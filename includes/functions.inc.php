<?php
 
 function emptyInputSignup($fullName,$userName, $pwd, $pwdRepeat) {
    $result;
    if (empty($fullName) || empty($userName) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
 }

 function invalidUsername($userName) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $userName)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
 }

 function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
 }

 function usernameExist($conn, $userName) {
    $sql = "SELECT * FROM users WHERE userName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))  {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;

    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
 }  

 function createUser($conn, $fullName, $userName, $pwd) {
    $sql = "INSERT INTO users (fullName, userName, userPwd) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))  {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $fullName, $userName, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
 } 
 
 function emptyInputLogin($userName, $pwd) {
    $result;
    if (empty($userName) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
 }

 function loginUser($conn, $userName, $pwd) {
    $usernameExist = usernameExist($conn, $userName);
    
    if ($usernameExist === false) {
        header("location: ../index.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $usernameExist["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../index.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $usernameExist["userID"];
        $_SESSION["username"] = $usernameExist["userName"];
        header("location: ../index.php");
        exit();
    }


 }