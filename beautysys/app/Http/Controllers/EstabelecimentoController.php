<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;  // Importe o modelo Estabelecimento
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha
use Illuminate\Support\Facades\DB; // Para consultas ao banco de dados
use Illuminate\Support\Facades\Session; // Para armazenar sessão

class EstabelecimentoController extends Controller
{
    // Função para salvar o cliente no banco de dados
    public function cadastrarEstabelecimento(Request $request)
    {
        // Valida os dados enviados pelo modal
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

        // Cria o cliente com os dados validados e criptografa a senha
        Estabelecimento::create([
            'razao_social' => $validatedData['razao_social'],
            'nome_fantasia' => $validatedData['nome_fantasia'],
            'telefone' => $validatedData['telefone'],
            'CNPJ' => $validatedData['cnpj'],
            'logradouro' => $validatedData['logradouro'],
            'numero' => $validatedData['numero'],
            'bairro' => $validatedData['bairro'],
            'cidade' => $validatedData['cidade'],
            'estado' => $validatedData['estado'],
            'CEP' => $validatedData['cep'],
            'inicio_expediente' => $validatedData['inicio_expediente'],
            'termino_expediente' => $validatedData['termino_expediente'],
            'email' => $validatedData['email'],
            'senha' => Hash::make($validatedData['senha']),
        ]);

        // Redireciona para a página index com uma mensagem de sucesso
        return redirect()->route('Parceiro')->with('success', 'Estabelecimento cadastrado com sucesso!');
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
}
?>