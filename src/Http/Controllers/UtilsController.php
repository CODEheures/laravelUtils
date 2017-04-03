<?php

namespace Codeheures\LaravelUtils\Http\Controllers;

use App\Http\Controllers\Controller;
use Codeheures\LaravelUtils\Traits\Geo\GeoIPUpdater;
use Codeheures\LaravelUtils\Traits\Geo\GeoUtils;
use Codeheures\LaravelUtils\Traits\Tools\Ip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UtilsController extends Controller
{
    CONST ALL = 0;
    CONST COUNTRY = 1;
    CONST LOC = 2;

    public function __construct() {
        foreach (config('codeheuresUtils.geoIp.routes.geoByIp.middlewares') as $middle) {
            $this->middleware($middle)->only('geoByIp');
        }
        foreach (config('codeheuresUtils.geoIp.routes.geoLocByIp.middlewares') as $middle) {
            $this->middleware($middle)->only('geoLocByIp');
        }
        foreach (config('codeheuresUtils.geoIp.routes.countryByIp.middlewares') as $middle) {
            $this->middleware($middle)->only('countryByIp');
        }
        foreach (config('codeheuresUtils.geoIp.routes.refreshDb.middlewares') as $middle) {
            $this->middleware($middle)->only('refreshDb');
        }
    }



    private function makeResponse($ip=null, Request $request, $type) {
        //Make new response (error by default)
        $response = new Response();
        $response->header('Content-Type','application/json ; charset=UTF-8');
        $response->setStatusCode(500);
        $response->setContent(json_encode(['error'=>'unknow IP']));

        //If Ip==null we use IP of request. If IP request is local we us IP test
        if(is_null($ip)){
            $ip = Ip::getNonPrivateIpByRequest($request, config('codeheuresUtils.ipTest'));
        }

        //If IP is valid
        if(filter_var($ip, FILTER_VALIDATE_IP)) {
            try {
                switch ($type) {
                    case self::ALL:
                        $result = GeoUtils::getGeoByIp($ip);
                        break;
                    case self::COUNTRY:
                        $result = GeoUtils::getCountryByIp($ip);
                        break;
                    case self::LOC:
                        $result = GeoUtils::getGeoLocByIp($ip);
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
            $result = GeoIPUpdater::updateGeoIpFiles();
        } catch (\Exception $e) {
            return $response;
        }
        return $result ? response()->json(['success' => 'maxmind db is refresh']) : $response;
    }
}