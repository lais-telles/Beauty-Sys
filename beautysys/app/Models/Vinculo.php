<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'vinculos';

    // Defina a chave primária, se não for 'id'
    protected $primaryKey = 'id_vinculo';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'id_estabelecimento',
        'id_profissional',
    ];

    // Desativa os timestamps automáticos
    public $timestamps = false;
}
