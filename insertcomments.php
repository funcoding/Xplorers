<?php
session_start();
$check_id = $_POST['id'];
$name_id  = $_SESSION['userid'];
$text     = $_POST['textinpu'];
if (!isset($_SESSION['userid'])) {
    header("url=http://xplorers-appsbyvinay.rhcloud.com");
} else {
    require('include/dbconnect.php');
    $submit = $_POST['submit'];
    if (isset($submit)) {
        if (!empty($text)) {
            $cmmname = $conn->prepare("SELECT `member_table` FROM `members` WHERE `memid`=?");
            $cmmname->bind_param("s", $check_id);
            $cmmname->execute();
            $cmmname->store_result();
            $cmmname->bind_result($commenttable);
            $time_of_post = strtotime(now);
            while ($cmmname->fetch()) {
                $action = $conn->prepare("INSERT INTO `$commenttable`(`member_posts`,`member_posted`,`unix_time`) VALUES (?,?,$time_of_post)");
                if (!$actions) {
                    echo ($conn->error);
                }
                $action->bind_param("ss", $text, $name_id);
                $action->execute();
                $result = $conn->prepare("SELECT `member_posts`,`post_id` FROM `$commenttable` WHERE `unix_time`=$time_of_post");
                if (!$result) {
                    echo ($conn->error);
                }
                $result->execute();
                $result->bind_result($post, $id_post);
                while ($result->fetch()) {
                    echo (json_encode(array(
                        "POST" => htmlentities($post,ENT_QUOTES),
                        "ID" => $id_post
                    )));
                }
            }
        }
        $conn->close();
        $cmmname->free_result();
        $action->free_result();
        $result->free_result();
    }
}
?>
