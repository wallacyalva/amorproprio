<?php

namespace App\Http\Utils;

class SanitizeUtil
{
    public static function sanitizeString($string): string
    {
        return htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeInt($int)
    {
        return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitizeEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizeUrl($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    public static function sanitizeHtml($html)
    {
        return filter_var($html, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public static function decodeSanitizedHtml($html): string
    {
        return html_entity_decode($html, ENT_QUOTES, "utf-8");
    }

    public static function sanitizeArray($array, $type = 513): array
    {
        $newArray = [];
        $amount = count($array);

        for ($i = 0; $i < $amount; $i++) {
            $newArray[$i] = filter_var($array[$i], $type);
        }

        return $newArray;
    }
}
