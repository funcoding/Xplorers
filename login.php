<?php
session_start();
if(!isset($_SESSION['token'])|| !isset($_POST['token'])){
	echo "bad request";
	exit();
}

if($_SESSION['token']!=$_POST['token']){
	echo "bad request";
	exit();
}

if(isset($_POST["submit"]) and !empty($_POST["usname"]) and !empty($_POST["uspass"])) 
{$xpuser=addslashes(trim($_POST["usname"]));
$xppass=addslashes(trim(md5($_POST["uspass"])));
$con=mysql_connect("mysql9.000webhost.com","a4313936_vinay","transcend89");
  if(!$con)
  {die('could not connect:'.mysql_error());}
  else
 {mysql_select_db("a4313936_xplorer",$con);
 $validation=mysql_query("SELECT * FROM xplomembers WHERE uname='$xpuser' AND upass='$xppass'");
$entry=mysql_fetch_assoc($validation);
mysql_close($con);
if(($entry['uname']==$xpuser) && ($entry['upass']==$xppass))
{$path=$entry['pagepath'];

session_start();
$_SESSION['xplo1']=$xpuser;
header("location:$path");
}
else
{
?>
<!DOCTYPE html><html lang="en"> 
<head><meta charset="utf-8" /> 

<title>Welcome to Xplorers</title><noscript><meta http-equiv="X-Frame-Options" content="deny" /></noscript> 
     <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    </head>
 
    <body>
		 <script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<div class="alert alert-info" style="float: right; margin-right: 100px; margin-top: 150px; border-width: 0px; padding-top: 25px; margin-bottom: 20px; padding-bottom: 0px; width: 250px;"> 
      <form method="POST" action=" " id="login_form" >
		  <form class="well form-inline">  
		  <p><strong>Sign in</strong></p>
		  <hr width=80%>
<input width="10" type="text" name="usname" placeholder="Username" class="input-small" style="border-bottom-width: 1px; width: 200px;">
  <br>
<input type="password" name="uspass" placeholder="Password" class="input-small" style="width: 200px;">
  <br>
  <button type="submit" class="btn" name="submit">Xplore</button>  
</form> 
<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
{?>
<body onload="javascript:browser()">
<?php
} ?>
<div class="alert alert-error">  
  
  <strong>Error!</strong>Wrong username or password. Try again  
</div>  
<a href="registration.html" id="reg">New User! Signup</a>
</div>
<div class="alert alert-error" >  
                    <p style="padding-left: 200px; font-size:25px;">XPLORERS</p>
                    </div>
        
                  </div>
                 
                    
                  </div>
</div></div><div id="pageFooter" data-referrer="page_footer"><div id="contentCurve"></div><div class="clearfix" id="footerContainer"><div class="mrl lfloat" role="contentinfo">
<script type="text/javascript">
	function browser()
	{alert("If u are facing problem using chrome, try again after clearing the cookies and cache in chrome.");
	}
	</script> 




</body>
</html>	

<?php
}
}}
?>