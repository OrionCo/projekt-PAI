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

    if(!isset($_POST['username'], $_POST['password'], $_POST['email'])){
        header('location: register.php');
    }

    if ($stmt = $con->prepare('SELECT `User_id`, `Hashed_pass` FROM users WHERE `Username` = ?')) {
        
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo 'Username already exists, choose another.';
        } else {
            if ($stmt = $con->prepare('INSERT INTO `users` (Username, Hashed_pass, `E-mail`) VALUES (?, ?, ?)')){
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
                $stmt->execute();
                header('Location: landing-page.php');
        }
        $stmt->close();
        }
    } else {
        echo 'Could not prepare statement';
    }

?>