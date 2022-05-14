<?php

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__ . '/../../Strona');

define('HOST', 'https://solideo.pl');

set_time_limit(15);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('session.use_cookies', '0');



require_once __DIR__ . '/../lib/Urlizer.php';
require_once __DIR__ . '/../lib/util.php';

function fillArrayWithFileNodes(DirectoryIterator $dir, $relativePath, &$pages) {
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $relativePath . "/" . $node->getFilename(), $pages);
        } else if ($node->isFile()) {
            if ($node->getFilename() == "settings.json") {//if dir has settings.json — multi page
                $pages[($relativePath == "" ? "/" : $relativePath)] = array("relative-path" => $relativePath, "settings" => json_decode(file_get_contents($node->getPathname()), true));
            } else if ($node->getExtension() == "txt" && $relativePath != "") {//if dir has *.txt -> single page. Prevent from categorising home as single page
                $pages[$relativePath] = array("relative-path" => $relativePath, "settings" => array("type" => "single"));
            }
        }
    }
}

$pages = array();
fillArrayWithFileNodes(new DirectoryIterator(CONTENT_DIRECTORY_PATH), "", $pages);
ksort($pages);
array_reverse($pages);

header("Content-type: text/html; charset=utf-8");

$output = "";

foreach ($pages as $relativePath => $page) {
    
    $urlModeOld = substr(Urlizer::pathToUrl($relativePath), 1);
    $urlModeNew = substr(Urlizer::pathToUrlMb($relativePath), 1);
    
    if($urlModeNew !== $urlModeOld) {
        $output .= '    "'.$urlModeOld."\" => \"".$urlModeNew."\",\n";
    }
    
    
}
echo $output;
?>

