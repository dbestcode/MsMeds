<?php
/*
 * @param $_GET['q'] (last name of a patient)
 * @return index of patient in 'patients' table
 */

require_once('common-items.php');

$q = $_REQUEST["q"];

$conn = ConnectDB();
// Select all patients
$sql = "SELECT `id`,`FirstName`,`LastName` FROM `patients` ORDER BY `LastName` ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	
	$i=0;
	while($row = $result->fetch_assoc()) {
		$patients[$i] = $row;
		$i++;
	}
} else {
	echo "Problem...Table Empty";
	exit;
}
$conn->close();

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
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
