<?php
header('Content-Type: application/json');

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
