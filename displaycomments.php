<?php
require("include/dbconnect.php");
$current_login = $_SESSION['userid'];
$user_id       = $_GET['user'];
if ((!isset($_SESSION['userid'])) && ($_SESSION['userid'] == '')) {
    $conn->close();
    header("location:index.php");
} else {
    $user_table = $conn->prepare("SELECT member_table from members where memid=?");
    $user_table->bind_param("s", $user_id);
    $user_table->execute();
    $user_table->bind_result($table);
    $user_table->store_result();
    while ($user_table->fetch()) {
        $disptable = $conn->prepare("SELECT `member_posts`,`unix_time`,`member_posted`,`post_id`,members.member_name  FROM `$table` INNER JOIN members ON `$table`.`member_posted`=members.memid ORDER BY post_id DESC");
        if (!$disptable) {
            echo ($conn->error);
        }
        if ($disptable) {
            $disptable->bind_result($posts, $time, $member, $idtable, $post_by);
            $disptable->execute();
            $disptable->store_result();
            while ($disptable->fetch()) {
?>

<div id="Post_no_<?php
                echo ($idtable);
?>">



<?php
                $dtime = date("d-m", $time);
?>
<?php
                $imagelocation = getenv('OPENSHIFT_DATA_DIR');
                if ($current_login == $member) {
                    echo ('<div id="media' . $idtable . '"class="media"><img  class="pull-left" style="width: 50px; height: 50px;" alt="/profilepics/' . $member . '.gif" src="/profilepics/' . $member . '.jpg"/>' . '<div class="media-body"><h4 class="media-heading"> ' . $post_by . '<input   type="button" name="thuuku" class="btn" onClick="javascript:deletepost(' . $idtable . ')" style="float:right" id="deletepost_' . $idtable . '" value="Delete"/>' . '
</h4>' . '<p>' . htmlentities($posts, ENT_QUOTES) . '</p><p style="font-size:12px;color:#3B5998;">' . $dtime . '</p>' . '</div></div>');
                } else {
                    echo ('<div id="media' . $idtable . '"class="media"><img  class="pull-left" style="width: 50px; height: 50px;" alt="/profilepics/' . $member . '.gif" src="/profilepics/' . $member . '.jpg"/>' . '<div class="media-body"><h4 class="media-heading"> ' . $post_by . '
</h4>' . '<p>' . htmlentities($posts, ENT_QUOTES) . '</p><p style="font-size:12px;color:#3B5998;">' . $dtime . '</p>' . '</div></div>');
                }
                echo ($conn->error);
                if ($querry2 = $conn->prepare("SELECT `members`.member_name,member_commented,  member_comments, comments_time,reply_id
FROM commentsforpost
JOIN members ON members.memid=commentsforpost.member_commented
WHERE `post_time` = $time")) {
                    echo ($conn->error);
                    $querry2->execute();
                    $querry2->bind_result($name_of_member, $member_comment_id, $display_comments, $time_of_comment, $id1);
                    $querry2->store_result();
                    while ($querry2->fetch()) {
                        $dtime2 = date("d-m", strtotime($time_of_comment));
                        if ($member_comment_id == $current_login) {
                            echo ('<li id="subcomment_no_' . $id1 . '" class="media" style=" margin-bottom: 1px;background-color:#EDEFF4;margin-left: 50px;margin-top: 0px;">
                        <img  style="width: 32px; height: 32px; padding-top: 5px; 
                        padding-left: 5px; padding-right: 0px; margin-right: 5px;" 
                        class="pull-left" style="width: 32px; height: 32px;" 
                        alt="/profilepics/' . $member_comment_id . '.gif" src="profilepics/' . $member_comment_id . '.jpg"/>' . '<div class="media-body"><h6 class="media-heading"> </h6><p style="font-size:12px;word-wrap:break-word;padding-right: 10px;">' . '<strong>' . htmlspecialchars($name_of_member) . '</strong>' . " " . htmlentities($display_comments) . '<input type="button"  id="erase' . $id1 . '" class="btn" style="float:right;"  onClick="javascript:des(' . $idtable . ',' . $id1 . ')" value="erase" /></p><p style="font-size:12px;color:#3B5998;">' . $dtime2 . '</p></div></li>');
                        } else {
                            echo ('<li id="subcomment_no_' . $id1 . '" class="media" style=" margin-bottom: 1px;background-color:#EDEFF4;margin-left: 50px;margin-top: 0px;">
                        <img  style="width: 32px; height: 32px; padding-top: 5px; padding-left: 5px; padding-right: 0px; margin-right: 5px;" class="pull-left" style="width: 32px; height: 32px;" 
                        alt="/profilepics/' . $member_comment_id . '.gif" src="/profilepics/' . $member_comment_id . '.jpg"/>' . '<div class="media-body"><h6 class="media-heading"> </h6><p style="font-size:12px;word-wrap:break-word;padding-right: 10px;">' . '<strong>' . htmlspecialchars($name_of_member) . '</strong>' . " " . htmlentities($display_comments) . '</p><p style="font-size:12px;color:#3B5998;">' . $dtime2 . '</p></div></li>');
                        }
                    }
?>

 <?php
                    $querry2->free_result();
                }
?>


<div id="commentfieldno<?php
                echo ($idtable);
?>">
<textarea placeholder="Comment"  id="commentarea<?php
                echo ($idtable);
?>" style="resize: none;margin-bottom: 1px; margin-left: 50px; margin-top: 0px; height: 40px; width: 572px;" name="commentss"></textarea>
</div>
<input  style="float:right" class="btn" type="button" name="insertreply"  value="Comment" onClick="insert_reply(<?php
                echo ($idtable);
?>);"/>
<br>
<hr>
</div>

<?php
            }
        }
    }
}
?>
