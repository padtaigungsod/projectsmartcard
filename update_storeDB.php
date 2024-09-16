<?php

// เชื่อมต่อกับฐานข้อมูล
$con = mysqli_connect("localhost", "root", "", "projectsmartcard");

// ตรวจสอบการเชื่อมต่อ
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
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
