
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="generator" content="">
    <meta name="created" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
   <script type="text/javascript" src="include/js/jquery-latest.js"></script>
     <script type="text/javascript" src="include/js/jquery.validate.js"></script>
<link href="include/css/bootstrap.min.css" rel="stylesheet" >
<script type="text/javascript">
$(document).ready(function() {
$("#form1").validate({
rules: {
email: {required:true,
email:true
},
username: {required:true,
rangelength: [5, 20]
},
password: {required:true,
rangelength: [6, 10]},
retype_password: {equalTo: "#password"}
},
messages:{
	username:{required:"Username is required"}
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
<form class="well" id="form1" action="" method="post"  style="width: 580px;">
<legend>New User</legend>
<p>Enter E-mail address <div class="control-group">	<input type="text" name="email" id="email" /></p> </div>
<p>Enter Desired User Name <div class="control-group">	<input type="text" name="username" id="username" /></p> </div>
<p>Enter New Password  <div class="control-group">	<input type="password" name="password" id="password" /></p> </div>
<p>Retype New Password <div class="control-group">	<input type="password" name="retype_password" id="retype_password" /></p> </div>
<input type="submit" value="submit" name="submit" class="btn btn-primary "/>
<?php

    if (isset($_POST['submit'])) {
        require("include/dbconnect.php");
        $user_password   = $_POST['password'];
        $user_name = $_POST['username'];
        $user_email = $_POST['email'];
        $check_user = $conn->prepare("SELECT COUNT(*) FROM members WHERE email_address=? ");
        $check_user->bind_param("s", $user_email);
        $check_user->execute();
        $check_user->bind_result($count_member);
        $check_user->store_result();
        while ($check_user->fetch()) {
            if ($count_member != 0) {
				?>
				
				<div class="alert alert-error">
<p> User already Exists </p>
</div>
<?php 		
            } else {
				$activation_key=mt_rand().mt_rand().mt_rand();
				$crypted_password=crypt($user_password,$salt);
				$table_name=uniqid();
				$activation_status=0;
				$new_user=$conn->prepare("INSERT INTO members (activation_key,activation_status,member_name,member_password,email_address,member_table) VALUES (?,?,?,?,?,?)");
				$new_user->bind_param("sissss",$activation_key,$activation_status,$user_name,$crypted_password,$user_email,$table_name);
				$new_user->execute();
				if($new_user)
				{	$conn->query("CREATE TABLE IF NOT EXISTS $table_name (post_id int(11) NOT NULL AUTO_INCREMENT, unix_time int(11) NOT NULL, member_posted int(11) NOT NULL, member_posts varchar(500) NOT NULL, PRIMARY KEY(post_id)) ");
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .='From:no-reply@xplorers.com'."\r\n";
					$body="Hello ".$user_name.",<br><br>Thank you for registering in Xplorers. Please click on the below link to activate your account.<br><br>
					<a href='http://xplorers-appsbyvinay.rhcloud.com/confirmaccount.php?email=".$user_email."&activationkey=".$activation_key."'>Click here to activate your account</a>";
					mail($user_email,"Registration in Xplorers",$body,$headers);
					?>
					<div class="alert alert-success">
					<p> An email has been sent to your account with instructions to activate your account. Please check your inbox. </p>
					</div>
<?
				}
            }
        }
    }
?>
</fieldset>
</div>
</div>
  </body>
</html>
