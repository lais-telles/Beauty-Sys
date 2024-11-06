<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetSenha extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'resets_senhas';

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

