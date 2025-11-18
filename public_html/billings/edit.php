<?php
include('../config/db_connect.php');
$lease_id = 0; $billing_date = ''; $due_date = ''; $rent = 0; $water = 0; $electric = 0; $status = ''; $id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM billings WHERE billing_id = ?");
    $stmt->bind_param("i", $id); $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $lease_id = $row['lease_id']; $billing_date = $row['billing_date']; $due_date = $row['due_date'];
        $rent = $row['rent_amount']; $water = $row['water_bill']; $electric = $row['electric_bill']; $status = $row['status'];
    }
    $stmt->close();
}
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE billings SET lease_id = ?, billing_date = ?, due_date = ?, rent_amount = ?, water_bill = ?, electric_bill = ?, total_amount = ?, status = ? WHERE billing_id = ?");
    $total = $_POST['rent'] + $_POST['water'] + $_POST['electric'];
    $stmt->bind_param("issddddsi", $_POST['lease_id'], $_POST['billing_date'], $_POST['due_date'], $_POST['rent'], $_POST['water'], $_POST['electric'], $total, $_POST['status'], $id);
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    $stmt->close();
}
$leases = $conn->query("SELECT l.lease_id, t.full_name, r.room_number FROM leases l JOIN tenants t ON l.tenant_id = t.tenant_id JOIN rooms r ON l.room_id = r.room_id WHERE l.active = 1 OR l.lease_id = $lease_id");
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>แก้ไขใบแจ้งหนี้</title></head><body>
<h2>แก้ไขใบแจ้งหนี้</h2>
<form method="post">
  <input type="hidden" name="id" value="<?= $id; ?>">
  <label>สัญญา:</label>
  <select name="lease_id" required>
    <?php while($l = $leases->fetch_assoc()) echo "<option value='{$l['lease_id']}' ".($l['lease_id']==$lease_id?'selected':'').">".htmlspecialchars($l['full_name'])." / ".htmlspecialchars($l['room_number'])."</option>"; ?>
  </select><br>
  <label>วันที่ออกบิล:</label><input type="date" name="billing_date" value="<?= $billing_date; ?>" required><br>
  <label>วันครบกำหนด:</label><input type="date" name="due_date" value="<?= $due_date; ?>" required><br>
  <label>ค่าเช่า:</label><input type="number" step="0.01" name="rent" value="<?= htmlspecialchars($rent); ?>" required><br>
  <label>ค่าน้ำ:</label><input type="number" step="0.01" name="water" value="<?= htmlspecialchars($water); ?>" required><br>
  <label>ค่าไฟ:</label><input type="number" step="0.01" name="electric" value="<?= htmlspecialchars($electric); ?>" required><br>
  <label>สถานะ:</label>
  <select name="status">
    <option value="unpaid" <?= ($status=='unpaid')?'selected':''; ?>>ยังไม่จ่าย</option>
    <option value="paid" <?= ($status=='paid')?'selected':''; ?>>จ่ายแล้ว</option>
    <option value="overdue" <?= ($status=='overdue')?'selected':''; ?>>เกินกำหนด</option>
  </select><br>
  <input type="submit" name="submit" value="อัปเดต">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>