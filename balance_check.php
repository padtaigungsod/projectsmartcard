<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Balance</title>
    <style>
        /* นำ CSS ที่ปรับแต่งมาใช้ */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 13px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 26px; 
            width: 90%;
            max-width: 520px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 18.2px;
            color: #333333;
        }

        input[type="text"] {
            width: calc(100% - 26px); 
            padding: 13px; 
            border-radius: 6.5px;
            border: 1px solid #ddd;
            font-size: 18.2px;
            box-sizing: border-box;
        }

        #balanceMessage {
            font-size: 18.2px;
            color: #333333;
            margin-top: 20px;
        }

        button[type="submit"] {
            background-color: #28a745; 
            color: #ffffff;
            border: none;
            padding: 13px 26px;
            border-radius: 6.5px;
            cursor: pointer;
            font-size: 20.8px;
        }

        button[type="submit"]:hover {
            background-color: #218838; 
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
        function showMessage(message) {
            document.getElementById("balanceMessage").innerText = message;
        }

        function handleSubmit(event) {
            // ดึงค่าที่จะส่ง
            let form = event.target;
            let data = new FormData(form);

            // ส่งค่าผ่าน AJAX
            fetch(form.action, {
                method: form.method,
                body: data
            })
            .then(response => response.text())
            .then(text => {
                showMessage(text);

                // รีเฟรชหน้าเว็บหลังจากแสดงผล 3 วินาที
                setTimeout(function() {
                    location.reload();
                }, 3000); // 3 วินาที
            });

            return false;
        }
        
        function goBack() {
            window.location.href = 'admin.php';
        }
    </script>
</head>
<body>
    <div class="container">
        <form action="balance_checkDB.php" method="POST" onsubmit="return handleSubmit(event)">
            <label for="smartcard_id">รหัสสมาร์ทการ์ด:</label>
            <input type="text" id="smartcard_id" name="smartcard_id" required>
            
            <button type="submit">ตรวจสอบยอดเงิน</button>
        </form>
        <div id="balanceMessage">
            <?php if (!empty($balanceMessage)) { echo $balanceMessage; } ?>
        </div>
        <button class="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
    </div>
</body>
</html>
