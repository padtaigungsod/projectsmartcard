<?php

//lets make a connection with Addtocart database

include 'config.php';

// $id = isset($_GET['projectsmartcard']) ? mysqli_real_escape_string($conn, $_GET['projectsmartcard']) : '';
// if(empty($id)){
//    die("Invalid ID!");
// }


if(isset($_POST['add_product'])){
   $store_id = $_POST['store_id'];
   $product_name = $_POST['product_name'];
   $price = $_POST['price'];
   $note = $_POST['note'];
   $product_type_id = $_POST['product_type_id'];
   $img = $_FILES['img']['name'];
   $img_tmp_name = $_FILES['img']['tmp_name'];
   $img_folder = 'uploaded_img/'.$img;

   if(empty($store_id) || empty($product_name) || empty($price) || empty($product_type_id)|| empty($img)){
      $message[] = 'please fill out all!';    
   } else {
      $insert = "INSERT INTO product(store_id, product_name, price, note, product_type_id, img) VALUES('$store_id', '$product_name', '$price', '$note', '$product_type_id', '$img')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($img_tmp_name, $img_folder);
         $message[] = 'new product added successfully';
         header("location: store_managePr.php");
      }else{
         $message[] = 'could not add the product';
      }
   }

};

// $id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $store_id = $_POST['store_id'];
   $product_name = $_POST['product_name'];
   $price = $_POST['price'];
   $note = $_POST['note'];
   $product_type_id = $_POST['product_type_id'];
   $img = $_FILES['img']['name'];
   $img_tmp_name = $_FILES['img']['tmp_name'];
   $img_folder = 'uploaded_img/'.$img;

   if(empty($store_id) || empty($product_name) || empty($price) || empty($product_type_id)|| empty($img)){
      $message[] = 'please fill out all!';     
   }else{

    $update_data = "UPDATE product SET store_id='$store_id', product_name='$product_name', price='$price', note='$note', product_type_id='$product_type_id',img='$img'  WHERE product_id = '$id'";
    $upload = mysqli_query($conn, $update_data);

    if($upload){
       move_uploaded_file($img_tmp_name, $img_folder);
       header('location: store_managePr.php');
    }else{
       $$message[] = 'please fill out all!';  
      }

   }
};

?>