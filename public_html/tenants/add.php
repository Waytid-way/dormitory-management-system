<?php 
include('../config/db_connect.php'); 
$message = '';

if(isset($_POST['submit'])){
    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO tenants (full_name, phone, email, id_number) VALUES (?, ?, ?, ?)");
    
    // 'ssss' means four string parameters
    $stmt->bind_param("ssss", $name, $phone, $email, $id_number);

    // Set parameters
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
<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>เพิ่มผู้เช่า</title></head><body>
<h2>เพิ่มผู้เช่าใหม่</h2>
<?php if(!empty($message)) echo "<p>$message</p>"; ?>
<form method="post">
  <label>ชื่อ-สกุล:</label><input type="text" name="name" required><br>
  <label>เบอร์โทร:</label><input type="text" name="phone"><br>
  <label>อีเมล:</label><input type="email" name="email"><br>
  <label>เลขบัตร:</label><input type="text" name="id_number"><br>
  <input type="submit" name="submit" value="บันทึก">
  <a href="index.php">ยกเลิก</a>
</form>
</body></html>