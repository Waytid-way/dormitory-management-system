<?php 
include('../config/db_connect.php'); 
if(isset($_POST['submit'])){
    $stmt = $conn->prepare("INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisds", $room_number, $floor, $room_type, $price, $status);
    $room_number = $_POST['room_number'];
    $floor = $_POST['floor'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    $stmt->close();
}
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>เพิ่มห้องพัก</title></head><body>
<h2>เพิ่มห้องพักใหม่</h2>
<form method="post">
  <label>เลขห้อง:</label><input type="text" name="room_number" required><br>
  <label>ชั้น:</label><input type="number" name="floor" required><br>
  <label>ประเภท:</label><input type="text" name="room_type" value="Standard"><br>
  <label>ราคา/เดือน:</label><input type="number" step="0.01" name="price" required><br>
  <label>สถานะ:</label>
  <select name="status">
    <option value="available">ว่าง</option>
    <option value="occupied">ไม่ว่าง</option>
    <option value="maintenance">ซ่อมบำรุง</option>
  </select><br>
  <input type="submit" name="submit" value="บันทึก">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>