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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectsmartcard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date
$today = date('Y-m-d');
$selected_date = isset($_GET['selected_date']) ? $_GET['selected_date'] : $today;

// Query to get total top-ups and withdrawals for the selected date
$sql_topup = "SELECT SUM(incoming_money) AS total_topup FROM topup_close 
                WHERE transaction_type = 'topup' AND dates = '$selected_date'";
$sql_withdraw = "SELECT SUM(incoming_money) AS total_withdraw FROM topup_close 
                  WHERE transaction_type = 'withdraw' AND dates = '$selected_date'";

$result_topup = $conn->query($sql_topup);
$result_withdraw = $conn->query($sql_withdraw);

// Fetch totals
$topup_total = $result_topup->fetch_assoc()['total_topup'] ?? 0;
$withdraw_total = $result_withdraw->fetch_assoc()['total_withdraw'] ?? 0;

// Query the topup_close table for transactions made by an admin
$sql = "SELECT dates, smartcard_id, transaction_type, incoming_money, admin_id 
        FROM topup_close 
        WHERE transaction_type IN ('topup', 'withdraw') 
        AND admin_id IS NOT NULL
        AND dates = '$selected_date'
        ORDER BY dates DESC, transaction_type DESC"; // Ensure the latest transactions are on top

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin regula</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

       <div class="sidebar">
            <div class="logo"></div>
            <ul class="menu">
                <li class="active">
                    <a href="admin_regular.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>หน้าหลัก</span>
                    </a>
                </li>
                <li>
                    <a href="shop_regular.php">
                        <i class="fas fa-user"></i>
                        <span>ร้านค้า</span>
                    </a>
                </li>
                <li>
                    <a href="topup_regular.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>เครดิต</span>
                    </a>
                </li>
                <li>
                    <a href="balance_check_regular.php">
                        <i class="fas fa-cog"></i>
                        <span>เช็คยอดเงินในสมาร์ทการ์ด</span>
                    </a>
                </li>
                <li>
                    <a href="registerSTORE_regular.php">
                        <i class="fas fa-cog"></i>
                        <span>เพิ่มร้านค้า</span>
                    </a>
                </li>
                <li>
                    <a href="showdatastore_regular.php">
                        <i class="fas fa-cog"></i>
                        <span>ดูยอดขายร้านค้า</span>
                    </a>
                </li>
                <li>
                    <a href="showdatauser_regular.php">
                        <i class="fas fa-cog"></i>
                        <span>ดูยอดการใช้จ่ายลูกค้า</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="admin.php?logout='1'"><span>ออกจากระบบ</span></a>
                    </a>
                </li>
            </ul>
       </div>

       <div class="main--content">
            <div class="header--wrapper">
                <div class="header--title">
                    <span>แอดมิน</span>
                    <h2>หน้าหลัก</h2>
                </div>

                <div class="user--info">
                    
                    <img src="images/9703596.png" alt="">
                </div>
            </div>
       

            <div class="card--container">
        <h3 class="main--title">ข้อมูลของวันที่ <?php echo $selected_date; ?></h3>
        <div class="card--wrapper">
            <div class="payment--card light-red">
                <div class="card--header">
                    <div class="amount">
                        <span class="title">เงินฝากเข้า</span>
                        <span class="amount-value"><?php echo number_format($topup_total, 2); ?> บาท</span>
                    </div>
                    <i class="fas fa-baht-sign icon"></i>
                </div>
                <span class="card-detail"></span>
            </div>

            <div class="payment--card light-purple">
                <div class="card--header">
                    <div class="amount">
                        <span class="title">เงินถอนออก</span>
                        <span class="amount-value"><?php echo number_format($withdraw_total, 2); ?> บาท</span>
                    </div>
                    <i class="fas fa-baht-sign icon dark-purple"></i>
                </div>
                <span class="card-detail"></span>
            </div>
        </div>
    </div>

    <div class="tabular--wrapper">
    <div class="date-selector">
    <form method="GET" action="">
        <label for="selected_date">เลือกวันที่:</label>
        <input type="date" id="selected_date" name="selected_date" value="<?php echo isset($_GET['selected_date']) ? $_GET['selected_date'] : $today; ?>">
        <button type="submit">ค้นหา</button>
    </form>
</div>

        <h3 class="main--title">รายละเอียดข้อมูลวันที่ <?php echo $selected_date; ?></h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>วันที่ทำรายการ</th>
                        <th>ไอดีสมาร์ทการ์ด</th>
                        <th>ประเภทการทำรายการ</th>
                        <th>จำนวนเงิน</th>
                        <th>ผู้ทำรายการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Check the transaction type and set the corresponding text and color
                            if ($row['transaction_type'] == 'Topup') {
                                $transaction_type_text = 'เติมเงิน';
                                $text_color = 'green';
                            } elseif ($row['transaction_type'] == 'Withdraw') {
                                $transaction_type_text = 'ถอนเงิน';
                                $text_color = 'red';
                            } else {
                                $transaction_type_text = 'ไม่ทราบประเภท';
                                $text_color = 'black';
                            }

                            echo "<tr>
                                    <td>" . $row['dates'] . "</td>
                                    <td>" . $row['smartcard_id'] . "</td>
                                    <td style='color: $text_color;'>" . $transaction_type_text . "</td>
                                    <td>" . $row['incoming_money'] . "</td>
                                    <td>Admin" . $row['admin_id'] . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>ไม่มีรายการในวันที่เลือก</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
</body>
</html>