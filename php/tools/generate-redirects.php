<?php
die(); //disable

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__ . '/../../Strona');

set_time_limit(10);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('session.use_cookies', '0');

$jom = json_decode(file_get_contents("jom_content.json"), true);

require_once __DIR__ . '/../lib/Urlizer.php';
require_once __DIR__ . '/../lib/util.php';

function fillArrayWithFileNodes(DirectoryIterator $dir, $relativePath, &$pages) {
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $relativePath . "/" . $node->getFilename(), $pages);
        } else if ($node->isFile()) {
            if ($node->getFilename() == "import-data.json") {//has import dala
                $pages[($relativePath == "" ? "/" : Urlizer::pathToUrl($relativePath))] = array("relative-path" => $relativePath, "import-data" => json_decode(file_get_contents($node->getPathname()), true));
            }
        }
    }
}

$pages = array();
fillArrayWithFileNodes(new DirectoryIterator(CONTENT_DIRECTORY_PATH), "", $pages);
ksort($pages);
array_reverse($pages);

$jomByIds = array();
foreach($jom as $jompost) {
    $jomByIds[$jompost['id']] = $jompost;
}

$ids = array();
$duplicates = array();
$notFoundIds = 0;
$notFoundAlias = 0;

foreach($pages as $newRelativePath => $page) {
    if(isset($page['import-data']['after-2013-move']['id'])) {
        $id = $page['import-data']['after-2013-move']['id'];
        
        if(in_array($id, $ids)) {
            if(!isset($duplicates[$id])) $duplicates[$id] = array();
            $duplicates[$id][] = $newRelativePath;
        }
        else {
            $ids[] = $id;
            if(isset($jomByIds[$id]['alias'])) {
                $oldAlias = $jomByIds[$id]['alias'];
                echo '    "'.$oldAlias.'" => "'.$newRelativePath.'",'."\n";
            }
            else $notFoundAlias++;
        }
    }
    else if(isset($page['import-data']['id'])) {
        $id = $page['import-data']['id'];
        
        if(in_array($id, $ids)) {
            if(!isset($duplicates[$id])) $duplicates[$id] = array();
            $duplicates[$id][] = $newRelativePath;
        }
        else {
            $ids[] = $id;
            if(isset($jomByIds[$id]['alias'])) {
                $oldAlias = $jomByIds[$id]['alias'];
                echo '    "'.$oldAlias.'" => "'.$newRelativePath.'",'."\n";
            }
            else $notFoundAlias++;
        }
    }
    else $notFoundIds++;
}
//echo '<p>'.$notFoundIds.' ids not found</p>';
//echo '<p>'.count($duplicates).' duplicates found</p>';
//echo '<p>'.$notFoundAlias.' not found aliases</p>';

//echo '<pre>';
//var_dump($duplicates);
//echo '</pre>';