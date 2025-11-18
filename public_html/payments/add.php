<?php 
include('../config/db_connect.php'); 
if(isset($_POST['submit'])){
    $stmt = $conn->prepare("INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $_POST['billing_id'], $_POST['amount'], $_POST['payment_date'], $_POST['method']);
    
    if($stmt->execute()){ 
        // Update billing status to 'paid'
        $conn->query("UPDATE billings SET status = 'paid' WHERE billing_id = {$_POST['billing_id']}");
        header("Location: index.php"); exit(); 
    }
    $stmt->close();
}
// Get unpaid bills
$bills = $conn->query("SELECT b.billing_id, b.total_amount, t.full_name, r.room_number
                        FROM billings b
                        JOIN leases l ON b.lease_id = l.lease_id
                        JOIN tenants t ON l.tenant_id = t.tenant_id
                        JOIN rooms r ON l.room_id = r.room_id
                        WHERE b.status = 'unpaid' OR b.status = 'overdue'");
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>บันทึกการชำระเงิน</title></head><body>
<h2>บันทึกการชำระเงิน</h2>
<form method="post">
  <label>บิลที่ค้าง (ผู้เช่า/ห้อง/ยอด):</label>
  <select name="billing_id" required>
    <option value="">-- เลือกบิล --</option>
    <?php while($b = $bills->fetch_assoc()) echo "<option value='{$b['billing_id']}'>ID: {$b['billing_id']} (".htmlspecialchars($b['full_name'])."/".htmlspecialchars($b['room_number'])."/ {$b['total_amount']} ฿)</option>"; ?>
  </select><br>
  <label>จำนวนเงิน:</label><input type="number" step="0.01" name="amount" required><br>
  <label>วันที่ชำระ:</label><input type="date" name="payment_date" value="<?= date('Y-m-d'); ?>" required><br>
  <label>วิธีชำระเงิน:</label>
  <select name="method">
    <option value="cash">เงินสด</option>
    <option value="transfer">โอน</option>
    <option value="card">บัตร</option>
  </select><br>
  <input type="submit" name="submit" value="บันทึก">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>