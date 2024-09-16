<?php  

session_start();

if(!isset($_SESSION['email'])){
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit();
}
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['email']);
    header('location: login.php');
    exit();
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectsmartcard";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึง admin_id ตามอีเมลที่ล็อกอิน
$email = $_SESSION['email'];
$sql = "SELECT admin_id FROM admin WHERE email = '$email'";
$result = $conn->query($sql);
$admin_id = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admin_id = $row['admin_id'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>topup</title>
    <link rel="stylesheet" href="topup.css">
    <script>
        // ฟังก์ชันสำหรับการปรับค่าจำนวนเงินในฟิลด์ input
        function setAmount(amount) {
            document.getElementById('incoming_money').value = amount;
        }
        function goBack() {
            window.location.href = 'admin.php'; 
        }
    </script>
</head>
<body>
    <?php
    
    // ตรวจสอบว่า session แจ้งเตือนการเติมเงินสำเร็จถูกตั้งไว้หรือไม่
    if (isset($_SESSION['topup_success'])) {
        echo "<script>alert('การเติมเงินสำเร็จ!');</script>";
        // ลบ session หลังจากแสดงข้อความแจ้งเตือนแล้ว
        unset($_SESSION['topup_success']);
    }
    // ตรวจสอบว่า session แจ้งเตือนการถอนเงินสำเร็จถูกตั้งไว้หรือไม่
    if (isset($_SESSION['withdraw_success'])) {
        echo "<script>alert('การถอนเงินสำเร็จ!');</script>";
        // ลบ session หลังจากแสดงข้อความแจ้งเตือนแล้ว
        unset($_SESSION['withdraw_success']);
    }
    if (isset($_SESSION['withdraw_error'])) {
        echo "<script>alert('ยอดเงินคงเหลือไม่เพียงพอสำหรับการถอนเงิน!');</script>";
        // ลบ session หลังจากแสดงข้อความแจ้งเตือนแล้ว
        unset($_SESSION['withdraw_error']);
    }
    ?>
    
    <form action="topupDB.php" method="POST">
        <div class="container">
            <div class="topupinfo">
                <label for="admin_id">รหัสผู้ดูแลระบบ</label>
                <input type="text" name="admin_id" placeholder="รหัสผู้ดูแล" value="<?php echo htmlspecialchars($admin_id); ?>" required readonly><br>
                <label for="smartcard_id">รหัสสมาร์ทการ์ด</label>
                <input type="text" name="smartcard_id" placeholder="รหัสสมาร์ทการ์ด" required><br>
                <div>
                    <label for="incoming_money">จำนวนเงิน</label>
                    <input type="text" name="incoming_money" placeholder="จำนวนเงิน" id="incoming_money" required><br>
                </div>
                <div class="topupinfo">
                    <label for="status">สถานะ</label>
                    <select name="status" id="status">
                        <option value="active">เปิดใช้งาน</option>
                        <option value="inactive">ปิดใช้งาน</option>
                    </select>
                </div>
            </div>

            <br>
            <div class="btnkey">
                <div class="box1">
                    <button type="button" onclick="setAmount(100)" id="btn1" name="btn100">100</button>
                    <button type="button" onclick="setAmount(200)" id="btn2" name="btn200">200</button>
                    <button type="button" onclick="setAmount(300)" id="btn3" name="btn300">300</button>
                </div>
                <div class="box2">
                    <button type="button" onclick="setAmount(500)" id="btn4">500</button>
                    <button type="button" onclick="setAmount(700)" id="btn5">700</button>
                    <button type="button" onclick="setAmount(900)" id="btn6">900</button>
                </div>
                <div class="box3">
                    <button type="submit" value="topup" name="action">เติมเงิน</button>
                    <button type="button" onclick="setAmount(1000)" id="btn7">1000</button>
                    <button type="submit" value="withdraw" name="action">ถอนเงิน</button>
                </div>
                </div>
                    <button class="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
