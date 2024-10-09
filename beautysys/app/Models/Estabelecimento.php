<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB

class Estabelecimento extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'estabelecimentos';

    // Defina a chave primária, se não for 'id'
    protected $primaryKey = 'id_estabelecimento';

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

    public static function atualizar_estabelecimento($id_estabelecimento, $nome_fantasia, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $CEP, $inicio_expediente, $termino_expediente, $email, $senha) {
        $estabelecimento = self::find($id_estabelecimento);

        // Se a senha for null, mantém o valor original
        if ($senha === null) {
            $senha = $estabelecimento->senha; // Mantém a senha inalterada
        }

        return DB::statement('CALL atualizar_estabelecimento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[$id_estabelecimento, $nome_fantasia, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $CEP, $inicio_expediente, $termino_expediente, $email, $senha]);
    }
}
