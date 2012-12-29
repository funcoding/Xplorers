<?php
session_start();
$checkname = $_POST['id'];
$name      = $_SESSION['xplo1'];
$text      = $_POST['textinpu'];
if (!isset($_SESSION['xplo1'])) {
    header("url=http://xplorers.host56.com");
} else {
    require('dbconnect.php');
    $submit = $_POST['submit'];
    if (isset($submit)) {
        if (!empty($text)) {
            $cmmname = $conn->prepare("SELECT `nstable` FROM `xplomembers` WHERE `uname`=?");
            $cmmname->bind_param("s", $checkname);
            $cmmname->execute();
            $cmmname->store_result();
            $cmmname->bind_result($cmmtable);
            $time = strtotime(now);
            while ($cmmname->fetch()) {
                $action = $conn->prepare("INSERT INTO `$cmmtable`(`nsense`,`coname`,`posttime`) VALUES (?,?,$time)");
                if (!$actions) {
                    echo ($conn->error);
                }
                $action->bind_param("ss", $text, $name);
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
