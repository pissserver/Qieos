<?php
include '../../sessions/session.php';

header('Content-Type: application/json');

$id = (int)$_POST['id'];

if($id <= 0){
    echo json_encode([
        "status"=>"error",
        "msg"=>"ID tidak valid"
    ]);
    exit;
}

$update = mysqli_query($conn,"
    UPDATE stock_requests
    SET status='rejected'
    WHERE id=$id
    AND status='pending'
");

if($update){
    echo json_encode([
        "status"=>"success",
        "msg"=>"Request ditolak"
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "msg"=>"Gagal update"
    ]);
}