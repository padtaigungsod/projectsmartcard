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


// ดึงข้อมูลจากฟอร์ม
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$storename = $_POST["storename"];
$tell = $_POST["tell"];
$email = $_POST["email"];
$password = $_POST["password"];
$status = $_POST["status"];


// ตรวจสอบว่า username และ email ซ้ำหรือไม่
$sql = "SELECT * FROM store WHERE email = '$email' OR lastname = '$lastname'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
  echo "Username หรือ Email นี้ถูกใช้งานแล้ว";
  exit;
}


// บันทึกข้อมูลลงฐานข้อมูล
$sql = "INSERT INTO store (firstname, lastname, storename,tell, email, password, status) VALUES ('$firstname', '$lastname', '$storename', '$tell', '$email', '$password', '$status')";
mysqli_query($con, $sql);


// แจ้งเตือนการลงทะเบียนสำเร็จ
echo "ลงทะเบียนสำเร็จ";
header("location: registerSTORE.php");

?>
