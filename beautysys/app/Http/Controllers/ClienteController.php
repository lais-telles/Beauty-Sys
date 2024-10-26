<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;  // Importe o modelo Cliente
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha
use Illuminate\Support\Facades\DB; // Para consultas ao banco de dados
use Illuminate\Support\Facades\Session; // Para armazenar sessão
use App\Models\Estabelecimento; // Certifique-se de importar o modelo
use App\Models\Profissional; // Certifique-se de importar o modelo
use App\Rules\validaCPF;
use App\Rules\validaCelular;

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
            Cliente::cadastrarCliente($validatedData);

            // Redireciona para a página com uma mensagem de sucesso
            return redirect()->route('PessoaFisica')->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Exception $e) {
            // Se ocorrer um erro, redireciona com uma mensagem de erro
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o cliente. Tente novamente.');
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

        // Recuperar o usuário do banco com base no e-mail
        $user = DB::table('clientes')->where('email', $request->input('emailLogin'))->first();

        // Comparar a senha fornecida com a senha armazenada
        if ($user && Hash::check($request->input('senhaLogin'), $user->senha)) {
            // Login bem-sucedido
            Session::put('id_cliente', $user->id_cliente);
            Session::put('nome', $user->nome);
            return view('home-pf')->with('success', 'Login realizado com sucesso!');
        } else {
            // Se falhar, redirecionar de volta com erro
            return redirect()->back()->with('error', 'Email ou senha inválidos');
        }
    }

    // Método de logout
    public function logoutCliente(Request $request)
    {
        // Limpa a sessão do cliente
        Session::flush();

        // Redireciona para a página de login (ou qualquer outra página)
        return view('index')->with('success', 'Logout realizado com sucesso!');
    }

    // Método para exibir os agendamentos
    public function exibirAgendamentos(){
        // Captura o id do cliente da sessão
        $id = Session::get('id_cliente');

        // Verifica se o id do cliente está presente na sessão
        if (!$id) {
            return redirect()->route('login')->with('error', 'É necessário estar logado para ver os agendamentos.');
        }

        // Chama a procedure armazenada e passa o id do estabelecimento
        $agendamentos = DB::select('CALL exibir_agendamentos_cliente(?)', [$id]);

        // Retorna a view com os agendamentos
        return view('agendamentos-cliente', compact('agendamentos'));
    }

    // Método para ir para a página de adm
    public function admCliente() {
        // Recupera o nome do cliente
        $nome = Session::get('nome');

        return view('adm-cliente', ['nome' => $nome]);
    }

    // Método para buscar cliente
    public function buscarCliente(Request $request){
        // Captura o id do estabelecimento da sessão
        $id_cliente = Session::get('id_cliente');
   
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
    public function alterarCadastro(Request $request) {
        // Captura o id do cliente da sessão
        $id_cliente = Session::get('id_cliente');
        $telefone = $request->input('telefone');
        $email = $request->input('email');

        Cliente::atualizarCliente($id_cliente, $telefone, $email);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function dadosRealizarAgendamento(Request $request) {
        $id_profissional = $request->input('profissional', null); // pode ser null se não for selecionado ainda
        $id_estabelecimento = $request->input('estabelecimento', null); // pode ser null se não for selecionado ainda
    
        // Verifica se $id_estabelecimento está definido, se não estiver, busca todos os estabelecimentos
        if ($id_estabelecimento) {
            $estabelecimentos = Estabelecimento::where('id_estabelecimento', $id_estabelecimento)->get();
        } else {
            $estabelecimentos = Estabelecimento::all();
        }
    
        // Verifica se $id_profissional está definido
        if ($id_estabelecimento) { // Aqui deve ser $id_estabelecimento, não $idEstabelecimento
            $profissional = Profissional::where('estabel_vinculado', $id_estabelecimento)->get(); // Corrigido
        } else {
            $profissional = Profissional::all();
        }
    
        $servicos = DB::select('CALL exibir_servicos_profissional(?)', [$id_profissional]);
    
        // Retorna a view com os dados carregados
        return view('finaliza-agendamento', compact('estabelecimentos', 'profissional', 'id_estabelecimento', 'id_profissional', 'servicos'));
    }
    
    
    public function getProfissionais(Request $request) {
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
    
    public function getServicos(Request $request) {
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
    
    public function getHorarios(Request $request) {
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
    
    public function realizarAgendamento(Request $request){
        $id_cliente = Session::get('id_cliente');
        $id_profissional = $request->input('profissional');
        $id_pag = $request->input('opcao_pag');
        $data_realizacao = $request->input('data_realizacao');
        $horario_inicio = $request->input('horario_inicio');
        $id_servico = $request->input('servico');

        DB::statement('CALL realizar_agendamento(?, ?, ?, ?, ?, ?)',[$id_cliente, $id_profissional, $id_pag, $data_realizacao, $horario_inicio, $id_servico]);

        return redirect()->back()->with('success', 'Agendamento realizado com sucesso!');
    }

    public function listaProfissionais() {
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

    public function listaEstab() {
        $estabelecimentos = DB::select('CALL listar_estab');
        
        return view('lista-estab', compact('estabelecimentos'));
    }

    public function listaEstabLogin(){
        $estabelecimentos = DB::select('CALL listar_estab');
        
        return view('lista-estab-login', compact('estabelecimentos'));
    }

    public function realizarPesquisa(Request $request) {
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