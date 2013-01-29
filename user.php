<?php
session_start();
$checkname = $_GET['name'];
$userid    = $_GET['user'];
require('include/dbconnect.php');
if (!isset($_SESSION['userid'])) {
    header("Location:http://xplorers-appsbyvinay.rhcloud.com");
} else {
?>

<!DOCTYPE html>
<html lang="en">
<html>

<head>
<title>Xplorers</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script src="include/js/bootstrap.js"></script>
<link href="include/css/bootstrap.css" rel="stylesheet"> 
<h1 ></h1>

<script type="text/javascript">
function deletepost(tableid)
{
var page_table="<?php
    echo ($userid);
?>";
var buttonname=document.getElementById("deletepost_"+tableid);
var condition=buttonname.getAttribute("name");
$.ajax({
	type:"POST",
	url:"judgement.php",
	data:{submit:condition,page:page_table,value_table:tableid},
	success:function(result){
		$("#Post_no_"+tableid).hide();
	}
});
}

</script>
<script type="text/javascript">
function insert_reply(postno,commentno)
{var pagename="<?php
    echo ($userid);
?>";
    var comment_date="<?php
    echo (date("d-m", strtotime(now)));
?>";
    var loggedin="<?php
    echo ($_SESSION['userid']);
?>"; 
var loggedin_username="<?php
    echo ($_SESSION['username']);
?>";
	 var comment= $('#commentarea'+postno).val();
	$.ajax({
		type:"POST",
		url:"judgement.php",
		dataType: 'json',
		data:{id:pagename,posttableno:postno,commentss:comment,submit:"insertreply"},
		success:function(resultreceived)
		{
			var post_date="<?php
    echo (date("d-m", strtotime(now)));
?>";
			var html='<li id="subcomment_no_'+resultreceived.id_comment+'" class="media" style=" margin-bottom: 1px;background-color:#EDEFF4;margin-left: 50px;margin-top: 0px;"><img  style="width: 32px; height: 32px; padding-top: 5px; padding-left: 5px; padding-right: 0px; margin-right: 5px;" class="pull-left" style="width: 32px; height: 32px;" alt="/profilepics'+loggedin+'.gif" src="/profilepics/'+loggedin+'.jpg"/><div class="media-body"><h6 class="media-heading"> </h6><p style="font-size:12px;word-wrap:break-word;padding-right: 10px;"><strong>'+loggedin_username+'</strong>&nbsp;'+ resultreceived.comments+ '<input type="button"  id="erase'+resultreceived.id_comment+'" class="btn" style="float:right;"  onClick="javascript:des('+postno+ ',' +resultreceived.id_comment+')" value="erase" /></p><p style="font-size:12px;color:#3B5998;">'+post_date+'</p></div></li>';
			
				$("#commentfieldno"+postno).prepend(html);
				$('#commentarea'+postno).val('');
			
		}
		
		
	
	});
}

	
</script>

<script type="text/javascript">
function des(a,b){

var c ="<?php
    echo ($userid);
?>";
	$.ajax({
  type: "POST",
  url: "deletecomment.php",
  dataType: 'json',
  data: {con:a,id:b,user:c},
  success:function( msg ) {
	
	if(msg[0]=="success")
	{
	$("#subcomment_no_"+b).hide();}
	else
	{alert("Something Went Wrong");}
}
});
}
</script>
<script type="text/javascript"> 
        
        $(document).ready(function() { 
            $('#profilepic').ajaxForm(
            
            function(result) { 
                if(result=="ok")
                {location.reload();}
                else
                {alert(result);}
            }); 
        }); 
    </script> 
<script type="text/javascript"> 
        
        $(document).ready(function() { 
            $('#userpost').ajaxForm({
				dataType:  'json',
                success:function(result){
				var post_member="<?php
    echo ($_SESSION['userid']);
?>";
                var post_member_name="<?php
    echo ($_SESSION['username']);
?>";
                var post_date="<?php
    echo (date("d-m", strtotime(now)));
?>";
                var html_post='<div id="Post_no_'+result.ID+'"><div id="media'+result.ID+'"class="media"><img  class="pull-left" style="width: 50px; height: 50px;" alt="/profilepics/' +post_member+ '.gif" src="/profilepics/' +post_member+ '.jpg"/><div class="media-body"><h4 class="media-heading"> '+post_member_name+ '<input   type="button" name="thuuku" class="btn" onClick="javascript:deletepost('+result.ID+')" style="float:right" id="deletepost_'+result.ID+'" value="Delete"/></h4><p>' +result.POST+ '</p><p style="font-size:12px;color:#3B5998;">'+post_date+'</p></div></div>';
				var html_post_comment='<div id="commentfieldno'+result.ID+'"><textarea placeholder="Comment"  id="commentarea'+result.ID+'" style="resize: none;margin-bottom: 1px; margin-left: 50px; margin-top: 0px; height: 40px; width: 572px;" name="commentss"></textarea></div><input  style="float:right" class="btn" type="button" name="insertreply"  value="Comment" onClick="insert_reply('+result.ID+');"/><br><hr></div>';
				$("#userpost").after(html_post);
				$('#media'+result.ID).after(html_post_comment);
				$("#post_area").val(''); 
			}
            }); 
        }); 
    </script> 

</head>
<body>

<div class="navbar navbar-fixed-top" >
	 <div class="navbar-inner"> 
	<div class="container" style="margin-left: 30px;">
		<a class="brand" href="#">Xplorers</a> 
		 <div class="nav-collapse"> 
		 <ul class="nav"> 
		 <li class="active">
		<li><a href="http://xplorers-appsbyvinay.rhcloud.com/user.php?user=<?php
    echo ($_SESSION['userid']);
?>&name=<?php
    echo ($_SESSION['username']);
?>">Home</a></li>
		<li><a href="logout.php">Logout</a></li>
		
</li>
</ul>
</div>
</div>
</div>
</div>

<div class="container" style="margin-left: 25px;">


<div class="row-fluid">  
<?php
    $checkuser = $conn->prepare("SELECT COUNT(*) FROM members WHERE memid=? AND member_name=?");
    $checkuser->bind_param("is", $userid, $checkname);
    $checkuser->execute();
    $checkuser->bind_result($user);
    $checkuser->store_result();
    while ($checkuser->fetch()) {
        if ($user == 0) {
?>
<div id="span9" class="span9 offset6">
<div class="thumbnail" style="width: 340px; height: 140px; margin-top: 60px;">
	<h4>The page you requested was not found.</h4>
<p>You may have clicked an expired link or mistyped the address. Some web addresses are case sensitive.</p>
</div>
</div>
<?php
        } else {
?>
<div class="span3">  

<div class="well sidebar-nav" style="background-color: rgb(255, 255, 255); border-width: 5px 0px 0px; margin-top: 0px; padding: 0px; margin-bottom: 0px;">

<div class="thumbnail" style="width: 130px; height: 140px; margin-top: 60px;">
	
<img  src="/profilepics/<?php
            echo ($userid);
?>
.jpg" /> 
</div>

<?php
            if (($_GET['user']) == ($_SESSION['userid'])) {
?>
		

	<div id="Uploadpic" class="modal hide fade in" style="display: none; ">		
<div class="modal-header">
<a class="close" data-dismiss="modal">x</a>
<h3>Select Profile Pic</h3>
</div>
<form method="post" id="profilepic" action="include/upload1.php" enctype="multipart/form-data">	
<div class="modal-body">

	<label>Filename:</label>
<input type="file" name="file" id="file" /> 		        
</div>
<div class="modal-footer">
<p>Supported Format:jpeg,gif</p>
<p>Maximum size:2 mb</p>	
<input type="submit" name="submit" id="uploadprofile"  value="Upload" class="btn btn-success"/>
<a href="#" class="btn" data-dismiss="modal">Close</a>
</div>
</div>


<p><a class="btn btn-primary" href="#Uploadpic" data-toggle="modal" >Change pic</a></p>
</form>

        <?php
            }
?>
<p style="padding-left: 10px; word-wrap: break-word; width: 125px;"><?php
            echo ($checkname);
?></p>
    
<h2 >Friends</h2>
<div class="thumbnail" style="max-width: 150px; overflow: auto; height: 300px; border-top-width: 0px; border-bottom-width: 0px;padding: 0px;">
<ul class="nav nav-tabs nav-stacked" style="margin-bottom: 0px;">
<?php
            $current_user_id = $_SESSION['userid'];
            $display_friends = $conn->prepare("SELECT memid,member_name FROM members WHERE memid <> $current_user_id ORDER BY memid ASC");
            $display_friends->execute();
            $display_friends->bind_result($friends_id, $friends_name);
            $display_friends->store_result();
            while ($display_friends->fetch()) {
?>

<li>
<a   href="http://xplorers-appsbyvinay.rhcloud.com/user.php?user=<?php
                echo ($friends_id);
?>&name=<?php
                echo ($friends_name);
?>">
<?php
                echo ($friends_name);
?>
        </a>
        </li>
        
        <?php
            }
            $conn->close();
?>
</ul>
</div>
</div>

</div>

<div id="span9" class="span9">
	
<div class="thumbnail" style="margin-top: 0px; border-top-width: 0px; border-left-width: 1px; margin-left: -20px; padding-top: 80px; border-right-width: 0px; padding-left: 80px;">

<form class="well" id="userpost" method="post" action="insertcomments.php" style="width: 350px;">
<label><textarea style="resize:none" id="post_area" name="textinpu" placeholder="Type something"></textarea></label>
<input type="submit" class="btn btn-primary "  name="submit" value="post"/> 
<input type="hidden" value="<?php
            echo ($userid);
?>" name="id"/>  
</form>
<?php
            require('displaycomments.php');
?>
</div>

</div>
<?php
        }
    }
}
?>
</div>
</div>
</body>
</html>


