<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Para consultas ao banco de dados

class Servico extends Model
{
    use HasFactory; 

    // Define a tabela associada
    protected $table = 'servicos';

    // Defina a chave primária, se não for 'id'
    protected $primaryKey = 'id_servico';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'valor',
        'duracao',
        'id_categoria',
        'id_estabelecimento',
    ];

    // Desativa os timestamps automáticos
    public $timestamps = false;

    public static function cadastrarServico($nome, $valor, $duracao, $id_categoria, $id_estabelecimento)
    {
        return DB::select('CALL cadastrar_servico(?, ?, ?, ?, ?)', [
            $nome,
            $valor,
            $duracao,
            $id_categoria,
            $id_estabelecimento,
        ]);
    }
    
}
