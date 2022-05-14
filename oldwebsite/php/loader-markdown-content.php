<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * 3. Znajdź folder wskazany przez URL
 */

function loadContent($website, $query) {
    $file = str_replace("..", "", $query); //usuwamy sztuczki

    $matchedFile = Urlizer::matchURL(CONTENT_DIRECTORY_PATH, $file);
    if ($matchedFile != null && is_dir($matchedFile)) {
        return loadContentDirectory($website, $matchedFile);
    } else {
        return notFound($query, $website);
    }
}

/*
 * 4. W folderze z treścią może znajdować się pojedynczy plik *.txt. Wtedy jest 
 * to pojedyncza strona. Folder może jednak zawierać plik settings.json, a w nim
 * można określić 'type' jako 'list'. Wtedy folder ładowany jest jako tablica 
 * podstron.
 */

function loadContentDirectory($website, $dir) {
    global $website;
    if(substr(basename($dir), 0, 1) == "_") return notFound(null, null);
    
    $settings = array("type" => "single");
    if (file_exists($dir . "/settings.json")) {
        //if(isset($_GET['cached'])) {
            $settings = json_decode(CachedFilesystem::file_get_contents($dir . "/settings.json"), true);
        //}
        //else {
        //    $settings = json_decode(file_get_contents($dir . "/settings.json"), true);
        //}
        
        if ($settings === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Json data in '" . $dir . "/settings.json" . "' is incorrect: error: " . json_last_error() . ", " . json_last_error_msg());
        }
    }

    if (!isset($settings['type']) || $settings['type'] == "single") {
        return loadContentAsSingle($website, $dir, $settings);
    } else if ($settings['type'] == "list") {
        if (isset($settings['title'])) {
            $website['title'] = $settings['title'];
        }
        return loadContentAsList($website, $dir, $settings);
    } else {
        return notFound(null, null);
    }
}

/*
 * 5A. Ładowanie pojedynczej strony.
 */

function loadContentAsSingle($website, $dir, $settings) {
    
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if ($fileInfo->getExtension() == "txt" && !$fileInfo->isDot()) {
            return array(new LoadableMd($fileInfo->getPathname(), CONTENT_DIRECTORY . str_replace(CONTENT_DIRECTORY_PATH, "", $dir), $website['settings']));
        }
    }
    return notFound(null, null);
}

/*
 * 5B. Ładowanie tablicy podstron.
 */

function loadContentAsList($website, $dir, $settings) {
    $out = array();

    $files = scandir($dir, SCANDIR_SORT_DESCENDING);
    foreach ($files as $f) {
        //echo("File order: ".$f."<br />\n");
        $file = $dir . "/" . $f;
        if (is_dir($file) && $f[0] != '.' && $f[0] != '_') {
            loadPostFromSubdirectory($website, $file, $out); //załaduj post z każdego podfolderu
        }
    }
    return $out;
}

/*
 * 5B.1 Załaduj podfolder
 */

function loadPostFromSubdirectory($website, $file, &$out) {
    foreach (new DirectoryIterator($file) as $fileInfo) {
        if ($fileInfo->isDot())
            continue;
        else if ($fileInfo->getExtension() == "txt" && substr(basename($file), 0, 1) != "_") {
            $out[] = new LoadableMd($fileInfo->getPathname(), CONTENT_DIRECTORY . str_replace(CONTENT_DIRECTORY_PATH, "", $file), $website['settings']);
            break;
        }
    }
}

function notFound($query, $website) {
    if ($query != null && $website != null) {
        if ($query == $website['settings']['not-found-url']) {
            http_response_code(404);
            header("Content-type: text/html");
            echo("Not found\n\n");
            die();
            return;
        }
    }
    include __DIR__ . '/old-redirect-on-not-found.php'; //redirects if an url from old website was found
    http_response_code(404);
    return loadContent($website, $website['settings']['not-found-url']);
}
