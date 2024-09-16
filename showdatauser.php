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


// Get selected date from form or default to today's date
$date_filter = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// SQL query to get details from withdraw, withdraw_detail, store, and product
$sql = "
SELECT w.dates, w.smartcard_id, s.storename AS store_name, p.product_name AS product_name, wd.number_of_purchases, wd.total_price
FROM withdraw w
JOIN withdraw_detail wd ON w.withdraw_id = wd.withdraw_id
JOIN store s ON w.store_id = s.store_id
JOIN product p ON wd.product_id = p.product_id
WHERE w.dates = '$date_filter'
";

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยอดการใช้จ่ายของลูกค้า</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li class="active">
                <a href="admin.php" >
                    <i class="fas fa-tachometer-alt"></i>
                    <span>หน้าหลัก</span>
                </a>
            </li>
            <li>
                <a href="shop.php">
                    <i class="fas fa-user"></i>
                    <span>ร้านค้า</span>
                </a>
            </li>
            <li>
                <a href="topup.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>เครดิต</span>
                </a>
            </li>
            <li>
                    <a href="balance_check.php">
                        <i class="fas fa-cog"></i>
                        <span>เช็คยอดเงินในสมาร์ทการ์ด</span>
                    </a>
                </li>
            <li>
                <a href="register.php">
                    <i class="fas fa-cog"></i>
                    <span>เพิ่มแอดมิน</span>
                </a>
            </li>
            <li>
                <a href="registerSTORE.php">
                    <i class="fas fa-cog"></i>
                    <span>เพิ่มร้านค้า</span>
                </a>
            </li>
            <li>
                <a href="showdatastore.php">
                    <i class="fas fa-cog"></i>
                    <span>ดูยอดขายร้านค้า</span>
                </a>
            </li>
            <li>
                    <a href="showdatauser.php">
                        <i class="fas fa-cog"></i>
                        <span>ดูยอดการใช้จ่ายลูกค้า</span>
                    </a>
                </li>
            <li>
                <a href="admin.php?logout='1'">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>ออกจากระบบ</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <span>แอดมินหลัก</span>
                <h2>หน้าหลัก</h2>
            </div>

            <div class="user--info">
                <img src="images/9703596.png" alt="">
            </div>
        </div>

        <!-- Form for selecting date -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <label for="date">เลือกวันที่:</label>
            <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($date_filter); ?>">
            <input type="submit" value="ค้นหา">
        </form>

        <div class="tabular--wrapper">
            <h3 class="main--title">รายละเอียดข้อมูลวันที่ <?php echo htmlspecialchars($date_filter); ?></h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>วันที่ทำรายการ</th>
                            <th>ไอดีสมาร์ทการ์ด</th>
                            <th>ร้านค้า</th>
                            <th>สินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคา</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['dates']) . "</td>
                                        <td>" . htmlspecialchars($row['smartcard_id']) . "</td>
                                        <td>" . htmlspecialchars($row['store_name']) . "</td>
                                        <td>" . htmlspecialchars($row['product_name']) . "</td>
                                        <td>" . htmlspecialchars($row['number_of_purchases']) . "</td>
                                        <td>" . htmlspecialchars($row['total_price']) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No transactions found</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>
