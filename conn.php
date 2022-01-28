<?php
//php login details, badly needs seccurity audit
//include "cherry.php";
$servername = "localhost";
$username = "simlab";
$password = '$imlab4ever';
$dbname = "sudo_meds";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
?>
