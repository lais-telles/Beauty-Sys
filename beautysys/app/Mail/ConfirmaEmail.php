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

    public function __construct($email)
    {
        $token = Str::random(60);
        
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('confirma-email')
                    ->with([
                        'link' => route('confirmaEmail', [
                            'token' => $this->token,
                            'email' => $this->email,
                        ]),
                    ]);
    }
}
?>
