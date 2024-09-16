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
    $sql = "SELECT * FROM admin";
    $result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE ADMIN</title>
    <link rel="stylesheet" href="update_admin.css">
    <script>
        function goBack() {
            window.location.href = 'admin.php'; 
        }
    </script>

</head>
<body>
    <div class="messagebox">
        <h1>รายการแอดมิน</h1>
    </div>
    <div class="tabular--wrapper">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ไอดี</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>เบอร์โทร</th>
                        <th>บทบาท</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['admin_id']; ?></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['tell']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <form action="update_adminDB.php" method="post">
                                    <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                                    <select name="status" class="status-select">
                                        <option value="active" <?php if ($row['status'] == 'active') echo 'selected'; ?>>เปิดใช้งาน</option>
                                        <option value="inactive" <?php if ($row['status'] == 'inactive') echo 'selected'; ?>>ปิดใช้งาน</option>
                                    </select>
                                    <button type="submit" class="update-btn">อัปเดต</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
            <button class="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
        </div>
    </div>
</body>
</html>
