<?php
if ($_POST['thuuku']) {
    session_start();
    $submit = $_POST['thuuku'];
    $nid    = $_POST['valueup'];
    $name   = $_POST['id'];
    require('dbconnect.php');
    $who1 = $conn->prepare("SELECT `nstable` FROM xplomembers WHERE uname=`(?)`");
    $who1->bind_param("s", $name);
    $who1->execute();
    $who1->store_result();
    $who1->bind_result($som);
    while ($who1->fetch()) {
        $query1 = $conn->prepare("DELETE FROM `$som` WHERE id=`(?)`");
        $query1->bind_param("i", $nid);
        $query1->execute();
        $conn->close();
        require("dbcomment.php");
        $comment_table = $nid . $som;
        $query2        = $comm->prepare("DROP TABLE `(?)` ");
        $query2->bind_param("s", $comment_table);
        $query2->execute();
        $comm->close();
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} elseif ($_POST['submit']) {
    session_start();
    $submit     = $_POST['submit'];
    $comment_id = $_POST['valueup'];
    $name2      = $_POST['tna'];
    $merg       = $comment_id . $name2;
    $member     = $_SESSION['xplo1'];
    $comments   = $_POST['commentss'];
    if (!isset($_SESSION['xplo1'])) {
        header("url=http://xplorers.host56.com");
    } else {
        if (isset($submit)) {
            if (isset($comments)) {
                require('dbcomment.php');
                $insert_comments1 = $comm->prepare("INSERT INTO `(?)` (`whoo`,`whatt`) VALUES (?,?)");
                if ($insert_comments1) {
                    echo ($merg . '<br>' . $member . '<br>' . $comments);
                    $insert_comments1->bind_param("sss", $merg, $member, $comments);
                    $insert_comments1->execute();
                    $insert_comments1->free_result();
                } else {
                    echo ("here");
                    $create_table = $comm->prepare("CREATE TABLE `(?)` (`id` INT(3) NOT NULL AUTO_INCREMENT,
`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`whoo` VARCHAR(50) NOT NULL, `whatt` VARCHAR(500) NOT NULL,
PRIMARY KEY (`id`))");
                    if (!$create_table) {
                        echo ($comm->error);
                    }
                    $create_table->bind_param("s", $merg);
                    $create_table->execute();
                }
                $comm->close();
            }
        }
    }
}
?>
