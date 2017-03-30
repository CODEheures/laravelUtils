<?php

namespace Codeheures\LaravelUtils\Traits\Tools;


trait FilesDirs
{
    /**
     *
     * Return Dir without "//" in string and with "/" at end
     *
     * @return string
     */
    public static function getCleanDir($dir) {
        $cleanDir =  str_replace('//', '/',$dir);
        $cleanDir .= (substr($cleanDir,-1)!=="/") ? '/' : '';
        return $cleanDir;
    }

    /**
     * @param $uri
     * @param $destinationDirectory
     * @return bool|string
     */
    public static function getHTTPFile($uri, $destinationDirectory) {
        set_time_limit(360);

        $existDir = is_dir($destinationDirectory);
        if(!$existDir){
            mkdir($destinationDirectory);
        }

        $fileWriteName = $destinationDirectory . basename($uri);

        $fileRead = @fopen($uri,"rb");
        $fileWrite = @fopen($fileWriteName, 'wb');
        if ($fileRead===false || $fileWrite===false) {
            // error reading or opening file
            return false;
        }

        while(!feof($fileRead))
        {
            $content = @fread($fileRead, 1024*8);
            $success = fwrite($fileWrite, $content);
            if($success===false){
                return false;
            }
        }
        fclose($fileWrite);
        fclose($fileRead);

        return $fileWriteName;
    }

    /**
     * @param $filePath
     * @return bool|int|mixed
     */
    public static function dezipGzFile($filePath) {
        $buffer_size = 4096; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $filePath);

        $fileRead = gzopen($filePath, 'rb');
        $fileWrite = fopen($out_file_name, 'wb');

        if ($fileRead===false || $fileWrite===false) {
            // error reading or opening file
            return false;
        }

        while(!gzeof($fileRead)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            $success = fwrite($fileWrite, gzread($fileRead, $buffer_size));
            if($success===false){
                return $success;
            }
        }

        // Files are done, close files
        fclose($fileWrite);
        gzclose($fileRead);
        return $out_file_name;
    }
}