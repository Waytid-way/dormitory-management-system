<?php
include('../config/db_connect.php');
$message = '';
$name = ''; $phone = ''; $email = ''; $id_number = ''; $id = 0;

// Check if ID is present
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tenants WHERE tenant_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $name = $row['full_name'];
        $phone = $row['phone'];
        $email = $row['email'];
        $id_number = $row['id_number'];
    } else {
        $message = "ไม่พบผู้เช่า!";
    }
    $stmt->close();
}

// Handle form submission
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE tenants SET full_name = ?, phone = ?, email = ?, id_number = ? WHERE tenant_id = ?");
    $stmt->bind_param("ssssi", $name, $phone, $email, $id_number, $id);

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $id_number = $_POST['id_number'];

    if($stmt->execute()){
        header("Location: index.php");
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>แก้ไขผู้เช่า</title></head><body>
<h2>แก้ไขข้อมูลผู้เช่า</h2>
<?php if(!empty($message)) echo "<p>$message</p>"; ?>
<form method="post">
  <input type="hidden" name="id" value="<?= $id; ?>">
  <label>ชื่อ-สกุล:</label><input type="text" name="name" value="<?= htmlspecialchars($name); ?>" required><br>
  <label>เบอร์โทร:</label><input type="text" name="phone" value="<?= htmlspecialchars($phone); ?>"><br>
  <label>อีเมล:</label><input type="email" name="email" value="<?= htmlspecialchars($email); ?>"><br>
  <label>เลขบัตร:</label><input type="text" name="id_number" value="<?= htmlspecialchars($id_number); ?>"><br>
  <input type="submit" name="submit" value="อัปเดต">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>