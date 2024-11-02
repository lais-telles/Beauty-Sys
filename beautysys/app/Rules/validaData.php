<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DateTime; // Importa a classe DateTime

class validaData implements Rule
{
    public function passes($attribute, $value)
    {
        // Cria um objeto DateTime para a data de hoje
        $hoje = new DateTime(date("Y-m-d"));
        
        // Converte o valor de entrada para um objeto DateTime
        $nascimento = new DateTime($value);

        // Calcula a diferença entre as datas
        $idade = $hoje->diff($nascimento);

        // Verifica se a idade é maior ou igual a 18
        return ($idade->y) >= 18;
    }

    public function message()
    {
        return 'Não permitido menores de 18 anos.';
    }
}
    