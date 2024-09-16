<?php  
    session_start();

    if(!isset($_SESSION['email'])){
        $_SESSION['msg'] = "You must log in first";
        header('location: login_store.php');
    }

    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['email']);
        header('location: login_store.php');
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectsmartcard";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ดึงอีเมลของผู้ใช้ที่ล็อกอิน
    $email = $_SESSION['email'];

    // ดึง store_id จากตารางร้านค้าตามอีเมล
    $store_query = "SELECT store_id FROM store WHERE email = '$email'";
    $store_result = $conn->query($store_query);

    if ($store_result->num_rows > 0) {
        $store_row = $store_result->fetch_assoc();
        $store_id = $store_row['store_id'];
    } else {
        echo "Store not found.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store_manage</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_st_mn_pr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li class="active">
                <a href="store.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>หน้าหลัก</span>
                </a>
            </li>
            <li>
                <a href="circulation.php">
                    <i class="fas fa-user"></i>
                    <span>ยอดขาย</span>
                </a>
            </li>
            <li>
                <a href="showproduct.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>สินค้าทั้งหมด</span>
                </a>
            </li>
            <li>
                <a href="store_managePr.php">
                    <i class="fas fa-cog"></i>
                    <span>จัดการสินค้า</span>
                </a>
            </li>
            <li>
                <a href="login_store.php">
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
                <h2>สินค้าทั้งหมด</h2>
            </div>
            <?php
            // ดึงสินค้าตาม store_id ที่ได้จากการล็อกอิน
            $select = mysqli_query($conn, "SELECT * FROM product WHERE store_id = '$store_id'");

            if (mysqli_num_rows($select) > 0) {
       
      ?>
            <div class="user--info">
                <img src="images/shop-icon-png-5.jpg" alt="">
            </div>
        </div>

        <div class="tabular--wrapper">
            <?php
            while ($row = mysqli_fetch_assoc($select)) {
            ?>
                <div class="card">
                    <div class="image">
                        <img src="uploaded_img/<?php echo $row['img']; ?>" alt="">
                    </div>
                    <div class="caption">
                        <p class="product_name"><?php echo $row["product_name"]; ?></p>
                        <p class="price">ราคา <?php echo $row["price"]; ?> บาท</p>
                        <p class="discount">หมายเหตุ : <?php echo $row["note"]; ?></p>
                    </div>
                    <button class="add-to-cart" onclick="addToCart(<?php echo $row['product_id']; ?>, '<?php echo $row['product_name']; ?>', <?php echo $row['price']; ?>)">+</button>
                </div>
            <?php
            }
            ?>
             <?php
            } else {
                echo "ไม่มีสินค้าสำหรับร้านค้านี้";
            }
        ?>
        </div>
    </div>

    <button id="cart-button" onclick="toggleCart()">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count">0</span>
    </button>

    <div id="cart-container">
        <button id="close-cart" onclick="toggleCart()">
            <i class="fas fa-times"></i>
        </button>
        <h2>ตะกร้าสินค้า</h2>
        <ul id="cart-items">
            <!-- รายการสินค้าที่เพิ่มจะถูกแสดงที่นี่ -->
        </ul>
        <p id="total-price">ราคารวม: 0 บาท</p>
        <button id="buy-button" onclick="checkout()">สั่งซื้อสินค้า</button>
    </div>

    <style>
        .card {
            position: relative;
            width: 200px;
            border: 1px solid #ccc;
            padding: 16px;
            margin: 16px;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }

        .image {
            width: 100%;
            height: 150px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .add-to-cart {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
            transition: transform 0.2s;
            margin-top: 10px;
        }

        .add-to-cart:hover {
            transform: scale(1.2);
        }

        #cart-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #cart-count {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #cart-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
            text-align: center;
        }

        #cart-container h2 {
            margin-top: 0;
        }

        #cart-items {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #cart-items li {
            margin-bottom: 10px;
        }

        #total-price {
            font-weight: bold;
            margin-top: 20px;
        }

        #buy-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            border-radius: 5px;
        }

        #close-cart {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff0000;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            color: white;
            padding: 5px;
            z-index: 10;
        }

        #close-cart:hover {
            background-color: #cc0000;
        }

        #close-cart i {
            margin: 0;
        }

    </style>

<script>
        let cart = [];

        function addToCart(productId, productName, productPrice) {
            let item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += 1;
            } else {
                cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
            }

            updateCart();
        }

        function updateCart() {
            const cartCount = document.getElementById('cart-count');
            const cartItems = document.getElementById('cart-items');
            const totalPriceElement = document.getElementById('total-price');
            let totalPrice = 0;

            cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);

            cartItems.innerHTML = '';

            cart.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.name} - ${item.price} บาท x ${item.quantity}`;
                cartItems.appendChild(li);
                totalPrice += item.price * item.quantity;
            });

            totalPriceElement.textContent = `ราคารวม: ${totalPrice} บาท`;
        }

        function toggleCart() {
            const cartContainer = document.getElementById('cart-container');
            if (cartContainer.style.display === 'none' || cartContainer.style.display === '') {
                cartContainer.style.display = 'block';
            } else {
                cartContainer.style.display = 'none';
            }
        }

        function checkout() {
    const totalPrice = cart.reduce((total, item) => total + item.price * item.quantity, 0);

    if (totalPrice > 0) {
        const form = document.createElement('form');
        form.method = 'GET';  // หรือเปลี่ยนเป็น 'POST' ถ้าต้องการใช้ POST
        form.action = 'payment.php';

        // สร้าง input สำหรับราคาทั้งหมด
        const totalInput = document.createElement('input');
        totalInput.type = 'hidden';
        totalInput.name = 'total_price';
        totalInput.value = totalPrice;
        form.appendChild(totalInput);

        // สร้าง input สำหรับรายการสินค้าในตะกร้า
        const cartInput = document.createElement('input');
        cartInput.type = 'hidden';
        cartInput.name = 'cart';
        cartInput.value = JSON.stringify(cart);  // แปลงรายการในตะกร้าเป็น JSON
        form.appendChild(cartInput);

        // ส่ง store_id ที่ได้จากการล็อกอินไปด้วย
        const storeInput = document.createElement('input');
        storeInput.type = 'hidden';
        storeInput.name = 'store_id';
        storeInput.value = '<?php echo $store_id; ?>';  // ดึง store_id จาก PHP
        form.appendChild(storeInput);

        document.body.appendChild(form);
        form.submit();
    } else {
        alert('กรุณาตรวจสอบตะกร้าสินค้า');
    }
}



    </script>

</body>
</html>
