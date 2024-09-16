<?php
// แสดงข้อผิดพลาดของ SQL เพื่อการดีบัก
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// เชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "projectsmartcard");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่าจากฟอร์มที่ส่งมาหลังจากการชำระเงิน
$smartcard_id = $_POST['smartcard_id'];
$store_id = isset($_POST['store_id']) ? $_POST['store_id'] : NULL; // ใช้ NULL หากไม่มี store_id
$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : NULL; // ใช้ NULL หากไม่มี admin_id
$withdraw_price = $_POST['total_price'];

$conn->begin_transaction();

try {
    // 1. ค้นหายอดเงินคงเหลือล่าสุดที่มี transaction_type เป็น 'topup' และ status เป็น 'active'
    $stmt_balance_check = $conn->prepare("
        SELECT balance FROM topup_close
        WHERE smartcard_id = ? AND status = 'active'
        ORDER BY dates DESC, times DESC
        LIMIT 1
    ");
    $stmt_balance_check->bind_param('i', $smartcard_id);
    $stmt_balance_check->execute();
    $stmt_balance_check->bind_result($current_balance);
    $stmt_balance_check->fetch();
    $stmt_balance_check->close();

    if ($current_balance === NULL) {
        throw new Exception("ไม่พบข้อมูลยอดเงินคงเหลือสำหรับบัตรนี้");
    }

    // 2. คำนวณยอดเงินที่เหลือหลังจากการซื้อ
    $remaining_balance = $current_balance - $withdraw_price;

    if ($remaining_balance < 0) {
        throw new Exception("ยอดเงินคงเหลือไม่เพียงพอ");
    }

        // 3. เพิ่มข้อมูลลงในตาราง withdraw
    $stmt_withdraw = $conn->prepare("
    INSERT INTO withdraw (smartcard_id, store_id, withdraw_price, dates, times, type_withdraw)
    VALUES (?, ?, ?, CURDATE(), CURTIME(), 'Purchase')
    ");
    $stmt_withdraw->bind_param('sis', $smartcard_id, $store_id, $withdraw_price);
    $stmt_withdraw->execute();

    // ดึงรหัสการถอน (withdraw_id) ล่าสุดที่เพิ่มเข้ามา
    $withdraw_id = $conn->insert_id;

    // 4. เพิ่มรายละเอียดการถอนลงในตาราง withdraw_detail
    $cart = json_decode($_POST['cart'], true); // รับข้อมูลสินค้าจากตะกร้า
    foreach ($cart as $item) {
        $stmt_detail = $conn->prepare("
            INSERT INTO withdraw_detail (product_id, withdraw_id, number_of_purchases, total_price)
            VALUES (?, ?, ?, ?)
        ");
        $total_price = $item['price'] * $item['quantity']; // คำนวณราคาทั้งหมด
        $stmt_detail->bind_param('iids', $item['id'], $withdraw_id, $item['quantity'], $total_price);
        $stmt_detail->execute();
    }

        // 5. เพิ่มรายการการชำระเงินลงในตาราง topup_close พร้อมกับยอดเงินคงเหลือที่หักแล้ว
    $stmt_balance_update = $conn->prepare("
    INSERT INTO topup_close (store_id, smartcard_id, admin_id, transaction_type, incoming_money, dates, times, balance, status)
    VALUES (?, ?, ?, 'Purchase', ?, CURDATE(), CURTIME(), ?, 'active')
    ");
    $stmt_balance_update->bind_param('iiidd', $store_id, $smartcard_id, $admin_id, $withdraw_price, $remaining_balance);
    $stmt_balance_update->execute();

    // ตรวจสอบผลลัพธ์
    if ($stmt_withdraw->affected_rows > 0 && $stmt_balance_update->affected_rows > 0) {
        $conn->commit(); // คอมมิตการทำธุรกรรม
        echo "ชำระเงินสำเร็จ";
         // หน่วงเวลา 3 วินาทีก่อนเปลี่ยนเส้นทางไปที่หน้าอื่น
         sleep(3);
         
        header('Location: showproduct.php');
    } else {
        throw new Exception("ไม่สามารถบันทึกข้อมูลหรืออัปเดตยอดเงินได้");
    }
} catch (Exception $e) {
    $conn->rollback(); // ย้อนกลับการทำธุรกรรมหากเกิดข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
