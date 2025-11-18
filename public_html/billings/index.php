<?php include('../components/navbar.php'); ?>
<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>จัดการใบแจ้งหนี้</title></head><body>
<h2>ข้อมูลใบแจ้งหนี้</h2>
<a href="add.php">+ สร้างใบแจ้งหนี้ใหม่</a>
<table border="1" cellpadding="8">
<tr><th>สัญญา (ผู้เช่า/ห้อง)</th><th>วันที่</th><th>ยอดรวม</th><th>สถานะ</th><th>จัดการ</th></tr>
<?php
$sql = "SELECT b.*, t.full_name, r.room_number
        FROM billings b
        LEFT JOIN leases l ON b.lease_id = l.lease_id
        LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
        LEFT JOIN rooms r ON l.room_id = r.room_id
        ORDER BY b.billing_date DESC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
echo "<tr>
  <td>".htmlspecialchars($row['full_name'] ?? 'N/A')." / ".htmlspecialchars($row['room_number'] ?? 'N/A')."</td>
  <td>{$row['billing_date']}</td>
  <td>".number_format($row['total_amount'], 2)."</td>
  <td>".htmlspecialchars($row['status'])."</td>
  <td>
    <a href='receipt.php?id={$row['billing_id']}' target='_blank' style='color:green;'>[ดูใบเสร็จ]</a> | 
    <a href='edit.php?id={$row['billing_id']}'>แก้ไข</a> | 
    <a href='delete.php?id={$row['billing_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบ?')\">ลบ</a>
  </td>
</tr>";
}
?>
</table>
<br><a href="../">กลับหน้าหลัก</a>
</body></html>