<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Api page for upload image */
require_once  '../Helper/PngUpload.php';

if(isset($_FILES['pngImage'])) {
    $uploader = new PngUpload($_FILES['pngImage'],'../PngImages/'); 
    echo $uploader->GetResult();
}
else{
    ?>
{
    "type": "Error",
    "message": "לא נשלח קובץ",
    "filePath": false
}
    <?php
}
