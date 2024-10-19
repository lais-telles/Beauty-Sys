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

class ProfissionalController extends Controller
{
    // Função para salvar o cliente no banco de dados
    public function cadastrarProfissional(Request $request)
    {
        // Valida os dados enviados pelo modal
        $validatedData = $request->validate([
            'nome' => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14',
            'telefone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:profissionais',
            'senha' => 'required|string|min:8',
        ]);

        // Chama o método para criar o profissional no model
        Profissional::cadastrarProfissional($validatedData);

        // Redireciona para a página index com uma mensagem de sucesso
        return redirect()->route('Parceiro')->with('success', 'Profissional cadastrado com sucesso!');
    }

    // Método de login
    public function loginProfissional (Request $request)
    {
        // Validação dos campos de entrada
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:8',
        ]);

        // Recuperar o usuário do banco com base no e-mail
        $user = DB::table('profissionais')->where('email', $request->input('email'))->first();

        // Comparar a senha fornecida com a senha armazenada
        if ($user && Hash::check($request->input('senha'), $user->senha)) {
            // Login bem-sucedido
            Session::put('id_profissional', $user->id_profissional);
            Session::put('nome', $user->nome);
            return view('home-profissional');
        } else {
            // Se falhar, redirecionar de volta com erro
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
        }
    }

    // Método de logout
    public function logoutProfissional(Request $request)
    {
        // Limpa a sessão do cliente
        Session::flush();

        // Redireciona para a página de login (ou qualquer outra página)
        return view('index')->with('success', 'Logout realizado com sucesso!');
    }

    // Método de exibição da grade horária
    public function gradeProf() {
        // Recupera o ID do profissional armazenado na sessão
        $idProfissional = Session::get('id_profissional');
    
        // Verifica se o ID está presente
        if (!$idProfissional) {
            return redirect()->route('login')->with('error', 'Profissional não autenticado');
        }
    
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
        
        // Recupera o ID do profissional armazenado na sessão
        $id = Session::get('id_profissional');

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
        // Captura o id do estabelecimento da sessão
        $id_profissional = Session::get('id_profissional');
   
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
        // Captura o id do estabelecimento da sessão
        $id_profissional = Session::get('id_profissional');
        $telefone = $request->input('telefone');
        $email = $request->input('email');

        Profissional::atualizarProfissional($id_profissional, $telefone, $email);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function exibirAgendamentosProf() {
        // Captura o id do profissional da sessão
        $id_profissional = Session::get('id_profissional');

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

    // Método para deletar horário
    public function deletarServico($id)
    {
        // Lógica para encontrar e deletar o horário pelo ID
        $horario = DB::table('servicos')->where('id_servico', $id)->first();

        if ($horario) {
            DB::table('servicos')->where('id_servico', $id)->delete();
            return redirect()->route('listaServicos')->with('success', 'Horário deletado com sucesso.');
        }

        return redirect()->route('listaServicos')->with('error', 'Horário não encontrado.');
    }

    // Método de exibição do vinculo
    public function vinculoProf()
    {
        // Recupera o ID do profissional armazenado na sessão
        $idProfissional = Session::get('id_profissional');

        // Verifica se o ID está presente
        if (!$idProfissional) {
            return redirect()->route('login')->with('error', 'Profissional não autenticado');
        }

        // Chama o stored procedure passando o ID do profissional
        $vinculo = DB::select('CALL consulta_vinculo(?)', [$idProfissional]);

        // Obtém a lista de estabelecimentos para o dropdown
        $estabelecimentos = Estabelecimento::all();

        return view('vinculo-prof', ['vinculo' => $vinculo, 'estabelecimentos' => $estabelecimentos]);
    }

    public function solicitarVinculo(Request $request)
    {
        $idProfissional = Session::get('id_profissional');
        $id_estabelecimento = $request->input('id_estabelecimento');

        try {
            DB::statement('CALL inserir_vinculo(?, ?)', [$id_estabelecimento, $idProfissional]);
            return back()->with('success', 'Solicitação de vínculo enviada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function servicosProf(){
        // Recupera o ID do profissional armazenado na sessão
        $idProfissional = Session::get('id_profissional');

        // Recupera o ID do estabelecimento vinculado armazenado na sessão
        $idEstab = DB::table('profissionais')
                ->where('id_profissional', $idProfissional)
                ->value('estabel_vinculado');

        // Verifica se o ID está presente
        if (!$idProfissional) {
            return redirect()->route('login')->with('error', 'Profissional não autenticado');
        }

        // Chama o stored procedure passando o ID do profissional
        $servicos = DB::select('CALL exibir_servicos_profissional(?)', [$idProfissional]);

        // Obtém a lista de serviços para o dropdown
        $lista = DB::select('CALL exibir_servicos_estabelecimento(?)', [$idEstab]);

        return view('servicos-prof', ['servicos' => $servicos, 'lista' => $lista]);
    }

    public function associarServ(Request $request)
    {
        $idProfissional = Session::get('id_profissional');
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