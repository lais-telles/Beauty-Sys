<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Função para confirmar o e-mail
    public function confirmaEmail(Request $request){
        $token = $request->query('token');
        $email = $request->query('email');

        if(!$token || !$email) {
            return redirect()->route('Index')->with('error', 'Acesso inválido.');
        }

        // Verifica se o e-mail está correto
        $cliente = Cliente::where('email', $email)->first();

        if ($cliente) {
            $cliente->email_verificado = true;
            $cliente->save();

            return redirect()->route('PessoaFisica')->with('success', 'E-mail confirmado com sucesso!');
        } else {
            return redirect()->route('PessoaFisica')->with('error', 'Token inválido ou expirado.');
        }
    }
}
