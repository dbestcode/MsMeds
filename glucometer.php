<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=500px, initial-scale=.75, user-scalable=no">
<link rel='stylesheet' href='css/w3mobile.css'>
<link rel='stylesheet' type='text/css' href='css/layout.css'/>

<style>
#device-img {
  background-image: url('img/glu.jpg');
  background-repeat: no-repeat;
  height: 900px;
//  width: 100%;
}
#glu-val {
  position: absolute;
  top: 230px;
  left: 100px;
  width: 330px;
  height: 350px;
  //border: 3px solid #73AD21;
}
</style>
</head>
<body>

<div id='device-img'></div>
<div id='glu-val'>
<span class='code' style='font-size:120px'>
<?php
// get the q parameter from URL
include "conn.php";
$unsafe_variable =  $_REQUEST["q"];
$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
//open record with barcode scanned
//$sql = "SELECT `id`,`PatientID`,`Glucose` FROM `patient_vitals` WHERE `PatientID` =" . $safe_variable;
$sql = "SELECT\n"

    . "    `patient_vitals`.`Glucose`,\n"

    . "    `patient_vitals`.`PatientID`,\n"

    . "    patients.LastName,\n"

    . "    patients.FirstName\n"

    . "FROM\n"

    . "    `patient_vitals`\n"

    . "INNER JOIN patients ON patients.id = patient_vitals.PatientID WHERE `PatientID` =" . $safe_variable;

$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$patients[$i] = $row;
		$i++;
		echo $row["Glucose"];
		$patientname = substr($row["FirstName"],0,1) . ". ". $row["LastName"];
	}
} else {
	echo "0 results";
	exit;
}
$conn->close();
?></span>mg/dL<br/><br/><br/>
<?php echo date("m/d/y h:m");
echo "<br />" . $patientname; ?>
</div>
</body>
</html>

