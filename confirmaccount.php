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
<legend>Registration</legend>
<?php
error_reporting(E_ALL);
require('include/dbconnect.php');
$email_id      = $_GET['email'];
$check_key     = $_GET['activationkey'];
$activate_user = $conn->prepare("SELECT COUNT(*),memid FROM members WHERE email_address=? AND activation_key=?");
$activate_user->bind_param("ss", $email_id, $check_key);
$activate_user->execute();
$activate_user->bind_result($count_member, $member_id);
$activate_user->store_result();
while ($activate_user->fetch()) {
    if ($count_member != 0) {
        $update_key = $conn->query("UPDATE members SET activation_status=1 WHERE memid=$member_id");
        if (!$update_key) {
            echo ($conn->error);
        }
?>
<p>Success.</p>
<?php
        $activate_user->free_result();
        header('Refresh:1; URL=http://xplorers-appsbyvinay.rhcloud.com');
    } else {
?>
<p> Registration Error. </p>
<?php
    }
}
?>
</fieldset>
</div>
</div>
  </body>
</html>
