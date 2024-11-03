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

    public $cliente;
    public $token;

    public function __construct($cliente, $token)
    {
        $this->cliente = $cliente;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('reset-password')
                    ->with([
                        'link' => route('resetSenhaCliente', ['token' => $this->token, 'email' => $this->cliente->email]),
                    ]);
    }
}
?>