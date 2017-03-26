<?php

namespace Codeheures\laravelGeoUtils\Http\Controllers;



use App\Http\Controllers\Controller;
use Codeheures\LaravelGeoUtils\Traits\GeoUtils;
use Illuminate\Http\Response;

class UtilsController extends Controller
{

    use GeoUtils;


    public function geoByIp($ip=null) {
        $result = $this->getGeoByIp($ip);
        $response = new Response();
        $response->header('Content-Type','application/json ; charset=UTF-8');
        $response->setContent(json_encode($result));
        $response->setStatusCode(200);
        return $response;
    }
}