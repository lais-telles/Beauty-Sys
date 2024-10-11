<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB
use Illuminate\Support\Facades\Hash;

class Profissional extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'profissionais';

    // Defina a chave primária, se não for 'id'
    protected $primaryKey = 'id_profissional';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'data_nasc',
        'CPF',
        'telefone',
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
