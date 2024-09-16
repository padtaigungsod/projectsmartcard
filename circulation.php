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
                <a href="store.php">
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
                <h2>ยอดขาย</h2>
            </div>

            <div class="user--info">
                <img src="images/store-icon-logo-vector-illustration_598213-5580.avif" alt="">
            </div>
        </div>
    
        <div class="tabular--wrapper">
        <h3 class="main--title">เลือกวันที่สำหรับแสดงยอดขาย</h3>
            <form method="POST" action="">
                <input type="date" name="selected_date" value="<?php echo $selected_date; ?>">
                <button type="submit">แสดงยอดขาย</button>
            </form>
            <h3 class="main--title">รายละเอียด</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>รหัสร้านค้า</th>
                            <th>วันที่</th>
                            <th>รายการอาหาร</th>
                            <th>หน่วยละ</th>
                            <th>จำนวน</th>
                            <th>ยอดเงินทั้งหมด</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
include 'circulationDB.php';
session_start();

// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['email'])) {
    header('Location: login_store.php');
    exit();
}

// รับค่าอีเมลของร้านค้าที่ล็อกอิน
$email = $_SESSION['email'];

// ดึง store_id โดยใช้ email ของร้านค้าที่ล็อกอิน
$store_id_query = "SELECT store_id FROM store WHERE email = '$email'";
$store_id_result = $conn->query($store_id_query);

if ($store_id_result->num_rows > 0) {
    $store_row = $store_id_result->fetch_assoc();
    $store_id = $store_row['store_id'];
} else {
    die("ไม่พบข้อมูลร้านค้าที่ล็อกอิน");
}

// ตรวจสอบว่ามีการเลือกวันที่หรือไม่
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d'); // ถ้าไม่มีให้ใช้วันที่ปัจจุบัน

// SQL query ดึงข้อมูลตาม store_id และวันที่ที่เลือก
$sql = "
SELECT w.store_id, w.dates, p.product_id, p.price AS unit_price, 
    SUM(wd.number_of_purchases) AS total_quantity, 
    SUM(wd.total_price) AS total_price
FROM withdraw w
JOIN withdraw_detail wd ON w.withdraw_id = wd.withdraw_id
JOIN product p ON wd.product_id = p.product_id
WHERE w.store_id = '$store_id' AND w.dates = '$selected_date'
GROUP BY w.store_id, w.dates, p.product_id, p.price
ORDER BY w.dates DESC, w.store_id
";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['store_id']}</td>
                <td>{$row['dates']}</td>
                <td>{$row['product_id']}</td>
                <td>{$row['unit_price']}</td>
                <td>{$row['total_quantity']}</td>
                <td>{$row['total_price']}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}

$conn->close();
?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>
