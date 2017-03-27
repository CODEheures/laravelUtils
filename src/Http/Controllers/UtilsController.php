<?php

namespace Codeheures\laravelGeoUtils\Http\Controllers;



use App\Http\Controllers\Controller;
use Codeheures\LaravelGeoUtils\Traits\GeoIPUpdater;
use Codeheures\LaravelGeoUtils\Traits\GeoUtils;
use Illuminate\Http\Response;

class UtilsController extends Controller
{

    use GeoUtils;
    use GeoIPUpdater;

    public function geoByIp($ip=null) {
        $response = new Response();
        $response->header('Content-Type','application/json ; charset=UTF-8');
        if(is_null($ip) || !filter_var($ip, FILTER_VALIDATE_IP)){
            $response->setStatusCode(500);
            $response->setContent(json_encode([]));
        } else {
            $response->setStatusCode(200);
            $result = $this->getGeoByIp($ip);
            $response->setContent(json_encode($result));
        }
        return $response;
    }

    public function refreshDb() {
        $result = $this->updateGeoIpFiles();
        return response()->json($result);
    }
}