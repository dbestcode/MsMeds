<meta http-equiv="refresh" content="1;url=index.php">
<!DOCTYPE html>
<html>
<head>
<?php
session_start();
require_once('php/head.php');
print_head('default');
echo "</head><body>";
require ("php/title.php");
//check for userID
if(isset($_POST["barcode"])) {
	echo "Finding user ID...<br>";
	//injection proection
	include "conn.php";
	$unsafe_variable = $_POST["barcode"];
	$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
	//open record with barcode scanned
	$sql = "SELECT id,FirstName,LastName,Barcode,AccessLevel,Pin FROM `users` WHERE Barcode='$safe_variable'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		$_SESSION["UserID"] = $row["id"];
		$_SESSION["uFirstName"] = $row["FirstName"];
		$_SESSION["uLastName"] = $row["LastName"];
		$_SESSION["AccessLevel"] = $row["AccessLevel"];
		$_SESSION["uPin"] = $row["Pin"];
//---  needs chenged and PIN implemented in future
		//$_SESSION["AuthPass"]=54792390;

	  }
	} else {
	  echo "0 results";
	  header("Location: adduser.php?barcode=" . $_POST["barcode"]);
	  exit;
	}
	$conn->close();
}
//check for patient ID
if(isset($_POST["PatientBarcode"])) {
	include "conn.php";
	$unsafe_variable = $_POST["PatientBarcode"];
	$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
	//open record with barcode scanned
	$sql = "SELECT * FROM `patients` WHERE Barcode='$safe_variable'";
	$result = $conn->query($sql);
	//A patient has been found
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$_SESSION["PatientID"] = $row["id"];
			$_SESSION["pFirstName"] = $row["FirstName"];
			$_SESSION["pLastName"] = $row["LastName"];
			$_SESSION["pDOB"] = $row["DOB"];
			$_SESSION["pBarcode"] = $row["Barcode"];
			$_SESSION["Provider"] = $row["Provider"];
			$_SESSION["MarFile"] = $row["MarFile"];
			$_SESSION["HpFile"] = $row["HpFile"];
			$_SESSION["OrdersFile"] = $row["OrdersFile"];
			$_SESSION["ReportFile"] = $row["ReportFile"];
			$_SESSION["HpFile"] = $row["HpFile"];
		}
		// checking for currnet records
		$sql = "SELECT * FROM `drug_admins` WHERE PatientID=" . $_SESSION["PatientID"];
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo "THIS PATIENT HAS AN OPEN SESSION.  DO YOU WISH TO JOIN?";
			  header("Location: opencase.php");

	 	}
		  header("Location: patient.php");
	} else {
		echo "0 results";
	}
	$conn->close();
}
if(isset($_SESSION["uPin"]) && isset($_POST["apin"])) {
// pins are disabled as none are in DB
	if (hash('md5',$_POST["apin"]) == $_SESSION["uPin"]){
		echo "<h1>Access Granted.</h1>";
		//echo hash('md5',$_POST["apin"]);
		$_SESSION["AuthPass"]=54792390;
		unset($_SESSION["uPin"]);
	} elseif (empty($_SESSION["uPin"])) {
		echo "<h1>Account has no pin.<br>Access Granted.</h1>";
		//echo hash('md5',$_POST["apin"]);
		$_SESSION["AuthPass"]=54792390;
		unset($_SESSION["uPin"]);
	} else {
		echo "<H1>PIN INVALID</H1>";
	}
}
echo "<br>Redirecting... <a href='index.php'>Click after 5 seconds <a>";
?>
<?php include 'php/footer.php';?>
</body></html>
