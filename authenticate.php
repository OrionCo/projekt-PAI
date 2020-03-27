<?php
    session_start();
    require("connect.php");

    if(!isset($_POST['username'], $_POST['password'])){
        $_SESSION['error'] = "Please fill in every field.";
        header('location: landing-page.php');
    }

    if($stmt = $con->prepare("SELECT u.`User_id`, `Hashed_pass`, `Is_admin`, `Is_active` FROM users u LEFT JOIN user_level ul ON u.User_id = ul.User_id WHERE `Username` = ?")){
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $stmt->bind_result($id, $password, $isadmin, $isactive);
            $stmt->fetch();
            
            if(password_verify($_POST['password'], $password)){
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                $_SESSION['isadmin'] = $isadmin;

                if($isactive == 0){
                    $_SESSION['error'] = "Your account has been disabled.";
                    header('Location: landing-page.php');
                } else {
                    if($isadmin == 1){
                        header('Location: admin-panel.php');
                    } else {
                        header('Location: user-panel.php');
                    }
                }

            } else {
                $_SESSION['error'] = "Username doesn't exist or the provided password is incorrect.";
                header("location: landing-page.php");
            }
        } else {
            $_SESSION['error'] = "Username doesn't exist or the provided password is incorrect.";
            header("location: landing-page.php");
        }

        $stmt->close();
    }
?>