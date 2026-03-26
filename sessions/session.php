<?php
    session_start();
    include '../script/connection.php';
    
    if (!isset($_SESSION['email'])) {
        header("Location: ../sessions/sign-in.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE email='".$_SESSION['email']."'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
?>