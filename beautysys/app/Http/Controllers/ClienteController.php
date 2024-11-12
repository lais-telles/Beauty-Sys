<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Estabelecimento;
use App\Models\Profissional;
use App\Models\ResetSenha;
use App\Models\LogsToken;
use App\Models\ConfirmacaoEmail;
use App\Rules\validaCPF;
use App\Rules\validaCelular;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetSenhaEmail;
use App\Mail\ConfirmaEmail;

class ClienteController extends Controller
{
    // Função para salvar o cliente no banco de dados
    public function cadastrarCliente(Request $request)
    {
        // Valida os dados enviados pelo modal
        $validatedData = $request->validate([
            'nome' => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'cpf' => ['required', new validaCPF],
            'telefone' => ['required', new validaCelular],
            'email' => 'required|string|email|max:255|unique:clientes',
            'senha' => 'required|string|min:8',
        ]);

        
        try {
            // Chama o método para criar o cliente no model
            $cliente = Cliente::cadastrarCliente($validatedData);

            $token = Str::random(60);

            // Inserir o token no banco de dados para esse email
            ConfirmacaoEmail::create([
                'email' => $cliente->email,
                'token' => $token,
                'created_at' => now(),
                'id_usuario' => $cliente->id_cliente,
                'tipo_usuario' => 'cliente',
            ]);

            // Envia o e-mail de confirmação
            Mail::to($validatedData['email'])->send(new ConfirmaEmail($token, $validatedData['email'], 'cliente'));

            // Redireciona para a página com uma mensagem de sucesso
            return redirect()->route('PessoaFisica')->with('success', 'Cliente cadastrado com sucesso. Por favor, verifique seu e-mail!');
        } catch (\Exception $e) {
            // Se ocorrer um erro, redireciona com uma mensagem de erro
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o cliente. Tente novamente.');
        }
    }

    // Função para enviar o e-mail de redefinição de senha
    public function esqueceuSenhaCliente(Request $request)
    {
        $email = $request->input('emailResetSenha'); 
    
        // Buscar o cliente pelo email no banco de dados
        $cliente = Cliente::where('email', $email)->first();
    
        // Verificar se o cliente foi encontrado
        if ($cliente) {
            // Gerar um token para redefinição de senha
            $token = Str::random(60);
            
            // Inserir o token no banco de dados para esse email
            ResetSenha::create([
                'email' => $cliente->email,
                'token' => $token,
                'created_at' => now(),
                'id_usuario' => $cliente->id_cliente,
                'tipo_usuario' => 'cliente',
            ]);
    
            // Enviar o email de redefinição de senha
            Mail::to($cliente->email)->send(new ResetSenhaEmail($cliente, $token, 'cliente'));
    
            return redirect()->back()->with('status', 'Email de redefinição de senha enviado!');
        } else {
            return redirect()->back()->with('error', 'Email não encontrado');
        }
    }
    
    // Função para retornar a tela para definição de uma nova senha
    public function resetSenhaCliente(Request $request) 
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if (!$email || !$token) {
            return redirect()->route('Index')->with('error', 'Acesso inválido.');
        }
    
        $resetRecord = ResetSenha::where('email', $email)->where('token', $token)->where('tipo_usuario','cliente')->first();
    
        if (!$resetRecord) {
            return redirect()->route('Index')->with('error', 'Link de redefinição de senha inválido ou expirado.');
        }
    
        // Busca o cliente pelo ID
        $cliente = Cliente::where('email', $email)->first();

        $expireTime = config('auth.passwords.clientes.expire');
        if (now()->diffInMinutes($resetRecord->created_at) > $expireTime) {
            LogsToken::create([
                'email' => $resetRecord->email,
                'token' => $resetRecord->token,
                'created_at' => $resetRecord->created_at,
                'used_at' => now(),
                'motivo' => 'redefinição de senha',
                'id_usuario' => $cliente->id_cliente,
                'tipo_usuario' => 'cliente',
            ]);
    
            ResetSenha::where('email', $email)->where('tipo_usuario','cliente')->delete();
    
            return redirect()->route('Index')->with('error', 'O link de redefinição de senha expirou.');
        }
    
        session(['email' => $email, 'token' => $token]);
    
        return view('nova-senhaCliente', compact('token', 'email'));
    }

    // Função para o processamento e inserção da nova senha na tabela clientes
    public function definirNovaSenhaCliente(Request $request)
    {
        // Valida a entrada
        $request->validate([
            'new_password' => 'required|min:8', 
        ]);

        /// Obtém o email da sessão
        $email = session('email');

        // Verifica se o token é válido e se o email existe na tabela resets_senhas
        $resetRecord = ResetSenha::where('email', $email)->where('tipo_usuario','cliente')->first();
    
        if (!$resetRecord) {
            return redirect()->route('Index')->with('error', 'Link de redefinição de senha inválido ou expirado.');
        }else {

            // Busca o cliente pelo email
            $cliente = Cliente::where('email', $email)->first();

            LogsToken::create([
                'email' => $resetRecord->email,
                'token' => $resetRecord->token,
                'created_at' => $resetRecord->created_at,
                'used_at' => now(),
                'motivo' => 'Redefinição de senha',
                'id_usuario' => $cliente->id_cliente,
                'tipo_usuario' => 'cliente',
            ]);

            ResetSenha::where('email', $email)->where('tipo_usuario','cliente')->delete();
            
            // Atualiza a senha
            $cliente->senha = Hash::make($request->input('new_password'));
            $cliente->save();
            
            return redirect()->route('Index')->with('success', 'Senha redefinida com sucesso');
        }
    }

    // Método de login
    public function loginCliente(Request $request)
    {
        // Validação dos campos de entrada
        $validatedData = $request->validate([
            'emailLogin' => 'required|string|email|max:255',
            'senhaLogin' => 'required|string|min:8',
        ]);

        $email_verificado = Cliente::where('email', $validatedData['emailLogin'])->where('email_verificado', 1)->first();

        if($email_verificado){
            // Tentar autenticar o cliente usando o guard 'cliente'
            if (Auth::guard('cliente')->attempt(['email' => $request->input('emailLogin'), 'password' => $request->input('senhaLogin')])) {
                
                // Chama o método para obter dados e retornar a view com os estabelecimentos populares
                return $this->paginaInicialPf()->with('success', 'Login realizado com sucesso!');
            } else {
                // Login falhou, redirecionar de volta com uma mensagem de erro
                return redirect()->back()->with('error', 'Email ou senha inválidos');
            }
        } else {
            return redirect()->back()->with('error', 'Email não verificado!');
        }
    }

    public function paginaInicialPf()
    {
        $estabPopulares = DB::select("SELECT * FROM estabelecimentos_populares");
        $profPopulares = DB::select("SELECT * FROM profissionais_populares");

        // Retorna a view 'home-pf' com os dados dos estabelecimentos populares
        return view('home-pf', compact('estabPopulares', 'profPopulares'));
    }

    // Método de logout
    public function logoutCliente() 
    {
        // Realiza o logout
        Auth::guard('cliente')->logout();

        // Verifica se o cliente ainda está autenticado após o logout
        $isAuthenticated = Auth::guard('cliente')->check();

        // Log para depuração
        Log::info('Cliente realizou logout. Sessão autenticada: ' . ($isAuthenticated ? 'Sim' : 'Não'));

        // Opcional: Exibir mensagem na tela também
        if ($isAuthenticated) {
            return redirect()->route('Index')->with('error', 'Erro ao encerrar a sessão.');
        }

        return redirect()->route('Index')->with('success', 'Logout realizado com sucesso!');
    }

    // Método para exibir os agendamentos
    public function exibirAgendamentos()
    {
        // Captura o id do cliente autenticado usando Auth
        $id_cliente = Auth::guard('cliente')->id();

        // Chama a procedure armazenada e passa o id do cliente
        $agendamentos = DB::select('CALL exibir_agendamentos_cliente(?)', [$id_cliente]);

        // Retorna a view com os agendamentos
        return view('agendamentos-cliente', compact('agendamentos'));
    }

    // Método para ir para a página de adm
    public function admCliente() 
    {
        // Recupera o nome do cliente
        $nome = Session::get('nome');

        return view('adm-cliente', ['nome' => $nome]);
    }

    // Método para buscar cliente
    public function buscarCliente(Request $request)
    {
        // Captura o id do estabelecimento da sessão
        $id_cliente = Auth::guard('cliente')->id();
   
        // Obtém o registro do estabelecimento
        $registro = Cliente::find($id_cliente);
   
        // Verifica se o registro foi encontrado
        if (!$registro) {
            return redirect()->route('admCliente')->with('error', 'Profissional não encontrado.');
        }
   
        // Retorna a view com o registro
        return view('info-cadCli', compact('registro'));
    }

    // Método para salvar alterações
    public function alterarCadastro(Request $request) 
    {
        // Captura o id do cliente da sessão
        $id_cliente = Auth::guard('cliente')->id();
        $telefone = $request->input('telefone');
        $email = $request->input('email');

        Cliente::atualizarCliente($id_cliente, $telefone, $email);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function dadosRealizarAgendamento(Request $request) 
    {
        $id_profissional = $request->input('profissional', null);
        $id_estabelecimento = $request->input('estabelecimento', null);
    
        // Verifica se $id_estabelecimento está definido, se não estiver, busca todos os estabelecimentos
        if ($id_estabelecimento) {
            $estabelecimentos = Estabelecimento::where('id_estabelecimento', $id_estabelecimento)->get();
        } else {
            $estabelecimentos = Estabelecimento::all();
        }
    
        // Verifica se $id_profissional está definido
        if ($id_estabelecimento) {
            $profissional = DB::select('CALL exibir_profissionais_vinculados(?)', [$id_estabelecimento]);
        } else {
            $profissional = Profissional::all();
        }
    
        $servicos = DB::select('CALL exibir_servicos_profissional(?)', [$id_profissional]);
    
        // Retorna a view com os dados carregados
        return view('finaliza-agendamento', compact('estabelecimentos', 'profissional', 'id_estabelecimento', 'id_profissional', 'servicos'));
    }
    
    public function getProfissionais(Request $request) 
    {
        $id_estabelecimento = $request->input('id');
    
        // Verifica se o id_estabelecimento foi passado
        if (!$id_estabelecimento) {
            return response()->json(['error' => 'Estabelecimento não informado'], 400);
        }
    
        // Executa a procedure para obter os profissionais vinculados ao estabelecimento
        try {
            $profissionais = DB::select('CALL exibir_profissionais_vinculados(?)', [$id_estabelecimento]);
            return response()->json(['profissionais' => $profissionais], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao obter profissionais'], 500);
        }
    }
    
    public function getServicos(Request $request) 
    {
        $id_profissional = $request->input('id_profissional');
        $id_estabelecimento = $request->input('id_estabelecimento');
    
        // Verifica se os parâmetros foram passados
        if (!$id_profissional || !$id_estabelecimento) {
            return response()->json(['error' => 'Dados inválidos'], 400);
        }
    
        // Executa a procedure para obter os serviços do profissional
        try {
            $servicos = DB::select('CALL exibir_servicos_profissional(?)', [$id_profissional]);
            return response()->json(['servicos' => $servicos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao obter serviços'], 500);
        }
    }
    
    public function getHorarios(Request $request) 
    {
        $id_profissional = $request->input('id_profissional');
        $data_realizacao = $request->input('data_realizacao');
    
        // Verifica se ambos os parâmetros foram passados corretamente
        if (!$id_profissional || !$data_realizacao) {
            return response()->json(['error' => 'Dados inválidos'], 400);
        }
    
        // Chama a procedure para gerar os horários
        try {
            $horarios = DB::select('CALL gerar_horarios(?, ?)', [$id_profissional, $data_realizacao]);
            return response()->json(['horarios' => $horarios], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao obter horários'], 500);
        }
    }    
    
    public function realizarAgendamento(Request $request)
    {
        $id_cliente = auth()->guard('cliente')->id();
        $id_profissional = $request->input('profissional');
        $id_pag = $request->input('opcao_pag');
        $data_realizacao = $request->input('data_realizacao');
        $horario_inicio = $request->input('horario_inicio');
        $id_servico = $request->input('servico');

        DB::statement('CALL realizar_agendamento(?, ?, ?, ?, ?, ?)',[$id_cliente, $id_profissional, $id_pag, $data_realizacao, $horario_inicio, $id_servico]);

        return redirect()->back()->with('success', 'Agendamento realizado com sucesso!');
    }

    public function listaProfissionais() 
    {
        $profissionais = DB::select('
            SELECT p.id_profissional,
                    p.nome,
                    p.telefone,
                    p.email,
                    p.estabel_vinculado,
                    e.nome_fantasia
            FROM profissionais AS p
            JOIN estabelecimentos AS e ON p.estabel_vinculado = e.id_estabelecimento
            ORDER BY p.nome ASC
        ');

        return view('lista-profissionais', compact('profissionais'));
    }

    public function listaEstab() 
    {
        $estabelecimentos = DB::select('CALL listar_estab');
        
        return view('lista-estab', compact('estabelecimentos'));
    }

    public function listaEstabLogin()
    {
        $estabelecimentos = DB::select('CALL listar_estab');
        
        return view('lista-estab-login', compact('estabelecimentos'));
    }

    public function realizarPesquisa(Request $request) 
    {
        // Valida o input para garantir que termo_pesquisa não seja vazio
        $request->validate([
            'termo_pesquisa' => 'required|string|max:30',
        ]);
    
        // Recupera o termo de pesquisa do request
        $termo_pesquisa = $request->input('termo_pesquisa');
    
        try {
            // Chama o procedimento armazenado
            $resultado_pesquisa = DB::select('CALL realizar_pesquisa(?)', [$termo_pesquisa]);
            
            // Retorna a view com os resultados da pesquisa
            return view('resultado-pesquisa', compact('resultado_pesquisa'));
        } catch (\Exception $e) {
            // Lida com exceções, como erros de conexão ou execução do procedimento
            return back()->withErrors(['error' => 'Ocorreu um erro ao realizar a pesquisa.']);
        }
    }
}
?>