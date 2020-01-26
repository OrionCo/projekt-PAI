<!DOCTYPE html>
<html lang="pl">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Landing page</title>
        <style>
            html, body{
                height: 100%;
            }
        </style>
        <script type="text/javascript" src="bcgscript.js"></script>
    </head>
    <body>
        <form id="loginDiv" method="post" action="authenticate.php">
            <div class='labels'>
                <input class="logincreds" type="text" name="username" id="username" placeholder="Username:" required>
                <span class="bar"></span>
                <label for="username">username:</label>
            </div>
            <br>
            <div class='labels'>
                <input class="logincreds" type="password" name="password" id="password" placeholder="Password:" required>
                <span class="bar"></span>
                <label for="password">password:</label>
            </div>
            <div class='labels'>
                <a id="forgot" href="recover.html">Forgot password?</a>
            </div>
            <br>
            <input id="loginbtn" class="logincreds" type="submit" value="Log in">
            <br>
            <br>
            <div class="labels">
                <hr class="line">
            </div>
            <span id="noAcc">Don't have an account?</span>
            <a href="" id="register">Register</a>
        </form>
        <script type="text/javascript">
            landingChangeIt();
        </script>
    </body>
</html>