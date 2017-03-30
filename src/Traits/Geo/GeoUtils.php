<?php

namespace Codeheures\LaravelUtils\Traits\Geo;


use GeoIp2\Database\Reader;

trait GeoUtils
{
    public static function getGeoByIp($ip) {
        $fileName = substr(basename(config('codeheuresUtils.geoIp.uri.mmdb')), 0, strlen(basename(config('codeheuresUtils.geoIp.uri.mmdb')))-3);
        $reader = new Reader(GeoIPUpdater::getDbDir() . $fileName);
        $record = $reader->city($ip);
        $result = [
            "ip" => $ip,
            "city" => $record->city->name,
            "region" => $record->subdivisions[0]->name,
            "country" => $record->country->isoCode,
            "loc" => $record->location->latitude . ',' . $record->location->longitude,
            "postal" => $record->postal->code
        ];
        return $result;
    }

    public static function getCountryByIp($ip) {
        $details = self::getGeoByIp($ip)['country'];
        return $details;
    }

    public static function getGeoLocByIp($ip) {
        $loc = false;
        $details = self::getGeoByIp($ip);
        if($details){
            $loc = explode(',', $details['loc']);
        }
        return $loc;
    }
}