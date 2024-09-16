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
