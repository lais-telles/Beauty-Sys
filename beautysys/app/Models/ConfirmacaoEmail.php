<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmacaoEmail extends Model
{
    use HasFactory;

    protected $table = 'confirmacoes_emails';

    protected $fillable = [
        'token',
        'email',
        'created_at',
        'id_usuario',
        'tipo_usuario'
    ];

     // Desativa os timestamps automáticos
     public $timestamps = false;
}
