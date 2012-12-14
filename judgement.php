<?php
if($_POST['thuuku'])
{
session_start();

$submit=$_POST['thuuku'];
$nid=$_POST['valueup'];
$ss=$_POST['id'];
echo($ss);
require('dbconnect.php');
$who1=mysql_query("SELECT * FROM xplomembers WHERE uname='$ss'");
while($som=mysql_fetch_array($who1))
{$tab=$som['nstable'];}
mysql_query("DELETE FROM `{$tab}` WHERE id='$nid'");
mysql_close($conn);
require("dbcomment.php");
$jo=$nid.$tab;
mysql_query("DROP TABLE `$jo` ");
mysql_close($conn1);
echo($ss);
header("Location: {$_SERVER['HTTP_REFERER']}");

}



elseif($_POST['submit'])
{
session_start();
$submit=$_POST['submit'];
$nonsenseid=$_POST['valueup'];

$nosense=$_POST['commentss'];
$checkname=$_POST['tna'];
$nnamme=$_SESSION['xplo1'];

if(!isset($_SESSION['xplo1']))
{header("url=http://xplorers.host56.com");}
else
{

if($submit)
 {
    if($nosense)
		{require('dbcomment.php');

$concate2=$nonsenseid.$checkname;



			if(mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$concate2."'")))
				{
    // do something
	mysql_query("INSERT INTO `{$concate2}` (whoo,whatt) VALUES ('$nnamme','$nosense')");
}
else {// do something else
$sql= "CREATE TABLE `{$concate2}` (`id` INT(3) NOT NULL AUTO_INCREMENT, 
`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
`whoo` VARCHAR(50) NOT NULL, `whatt` VARCHAR(500) NOT NULL, 
PRIMARY KEY (`id`))"; 
mysql_query($sql,$conn1);
mysql_query("INSERT INTO `{$concate2}` (whoo,whatt) VALUES ('$nnamme','$nosense')");
}
mysql_close($conn1);		
}}

header("Location: {$_SERVER['HTTP_REFERER']}");

}

}




?>
