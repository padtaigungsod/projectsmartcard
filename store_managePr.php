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

  $host = 'junction.proxy.rlwy.net';
  $port = '13506';
  $dbname = 'railway';
  $username = 'root';
  $password = 'YvHGSjIeEzwZcJbdstAFfEhaWGViYLdb';
  
  try {
      $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
  } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
  }
  

    // ดึง email ของร้านค้าที่ล็อกอินอยู่
    $email = $_SESSION['email'];

    // ตรวจสอบและดึง store_id ของร้านค้าที่ใช้อีเมลล์นี้
    $result = mysqli_query($conn, "SELECT store_id FROM store WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);
    $store_id = $row['store_id'];

    if (!$store_id) {
        die("ไม่พบร้านค้าที่ตรงกับอีเมลนี้");
    }

    // Query เพื่อแสดงสินค้าตาม store_id ของร้านที่ล็อกอินอยู่
    $select = mysqli_query($conn, "SELECT * FROM product WHERE store_id = '$store_id'");

?>
   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store_manage</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_st_mn_pr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

       <div class="sidebar">
            <div class="logo"></div>
            <ul class="menu">
                <li class="active">
                    <a href="store.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>หน้าหลัก</span>
                    </a>
                </li>
                <li>
                    <a href="circulation.php">
                        <i class="fas fa-user"></i>
                        <span>ยอดขาย</span>
                    </a>
                </li>
                <li>
                    <a href="showproduct.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>สินค้าทั้งหมด</span>
                    </a>
                </li>
                <li>
                    <a href="store_managePr.php">
                        <i class="fas fa-cog"></i>
                        <span>จัดการสินค้า</span>
                    </a>
                </li>
                <li>
                  <a href="login_store.php" onclick="confirmLogout()">
                     <i class="fas fa-sign-out-alt"></i>
                     <span>ออกจากระบบ</span>

                  </a>
               </li>

            </ul>
       </div>

       <div class="main--content">
            <div class="header--wrapper">
                <div class="header--title">
                    <span>ร้านค้า</span>
                    <h2>จัดการสินค้า</h2>
                </div>

                <div class="user--info">
                    
                    <img src="images/shop-icon-png-5.jpg" alt="">
                </div>
            </div>
       

       

       <div class="tabular--wrapper">
       <?php

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


//delete
if(isset($_GET["delete"])){
    $product_id = $_GET['delete'];
    $delete = "DELETE FROM product WHERE product_id = '$product_id'";
    mysqli_query($conn, $delete);
    header('location:store_managePr.php');
    exit();
}
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style2.css">

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

   <div class="admin-product-form-container">

   <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
   <h3>add a new product</h3>
   <input type="text" placeholder="กรุณากรอกรหัสร้านค้า" name="store_id" class="box">
   <input type="text" placeholder="กรุณากรอกชื่อสินค้า" name="product_name" class="box">
   <input type="text" placeholder="กรุณากรอกราคาสินค้า" name="price" class="box">
   <input type="text" placeholder="กรุณากรอกหมายเหตุ (ไม่บังคับ)" name="note" class="box">
   <label for="type">ประเภท</label><br>
   <select name="product_type_id" id="product_type_id">
      <option value="1">เมนูข้าว</option>
      <option value="2">เมนูเส้น</option>
      <option value="3" selected>ของหวาน</option>
      <option value="4" selected>เครื่องดื่ม</option>
   </select>
   <input type="file" accept="image/png, image/jpeg, image/jpg" name="img" class="box">
   <input type="submit" class="btn" name="add_product" value="add product">
</form>


   </div>

<div class="product-display">
    <table class="product-display-table">
        <thead>
            <tr>
                <th>product image</th>
                <th>product name</th>
                <th>product price</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($select)){ ?>
            <tr>
                <td><img src="uploaded_img/<?php echo $row['img']; ?>" height="100" alt=""></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['price']; ?> บาท</td>
                <td>
                    <a href="st_mnPr_update.php?edit=<?php echo $row['product_id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                    <a href="store_managePr.php?delete=<?php echo $row['product_id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


</div>


</body>
</html>