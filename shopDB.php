<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectsmartcard";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบและรับค่า store_id จากการร้องขอ
$store_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($store_id > 0) {
    // ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("SELECT store_id, firstname, lastname, storename, tell, email, status FROM store WHERE store_id = ?");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }

    $stmt->close();
} else {
    echo json_encode([]);
}

$conn->close();
?>
