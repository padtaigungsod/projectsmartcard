<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแอดมิน</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .header {
            background-color: rgba(113, 99, 186, 255);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            position: fixed;
            top: 120px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 500px;
            z-index: 1000;
        }

        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
            margin-top: 100px; /* เพิ่มช่องว่างระหว่างส่วนหัวและฟอร์ม */
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: rgba(113, 99, 186, 255);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="radio"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            width: auto;
            margin-right: 5px;
        }

        .btn,
        .manageadmin-button,
        #back-button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: auto;
            text-align: center;
            white-space: nowrap;
        }

        .btn {
            background-color: #66bb6a;
            color: white;
        }

        .btn:hover {
            background-color: #81c784;
        }

        .manageadmin-button {
            background-color: rgba(113, 99, 186, 255);
            color: white;
            text-decoration: none;
        }

        .manageadmin-button:hover {
            background-color: rgba(105, 99, 180, 240);
        }

        #back-button {
            background-color: #c62828;
            color: white;
        }

        #back-button:hover {
            background-color: #d32f2f;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px; /* เพิ่มช่องว่างระหว่างปุ่ม */
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
        <h2>เพิ่มแอดมิน</h2>
    </div>
    
    <form action="register_db.php" method="post">

        <div class="input-group">
            <label for="firstname">ชื่อ</label>
            <input type="text" name="firstname" placeholder="ชื่อ" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="lastname">นามสกุล</label>
            <input type="text" name="lastname" placeholder="นามสกุล" autocomplete="off" required>
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
            <label for="tell">เบอร์โทรศัพท์</label>
            <input type="text" name="tell" placeholder="tellephone number" autocomplete="off" required>
        </div>
        <div class="input-group">
            <label for="role">บทบาท</label>
            <input type="radio" name="role" value="admin-main">แอดมินหลัก
            <input type="radio" name="role" value="admin-regular" checked>แอดมินธรรมดา
        </div>
        <div class="input-group">
            <label for="status">สถานะ</label>
            <input type="radio" name="status" value="active">เปิดใช้งาน
            <input type="radio" name="status" value="inactive">ปิดใช้งาน
        </div>

        <div class="button-group">
            <button type="button" name="back" id="back-button">ย้อนกลับ</button>
            <button type="submit" name="reg_addmin" class="btn">เพิ่มแอดมิน</button>
            <a href="update_admin.php" class="manageadmin-button">จัดการแอดมิน</a>
        </div>
        </div>
        <button class="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
    </div>

    </form>
</body>
</html>
