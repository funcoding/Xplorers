<?php
session_start();
require('dbconnect.php');
$userlogout=$_SESSION['xplo1'];
$status       = "offline";
$conn->query("UPDATE `xplomembers` SET `sess` = $status WHERE `uname`= $userlogout");
session_unset();
session_destroy();
header('location:http://www.xplorers.host56.com/index.html');
?>
