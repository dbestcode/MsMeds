<?php
session_start();
include "cherry.php";
require('php/head.php');


if(isset($_POST['submit'])) {
	//OPEN A CONNECTION AND ATTEMPT TO INSERT A NEW RECORD FOR VITALS
	include ('conn.php');
	$sql = "INSERT INTO `patient_vitals` (`id`, `PatientID`, `Glucose`) VALUES (NULL," . $_POST["patientid"] .", " . $_POST["glucose"] . ")";
	$result = $conn->query($sql);

	//IF RESULTS EMPTY A RECORD XXISSITS AND NEEDS UPDATEDED
	if($result){
		echo "<script>alert('Glucose added, " . $_POST["glucose"]  . "')</script>";
	} else {
	echo "<script>alert('Glucose changed to " . $_POST["glucose"]  . "')</script>";
		$sql = "UPDATE `patient_vitals` SET `Glucose` = " . $_POST["glucose"] ." WHERE `patient_vitals`.`PatientID` = " . $_POST["patientid"];
		$result = $conn->query($sql);
	}
	$conn->close();
//	echo "<a href='admin.php'>admin menu</a> or <a href='javascript:history.back()'>upload more?</a>";
//	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<?php print_head("default"); ?>

<script>
//returns the ID of the patient selected and chaneges the input box to reflect ID.
function showHint(str) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("patientid").value =
    this.responseText;
    const qrdata = "http://10.81.183.51/glucometer.php?q=" + this.responseText;
    document.getElementById("qrlink").innerHTML = "<a href=" + qrdata + ">Link</a>";
//    document.getElementById("qrform").innerHTML = "<form action='https://api.qr-code-generator.com/v1/create?access-token=652Fp3aBsdijHyXNfh0F2NoUHpjHZpT9PHmGk9KA8AdHwA_wQY2xqCmOtFR9c1bO' method='post'><input type='text' name='qr_code_text' value='" + qrdata + "'><input type='text' name='width' value='200'><input type='submit' value='view' name='submit'></form>";
  }
  xhttp.open("GET", "getid.php?q="+str);
  xhttp.send();
}
</script>

</head>

<body>
<?php require ("php/title.php"); ?>
	<div id="container" >
		<div id="content">

		<h3>Set Glucose</h3>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
		<table class="nnote">
		<tr><td>Patient</td><td>
<?php
//----------------------------------------------
include ('conn.php');
$sql = "SELECT * FROM patients ORDER by `patients`.`LastName`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  //$i=0;
  echo "<input list='patientn' name='patientna' onkeyup='showHint(this.value)'>";
  echo "<datalist id='patientn'>";
  while($row = $result->fetch_assoc()) {
	echo "<option value='" . $row["LastName"] . "-" . $row["FirstName"] . "'>\n";
	$namelist[$i]=$row;
	$i++;
  }
  echo "</datalist>";

} else {
  echo "0";
  exit;
}
$conn->close();
/*echo "<br>Patient ID List<span style='font-size:10px'>";
for($i = 0; $i < count($namelist); $i++) {
	echo "<br>" . $namelist[$i]['id'] . ": " . $namelist[$i]['FirstName']. " " . $namelist[$i]['LastName'];
}*/
echo "</span>";
//----------------------------------------------
?>
		<input type='hidden' readonly=true name='patientid' id='patientid' value=''><p id='qrlink'></p>
		<br></td></tr>
		<tr><td>Glucose</td><td>
		<input type="text" name="glucose" value="100
<?php 
/*include ('conn.php');
$sql = "SELECT `PatientID`,`Glucose` FROM `patient_vitals` WHERE PatientID=4";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	echo $row["Glucose"];
  }
} else {
  exit;
}
$conn->close();*/
?>
		"><br>

		<br></td></tr>
		<tr><td><input type="submit" value="Update" name="submit"></td><td><a href='admin.php' style='
		  background-color: #20285b;
		  border: none;
		  color: white;
		  padding: 16px 32px;
		  text-decoration: none;
		  margin: 4px 2px;
		  cursor: pointer;
		  width: 150px;
		'>Cancel</a></td></tr>
		<br>

		</TABLE>
		</form>
		</div>
		<p id='qrform'></p>
		<div id="footer">
		<?php include 'footer.php';?>
		</div>
	</div>
	</div>
</div>
</body>

</html>
