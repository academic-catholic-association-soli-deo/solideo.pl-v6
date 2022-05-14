<?php
die(); //disabled

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__ . '/../../Strona');

set_time_limit(35);
error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once __DIR__ . '/../lib/Urlizer.php';
require_once __DIR__ . '/../lib/util.php';

function fillArrayWithFileNodes(DirectoryIterator $dir, $relativePath, &$images) {
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $relativePath . "/" . $node->getFilename(), $images);
        } else if ($node->isFile()) {
            if(in_array(strtolower($node->getExtension()), array("jpeg", "jpg", "png", "gif", "tif", "tiff"))) {
                if($node->getSize() > 1024*1024) {
                    $images[] = $node->getPathname();
                }
            }
        }
    }
}

$images = array();
fillArrayWithFileNodes(new DirectoryIterator(CONTENT_DIRECTORY_PATH), "", $images);

echo "<h1>Images > 1MB</h1>";
echo "<hr />";
echo "<ol>";

foreach($images as $imgPath) {
    echo "<li>".$imgPath."</li>";
}
echo "</ol>";