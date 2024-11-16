<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importando Authenticatable para autenticação

class Estabelecimento extends Authenticatable
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
        'email_verificado',
        'imagem_perfil',
    ];


    // Desativa os timestamps automáticos
    public $timestamps = false;

    // Ocultar a senha ao recuperar os dados
    protected $hidden = [
        'senha',
    ];

    // Adiciona a função getAuthPassword para autenticação
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public static function cadastrarEstabelecimento($data){
        // Cria o estabelecimento com os dados validados e criptografa a senha
        return self::create([
            'razao_social' => $data['razao_social'],
            'nome_fantasia' => $data['nome_fantasia'],
            'telefone' => $data['telefoneEstab'],
            'CNPJ' => $data['cnpj'],
            'logradouro' => $data['logradouro'],
            'numero' => $data['numero'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'estado' => $data['estado'],
            'CEP' => $data['cep'],
            'inicio_expediente' => $data['inicio_expediente'],
            'termino_expediente' => $data['termino_expediente'],
            'email' => $data['emailCadasProp'],
            'senha' => Hash::make($data['senhaCadasProp']),
            'email_verificado' => 0,
        ]);
    }
    
    public static function atualizar_estabelecimento($id_estabelecimento, $nome_fantasia, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $CEP, $inicio_expediente, $termino_expediente, $email)
    {
        return DB::statement('CALL atualizar_estabelecimento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[$id_estabelecimento, $nome_fantasia, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $CEP, $inicio_expediente, $termino_expediente, $email]);
    }
}
