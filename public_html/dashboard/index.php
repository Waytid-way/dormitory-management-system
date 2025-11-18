<?php include('../components/navbar.php'); ?>
<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>แดชบอร์ด</title>
<style>
    body { font-family: sans-serif; padding: 20px; background: #f9f9f9; }
    h1, h2 { color: #333; }
    nav { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
    nav a { text-decoration: none; color: #007bff; font-weight: bold; margin-right: 15px; }
    nav a:hover { text-decoration: underline; }
    .card-container { display: flex; gap: 20px; flex-wrap: wrap; }
    .card { background: #fff; border: 1px solid #ccc; border-radius: 8px; padding: 20px; min-width: 200px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .card h3 { margin-top: 0; color: #555; }
    .card p { font-size: 2em; font-weight: bold; margin: 0; color: #007bff; }
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    th { background: #f2f2f2; }
    tr:nth-child(even) { background: #f9f9f9; }
</style>
</head>
<body>
<h1>แดชบอร์ดภาพรวม</h1>
<nav>
    <a href="../">หน้าหลัก</a> |
    <a href="../tenants/">จัดการผู้เช่า</a> |
    <a href="../rooms/">จัดการห้องพัก</a> |
    <a href="../leases/">จัดการสัญญา</a> |
    <a href="../billings/">จัดการบิล</a> |
    <a href="../payments/">จัดการชำระเงิน</a>
</nav>

<?php
// ห้องว่าง
$r1 = $conn->query("SELECT COUNT(*) AS c FROM rooms WHERE status='available'")->fetch_assoc();
// ห้องมีคนเช่า
$r2 = $conn->query("SELECT COUNT(*) AS c FROM rooms WHERE status='occupied'")->fetch_assoc();
// บิลยังไม่จ่าย
$b1 = $conn->query("SELECT COUNT(*) AS c FROM billings WHERE status='unpaid' OR status='overdue'")->fetch_assoc();
// ยอดรวมรายรับเดือนนี้ (CURDATE() is Awardspace friendly)
$rev = $conn->query("SELECT SUM(amount) AS s FROM payments WHERE MONTH(payment_date)=MONTH(CURDATE()) AND YEAR(payment_date)=YEAR(CURDATE())")->fetch_assoc();
?>
<div class="card-container">
    <div class="card">
        <h3>ห้องว่าง</h3>
        <p><?= $r1['c'] ?></p>
    </div>
    <div class="card">
        <h3>ห้องมีผู้เช่า</h3>
        <p><?= $r2['c'] ?></p>
    </div>
    <div class="card">
        <h3>บิลค้างชำระ</h3>
        <p><?= $b1['c'] ?></p>
    </div>
    <div class="card">
        <h3>รายรับเดือนนี้</h3>
        <p><?= number_format($rev['s'] ?? 0, 2) ?> ฿</p>
    </div>
</div>

<h2 style="margin-top: 40px;">บิลที่ยังไม่จ่าย</h2>
<table>
<tr><th>บิล ID</th><th>ผู้เช่า</th><th>ห้อง</th><th>ยอดรวม</th><th>สถานะ</th></tr>
<?php
$sql = "SELECT b.*, t.full_name, r.room_number
        FROM billings b
        LEFT JOIN leases l ON b.lease_id = l.lease_id
        LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
        LEFT JOIN rooms r ON l.room_id = r.room_id
        WHERE b.status = 'unpaid' OR b.status = 'overdue'
        ORDER BY b.due_date ASC";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr>
        <td>{$row['billing_id']}</td>
        <td>".htmlspecialchars($row['full_name'] ?? 'N/A')."</td>
        <td>".htmlspecialchars($row['room_number'] ?? 'N/A')."</td>
        <td>".number_format($row['total_amount'], 2)."</td>
        <td>".htmlspecialchars($row['status'])."</td>
      </tr>";
    }
} else {
    echo '<tr><td colspan="5" style="text-align:center;">ไม่พบข้อมูลบิลค้างชำระ</td></tr>';
}
?>
</table>

</body>
</html>