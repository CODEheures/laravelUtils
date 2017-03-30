## laravel-utils ## 
 
- Get Geoloc by Ip
```
    Geo Loc Tool
    http://yourproject/geoUtils/geoByIp/82.246.117.210 or http://yourproject/geoUtils/geoByIp
        => {"ip":"82.246.117.210","city":"Joué-lès-Tours","region":"Centre","country":"FR","loc":"47.3522,0.6691","postal":"37300"}
    http://yourproject/geoUtils/geoLocByIp
        => ["47.3522","0.6691"]
    http://yourproject/geoUtils/countryByIp
        => "FR"
        => {"error":"unknow IP"}
```

- Ip Tools
```
    Codeheures\LaravelUtils\Traits\Tools\Ip::getNonPrivateIpByRequest($request, '82.246.117.210')); 
        => your IP if non locale or param 2
    Codeheures\LaravelUtils\Traits\Tools\Ip::getNonPrivateIpByRequest($request)); 
        => your IP if non locale or a static IP
```

- Browser Tools
```
    Codeheures\LaravelUtils\Traits\Tools\Browser::getBrowserName(); 
        => the name of the browser
```

- Database Tools
```
    Codeheures\LaravelUtils\Traits\Tools\Database::getEnumValues('myTable','myColumn'); 
        => array [enum1, enum2,...]
    Codeheures\LaravelUtils\Traits\Tools\Database::getCountItems('myTable',['whereKey1'=>'whereValue1', ...]); 
        => count elem
```

- Locale Tools
```
    Codeheures\LaravelUtils\Traits\Tools\Locale::listLocales();
        => array of available locales on server
    Codeheures\LaravelUtils\Traits\Tools\Locale::existLocale('fr_FR');
        => true if available on server
    Codeheures\LaravelUtils\Traits\Tools\Locale::getFirstLocaleByCountryCode('ca');
        => 'en_CA'
    Codeheures\LaravelUtils\Traits\Tools\Locale::composeLocale('fr', 'CA');
        => 'fr_CA' if exist on server or null
       
```

- Currencies Tools
```
    Codeheures\LaravelUtils\Traits\Tools\Currencies::isAvailableCurrency("EUR")
        => True
    Codeheures\LaravelUtils\Traits\Tools\Currencies::getSubUnit("EUR")
        => 2
    Codeheures\LaravelUtils\Traits\Tools\Currencies::listCurrencies("fr")
        => Array of currency according to locale
    Codeheures\LaravelUtils\Traits\Tools\Currencies::getSymbolByCurrencyCode("CAD", "fr)
        => $CA
    Codeheures\LaravelUtils\Traits\Tools\Currencies::getDefaultMoneyByComposeLocale("fr_CA")
        => CAD
```

- Set automatique best locale
- Save Runtime best locale, runtime currency in config('runtime.xxx') parameter

 
  
### Installation ###
 
- Add laravel-utils to your composer.json file to require laravel-utils :
```
    require : {
        "laravel/framework": "5.4.*",
        "codeheures/laravel-utils": "^1.0"
    }
```
 
- Update Composer :
```
    composer update
```
 
- add the service provider to config/app.php :
```
    Codeheures\LaravelUtils\LaravelUtilsServiceProvider::class,
```

- add middlewares to web routes in app/Http/kernel.php:

```
protected $middlewareGroups = [
        'web' => [
            ...
            \Codeheures\LaravelUtils\Http\Middleware\RuntimeIp::class,
            \Codeheures\LaravelUtils\Http\Middleware\RuntimeLocale::class,
        ],
```

- Publish the config file config/codeheuresUtils.php:
```
    php artisan vendor:publish --provider="Codeheures\LaravelUtils\LaravelUtilsServiceProvider"
```
In config file you can change routes uri, routes names and value of Ip test, list of availables locales

- Optionnal: add "locale" atribute to User to manage saving preferences locale in your app


### Before first use we update maxmind db ###
```
    http://yourproject/geoIp/refreshDb
``` 
Congratulations, you have successfully installed laravel-geo-utils !

### Copyright and Licence ###

This product includes GeoLite2 data created by MaxMind, available from
<a href="http://www.maxmind.com">http://www.maxmind.com</a>.

This product use GeoIp2 on apache2 Licence
<a href="https://github.com/maxmind/GeoIP2-php">https://github.com/maxmind/GeoIP2-php</a>.

This software is provided "as is" without warranty of any kind, either express or implied, regarding the software package, its merchantability, or its fitness for any particular purpose. 

This is free software, licensed under the Apache License, Version 2.0.