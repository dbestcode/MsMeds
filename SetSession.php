<?php
/* File: SetSesson.php
 * Auth: nb
 * date: 11/22
 * desc: Set session variable based on what is sent from index.php via post
 * 		the vairble wil change depending on what was entered on index
 * 		e.x. user enters: 
 * 		their ID --> varible'barcode'
 * 		a Pin    --> varible: 'apin'
 * 		Patient Id-->varible: 'PatientBarcode'
 * 		Handles; user id's, user pins, and patient ids
 * 
 */
?>
<meta http-equiv="refresh" content="2;url=index.php">
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
	  echo "fdsjdfsjkldsf0 results";
	  header("Location: adduser.php?barcode=" . $_POST["barcode"]);
	  exit;
	}
	$conn->close();
}
//check for patient ID
if(isset($_POST["PatientBarcode"])) {
	echo "Looking for patient...";
	include "conn.php";
	$unsafe_variable = $_POST["PatientBarcode"];
	$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
	//open record with barcode scanned
	$sql = "SELECT * FROM `patients` WHERE Barcode='$safe_variable'";
	$result = $conn->query($sql);
	//A patient has been found
	if ($result->num_rows > 0) {
		echo "Found...</br>";
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
		
		// check for immortal patient where students cannot remove their info once entered
		$sql = "SELECT `Immortal` FROM `patients` WHERE `id`=" . $_SESSION["PatientID"];
		$immortal = $conn->query($sql);
		while($row = $immortal->fetch_assoc()) {
			if($row['Immortal']=='1'){
				if ($_SESSION["AccessLevel"] == 7){
					header("Location: oper.php");
				} else{
					header("Location: patient.php");
				}
			}
		}
		
		// checking for current records(meds or notes), if found redirect to 'opencase.php' for option to delete
		$sql = "SELECT * FROM `drug_admins` WHERE PatientID=" . $_SESSION["PatientID"];
		$resultone = $conn->query($sql);
		$sql = "SELECT * FROM `nurse_notes` WHERE PatientID=" . $_SESSION["PatientID"];
		$resulttwo = $conn->query($sql);
		if (($resultone->num_rows > 0)||($resulttwo->num_rows > 0)) {
			header("Location: opencase.php");
	 	}
	 	
		if ($_SESSION["AccessLevel"] == 7){
			header("Location: oper.php");
		} else {
		  header("Location: patient.php");
		}
	} else {
		echo "Not found!";
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
		exit;
	}
	
	if ($_SESSION["AccessLevel"] == 3){
		header("Location: admin.php");
	} else {
		header("Location: index.php");
	}

}
echo "<br>Redirecting... <a href='index.php'>Click after 5 seconds <a>";
?>
<?php include 'php/footer.php';?>
</body></html>
