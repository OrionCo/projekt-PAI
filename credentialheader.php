<?php
    if(session_id() == '' || !isset($_SESSION))
        session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php if(basename($_SERVER['PHP_SELF']) == "register.php") echo "Register"; else if(basename($_SERVER['PHP_SELF']) == "landing-page.php") echo "Landing page"; ?></title>
        <style>
            html, body{
                height: 100%;
            }
        </style>
        <script type="text/javascript" src="bgscript.js"></script>
    </head>
    <body>