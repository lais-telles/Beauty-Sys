<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;  // Importe o modelo Cliente
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha

class ClienteController extends Controller
{
    // Função para salvar o cliente no banco de dados
    public function cadastrarCliente(Request $request)
    {
        // Valida os dados enviados pelo modal
        $validatedData = $request->validate([
            'nome' => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'CPF' => 'required|string|max:14',
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
        return redirect()->route('PaginaInicialPf')->with('success', 'Cliente cadastrado com sucesso!');
    }
}
