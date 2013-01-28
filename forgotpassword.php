<?php
session_start();
$password_token = md5(uniqid(mt_rand(), TRUE));
?>
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
user_email:{required:true,
email:true,
},
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
    <link href="include/css/bootstrap.css" rel="stylesheet"> 
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
	 <div class="navbar">
		  <div class="navbar-inner"> 
		  <div class="container" style="padding-left: 50px; border-left-width: 0px; margin-left: 20px;"> 
		  <a class="brand" href="http://xplorers-appsbyvinay.rhcloud.com">Xplorers</a>
		 </div>
		 </div>
		 </div>
	  <div class="row">
  <div class="span6 offset4">
<fieldset>
<form class="well" id="form1" action="forgotpassword.php?token=<?php
echo ($password_token);
?>" method="post"  style="width: 580px;">
<legend>Password Reset</legend>
<p>Please enter the e-mail address you use to login and we'll send you instructions to reset your password</p>
<p>E-mail<div class="control-group"><input type="text" name="user_email" id="user_email"></input></p></div>
<input type="hidden" name="token" value="<?php
echo ($password_token);
?>" />
<input type="submit" value="submit" name="resetpassword" class="btn btn-primary "/>
<?php
require('include/dbconnect.php');
if (isset($_POST['resetpassword']) && isset($_POST['user_email'])) {
    if (!isset($_GET['token'])) {
        header("Location:http://xplorers-appsbyvinay.rhcloud.com");
    } else {
        $email          = $_POST['user_email'];
        $password_reset = $conn->prepare("SELECT `activation_key`,`member_name` FROM `members` WHERE `email_address`=?");
        if (!$password_reset) {
            echo ($con->error);
        }
        $password_reset->bind_param("s", $email);
        $password_reset->execute();
        $password_reset->bind_result($key, $member_name);
        $password_reset->store_result();
        if ($password_reset->num_rows != 0) {
            while ($password_reset->fetch()) {
                $subject = "Password Reset Xplorers";
                $header  = "From: appsbyvinay@rhcloud.com";
                $message = "Hi " . $member_name . ",\n Please click on the below link to reset your account password\nhttp://xplorers-appsbyvinay.rhcloud.com/passwordreset.php?email=" . $email . "&token=" . $key;
                mail($email, $subject, $message, $header);
            }
            $password_reset->free_result();
            $conn->close();
?>
<div class="alert alert-success">
<p>A password reset link has been e-mailed to you. Please check your email for instructions.</p>
</div>
<?php
        } else {
?>
<div class="alert alert-error"> 
<p>User e-mail doesn't exists</p>
</div>
<?php
        }
    }
}
?>
</fieldset>
</div>
</div>
  </body>
</html>

