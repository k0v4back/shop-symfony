<?php

namespace App\Helpers;

class GenerateDefaultNick
{
    public static function generate(int $len = 7)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';

        for ($i = 0; $i < $len; $i++){
            $result .= $characters[rand(0, strlen($characters)-1)];
        }

        return $result;
    }
}