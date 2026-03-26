<?php

    include '../script/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Validasi input
        if($email==''||$password==''){
            header("Location:sign-in.php?error=empty");
            exit;
        }

        // Cek email di database
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Login berhasil
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];

                // Jika user centang "ingat saya"
                if (isset($_POST['remember'])) {
                    setcookie("email", $row['email'], time() + (86400 * 30), "/"); // 30 hari
                } else {
                    setcookie("email", "", time() - 3600, "/"); // Hapus cookie
                }

                header("Location:../index.php");
                exit;
            } else {
                // Password salah
                header("Location:sign-in.php?error=password");
                exit;
            }
        } else {
            // Email tidak ditemukan
            header("Location:sign-in.php?error=email");
            exit;
        }

        $conn->close();
    }