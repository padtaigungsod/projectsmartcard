<?php
    session_start();
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


    // กำหนดค่าตัวแปรเริ่มต้น
    $balanceMessage = "";

    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST หรือไม่
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['smartcard_id'])) {
            $smartcard_id = $_POST['smartcard_id'];

            // ดึงยอดเงินคงเหลือปัจจุบันจากฐานข้อมูล
            $sql = "SELECT balance FROM topup_close WHERE smartcard_id = '$smartcard_id' ORDER BY topup_close_id DESC LIMIT 1";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $balance = $row['balance'];
                $balanceMessage = "ยอดเงินคงเหลือ: " . $balance . " บาท";
                echo $balanceMessage ;
            } else {
                $balanceMessage = "ไม่พบข้อมูลสมาร์ทการ์ด";
            }
        }
    }
    
    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($con);
?>
