<?php
    session_start();
    require('connect.php');
    $_SESSION['setId'] = $_POST['setId'];
    if(isset($_POST['newTerm']) && isset($_POST['newDefinition']) && $_POST['newTerm'] !== "" && $_POST['newDefinition'] !== ""){
        if($stmt = $con->prepare("INSERT INTO `terms` VALUES (NULL, ?)")){
            $stmt->bind_param('s', $_POST['newTerm']);
            $stmt->execute();
            $stmt->close();

            if($stmt = $con->prepare("SELECT `Term_id` FROM `terms` WHERE `Term_name` = ?")){
                $stmt->bind_param('s', $_POST['newTerm']);
                $stmt->execute();
                $stmt->bind_result($termId);
                $stmt->fetch();
                $stmt->close();
                
                if($stmt = $con->prepare("INSERT INTO `definitions` VALUES (NULL, ?, ?)")){
                    $stmt->bind_param('si', $_POST['newDefinition'], $termId);
                    $stmt->execute();
                    $stmt->close();

                    if($stmt = $con->prepare("INSERT INTO `set_pairs` VALUES (?, ?)")){
                        $stmt->bind_param('ii', $_POST['setId'], $termId);
                        $stmt->execute();
                        $stmt->close();
                        unset($_SESSION['error']);
                        header("location: set.php");
                    }
                }
            }
        }
    } else {
        $_SESSION['error'] = "Please specify both fields.";
        header("location: set.php");
    }
?>