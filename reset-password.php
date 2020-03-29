<?php
session_start();
require("connect.php");

if(isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET['action'] == 'reset') && !isset($_POST['action'])){
    $key = $_GET['key'];
    $email = $_GET['email'];
    $curDate = date("Y-m-d H:i:s");
    if($stmt = $con->prepare("SELECT `expDate` FROM `password_reset_temp` WHERE `key` = ? AND `email` = ?")){
        $stmt->bind_param('ss', $key, $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0 ){
            $stmt->bind_result($expDate);
            $stmt->fetch();

            if($expDate >= $curDate){
                require("credentialheader.php");
                ?>

                <form id="loginDiv" method="post" action="" name="update">
                    <div class='labels'>
                        <div class="error">
                            <?php
                                if(isset($_SESSION['error'])){
                                    echo $_SESSION['error'];
                                }
                            ?>
                        </div>
                        <input class="logincreds" type="text" name="email" id="email" placeholder="E-mail:" required>
                        <span class="bar"></span>
                        <label for="email">E-mail:</label>
                    </div>
                    <div class='labels'>
                        <input type="hidden" name="action" value="update">
                        <input class="logincreds" type="password" name="pass1" id="pass1" placeholder="Password:" required>
                        <span class="bar"></span>
                        <label for="pass1">password:</label>
                    </div>
                    <div class='labels'>
                        <input class="logincreds" type="password" name="pass2" id="pass2" placeholder="Confirm Password:" required>
                        <span class="bar"></span>
                        <label for="pass2">confirm password:</label>
                    </div>
                    <br>
                    <input id="loginbtn" class="logincreds" type="submit" value="Reset Password">
                </form>

                <?php
                require("credentialfooter.php");
            } else {
                $_SESSION['error'] = "The link has expired. You are trying to use an expired link which is valid for 24 hours after request.";
                header("location: landing-page.php");
            }
        } else {
            $_SESSION['error'] = "The link is invalid.";
            header("location: landing-page.php");
        }
        $stmt->close();
    }
} else {
    if(isset($_POST['email']) && isset($_POST['action']) && ($_POST['action'] == 'update')){
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $email = $_POST['email'];
        $curDate = date("Y-m-d H:i:s");
        if($pass1 != $pass2){
            $_SESSION['error'] = "Passwords do not match.";
            header("location: reset-password.php");
        } else {
            $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
    
            if($stmt = $con->prepare("UPDATE `users` SET `Hashed_pass` = ? WHERE `E-mail` = ?")){
                $stmt->bind_param('ss', $pass1, $email);
                $stmt->execute();
    
                if($stmt = $con->prepare("DELETE FROM `password_reset_temp` WHERE `email` = ?")){
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $stmt->close;
                    $_SESSION['error'] = "Password has been reset.";
                    header("location: landing-page.php");
                } else {
                    $_SESSION['error'] = "Could not prepare statement";
                    header("location: landing-page.php");
                }
            }
        }
    } else {
        $_SESSION['error'] = "The link is invalid or has expired.";
        header("location: landing-page.php");
    }
}



?>