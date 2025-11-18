<?php 
include('../config/db_connect.php'); 
if(isset($_POST['submit'])){
    $stmt = $conn->prepare("INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $total = $_POST['rent'] + $_POST['water'] + $_POST['electric'];
    $status = 'unpaid';
    $stmt->bind_param("issdddds", $_POST['lease_id'], $_POST['billing_date'], $_POST['due_date'], $_POST['rent'], $_POST['water'], $_POST['electric'], $total, $status);
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    $stmt->close();
}
// Get active leases
$leases = $conn->query("SELECT l.lease_id, t.full_name, r.room_number 
                        FROM leases l 
                        JOIN tenants t ON l.tenant_id = t.tenant_id
                        JOIN rooms r ON l.room_id = r.room_id
                        WHERE l.active = 1");
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>สร้างใบแจ้งหนี้</title></head><body>
<h2>สร้างใบแจ้งหนี้ใหม่</h2>
<form method="post">
  <label>สัญญา (ผู้เช่า/ห้อง):</label>
  <select name="lease_id" required>
    <option value="">-- เลือกสัญญา --</option>
    <?php while($l = $leases->fetch_assoc()) echo "<option value='{$l['lease_id']}'>".htmlspecialchars($l['full_name'])." / ".htmlspecialchars($l['room_number'])."</option>"; ?>
  </select><br>
  <label>วันที่ออกบิล:</label><input type="date" name="billing_date" value="<?= date('Y-m-d'); ?>" required><br>
  <label>วันครบกำหนด:</label><input type="date" name="due_date" required><br>
  <label>ค่าเช่า:</label><input type="number" step="0.01" name="rent" required><br>
  <label>ค่าน้ำ:</label><input type="number" step="0.01" name="water" required><br>
  <label>ค่าไฟ:</label><input type="number" step="0.01" name="electric" required><br>
  <input type="submit" name="submit" value="บันทึก">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>