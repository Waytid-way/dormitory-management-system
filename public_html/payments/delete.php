<?php
include('../config/db_connect.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Optional: Revert billing status to 'unpaid'
    $payment = $conn->query("SELECT billing_id FROM payments WHERE payment_id = $id")->fetch_assoc();
    if($payment){
        $conn->query("UPDATE billings SET status = 'unpaid' WHERE billing_id = {$payment['billing_id']}");
    }
    
    $stmt = $conn->prepare("DELETE FROM payments WHERE payment_id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){ header("Location: index.php"); exit(); }
    else { echo "Error: " . $stmt->error; }
    $stmt->close();
} else { header("Location: index.php"); exit(); }
?>