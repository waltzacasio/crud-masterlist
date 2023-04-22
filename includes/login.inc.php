<?php

if (isset($_POST["submit"])) {

    $userName = $_POST["username"];
    $pwd = $_POST["pwd"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($userName, $pwd) !== false) {
        header("location: ../index.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $userName, $pwd);
}

