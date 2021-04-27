<?php
    session_start();
    unset($_SESSION["id"]);
    unset($_SESSION["message"]);
    unset($_SESSION["username"]);
    $_SESSION['loggedin'] = false;
    // unset($_SESSION['avatar']);
    // $_SESSION['avatar'] = '';
    // session_destroy();
    header("Location: login.php");
?>