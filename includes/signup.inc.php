<?php

if (isset($_POST["submit"])) {
    
    $fullName = $_POST["fullname"];
    $userName = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($fullName,$userName, $pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($userName) !== false) {
        header("location: ../signup.php?error=invalidusername");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    if (usernameExist($conn, $userName) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $fullName, $userName, $pwd);


} else {
    header("location: ../signup.php");
}