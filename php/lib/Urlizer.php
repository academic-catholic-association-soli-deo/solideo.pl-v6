<?php
define('URLIZER_CHARTABLE', array(
    "ą" => "a",
    "ę" => "e",
    "ś" => "s",
    "ć" => "c",
    "ó" => "o",
    "ń" => "n",
    "ź" => "z",
    "ż" => "z",
    "ł" => "l",
    "'" => "",
    "\"" => "",
    "---" => "-",
    "\u2014" => "-",
    "\u2013" => "-",
    "[" => "",
    "]" => ""
));

class Urlizer {
    
    public static function pathToUrl($path) {
        $url = str_replace(" ", "-", Normalizer::normalize(mb_strtolower($path)));
        $url = str_replace("quot", "", $url);
        $url = strtr($url, URLIZER_CHARTABLE);
        $url = preg_replace("/[^\x01-\x7F]/u", "-", $url);
        
        while(strpos($url, "--") !== FALSE) {
            $url = str_replace("--", "-", $url);
        }
        
         //remove non-ascii characters
        if(substr($url, -1) == "-") $url = substr($url, 0, -1);
        return $url;
    }

    public static function urlEquals($urlA, $urlB) {
        return Urlizer::pathToUrl($urlA) == Urlizer::pathToUrl($urlB);
    }

    public static function matchURLElems($root, $pathElems) {
        $element = array_shift($pathElems);
        if ($element == "")
            return Urlizer::matchURLElems($root, $pathElems);

        $files = scandir($root, SCANDIR_SORT_ASCENDING);
        foreach ($files as $filename) {
            if (Urlizer::urlEquals($filename, $element)) {
                if (count($pathElems) == 0) {
                    return $root . "/" . $filename;
                } else {
                    return Urlizer::matchURLElems($root . "/" . $filename, $pathElems);
                }
            }
        }
        return null;
    }

    public static function matchURL($root, $path) {
        return Urlizer::matchURLElems($root, explode("/", $path));
    }

}