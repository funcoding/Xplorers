<?php
$email_id  = $_GET['email'];
$check_key = $_GET['token'];
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

password: {required:true,
rangelength: [6, 10]},
retype_password: {equalTo: "#password"}
},
messages:{
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
<form class="well" id="form1" action="passwordreset.php?email=<?php
echo ($email_id);
?>&token=<?php
echo ($check_key);
?>" method="post"  style="width: 580px;">
<legend>New Password</legend>

<p>Enter New Password  <div class="control-group">	<input type="password" name="password" id="password" /></p> </div>
<p>Retype New Password <div class="control-group">	<input type="password" name="retype_password" id="retype_password" /></p> </div>
<input type="submit" value="submit" name="submit" class="btn btn-primary "/>
<?php
if (!isset($email_id) || !isset($check_key)) {
    echo ("Error");
} else {
    if (isset($_POST['submit'])) {
        require("include/dbconnect.php");
        $newpassword   = $_POST['password'];
        $activate_user = $conn->prepare("SELECT COUNT(*),`memid` FROM members WHERE email_address=? AND activation_key=?");
        $activate_user->bind_param("ss", $email_id, $check_key);
        $activate_user->execute();
        $activate_user->bind_result($count_member, $member_id);
        $activate_user->store_result();
        while ($activate_user->fetch()) {
            if ($count_member != 0) {
                $update_password = $conn->prepare("UPDATE members SET member_password=? WHERE `memid`=$member_id");
                if (!$update_password) {
                    echo ($conn->error);
                }
                $update_password->bind_param("s", crypt($newpassword, $salt));
                $update_password->execute();
                if (!$update_password) {
                    echo ($conn->error);
                }
?>
<div class="alert alert-success">
<p>New password Successfully Set</p>
</div>
<?php
                $activate_user->free_result();
                header('Refresh:1; URL=http://xplorers-appsbyvinay.rhcloud.com');
            } else {
?>
<div class="alert alert-error">
<p> Error. </p>
</div>
<?php
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
