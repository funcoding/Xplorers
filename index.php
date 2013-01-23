<?php
session_start();
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
		 
<div class="alert alert-error" >  
                    <p style="padding-left: 200px; font-size:25px;">XPLORERS</p>
                    </div>
 <div class="span3 offset10" style="margin-top: 50px;">
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
  <button type="submit" class="btn btn-primary " name="submit">Xplore</button>  
<input type="hidden" value="
<?php
echo ($token);
?>
" name="token"/>
</form>  	
 <a href="registration.php" id="reg">New User! Signup</a>
</div>
</div>
</body>
</html>
