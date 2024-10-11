<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;  // Importe o modelo Cliente
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha
use Illuminate\Support\Facades\DB; // Para consultas ao banco de dados
use Illuminate\Support\Facades\Session; // Para armazenar sessão

class ClienteController extends Controller
{
    // Função para salvar o cliente no banco de dados
    public function cadastrarCliente(Request $request)
    {
        // Valida os dados enviados pelo modal
        $validatedData = $request->validate([
            'nome' => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14',
            'telefone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:clientes',
            'senha' => 'required|string|min:8',
        ]);

        // Cria o cliente com os dados validados e criptografa a senha
        Cliente::create([
            'nome' => $validatedData['nome'],
            'data_nasc' => $validatedData['data_nascimento'],
            'CPF' => $validatedData['cpf'],
            'telefone' => $validatedData['telefone'],
            'email' => $validatedData['email'],
            'senha' => Hash::make($validatedData['senha']),
        ]);

        // Redireciona para a página index com uma mensagem de sucesso
        return redirect()->route('PessoaFisica')->with('success', 'Cliente cadastrado com sucesso!');
    }

    // Método de login
    public function loginCliente(Request $request)
    {
        // Validação dos campos de entrada
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:8',
        ]);

        // Recuperar o usuário do banco com base no e-mail
        $user = DB::table('clientes')->where('email', $request->input('email'))->first();

        // Comparar a senha fornecida com a senha armazenada
        if ($user && Hash::check($request->input('senha'), $user->senha)) {
            // Login bem-sucedido
            Session::put('id_cliente', $user->id_cliente);
            Session::put('nome', $user->nome);
            return view('home-pf');
        } else {
            // Se falhar, redirecionar de volta com erro
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
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
    public function buscar_cliente(Request $request){
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
    public function alterar_cadastro(Request $request) {
        // Captura o id do cliente da sessão
        $id_cliente = Session::get('id_cliente');
        $telefone = $request->input('telefone');
        $email = $request->input('email');
        $senha = NULL;

        DB::select('CALL atualizar_cliente(?, ?, ?, ?)', [
            $id_cliente,
            $telefone,
            $email,
            $senha
        ]);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }
}
?>