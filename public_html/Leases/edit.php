<?php
include('../config/db_connect.php');
$tenant_id = 0; $room_id = 0; $start_date = ''; $end_date = ''; $deposit = ''; $active = 0; $id = 0; $current_room_id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM leases WHERE lease_id = ?");
    $stmt->bind_param("i", $id); $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $tenant_id = $row['tenant_id']; $room_id = $row['room_id']; $start_date = $row['start_date'];
        $end_date = $row['end_date']; $deposit = $row['deposit_amount']; $active = $row['active'];
        $current_room_id = $row['room_id'];
    }
    $stmt->close();
}
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE leases SET tenant_id = ?, room_id = ?, start_date = ?, end_date = ?, deposit_amount = ?, active = ? WHERE lease_id = ?");
    $stmt->bind_param("iissdii", $tenant_id, $room_id, $start_date, $end_date, $deposit, $active, $id);
    $tenant_id = $_POST['tenant_id']; $room_id = $_POST['room_id']; $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date']; $deposit = $_POST['deposit']; $active = isset($_POST['active']) ? 1 : 0;
    
    if($stmt->execute()){ 
        // If room changed, update old and new room status
        if($current_room_id != $room_id) {
            $conn->query("UPDATE rooms SET status = 'available' WHERE room_id = $current_room_id");
            $conn->query("UPDATE rooms SET status = 'occupied' WHERE room_id = $room_id");
        }
        header("Location: index.php"); exit(); 
    }
    $stmt->close();
}
$tenants = $conn->query("SELECT tenant_id, full_name FROM tenants ORDER BY full_name");
// Allow selecting the current room OR available rooms
$rooms = $conn->query("SELECT room_id, room_number FROM rooms WHERE status = 'available' OR room_id = $current_room_id ORDER BY room_number");
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>แก้ไขสัญญาเช่า</title></head><body>
<h2>แก้ไขสัญญาเช่า</h2>
<form method="post">
  <input type="hidden" name="id" value="<?= $id; ?>">
  <label>ผู้เช่า:</label>
  <select name="tenant_id" required>
    <?php while($t = $tenants->fetch_assoc()) echo "<option value='{$t['tenant_id']}' ".($t['tenant_id']==$tenant_id?'selected':'').">".htmlspecialchars($t['full_name'])."</option>"; ?>
  </select><br>
  <label>ห้อง:</label>
  <select name="room_id" required>
    <?php while($r = $rooms->fetch_assoc()) echo "<option value='{$r['room_id']}' ".($r['room_id']==$room_id?'selected':'').">".htmlspecialchars($r['room_number'])."</option>"; ?>
  </select><br>
  <label>วันเริ่ม:</label><input type="date" name="start_date" value="<?= $start_date; ?>" required><br>
  <label>วันสิ้นสุด:</label><input type="date" name="end_date" value="<?= $end_date; ?>"><br>
  <label>เงินมัดจำ:</label><input type="number" step="0.01" name="deposit" value="<?= htmlspecialchars($deposit); ?>" required><br>
  <label>Active:</label><input type="checkbox" name="active" value="1" <?= ($active ? 'checked' : ''); ?>><br>
  <input type="submit" name="submit" value="อัปเดต">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>