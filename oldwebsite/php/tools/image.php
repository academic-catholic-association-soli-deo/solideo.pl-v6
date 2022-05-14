<?php
not_found("Images disabled");//disable images
die();

$sTime = microtime(true);
/*
  /*
 * Crop-to-fit PHP-GD
 * http://salman-w.blogspot.com/2009/04/crop-to-fit-image-using-aspphp.html
 *
 * Resize and center crop an arbitrary size image to fixed width and height
 * e.g. convert a large portrait/landscape image to a small square thumbnail
 */

function not_found($errorText) {
    file_put_contents("image.log", "error:" . $errorText . "\n", FILE_APPEND);
    http_response_code(404);
    die();
}

function base64_url_encode($input) {
    return strtr(base64_encode($input), '+/=', '._-');
}

if (empty($_GET['w']) || empty($_GET['h']) || empty($_GET['img'])) {
    not_found("w,h or img not present");
}

if (!is_numeric(filter_input(INPUT_GET, "w")) || !is_numeric(filter_input(INPUT_GET, "h"))) {
    not_found("w or h is not an int: w=" . filter_input(INPUT_GET, "w") . "; h=" . filter_input(INPUT_GET, "h"));
}


define('DESIRED_IMAGE_WIDTH', filter_input(INPUT_GET, "w") * 1);
define('DESIRED_IMAGE_HEIGHT', filter_input(INPUT_GET, "h") * 1);

if (DESIRED_IMAGE_WIDTH < 10 || DESIRED_IMAGE_WIDTH > 2560 || DESIRED_IMAGE_HEIGHT < 10 || DESIRED_IMAGE_HEIGHT > 2560) {
    not_found("w < 10 || w > 2560 || h < 10 || h > 2560");
}

$url = str_replace("..", "", filter_input(INPUT_GET, "img"));
$source_path = __DIR__ . "/" . $url;
if (!file_exists($source_path))
    not_found("File not found");

$cacheFilePath = __DIR__ . "/foto-cache/" . base64_url_encode($url . ":" . DESIRED_IMAGE_WIDTH . ":" . DESIRED_IMAGE_HEIGHT);
if (file_exists($cacheFilePath)) {
    header('Content-type: image/jpeg');
    echo file_get_contents($cacheFilePath);
} else {

    /*
     * Add file validation code here
     */

    list($source_width, $source_height, $source_type) = getimagesize($source_path);

    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gdim = imagecreatefromgif($source_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gdim = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $source_gdim = imagecreatefrompng($source_path);
            break;
    }

    $source_aspect_ratio = $source_width / $source_height;
    $desired_aspect_ratio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;

    if ($source_aspect_ratio > $desired_aspect_ratio) {
        /*
         * Triggered when source image is wider
         */
        $temp_height = DESIRED_IMAGE_HEIGHT;
        $temp_width = (int) (DESIRED_IMAGE_HEIGHT * $source_aspect_ratio);
    } else {
        /*
         * Triggered otherwise (i.e. source image is similar or taller)
         */
        $temp_width = DESIRED_IMAGE_WIDTH;
        $temp_height = (int) (DESIRED_IMAGE_WIDTH / $source_aspect_ratio);
    }

    /*
     * Resize the image into a temporary GD image
     */

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
            $temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
    );

    /*
     * Copy cropped region from temporary image into the desired GD image
     */

    $x0 = ($temp_width - DESIRED_IMAGE_WIDTH) / 2;
    $y0 = ($temp_height - DESIRED_IMAGE_HEIGHT) / 2;
    $desired_gdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
    imagecopy(
            $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT
    );

    /*
     * Render the image
     * Alternatively, you can save the image in file-system or database
     */

    header('Content-type: image/jpeg');
    imagejpeg($desired_gdim);
}
/*
 * Add clean-up code here
 */

$time = microtime(true) - $sTime;
file_put_contents("image.log", "time: " . ($time * 1000) . "ms\n", FILE_APPEND);
mic
?>