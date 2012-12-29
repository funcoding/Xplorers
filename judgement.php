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
    $member      = $_SESSION['xplo1'];
    $comments    = $_POST['commentss'];
    $member_page = $_POST['id'];
    if (!isset($_SESSION['xplo1'])) {
        header("url=http://xplorers.host56.com");
    } else {
        if (isset($submit)) {
            if (!empty($comments)) {
                require("dbconnect.php");
                $post_table = $_POST['posttableno'];
                $get_id     = $conn->prepare("SELECT `nstable` FROM `xplomembers` WHERE `uname`=?");
                $get_id->bind_param("s", $member_page);
                $get_id->execute();
                $get_id->bind_result($p_table);
                $get_id->store_result();
                while ($get_id->fetch()) {
                    $get_time = $conn->prepare("SELECT `posttime` FROM `$p_table` WHERE `id`=?");
                    $get_time->bind_param("i", $post_table);
                    $get_time->execute();
                    $get_time->bind_result($post_time);
                    $get_time->store_result();
                    $get_id->free_result();
                    while ($get_time->fetch()) {
                        $insert_comments1 = $conn->prepare("INSERT INTO `userreplies` (`posttime`,`whoo`,`whatt`) VALUES (?,?,?)");
                        $insert_comments1->bind_param("iss", $post_time, $member, $comments);
                        $insert_comments1->execute();
                        $insert_comments1->store_result();
                        $get_inserted_comment = $conn->prepare("SELECT `reply_id`,`whatt` FROM `userreplies` WHERE `time`=NOW()");
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
    require("dbconnect.php");
    $who1 = $conn->prepare("SELECT nstable FROM xplomembers WHERE uname=?");
    $who1->bind_param("s", $person);
    $who1->execute();
    $who1->store_result();
    $who1->bind_result($todel);
    while ($who1->fetch()) {
        $del_sub_comments = $conn->prepare("SELECT `posttime` FROM $todel WHERE id=?");
        $del_sub_comments->bind_param("i", $comment_id);
        $del_sub_comments->execute();
        $del_sub_comments->bind_result($post_time_1);
        $del_sub_comments->store_result();
        while ($del_sub_comments->fetch()) {
            $conn->query("DELETE FROM `userreplies` WHERE `posttime`=$post_time_1");
        }
        $del_sub_comments->free_result();
        $query1 = $conn->prepare("DELETE FROM $todel WHERE id=?");
        $query1->bind_param("i", $comment_id);
        $query1->execute();
        $conn->close();
        echo (json_encode("Deleted"));
    }
}
?>
