# laravel-utils # 
 
Laravel-utils is a toolbox that allow:

 - API to get geolocation informations of client by ip. Usable for server-side processing
 - PHP tool to get a valid public IP (useful on a devel environment)
 - PHP tool to get browser infos
 - PHP tool to get database enum list, or get count items with a reusable mutiple where (=) clause
 - Middleware to to share config('runtime.ip') variable (base on PHP tool to get valid public IP)
 - Middleware to obtain automatically the best locale for your client and share it on your application by a config('runtime.locale') variable
 - Middleware to obtain automatically the best currency for your client and share it on your application by a config('runtime.currency') variable
  
 
API: Geolocation Informations by Ip
-----------------------------------
This API allow you to serve geolocation infos to client (useful for xhtmlrequests). \
You can also use static function for a server side processing.


### Get complete informations
with Ip on URL
````
http://yourproject/geoIp/geoByIp/82.246.117.210
````
````json
//result example
{"ip":"82.246.117.210","city":"Joué-lès-Tours","region":"Centre","country":"FR","loc":"47.3522,0.6691","postal":"37300"}
````
without Ip : try first to use your public Ip. If not public, try to use config('codeheuresUtils.ipTest').
If not available Ip finally use a static IP 
````    
http://yourproject/geoIp/geoByIp
````
````json
//result example
{"ip":"82.246.117.210","city":"Joué-lès-Tours","region":"Centre","country":"FR","loc":"47.3522,0.6691","postal":"37300"}
````
### Get only LOC [latitutde, longitude] informations
With or without IP on url (see above)
````
http://yourproject/geoIp/geoLocByIp
````
````json
//result example
["47.3522","0.6691"]
````
### Get only Country informations
With or without IP on url (see above)
````
http://yourproject/geoIp/countryByIp
````
````json
//result example
"FR"
````
### If error
````json
//result example
{"error":"unknow IP"}
````

PHP Tool: Geolocation Informations by Ip
----------------------------------------
### You can use statics class for a side-server processing
````php
$ip = "82.246.117.210"
if(filter_var($ip, FILTER_VALIDATE_IP)) {
            try {
                    [
                        'all_infos' => Codeheures\LaravelUtils\Traits\Geo\GeoUtils::getGeoByIp($ip),
                        'loc_infos' => Codeheures\LaravelUtils\Traits\Geo\GeoUtils::getGeoLocByIp($ip),
                        'country_info' => Codeheures\LaravelUtils\Traits\Geo\GeoUtils::getCountryByIp($ip)
                    ]
            } catch(...) { ...}
}            
````
````php
//result example
[
    'all_infos' => ["ip"=>"82.246.117.210","city"=>"Joué-lès-Tours","region"=>"Centre","country"=>"FR","loc"=>"47.3522,0.6691","postal"=>"37300"],
    'loc_infos' => ["47.3522","0.6691"],
    'country_info' => "FR"
]
````
PHP Tool: Get valid public IP
-----------------------------
with only request: return your IP if public or the static class var Ip
````php
$ip = Codeheures\LaravelUtils\Traits\Tools\Ip::getNonPrivateIpByRequest($request)); 
````
````php
//result example
"82.246.117.210"
````
with a second param: return your IP if public, or param if public IP, or finally the static class var Ip
````php
$ip = Codeheures\LaravelUtils\Traits\Tools\Ip::getNonPrivateIpByRequest($request, '82.246.117.210')); 
````
````php
//result example
"82.246.117.210"
````

PHP Tool: Get the Browser Name
------------------------------
````php
$browser = Codeheures\LaravelUtils\Traits\Tools\Browser::getBrowserName(); 
````
````php
//result example
"chrome"
````

PHP Tool: Get Database Infos
----------------------------

### get list of enum values for a column of a table
Example: get the enum values of the currencies column of the priceTable
````php
$listEnumValues = Codeheures\LaravelUtils\Traits\Tools\Database::getEnumValues('priceTable','currencies');
````
````php
//result example
['dollard', 'euro', 'yen', 'bitcoins']
````

### get easy count elem on a table with multiple count where
The where clauses is a equal clauses
````php
Codeheures\LaravelUtils\Traits\Tools\Database::getCountItems('customer',['name'=>'paul', 'age'=>'18']); 
````
````php
//result example
172
````

PHP Tool: Locale Tools
----------------------

Locale Tools allow you to obtain various information of locales.
This suite of tools is used in a powerful middleware to find the best locale adapted to the user.
When the middleware find the best locale, this is shared in a config('runtime.locale') variable accessible throughout
the application. You can use it to translate your application for the user.

### Array of locales availables on the server
without restriction of availables languages (find in codeheuresUtils.availableLocales config file):
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::listLocales();
````
````php
//result example
[    "af" => [
        "code" => "af",
        "name" => "afrikaans",
        "region" => ""
      ],
      "af_NA" => [
        "code" => "af_NA",
        "name" => "afrikaans (Namibie)",
        "region" => "namibie"
      ],
      ...
]      
````
with restriction:
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::listLocales();
````
````php
//result example
[       
       "en" => [
         "code" => "en",
         "name" => "anglais",
         "region" => ""
       ]
       "en_001" => [
         "code" => "en_001",
         "name" => "anglais (Monde)",
         "region" => "monde"
       ]
       "en_150" => [
         "code" => "en_150",
         "name" => "anglais (Europe)",
         "region" => "europe"
       ]     
      ...
]     
````

### Boolean test if a locale is an available locale
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::existLocale('fr_FR');
````
````php
//result example
true
````

### Test if a locale is an valid locale and return locale or null
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::isValidLocale('fr_FR');
````
````php
//result example
"fr_FR"
````

### Get the first possible locale by a country code 
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::getFirstLocaleByCountryCode('ca');
````
````php
//result example
"en_CA"
````

### Compose a locale and return if exist, null if don't exist 
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::composeLocale('fr', 'CA');
````
````php
//result example
"fr_CA"
````

### Get default Locale within env('DEFAULT_LOCALE') or static var $last_fall_locale 
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::getDefaultLocale();
````
````php
//result example
"en_US"
````

PHP Tool: Currencies Tools
--------------------------

Currencies Tools allow you to obtain various information of currencies. It use MoneyPhp and config('runtime.locale')
This suite of tools is used in a powerful middleware to find the best currency adapted to the user.
When the middleware find the best currency, this is shared in a config('runtime.currency') variable accessible throughout
the application. You can use it to manage prices in your application.

### Test if a currency exist
````php
Codeheures\LaravelUtils\Traits\Tools\Currencies::isAvailableCurrency("EUR")
````
````php
//result example
true
````

### Get subunit of a currency (if exist else return 0)
````php
Codeheures\LaravelUtils\Traits\Tools\Currencies::getSubUnit("EUR")
````
````php
//result example
2
````

### Get list of currencies with symbol according to a locale
````php
Codeheures\LaravelUtils\Traits\Tools\Currencies::listCurrencies("fr_CA")
````
````php
//result example
[
    "XAF" => [
      "code" => "XAF",
      "symbol" => "XAF",
      "subunit" => 0
    ],
    "CAD" => [
      "code" => "CAD",
      "symbol" => "$",
      "subunit" => 2
    ],
    ...
]    
````

### Get symbol by currency code and locale
````php
Codeheures\LaravelUtils\Traits\Tools\Currencies::getSymbolByCurrencyCode("CAD", "fr)
````
````php
//result example
"$CA" 
````

### Get default money by a compose local (the second param is a fallback currency)
````php
Codeheures\LaravelUtils\Traits\Tools\Currencies::getDefaultMoneyByComposeLocale("fr_CA", "EUR")
````
````php
//result example
"CAD" 
````

### Get default Currency within env('DEFAULT_CURRENCY') or static var $last_fall_currency 
````php
Codeheures\LaravelUtils\Traits\Tools\Locale::getDefaultCurrency();
````
````php
//result example
"EUR"
````

Middleware: config('runtime.ip'), config('runtime.locale') & config('runtime.currency')
---------------------------------------------------------------------------------------

Installation of middlawares allow you to use config('runtime.ip'), config('runtime.locale') & config('runtime.currency')
all over the application controllers ans views.

config('runtime.locale') & config('runtime.currency') can be saved and read in User attribute 'locale' & 'currency'

````php
config('runtime.ip') //your public Ip or fallback ip (see above PHP Tool: Get valid public IP)
config('runtime.locale') //the RuntimeLocale middlware look for the best local and assign to this
config('runtime.currency') //the RuntimeLocale middlware look for the best currecny and assign to this
````

  
# Installation #
 
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

- add middlewares to web routes in app/Http/kernel.php (respect order IP->Locale->Currency). Middleware SetLocaleByRuntime
is optionnal and allow you to set your app locale automatically base on the detect best locale.:

```
protected $middlewareGroups = [
        'web' => [
            ...
            \Codeheures\LaravelUtils\Http\Middleware\RuntimeIp::class,       
            \Codeheures\LaravelUtils\Http\Middleware\RuntimeLocale::class,   
            \Codeheures\LaravelUtils\Http\Middleware\RuntimeCurrency::class,
            \Codeheures\LaravelUtils\Http\Middleware\SetLocaleByRuntime::class, //optionnal
        ],
```

- Publish the config file config/codeheuresUtils.php:
```
    php artisan vendor:publish --provider="Codeheures\LaravelUtils\LaravelUtilsServiceProvider"
```
In config file you can change 
- routes uri, 
- routes names 
- routes middlwares (Add a admin type middleware to refreshDb is highly advised)
- value of Ip test
- list of availables locales

Optionnal: add "locale" and/or "currency" attribute to User to manage saving preferences locale in your app


### Before first use we update maxmind db ###
```
    http://yourproject/geoIp/refreshDb
``` 
Congratulations, you have successfully installed laravel-utils !

### Copyright and Licence ###

This product includes GeoLite2 data created by MaxMind, available from
<a href="http://www.maxmind.com">http://www.maxmind.com</a>.

This product use GeoIp2 on apache2 Licence
<a href="https://github.com/maxmind/GeoIP2-php">https://github.com/maxmind/GeoIP2-php</a>.

This product use Moneyphp on MIT Licence
<a href="https://github.com/moneyphp/money">https://github.com/moneyphp/money</a>.

This software is provided "as is" without warranty of any kind, either express or implied, regarding the software package, its merchantability, or its fitness for any particular purpose. 

This is free software, licensed under the Apache License, Version 2.0.