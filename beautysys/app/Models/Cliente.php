<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB
use Illuminate\Support\Facades\Hash;

class Cliente extends Model
{
    use HasFactory;

    // Defina a chave primária, se não for 'id'
    protected $primaryKey = 'id_cliente';

    // Define a tabela associada
    protected $table = 'clientes';

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

    public static function cadastrarCliente($data) {
        // Cria o cliente com os dados validados e criptografa a senha
        return self::create([
            'nome' => $data['nome'],
            'data_nasc' => $data['data_nascimento'],
            'CPF' => $data['cpf'],
            'telefone' => $data['telefone'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
        ]);
    }

    public static function atualizarCliente($id_cliente, $telefone, $email, $senha) {
        $cliente = self::find($id_cliente);
        
        return DB::statement('CALL atualizar_cliente(?, ?, ?, ?)', [$id_cliente, $telefone, $email, $senha]);
    }
}
?>
