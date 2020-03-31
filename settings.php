<?php
    require("header.php");

    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['curPass'])){
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if(!$email){
            unset($_SESSION['error']);
            $_SESSION['error'] = "The e-mail you have provided is not valid.";
            header('location: settings.php');
        } else {
            $username = $_POST['username'];
            $curPass = $_POST['curPass'];
    
            if($stmt = $con->prepare("SELECT `Hashed_pass` FROM `users` WHERE `User_id` = ?")){
                $stmt->bind_param('i', $_SESSION['id']);
                $stmt->execute();
                $stmt->bind_result($hash);
                $stmt->fetch();
                $stmt->close();

                if(password_verify($curPass, $hash)){
                    if(isset($_POST['newPass']) && ($_POST['newPass'] !== "")){
                        if(isset($_POST['confirmPass']) && ($_POST['confirmPass'] !== "")){
                            if($_POST['newPass'] == $_POST['confirmPass']){
                                if($stmt = $con->prepare("UPDATE `users` SET `Hashed_pass` = ? WHERE `User_id` = ?")){
                                    $newPass = password_hash($_POST['newPass'], PASSWORD_ARGON2ID);
                                    $stmt->bind_param('si', $newPass, $_SESSION['id']);
                                    $stmt->execute();
                                    $stmt->close();

                                    if($stmt = $con->prepare("UPDATE `users` SET `Username` = ?, `E-mail` = ? WHERE `User_id` = ?")){
                                        $stmt->bind_param('sss', $username, $email, $_SESSION['id']);
                                        $stmt->execute();
                                        $_SESSION['name'] = $username;
                                        $stmt->close();
                                        unset($_SESSION['error']);
                                        $_SESSION['error'] = "Changes have been saved.";
                                        header("location: settings.php");
                                    }
                                }
                            } else {
                                unset($_SESSION['error']);
                                $_SESSION['error'] = "Passwords don't match.";
                                header("location: settings.php");
                            }
                        } else {
                            unset($_SESSION['error']);
                            $_SESSION['error'] = "Please confirm the new password before changing it.";
                            header("location: settings.php");
                        }
                    } else {
                        if($stmt = $con->prepare("UPDATE `users` SET `Username` = ?, `E-mail` = ? WHERE `User_id` = ?")){
                            $stmt->bind_param('sss', $username, $email, $_SESSION['id']);
                            $stmt->execute();
                            $_SESSION['name'] = $username;
                            $stmt->close();
                            unset($_SESSION['error']);
                            $_SESSION['error'] = "Changes have been saved.";
                            header("location: settings.php");
                        }
                    }
                } else {
                    unset($_SESSION['error']);
                    $_SESSION['error'] = "The password is incorrect";
                    header("location: settings.php");
                }
            }
        }
    } else {
        if($stmt = $con->prepare("SELECT `Username`, `E-mail`, `Hashed_pass` FROM `users` WHERE `User_id` = ?")){
            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0){
                $stmt->bind_result($username, $email, $hash);
                $stmt->fetch();
            }
        }
    }
?>
    <form action="" class="editProfile" name="editProfile" method="post">
        
        <h1 class="profileName"><i class="icofont-ui-user"></i>&nbsp;&nbsp;<?php echo $username; ?>'s profile</h1>
        <div class='labels editLabels'>
            <hr class="profileLine">
            <div class="error">
                <?php
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                    }
                ?>
            </div>
            <span class="profileInfo">Username:</span>
            <input class="logincreds infoInput" type="text" name="username" value="<?php echo $username; ?>" required>
            <span class="bar infoBar"></span>
        </div>
        <span class="profileInfo">E-mail:</span>
        <div class='labels editLabels'>
            <input class="logincreds infoInput" type="text" name="email" value="<?php echo $email; ?>" required>
            <span class="bar infoBar"></span>
        </div>
        <span class="profileInfo">Current password:</span>
        <div class='labels editLabels'>
            <input class="logincreds infoInput" type="password" name="curPass"  required>
            <span class="bar infoBar"></span>
        </div>
        <span class="profileInfo">New password:</span>
        <div class='labels editLabels'>
            <input class="logincreds infoInput" type="password" name="newPass">
            <span class="bar infoBar"></span>
        </div>
        <span class="profileInfo">Confirm password:</span>
        <div class='labels editLabels'>
            <input class="logincreds infoInput" type="password" name="confirmPass">
            <span class="bar infoBar"></span>
        </div>
        <input class="editInfo" type="submit" value="Submit" />
    </form>
<?php
    require("footer.php");
?>