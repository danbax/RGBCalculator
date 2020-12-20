<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Api page for calculate top 5 RGB values of image */
require_once  '../Helper/RgbPixelsCounter.php';

if(isset($_POST['imagePath'])){
    $counter = new RgbPixelsCounter($_POST['imagePath']);
    echo $counter->getTopFiveRgbColors();
}