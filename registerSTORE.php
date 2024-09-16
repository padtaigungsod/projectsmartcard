<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มร้านค้า</title>
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
            background-color: #CC3366;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 400px;
            z-index: 1000;
            font-size: 18px;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 3px 12px rgba(0, 0, 0, 0.1);
            padding: 15px;
            max-width: 400px;
            width: 100%;
            margin-top: 120px;
        }

        .input-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #CC3366;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 3px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="radio"] {
            width: auto;
            margin-right: 5px;
        }

        .radio-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-group label {
            margin: 0;
            font-weight: normal;
            font-size: 14px;
        }

        .btn,
        .managestore-button,
        .addstore-button,
        #back-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
        }

        .addstore-button {
            background-color: #66bb6a;
            color: white;
            transition: background-color 0.3s ease;
        }

        .addstore-button:hover {
            background-color: #57a863;
        }

        .managestore-button {
            background-color: #CC3366;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .managestore-button:hover {
            background-color: #CC3366;
        }

        #back-button {
            background-color: #c62828;
            color: white;
            transition: background-color 0.3s ease;
        }

        #back-button:hover {
            background-color: #d32f2f;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
        }

        .back-button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        /* ปรับแต่งสำหรับหน้าจอขนาดเล็ก */
        @media (max-width: 600px) {
            .header,
            form {
                width: 90%;
            }

            .button-group {
                flex-direction: column;
                align-items: stretch;
            }

            .btn,
            .managestore-button,
            #back-button {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
    <script>
        function goBack() {
            window.location.href = 'admin.php';
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
            <div class="radio-group">
                <input type="radio" name="status" value="active">เปิดใช้งาน
                <input type="radio" name="status" value="inactive">ปิดใช้งาน
            </div>
        </div>

        <div class="button-group">
            <button type="button" id="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
            <button type="submit" class="addstore-button">เพิ่มร้านค้า</button>
            <a href="update_store.php" class="managestore-button">จัดการร้านค้า</a>
        </div>
    </form>
</body>
</html>
