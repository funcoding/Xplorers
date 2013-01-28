<?php
session_start();
if (isset($_SESSION['userid'])) {
    deletecomment();
}
function deletecomment()
{
    $current_user = $_SESSION['xplo1'];
    $num2         = $_POST['con'];
    $table_to_del = $_POST['id'];
    $person1      = $_POST['user'];
    require('include/dbconnect.php');
    $query = $conn->prepare("DELETE  FROM `commentsforpost` WHERE `reply_id`=?");
    echo ($conn->error);
    $query->bind_param("i", $table_to_del);
    echo ($conn->error);
    $query->execute();
    $conn->close();
    echo json_encode(array(
        "success"
    ));
}
?>
