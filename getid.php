<?php
//require('./php/cherry.php');
// get the q parameter from URL
$q = $_REQUEST["q"];

include "conn.php";
$unsafe_variable = $_POST["barcode"];
$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
//open record with barcode scanned
$sql = "SELECT `id`,`FirstName`,`LastName` FROM `patients` ORDER BY `LastName` ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	$i=0;
	while($row = $result->fetch_assoc()) {
		$patients[$i] = $row;
		$i++;
//		echo $row["id"] .":". $row["LastName"] ."-". $row["FirstName"]. "<br>";
	}
} else {
	echo "0 results";
	exit;
}
$conn->close();



$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
//$q = strtolower($q);
  $len=strlen($q);
  foreach($patients as $name) {
    if (stristr($q, substr($name["LastName"] . "-" . $name["FirstName"], 0, $len))) {
      if ($hint === "") {
        $hint = $name["id"];
        break;
      }
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?> 
