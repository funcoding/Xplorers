<?php
session_start();
$usename = $_SESSION['xplo1'];
if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2000000)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
        include("resize-class.php");
        $resizeObj = new resize($_FILES["file"]["name"]);
        $resizeObj->resizeImage(140, 150, 'exact');
        $resizeObj->saveImage($_FILES["file"]["name"], 100);
        rename($_FILES["file"]["name"], $usename . ".jpg");
        $patth = "xplmemb/" . $usename . "/" . $usename . ".jpg";
        require('dbconnect.php');
        $conn->query("UPDATE xplomembers SET upict='$patth' WHERE uname='$usename'");
        $conn->close();
    }
} else {
    echo "Invalid file";
}

header("Location: {$_SERVER['HTTP_REFERER']}");
$conn->close();
?>
