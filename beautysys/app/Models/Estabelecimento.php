<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'estabelecimentos';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'telefone',
        'CNPJ',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'CEP',
        'inicio_expediente',
        'termino_expediente',
        'email',
        'senha',
    ];


    // Desativa os timestamps automáticos
    public $timestamps = false;

    // Ocultar a senha ao recuperar os dados
    protected $hidden = [
        'senha',
    ];
}
