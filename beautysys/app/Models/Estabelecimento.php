<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB
use Illuminate\Support\Facades\Hash;

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


    public static function cadastrarEstabelecimento($data){
        // Cria o estabelecimento com os dados validados e criptografa a senha
        return self::create([
            'razao_social' => $data['razao_social'],
            'nome_fantasia' => $data['nome_fantasia'],
            'telefone' => $data['telefone'],
            'CNPJ' => $data['cnpj'],
            'logradouro' => $data['logradouro'],
            'numero' => $data['numero'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'estado' => $data['estado'],
            'CEP' => $data['cep'],
            'inicio_expediente' => $data['inicio_expediente'],
            'termino_expediente' => $data['termino_expediente'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
        ]);
    }
    
}
