<?php

namespace App\Http\Utils;
use Illuminate\Support\Facades\Request;

class ServerUtil
{

    /**
     *
     * @return boolean
     */
    public static function isDesenv()
    {
        return ! ServerUtil::isProd();
    }

    /**
     *
     * @return boolean
     */
    public static function isProd()
    {
        if(env('APP_ENV') == 'production'){
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public static function getIpAddress()
    {
        return Request::ip();
    }

}
