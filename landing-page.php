<?php require("credentialheader.php") ?>
        <form id="loginDiv" method="post" action="authenticate.php">
            <div class='labels'>
                <div class="error">
                    <?php
                        if(isset($_SESSION['error'])){
                            echo $_SESSION['error'];
                        }
                    ?>
                </div>
                <input class="logincreds" type="text" name="username" id="username" placeholder="Username:" required>
                <span class="bar"></span>
                <label for="username">username:</label>
            </div>
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
            <a href="register.php" id="register">Register</a>
        </form>
<?php require("credentialfooter.php") ?>