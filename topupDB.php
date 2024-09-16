<?php
    // เชื่อมต่อกับฐานข้อมูล
    session_start(); // เริ่มการทำงานของ session
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


    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST หรือไม่
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $smartcard_id = $_POST['smartcard_id'];
            $amountInput = (float) $_POST['incoming_money']; // แปลงเป็น float เพื่อการคำนวณ
            $admin_id = $_POST['admin_id'];
            $status = $_POST['status'];

            if ($action === 'topup') {
                // ดึงยอดเงินคงเหลือปัจจุบันจากฐานข้อมูล
                $sql = "SELECT balance FROM topup_close WHERE smartcard_id = '$smartcard_id' ORDER BY topup_close_id DESC LIMIT 1";
                $result = mysqli_query($con, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $currentBalance = (float) $row['balance'];
                } else {
                    // ถ้าไม่มีข้อมูลสมาร์ทการ์ดในระบบ กำหนดยอดคงเหลือเป็น 0
                    $currentBalance = 0;
                }

                // คำนวณยอดเงินคงเหลือใหม่
                $newBalance = $currentBalance + $amountInput;

                // บันทึกข้อมูลการเติมเงินลงในฐานข้อมูลพร้อมยอดเงินคงเหลือใหม่ และบันทึก detail ว่าเป็นการเติมเงิน
                $insertSql = "INSERT INTO topup_close (smartcard_id, incoming_money, balance, admin_id, status, dates, times, transaction_type) 
                              VALUES ('$smartcard_id', '$amountInput', '$newBalance', '$admin_id', '$status', CURDATE(), CURTIME(), 'Topup')";

                if (mysqli_query($con, $insertSql)) {
                    // ตั้ง session เพื่อแจ้งเตือนการเติมเงินสำเร็จ
                    $_SESSION['topup_success'] = true;

                    // เปลี่ยนเส้นทางกลับไปยังหน้า topup.php หลังจากทำรายการสำเร็จ
                    header("Location: topup.php");
                    exit();
                } else {
                    echo "Error inserting new record: " . mysqli_error($con);
                }
            } elseif ($action === 'withdraw') {
                // ฟังก์ชันสำหรับการถอนเงิน
                $sql = "SELECT balance FROM topup_close WHERE smartcard_id = '$smartcard_id' ORDER BY topup_close_id DESC LIMIT 1";
                $result = mysqli_query($con, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $currentBalance = (float) $row['balance'];

                    if ($amountInput > $currentBalance) {
                        // เก็บข้อความแจ้งเตือนใน session
                        $_SESSION['withdraw_error'] = true;
                        header("Location: topup.php");
                        exit();
                    } else {
                        // คำนวณยอดเงินคงเหลือใหม่หลังจากการถอนเงิน
                        $newBalance = $currentBalance - $amountInput;

                        // บันทึกข้อมูลการถอนเงินลงในฐานข้อมูล และบันทึก detail ว่าเป็นการถอนเงิน
                        $insertSql = "INSERT INTO topup_close (smartcard_id, incoming_money, balance, admin_id, status, dates, times, transaction_type) 
                                      VALUES ('$smartcard_id', '-$amountInput', '$newBalance', '$admin_id', '$status', CURDATE(), CURTIME(), 'Withdraw')";

                        if (mysqli_query($con, $insertSql)) {
                            $_SESSION['withdraw_success'] = true;
                            header("Location: topup.php");
                            exit();
                        } else {
                            echo "Error inserting new record: " . mysqli_error($con);
                        }
                    }
                } else {
                    // เก็บข้อความแจ้งเตือนใน session หากไม่พบข้อมูลสมาร์ทการ์ด
                    $_SESSION['withdraw_error'] = "ไม่พบข้อมูลสมาร์ทการ์ด";
                    header("Location: topup.php");
                    exit();
                }
            }
        }
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($con);
?>
