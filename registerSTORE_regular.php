<?php  
    session_start();

    if(!isset($_SESSION['email'])){
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['email']);
        header('location: login.php');
    }

    // เชื่อมต่อกับฐานข้อมูล
    $con = mysqli_connect("localhost", "root", "", "projectsmartcard");

    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM store";
    $result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มร้านค้า</title>
    <link rel="stylesheet" href="registerSTORE.css"> <!-- เชื่อมโยง CSS -->
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* กำหนดความกว้างของคอลัมน์ "จัดการ" */
        .action-column {
            width: 100px; /* ปรับขนาดตามที่ต้องการ */
        }

        /* ปรับขนาดปุ่มลบให้เล็กลง */
        .action-column button {
            padding: 5px 10px;
        }
        .back-button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 13px 26px;
            border-radius: 6.5px;
            cursor: pointer;
            font-size: 20.8px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function goBack() {
            window.location.href = 'admin_regular.php'; 
        }
    </script>
</head>
<body>
    <div class="header">
        <h2>เพิ่มร้านค้า</h2>
    </div>
    
    <form action="registerSTORE_db.php" method="post">
        <div class="input-group">
            <label for="firstname">ชื่อ</label>
            <input type="text" name="firstname" placeholder="ชื่อ" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="lastname">นามสกุล</label>
            <input type="text" name="lastname" placeholder="นามสกุล" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="storename">ชื่อร้านค้า</label>
            <input type="text" name="storename" placeholder="ชื่อร้านค้า" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="tell">เบอร์โทรศัพท์</label>
            <input type="text" name="tell" placeholder="เบอร์โทรศัพท์" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="email">อีเมลล์</label>
            <input type="email" name="email" placeholder="อีเมลล์" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password" placeholder="รหัสผ่าน" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="status">สถานะ</label>
            <input type="radio" name="status" value="active">เปิดใช้งาน
            <input type="radio" name="status" value="inactive">ปิดใช้งาน
        </div>

        <!-- ปุ่มด้านล่างฟอร์ม -->
        <div class="button-group">
            <button class="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
            <button class="addstore-button" type="submit">เพิ่มร้านค้า</button>
            <a href="update_store_regular.php" class="managestore-button">จัดการร้านค้า</a>
        </div>
    </form>
    
</body>
</html>

<?php mysqli_close($con); ?>
