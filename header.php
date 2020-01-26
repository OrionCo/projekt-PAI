<?php
    $path = $_SERVER['PHP_SELF'];
    $file = basename($path);
    if($file == "user-panel.php"){
        $menuVar = "Sets";
    } else if ($file == "admin-panel.php"){
        $menuVar = "Manage Accounts";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="icons.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User panel</title>
        <script type="text/javascript" src="bcgscript.js"></script>
    </head>
    <body>
        <nav id="navbar">
            <a onclick="" class="navbtn">Create <i class="icofont-plus-square"></i></a><!--
            --><a onclick="" class="navbtn">$username <i class="icofont-ui-user"></i></a>
        </nav>
        <nav id="mobilenav">
            <a onclick="" class="navbtn">$username <i class="icofont-ui-user"></i></a>
            <a onclick="mobileNav()" class="navbtn"><i class="icofont-settings"></i></a>
        </nav>
        <section id="mobileMenu">
            <div class="menubtn"><span><i class="icofont-home icon"></i>Home</span></div>
            <div class="menubtn"><span><i class="icofont-notebook icon"></i><?php echo $menuVar ?></span></div>
            <div class="menubtn"><span><i class="icofont-settings icon"></i>Settings</span></div>
            <div class="menubtn"><span><i id="icon-sign-out" class="icofont-sign-out icon"></i>Log out</span></div>
        </section>
        <section id="container">
            <aside id="sidebar">
                <div class="menubtn"><span><i class="icofont-home icon"></i>Home</span></div>
                <div class="menubtn"><span><i class="icofont-notebook icon"></i><?php echo $menuVar ?></span></div>
                <div class="menubtn"><span><i class="icofont-settings icon"></i>Settings</span></div>
                <div class="menubtn"><span><i id="icon-sign-out" class="icofont-sign-out icon"></i>Log out</span></div>
            </aside>