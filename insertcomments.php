<?php
session_start();
$checkname=$_POST['id'];
$name=$_SESSION['xplo1'];
if(!isset($_SESSION['xplo1']))
{header("url=http://xplorers.host56.com");}
else
{require('dbconnect.php');
$timepass=strip_tags($_POST['textinpu']);
 $submit=$_POST['submit'];
 if(isset($submit))
 {
    if(isset($timepass))
    {
		$cmmname=$conn->prepare("SELECT `nstable` FROM xplomembers WHERE uname=(?)");
		$cmmname->bind_param("s",$checkname);
		$cmmname->execute();
		$cmmname->store_result();
		$cmmname->bind_result($cmmtable);
			while($cmmname->fetch())
				{ 
					$action=$conn->prepare("INSERT INTO `$cmmtable` (`nsense`,`coname`) VALUES (?,?)");
						if(!$action)
							{echo("error ".$conn->error);}
					$action->bind_param("ss",$timepass,$name);
					$action->store_result();
					$action->execute();
				}
		$cmmname->free_result();
		$action->free_result();
	}
    else
    {
        echo("Enter something in Comment Box");
    }
 }


 header("Location: {$_SERVER['HTTP_REFERER']}");
}
?>