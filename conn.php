<?php
$servername = "localhost";

# setup login credientials and remove the notice below,
# sql user is what was setup at time for installation of sql.
echo '<script type="text/javascript">window.onload = function () { alert("MSMEDS SETUP INCOMPLETE, SQL LOGIN CREDENTIALS NOT SET!!! SET IN conn.php"); }</script>';
$username = ""; #Add me!
$password = ""; #Add me!
$dbname = "sudo_meds";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
?>
