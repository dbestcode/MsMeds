
<?php 
session_start();
require('./php/patientaccess.php');
require_once('./php/head.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php print_head("default");?>
<meta http-equiv="refresh" content="3;url=patient.php">
</head>

<body>
<?php require './php/title.php';?>

<div id="container">
<?php 
//if(isset($_POST["drugid"])) {
	include "conn.php";
	echo "Finding Drug...   " . $_POST["drugid"] . "<BR>";
	$file_name = "txt/" . $_SESSION["PatientID"];
	$unsafe_variable = $_POST["drugid"];
	$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
	//open record with barcode scanned
	$sql = "SELECT * FROM `drugs` WHERE Barcode='$safe_variable'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		$medication=$row;
//		print_r($row);
	  }
	  $sql = "INSERT INTO drug_admins (DrugID, DrugName, PatientID, UserID, UserInitals, AdminTime)" .
		" VALUES ('" . $medication["id"] . "', '" . $medication["DrugName"] . "', '" . $_SESSION["PatientID"] . "', '" . $_SESSION["UserID"] . "', '" .
		 $_SESSION["uFirstName"] . "', '" . $_POST["admintime"] . "')";
	$result = $conn->query($sql);
	echo "Administered " . $medication["DrugName"] ;
	} else {
	  echo "0 results, not listed....";
	  //header("Location: adduser.php?barcode=" . $_POST["barcode"]);
	  exit;
	}
	$conn->close();
//}
?>
</div>
<?php include './php/footer.php';?>
</body>
</html>
