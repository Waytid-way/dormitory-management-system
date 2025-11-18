<?php
$servername = "fdb1033.awardspace.net";
$username = "4705506_dormdb";
$password = "wutwaytargo4";
$database = "4705506_dormdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>