<?php
session_start();
$user_name = $_SESSION['userid'];
if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2000000)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "http://xplorers-appsbyvinay.rhcloud.com/profilepics/".$_FILES["file"]["name"]);
        include("include/resize-class.php");
        $resizeObj = new resize($_FILES["file"]["name"]);
        $resizeObj->resizeImage(140, 150, 'exact');
        $resizeObj->saveImage($_FILES["file"]["name"], 100);
        rename($_FILES["file"]["name"], $user_name . ".jpg");
        echo(json_encode("upload"=>"ok"));
    }
} else {
    echo(json_encode("upload"=>"Invalid file"));
}

$conn->close();
?>
