<?php

if(!file_exists("tmp")) {
    mkdir("tmp");
}

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__ . '/Strona');

define('HOST', 'https://solideo.pl');
define('SITEMAP_CACHE_FILE_PATH', __DIR__ . "/sitemap-cache.xml");

set_time_limit(30);
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
ini_set('session.use_cookies', '0');


require_once __DIR__ . '/php/lib/LoadableMd.php';
require_once __DIR__ . '/php/lib/Urlizer.php';
require_once __DIR__ . '/php/lib/util.php';

function fillArrayWithFileNodes(DirectoryIterator $dir, $relativePath, &$pages) {
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $relativePath . "/" . $node->getFilename(), $pages);
        } else if ($node->isFile()) {
            if ($node->getFilename() == "settings.json") {//if dir has settings.json — multi page
                $settings = json_decode(file_get_contents($node->getPathname()), true);
                $pages[($relativePath == "" ? "/" : Urlizer::pathToUrl($relativePath))] = array("relative-path" => $relativePath, "settings" => $settings);
            } else if ($node->getExtension() == "txt" && $relativePath != "") {//if dir has *.txt -> single page. Prevent from categorising home as single page
                $settings = array("type" => "single");
                if (file_exists(dirname($node->getPathname()) . "/settings.json")) {
                    $settings = json_decode(file_get_contents(dirname($node->getPathname()) . "/settings.json"), true);
                }
                $pages[Urlizer::pathToUrl($relativePath)] = array("relative-path" => $relativePath, "settings" => $settings, "md-path" => $node->getPathname());
            }
        }
    }
}

$pages = array();
fillArrayWithFileNodes(new DirectoryIterator(CONTENT_DIRECTORY_PATH), "", $pages);
ksort($pages);
array_reverse($pages);


foreach ($pages as $url => $page) {
    //$relativePath = $page['relative-path'];
    //$settings = $page['settings'];

    echo $url . " => ";
    print_r($page);
    echo "\n";
    
    /*if (isset($settings['sitemap-skip']) && $settings['sitemap-skip'] === true) {
        continue;
    }
    $output .= '<url>';
    //$output .= '<!-- settings: '.json_encode($settings).'-->';
    $output .= ' <loc>' . HOST . $url . '</loc>';
    $output .= '<lastmod>' . date("c", filemtime(CONTENT_DIRECTORY_PATH . $relativePath)) . '</lastmod>';
    if (isset($settings['sitemap-priority'])) {
        $output .= '<priority>' . $settings['sitemap-priority'] . '</priority>';
    } else if ($settings['type'] == "single") {//single page
        $output .= '<priority>0.6</priority>';
    } else {
        $output .= '<priority>0.4</priority>'; //list page
    }

    if (isset($settings['sitemap-changefreq'])) {
        $output .= '<changefreq>' . $settings['sitemap-changefreq'] . '</changefreq>';
    } else if (strpos($url, date('Y')) !== false) {//if contains current year in url => daily
        $output .= '<changefreq>daily</changefreq>';
    } else {
        $output .= '<changefreq>yearly</changefreq>';
    }

    if ((isset($_GET['generateCache']) || defined("GENERATE_CACHE")) && isset($page['md-path'])) {
        //echo("<!--relativePath=".$page['relative-path']."<br />-->\n");
        CacheManager::clearMyCache($page['md-path']);
        $md = new LoadableMd($page['md-path'], CONTENT_DIRECTORY.$page['relative-path'], $settings);
        $md->loadContent(false);
    }

    $output .= '</url>';*/
}

?>

