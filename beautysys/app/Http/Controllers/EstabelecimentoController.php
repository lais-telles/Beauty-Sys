<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;  // Importe o modelo Estabelecimento
use App\Models\Servico;  // Importe o modelo Servico
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha
use Illuminate\Support\Facades\DB; // Para consultas ao banco de dados
use Illuminate\Support\Facades\Session; // Para armazenar sessão

class EstabelecimentoController extends Controller
{
    // Função para salvar o estabelecimento no banco de dados
    public function cadastrarEstabelecimento(Request $request)
    {
        // Valida os dados enviados pelo modal presente na view
        $validatedData = $request->validate([
            'razao_social' => 'required|string|max:40',
            'nome_fantasia' => 'required|string|max:40',
            'telefone' => 'required|string|max:15',
            'cnpj' => 'required|string|max:18',
            'logradouro' => 'required|string|max:40',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:40',
            'cidade' => 'required|string|max:40',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9',
            'inicio_expediente' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'termino_expediente' => 'required|string|max:255', //verificar a possibilidade, necessidade de mudar o tipo de dados
            'email' => 'required|string|email|max:255|unique:estabelecimentos',
            'senha' => 'required|string|min:8',
        ]);

        // Chama o método para criar o estabelecimento no model
        Estabelecimento::cadastrarEstabelecimento($validatedData);

        // Redireciona para a página index com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Estabelecimento cadastrado com sucesso!');
    }

    // Método de login
    public function loginEstab(Request $request) 
    {
        // Validação dos campos de entrada
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:8',
        ]);

        // Recuperar o usuário do banco com base no e-mail
        $user = DB::table('estabelecimentos')->where('email', $request->input('email'))->first();

        // Comparar a senha fornecida com a senha armazenada
        if ($user && Hash::check($request->input('senha'), $user->senha)) {
            // Login bem-sucedido
            Session::put('id_estabelecimento', $user->id_estabelecimento);
            Session::put('nome_fantasia', $user->nome_fantasia);
            return view('home-pj');
        } else {
            // Se falhar, redirecionar de volta com erro
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
        }
    }

    // Método de logout
    public function logoutEstab(Request $request)
    {
        // Limpa a sessão do cliente
        Session::flush();

        // Redireciona para a página de login (ou qualquer outra página)
        return view('index')->with('success', 'Logout realizado com sucesso!');
    }


    public function buscar_estabelecimento(Request $request){
        // Captura o id do estabelecimento da sessão
        $id_estabelecimento = Session::get('id_estabelecimento');
   
        // Obtém o registro do estabelecimento
        $registro = Estabelecimento::find($id_estabelecimento);
   
        // Verifica se o registro foi encontrado
        if (!$registro) {
            return redirect()->route('Parceiro')->with('error', 'Estabelecimento não encontrado.');
        }
   
        // Retorna a view com o registro
        return view('info-cadEstab', compact('registro'));
    }


    public function alterar_cadastro(Request $request) {
        // Captura o id do estabelecimento da sessão
        $id_estabelecimento = Session::get('id_estabelecimento');
        $nome_fantasia = $request->input('nome_fantasia');
        $telefone = $request->input('telefone');
        $logradouro = $request->input('logradouro');
        $numero = $request->input('numero');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $estado = $request->input('estado');
        $CEP = $request->input('CEP');
        $inicio_expediente = $request->input('inicio_expediente');
        $termino_expediente = $request->input('termino_expediente');
        $email = $request->input('email');
        $senha = NULL;

        Estabelecimento::atualizar_estabelecimento($id_estabelecimento, $nome_fantasia, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $CEP, $inicio_expediente, $termino_expediente, $email, $senha);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }


    public function listaServicos() {
        // Captura o id do estabelecimento da sessão
        $id_estabelecimento = Session::get('id_estabelecimento');
   
        // Obtém o registro do estabelecimento
        $servicos = Servico::where('id_estabelecimento', $id_estabelecimento)->get();
   
        // Retorna a view com o registro
        return view('servicos-cad', compact('servicos'));
    }   

    public function cadastrarServico(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'required|string|max:30',
            'valor' => 'required|numeric',
            'duracao' => 'required|string',
            'id_categoria' => 'required|integer',
        ]);
    
        // Obtendo o id_estabelecimento da sessão
        $id_estabelecimento = session('id_estabelecimento');
    
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

    public function exibirAgendamentosEstab(){
        // Captura o id do estabelecimento da sessão
        $id_estabelecimento = Session::get('id_estabelecimento');

        // Chama a procedure armazenada e passa o id do estabelecimento
        $agendamentos = DB::select('CALL exibir_agendamentos_estabelecimento(?)', [$id_estabelecimento]);

        // Retorna a view com os agendamentos
        return view('agendamentos-estab', compact('agendamentos'));
    }


    public function dashboardEstab(){
        // Captura o id do estabelecimento da sessão
        $id_estabelecimento = Session::get('id_estabelecimento');
    
        // Executa os procedimentos armazenados e captura os resultados
        $profissionais = DB::select('CALL exibir_profissionais_vinculados(?)', [$id_estabelecimento]);
        $clientes = DB::select('CALL clientes_por_estabelecimento(?)', [$id_estabelecimento]);
        $servicos = DB::select('CALL exibir_servicos_estabelecimento(?)', [$id_estabelecimento]);
        $agendamentos = DB::select('CALL exibir_agendamentos_estabelecimento(?)', [$id_estabelecimento]);
        $agendamentos_mes = DB::select('CALL contagem_agendamentos(?)', [$id_estabelecimento]);
    
        // Cria um objeto ou array simplificado contendo os totais
        $data = [
            'total_profissionais' => $profissionais[0]->total_profissionais ?? 0,
            'total_clientes' => $clientes[0]->total_clientes ?? 0,
            'total_servicos' => $servicos[0]->total_servicos ?? 0,
            'total_agendamentos' => $agendamentos[0]->total_agendamentos ?? 0,
            'agendamentos_por_mes' => $agendamentos_mes, // Armazena a contagem mensal
        ];
    
        // Retorna a view com os dados simplificados
        return view('dashboard-pj', compact('data'));
    }
    
    
}    
?>