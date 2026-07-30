<?php
    include '../../sessions/session.php';
    header('Content-Type: application/json');

    // buat produk tambahan baru
    if ($_GET['action'] === 'store') {

        $name       = $_POST['product_name'];
        $category   = 'additional';
        $sell_price = (float)$_POST['sell_price'];
        $date       = date('Y-m-d');

        /* upload foto baru jika ada */
        if (!empty($_FILES['photo']['name'])) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_name = 'prod_' . time() . '.' . $ext;

            move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                "../../assets/img/products/".$photo_name
            );
        }
    
        mysqli_query($conn, "INSERT INTO products (name,category,sell_price,photo, catalog)
        VALUES ('$name','$category','$sell_price','$photo_name', 'active')");

        echo json_encode([
            "status"=>"success",
            "msg"=>"Stok berhasil ditambahkan"
        ]);
    }

    // update produk tambahan
    if($_GET['action']=='update'){

        $id = $_GET['id'];

        $product_name = $_POST['product_name'];
        $sell_price   = $_POST['sell_price'];

        /* cek produk & ambil foto lama */
        $cek = mysqli_query($conn, "SELECT * FROM products WHERE id='$id' LIMIT 1");
        $p = mysqli_fetch_assoc($cek);

        // default pakai foto lama
        $photo_name = $p['photo'] ? $p['photo'] : null;

        /* upload foto baru jika ada */
        if (!empty($_FILES['photo']['name'])) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_name = 'prod_' . time() . '.' . $ext;

            move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                "../../assets/img/products/".$photo_name
            );
        }


        mysqli_query($conn,"
            UPDATE products 
            SET 
                name='$product_name',
                sell_price='$sell_price',
                photo='$photo_name'
            WHERE id = '$id'
        ");

        echo json_encode([
            'status'=>'success'
        ]);
        exit;
    }

    // hapus produk tambahan
    if($_GET['action']=='destroy'){

        $id = (int)$_POST['id'];

        $delete = mysqli_query($conn,"
            DELETE FROM products
            WHERE id='$id'
        ");

        if($delete){

            echo json_encode([
                'status'=>'success'
            ]);

        }else{

            echo json_encode([
                'status'=>'error',
                'msg'=>mysqli_error($conn)
            ]);

        }

        exit;
    }