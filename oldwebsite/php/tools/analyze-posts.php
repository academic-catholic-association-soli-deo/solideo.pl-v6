<?php
die(); //disabled

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__ . '/../../Strona');

set_time_limit(35);
error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once __DIR__ . '/../lib/Urlizer.php';
require_once __DIR__ . '/../lib/util.php';

function fillArrayWithFileNodes(DirectoryIterator $dir, $relativePath, &$pages) {
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $relativePath . "/" . $node->getFilename(), $pages);
        } else if ($node->isFile()) {
            if ($node->getFilename() == "settings.json") {//if dir has settings.json — multi page
                $pages[($relativePath == "" ? "/" : Urlizer::pathToUrl($relativePath))] = array("relative-path" => $relativePath, "settings" => json_decode(file_get_contents($node->getPathname()), true));
            } else if ($node->getExtension() == "txt" && $relativePath != "") {//if dir has *.txt -> single page. Prevent from categorising home as single page
                $pages[Urlizer::pathToUrl($relativePath)] = array("relative-path" => $relativePath, "settings" => array("type" => "single"), "txt-path" => $node->getPathname());
            }
        }
    }
}

$pages = array();
fillArrayWithFileNodes(new DirectoryIterator(CONTENT_DIRECTORY_PATH), "", $pages);
ksort($pages);
array_reverse($pages);
shuffle($pages);

echo "<h1>POST ANALYZER</h1>";
echo "<hr /><br /><br/>";
echo "<ol>";
echo("\n\n\n");
//$i = 0;
foreach($pages as $page) {
    if(isset($page['txt-path'])) {
        $txtPath = $page['txt-path'];
        moveImagesToTop($txtPath);
        //echo "\n<hr />\n\n\n\n\n";
        //if($i > 50) break;
        //$i++;
        /*$content = file_get_contents($txtPath);
        $content = preg_replace("/^#.*$/muUi", "", $content);
        $content = preg_replace("/<\!--(.*)+-->/muUi", "", $content);
        $content = preg_replace("/<time>(.*)<\/time>/muUi", "", $content);
        
        
        $editorLink = "https://new.asksolideo.pl/editor/#".str_replace(CONTENT_DIRECTORY_PATH, "", $page['relative-path']);
        
        $hasQuotes = false;//(strpos($content, "\"") !== FALSE);
        $hasBBCode = (strpos($content, "[") !== FALSE);
        $hasTags = (strpos($content, "<") !== FALSE);
        //if ($hasQuotes || $hasBBCode || $hasTags){
        //    echo("<li>".$txtPath." has ".($hasQuotes? "[quotes]" : "").($hasTags? "[tags]" : "").($hasBBCode? " [bbcode]" : "").": <a href=\"".$editorLink."\">edit</a></li>\n");
        //}
        
        if($hasBBCode) {
            $modified = removeBBCode($txtPath);
            if($modified) echo("<li>".str_replace(CONTENT_DIRECTORY_PATH, "", $page['relative-path'])." had bbcode removed.</li>");
        }*/
        
    }
}
echo "</ol>";

function moveImagesToTop($txtPath) {
    $initialContent = file_get_contents($txtPath);
    $content = $initialContent;
    
    preg_match_all("/\!\[[^\]]+\]\([^\)]+\)/miuU", $content, $images);
    preg_match_all("/<\!--\{\{json(.*)-->/miuU", $content, $jsons);
    
    if(count($images[0]) > 0) {
        $content = str_replace($images[0][0], "", $content);
        $content = $images[0][0]."\n".$content;
    }
    
    if(count($jsons[0]) > 0) {
        $content = str_replace($jsons[0][0], "", $content);
        $content = $content."\n\n".$jsons[0][0]."\n";
    }
    
    file_put_contents($txtPath, $content);
    
    /*if($content == $initialContent) return false;
    else return true;*/
    
    //return $content;
}