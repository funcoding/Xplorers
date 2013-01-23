<?php
session_start();
if (!isset($_SESSION['token']) || !isset($_POST['token'])) {
    echo "bad request";
    header("refresh:1;url=http://xplorers-appsbyvinay.rhcloud.com");
    exit();
}
if (isset($_POST["submit"]) and !empty($_POST["login_id"]) and !empty($_POST["login_password"])) {
    login_success();
} else {
    login_fail();
}
function login_success()
{
    require("include/dbconnect.php");
    if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
    $user_email_id     = trim($_POST["login_id"]);
    $user_password     = trim($_POST["login_password"]);
    $loginquery = $conn->prepare("SELECT `memid`,activation_status,member_name FROM `members` WHERE `email_address`=? AND member_password=?");
    $loginquery->bind_param("ss",$user_email_id,crypt($user_password,$salt));
    $loginquery->execute();
    $loginquery->bind_result($member,$activation,$user_name);
    $loginquery->store_result();
    if ($loginquery->num_rows == 1) {
        while ($loginquery->fetch()) {
			if($activation==1)
            {$_SESSION['username'] = $user_name;
            $_SESSION['userid']=$member;
            header("location:user.php?user=$member&name=$user_name");
            $loginquery->free_result();}
            else
            {
				login_fail(true);
				}
        }
    } else {
        login_fail(false);
    }
    $conn->close();
}
function login_fail($activation)
{
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
<input type="hidden" value="<?php
echo ($token);
?>" name="token"/>
</form> 
<div class="alert alert-error">  
<?php
if($activation===true)
{
	?>

<p><strong>The Account has not been activated yet.</strong></p>
<?php
}
elseif($activation===false)
{
	?>
<p><strong>Error!</strong>Wrong username or password. Try again</p>
<?php
}
?>
</div>    	
 <a href="registration.php" id="reg">New User! Signup</a>
</div>
</div>
</body>
</html>

<?php
}
?>
