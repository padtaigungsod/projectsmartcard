<?php
    session_start();

    // ตรวจสอบว่า store_id ถูกส่งมาจากหน้าก่อนหรือไม่
    if (isset($_GET['store_id'])) {
        $store_id = $_GET['store_id'];
    } else {
        // ถ้าไม่มี store_id ใน URL ให้เช็คจาก session
        $store_id = isset($_SESSION['store_id']) ? $_SESSION['store_id'] : '';
    }
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="payment.css">
    <script>
        function goBack() {
            window.location.href = 'showproduct.php'; 
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>การชำระเงิน</h2>
        <form id="payment-form" method="POST" action="process_payment.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="smartcard_id">รหัสบัตรสมาร์ทการ์ด:</label>
                <input type="text" id="smartcard-id" name="smartcard_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="store_id">รหัสร้านค้า:</label>
                <input type="text" id="store-id" name="store_id" class="form-control" value="<?php echo $store_id; ?>" readonly required>
            </div>
            <div class="form-group">
                <label>รายการสินค้าที่สั่งซื้อ:</label>
                <ul id="product-list">
                    <!-- รายการสินค้าที่แสดงจะถูกเพิ่มที่นี่ -->
                </ul>
            </div>
            <div class="form-group">
                <label for="total-price">ราคารวม:</label>
                <p id="total-price">0 บาท</p>
            </div>
            <input type="hidden" name="total_price" id="total-price-hidden">
            <input type="hidden" name="cart" id="cart-hidden">
            <button type="submit" class="btn btn-primary">ชำระเงิน</button>
            <br>
            <button class="back-button" onclick="goBack()">กลับไปที่หน้าหลัก</button>
        </form>
    </div>

    <!-- Modal สำหรับแสดงป็อปอัพ -->
    <div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentSuccessModalLabel">ชำระเงินสำเร็จ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>ขอบคุณที่ทำการชำระเงิน ยอดเงินของท่านถูกหักเรียบร้อยแล้ว</p>
                    <p>รายการสินค้าที่ท่านได้ทำการสั่งซื้อ:</p>
                    <ul id="success-product-list"></ul>
                    <p>ราคารวม: <span id="success-total-price"></span> บาท</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const totalPrice = urlParams.get('total_price');
            const cart = JSON.parse(urlParams.get('cart')) || [];

            let calculatedTotalPrice = 0;
            const productList = document.getElementById('product-list');
            const totalPriceElement = document.getElementById('total-price');

            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - ${item.price} บาท x ${item.quantity}`;
                productList.appendChild(listItem);

                // คำนวณราคารวม
                calculatedTotalPrice += item.price * item.quantity;
            });

            // ใช้ราคา calculatedTotalPrice ถ้าหากไม่ได้รับจาก URL
            totalPriceElement.textContent = `${totalPrice || calculatedTotalPrice} บาท`;

            // กำหนดค่าให้กับ hidden fields
            document.getElementById('total-price-hidden').value = totalPrice || calculatedTotalPrice;
            document.getElementById('cart-hidden').value = JSON.stringify(cart);
        });

        // ป้องกันการส่งฟอร์มโดยอัตโนมัติเมื่อกรอกข้อมูลลงในช่องรหัสบัตรสมาร์ทการ์ด
        document.getElementById('smartcard-id').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();  // ป้องกันการส่งฟอร์มเมื่อกด Enter
            }
        });

        // ตรวจสอบก่อนส่งฟอร์ม
        function validateForm() {
            const smartcardId = document.getElementById('smartcard-id').value;
            const totalPrice = document.getElementById('total-price-hidden').value;

            if (!smartcardId || !totalPrice || totalPrice == 0) {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                return false;
            }

            // แสดงป็อปอัพการชำระเงินสำเร็จ
            showPaymentSuccessModal();
            return true;
        }

        // แสดง modal การชำระเงินสำเร็จ
        function showPaymentSuccessModal() {
            const modal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));
            const cart = JSON.parse(document.getElementById('cart-hidden').value);
            const totalPrice = document.getElementById('total-price-hidden').value;

            // เพิ่มรายการสินค้าใน modal
            const successProductList = document.getElementById('success-product-list');
            successProductList.innerHTML = ''; // ล้างรายการเก่า
            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - ${item.price} บาท x ${item.quantity}`;
                successProductList.appendChild(listItem);
            });

            // แสดงราคารวมใน modal
            document.getElementById('success-total-price').textContent = totalPrice;

            // แสดง modal
            modal.show();
        }
    </script>

</body>
</html>
