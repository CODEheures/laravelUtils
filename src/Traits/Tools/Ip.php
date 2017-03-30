<?php

namespace Codeheures\LaravelUtils\Traits\Tools;

use Illuminate\Http\Request;

trait Ip
{
    public static $ipTest = '82.246.117.210';

    public static function getNonPrivateIpByRequest(Request $request, $ipTest=null) {

        if(filter_var($request->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)
            && filter_var($request->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE))
        {
            $ip = $request->ip();
        } else {
            $ip = $ipTest ? $ipTest : self::$ipTest;
        }

        return $ip;
    }
}