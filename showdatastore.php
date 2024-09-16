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
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยอดขายของร้านค้า</title>
    <link rel="stylesheet" href="showdatastore.css">
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
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>ออกจากระบบ</span>
                    </a>
                </li>
        </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <span>ร้านค้า</span>
                <h2>ยอดขาย</h2>
            </div>

            <div class="user--info">
                <img src="images/store-icon-logo-vector-illustration_598213-5580.avif" alt="">
            </div>
        </div>
        
        <!-- Dropdown เพื่อกรองข้อมูลตาม store_id และวันที่ -->
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
            <label for="store_id">เลือกร้านค้า:</label>
            <select name="store_id" id="store_id">
                <option value="">เลือกทั้งหมด</option>
                <?php
                include 'circulationDB.php';
                
                // ดึงข้อมูลร้านค้าทั้งหมดจากฐานข้อมูล
                $stores = mysqli_query($conn, "SELECT DISTINCT store_id FROM product");
                while($store = mysqli_fetch_assoc($stores)){
                    $selected = (isset($_GET['store_id']) && $_GET['store_id'] == $store['store_id']) ? 'selected' : '';
                    echo "<option value='".$store['store_id']."' $selected>".$store['store_id']."</option>";
                }
                ?>
            </select>

            <label for="date">เลือกวันที่:</label>
            <input type="date" name="date" id="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">

            <input type="submit" value="ค้นหา">
        </form>

        <div class="tabular--wrapper">
            <h3 class="main--title">รายละเอียด</h3>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อร้านค้า</th>
                            <th>วันที่</th>
                            <th>รายการอาหาร</th>
                            <th>หน่วยละ</th>
                            <th>จำนวน</th>
                            <th>ยอดเงินทั้งหมด</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    include 'circulationDB.php';

                    // ตรวจสอบว่ามีการเลือก store_id หรือไม่
                    $store_id_filter = isset($_GET['store_id']) ? $_GET['store_id'] : '';
                    $date_filter = isset($_GET['date']) ? $_GET['date'] : '';

                    // SQL query ที่ปรับปรุงเพื่อกรองข้อมูลตาม store_id และวันที่
                    $sql = "
                    SELECT s.storename, w.dates, p.product_id, p.price AS unit_price, 
                        SUM(wd.number_of_purchases) AS total_quantity, 
                        SUM(wd.total_price) AS total_price
                    FROM withdraw w
                    JOIN withdraw_detail wd ON w.withdraw_id = wd.withdraw_id
                    JOIN product p ON wd.product_id = p.product_id
                    JOIN store s ON w.store_id = s.store_id
                    ";

                    // เพิ่มเงื่อนไขกรองถ้ามีการเลือก store_id
                    $conditions = [];
                    if (!empty($store_id_filter)) {
                        $conditions[] = "w.store_id = '$store_id_filter'";
                    }
                    if (!empty($date_filter)) {
                        $conditions[] = "w.dates = '$date_filter'";
                    }

                    if (!empty($conditions)) {
                        $sql .= " WHERE " . implode(' AND ', $conditions);
                    }

                    $sql .= "
                    GROUP BY s.storename, w.dates, p.product_id, p.price
                    ORDER BY w.dates DESC, s.storename
                    ";

                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Query failed: " . $conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['storename']}</td>
                                    <td>{$row['dates']}</td>
                                    <td>{$row['product_id']}</td>
                                    <td>{$row['unit_price']}</td>
                                    <td>{$row['total_quantity']}</td>
                                    <td>{$row['total_price']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>
