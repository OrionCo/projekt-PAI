<?php
    session_start();
    require("connect.php");

    if(mysqli_connect_errno()){
        die('Failed to connect to database: ' . mysqli_connect_error());
    }
    if(!isset($_POST['username'], $_POST['password'], $_POST['email'])){
        $_SESSION['error'] = "Please fill in every field.";
        header('location: register.php');
    }

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    
    if(!$email){
        $_SESSION['error'] = "The e-mail you have provided is not valid.";
        header('location: register.php');
    }

    if ($stmt = $con->prepare('SELECT `User_id` FROM users WHERE `Username` = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $_SESSION['error'] = 'Account with associated e-mail or username  already exists, choose another.';
            header("Location: register.php");
        } else {
            if($stmt = $con->prepare('SELECT `User_id` FROM users WHERE `E-mail` = ?')){
                $stmt->bind_param('s', $_POST['email']);
                $stmt->execute();
                $stmt->store_result();

                if($stmt->num_rows > 0){
                    $_SESSION['error'] = 'Account with associated e-mail or username  already exists, choose another.';
                    header("Location: register.php");
                } else {
                    if ($stmt = $con->prepare('INSERT INTO `users` (Username, Hashed_pass, `E-mail`) VALUES (?, ?, ?)')){
                        $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
                        $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
                        $stmt->execute();

                        if($stmt = $con->prepare('SELECT `User_id` FROM users WHERE `E-mail` = ?')){
                            $stmt->bind_param('s', $_POST['email']);
                            $stmt->execute();
                            $stmt->store_result();

                            if($stmt->num_rows() > 0){
                                $stmt->bind_result($id);
                                $stmt->fetch();
                                
                                if($stmt = $con->prepare("INSERT INTO `user_level` (`User_id`, `Is_admin`) VALUES (?, DEFAULT)")){
                                    $stmt->bind_param('s', $id);
                                    $stmt->execute();
                                    $_SESSION['error'] = "User account has been registered.";

                                    header('Location: landing-page.php');
                                }
                            }
                        }
                    }
                }
            }
            $stmt->close();
        }
    } else {
        echo 'Could not prepare statement';
    }

?>