<?php
include '../../sessions/session.php';
header('Content-Type: application/json');

$product_id = (int)$_POST['product_id'];
$qty = (int)$_POST['qty'];

if($product_id <= 0 || $qty <= 0){
    echo json_encode([
        "status"=>"error",
        "msg"=>"Input tidak valid"
    ]);
    exit;
}

/* cek produk */
$cek = mysqli_query($conn,"SELECT id FROM products WHERE id=$product_id");
if(mysqli_num_rows($cek)==0){
    echo json_encode([
        "status"=>"error",
        "msg"=>"Produk tidak ditemukan"
    ]);
    exit;
}

/* simpan request */
mysqli_query($conn,"
INSERT INTO stock_requests (product_id, qty, status)
VALUES ($product_id, $qty, 'pending')
");

echo json_encode([
    "status"=>"success",
    "msg"=>"Request berhasil dikirim ke admin"
]);