<?php
/*
 * Source: https://stackoverflow.com/questions/25869504/htaccess-show-404-403-500-error-pages-via-php
 */
$code = $_SERVER['REDIRECT_STATUS'];
$codes = array(
    403 => 'Dostęp zabroniony',
    404 => 'Nie znaleziono',
    500 => 'Wewnętrzny błąd serwera'
);
$title = "Nieznany błąd";
if (is_numeric($code)) {
    if (array_key_exists($code, $codes)) {
        $title = $codes[$code];
    }
    http_response_code((int) $code);
} else {
    http_response_code(500);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ASK Soli Deo – błąd — <?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="robots" content="noindex">
        <style type="text/css">
            body {	text-align: center; padding: 5%; font: 20px Helvetica, sans-serif; color: #333; }
            h1 { font-size: 50px; margin: 0; }
            article { display: block; text-align: left; max-width: 650px; margin: 0 auto; }
            a { color: #dc8100; text-decoration: none; }
            a:hover { color: #333; text-decoration: none; }
            @media only screen and (max-width : 480px) {
                h1 { font-size: 40px; }
            }
        </style>
    </head>
    <body>
        <img src="/img/logo.png" />
        <br /><br /><br /><br />
        <article>
            <h1>Błąd: <?php echo $title; ?></h1>
            <div>
                <p>Przepraszamy, wystąpiły błąd. Jeśli uznasz to za stosowne, to zapraszamy do kontaktu z naszym <a href="https://new.asksolideo.pl/kontakt/strona">działem IT</a>.</p>
                <p>&mdash; Sekcja IT ASK Soli Deo</p>
            </div>
        </article>


    </body>
</html>