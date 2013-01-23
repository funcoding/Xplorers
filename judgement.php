<?php
if ($_POST['submit'] == "thuuku") {
    deletePosts();
} elseif ($_POST['submit'] == "insertreply") {
    postReplies();
}
function postReplies()
{
    session_start();
    $submit      = $_POST['submit'];
    $member      = $_SESSION['userid'];
    $comments    = $_POST['commentss'];
    $member_page = $_POST['id'];
    if (!isset($_SESSION['userid'])) {
        header("url=http://xplorers-appsbyvinay.rhcloud.com");
    } else {
        if (isset($submit)) {
            if (!empty($comments)) {
                require("include/dbconnect.php");
                $post_table = $_POST['posttableno'];
                $get_id     = $conn->prepare("SELECT `member_table` FROM `members` WHERE `memid`=?");
                $get_id->bind_param("s", $member_page);
                $get_id->execute();
                $get_id->bind_result($p_table);
                $get_id->store_result();
                while ($get_id->fetch()) {
                    $get_time = $conn->prepare("SELECT `unix_time` FROM `$p_table` WHERE `post_id`=?");
                    $get_time->bind_param("i", $post_table);
                    $get_time->execute();
                    $get_time->bind_result($post_time);
                    $get_time->store_result();
                    $get_id->free_result();
                    while ($get_time->fetch()) {
                        $insert_comments1 = $conn->prepare("INSERT INTO `commentsforpost` (`post_time`,`member_commented`,`member_comments`) VALUES (?,?,?)");
                        $insert_comments1->bind_param("iss", $post_time, $member, $comments);
                        $insert_comments1->execute();
                        $insert_comments1->store_result();
                        $get_inserted_comment = $conn->prepare("SELECT `reply_id`,`member_comments` FROM `commentsforpost` WHERE `comments_time`=NOW()");
                        $get_inserted_comment->execute();
                        $get_inserted_comment->bind_result($subcommentid, $user_comment);
                        $get_inserted_comment->store_result();
                        while ($get_inserted_comment->fetch()) {
                            $to_send = array(
                                "id_comment" => $subcommentid,
                                "comments" => htmlentities($user_comment)
                            );
                        }
                    }
                }
                $get_time->free_result();
                $conn->close();
                echo (json_encode($to_send));
                $insert_comments1->free_result();
                $get_inserted_comment->free_result();
            }
        }
    }
}
function deletePosts()
{
    session_start();
    $submit     = $_POST['thuuku'];
    $comment_id = $_POST['value_table'];
    $person     = $_POST['page'];
    require("include/dbconnect.php");
    $who1 = $conn->prepare("SELECT `member_table` FROM members WHERE memid=?");
    $who1->bind_param("i", $person);
    $who1->execute();
    $who1->store_result();
    $who1->bind_result($todel);
    while ($who1->fetch()) {
        $del_sub_comments = $conn->prepare("SELECT `unix_time` FROM `$todel` WHERE post_id=?");
        $del_sub_comments->bind_param("i", $comment_id);
        $del_sub_comments->execute();
        $del_sub_comments->bind_result($post_time_1);
        $del_sub_comments->store_result();
        while ($del_sub_comments->fetch()) {
            $conn->query("DELETE FROM `commentsforpost` WHERE `post_time`=$post_time_1");
        }
        $del_sub_comments->free_result();
        $query1 = $conn->prepare("DELETE FROM `$todel` WHERE post_id=?");
        $query1->bind_param("i", $comment_id);
        $query1->execute();
        $conn->close();
        echo (json_encode("Deleted"));
    }
}
?>
