<?php
session_start();
if(!isset($_SESSION['token'])|| !isset($_POST['token'])){
	echo "bad request";
	header("refresh:1;url=http://xplorers.host56.com");
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
<!DOCTYPE html>
<html>
<head><meta charset="utf-8" />

<title>Welcome to Xplorers</title><noscript><meta http-equiv="X-Frame-Options" content="deny" /></noscript> 
     <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     <script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	function browser()
	{alert("If u are facing problem using chrome, try again after clearing the cookies and cache in chrome.");
	}
	</script> 
<script type="text/javascript">
$(document).ready(function() {
$("#login").validate({
rules: {
usname: {required:true},
uspass: {required:true}
},
messages:{
usname:{required:"Username Required"},
uspass:{required:"Password Required"}	
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
    </head>
 
    <body>
		 
<div class="alert alert-error" >  
                    <p style="padding-left: 200px; font-size:25px;">XPLORERS</p>
                    </div>
 <div class="span3 offset10" style="margin-top: 50px;">
<div class="alert alert-info" style="width: 250px;"> 
     <form id="login" action="/login.php" method="POST" novalidate="novalidate" style="border-top-width: 0px; margin-top: 30px;">
		  <p style="font-size:20px;"><strong>Sign in</strong></p>
		  <hr width=80%>
<div class="control-group">		  
<label>Username: <input width="10" type="text" name="usname" id="usname" placeholder="Username"/>

</div>
<label>Password:
<div class="control-group">	
<input type="password" name="uspass" id="uspass" placeholder="Password"/></label>
  <br>
</div>
  <button type="submit" class="btn btn-primary " name="submit">Xplore</button>  
<input type="hidden" value="<?php echo($token); ?>" name="token"/>
</form>
<div class="alert alert-error">  
  
  <strong>Error!</strong>Wrong username or password. Try again  
</div>    	
 <?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
{?>
<body onload="javascript:browser()">
<?php
} 
?>
 <a href="registration.html" id="reg">New User! Signup</a>
</div>
</div>
</body>
</html>

<?php
}
}}
?>
