<?php

    include '../sessions/session.php';

    // Action add
    if(isset($_GET['action']) && $_GET['action'] == 'add'){
        if(isset($_POST['save_product'])){

            $product_name = $_POST['product_name'];
            $price = $_POST['price'];

            $photo = $_FILES['photo']['name'];
            $tmp = $_FILES['photo']['tmp_name'];

            $created_at = date("Y-m-d");

            $folder = "../assets/img/uploads/";

            move_uploaded_file($tmp,$folder.$photo);

            $query = mysqli_query($conn,"INSERT INTO products (product_name,price,photo,created_at)
                                    VALUES ('$product_name','$price','$photo','$created_at')");

            if($query){
                $_SESSION['success_message'] = "Produk berhasil ditambahkan";

                header("Location: product-add.php");
                exit();
            }else{
                $_SESSION['error_message'] = "Produk gagal ditambahkan";

                header("Location: product-add.php");
                exit();
            }
        }
    }

    // Action edit
    if(isset($_GET['action']) && $_GET['action'] == 'edit'){
        if(isset($_POST['edit_product'])){

            $id = $_GET['id'];
            $product_name = $_POST['product_name'];
            $price = $_POST['price'];

            $photo = $_FILES['photo']['name'];
            $tmp = $_FILES['photo']['tmp_name'];

            $folder = "../assets/img/uploads/";

            $get = mysqli_query($conn,"SELECT photo FROM products WHERE id='$id'");
            $data = mysqli_fetch_assoc($get);
            $old_photo = $data['photo'];

            if($photo){
                if($old_photo && file_exists($folder.$old_photo)){
                    unlink($folder.$old_photo);
                }

                move_uploaded_file($tmp,$folder.$photo);
                $query = mysqli_query($conn,"UPDATE products SET product_name='$product_name', price='$price', photo='$photo' WHERE id='$id'");
            }else{
                $query = mysqli_query($conn,"UPDATE products SET product_name='$product_name', price='$price' WHERE id='$id'");
            }

            if($query){
                $_SESSION['success_message'] = "Produk berhasil diubah";

                header("Location: product-add.php");
                exit();
            }else{
                $_SESSION['error_message'] = "Produk gagal diubah";

                header("Location: product-add.php");
                exit();
            }
        }
    }

    // Action delete
    if(isset($_GET['action']) && $_GET['action'] == 'delete'){
        if(isset($_GET['id'])){

            $id = $_GET['id'];

            
            $folder = "../assets/img/uploads/";
            
            $get = mysqli_query($conn,"SELECT photo FROM products WHERE id='$id'");
            $data = mysqli_fetch_assoc($get);
            $old_photo = $data['photo'];
            
            if($old_photo && file_exists($folder.$old_photo)){
                unlink($folder.$old_photo);
            }

            $query = mysqli_query($conn,"DELETE FROM products WHERE id='$id'");

            if($query){
                $_SESSION['success_message'] = "Produk berhasil dihapus";

                header("Location: product-add.php");
                exit();
            }else{
                $_SESSION['error_message'] = "Produk gagal dihapus";

                header("Location: product-add.php");
                exit();
            }
        }
    }