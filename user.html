<?php
session_start();
require('dbconnect.php');
if (isset($_SESSION['xplo1']) && isset($_SESSION['token'])) {
    $stat      = "online";
    $setlogged = $conn->prepare("UPDATE `xplomembers` SET `time`=CURTIME(),`tstamp`=now(),  `sess`='" . $stat . "' WHERE `uname` ='" . $_SESSION['xplo1'] . "'");
    $setlogged->execute();
} else {
    $conn->close();
}
$checkname = $_GET['user'];
if (!isset($_SESSION['xplo1'])) {
    header("url=http://xplorers.host56.com");
} else {
    $head = $_SESSION['xplo1'];
    $head = strtoupper($head);
    $sql  = $conn->prepare("select `upict` from xplomembers where `uname`=(?)");
    $sql->bind_param("s", $checkname);
    $sql->execute();
    $sql->bind_result($y);
?>

<!DOCTYPE html>
<html lang="en">
<html>

<head>
<title>Xplorers</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<link href="css/bootstrap.css" rel="stylesheet"> 
<h1 ><?php
    if ($checkname == $_SESSION['xplo1']) {
        require("spcheck.php");
    } 
    
?></h1>
<script type="text/javascript">
function des(a,b)
{
var c ="<?php
    echo ($checkname);
?>";

window.location="/ercom.php?no="+a+"&con="+b+"&user="+c;

 }
</script>

</head>
<body>
<div class="navbar" >
	 <div class="navbar-inner" style="position:fixed;width:100%;z-index:1; top:0px;"> 
	 <div class="container">
		<a class="brand" href="#">Xplorers</a> 
		 <div class="nav-collapse"> 
		 <ul class="nav"> 
		 <li class="active">
		<li><a href="#">Home</a></li>
		<li><a href="#">Logout</a></li>
		<li><a href="http://www.xplorers.host56.com/xplmemb/xplorercomments/xplorercomments.html?user=xplorercomments">TimepassBoard</a></li>
		</div> 
	</div>
	</div>
</div>


<div class="thumbnail" style="width: 130px; height: 140px; margin-top: 60px; margin-left: 20px;">
<br/><img  src="http://www.xplorers.host56.com/<?php
    echo ($y);
?>" /> 
<?php
    if (($_GET['user']) == ($_SESSION['xplo1'])) {
        echo ('<a style="text-decoration: none;" href="uploadpic.php">click here to upload or change pic</a>');
    }
?>
</div>
<h2 >Friends</h2>
<div class="thumbnail" style="max-width: 150px; overflow: auto; height: 300px; border-left-width: 0px; margin-left: 22px; border-top-width: 0px; border-bottom-width: 0px;padding: 0px;">
<ul class="nav nav-tabs nav-stacked" style="margin-bottom: 0px;">
<?php
    require('dbconnect.php');
    $a   = 16;
    $dis = $conn->prepare("SELECT `memid`,`uname`,`pagepath`,`time`,`sess` FROM xplomembers WHERE `memid` ORDER BY `memid` ASC");
    $dis->execute();
    $dis->bind_result($nameid, $namedis, $hreflink, $time, $ses);
    while ($dis->fetch()) {
        /*if (($ses == "online") && (time() < (strtotime($time)) + 900)) {
            $stats = '<img src="onl.jpg"/>';
        } else {
            $stats = "";
        }*/
?>

<li>
<a   href="http://www.xplorers.host56.com/<?php
        echo ($hreflink);
?>">
<?php
        echo ($namedis . " ");
        ?>
        </a>
        </li>
        <?php 
    }
    $conn->close();
}
?>
</ul>
</div>

<table border="0" style="position:relative; left:390px; top:-480px;"width=50% >
<tr>
<td>

<form class="well" method="post" action="insertcomments.php" style="width: 350px;">
<label><textarea class="span3" name="textinpu" placeholder="Type something"></textarea></label>
<input type="submit" class="btn btn-primary "  name="submit" value="post"/> 
<input type="hidden" value="<?php
echo ($checkname);
?>" name="id"/>  
</form>

<?php
require('displaycomments.php');
?>
</td>
</tr>
</table>
</body>
</html>

