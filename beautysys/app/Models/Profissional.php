<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importando Authenticatable para autenticação
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Profissional extends Authenticatable
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

    // Adiciona a função getAuthPassword para autenticação
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public static function cadastrarProfissional($data) {
        // Cria o profissional com os dados validados e criptografa a senha
        return self::create([
            'nome' => $data['nome'],
            'data_nasc' => $data['data_nascimento'],
            'CPF' => $data['cpf'],
            'telefone' => $data['telefone'],
            'email' => $data['emailCadasProf'],
            'senha' => Hash::make($data['senhaCadasProf']),
        ]);
    }

    public static function atualizarProfissional($id_profissional, $telefone, $email) {      
        return DB::statement('CALL atualizar_profissional(?, ?, ?)', [
            $id_profissional,
            $telefone,
            $email
        ]);
    }
}
