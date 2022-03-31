<?php
require("php/cherry.php");

if(isset($_POST['edititem'])) {
        echo "edit: " . $_POST['edititem'];
	$_SESSION['edititem']=$_POST['edititem'];
	header("Location: edit.php");
}

if(isset($_POST['deleteitem'])) {
        echo "delete: " . $_POST['deleteitem'];
	$_SESSION['deleteitem']=$_POST['deleteitem'];
	header("Location: delete.php");
}

require_once('php/draw.php');
require_once( "php/head.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php print_head("admin");?>
</head>
<body>

<?php
require("php/title.php");
require('conn.php');
//sort based on the table selected
if ($_SESSION["activetable"]=='patients') {
	$sql = "SELECT * FROM `patients` ORDER BY `patients`.`LastName` ASC";
}else if ($_SESSION["activetable"]=='users') {
$sql = "SELECT * FROM `users`  \n" . "ORDER BY `users`.`LastName` ASC, `users`.`FirstName` ASC";
}else if ($_SESSION["activetable"]=='drugs') {
	$sql = "SELECT * FROM `drugs` ORDER BY `drugs`.`DrugName` ASC";
} else if ($_SESSION["activetable"]=='patient_files') {
$sql = "SELECT * FROM `patient_files` ORDER BY `patient_files`.`FileName` ASC, `patient_files`.`Label`  DESC";
} else {
	$sql = "SELECT * FROM ". $_SESSION["activetable"];
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<TABLE class='drug_table'>";
	//load data into 'table[][]'
	$i=0;
	while($row = $result->fetch_assoc()) {
		$table[$i]=$row;
		$i++;
	}
	//count of rows
	echo "<br><h1>TOTAL '" .  $_SESSION["activetable"] . "': " . count($table) . "<h1>";
	//List keys and print as table headers
	foreach($table[0] as $x =>$x_value){
		echo "<th>" . $x . "</th>";
		if (!isset($PrimaryKey)){
			$PrimaryKey=$x;
		}
	}
	echo "<th>EDIT</th>";
	echo "<th>DELETE</th>";
	echo "<form method='post'>";
	for($r=0;$r<count($table);$r++){
		echo "<tr>";
		foreach($table[$r] as $x =>$x_value){
			echo tablecell($x_value);
		}
		echo tablecell("<button type='submit' name='edititem' value='" . $table[$r][$PrimaryKey] . "' >edit</button>");
		echo tablecell("<button type='submit' name='deleteitem' value='" . $table[$r][$PrimaryKey] . "' >delete</button>");
		//echo tablecell("<a href=edit.php?table=" . $_SESSION["activetable"] ."&id=" . $table[$r][$PrimaryKey] . ">Edit</a>");
		//echo tablecell("<a href=delete.php?table=" . $_SESSION["activetable"] ."&id=" . $table[$r][$PrimaryKey] . ">Delete</a>");
		echo "</tr>";
	}
	echo "</form></TABLE>";
} else {
	echo "0 results";
}
$conn->close();
include "php/footer.php";
?>
</body></html>
