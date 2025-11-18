<?php include('../components/navbar.php'); ?>
<?php include('../config/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการผู้เช่า</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h2>ข้อมูลผู้เช่า</h2>
<a href="add.php">+ เพิ่มผู้เช่าใหม่</a>
<table border="1" cellpadding="8">
<tr>
  <th>ID</th><th>ชื่อ-สกุล</th><th>โทรศัพท์</th><th>อีเมล</th><th>จัดการ</th>
</tr>
<?php
$result = $conn->query("SELECT * FROM tenants ORDER BY tenant_id DESC");
while($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>{$row['tenant_id']}</td>
    <td>{$row['full_name']}</td>
    <td>{$row['phone']}</td>
    <td>{$row['email']}</td>
    <td>
      <a href='edit.php?id={$row['tenant_id']}'>แก้ไข</a> | 
      <a href='delete.php?id={$row['tenant_id']}' onclick=\"return confirm('คุณแน่ใจว่าต้องการลบ?')\">ลบ</a>
    </td>
  </tr>";
}
?>
</table>
<br><a href="../">กลับหน้าหลัก</a>
</body>
</html>