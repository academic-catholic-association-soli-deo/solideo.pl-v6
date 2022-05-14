<?php

class Profiler {
    private static $times = array();
    private static $enabled = false;
    public static function start($name) {
        if(!self::$enabled) return;
        if(isset(self::$times[$name])) throw new Exception("Timer ".$name." was already started.");
        self::$times[$name] = array("s" => microtime(true), "e" => 0);
    }
    
    public static function setEnabled($e) {
        self::$enabled = $e;
    }
    
    public static function stop($name) {
        if(!self::$enabled) return;
        if(!isset(self::$times[$name])) throw new Exception("Timer ".$name." was not started.");
        self::$times[$name]["e"] = microtime(true);
    }
    
    public static function getResults() {
        if(!self::$enabled) return null;
        $out = array();
        foreach(self::$times as $k => $time) {
            $out[$k] = ($time["e"]-$time["s"])*1000;
        }
        return array("times" => $out, "unit" => "ms");
    }
    
    public static function getPrintableResults() {
        if(!self::$enabled) return "";
        return print_r(self::getResults(), true);
    }
}