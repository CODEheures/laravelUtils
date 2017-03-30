<?php

namespace Codeheures\LaravelGeoUtils\Traits;


use Codeheures\LaravelTools\Traits\FilesDirs;

trait GeoIPUpdater
{
    public static function getDbDir () {
        return FilesDirs::getCleanDir(config('geoUtils.destination_directory'));
    }

    /**
     *
     * Update GEOLITE2 MMDB DATABASE file from maxmind.com
     * http://dev.maxmind.com/geoip/geoip2/geolite2/
     * GeoLite2 databases are updated on the first Tuesday of each month.
     * Work with Schedule in App\Console\Kernel
     *      $schedule->call(function(){
     *           try {
     *               $geoIpResult = GeoIPUpdater::updateGeoIpFiles();
     *           } catch (\Exception $e) {
     *               $geoIpResult = false;
     *           }
     *           if(!Storage::disk('logs')->exists('geoIpUpdate.log')){
     *           Storage::disk('logs')->append('geoIpUpdate.log' , 'DATE;RESULT;');
     *           }
     *           Storage::disk('logs')->append('geoIpUpdate.log' , Carbon::now()->toDateTimeString() . ';' . $geoIpResult);
     *      })->monthlyOn(7,'3:57');
     *
     *
     * @return bool
     */
    public static function updateGeoIpFiles() {
        //GET DB & MD5 FILES
        set_time_limit(180);

        $database_gz_filePath = FilesDirs::getHTTPFile(config('geoUtils.uri.mmdb'), self::getDbDir());
        $md5_filePath = FilesDirs::getHTTPFile(config('geoUtils.uri.md5'), self::getDbDir());
        //UNZIP, TEST MD5 & COPY TO VENDOR\PragmaRX\Support\GeoIp;
        if($database_gz_filePath && $md5_filePath){
            $database_filePath= FilesDirs::dezipGzFile($database_gz_filePath);
            if($database_filePath){
                $calc_md5 = md5_file($database_filePath);
                $original_md5 = file_get_contents($md5_filePath);
                if($calc_md5==$original_md5){
                    unlink($database_gz_filePath);
                    unlink($md5_filePath);
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
}