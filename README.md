## LaravelGeoUtils ## 
 
### Installation ###
 
Add LaravelGeoUtils to your composer.json file to require LaravelGeoUtils :
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
 
Congratulations, you have successfully installed LaravelGeoUtils !

### Use ###
```
http://yourproject/geoByIp
```

### Copyright and Licence ###

This product includes GeoLite2 data created by MaxMind, available from
<a href="http://www.maxmind.com">http://www.maxmind.com</a>.

This product use GeoIp2 on apache2 Licence
<a href="https://github.com/maxmind/GeoIP2-php">https://github.com/maxmind/GeoIP2-php</a>.

This is free software, licensed under the Apache License, Version 2.0.