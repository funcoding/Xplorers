<?php
session_start();
require('dbconnect.php');
$tt="";
$stat2="UPDATE `xplomembers` SET `sess` = '".$tt."' WHERE `uname`='".$_SESSION['xplo1']."'";

$setlogged=mysql_query($stat2);

session_unset();
session_destroy();

header('location:http://www.xplorers.host56.com/index.html');
?>
