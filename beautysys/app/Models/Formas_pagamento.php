<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB

class Formas_pagamento extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'formas_pagamentos';

    // Defina a chave primária, se não for 'id'
    protected $primaryKey = 'id_opcaopag';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'descricao',
    ];


    // Desativa os timestamps automáticos
    public $timestamps = false;
}
