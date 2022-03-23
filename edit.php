<?php
session_start();
require_once('./php/draw.php');

if(isset($_POST['submit']))
{
	$sql="UPDATE ";
	$i=0;
 	foreach($_POST as $x =>$x_value){
                if($i==0){
			$sql=$sql . $x_value . " SET ";
		} elseif($i==1){
			$id=$x_value;
		} elseif($i==2){
                	$sql = $sql . $x . " = '" . $x_value ."' ";
		} elseif ($i==count($_POST)-1){
                	echo "'REMOVED ";
		} else {
                	$sql = $sql . ", " . $x . " = '" . $x_value ."' ";
	                echo "</tr>\n";
		}
		$i++;

        }
	$sql=$sql . "WHERE id=" . $id;
	include ('conn.php');
	$result = $conn->query($sql);
	$conn->close();
	unset($_SESSION["edititem"]);
	header("Location: displaytable.php");
	exit;
}
include "php/cherry.php";
require "php/head.php";
?>
<!DOCTYPE html>
<html>
<head>
<?php print_head("admin");?>
</head>
<body>
<?php
require "php/title.php";

require "conn.php";
$sql = "SELECT * FROM ". $_SESSION["activetable"] . " WHERE id=" . $_SESSION["edititem"];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	//load data into 'table[][]'
	$i=0;
	while($row = $result->fetch_assoc()) {
		$table[$i]=$row;
		$i++;
	}
		//List keys and print as table headers
	echo "<form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . ">";
	echo "<table>";
	echo "<tr>";
	echo tablecell("<input type='hidden' name=table value=" .  $_SESSION["activetable"] . "><br>");
	echo tablecell("DO NOT CHANGE 'id'");
	echo "</tr>\n";
	foreach($table[0] as $x =>$x_value){
//switch based on column, if a file for patient is the column, use a dropdown box (input list)
		switch($x){
		case "MarFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
			echo "</tr>\n";
			break;
		case "HpFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
			echo "</tr>\n";
			break;
		case "OrdersFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
			echo "</tr>\n";
			break;
		case "ReportFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "' style='width:300px'><br>");
			echo "</tr>\n";
			break;
		default:
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input type='text' name='" . $x . "' value='" . $x_value . "'><br>");
			echo "</tr>\n";
		}

	}
	echo "</TABLE>";
	echo "<input type='submit' name='submit' value='Submit Form'></form><br>";
}
//if patients table, a datalist of files is needed for the dropdown boxes for specidfy the MAR, etc...
if ($_SESSION["activetable"]=="patients"){
	echo "\n<datalist id='uploads'>\n";
	//echo "<iframe width=100% height=600px src='/patient_files'></iframe>";
	$arrFiles = array();
	$handle = opendir('patient_files');

	if ($handle) {
	    while (($entry = readdir($handle)) !== FALSE) {
		echo "<option value='" . $entry . "'>\n";
	    }
	}
	echo "</datalist>\n";
	closedir($handle);
}

$conn->close();
require "php/footer.php";
?>
</body></html>
