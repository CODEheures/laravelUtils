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
 
Congratulations, you have successfully installed Scafold !

Use:

http://yourproject/geoByIp