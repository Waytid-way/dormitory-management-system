<?php 
include('../config/db_connect.php');
// Note: No navbar here because we want a clean printable page

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT b.*, t.full_name, r.room_number
            FROM billings b
            LEFT JOIN leases l ON b.lease_id = l.lease_id
            LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
            LEFT JOIN rooms r ON l.room_id = r.room_id
            WHERE b.billing_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill = $result->fetch_assoc();
}
if(!$bill) die("ไม่พบข้อมูลบิล");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบแจ้งหนี้ #<?= $bill['billing_id'] ?></title>
    <style>
        body { font-family: 'Sarabun', sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .total { font-weight: bold; text-align: right; background-color: #f2f2f2; }
        .btn-print { display: block; width: 100px; margin: 20px auto; padding: 10px; background: #007bff; color: white; text-align: center; text-decoration: none; cursor: pointer; }
        @media print { .btn-print { display: none; } body { border: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>ใบแจ้งหนี้ / ใบเสร็จรับเงิน</h2>
        <p>หอพักตัวอย่าง (Mockup Dorm)</p>
    </div>

    <div class="info">
        <p><b>เลขที่บิล:</b> <?= $bill['billing_id'] ?></p>
        <p><b>ผู้เช่า:</b> <?= htmlspecialchars($bill['full_name']) ?> (ห้อง <?= htmlspecialchars($bill['room_number']) ?>)</p>
        <p><b>วันที่ออกบิล:</b> <?= $bill['billing_date'] ?></p>
        <p><b>กำหนดชำระ:</b> <?= $bill['due_date'] ?></p>
        <p><b>สถานะ:</b> <?= strtoupper($bill['status']) ?></p>
    </div>

    <table>
        <tr>
            <th>รายการ</th>
            <th>จำนวนเงิน (บาท)</th>
        </tr>
        <tr>
            <td>ค่าเช่าห้องพัก</td>
            <td><?= number_format($bill['rent_amount'], 2) ?></td>
        </tr>
        <tr>
            <td>ค่าน้ำ</td>
            <td><?= number_format($bill['water_bill'], 2) ?></td>
        </tr>
        <tr>
            <td>ค่าไฟ</td>
            <td><?= number_format($bill['electric_bill'], 2) ?></td>
        </tr>
        <tr>
            <td class="total">รวมทั้งสิ้น</td>
            <td class="total"><?= number_format($bill['total_amount'], 2) ?></td>
        </tr>
    </table>

    <button onclick="window.print()" class="btn-print">พิมพ์ใบเสร็จ</button>
</body>
</html>