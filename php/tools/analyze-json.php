<?php
die();
$text = "Mądrość króla salomona _ ! * @ ( reg + -";
$urlprepared = mb_ereg_replace("[^A-Za-z0-9\.\-]","",$text);
echo($text."\n");
echo($urlprepared."\n");