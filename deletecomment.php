<?php
session_start();
$current_user=$_SESSION['xplo1'];
$num2=$_GET['con'];
$table_to_del=$_GET['id'];
$person1=$_GET['user'];
if(isset($current_user))
{
require('dbconnect.php');
$query=$conn->prepare("DELETE  FROM `userreplies` WHERE `reply_id`=?");
echo($conn->error);
$query->bind_param("i",$table_to_del);
echo($conn->error);
$query->execute();
$conn->close();
header("Location: {$_SERVER['HTTP_REFERER']}");}
?>
