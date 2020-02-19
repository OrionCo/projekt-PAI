<?php
    session_start();
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "projekt";

    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(mysqli_connect_errno()){
        die('Failed to connect to database: ' . mysqli_connect_error());
    }

    if(!isset($_POST['username'], $_POST['password'])){
        $_SESSION['error'] = "Please fill in every field.";
        header('location: landing-page.php');
    }

    if($stmt = $con->prepare("SELECT u.`User_id`, `Hashed_pass`, `Is_admin` FROM users u LEFT JOIN user_level ul ON u.User_id = ul.User_id WHERE `Username` = ?")){
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $stmt->bind_result($id, $password, $isadmin);
            $stmt->fetch();
            
            if(password_verify($_POST['password'], $password)){
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                $_SESSION['isadmin'] = $isadmin;
                
                if($isadmin == 1){
                    header('Location: admin-panel.php');
                } else {
                    header('Location: user-panel.php');
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