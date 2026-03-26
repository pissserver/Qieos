<?php
    session_start();
    include '../script/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Cek email di database
        $sql = "SELECT email FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $_SESSION['reset_email'] = $row['email'];
            header("Location:reset-password.php");
            exit;
        } else {
            // Email tidak ditemukan
            header("Location:forgot-password.php?error=invalid");
            exit;
        }

        $conn->close();
    }