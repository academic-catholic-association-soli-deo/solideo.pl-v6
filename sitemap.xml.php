<?php

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__ . '/Strona');

define('HOST', 'https://solideo.pl');
define('SITEMAP_CACHE_FILE_PATH', __DIR__ . "/sitemap-cache.xml");

set_time_limit(30);
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
ini_set('session.use_cookies', '0');


require_once __DIR__ . '/php/lib/LoadableMd.php';
require_once __DIR__ . '/php/lib/CacheManager.php';
require_once __DIR__ . '/php/lib/CachedFilesystem.php';
require_once __DIR__ . '/php/lib/Urlizer.php';
require_once __DIR__ . '/php/lib/util.php';

function fillArrayWithFileNodes(DirectoryIterator $dir, $relativePath, &$pages) {
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $relativePath . "/" . $node->getFilename(), $pages);
        } else if ($node->isFile()) {
            if ($node->getFilename() == "settings.json") {//if dir has settings.json — multi page
                if (isset($_GET['generateCache']) ||  defined("GENERATE_CACHE")) {
                    CacheManager::clearMyCache($node->getPathname());
                }
                $settings = json_decode(CachedFilesystem::file_get_contents($node->getPathname()), true);
                $pages[($relativePath == "" ? "/" : Urlizer::pathToUrl($relativePath))] = array("relative-path" => $relativePath, "settings" => $settings);
            } else if ($node->getExtension() == "txt" && $relativePath != "") {//if dir has *.txt -> single page. Prevent from categorising home as single page
                $settings = array("type" => "single");
                if (file_exists(dirname($node->getPathname()) . "/settings.json")) {
                    $settings = json_decode(CachedFilesystem::file_get_contents(dirname($node->getPathname()) . "/settings.json"), true);
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

header("Content-type: application/xml; charset=utf-8");

if (!isset($_GET['generateCache']) && !defined("GENERATE_CACHE")) {
    if (file_exists(SITEMAP_CACHE_FILE_PATH)) {
        if (time() - filemtime(SITEMAP_CACHE_FILE_PATH) < 1800) {//generate sitemaps at most every half an hour
            echo file_get_contents(SITEMAP_CACHE_FILE_PATH);
            die();
        }
    }
}

$output = '<?xml version="1.0" encoding="UTF-8"?>';
$output .= "\n";
$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($pages as $url => $page) {
    $relativePath = $page['relative-path'];
    $settings = $page['settings'];

    if (isset($settings['sitemap-skip']) && $settings['sitemap-skip'] === true) {
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

    $output .= '</url>';
}
$output .= '</urlset>';
echo $output;

if (file_exists(SITEMAP_CACHE_FILE_PATH)) {
    unlink(SITEMAP_CACHE_FILE_PATH);
}
file_put_contents(SITEMAP_CACHE_FILE_PATH, $output);
touch(SITEMAP_CACHE_FILE_PATH);
?>

