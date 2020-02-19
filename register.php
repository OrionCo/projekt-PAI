<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <style>
            html, body{
                height: 100%;
            }
        </style>
        <script type="text/javascript" src="bcgscript.js"></script>
    </head>
    <body>
        <form id="loginDiv" method="post" action="registerscript.php">
            <div class="error">
            <?php
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                }
            ?>
            </div>
            <div class='labels'>
                <input class="logincreds" type="text" name="email" id="email" placeholder="E-mail:" required>
                <span class="bar"></span>
                <label for="email">E-mail:</label>
            </div>
            <div class='labels'>
                <input class="logincreds" type="text" name="username" id="username" placeholder="Username:" required>
                <span class="bar"></span>
                <label for="username">username:</label>
            </div>
            <div class='labels'>
                <input class="logincreds" type="password" name="password" id="password" placeholder="Password:" required>
                <span class="bar"></span>
                <label for="password">password:</label>
            </div>
            <br />
            <input id="loginbtn" class="logincreds" type="submit" value="Register">
            <br>
            <br>
            <div class="labels">
                <hr class="line">
            </div>
            <span id="noAcc">Already have an account?</span>
            <a href="landing-page.php" id="register">Log in</a>
        </form>
        <script type="text/javascript">
            landingChangeIt();
        </script>
    </body>
</html>

<?php 
    unset($_SESSION['error']);
?>