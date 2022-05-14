<?php
class CacheManager {
    private static $timeStampVarId = 1;
    private static $secretVarId = 2;
    private static $dataVarId = 3;
    private static $compressVarId = 4;
    
    private static function lock($fToken) {
        $sem = sem_get($fToken, 1, 0644, 1);
        if($sem === FALSE) {
            return false;
        }
        if(sem_acquire($sem)) {
            return $sem;
        }
        else return false;
    }
    
    private static function unlock($lockingSem) {
        if($lockingSem !== null) {
            sem_release($lockingSem);
        }
    }
    
    private static function closeShm($shm, $deleteAll) {
        if($shm !== null) {
            if($deleteAll) {
                shm_remove($shm);
            }
            shm_detach ($shm);
        }
    }
    
    private static function generateSecret($filePath, $secretPart) {
        return md5($filePath.$secretPart.date('W'));//invalidate each monday
    }
    
    public static function getMyCache($file, $secretPart, $expirationTime, $dataAllocationSize = 10000) { 
        $key = ftok($file, 'c');
        if($key === -1) {
            if(isset($_GET['cacheDebug'])) echo "<!-- ftok failes -->\n";
            return null;
        }
        $lock = self::lock($key);
        if($lock === false) {
            if(isset($_GET['cacheDebug'])) echo "<!-- lock failed -->\n";
            return null;
        }
        return null;
        $shm = shm_attach($key, $dataAllocationSize);
        if($shm === null) {
            if(isset($_GET['cacheDebug'])) echo "<!-- shm_attach failed -->\n";
            self::unlock($lock);
            return null;
        }
        
        if(!(shm_has_var($shm, self::$dataVarId) && shm_has_var($shm, self::$secretVarId) && shm_has_var($shm, self::$timeStampVarId))) {
           if(isset($_GET['cacheDebug'])) echo "<!-- missing variables ("
               . "dataVar=".shm_has_var($shm, self::$dataVarId).", "
               . "secretVar=".shm_has_var($shm, self::$secretVarId).", "
               . "timeStampVar=".shm_has_var($shm, self::$timeStampVarId).") for ".$file." -->\n";
           self::closeShm($shm, true);
           self::unlock($lock);
           return null; 
        }
        
        $timestamp = shm_get_var($shm, self::$timeStampVarId);
        if($timestamp < time()-$expirationTime) {
            if(isset($_GET['cacheDebug'])) echo "<!-- Shm block expired -->\n";
            self::closeShm($shm, true);
            self::unlock($lock);
            return null;
        }
        
        $secret = self::generateSecret($file, $secretPart);
        if(shm_get_var($shm, self::$secretVarId) !== $secret) {
            if(isset($_GET['cacheDebug']))  echo "<!-- Shm block has invalid secret -->\n";
            self::closeShm($shm, true);
            self::unlock($lock);
            return null;
        }
        
        $retrivedData = shm_get_var($shm, self::$dataVarId);
        
        if(shm_has_var($shm, self::$compressVarId)) {
            if(shm_get_var($shm, self::$compressVarId) == true) {
                $retrivedData = gzuncompress($retrivedData);
            }
        }
        
        $data = @unserialize($retrivedData);
        if($data === false) {
            if(isset($_GET['cacheDebug'])) echo "<!-- Invalid data -->\n";
            self::closeShm($shm, true);
            self::unlock($lock);
            return null;
        }
        
        self::closeShm($shm, false);
        self::unlock($lock);
        
        //if(isset($_GET['cacheDebug'])) echo("<!-- Read from ".$file." -->\n");
        return $data;        
    }
    
    public static function setMyCache($file, $secretPart, $data) {      
        $key = ftok($file, 'c');
        if($key === -1) {
            if(isset($_GET['cacheDebug'])) echo "<!-- ftok failes -->\n";
            return false;
        }
        
        $dataSerialized = serialize($data);
        $dataAllocationSize = 10000;//strlen($dataSerialized)+10;
        
        $compress = false;
        
        if(strlen($dataSerialized)+10 > $dataAllocationSize) {
            $dataBeforeCompress = $dataSerialized;
            $dataSerialized = gzcompress($dataSerialized);
            $compress = true;
            
            if(strlen($dataSerialized)+10 > $dataAllocationSize) {
                if(isset($_GET['cacheDebug'])) echo "<!-- File ".$file." too big to be cached-->\n";
                if(isset($_GET['verboseTooBig'])) echo("<!-- ===== VERBOSING TOO BIG FILE $file: =====\n".$dataBeforeCompress."\n======================\n\n");
                return false;
            }
        }
        
        $lock = self::lock($key);
        if($lock === false) {
            if(isset($_GET['cacheDebug'])) echo "<!-- lock failed-->\n";
            return false;
        }        
        return null;
        $shm = shm_attach($key, $dataAllocationSize);
        if($shm === null) {
            if(isset($_GET['cacheDebug'])) echo "<!-- shm_attach failed -->\n";
            self::unlock($lock);
            return false;
        }
        
        shm_put_var($shm, self::$timeStampVarId, time());
        shm_put_var($shm, self::$secretVarId, self::generateSecret($file, $secretPart));
        shm_put_var($shm, self::$dataVarId, $dataSerialized);
        shm_put_var($shm, self::$compressVarId, $compress);
        
        
        self::closeShm($shm, false);
        self::unlock($lock);
        if(isset($_GET['cacheDebug'])) echo("<!-- Written to  ".$file." -->\n");
        return true;    
    }
    
    public static function clearMyCache($file) {
        $key = ftok($file, 'c');
        if($key === -1) {
            if(isset($_GET['cacheDebug']))  echo "<!-- ftok failes -->\n";
            return false;
        }
        $lock = self::lock($key);
        if($lock === false) {
            if(isset($_GET['cacheDebug'])) echo "<!-- lock failed -->\n";
            return false;
        }
        return null;
        $shm = shm_attach($key);
        if($shm === null) {
            if(isset($_GET['cacheDebug']))  echo "<!-- shm_attach failed -->\n";
            self::unlock($lock);
            return false;
        }
        
        self::closeShm($shm, true);
        self::unlock($lock);
        return true;    
    }
}					