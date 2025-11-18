<?php
include('../config/db_connect.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Note: In a real app, check for related leases before deleting.
    $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    else { echo "Error: " . $stmt->error; } // Foreign key constraint will likely trigger here if in use
    $stmt->close();
} else { header("Location: index.php"); exit(); }
?>