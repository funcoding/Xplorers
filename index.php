<?php
session_start();
if(isset($_SESSION['userid']))
{$redirect_userid=$_SESSION['userid'];
$redirect_username=$_SESSION['username'];
	header("Location:http://xplorers-appsbyvinay.rhcloud.com/user.php?user=$redirect_userid&name=$redirect_username"); }

$token             = md5(uniqid(mt_rand(), TRUE));
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8" />

<title>Welcome to Xplorers</title><noscript><meta http-equiv="X-Frame-Options" content="deny" /></noscript> 
     <link href="include/css/bootstrap.min.css" rel="stylesheet" media="screen">
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     <script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script src="include/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#login").validate({
rules: {
login_id: {required:true,
email:true},
login_password: {required:true}
},
messages:{
login_id:{required:"Email Required"},
login_password:{required:"Password Required"}	
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
		 
<div class="navbar navbar-fixed-top" >
	 <div class="navbar-inner"> 
	<div class="container"  style="margin-left: 30px;width:1090px;">
		<a class="brand" href="#"><h4>Xplorers</h4></a>
		<a class="btn btn-success pull-right" style="margin-top:15px;"  href="registration.php" id="reg">New User! Signup</a>
		 <div class="nav-collapse">  
                 </div>
</div>
</div>
</div>
 <div class="span3 offset10" style="margin-top: 150px;">
<div class="alert alert-info" style="width: 250px;"> 
     <form id="login" action="/login.php" method="POST" novalidate="novalidate" style="border-top-width: 0px; margin-top: 30px;">
		  <p style="font-size:20px;"><strong>Sign in</strong></p>
		  <hr width=80%>
<div class="control-group">		  
<label>E-mail: <input width="10" type="text" name="login_id" id="login_id" placeholder="Email id"/>

</div>
<label>Password:
<div class="control-group">	
<input type="password" name="login_password" id="login_password" placeholder="Password"/></label>
  <br>
</div>
  <button type="submit" class="btn btn-primary" name="submit">Xplore</button>  
<input type="hidden" value="
<?php
echo ($token);
?>
" name="token"/>
</form>  	
 
<p><a href="forgotpassword.php" id="reg">Reset Password</a></p>
 
</div>
</div>
</body>
</html>
