<?php
session_start();
include("connect.php");
if(isset($_POST['email']) && (!empty($_POST['email']))){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if(!$email){
        $_SESSION['error'] = "The e-mail you have provided is not valid.";
    } else {
        if($stmt = $con->prepare("SELECT `Username` FROM `users` WHERE `e-mail` = ?")){
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0){
                $stmt->bind_result($username);
                $expFormat = mktime(
                    date('H'), date('i'), date('s'), date('m'), date('d') + 1, date("Y")
                );
                $expDate = date("Y-m-d H:i:s", $expFormat);
                $key = md5(2418*2 . $email);
                $addKey = substr(md5(uniqid(rand(),1)), 3, 10);
                $key = $key . $addKey;

                if($stmt = $con->prepare("INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES (?, ?, ?)")){
                    $stmt->bind_param('sss', $email, $key, $expDate);
                    $stmt->execute();
                    $output = "<p>Dear $username,</p>";
                    $output .= "<p>Please click on the following link to reset your password:</p>";
                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $link = "https";
                    else{
                        $link = "http";
                    }
                    $link .= "://";
                    $link .= $_SERVER["HTTP_HOST"];
                    $link .= $_SERVER['REQUEST_URI'];
                    $link = str_replace(basename($_SERVER["REQUEST_URI"]), "", $link);
                    $output .= "<p><a href='$link" . "reset-password.php?key=$key&email=$email&action=reset' target='_blank'>$link" . "reset-password.php?key=$key&email=$email&action=reset</a></p>";
                    $output .= "<p>Please click the link or copy it into your browser. The link will expire after 1 day for security reasons.</p>";
                    $output .= "<p>If you did not request this forgotten password email, no action is needed; your password will not be reset. However, you may want to log into your account and change your security password as someone may have guessed it.</p>";
                    $output .= "<p>Thank you,</p>";
                    $output .= "<p>The Team</p>";
                    $body = $output;
                    $subject = "Password Recovery - teamwords.com";
                    
                    $email_to = $email;
                    $fromserver = "noreply@teamwords.com";
                    require("PHPMailer/PHPMailerAutoload.php");
                    $mail = new PHPMailer();
                    $mail ->IsSMPT();
                    $mail->Host = "mail.teamwords.com";
                    $mail->SMTPAuth = true;
                    $mail->Username = "noreply@teamwords.com";
                    $mail->Password = "password";
                    $mail->Port = 25;
                    $mail->IsHTML(true);
                    $mail->From = "noreply@teamwords.com";
                    $mail->FromName = "TeamWords";
                    $mail->Sender = $fromserver;
                    $mail->Subject = $subject;
                    $mail->Body = $body;
                    $mail->AddAddress($email_to);
                    if(!$mail->Send()){
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        $_SESSION['error'] = "An email has been sent to you with instructions on how to reset your password.";
                        unset($_POST['email']);
                        header("location: recover.php");
                    }
                }
            } else {
                $_SESSION['error'] = "User with associated e-mail does not exist.";
                unset($_POST['email']);
                header("location: recover.php");
            }
        }
    }
} else {

require("credentialheader.php");
?>

<form id="loginDiv" method="post" action="" name="reset">
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
    <br />
    <input id="loginbtn" class="logincreds" type="submit" value="Reset Password">
    <br>
    <br>
    <div class="labels">
        <hr class="line">
    </div>
    <span id="noAcc">Remember it after all?</span>
    <a href="landing-page.php" id="register">Log in</a>
</form>


<?php
require("credentialfooter.php");
}
?>