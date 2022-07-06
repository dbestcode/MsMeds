<?php
$servername = "localhost";
$username = "simlab";
$password = "Icould$1mallday!";
$dbname = "sudo_meds";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
?>
