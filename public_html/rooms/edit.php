<?php
include('../config/db_connect.php');
$room_number = ''; $floor = ''; $room_type = ''; $price = ''; $status = ''; $id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $id); $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $room_number = $row['room_number']; $floor = $row['floor'];
        $room_type = $row['room_type']; $price = $row['price_per_month']; $status = $row['status'];
    }
    $stmt->close();
}
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE rooms SET room_number = ?, floor = ?, room_type = ?, price_per_month = ?, status = ? WHERE room_id = ?");
    $stmt->bind_param("sisdsi", $room_number, $floor, $room_type, $price, $status, $id);
    $room_number = $_POST['room_number']; $floor = $_POST['floor'];
    $room_type = $_POST['room_type']; $price = $_POST['price']; $status = $_POST['status'];
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    $stmt->close();
}
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>แก้ไขห้องพัก</title></head><body>
<h2>แก้ไขห้องพัก</h2>
<form method="post">
  <input type="hidden" name="id" value="<?= $id; ?>">
  <label>เลขห้อง:</label><input type="text" name="room_number" value="<?= htmlspecialchars($room_number); ?>" required><br>
  <label>ชั้น:</label><input type="number" name="floor" value="<?= htmlspecialchars($floor); ?>" required><br>
  <label>ประเภท:</label><input type="text" name="room_type" value="<?= htmlspecialchars($room_type); ?>"><br>
  <label>ราคา/เดือน:</label><input type="number" step="0.01" name="price" value="<?= htmlspecialchars($price); ?>" required><br>
  <label>สถานะ:</label>
  <select name="status">
    <option value="available" <?= ($status=='available')?'selected':''; ?>>ว่าง</option>
    <option value="occupied" <?= ($status=='occupied')?'selected':''; ?>>ไม่ว่าง</option>
    <option value="maintenance" <?= ($status=='maintenance')?'selected':''; ?>>ซ่อมบำรุง</option>
  </select><br>
  <input type="submit" name="submit" value="อัปเดต">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>