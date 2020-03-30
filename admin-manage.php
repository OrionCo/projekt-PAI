<?php

session_start();
require_once("connect.php");

if(isset($_POST['username']) && (isset($_POST['email'])) && (isset($_POST['userId']))){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    
    if(!$email){
        $_SESSION['error'] = "The e-mail you have provided is not valid.";
        header('location: admin-manage.php');
    } else {
        $username = $_POST['username'];
        $userId = $_POST['userId'];
        if(isset($_POST['isAdmin'])) $isAdmin = 1;
        if(isset($_POST['userStatus'])) $userStatus = 1;
    
        if($stmt = $con->prepare("UPDATE `users` SET `Username` = ?, `E-mail` = ?, `Is_active` = ? WHERE `User_id` = ?")){
            $stmt->bind_param('sssi', $username, $email, $userStatus, $userId);
            $stmt->execute();
    
            if($stmt = $con->prepare("UPDATE `user_level` SET `Is_admin` = ? WHERE `User_id` = ?")){
                $stmt->bind_param('ii', $isAdmin, $userId);
                $stmt->execute();
                $_SESSION['error'] = "Changes have been saved.";
                header('location: admin-manage.php');
            }
        }
    }
} else {
    require("header.php");
    echo "<div class='error'>";
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
    }
    echo "</div>";

    if($stmt = $con->prepare("SELECT u.`User_id`, `Username`, `E-mail`, `Is_active`, `Is_admin` FROM `users` u LEFT JOIN `user_level` ul ON (u.`User_id` = ul.`User_id`)")){
        $stmt->execute();
        $stmt->store_result();
    
        if($stmt->num_rows() > 0){
            $stmt->bind_result($id, $username, $email, $isActive, $userLevel);
            echo "<div class='list'>";
            while($stmt->fetch()){
                if($isActive == 1){
                    $userStatus = "active";
                    $statusCheckbox = "checked";
                } else {
                    $userStatus = "suspended";
                    $statusCheckbox = "";
                }
    
                if($userLevel == 1){
                    $isAdmin = "yes";
                    $isAdminCheckbox = "checked";
                } else {
                    $isAdmin = "no";
                    $isAdminCheckbox = "";
                }
    
                echo <<< list
                <div class='listItem'>
                    <span class="itemName">$username</span>
                    <span class="itemOpen"><i class="icofont-plus-square"></i> More</span>
                </div>
                <section class='itemInfo'>
                    <div class="infoName">
                        <span>Username:</span>
                        <span>E-mail:</span>
                        <span>Admin:</span>
                        <span>Status:</span>
                        <a class="editInfo" href="javascript:void(0)">Edit</a>
                    </div>
                    <div class="infoContent">
                        <span>$username</span>
                        <span>$email</span>
                        <span>$isAdmin</span>
                        <span>$userStatus</span>
                    </div>
                    <form class="infoContent editForm" action="" method="post" name="editAcc">
                        <input type="text" name="username" placeholder="username.." value="$username" required />
                        <input type="text" name="email" placeholder="email.." value="$email" required />
                        <input type="checkbox" name="isAdmin" value="checked" $isAdminCheckbox />
                        <input type="checkbox" name="userStatus" value="checked" $statusCheckbox />
                        <input type="hidden" name="userId" value="$id" />
                        <input type="submit" class="editInfo" value="Submit" />
                    </form>
                </section>
                list;
            }
            echo "</div>";
        }
    }
    if(isset($_SESSION['error'])) unset($_SESSION['error']);
    require("footer.php");
}

?>