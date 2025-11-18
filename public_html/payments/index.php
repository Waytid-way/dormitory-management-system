<?php include('../components/navbar.php'); ?>
<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>จัดการการชำระเงิน</title></head><body>
<h2>ข้อมูลการชำระเงิน</h2>
<a href="add.php">+ บันทึกการชำระเงิน</a>
<table border="1" cellpadding="8">
<tr><th>บิล ID</th><th>ผู้จ่าย</th><th>จำนวน</th><th>วันที่ชำระ</th><th>วิธี</th><th>จัดการ</th></tr>
<?php
$sql = "SELECT p.*, t.full_name 
        FROM payments p
        LEFT JOIN billings b ON p.billing_id = b.billing_id
        LEFT JOIN leases l ON b.lease_id = l.lease_id
        LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
        ORDER BY p.payment_date DESC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>{$row['billing_id']}</td>
    <td>".htmlspecialchars($row['full_name'] ?? 'N/A')."</td>
    <td>".number_format($row['amount'], 2)."</td>
    <td>{$row['payment_date']}</td>
    <td>".htmlspecialchars($row['method'])."</td>
    <td>
      <a href='delete.php?id={$row['payment_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบ?')\">ลบ</a>
    </td>
  </tr>";
}
?>
</table>
<br><a href="../">กลับหน้าหลัก</a>
</body></html>