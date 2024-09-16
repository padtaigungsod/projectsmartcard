<?php

// ตรวจสอบข้อมูล login
$email = $_POST["email"];
$password = $_POST["password"];

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


// SQL query
$sql_admin = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";


// Get result
$result_admin = mysqli_query($conn, $sql_admin);


// ตรวจสอบว่าผู้ใช้มีอยู่หรือไม่
if (mysqli_num_rows($result_admin) > 0) {
  // ผู้ใช้เป็นแอดมิน
  session_start();
  $_SESSION["email"] = $email;
  
  $user = mysqli_fetch_assoc($result_admin);
  if ($user['role'] === 'admin-main') {
    // แอดมินหลัก
    header("Location: admin.php");
  } elseif ($user['role'] === 'admin-regular') {
    // แอดมินธรรมดา
    header("Location: admin_regular.php");
  }
} else {
  // ไม่พบผู้ใช้
  header("location: login.php");
}

mysqli_close($conn);

?>
