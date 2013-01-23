<?php
session_start();
$check_id = $_POST['id'];
$name_id      = $_SESSION['userid'];
$text      = $_POST['textinpu'];
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
            }
            $conn->close();
            $cmmname->free_result();
            $action->free_result();
        }
    }
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
?>
