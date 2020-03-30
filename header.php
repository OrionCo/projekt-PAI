<?php
    if(session_id() == '' || !isset($_SESSION))
    session_start();
    include("connect.php");

    if(!isset($_SESSION['loggedin'])){
        header('location: landing-page.php');
        exit();
    }

    $path = $_SERVER['PHP_SELF'];
    $file = basename($path);

    if(strpos($file, "user") !== FALSE){
        if($_SESSION["isadmin"] == 1){
            header('location: admin-panel.php');
        }
        if($stmt = $con->prepare("SELECT `Set_name` FROM `sets` ORDER BY `Creation_date` DESC LIMIT 1")){
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0){
                $stmt->bind_result($lastSet);
                $stmt->fetch();
            }
        }
    } else if (strpos($file, "admin") !== FALSE){
        if($_SESSION["isadmin"] == 0){
            header('location: user-panel.php');
        }
    }

    if($_SESSION["isadmin"] == 1){
        $link1 = "admin-panel.php";
        $link2 = "admin-manage.php";
        $link3 = "admin-settings.php";
        $panelName = "Admin Panel";
        $menuVar = "Manage Accounts";
    } else {
        $panelName = "User Panel";
        $menuVar = "Sets";
        $link1 = "user-panel.php";
        $link2 = "user-sets.php";
        $link3 = "user-settings.php";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="icons.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $panelName ?></title>
        <script type="text/javascript" src="bgscript.js"></script>
    </head>
    <body>
        <nav id="navbar">
            <a onclick="" class="navbtn">Create <i class="icofont-plus-square"></i></a><!--
            --><a onclick="" class="navbtn"><?php echo $_SESSION['name'] ?> <i class="icofont-ui-user"></i></a>
        </nav>
        <nav id="mobilenav">
            <a onclick="" class="navbtn"><?php echo $_SESSION['name'] ?> <i class="icofont-ui-user"></i></a>
            <a onclick="mobileNav()" class="navbtn"><i class="icofont-settings"></i></a>
        </nav>
        <section id="mobileMenu">
            <a class="menubtn" href="<?php echo $link1; ?>"><span><i class="icofont-home icon"></i>Home</span></a>
            <a class="menubtn" href="<?php echo $link2; ?>"><span><i class="icofont-notebook icon"></i><?php echo $menuVar ?></span></div>
            <a class="menubtn" href="<?php echo $link3; ?>"><span><i class="icofont-settings icon"></i>Settings</span></a>
            <a class="menubtn" href="logout.php"><span><i id="icon-sign-out" class="icofont-sign-out icon"></i>Log out</span></a>
        </section>
        <section id="container">
            <aside id="sidebar">
                <a class="menubtn" href="<?php echo $link1; ?>"><span><i class="icofont-home icon"></i>Home</span></a>
                <a class="menubtn" href="<?php echo $link2; ?>"><span><i class="icofont-notebook icon"></i><?php echo $menuVar ?></span></a>
                <a class="menubtn" href="<?php echo $link3; ?>"><span><i class="icofont-settings icon"></i>Settings</span></a>
                <a class="menubtn" href="logout.php"><span><i id="icon-sign-out" class="icofont-sign-out icon"></i>Log out</span></a>
            </aside>
            <div id="main">