<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class ValidaCNPJ implements Rule
{
    public function passes($attribute, $value) {
        // Remove qualquer caractere não numérico
        $cnpj = preg_replace('/[^0-9A-Za-z]/', '', $value);
    
        // Verifica se o CNPJ tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }
    
        // Verifica se todos os dígitos são iguais (ex.: "11111111111111")
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
    
        // Converte os dígitos hexadecimais em valores numéricos subtraindo 48
        $valores = array_map(function($char) {
            return ord($char) - 48; // Converte de ASCII para valor numérico
        }, str_split($cnpj));
    
        // Cálculo do primeiro dígito verificador
        $soma = 0;
        $multiplicadores = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        for ($i = 0; $i < 12; $i++) {
            $soma += $valores[$i] * $multiplicadores[$i];
        }

        $resto = $soma % 11;
        $primeiroDigitoVerificador = $resto < 2 ? 0 : 11 - $resto;
    
        // Cálculo do segundo dígito verificador
        $soma = 0;
        $multiplicadores = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 13; $i++) {
            $soma += $valores[$i] * $multiplicadores[$i];
        }

        $resto = $soma % 11;
        $segundoDigitoVerificador = $resto < 2 ? 0 : 11 - $resto;
    
        // Verifica os dígitos verificadores
        return $primeiroDigitoVerificador == $valores[12] && $segundoDigitoVerificador == $valores[13];
    }

    public function message(){
        return 'CNPJ inválido.';
    }
}
