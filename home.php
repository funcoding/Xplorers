<?php
session_start();
if (isset($_SESSION['xplo1'])) {
    Home();
} else {
    header("Location:http://www.xplorers.host56.com");
}
function Home()
{
    require("dbconnect.php");
    $user_logged = $_SESSION['xplo1'];
    $home        = $conn->prepare("SELECT `pagepath` FROM xplomembers WHERE uname=?");
    $home->bind_param("s", $user_logged);
    $home->execute();
    $home->bind_result($userurl);
    while ($home->fetch()) {
        header("Location:http://www.xplorers.host56.com/$userurl");
    }
    $conn->close();
}
?>
