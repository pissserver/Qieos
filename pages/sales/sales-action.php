<?php
    include '../../sessions/session.php';
    header('Content-Type: application/json');

    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;

    /* VALIDASI */
    if($product_id <= 0 || $qty <= 0){
        echo json_encode([
            "status"=>"error",
            "msg"=>"Input tidak valid"
        ]);
        exit;
    }

    /* CEK PRODUK */
    $cek = mysqli_query($conn,"SELECT id FROM products WHERE id=$product_id");
    if(mysqli_num_rows($cek)==0){
        echo json_encode([
            "status"=>"error",
            "msg"=>"Produk tidak ditemukan"
        ]);
        exit;
    }

    /* CEK STOK GUDANG */
    $stok = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT COALESCE(SUM(remaining_qty),0) as total
        FROM purchase_items
        WHERE product_id = $product_id
    "))['total'];

    if($stok < $qty){
        echo json_encode([
            "status"=>"error",
            "msg"=>"Stok tidak cukup (sisa: $stok)"
        ]);
        exit;
    }

    /* SIMPAN REQUEST */
    $insert = mysqli_query($conn,"
        INSERT INTO stock_requests (product_id, qty, status, created_at)
        VALUES ($product_id, $qty, 'pending', NOW())
    ");

    if(!$insert){
        echo json_encode([
            "status"=>"error",
            "msg"=>mysqli_error($conn)
        ]);
        exit;
    }

    echo json_encode([
        "status"=>"success",
        "msg"=>"Request berhasil dikirim ke admin"
    ]);