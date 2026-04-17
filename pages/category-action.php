<?php
include '../sessions/session.php';

header('Content-Type: application/json');

if($_GET['action'] === 'add'){
    if(!isset($_POST['category_name'])){
        echo json_encode(["status"=>"error","message"=>"Nama kategori tidak diterima"]);
        exit;
    }

    $category_name = $_POST['category_name'];

    $query = "INSERT INTO cashout_categories (category_name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $category_name);
    if($stmt->execute()){
        echo json_encode(["status"=>"success","message"=>"Kategori berhasil ditambahkan"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Gagal menambahkan kategori"]);
    }
} 