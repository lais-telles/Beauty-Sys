<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;  // Importe o modelo Cliente
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha

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
            'numero' => 'required|int|max:11',
            'bairro' => 'required|string|max:40',
            'cidade' => 'required|string|max:40',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9',
            'inicio_expediente' => 'required|date_format: H:i:s',
            'termino_expediente' => 'required|date_format: H:i:s',
            'email' => 'required|string|email|max:255|unique:estabelecimentos',
            'senha' => 'required|string|min:8',
        ]);

        // Cria o cliente com os dados validados e criptografa a senha
        Estabelecimento::create([
            'nome' => $validatedData['nome'],
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
        return redirect()->route('PaginaInicialPj')->with('success', 'Cliente cadastrado com sucesso!');
    }
}
