<?php

namespace Codeheures\LaravelGeoUtils\Traits;



use GeoIp2\Database\Reader;

trait GeoUtils
{
    public static function getGeoByIp($ip) {
        $reader = new Reader(__DIR__.'/../maxmind-db/GeoLite2-City.mmdb');
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