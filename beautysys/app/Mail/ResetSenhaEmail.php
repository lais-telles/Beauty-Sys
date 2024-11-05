<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetSenhaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $userType;

    public function __construct($user, $token, $userType)
    {
        $this->user = $user;
        $this->token = $token;
        $this->userType = $userType;
    }

    public function build()
    {
        // Define a rota com base no tipo de usuário
        $routeName = match ($this->userType) {
            'cliente' => 'resetSenhaCliente',
            'profissional' => 'resetSenhaProfissional',
            'estabelecimento' => 'resetSenhaEstabelecimento',
            default => throw new \Exception('Tipo de usuário inválido')
        };

        return $this->view('reset-password')
                    ->with([
                        'link' => route($routeName, [
                            'token' => $this->token,
                            'email' => $this->user->email,
                        ]),
                    ]);
    }
}
?>