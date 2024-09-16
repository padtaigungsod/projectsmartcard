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

    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectsmartcard";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // คิวรีข้อมูลร้านค้าทั้งหมด
    $sql = "SELECT store_id, storename FROM store";
    $result = $conn->query($sql);

    $stores = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $stores[] = $row;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="style_shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                    <a href="registerSTORE.php">
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
                <h2>ร้านค้า</h2>
            </div>

            <div class="user--info">
                <img src="images/9703596.png" alt="">
            </div>
        </div>

        <div class="card--container">
            <h3 class="main--title">ร้านค้าทั้งหมด</h3>
            <div class="card--wrapper">
                <?php foreach ($stores as $store) { ?>
                    <div class="payment--card" data-store-id="<?php echo $store['store_id']; ?>">
                        <div class="card--header">
                            <div class="amount">
                                <span class="title">รหัสร้าน : <?php echo $store['store_id']; ?></span>
                                <span class="amount-value"><?php echo $store['storename']; ?></span>
                            </div>
                            <i class="fas fa-store icon"></i>
                        </div>
                        <span class="card-detail"></span>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="modalContent">
                    <!-- Store information will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btns = document.querySelectorAll('.payment--card');

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // Get the modal content
            var modalContent = document.getElementById("modalContent");

            // When the user clicks on the card, open the modal
            btns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var storeId = btn.getAttribute('data-store-id');
                    // Fetch store data
                    fetchStoreData(storeId);
                    modal.style.display = "block";
                });
            });

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            function fetchStoreData(storeId) {
                // Fetch data from server
                fetch('shopDB.php?id=' + storeId)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.store_id) {
                            var content = `
                                <h3>ข้อมูลร้านค้า</h3>
                                <p><strong>รหัสร้าน:</strong> ${data.store_id}</p>
                                <p><strong>ชื่อ:</strong> ${data.firstname} ${data.lastname}</p>
                                <p><strong>ชื่อร้าน:</strong> ${data.storename}</p>
                                <p><strong>โทรศัพท์:</strong> ${data.tell}</p>
                                <p><strong>อีเมล:</strong> ${data.email}</p>
                                <p><strong>สถานะ:</strong> ${data.status}</p>
                            `;
                            modalContent.innerHTML = content;
                        } else {
                            modalContent.innerHTML = `<p>ข้อมูลร้านค้าไม่พบ</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        modalContent.innerHTML = `<p>เกิดข้อผิดพลาดในการดึงข้อมูลร้านค้า</p>`;
                    });
            }
        });
    </script>

</body>
</html>
