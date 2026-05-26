<?php

namespace App\Http\Utils;
use Carbon\Carbon;

class DateUtil
{

    /**
     * Converte a data em milisegundos
     */
    public static function returnDateConvertedSecond($data) {
        date_default_timezone_set(env('APP_TIMEZONE', 'America/Sao_Paulo'));
        return strtotime($data);
    }

    /**
     * retorna data e hora atual do relogio sequida de Ano-Mes-Dia Hora-Minuto-Segundo
     * utilizada geralmente para salvar no banco de dados
     */
    public static function returnDateTimeNow() {
        date_default_timezone_set(env('APP_TIMEZONE', 'America/Sao_Paulo'));
        return date('Y-m-d H:i:s');
    }

    /**
     * retorna data e hora atual do relogio sequida de Ano-Mes-Dia Hora-Minuto-Segundo
     * utilizada geralmente para salvar no banco de dados
     */
    public static function returnDate() {
        date_default_timezone_set(env('APP_TIMEZONE', 'America/Sao_Paulo'));
        return date('Y-m-d');
    }

    /**
     * Retorna a data atual, mais os minutos vindo por parametro
     * @param int $minutes
     * @param bool $converted
     * @return string
     */
    public static function addMinutesToDate(int $minutes, bool $converted=true):string {
        date_default_timezone_set(env('APP_TIMEZONE', 'America/Sao_Paulo'));
        $timeCurrent = Carbon::now();
        $timeNew = $timeCurrent->addMinutes($minutes);

        if($converted){
            $timeNew = $timeNew->format('d/m/Y H:i:s');
        }

        return $timeNew;
    }

    /**
     * Retorna a data atual nesse formato Terça-feira, 1 de outubro de 2024 às 11:50
     * @return string
     */
    public static function returnCurrentDateFormatHumam(){
        date_default_timezone_set(env('APP_TIMEZONE', 'America/Sao_Paulo'));
        $now = Carbon::now()->locale('pt_BR');
        return $now->translatedFormat('l, j \d\e F \d\e Y \à\s H:i');
    }

    /**
     * Retorna o Mês descritivo
     * @param int $month
     * @return string
     */
    public static function descriptiveMonth(int $month): string
    {
        return Carbon::createFromDate(null, $month, 1)
            ->locale('pt_BR')
            ->translatedFormat('F');
    }

    /**
     * Retorna a data no formato date para mostrar para o usuário no formato brasileiro Dia/Mes/Ano
     */
    public static function returnDataShow($data) {

        if(!$data){
            return null;
        }

        date_default_timezone_set('America/Sao_Paulo');
        $dataConverted = self::returnDateConvertedSecond($data);
        return date("d/m/Y", $dataConverted);
    }

    public static function calcAge($birth_date){
        date_default_timezone_set(env('APP_TIMEZONE', 'America/Sao_Paulo'));
        if (!$birth_date) {
            return 0; 
        }
        return Carbon::parse($birth_date)->age;
    }
}
