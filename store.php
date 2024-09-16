<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง ถ้ายังให้เปลี่ยนเส้นทางกลับไปที่หน้า login
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login_store.php');
    exit();
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


// ดึงข้อมูลจาก session
$store_email = $_SESSION['email'];

// ดึงข้อมูลร้านค้าจากฐานข้อมูล โดยใช้ email จาก session
$sql = "SELECT store_id, firstname, storename FROM store WHERE email = '$store_email'";
$result = $conn->query($sql);

// ถ้าพบข้อมูลในฐานข้อมูล
if ($result->num_rows == 1) {
    $store = $result->fetch_assoc();
    $store_id = $store['store_id']; // ดึง store_id มาใช้
} else {
    echo "Store data not found.";
}

// ดึงข้อมูลยอดขายของวันนี้จากตาราง withdraw
$date_today = date('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ YYYY-MM-DD

$sql_sales = "SELECT SUM(withdraw_price) AS total_sales 
              FROM withdraw 
              WHERE store_id = '$store_id' AND DATE(dates) = '$date_today'";
$result_sales = $conn->query($sql_sales);

// กำหนดยอดขายเริ่มต้น
$total_sales_today = 0;

// ตรวจสอบผลลัพธ์ของยอดขาย
if ($result_sales->num_rows == 1) {
    $row_sales = $result_sales->fetch_assoc();
    $total_sales_today = $row_sales['total_sales'] ?? 0; // ถ้าไม่มีข้อมูลให้เป็น 0
}
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['email']);
    header('location: login_store.php');
}
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link rel="stylesheet" href="style_st_mn_pr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

       <div class="sidebar">
            <div class="logo"></div>
            <ul class="menu">
                <li class="active">
                    <a href="#" >
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
                    <a href="store.php?logout='1'">
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
                    <h2>หน้าหลัก</h2>
                </div>

                <div class="user--info">
                    <img src="images/store-icon-logo-vector-illustration_598213-5580.avif" alt="">
                </div>
            </div>
       
       <div class="card--container">
            <h3 class="main--title">ยอดขายของวันนี้</h3>
            <div class="card--wrapper">
                <div class="payment--card light-green">
                    <div class="card--header">
                        <div class="amount">
                            <span class="amount-value"><?php echo number_format($total_sales_today, 2); ?> บาท</span>
                        </div>
                        <i class="fas fa-baht-sign icon"></i>
                    </div>
                    <span class="card-detail"></span>
                </div>
            </div>
       </div>

       <div class="tabular--wrapper">
        <h3 class="main--title">รายละเอียดร้านค้า</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>รหัสร้านค้า</th>
                        <th>ชื่อ-สกุล เจ้าของร้าน</th>
                        <th>ชื่อร้าน</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $store['store_id']; ?></td>
                        <td><?php echo $store['firstname']; ?></td>
                        <td><?php echo $store['storename']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
       </div>
    </div>
    
</body>
</html>
