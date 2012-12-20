<?php
include("resize-class.php");
$resizeObj = new resize('sample.jpg');
$resizeObj->resizeImage(150, 150, 'crop');
$resizeObj->saveImage('sample-resized.jpg', 100);
?>
