<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validaCelular implements Rule
{    

    public function passes($attribute, $value)
    {
        return preg_match('/^\(\d{2}\)\s?\d{4,5}-\d{4}$/', $value) > 0;
    }

    public function message()
    {
    return 'O campo :attribute não é um celular com DDD válido.';
    }
}