<?php
session_start();
require('dbconnect.php');
if (isset($_SESSION['xplo1']) && isset($_SESSION['token'])) {
    $stat      = "online";
    $setlogged = $conn->prepare("UPDATE `xplomembers` SET `time`=CURTIME(),`tstamp`=now(),  `sess`='" . $stat . "' WHERE `uname` ='" . $_SESSION['xplo1'] . "'");
    $setlogged->execute();
} else {
    $conn->close();
}
$checkname = $_GET['user'];
if (!isset($_SESSION['xplo1'])) {
    header("url=http://xplorers.host56.com");
} else {
    $head = $_SESSION['xplo1'];
    $head = strtoupper($head);
    $sql  = $conn->prepare("select `upict` from xplomembers where `uname`=?");
    $sql->bind_param("s", $checkname);
    $sql->execute();
    $sql->bind_result($profilepic);
    while ($sql->fetch()) {
        $profilepic = $profilepic;
    }
?>

<!DOCTYPE html>
<html lang="en">
<html>

<head>
<title>Xplorers</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script src="/js/bootstrap.js"></script>
<link href="/css/bootstrap.css" rel="stylesheet"> 
<h1 ><?php
    if ($checkname == $_SESSION['xplo1']) {
        require("spcheck.php");
    }
?></h1>




<script type="text/javascript">
function deletepost(tableid)
{
var page_table="<?php
    echo ($checkname);
?>";
var buttonname=document.getElementById("deletepost_"+tableid);
var condition=buttonname.getAttribute("name");
$.ajax({
	type:"POST",
	url:"judgement.php",
	data:{submit:condition,page:page_table,value_table:tableid},
	success:function(result){
		alert(result);
		$("#Post_no_"+tableid).hide();
	}
});
}

</script>
<script type="text/javascript">
function insert_reply(postno,commentno)
{var pagename="<?php
    echo ($checkname);
?>";
    var comment_date="<?php
    echo (date("d-m", strtotime(now)));
?>";
    var loggedin="<?php
    echo ($_SESSION['xplo1']);
?>";
	 var comment= $('#commentarea'+postno).val();
	$.ajax({
		type:"POST",
		url:"judgement.php",
		dataType: 'json',
		data:{id:pagename,posttableno:postno,commentss:comment,submit:"insertreply"},
		success:function(resultreceived)
		{
		
			var html='<li id="subcomment_no_'+resultreceived.id_comment+'" class="media" style=" margin-bottom: 1px;background-color:#EDEFF4;margin-left: 50px;margin-top: 0px;"><img  style="width: 32px; height: 32px; padding-top: 5px; padding-left: 5px; padding-right: 0px; margin-right: 5px;" class="pull-left" style="width: 32px; height: 32px;" alt="http://www.xplorers.host56.com/xplmemb/'+loggedin+'/'+loggedin+'.gif" src="http://www.xplorers.host56.com/xplmemb/'+loggedin+'/'+loggedin+'.jpg"/><div class="media-body"><h6 class="media-heading"> </h6><p style="font-size:12px;word-wrap:break-word;padding-right: 10px;"><strong>'+loggedin+'</strong>&nbsp;'+ resultreceived.comments+ '<input type="button"  id="erase'+resultreceived.id_comment+'" class="btn" style="float:right;"  onClick="javascript:des('+postno+ ',' +resultreceived.id_comment+')" value="erase" /></p><p style="font-size:12px;color:#3B5998;">'+comment_date+'</p></div></li>';
			
				$("#commentfieldno"+postno).prepend(html);
				$('#commentarea'+postno).val('');
		}
		
		
	
	});
}

	
</script>
<script type="text/javascript">
function des(a,b){

var c ="<?php
    echo ($checkname);
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


</head>
<body>

<div class="navbar navbar-fixed-top" >
	 <div class="navbar-inner"> 
	<div class="container" style="margin-left: 30px;">
		<a class="brand" href="#">Xplorers</a> 
		 <div class="nav-collapse"> 
		 <ul class="nav"> 
		 <li class="active">
		<li><a href="home.php">Home</a></li>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="http://www.xplorers.host56.com/xplmemb/xplorercomments/xplorercomments.html?user=xplorercomments">TimepassBoard</a></li>
</li>
</ul>
</div>
</div>
</div>
</div>

<div class="container" style="margin-left: 25px;">


<div class="row-fluid">  

<div class="span3">  
          
   
<div class="well sidebar-nav" style="background-color: rgb(255, 255, 255); border-width: 5px 0px 0px; margin-top: 0px; padding: 0px; margin-bottom: 0px;">

<div class="thumbnail" style="width: 130px; height: 140px; margin-top: 60px;">
	
<img  src="http://www.xplorers.host56.com/<?php
    echo ($profilepic);
?>" /> 
</div>

<?php
    if (($_GET['user']) == ($_SESSION['xplo1'])) {
?>
		

	<div id="Uploadpic" class="modal hide fade in" style="display: none; ">		
<div class="modal-header">
<a class="close" data-dismiss="modal">x</a>
<h3>Select Profile Pic</h3>
</div>
<form method="post" action="upload1.php" enctype="multipart/form-data">	
<div class="modal-body">

	<label>Filename:</label>
<input type="file" name="file" id="file" /> 		        
</div>
<div class="modal-footer">
<p>Supported Format:jpeg,gif</p>
<p>Maximum size:2 mb</p>	
<input type="submit" name="submit" value="Upload" class="btn btn-success"/>
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
    require('dbconnect.php');
    $dis = $conn->prepare("SELECT `memid`,`uname`,`pagepath`,`time`,`sess` FROM xplomembers WHERE `memid` ORDER BY `memid` ASC");
    $dis->execute();
    $dis->bind_result($nameid, $namedis, $hreflink, $time, $ses);
    while ($dis->fetch()) {
?>

<li>
<a   href="http://www.xplorers.host56.com/<?php
        echo ($hreflink);
?>">
<?php
        echo ($namedis);
?>
        </a>
        </li>
        
        <?php
    }
    $conn->close();
}
?>
</ul>
</div>
</div>

</div>

<div id="span9" class="span9">
	
<div class="thumbnail" style="margin-top: 0px; border-top-width: 0px; border-left-width: 1px; margin-left: -20px; padding-top: 80px; border-right-width: 0px; padding-left: 80px;">

<form class="well" method="post" action="insertcomments.php" style="width: 350px;">
<label><textarea style="resize:none" name="textinpu" placeholder="Type something"></textarea></label>
<input type="submit" class="btn btn-primary "  name="submit" value="post"/> 
<input type="hidden" value="<?php
echo ($checkname);
?>" name="id"/>  
</form>
<?php
require('displaycomments.php');
?>
</div>

</div>

</div>
</div>
</body>
</html>

