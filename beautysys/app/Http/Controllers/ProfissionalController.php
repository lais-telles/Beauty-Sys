<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissional;  // Importe o modelo Profissional
use Illuminate\Support\Facades\Hash;  // Importe a classe Hash para criptografar a senha

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

        // Cria o cliente com os dados validados e criptografa a senha
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
}
