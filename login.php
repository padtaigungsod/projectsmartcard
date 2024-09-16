<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "projectsmartcard");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ตรวจสอบว่าผู้ใช้เป็นแอดมินหรือร้านค้า
    // กรณีแอดมิน
    $sql_admin = "SELECT admin_id, email FROM admins WHERE email = '$email' AND password = '$password'";
    $result_admin = $conn->query($sql_admin);


    if ($result_admin->num_rows == 1) {
        // ล็อกอินสำเร็จในฐานะ Admin
        $row = $result_admin->fetch_assoc();
        $_SESSION['admin_id'] = $row['admin_id'];  // เก็บ admin_id
        $_SESSION['admin_email'] = $row['email'];  // เก็บอีเมลของแอดมิน

        // เปลี่ยนเส้นทางไปยังหน้าแดชบอร์ดของแอดมิน
        header('Location: admin.php');
        exit();
    }  else {
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

        <form action="login_db.php" method="post">
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

