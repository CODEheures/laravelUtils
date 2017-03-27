## laravel-geo-utils ## 
 
### Example Use ###
```
    http://yourproject/geoUtils/geoByIp/82.246.117.210 or http://yourproject/geoUtils/geoByIp
    http://yourproject/geoUtils/geoLocByIp
    http://yourproject/geoUtils/countryByIp
```
### Results is json_encode response ###
```json
    {"ip":"82.246.117.210","city":"Joué-lès-Tours","region":"Centre","country":"FR","loc":"47.3522,0.6691","postal":"37300"}
```
```json
    ["47.3522","0.6691"]
```
```json
    "FR"
```
or error
```json
    {"error":"unknow IP"}
```
 
 
### Installation ###
 
Add laravel-geo-utils to your composer.json file to require laravel-geo-utils :
```
    require : {
        "laravel/framework": "5.4.*",
        "codeheures/laravel-geo-utils": "dev-master"
    }
```
 
Update Composer :
```
    composer update
```
 
The next required step is to add the service provider to config/app.php :
```
    Codeheures\LaravelGeoUtils\LaravelGeoUtilsServiceProvider::class,
```

Publish the config file config/geoUtils.php:
```
    php artisan vendor:publish --provider="Codeheures\LaravelGeoUtils\LaravelGeoUtilsServiceProvider"
```
In config file you can change routes uri, routes names and value of Ip test


### Before first use we update maxmind db ###
```
    http://yourproject/geoUtils/refreshDb
``` 
Congratulations, you have successfully installed laravel-geo-utils !

### Copyright and Licence ###

This product includes GeoLite2 data created by MaxMind, available from
<a href="http://www.maxmind.com">http://www.maxmind.com</a>.

This product use GeoIp2 on apache2 Licence
<a href="https://github.com/maxmind/GeoIP2-php">https://github.com/maxmind/GeoIP2-php</a>.

This software is provided "as is" without warranty of any kind, either express or implied, regarding the software package, its merchantability, or its fitness for any particular purpose. 

This is free software, licensed under the Apache License, Version 2.0.