<?php

return [

    'geoIp' => [
        'uri' => [
            'mmdb' => 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz',
            'md5' => 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.md5',
        ],

        'destination_directory' => storage_path(''),

        'routes' => [
            'prefix' => 'geoIp',
            'geoByIp' => [
                'uri' => 'geoByIp',
                'name' => 'codeheures.geoUtils.getGeoByIp'
            ],
            'geoLocByIp' => [
                'uri' => 'geoLocByIp',
                'name' => 'codeheures.geoUtils.getGeoLocByIp'
            ],
            'countryByIp' => [
                'uri' => 'countryByIp',
                'name' => 'codeheures.geoUtils.getCountryByIp'
            ],
            'refreshDb' => [
                'uri' => 'refreshDb',
                'name' => 'codeheures.geoUtils.refreshDb'
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