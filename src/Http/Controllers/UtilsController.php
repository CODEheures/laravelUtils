<?php

namespace Codeheures\laravelGeoUtils\Http\Controllers;

use App\Http\Controllers\Controller;
use Codeheures\LaravelGeoUtils\Traits\GeoIPUpdater;
use Codeheures\LaravelGeoUtils\Traits\GeoUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UtilsController extends Controller
{

    use GeoUtils;
    use GeoIPUpdater;

    CONST ALL = 0;
    CONST COUNTRY = 1;
    CONST LOC = 2;

    private function makeResponse($ip=null, Request $request, $type) {
        //Make new response (error by default)
        $response = new Response();
        $response->header('Content-Type','application/json ; charset=UTF-8');
        $response->setStatusCode(500);
        $response->setContent(json_encode(['error'=>'unknow IP']));


        //If Ip==null we use IP of request. If IP request is local we us IP test
        if(is_null($ip)){
            if(filter_var($request->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)
                && filter_var($request->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE))
            {
                $ip = $request->ip();
            } else {
                $ip = config('geoUtils.ipTest');
            }
        }

        //If IP is valid
        if(filter_var($ip, FILTER_VALIDATE_IP)) {
            try {
                switch ($type) {
                    case self::ALL:
                        $result = $this->getGeoByIp($ip);
                        break;
                    case self::COUNTRY:
                        $result = $this->getCountryByIp($ip);
                        break;
                    case self::LOC:
                        $result = $this->getGeoLocByIp($ip);
                        break;
                    default:
                        throw new \Exception('');
                }
                $response->setContent(json_encode($result));
                $response->setStatusCode(200);
            } catch (\Exception $e) { }
        }

        return $response;
    }

    public function geoByIp($ip=null, Request $request) {
        return $this->makeResponse($ip, $request, self::ALL);
    }

    public function geoLocByIp($ip=null, Request $request) {
        return $this->makeResponse($ip, $request, self::LOC);
    }

    public function countryByIp($ip=null, Request $request) {
        return $this->makeResponse($ip, $request, self::COUNTRY);
    }

    public function refreshDb() {
        $response = response()->json(['error' => 'bad report on maxmind db refresh']);
        try {
            $result = $this->updateGeoIpFiles();
        } catch (\Exception $e) {
            return $response;
        }
        return $result ? response()->json(['success' => 'maxmind db is refresh']) : $response;
    }
}