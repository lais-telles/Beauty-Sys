<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DateTime;

class validaDataCliente implements Rule
{
    public function passes($attribute, $value)
    {
        // Verifica se o valor está em branco ou nulo
        if (empty($value)) {
            return false;
        }

        // Cria um objeto DateTime para a data de hoje
        $hoje = new DateTime(date("Y-m-d"));

        // Converte o valor de entrada para um objeto DateTime
        try {
            $nascimento = new DateTime($value);
        } catch (\Exception $e) {
            return false; // Retorna falso se a data não for válida
        }

        // Calcula a diferença entre as datas
        $idade = $hoje->diff($nascimento);

        // Verifica se a idade está entre 18 e 125 anos
        return ($idade->y >= 13 && $idade->y <= 125);
    }

    public function message()
    {
        return 'A idade deve ser entre 13 e 125 anos.';
    }
}
