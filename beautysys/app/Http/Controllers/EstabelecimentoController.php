<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;
use App\Models\Servico;
use App\Models\ResetSenha; 
use App\Models\LogsToken; 
use App\Models\ConfirmacaoEmail; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Rules\validaCNPJ;
use App\Rules\validaCelular;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetSenhaEmail;
use App\Mail\ConfirmaEmail;

class EstabelecimentoController extends Controller
{
    // Função para salvar o estabelecimento no banco de dados
    public function cadastrarEstabelecimento(Request $request)
    {
        // Valida os dados enviados pelo modal presente na view
        $validatedData = $request->validate([
            'razao_social' => 'required|string|max:40',
            'nome_fantasia' => 'required|string|max:40',
            'telefoneEstab' => ['required', new validaCelular],
            'cnpj' => ['required', new validaCNPJ],
            'logradouro' => 'required|string|max:40',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:40',
            'cidade' => 'required|string|max:40',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9',
            'inicio_expediente' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'termino_expediente' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'emailCadasProp' => 'required|string|email|max:100|unique:estabelecimentos,email',
            'senhaCadasProp' => 'required|string|min:8',
        ]);

        try {
            // Chama o método para criar o estabelecimento no model
            $estabelecimento = Estabelecimento::cadastrarEstabelecimento($validatedData);

            $token = Str::random(60);

            // Inserir o token no banco de dados para esse email
            ConfirmacaoEmail::create([
                'email' => $estabelecimento->email,
                'token' => $token,
                'created_at' => now(),
                'id_usuario' => $estabelecimento->id_estabelecimento,
                'tipo_usuario' => 'estabelecimento',
            ]);

            // Envia o e-mail de confirmação
            Mail::to($validatedData['emailCadasProp'])->send(new ConfirmaEmail($token, $validatedData['emailCadasProp'], 'estabelecimento'));
    
            // Redireciona para a página index com uma mensagem de sucesso
            return redirect()->route('Parceiro')->with('success', 'Estabelecimento cadastrado com sucesso!');
        } catch (\Throwable $th) {
            // Se ocorrer um erro, redireciona com uma mensagem de erro
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o estabelecimento. Tente novamente.');
        }
    }

    public function esqueceuSenhaEstabelecimento(Request $request)
    {
        // Corrigido para corresponder ao campo correto
        $email = $request->input('emailResetSenhaEstab'); 
    
        // Buscar o cliente pelo email no banco de dados
        $estabelecimento = Estabelecimento::where('email', $email)->first();
    
        // Verificar se o cliente foi encontrado
        if ($estabelecimento) {
            // Gerar um token para redefinição de senha
            $token = Str::random(60);
            
            // Inserir o token no banco de dados para esse email
            ResetSenha::create([
                'email' => $estabelecimento->email,
                'token' => $token,
                'created_at' => now(),
                'id_usuario' => $estabelecimento->id_estabelecimento,
                'tipo_usuario' => 'estabelecimento',
            ]);
    
            // Enviar o email de redefinição de senha
            Mail::to($estabelecimento->email)->send(new ResetSenhaEmail($estabelecimento, $token, 'estabelecimento'));
    
            return redirect()->back()->with('status', 'Email de redefinição de senha enviado!');
        } else {
            return redirect()->back()->with('error', 'Email não encontrado');
        }
    }

    public function resetSenhaEstabelecimento(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if (!$email || !$token) {
            return redirect()->route('Index')->with('error', 'Acesso inválido.');
        }
    
        $resetRecord = ResetSenha::where('email', $email)->where('token', $token)->where('tipo_usuario','estabelecimento')->first();
    
        if (!$resetRecord) {
            return redirect()->route('Index')->with('error', 'Link de redefinição de senha inválido ou expirado.');
        }
    
        $estabelecimento = Estabelecimento::where('email', $email);

        $expireTime = config('auth.passwords.estabelecimentos.expire');
        if (now()->diffInMinutes($resetRecord->created_at) > $expireTime) {
            LogsToken::create([
                'email' => $resetRecord->email,
                'token' => $resetRecord->token,
                'created_at' => $resetRecord->created_at,
                'used_at' => now(),
                'motivo' => 'redefinição de senha',
                'id_usuario' => $estabelecimento->id_estabelecimento,
                'tipo_usuario' => 'estabelecimento',
            ]);
    
            ResetSenha::where('email', $email)->where('tipo_usuario','estabelecimento')->delete();
    
            return redirect()->route('Index')->with('error', 'O link de redefinição de senha expirou.');
        }
    
        session(['email' => $email, 'token' => $token]);
    
        return view('nova-senhaEstab', compact('token', 'email'));
    }

    public function definirNovaSenhaEstabelecimento(Request $request)
    {
        // Valida a entrada
        $request->validate([
            'new_password' => 'required|min:8', // Adicione outras regras de validação conforme necessário
        ]);

        /// Obtém o email da sessão
        $email = session('email');

        // Verifique se o token é válido e se o email existe na tabela resets_senha_clientes
        $resetRecord = ResetSenha::where('email', $email)->where('tipo_usuario','estabelecimento')->first();
    
        if (!$resetRecord) {
            return redirect()->route('Index')->with('error', 'Link de redefinição de senha inválido ou expirado.');
        }else {

            // Busca o cliente pelo ID
            $estabelecimento = Estabelecimento::where('email', $email)->first();

            LogsToken::create([
                'email' => $resetRecord->email,
                'token' => $resetRecord->token,
                'created_at' => $resetRecord->created_at,
                'used_at' => now(), // Para registrar quando o link foi usado
                'motivo' => 'redefinição de senha',
                'id_usuario' => $estabelecimento->id_estabelecimento,
                'tipo_usuario' => 'estabelecimento',
            ]);

            ResetSenha::where('email', $email)->where('tipo_usuario','estabelecimento')->delete();
            
            // Atualiza a senha
            $estabelecimento->senha = Hash::make($request->input('new_password'));
            $estabelecimento->save();
            
            return redirect()->route('Index')->with('success', 'Senha redefinida com sucesso');
        }
    }

    // Método de login
    public function loginEstab(Request $request) 
    {
        // Validação dos campos de entrada
        $validatedData = $request->validate([
            'emailLoginProp' => 'required|string|email|max:255',
            'senhaLoginProp' => 'required|string|min:8',
        ]);

        $email_verificado = Estabelecimento::where('email', $validatedData['emailLoginProp'])->where('email_verificado', 1)->first();
            
        // Tentar autenticar o estabelecimento usando o guard 'estabelecimento'
        if (Auth::guard('estabelecimento')->attempt(['email' => $request->input('emailLoginProp'), 'password' => $request->input('senhaLoginProp')])) {
            if($email_verificado){
                // Login bem-sucedido, redirecionar para a página inicial do profissional
                return redirect()->route('paginaInicialPj')->with('success', 'Login realizado com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Email não verificado!');
            }
         } else {
            // Login falhou, redirecionar de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'Email ou senha inválidos');
        }
        
    }

    // Método de logout
    public function logoutEstab(Request $request)
    {
        // Realiza o logout
        Auth::guard('estabelecimento')->logout();

        // Verifica se o estabelecimento ainda está autenticado após o logout
        $isAuthenticated = Auth::guard('estabelecimento')->check();

        // Log para depuração
        Log::info('Estabelecimento realizou logout. Sessão autenticada: ' . ($isAuthenticated ? 'Sim' : 'Não'));

        // Opcional: Exibir mensagem na tela também
        if ($isAuthenticated) {
            return redirect()->route('Index')->with('error', 'Erro ao encerrar a sessão.');
        }

        return redirect()->route('Index')->with('success', 'Logout realizado com sucesso!');
    }

    public function buscarEstabelecimento(Request $request)
    {
        // Captura o id do estabelecimento autenticado usando Auth
        $id_estabelecimento = Auth::guard('estabelecimento')->id();
   
        // Obtém o registro do estabelecimento
        $registro = Estabelecimento::find($id_estabelecimento);
   
        // Verifica se o registro foi encontrado
        if (!$registro) {
            return redirect()->route('Parceiro')->with('error', 'Estabelecimento não encontrado.');
        }
   
        // Retorna a view com o registro
        return view('info-cadEstab', compact('registro'));
    }

    public function alterarCadastro(Request $request)
    {
        $id_estabelecimento = Auth::guard('estabelecimento')->id();

        $request->validate([
            'nome_fantasia' => 'required|string|max:40',
            'telefone' => ['required', new validaCelular],
            'logradouro' => 'required|string|max:40',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:40',
            'cidade' => 'required|string|max:40',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9',
            'inicio_expediente' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'termino_expediente' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'email' => ['required', 'email', 'max:100', 'unique:estabelecimentos,email,' . $id_estabelecimento . ',id_estabelecimento',],
        ]);

        // Captura o id do estabelecimento da sessão
        $nome_fantasia = $request->input('nome_fantasia');
        $telefone = $request->input('telefone');
        $logradouro = $request->input('logradouro');
        $numero = $request->input('numero');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $estado = $request->input('estado');
        $cep = $request->input('cep');
        $inicio_expediente = $request->input('inicio_expediente');
        $termino_expediente = $request->input('termino_expediente');
        $email = $request->input('email');

        Estabelecimento::atualizar_estabelecimento($id_estabelecimento, $nome_fantasia, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $cep, $inicio_expediente, $termino_expediente, $email);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function listaServicos() 
    {
        // Captura o id do estabelecimento autenticado usando Auth
        $id_estabelecimento = Auth::guard('estabelecimento')->id();
   
        // Obtém o registro do estabelecimento
        $servicos = Servico::where('id_estabelecimento', $id_estabelecimento)->get();
        $categorias = DB::table('categorias_servico')->get();
   
        // Retorna a view com o registro
        return view('servicos-cad', compact('servicos', 'categorias'));
    }   

    public function cadastrarServico(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'required|string|max:30',
            'valor' => 'required|numeric|min:0.01',
            'duracao' => ['required', 'string', 'not_in:00:00'],
            'id_categoria' => 'required|integer',
        ], [
            'nome.required' => 'O nome do serviço é obrigatório.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'duracao.not_in' => 'A duração não pode ser zero.',
            'id_categoria.required' => 'A categoria é obrigatória.',
        ]);
        
        
        
        // Captura o id do estabelecimento autenticado usando Auth
        $id_estabelecimento = Auth::guard('estabelecimento')->id();
    
        // Chamada do método do modelo para cadastrar o serviço
        Servico::cadastrarServico(
            $request->nome,
            $request->valor,
            $request->duracao,
            $request->id_categoria,
            $id_estabelecimento
        );
    
        // Redirecionar ou retornar uma resposta
        return redirect()->back()->with('success', 'Serviço cadastrado com sucesso!');
    }

    // Método para deletar serviço
    public function deletarServico($id)
    {
        // Lógica para encontrar o serviço pelo ID
        $servico = DB::table('servicos')->where('id_servico', $id)->first();

        if ($servico) {
            // Verifica se há agendamentos associados ao serviço
            $hasAgendamentos = DB::table('agendamentos')->where('id_servico', $id)->exists();

            if ($hasAgendamentos) {
                return back()->with('error', 'Não é possível deletar o serviço, pois ele está associado a agendamentos.');
            }

            try {
                DB::table('servicos')->where('id_servico', $id)->delete();
                return redirect()->route('listaServicos')->with('success', 'Serviço deletado com sucesso.');
            } catch (\QueryException $e) {
                return back()->with('error', 'Não é possível deletar o serviço, pois ele está associado a um profissional.');
            }
        }

        return redirect()->route('listaServicos')->with('error', 'Serviço não encontrado.');
    }

    public function exibirAgendamentosEstab()
    {
        // Captura o id do estabelecimento autenticado usando Auth
        $id_estabelecimento = Auth::guard('estabelecimento')->id();

        // Chama a procedure armazenada e passa o id do estabelecimento
        $agendamentos = DB::select('CALL exibir_agendamentos_estabelecimento(?)', [$id_estabelecimento]);

        // Retorna a view com os agendamentos
        return view('agendamentos-estab', compact('agendamentos'));
    }

    public function dashboardEstab()
    {
        // Captura o id do estabelecimento autenticado usando Auth
        $id_estabelecimento = Auth::guard('estabelecimento')->id();
    
        // Executa os procedimentos armazenados e captura os resultados
        $profissionais = DB::select('CALL exibir_profissionais_vinculados(?)', [$id_estabelecimento]);
        $clientes = DB::select('CALL clientes_por_estabelecimento(?)', [$id_estabelecimento]);
        $servicos = DB::select('CALL exibir_servicos_estabelecimento(?)', [$id_estabelecimento]);
        $agendamentos = DB::select('CALL exibir_agendamentos_estabelecimento(?)', [$id_estabelecimento]);
        $agendamentos_mes = DB::select('CALL contagem_agendamentos(?)', [$id_estabelecimento]);
        $servicos_populares = DB::select('CALL exibir_servicos_mais_populares_por_estabelecimento(?)', [$id_estabelecimento]);
        $profissionais_populares = DB::select('CALL profissionais_populares(?)', [$id_estabelecimento]);
        $horarios_pico = DB::select('CALL horarios_pico(?)', [$id_estabelecimento]);
    
        // Cria um objeto ou array simplificado contendo os totais
        $data = [
            'total_profissionais' => $profissionais[0]->total_profissionais ?? 0,
            'total_clientes' => $clientes[0]->total_clientes ?? 0,
            'total_servicos' => $servicos[0]->total_servicos ?? 0,
            'total_agendamentos' => $agendamentos[0]->total_agendamentos ?? 0,
            'agendamentos_por_mes' => $agendamentos_mes, // Armazena a contagem mensal
            'servicos_populares' => $servicos_populares,
            'profissionais_populares' => $profissionais_populares,
            'horarios_pico' => $horarios_pico,
        ];
    
        // Retorna a view com os dados simplificados
        return view('dashboard-pj', compact('data'));
    }
    
    public function exibirVinculosEstab() 
    {
        // Captura o id do estabelecimento autenticado usando Auth
        $id_estabelecimento = Auth::guard('estabelecimento')->id();
    
        // Chama a procedure armazenada e passa o id do estabelecimento
        $vinculos = DB::select('CALL exibir_profissionais_vinculados(?)', [$id_estabelecimento]);
    
        // Opções de status fixas conforme o ENUM da tabela
        $statusOptions = ['pendente', 'aprovado', 'rejeitado'];
    
        // Retorna a view com os vínculos e as opções de status
        return view('vinculo-estab', compact('vinculos', 'statusOptions'));
    }

    public function atualizarStatusVinculo(Request $request) 
    {
        $status = $request->input('status_vinculo'); // Recebe o novo status diretamente do ENUM
        $id_vinculo = $request->input('id_vinculo');
    
        // Atualiza o status do vínculo no banco de dados
        $updated = DB::table('vinculos')
            ->where('id_vinculo', $id_vinculo)
            ->update(['status_vinculo' => $status]);
    
        if ($updated) {
            return redirect()->back()->with('success', 'Status atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar o status.');
        }
    }

    public function uploadImagemPerfil(Request $request)
    {
        // Validação da imagem
        $request->validate([
            'imagem_perfil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Verifica se o arquivo foi enviado
        if ($request->hasFile('imagem_perfil')) {
            // Recupera o usuário autenticado
            $user = auth()->user();

            // Se o usuário já possui uma imagem de perfil, exclui a imagem antiga
            if ($user->imagem_perfil) {
                $oldImagePath = storage_path('app/public/imagem_perfil/' . $user->imagem_perfil);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Salva a nova imagem diretamente em public/imagem_perfil e obtém o nome do arquivo
            $imageName = time() . '_' . $request->file('imagem_perfil')->getClientOriginalName();
            $request->file('imagem_perfil')->move(public_path('imagem_perfil'), $imageName);

            // Salva o nome do arquivo da nova imagem no banco de dados
            $user->update(['imagem_perfil' => $imageName]);

            return back()->with('success', 'Foto de perfil atualizada!');
        }

        return back()->with('error', 'Erro ao fazer upload da foto de perfil.');
    }
}    
?>