<?php

class CachedFilesystem {
    private static $secret = "a82cy62qf";
    
    public static function file_get_contents($path) {
        if(!file_exists($path)) return null;
        $fileContents = CacheManager::getMyCache($path, self::$secret, 3600*2, 4000);
        if($fileContents === null) {
            $fileContents = file_get_contents($path);
            if(strlen($fileContents) > 3999) {
                return $fileContents;
            }
            if(!$fileContents) {
                return $fileContents;
            }
            
            CacheManager::setMyCache($path, self::$secret, $fileContents);
        }
        else {
            //if(isset($_GET['cacheDebug'])) echo("Retrived ".$path." from cache...<br />\n");
        }
        return $fileContents;
    }
}