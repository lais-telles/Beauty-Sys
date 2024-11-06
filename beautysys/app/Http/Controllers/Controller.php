<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ConfirmacaoEmail;
use App\Models\LogsToken;
use App\Models\ResetSenha;
use App\Models\Profissional;
use App\Models\Estabelecimento;
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
        $tipo_usuario = $request->query('tipo_usuario');

        $resetRecord = ConfirmacaoEmail::where('email', $email)->where('token', $token)->where('tipo_usuario', $tipo_usuario)->first();

        if(!$token || !$email) {
            return redirect()->route('Index')->with('error', 'Acesso inválido.');
        }


        if($tipo_usuario){
            if($tipo_usuario == 'cliente'){
                // Verifica se o e-mail está correto
                $cliente = Cliente::where('email', $email)->first();

                if ($cliente) {
                    $cliente->email_verificado = true;
                    $cliente->save();

                    LogsToken::create([
                        'email' => $email,
                        'token' => $token,
                        'created_at' => $resetRecord->created_at,
                        'used_at' => now(),
                        'motivo' => 'confirmação de email',
                        'id_usuario' => $cliente->id_cliente,
                        'tipo_usuario' => 'cliente',
                    ]);
            
                    ConfirmacaoEmail::where('email', $email)->where('tipo_usuario', 'cliente')->delete();

                    return redirect()->route('PessoaFisica')->with('success', 'E-mail confirmado com sucesso!');
                }
            } else if($tipo_usuario == 'profissional') {
                // Verifica se o e-mail está correto
                $profissional = Profissional::where('email', $email)->first();

                if ($profissional) {
                    $profissional->email_verificado = true;
                    $profissional->save();

                    LogsToken::create([
                        'email' => $email,
                        'token' => $token,
                        'created_at' => $resetRecord->created_at,
                        'used_at' => now(),
                        'motivo' => 'confirmação de email',
                        'id_usuario' => $profissional->id_profissional,
                        'tipo_usuario' => 'profissional',
                    ]);

                    ConfirmacaoEmail::where('email', $email)->where('tipo_usuario', 'profissional')->delete();

                    return redirect()->route('Parceiro')->with('success', 'E-mail confirmado com sucesso!');
                }
            } else if($tipo_usuario == 'estabelecimento') {
                // Verifica se o e-mail está correto
                $estabelecimento = Estabelecimento::where('email', $email)->first();

                if ($estabelecimento) {
                    $estabelecimento->email_verificado = true;
                    $estabelecimento->save();

                    LogsToken::create([
                        'email' => $email,
                        'token' => $token,
                        'created_at' => $resetRecord->created_at,
                        'used_at' => now(),
                        'motivo' => 'confirmação de email',
                        'id_usuario' => $estabelecimento->id_estabelecimento,
                        'tipo_usuario' => 'estabelecimento',
                    ]);
            
                    ConfirmacaoEmail::where('email', $email)->where('tipo_usuario', 'estabelecimento')->delete();

                    return redirect()->route('Parceiro')->with('success', 'E-mail confirmado com sucesso!');
                }
            }
        } else {
            return redirect()->route('Index')->with('error', 'Token inválido ou expirado.');
        }
    }
}