<?php

namespace App\Services;
use App\Exceptions\AccessTypeException;

class MensageService{

    /**
     * Metodo para salvar o log do evento
     * @param $eventId
     * @param $userId
     * @param $note
     * @return int|null
    */
    public static function error($mensage,$status = 400){
        return response()->json(['status' => false, 'error' => $mensage],$status);
    }

    /**
     * Metodo para salvar o log de inscricao
     * @param $inscriptionId
     * @param $userId
     * @param $note
     * @return int|null
     */
    public static function sucess($mensage, $model = [],$pagination = false){
        $infos = [
            'status' => true,
            // 'message' => $mensage
        ];
        
        if($pagination){
            $infos['amount'] = count($model);
            $infos['total'] = $model->total();
            $infos['data'] = $model->items();
        }else if($model){
            $infos['message'] = $mensage;
            $infos['data'] = $model;
        }

        return response()->json($infos, 201);
    }

    public static function throwable($th = []){
        return response()->json(['status' => false, 'message' => 'Erro ao salvar as informações na base de dados.', 'code' => $th->getCode(), 'error' => $th->getMessage()], 500);
    }
}
