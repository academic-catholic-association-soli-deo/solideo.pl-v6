<?php

//die("Disabled");

set_time_limit(2);

error_reporting(E_ALL);
/*
 * Jak najszybciej wyłączyć wyświetlanie błędów na stronie.
 */
ini_set('display_errors', 'On');


//zend_shm_cache_store("hello1", 1);

require_once __DIR__ . "/../lib/CacheManager.php";

$sTime = microtime(true);

for ($i = 0; $i < 10; $i++) {
    echo("<br />\n<br />\n$i:<br />\n");
    CacheManager::clearMyCache(__FILE__);
    $got = CacheManager::getMyCache(__FILE__, "6eytgg6216ssvr", 60 * 2); //2 minutes
    if ($got === null) {
        echo("Nothing got.<br /> \nSaving data...<br />\n\n");
        $myData = "Hello, it's " . date("Y-m-d H:i:s") . " now!\n";
        CacheManager::setMyCache(__FILE__, "6eytgg6216ssvr", $myData);
        $got = CacheManager::getMyCache(__FILE__, "6eytgg6216ssvr", 60 * 2); //2 minutes
    }
    
    echo("Got from cache: \"" . $got . "\"!<br />\n\n");
}

echo("<br />\nTime: " . ((microtime(true) - $sTime) * 1000000) . "us<br />\n<hr />\n<br />\n");




$sTime = microtime(true);

for($i = 0;$i < 10;$i++) {
    $filepath = __DIR__."/test.tmp";
    echo ($filepath."<br />\n\n");
    if(file_exists($filepath)) unlink($filepath);
    
    $handle = fopen($filepath, "w");
    $myData = "Hello, it's " . date("Y-m-d H:i:s") . " now!\n";
    fwrite($handle, $myData);
    fclose($handle);
    
    $handle = fopen($filepath, "r");
    $data = fread($handle, 10000);
    echo("Read: ".$data."<br />\n");
    fclose($handle);
    
    unlink($filepath);
}

echo("<br />\nTime: " . ((microtime(true) - $sTime) * 1000000) . "us<br />\n<hr />\n<br />\n");

