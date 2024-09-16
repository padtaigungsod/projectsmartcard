<?php

// ตรวจสอบข้อมูล login
$email = $_POST["email"];
$password = $_POST["password"];

// เชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "projectsmartcard");

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// SQL query
$sql_store = "SELECT * FROM store WHERE email = '$email' AND password = '$password'";

// Get result
$result_store = mysqli_query($conn, $sql_store);

if (mysqli_num_rows($result_store) > 0) {
  // ผู้ใช้เป็นร้านค้า
  session_start();
  $_SESSION["email"] = $email;
  header("Location: store.php");
} else {
  // ไม่พบผู้ใช้
  header("location: login.php");
}

mysqli_close($conn);

?>
