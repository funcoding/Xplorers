<?php
session_start();
$checkname=$_POST['id'];
$namme=$_SESSION['xplo1'];
if(!isset($_SESSION['xplo1']))
{header("url=http://xplorers.host56.com");}
else
{require('dbconnect.php');
$timepass=strip_tags($_POST['textinpu']);
 $submit=$_POST['submit'];
 echo($timepass);
 if($submit)
 {
    if($timepass)
    { $cmmname=mysql_fetch_assoc(mysql_query("SELECT nstable FROM xplomembers WHERE uname='$checkname'"));
	mysql_query("INSERT INTO `{$cmmname['nstable']}` (nsense,coname) VALUES ('$timepass','$namme')");
	}
    else
    {
        echo("Enter something in Comment Box");
    }
 }
 mysql_close($conn);
 header("Location: {$_SERVER['HTTP_REFERER']}");
	}
	?>
