<?php
include('../config/db_connect.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Optional: Set room back to 'available'
    $lease = $conn->query("SELECT room_id FROM leases WHERE lease_id = $id")->fetch_assoc();
    if($lease){
        $conn->query("UPDATE rooms SET status = 'available' WHERE room_id = {$lease['room_id']}");
    }
    
    // Note: In a real app, check for related billings/payments first
    $stmt = $conn->prepare("DELETE FROM leases WHERE lease_id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    else { echo "Error: " . $stmt->error; }
    $stmt->close();
} else { header("Location: index.php"); exit(); }
?>