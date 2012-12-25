<?php
if ($_POST['thuuku']) {
    session_start();
    $submit = $_POST['thuuku'];
    $comment_id    = $_POST['valueup'];
    $person   = $_POST['id'];
    require("dbconnect.php");
    require("dbcomment.php");
    $who1 = $conn->prepare("SELECT nstable FROM xplomembers WHERE uname=?");
    
    $who1->bind_param("s", $person);
    $who1->execute();
    $who1->store_result();
    $who1->bind_result($todel);
    while ($who1->fetch()) {
		$del_sub_comments=$conn->prepare("SELECT `posttime` FROM $todel WHERE id=?");
		$del_sub_comments->bind_param("i",$comment_id);
		$del_sub_comments->execute();
		$del_sub_comments->bind_result($post_time_1);
		$del_sub_comments->store_result();
		while($del_sub_comments->fetch())
		{$conn->query("DELETE FROM `userreplies` WHERE `posttime`=$post_time_1");}
		$del_sub_comments->free_result();
        $query1 = $conn->prepare("DELETE FROM $todel WHERE id=?");
        $query1->bind_param("i", $comment_id);
        $query1->execute();
        $conn->close();
        
       header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} elseif ($_POST['submit']) {
    session_start();
    
    $submit     = $_POST['submit'];
    $member     = $_SESSION['xplo1'];
    $comments   = $_POST['commentss'];
    $member_page=$_POST['id'];
    $x="badboy";
    if (!isset($_SESSION['xplo1'])) {
        header("url=http://xplorers.host56.com");
    } else { 
        if (isset($submit)) {
            if (isset($comments)) {
				require("dbconnect.php");
				$post_table=$_POST['valueup'];
				$get_id=$conn->prepare("SELECT `nstable` FROM `xplomembers` WHERE `uname`=?");
				echo($conn->error);
				$get_id->bind_param("s",$member_page); 
				$get_id->execute();
				$get_id->bind_result($p_table);
				$get_id->store_result();
				echo("j");
				while($get_id->fetch())
				{echo("k");
				$get_time=$conn->prepare("SELECT `posttime` FROM `$p_table` WHERE `id`=?");
				echo($conn->error);
				$get_time->bind_param("i",$post_table);
				$get_time->execute();
				$get_time->bind_result($post_time);
				$get_time->store_result();
				$get_id->free_result();
				while($get_time->fetch())
                {$insert_comments1 = $conn->prepare("INSERT INTO `userreplies` (`posttime`,`whoo`,`whatt`) VALUES (?,?,?)");
                echo($conn->error);
                echo($post_time);
                 $insert_comments1->bind_param("iss", $post_time,$member, $comments);
                $insert_comments1->execute();
                
			}}
				
			$get_time->free_result();
               $conn->close();
                
 
		       } 
            }
         header("Location: {$_SERVER['HTTP_REFERER']}");}
    }
?>
