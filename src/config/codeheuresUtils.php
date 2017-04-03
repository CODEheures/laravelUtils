<?php

return [

    'geoIp' => [
        'uri' => [
            'mmdb' => 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz',
            'md5' => 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.md5',
        ],

        'destination_directory' => storage_path('maxmind'),

        'routes' => [
            'prefix' => 'geoIp',
            'geoByIp' => [
                'uri' => 'geoByIp',
                'name' => 'codeheures.geoUtils.getGeoByIp',
                'middlewares' => []
            ],
            'geoLocByIp' => [
                'uri' => 'geoLocByIp',
                'name' => 'codeheures.geoUtils.getGeoLocByIp',
                'middlewares' => []
            ],
            'countryByIp' => [
                'uri' => 'countryByIp',
                'name' => 'codeheures.geoUtils.getCountryByIp',
                'middlewares' => []
            ],
            'refreshDb' => [
                'uri' => 'refreshDb',
                'name' => 'codeheurs.geoUtils.refreshDb',
                'middlewares' => []
            ]
        ],
    ],

    'ipTest' => '82.246.117.210',

    'availableLocales' => [
        'fr',
        'en',
        'es'
    ]
];
