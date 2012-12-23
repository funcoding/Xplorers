<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="generator" content="">
    <meta name="created" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
   <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#form1").validate({
rules: {
namealpha: {required:true,
rangelength: [4, 15]},
passalpha1: {required:true,
rangelength: [6, 10]},
passalpha2: {equalTo: "#passalpha1"}
},
messages:{
	namealpha:{required:"Login Name is required"},
	passalpha1:{required:"Password is required"}
},
errorClass: "help-inline",
errorElement: "span",
highlight:function(element, errorClass, validClass)
{
$(element).parents('.control-group').addClass('error');

},
unhighlight: function(element, errorClass, validClass)
{
$(element).parents('.control-group').removeClass('error');

}
});
});
</script>
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet"> 
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
	 <div class="navbar">
		  <div class="navbar-inner"> 
		  <div class="container" style="padding-left: 50px; border-left-width: 0px; margin-left: 20px;"> 
		  <a class="brand" href="http://xplorers.host56.com">Xplorers</a>
		 </div>
		 </div>
		 </div>
	  <div class="row">
  <div class="span6 offset4">
<fieldset>
<form class="well" id="form1" action="registration.html" method="post"  style="width: 580px;">
<legend>New User</legend>

<p>Enter Desired Login Name <div class="control-group">	 <input type="text" name="namealpha" id="namealpha"></input></p></div>
<p>Enter Password  <div class="control-group">	<input type="password" name="passalpha1" id="passalpha1" /></p> </div>
<p>Retype Password <div class="control-group">	<input type="password" name="passalpha2" id="passalpha2" /></p> </div>
<input type="submit" value="Register" name="register" class="btn btn-primary "/>

<?php
require('dbconnect.php');
if (isset($_POST['register'])) {
    if (isset($_POST['namealpha']) && isset($_POST['passalpha1']) && ($_POST['passalpha1'] == $_POST['passalpha2']) && isset($_POST['passalpha2']) && ctype_alnum($_POST['namealpha']) && !preg_match('/ /', $_POST['namealpha'])) {
        $xpalpha = (trim($_POST['namealpha']));
        $passxp  = (trim($_POST['passalpha1']));
        $count1  = strlen($xpalpha);
        $count2  = strlen($passxp);
        if ((4 <= $count1 && $count1 <= 15 && 6 <= $count2 && $count2 <= 10)) {
            $ncheck = $conn->prepare("SELECT uname FROM xplomembers WHERE uname=(?)");
            $ncheck->bind_param("s", $xpalpha);
            $ncheck->execute();
            $ncheck->bind_result($ncheck1);
            if ($ncheck->fetch() != 0) {
?>
<div class="alert alert-error"> 
<?php
                die('Sorry, the username already exists');
?>
	</div>
	<?php
            } else {
                $hrefval = 'xplmemb/' . $xpalpha . '/' . $xpalpha . '.html?user=' . $xpalpha;
                $qsql    = $conn->prepare("INSERT INTO xplomembers (memid,uname,upass,pagepath,nstable) VALUES (NULL,(?),MD5(?),(?),(?))");
                $qsql->bind_param("ssss", $xpalpha, $passxp, $hrefval, $xpalpha);
                $qsql->execute();
                mkdir("xplmemb/" . $xpalpha);
                chmod("xplmemb/" . $xpalpha, 0777);
                copy("user.php", "xplmemb/$xpalpha/$xpalpha.html");
                copy("displaycomments.php", "xplmemb/$xpalpha/displaycomments.php");
                copy("judgement.php", "xplmemb/$xpalpha/judgement.php");
                copy("dbconnect.php", "xplmemb/$xpalpha/dbconnect.php");
                copy("dbcomment.php", "xplmemb/$xpalpha/dbcomment.php");
                copy("logout.php", "xplmemb/$xpalpha/logout.php");
                copy("resize-class.php", "xplmemb/$xpalpha/resize-class.php");
                copy("resize.php", "xplmemb/$xpalpha/resize.php");
                copy("uploadpic.php", "xplmemb/$xpalpha/uploadpic.php");
                copy("upload1.php", "xplmemb/$xpalpha/upload1.php");
                copy("insertcomments.php", "xplmemb/$xpalpha/insertcomments.php");
                copy("lu.css", "xplmemb/$xpalpha/lu.css");
                copy("sp.php", "xplmemb/$xpalpha/sp.php");
                copy("spcheck.php", "xplmemb/$xpalpha/spcheck.php");
                copy("jwplayer.js", "xplmemb/$xpalpha/jwplayer.js");
                copy("player.swf", "xplmemb/$xpalpha/player.swf");
                copy("home.php", "xplmemb/$xpalpha/home.php");
                copy("blank.jpg", "xplmemb/$xpalpha/$xpalpha.jpg");
                copy("onl.jpg", "xplmemb/$xpalpha/onl.jpg");
                $conn->query("CREATE TABLE `a4313936_xplorer`.`$xpalpha` (`id` INT NOT NULL AUTO_INCREMENT, `xplotime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `coname` VARCHAR(15) NOT NULL, `nsense` VARCHAR(1000) NOT NULL, INDEX (`id`)) ENGINE = MyISAM");
                $patth  = "xplmemb/" . $xpalpha . "/" . $xpalpha . ".jpg";
                $update = $conn->prepare("UPDATE xplomembers SET upict=(?) WHERE uname=(?)");
                $update->bind_param("ss", $patth, $xpalpha);
                $update->execute();
                $conn->close();
                echo ("Thank you for registering. you will be redirected in 5 secs");
                header("refresh:5,url=http://www.xplorers.host56.com/index.html");
            }
        } else
            echo ("error in filling form..");
    } else
        echo ("Error!");
}
?>
</fieldset>
</div>
</div>
  </body>
</html>