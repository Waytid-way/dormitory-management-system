<?php
$servername = "fdb1033.awardspace.net";
$username = "4692447_dormdb";
$password = "TEjZ6tsy5{GVShm+";
$database = "4692447_dormdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>