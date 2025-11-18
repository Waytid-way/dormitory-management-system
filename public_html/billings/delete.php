<?php
include('../config/db_connect.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Note: In a real app, check for related payments first
    $stmt = $conn->prepare("DELETE FROM billings WHERE billing_id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    else { echo "Error: " . $stmt->error; }
    $stmt->close();
} else { header("Location: index.php"); exit(); }
?>