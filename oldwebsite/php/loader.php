<?php
require_once(__DIR__.'/lib/Urlizer.php');
require_once(__DIR__.'/lib/LoadableMd.php');
require_once(__DIR__.'/lib/Paginator.php');
require_once(__DIR__.'/lib/util.php');

require_once 'loader-markdown-content.php'; //loadContent is here

/**
 * 1. Ładuje ustawienia z pliku /Strona/settings.json
 */
function loadSettings() {
    $out = json_decode(file_get_contents(CONTENT_DIRECTORY_PATH . "/settings.json"), true);
    if ($out === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Json data in 'settings.json' is incorrect: error: " . json_last_error() . ", " . json_last_error_msg());
    }
    return $out;
}

/*
 * 2. Przetwarza URL. Dzięki mod_rewrite i jego konfiguracji w pliku .htaccess 
 * wszystkie adresy trafiają do pliku index.php jako parametr GET['q'].
 */
function loadUrl($website) {
    $query = "/" . filter_input(INPUT_GET, "q");
    if ($query === null || empty($query)) {
        $query = filter_input(INPUT_SERVER, "PATH_INFO");
    }
    if ($query === null || empty($query) || $query == "/") {
        $query = $website['settings']['home-url']; //załaduj stronę główną
    }
    return str_replace("-", " ", $query);
}

$website = array();

$website['settings'] = loadSettings();
$website['query'] = loadUrl($website);
$website['is-home'] = ($website['query'] == $website['settings']['home-url']);
$website['edit-mode'] = isset($website['settings']['edit-mode']) && $website['settings']['edit-mode'] && isset($_GET['editMode']);

Profiler::start("loadContent");
$website['content'] = loadContent($website, $website['query']); //defined in loader-markdown-content.php
Profiler::stop("loadContent");

Profiler::start("paginator");
$website['paginator'] = new Paginator($website['content'], $website['settings']['posts-per-page'], $website['query']);
Profiler::stop("paginator");
