<?php

class validarNif
{
    public static function validateNIF($nif)
    {
        $nif = trim($nif);
        $nif_split = str_split($nif);
        $nif_primeiros_digito = array(1, 2, 3, 5, 6, 7, 8, 9);
        if (is_numeric($nif) && strlen($nif) == 9 && in_array($nif_split[0], $nif_primeiros_digito)) {
            $check_digit = 0;
            for ($i = 0; $i < 8; $i++) {
                $check_digit += $nif_split[$i] * (10 - $i - 1);
            }
            $check_digit = 11 - ($check_digit % 11);
            $check_digit = $check_digit >= 10 ? 0 : $check_digit;
            if ($check_digit == $nif_split[8]) {
                return true;
            }
        }
        return false;
    }

    public static function isParticular($nif)
    {
        $nif = trim($nif);
        if (
            substr($nif, 0, 1) == '1' ||
            substr($nif, 0, 1) == '2' ||
            substr($nif, 0, 1) == '3' ||
            substr($nif, 0, 2) == '45'
        ) {
            return true;
        }else{
            return false;
        }
    }


    public static function isEmpresa($nif)
    {
        $nif = trim($nif);
        if (
            substr($nif, 0, 1) == '5' ||
            substr($nif, 0, 2) != '71')
        {
            return true;
        }else{
            return false;
        }
    }

}