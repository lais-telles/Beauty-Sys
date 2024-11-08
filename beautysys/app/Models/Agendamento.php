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

    protected $primaryKey = 'id_agendamento';

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

    public static function atualizarStatus($id_agendamento, $novoStatus) {
        $agendamento = self::find($id_agendamento);
        
        if ($agendamento) {
            // Atualiza o status usando o ID correto
            $agendamento->id_status = $novoStatus;
            $agendamento->save();
            return true;
        }
    
        return false;
    }
}
