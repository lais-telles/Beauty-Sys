<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissional;  // Importe o modelo Profissional
use App\Models\Agendamento;  // Importe o modelo Agendamento
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

        // Cria o profissional com os dados validados e criptografa a senha
        Profissional::create([
            'nome' => $validatedData['nome'],
            'data_nasc' => $validatedData['data_nascimento'],
            'CPF' => $validatedData['cpf'],
            'telefone' => $validatedData['telefone'],
            'email' => $validatedData['email'],
            'senha' => Hash::make($validatedData['senha']),
        ]);

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

        // Chama o stored procedure passando o ID do profissional
        $horarios = DB::select('CALL consulta_grade_horaria(?)', [$idProfissional]);

        // Retorna a view 'grade-profissional' com os dados da grade
        return view('grade-profissional', ['horarios' => $horarios]);
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


    public function exibirAgendamentosProf() {
        // Captura o id do estabelecimento da sessão
        $id_profissional = Session::get('id_profissional');

        // Buscando todos os status disponíveis no banco de dados
        $statusAgendamentos = DB::table('status_agendamentos')->get();

        // Chama a procedure armazenada e passa o id do estabelecimento
        $agendamentos = DB::select('CALL exibir_agendamentos_profissional(?)', [$id_profissional]);

        // Retorna a view com os agendamentos
        return view('agendamentos-prof', compact('agendamentos', 'statusAgendamentos'));
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
    
}
?>