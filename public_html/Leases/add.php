<?php 
include('../config/db_connect.php'); 
if(isset($_POST['submit'])){
    $stmt = $conn->prepare("INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdi", $tenant_id, $room_id, $start_date, $end_date, $deposit, $active);
    
    $tenant_id = $_POST['tenant_id'];
    $room_id = $_POST['room_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $deposit = $_POST['deposit'];
    $active = isset($_POST['active']) ? 1 : 0;
    
    if($stmt->execute()){ 
        // Update room status to 'occupied'
        $conn->query("UPDATE rooms SET status = 'occupied' WHERE room_id = $room_id");
        header("Location: index.php"); exit(); 
    }
    $stmt->close();
}
// Fetch tenants and available rooms for dropdowns
$tenants = $conn->query("SELECT tenant_id, full_name FROM tenants ORDER BY full_name");
$rooms = $conn->query("SELECT room_id, room_number FROM rooms WHERE status = 'available' ORDER BY room_number");
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>เพิ่มสัญญาเช่า</title></head><body>
<h2>เพิ่มสัญญาเช่าใหม่</h2>
<form method="post">
  <label>ผู้เช่า:</label>
  <select name="tenant_id" required>
    <option value="">-- เลือกผู้เช่า --</option>
    <?php while($t = $tenants->fetch_assoc()) echo "<option value='{$t['tenant_id']}'>".htmlspecialchars($t['full_name'])."</option>"; ?>
  </select><br>
  <label>ห้อง (เฉพาะห้องว่าง):</label>
  <select name="room_id" required>
    <option value="">-- เลือกห้อง --</option>
    <?php while($r = $rooms->fetch_assoc()) echo "<option value='{$r['room_id']}'>".htmlspecialchars($r['room_number'])."</option>"; ?>
  </select><br>
  <label>วันเริ่ม:</label><input type="date" name="start_date" required><br>
  <label>วันสิ้นสุด:</label><input type="date" name="end_date"><br>
  <label>เงินมัดจำ:</label><input type="number" step="0.01" name="deposit" required><br>
  <label>Active:</label><input type="checkbox" name="active" value="1" checked><br>
  <input type="submit" name="submit" value="บันทึก">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>