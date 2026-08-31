<?php
include '../../sessions/session.php';

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Upload helper
function uploadPhoto($file){
    $allowed = ['image/jpeg','image/png','image/webp'];
    if(!in_array($file['type'], $allowed)){
        return ['ok'=>false, 'msg'=>'Format file tidak valid (JPG/PNG/WEBP)'];
    }
    if($file['size'] > 2 * 1024 * 1024){
        return ['ok'=>false, 'msg'=>'Ukuran file maksimal 2MB'];
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = 'product_' . time() . '_' . rand(1000,9999) . '.' . $ext;
    $dest = '../../assets/img/products/' . $name;

    if(move_uploaded_file($file['tmp_name'], $dest)){
        return ['ok'=>true, 'name'=>$name];
    }
    return ['ok'=>false, 'msg'=>'Gagal upload file'];
}

// STORE
if($action === 'store'){

    $code        = mysqli_real_escape_string($conn, trim(isset($_POST['code']) ? $_POST['code'] : ''));
    $name        = mysqli_real_escape_string($conn, trim(isset($_POST['name']) ? $_POST['name'] : ''));
    $category    = mysqli_real_escape_string($conn, trim(isset($_POST['category']) ? $_POST['category'] : ''));
    $price       = isset($_POST['price']) ? (int)$_POST['price'] : 0;
    $supplier_id = isset($_POST['supplier_id']) && $_POST['supplier_id'] !== '' ? (int)$_POST['supplier_id'] : 'NULL';

    if($code === '' || $name === '' || $category === '' || $price <= 0){
        echo json_encode(['status'=>'error', 'message'=>'Semua field wajib diisi']);
        exit;
    }

    // Upload photo if provided
    $photoName = '';
    if(!empty($_FILES['photo']['name'])){
        $upload = uploadPhoto($_FILES['photo']);
        if(!$upload['ok']){
            echo json_encode(['status'=>'error', 'message'=>$upload['msg']]);
            exit;
        }
        $photoName = $upload['name'];
    }

    $suppVal = $supplier_id === 'NULL' ? "NULL" : $supplier_id;
    $q = mysqli_query($conn,"
        INSERT INTO products (code, name, category, sell_price, supplier_id, photo, created_at)
        VALUES ('$code', '$name', '$category', $price, $suppVal, '$photoName', NOW())
    ");

    if($q){
        echo json_encode(['status'=>'success']);
    }else{
        echo json_encode(['status'=>'error', 'message'=>'Gagal menyimpan data']);
    }
    exit;
}

// UPDATE
if($action === 'update'){

    $id          = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $code        = mysqli_real_escape_string($conn, trim(isset($_POST['code']) ? $_POST['code'] : ''));
    $name        = mysqli_real_escape_string($conn, trim(isset($_POST['name']) ? $_POST['name'] : ''));
    $category    = mysqli_real_escape_string($conn, trim(isset($_POST['category']) ? $_POST['category'] : ''));
    $price       = isset($_POST['price']) ? (int)$_POST['price'] : 0;
    $oldPhoto    = isset($_POST['old_photo']) ? $_POST['old_photo'] : '';
    $rawSupplier = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : '';

    if($id <= 0 || $code === '' || $name === '' || $category === '' || $price <= 0){
        echo json_encode(['status'=>'error', 'message'=>'Semua field wajib diisi']);
        exit;
    }

    // Upload new photo if provided
    $photoName = $oldPhoto;
    if(!empty($_FILES['photo']['name'])){
        $upload = uploadPhoto($_FILES['photo']);
        if(!$upload['ok']){
            echo json_encode(['status'=>'error', 'message'=>$upload['msg']]);
            exit;
        }
        $photoName = $upload['name'];

        // Delete old photo
        if($oldPhoto !== ''){
            $oldPath = '../../assets/img/products/' . $oldPhoto;
            if(file_exists($oldPath)){
                unlink($oldPath);
            }
        }
    }

    // Handle supplier_id: NULL if empty, else integer
    if($rawSupplier !== '' && $rawSupplier !== '0'){
        $suppSql = "$rawSupplier";
    } else {
        $suppSql = "NULL";
    }

    $q = mysqli_query($conn,"
        UPDATE products
        SET code='$code', name='$name', category='$category', sell_price=$price, supplier_id=$suppSql, photo='$photoName'
        WHERE id = $id
    ");

    if($q){
        echo json_encode(['status'=>'success']);
    }else{
        echo json_encode(['status'=>'error', 'message'=>'Gagal memperbarui data']);
    }
    exit;
}

// DESTROY
if($action === 'destroy'){

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if($id <= 0){
        echo json_encode(['status'=>'error', 'message'=>'ID tidak valid']);
        exit;
    }

    // Soft delete
    $q = mysqli_query($conn,"
        UPDATE products SET deleted_at = NOW() WHERE id = $id
    ");

    if($q){
        echo json_encode(['status'=>'success']);
    }else{
        echo json_encode(['status'=>'error', 'message'=>'Gagal menghapus data']);
    }
    exit;
}

echo json_encode(['status'=>'error', 'message'=>'Aksi tidak dikenali']);