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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // ตรวจสอบข้อมูลร้านค้าในฐานข้อมูล
    $sql_store = "SELECT store_id, email, password FROM stores WHERE email = '$email'";
    $result_store = $conn->query($sql_store);

    if ($result_store->num_rows == 1) {
        // ดึงข้อมูลจากฐานข้อมูล
        $row = $result_store->fetch_assoc();

        // ตรวจสอบว่ารหัสผ่านตรงกับรหัสผ่านที่เข้ารหัสในฐานข้อมูลหรือไม่
        if (password_verify($password, $row['password'])) {
            // ล็อกอินสำเร็จในฐานะ Store
            $_SESSION['store_id'] = $row['store_id'];  // เก็บ store_id
            $_SESSION['store_email'] = $row['email'];  // เก็บอีเมลของร้านค้า

            // เปลี่ยนเส้นทางไปยังหน้าแดชบอร์ดของร้านค้า
            header('Location: store.php');
            exit(); // หยุดการทำงานที่เหลือ
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_lg.css">
    <title>Login</title>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <header>Login</header>
        </div>

        <form action="login_dbSTORE.php" method="post">
         <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);

                    ?>
                </h3>
            </div>   
            <?php endif ?>
        <div class="input-box">
            <input type="text" class="input-field" name="email" placeholder="Email" autocomplete="off" required>
        </div>
        <div class="input-box">
            <input type="password" class="input-field" name="password" placeholder="Password" autocomplete="off" required>
        </div>
        <div class="input-submit">
            <button class="submit-btn" id="submit" name="login_user"></button>
            <label for="submit">Sign In</label>
        </div>
    </div>
    </form>

</body>
</html>

