<?php
session_start();
$usename=$_SESSION['xplo1'];
require('dbconnect.php');
 $who1=mysql_query("SELECT * FROM xplomembers WHERE uname='$usename'");
while($som=mysql_fetch_array($who1))
{$tab=$som['pagepath'];}
mysql_close($conn);
header("Location:http://www.xplorers.host56.com/$tab");
die();

?>
