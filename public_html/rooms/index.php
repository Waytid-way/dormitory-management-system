<?php include('../components/navbar.php'); ?>
<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>จัดการห้องพัก</title></head><body>
<h2>ข้อมูลห้องพัก</h2>
<a href="add.php">+ เพิ่มห้องพักใหม่</a>
<table border="1" cellpadding="8">
<tr><th>เลขห้อง</th><th>ชั้น</th><th>ประเภท</th><th>ราคา/เดือน</th><th>สถานะ</th><th>จัดการ</th></tr>
<?php
$result = $conn->query("SELECT * FROM rooms ORDER BY room_number");
while($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>".htmlspecialchars($row['room_number'])."</td>
    <td>".htmlspecialchars($row['floor'])."</td>
    <td>".htmlspecialchars($row['room_type'])."</td>
    <td>".number_format($row['price_per_month'], 2)."</td>
    <td>".htmlspecialchars($row['status'])."</td>
    <td>
      <a href='edit.php?id={$row['room_id']}'>แก้ไข</a> | 
      <a href='delete.php?id={$row['room_id']}' onclick="return confirm('คุณแน่ใจว่าต้องการลบ?')">ลบ</a>
    </td>
  </tr>";
}
?>
</table>
<br><a href="../">กลับหน้าหลัก</a>
</body></html>