<?php

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


// รับค่าสถานะใหม่จาก URL
$store_id = $_POST["store_id"];
$newStatus = $_POST["status"];

// เขียนคำสั่ง SQL สำหรับการอัปเดตสถานะ
$sql = "UPDATE store SET status = '$newStatus' WHERE store_id = '$store_id'";

// รันคำสั่ง SQL
if (mysqli_query($con, $sql)) {
    header("Location: update_store.php"); // กลับไปยังหน้า update_store.php
    exit();
} else {
    echo "อัปเดตสถานะล้มเหลว: " . mysqli_error($con);
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($con);

?>
