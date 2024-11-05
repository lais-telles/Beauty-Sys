<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissional;  // Importe o modelo Profissional
use App\Models\Estabelecimento;  // Importe o modelo Estabelecimento
use App\Models\Vinculo;  // Importe o modelo Vinculo
use App\Models\Agendamento;  // Importe o modelo Agendamento
use App\Models\Servico;  // Importe o modelo Servico
use App\Models\Formas_pagamento;  // Importe o modelo Formas_pagamento
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha
use Illuminate\Support\Facades\DB; // Para consultas ao banco de dados
use Illuminate\Support\Facades\Session; // Para armazenar sessão
use App\Models\Grade;  // Importe o modelo Grade
use App\Rules\validaCPF;
use App\Rules\validaData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetSenhaEmail;

class ProfissionalController extends Controller
{
    // Função para salvar o cliente no banco de dados
    public function cadastrarProfissional(Request $request)
    {
        // Valida os dados enviados pelo modal
        $validatedData = $request->validate([
            'nome' => 'required|string|max:50',
            'data_nascimento' => ['required', new validaData],
            'cpf' => ['required', new validaCPF],
            'telefone' => ['required', new validaCelular],
            'emailCadasProf' => 'required|string|email|max:255|unique:profissionais,email',
            'senhaCadasProf' => 'required|string|min:8',
        ]);

        try {
            // Chama o método para criar o profissional no model
            Profissional::cadastrarProfissional($validatedData);

            // Redireciona para a página index com uma mensagem de sucesso
            return redirect()->route('Parceiro')->with('success', 'Profissional cadastrado com sucesso!');
        } catch (\Exception $e) {
            // Se ocorrer um erro, redireciona com uma mensagem de erro
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o profissional. Tente novamente.');
        }

    }

    public function esqueceuSenhaProfissional(Request $request)
    {
        // Corrigido para corresponder ao campo correto
        $email = $request->input('emailResetSenhaProf'); 
    
        // Buscar o cliente pelo email no banco de dados
        $profissional = DB::table('profissionais')->where('email', $email)->first();
    
        // Verificar se o cliente foi encontrado
        if ($profissional) {
            // Gerar um token para redefinição de senha
            $token = Str::random(60);
            
            // Inserir o token no banco de dados para esse email
            DB::table('resets_senha_profissionais')->insert([
                'email' => $profissional->email,
                'token' => $token,
                'created_at' => now(),
            ]);
    
            // Enviar o email de redefinição de senha
            Mail::to($profissional->email)->send(new ResetSenhaEmail($profissional, $token, 'profissional'));
    
            return redirect()->back()->with('status', 'Email de redefinição de senha enviado!');
        } else {
            return redirect()->back()->with('error', 'Email não encontrado');
        }
    }
    

    public function resetSenhaProfissional(Request $request) {
        $email = $request->query('email');
        $token = $request->query('token');

        if (!$email || !$token) {
            return redirect()->route('Index')->with('error', 'Acesso inválido.');
        }
    
        $resetRecord = DB::table('resets_senha_profissionais')->where('email', $email)->where('token', $token)->first();
    
        if (!$resetRecord) {
            return redirect()->route('Index')->with('error', 'Link de redefinição de senha inválido ou expirado.');
        }
    
        $expireTime = config('auth.passwords.profissionais.expire');
        if (now()->diffInMinutes($resetRecord->created_at) > $expireTime) {
            DB::table('logs_tokens')->insert([
                'email' => $resetRecord->email,
                'token' => $resetRecord->token,
                'created_at' => $resetRecord->created_at,
                'used_at' => now(),
            ]);
    
            DB::table('resets_senha_profissionais')->where('email', $email)->delete();
    
            return redirect()->route('Index')->with('error', 'O link de redefinição de senha expirou.');
        }
    
        session(['email' => $email, 'token' => $token]);
    
        return view('nova-senhaProf', compact('token', 'email'));
    }
        
    

    public function definirNovaSenhaProfissional(Request $request){
        // Valida a entrada
        $request->validate([
            'new_password' => 'required|min:8', // Adicione outras regras de validação conforme necessário
        ]);

        /// Obtém o email da sessão
        $email = session('email');

        // Verifique se o token é válido e se o email existe na tabela resets_senha_clientes
        $resetRecord = DB::table('resets_senha_profissionais')->where('email', $email)->first();
    
        if (!$resetRecord) {
            return redirect()->route('Index')->with('error', 'Link de redefinição de senha inválido ou expirado.');
        }else {

            // Busca o cliente pelo ID
            $profissional = Profissional::where('email', $email)->first();

            DB::table('logs_tokens')->insert([
                'email' => $resetRecord->email,
                'token' => $resetRecord->token,
                'created_at' => $resetRecord->created_at,
                'used_at' => now(), // Para registrar quando o link foi usado
            ]);

            DB::table('resets_senha_profissionais')->where('email', $email)->delete();
            
            // Atualiza a senha
            $profissional->senha = Hash::make($request->input('new_password'));
            $profissional->save();
            
            return redirect()->route('Index')->with('success', 'Senha redefinida com sucesso');
        }
    }

    // Método de login
    public function loginProfissional (Request $request)
    {
        // Validação dos campos de entrada
        $validatedData = $request->validate([
            'emailLoginProf' => 'required|string|email|max:255',
            'senhaLoginProf' => 'required|string|min:8',
        ]);

        // Tentar autenticar o profissional usando o guard 'profissional'
        if (Auth::guard('profissional')->attempt(['email' => $request->input('emailLoginProf'), 'password' => $request->input('senhaLoginProf')])) {
            // Login bem-sucedido, redirecionar para a página inicial do profissional
            return redirect()->route('PaginaInicialProfissional')->with('success', 'Login realizado com sucesso!');
        } else {
            // Login falhou, redirecionar de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'Email ou senha inválidos');
        }
    }

    // Método de logout
    public function logoutProfissional(Request $request)
    {
        // Realiza o logout
        Auth::guard('profissional')->logout();

        // Verifica se o profissional ainda está autenticado após o logout
        $isAuthenticated = Auth::guard('profissional')->check();

        // Log para depuração
        Log::info('Profissional realizou logout. Sessão autenticada: ' . ($isAuthenticated ? 'Sim' : 'Não'));

        // Opcional: Exibir mensagem na tela também
        if ($isAuthenticated) {
            return redirect()->route('Index')->with('error', 'Erro ao encerrar a sessão.');
        }

        return redirect()->route('Index')->with('success', 'Logout realizado com sucesso!');
    }

    // Método de exibição da grade horária
    public function gradeProf() {
        // Captura o id do profissional autenticado usando Auth
        $idProfissional = Auth::guard('profissional')->id();

        // Obter o ID do estabelecimento vinculado ao profissional
        $idEstabelecimento = DB::table('profissionais')
            ->where('id_profissional', $idProfissional)
            ->value('estabel_vinculado');
    
        if (!$idEstabelecimento) {
            // Definindo os horários de um profissional sem vínculo
            $horaAbertura = "08:00:00";
            $horaFechamento = "19:00:00";
        } else {
            // Buscar os horários de funcionamento do estabelecimento
            $estabelecimento = DB::table('estabelecimentos')
                ->where('id_estabelecimento', $idEstabelecimento)
                ->first(['inicio_expediente', 'termino_expediente']);
        
            if (!$estabelecimento) {
                return redirect()->back()->with('error', 'Horários de funcionamento do estabelecimento não encontrados.');
            }
            // Definindo os horários de acordo com o estabelecimento
            $horaAbertura = $estabelecimento->inicio_expediente; 
            $horaFechamento = $estabelecimento->termino_expediente; 
        }

        // Gerar lista de horários
        $select_horario = [];
        $intervalo = new \DateInterval('PT30M'); // Intervalo de 30 minutos
        $periodo = new \DatePeriod(new \DateTime($horaAbertura), $intervalo, new \DateTime($horaFechamento));
    
        foreach ($periodo as $hora) {
            $select_horario[] = $hora->format('H:i');
        }

        // Adiciona manualmente o horário de fechamento, caso não esteja na lista
        if (end($select_horario) !== $horaFechamento) {
            $select_horario[] = (new \DateTime($horaFechamento))->format('H:i');
        }
    
        // Chama o stored procedure passando o ID do profissional
        $horarios = DB::select('CALL consulta_grade_horaria(?)', [$idProfissional]);
    
        // Retorna a view 'grade-profissional' com os dados da grade e a lista de horários
        return view('grade-profissional', [
            'horarios' => $horarios,
            'select_horario' => $select_horario
        ]);
    }

    // Método para deletar horário
    public function deletarHorario($id)
    {
        // Lógica para encontrar e deletar o horário pelo ID
        $horario = DB::table('grades_horario')->where('id_grade', $id)->first();

        if ($horario) {
            DB::table('grades_horario')->where('id_grade', $id)->delete();
            return redirect()->route('gradeProf')->with('success', 'Horário deletado com sucesso.');
        }

        return redirect()->route('gradeProf')->with('error', 'Horário não encontrado.');
    }

    public function salvarGrade(Request $request) {
        // Valida os dados enviados pelo modal
        $validatedData = $request->validate([
            'dia_semana' => 'required|string|max:10',
            'hora_inicio' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'hora_termino' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
        ]);
        
        // Captura o id do profissional autenticado usando Auth
        $id = Auth::guard('profissional')->id();

        // Verifica se já existe uma grade cadastrada para o mesmo dia da semana
        $gradeExistente = Grade::where('id_profissional', $id)
        ->where('dia_semana', $validatedData['dia_semana'])->first();

        if ($gradeExistente) {
            return redirect()->route('gradeProf')->with('error', 'Já existe um horário cadastrado para este dia da semana.');
        }
        
        // Cria a grade
        Grade::create([
            'id_profissional' => $id,
            'dia_semana' => $validatedData['dia_semana'],
            'hora_inicio' => $validatedData['hora_inicio'],
            'hora_termino' => $validatedData['hora_termino']
        ]);

        return redirect()->route('gradeProf')->with('success', 'Grade cadastrada com sucesso!');
    }

    // Método para ir para a página de adm
    public function admProf(Request $request) {
        // Recupera o nome do profissional
        $nome = Session::get('nome');
        
        return view('adm-profissional', ['nome' => $nome]);
    }

    // Método para buscar profissional
    public function buscarProfissional(Request $request){
        // Captura o id do profissional autenticado usando Auth
        $id_profissional = Auth::guard('profissional')->id();
   
        // Obtém o registro do estabelecimento
        $registro = Profissional::find($id_profissional);
   
        // Verifica se o registro foi encontrado
        if (!$registro) {
            return redirect()->route('admProf')->with('error', 'Profissional não encontrado.');
        }
   
        // Retorna a view com o registro
        return view('info-cadProf', compact('registro'));
    }

    // Método para salvar alterações
    public function alterarCadastro(Request $request) {
        // Captura o id do profissional autenticado usando Auth
        $id_profissional = Auth::guard('profissional')->id();
        $telefone = $request->input('telefone');
        $email = $request->input('email');

        Profissional::atualizarProfissional($id_profissional, $telefone, $email);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function exibirAgendamentosProf() {
        // Captura o id do profissional autenticado usando Auth
        $id_profissional = Auth::guard('profissional')->id();

        // Buscando todos os status disponíveis no banco de dados
        $statusAgendamentos = DB::table('status_agendamentos')->get();

        // Chama a procedure armazenada e passa o id do profissional
        $agendamentos = DB::select('CALL exibir_agendamentos_profissional(?)', [$id_profissional]);

        // Obtém os serviços disponíveis
        $servicos = DB::select('CALL exibir_servicos_profissional(?)', [$id_profissional]);
        $servicos = $this->servicosDisponiveis($id_profissional);

        // Retorna a view com os agendamentos e serviços
        return view('agendamentos-prof', compact('agendamentos', 'statusAgendamentos', 'servicos'));
    }

    // Função separada para obter serviços disponíveis
    private function servicosDisponiveis($id_profissional) {
        // Obtém os serviços disponíveis
        return DB::select('CALL exibir_servicos_profissional(?)', [$id_profissional]);
    }

    public function atualizarStatusAgendamentos(Request $request) {
        $statusDescricao = $request->input('status'); // 'Ausência' ou outro status descritivo
        $id_agendamento = $request->input('id_agendamento');

        // Busca o ID do status correspondente
        $status = DB::table('status_agendamentos')->where('descricao', $statusDescricao)->first();

        if ($status) {
            Agendamento::atualizarStatus($id_agendamento, $status->id_status); // Usa o ID encontrado
            return redirect()->back()->with('success', 'Status atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Status inválido.');
        }
    }

    // Método de exibição do vinculo
    public function vinculoProf()
    {
        // Captura o id do profissional autenticado usando Auth
        $idProfissional = Auth::guard('profissional')->id();

        // Chama o stored procedure passando o ID do profissional
        $vinculo = DB::select('CALL consulta_vinculo(?)', [$idProfissional]);

        // Obtém a lista de estabelecimentos para o dropdown
        $estabelecimentos = Estabelecimento::all();

        return view('vinculo-prof', ['vinculo' => $vinculo, 'estabelecimentos' => $estabelecimentos]);
    }

    public function solicitarVinculo(Request $request)
    {
        // Captura o id do profissional autenticado usando Auth
        $idProfissional = Auth::guard('profissional')->id();
        $id_estabelecimento = $request->input('id_estabelecimento');

        try {
            DB::statement('CALL inserir_vinculo(?, ?)', [$id_estabelecimento, $idProfissional]);
            return back()->with('success', 'Solicitação de vínculo enviada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function servicosProf(){
        // Captura o id do profissional autenticado usando Auth
        $idProfissional = Auth::guard('profissional')->id();

        // Recupera o ID do estabelecimento vinculado armazenado na sessão
        $idEstab = DB::table('profissionais')
                ->where('id_profissional', $idProfissional)
                ->value('estabel_vinculado');

        // Chama o stored procedure passando o ID do profissional
        $servicos = DB::select('CALL exibir_servicos_profissional(?)', [$idProfissional]);

        // Obtém a lista de serviços para o dropdown
        $lista = DB::select('CALL exibir_servicos_estabelecimento(?)', [$idEstab]);

        return view('servicos-prof', ['servicos' => $servicos, 'lista' => $lista]);
    }

    public function associarServ(Request $request)
    {
        // Captura o id do profissional autenticado usando Auth
        $idProfissional = Auth::guard('profissional')->id();
        $id_servico = $request->input('id_servico');

        try {
            DB::statement('CALL vincular_servico_profissional(?, ?)', [$idProfissional, $id_servico]);
            return back()->with('success', 'Associação de serviço realizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
?>