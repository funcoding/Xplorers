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
user: {required:true,
rangelength: [4, 15]},
user_email:{required:true,
email:true,
},
password: {required:true,
rangelength: [6, 10]},
retype_password: {equalTo: "#password"}
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
<form class="well" id="form1" action="registration.php" method="post"  style="width: 580px;">
<legend>New User</legend>

<p>Enter Desired Login Name <div class="control-group">	 <input type="text" name="user" id="user"></input></p></div>
<p>E-mail <div class="control-group">	 <input type="text" name="user_email" id="user_email"></input></p></div>
<p>Enter Password  <div class="control-group">	<input type="password" name="password" id="password" /></p> </div>
<p>Retype Password <div class="control-group">	<input type="password" name="retype_password" id="retype_password" /></p> </div>
<input type="submit" value="Register" name="register" class="btn btn-primary "/>

<?php
error_reporting(E_ALL);
require('include/dbconnect.php');

if (isset($_POST['register'])) {
    if (isset($_POST['user']) && isset($_POST['password']) && ($_POST['password'] == $_POST['retype_password']) && isset($_POST['retype_password']) && ctype_alnum($_POST['user']) && !preg_match('/ /', $_POST['user'])) {
        $member_name = (trim($_POST['user']));
        $member_email=(trim($_POST['user_email']));
        $password  = (trim($_POST['password']));
        $count1  = strlen($member_name);
        $count2  = strlen($password);
        if ((4 <= $count1 && $count1 <= 15 && 6 <= $count2 && $count2 <= 10)) {
			 
            $check_member = $conn->prepare("SELECT memid FROM members WHERE email_address=?");
            $check_member->bind_param("s", $member_email);
            $check_member->execute();
            $check_member->bind_result($member_status); 
            if ($check_member->fetch() != 0) {
?>
<div class="alert alert-error"> 
<?php
                die('Sorry, the username already exists');
?>
	</div>
	<?php
            } else {
				$activation_key=mt_rand().mt_rand().mt_rand();
				$table_name=uniqid();
				$activation_status=0;
                $qsql    = $conn->prepare("INSERT INTO members (member_name,member_password,email_address,activation_key,activation_status,$member_table) VALUES (?,?,?,?,?,?)");
                $qsql->bind_param("ssssis", $member_name, crypt($password,$salt), $member_email,$activation_key,$activation_status,$table_name);
                $qsql->execute();
                if(!$qsql)
                {echo($conn->error);}
                $pic_name=$conn->insert_id;
                
                copy("blank.jpg", "profilepics/$pic_name.jpg");
                $conn->query("CREATE TABLE xplorers.$table_name (
								post_id int not null auto_increment,
								unix_time int not null,
								member_posted int not null ,
								member_posts varchar(500) not null,
								primary key (post_id),
								foreign key (member_posted) references members(memid)
								)engine=innodb");
				
	            
                $conn->close();
                $subject="Registration on Xplorers";
                $header="From: appsbyvinay@rhcloud.com";
                $message="Hi ".$member_name.",\nThank you for registering on xplorers site. Please click on the below link to activate your account\nhttp://xplorers-appsbyvinay.rhcloud.com/confirmaccount.php?email=".$member_email."&activationkey=".$activation_key;
                mail($member_email,$subject,$message,$header);
                header("Location: http://xplorers-appsbyvinay.rhcloud.com/");
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
