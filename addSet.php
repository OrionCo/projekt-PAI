<?php
session_start();
require("connect.php");

if(isset($_POST['setName']) && $_POST['setName'] !== ""){
    $setName = $_POST['setName'];
    $date = date("Y-m-d");
    if($stmt = $con->prepare("SELECT `User_id` FROM `users` WHERE `Username` = ?")){
        $stmt->bind_param('s', $_SESSION['name']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        if($stmt = $con->prepare("INSERT INTO `sets` VALUES (NULL, ?, ?, ?)")){
            $stmt->bind_param('sis', $setName, $id, $date);
            $stmt->execute();
            $stmt->close();

            $_SESSION['error'] = "The set has been created.";
            header("location: user-sets.php");
        } else {
            $_SESSION['error'] = "insert query invalid";
            header("location: user-sets.php");
        }
    }
} else {
    $_SESSION['error'] = "Please specify set name";
    header("location: user-sets.php");
}

?>