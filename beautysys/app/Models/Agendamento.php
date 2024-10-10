<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importando a classe DB

class Agendamento extends Model
{
    use HasFactory;

     // Define a tabela associada
     protected $table = 'agendamentos';

     // Define os campos que podem ser preenchidos em massa
     protected $fillable = [
         'id_cliente',
         'id_profissional',
         'id_opcaopag',
         'id_status',
         'id_servico',
         'data_realizacao',
         'data_agendamento',
         'hora_inicio',
         'horario_termino',
         'valor_total',
     ];

     // Desativa os timestamps automáticos
    public $timestamps = false;
}
