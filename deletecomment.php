<?php
session_start();
if (isset($_SESSION['userid'])) {
    deletecomment();
}
function deletecomment()
{
  
    $table_to_del = $_POST['id'];
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
