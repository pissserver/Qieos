<?php
include '../sessions/session.php';

header('Content-Type: application/json');

if ($_GET['action'] === 'add') {

    $cashout_date = $_POST['cashout_date'];
    $category = (int) $_POST['category'];
    $expense_name = $_POST['expense_name'];
    $quantity = (int) $_POST['quantity'];
    $unit = $_POST['unit'];
    $price = (int) $_POST['price'];
    $amount = $quantity * $price;

    $query = "INSERT INTO cashouts 
    (cashout_date, category_id, expense_name, quantity, unit, price, amount) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisissd", 
        $cashout_date, 
        $category, 
        $expense_name, 
        $quantity, 
        $unit, 
        $price, 
        $amount
    );

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Kas keluar berhasil ditambahkan"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menambahkan kas keluar"
        ]);
    }
}