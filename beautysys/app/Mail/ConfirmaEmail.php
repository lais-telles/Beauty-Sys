<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ConfirmaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;
    public $tipo_usuario;

    public function __construct($token, $email, $tipo_usuario){
        $this->email = $email;
        $this->token = $token;
        $this->tipo_usuario = $tipo_usuario;
    }

    public function build(){
        return $this->view('confirma-email')
                    ->with([
                        'link' => route('confirmaEmail', [
                            'token' => $this->token,
                            'email' => $this->email,
                            'tipo_usuario' => $this->tipo_usuario,
                        ]),
                    ]);
    }
}
?>
