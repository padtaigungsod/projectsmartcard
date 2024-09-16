<?php  

    session_start();

    if(!isset($_SESSION['email'])){
        $_SESSION['msg'] = "You must log in first";
        header('location: login_store.php');

    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['email']);
        header('location: login_store.php');
    }
    
?>


<?php

@include 'config.php';

$id = $_GET['edit'];

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

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="st_mnPr_update.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM product WHERE product_id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">update the product</h3>
      <input type="text" class="box" name="store_id" value="<?php echo $row['store_id']; ?>" placeholder="กรุณากรอกรหัสร้านค้า">
      <input type="text" class="box" name="product_name" value="<?php echo $row['product_name']; ?>" placeholder="กรุณากรอกชื่อสินค้า">
      <input type="text" class="box" name="price" value="<?php echo $row['price']; ?>" placeholder="กรุณากรอกราคาสินค้า">
      <input type="text" class="box" name="note" value="<?php echo $row['note']; ?>" placeholder="กรุณากรอกหมายเหตุ (ไม่บังคับ)">
      <select name="product_type_id" id="product_type_id" value="<?php echo $row['product_type_id']; ?>">
      <option value="1">เมนูข้าว</option>
      <option value="2">เมนูเส้น</option>
      <option value="3" selected>ของหวาน</option>
      <option value="4" selected>เครื่องดื่ม</option>
   </select>
      <input type="file" class="box" name="img"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="store_managePr.php" class="btn">กลับไปที่หน้าหลัก</a>
   </form>
   


   <?php }; ?>

   

</div>

</div>

</body>
</html>