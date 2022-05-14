<?php
defined("SOLI_DEO") or die();


/**
 * Ten plik przekierowuje linki ze starej strony na nową stronę. Dzięki temu stare linki nadal działają.
 */

$redirects = array(
    "o-nas/kim-jestesmy/kim-jestesmy" => "o-nas/kim-jestesmy",
    "o-nas/kim-jestesmy/patron" => "o-nas/patron",
    "o-nas/kim-jestesmy/historia" => "o-nas/historia",
    "o-nas/kim-jestesmy/nasz-opiekun" => "o-nas/nasz-opiekun",
    "o-nas/jak-dolaczyc" => "o-nas/dolacz-do-nas",
    "o-nas/inne/najczesciej-zadawane-pytania" => "o-nas/faq",
    "o-nas/inne" => "o-nas/ciekawostki",
    "kontakt/sekcje" => "o-nas/sekcje",
    "kontakt/kola-terenowe/sgh" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/pw" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/uw" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/sggw" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/uksw" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/ukswk" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/sgh" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/ump" => "kontakt/kola-terenowe",
    "kontakt/kola-terenowe/wum" => "kontakt/kola-terenowe",
    "kontakt/duszpasterz" => "o-nas/nasz-opiekun",
    "multimedia" => "multimedia/multimedia",
    "2013/2013.10.16-kontakt" => "kontakt"
);

$url = rtrim(trim(filter_input(INPUT_GET, "q")), '/');
if(isset($redirects[$url])) {
    $host = "https://".$_SERVER['HTTP_HOST'];
    $link = $redirects[$url];
    
    header("HTTP/1.1 301 Moved Permanently");
    //header("HTTP/1.1 302 Moved Temporarily");
    header("Location: $host/$link"); 
    header("Content-type: text/html");
    print("Content-type: text/html\n\n");
    echo("Moved to ". $host/$link."\n\n");
    die();
}