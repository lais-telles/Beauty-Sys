<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Define a tabela associada
    protected $table = 'grades_horario';

    protected $primaryKey = 'id_grade';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'id_profissional',
        'dia_semana',
        'hora_inicio',
        'hora_termino'
    ];


    // Desativa os timestamps automáticos
    public $timestamps = false;
}
