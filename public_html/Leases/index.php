<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>จัดการสัญญาเช่า</title></head><body>
<h2>ข้อมูลสัญญาเช่า</h2>
<a href="add.php">+ เพิ่มสัญญาใหม่</a>
<table border="1" cellpadding="8">
<tr><th>ผู้เช่า</th><th>ห้อง</th><th>วันเริ่ม</th><th>วันสิ้นสุด</th><th>สถานะ</th><th>จัดการ</th></tr>
<?php
$sql = "SELECT l.*, t.full_name, r.room_number 
        FROM leases l
        LEFT JOIN tenants t ON l.tenant_id = t.tenant_id
        LEFT JOIN rooms r ON l.room_id = r.room_id
        ORDER BY l.start_date DESC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>".htmlspecialchars($row['full_name'] ?? 'N/A')."</td>
    <td>".htmlspecialchars($row['room_number'] ?? 'N/A')."</td>
    <td>{$row['start_date']}</td>
    <td>{$row['end_date']}</td>
    <td>".($row['active'] ? 'Active' : 'Inactive')."</td>
    <td>
      <a href='edit.php?id={$row['lease_id']}'>แก้ไข</a> | 
      <a href='delete.php?id={$row['lease_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบ?')\">ลบ</a>
    </td>
  </tr>";
}
?>
</table>
<br><a href="../">กลับหน้าหลัก</a>
</body></html>