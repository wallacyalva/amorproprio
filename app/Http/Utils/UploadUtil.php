<?php

namespace App\Http\Utils;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UploadUtil
{

	/**
	 * Retorna o link para donwload do arquivo
	 * Esse metodo foi criado por que no servidor de produção Linux, não foi possivel utilizar do comando php artisan storage:link para criar um link simbólico
	 * @param string $path Caminho do arquivo
	 * @param int $type 0-publica, 1-Privado(Tabela Files)
	 * return string
	 */
	public static function linkDownloadFile($path, $type=1, $token=null)
	{
		if (empty($path)) {
			return null;
		}

		$urlBase = ServerUtil::isDesenv() ? env('APP_URL') : env('APP_URL_PROD');

		if(!$type){
			return $urlBase."/download-public-file/{$token}";
		}

		if($type>0 && !$token){
			return env('APP_URL_CLIENT');
		}

		if($type == 1){
			return $urlBase.env('APP_URI')."download-private-file/{$token}";
		}

		return $urlBase;

	}

	/**
	 * Deletar Files
	 * @param string $path
	 * @return object
	 */
	public static function deleteFile(string $path):object
	{

		try {

			if (empty($path)) {
				return (object)['status' => true, 'error' => "Não foi enviado nenhum path"];
			}

			if (!Storage::exists($path)) {
				return (object)['status' => true, 'error' => "Arquivo não encontrado ou já foi deletado"];
			}

			Storage::delete($path);
			return (object)['status' => true, 'message' => "Arquivo deletado com sucesso"];
		} catch (\Throwable $th) {
			return (object)[
				'status' => false,
				'error' => "Erro ao deletar o arquivo",
				'code' => $th->getCode(),
				'message' => $th->getMessage()
			];
		}
	}

	/**
	 * Retira qualquer caracteres especiais para o nome do arquivo
	 * @param string $string
	 * @return string
	 */
	public static function cleanCaracters(string $string):string
	{
		$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string); // remove acentos
		return preg_replace('/[^A-Za-z0-9]/', '', $string);  // remove caracteres especiais
	}

}
