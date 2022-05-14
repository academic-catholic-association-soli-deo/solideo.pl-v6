<?php
set_time_limit(5);


ini_set('display_errors', 'On');

error_reporting(E_ALL);
/*
 * Jak najszybciej wyłączyć wyświetlanie błędów na stronie.
 */



ini_set('session.use_cookies', '0');
header_remove("X-Powered-By");

/*
 * 
 */
define('SOLI_DEO', true); //inne skrypty załadują się tylko, jeśli ta stała będzie zdefiniowana

define('SITE_ROOT', __DIR__);

define('CONTENT_DIRECTORY', 'Strona');
define('CONTENT_DIRECTORY_PATH', __DIR__.'/Strona');

define('NEWSLETTER_CLIENT_PATH', __DIR__.'/../newsletter/NewsletterClient.php');


require_once __DIR__.'/php/index.php';
?>