<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsToken extends Model
{
    use HasFactory;
 
    // Define a tabela associada
    protected $table = 'logs_tokens';

    protected $primaryKey = 'id_token';

    protected $fillable = [
        'email',
        'token',
        'created_at',
        'used_at',
        'motivo',
        'id_usuario',
        'tipo_usuario'
    ];

    // Desativa os timestamps automáticos
    public $timestamps = false;
}
