<?php

namespace App\Http\Utils;

class UserUtil
{

    public static function hashPasswod($passwod)
    {
        return bcrypt($passwod);
    }

    /**
     * Retorna o cpf sem . ou -
     * */
    public static function documentWithoutDotAndDash($document)
    {
        $document = trim($document);
        $document = str_replace(['.', '-', '/'], "", $document);
        return $document;
    }

    /**
     * Metodo retorna o nome formatado
     */
    public static function checkName($name)
    {
        //retira os espaço do ínicio e final da string
        $name = trim($name);

        //Deixa tudo com letra minuscula
        $name = mb_strtolower($name, 'UTF-8'); //strtolower($name);

        //Deixa a Primeira letra da palavra em Maiscula
        $name = ucwords($name);

        $exName = explode(' ', $name); // Pega e converte as Letras em vetor

        for ($i = 0; $i < count($exName); $i++) {
            $exName[$i] = match ($exName[$i]) {
                "Dos" => "dos",
                "Das" => "das",
                "Do" => "do",
                "De" => "de",
                "Da" => "da",
                default => $exName[$i]
            };
        }

        $name = implode(" ", $exName);
        return $name;
    }

    /**
     * Formatar CPF
     */
    public static function formatCPF($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            $cpf = str_pad($cpf, 11, "0", STR_PAD_LEFT);
        }

        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    /**
     * Verifica a formatação correta do E-mail
     * @param string $email
     * @return string
     */
    public static function checkEmail($email)
    {
        //retira os espaço do ínicio e final da string
        $email = trim($email);

        //Deixa tudo com letra minuscula
        $email = mb_strtolower($email, 'UTF-8'); //strtolower($name);

        $exEmail = explode(' ', $email); // Pega e converte as Letras em vetor
        $email = implode("", $exEmail);
        return $email;
    }

    

}
