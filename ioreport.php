<!DOCTYPE html>
<html>
<head>

<?php
session_start();
require_once('php/draw.php');
require_once( "php/head.php");
print_head("admin");
//--------------------------------------------------------------------------------------begin edit submit
if(isset($_POST['submit'])){
	$sql="UPDATE ";
	$i=0;
 	foreach($_POST as $x =>$x_value){
                if($i==0){
			$sql=$sql . $x_value . " SET ";
		} elseif($i==1){
			$id=$x_value;
		} elseif($i==2){
                	$sql = $sql . "or_report." . $x . " = '" . $x_value ."' ";
		} elseif ($i==count($_POST)-1){
               	echo "";
		} else {
                	$sql = $sql . ", " .  "or_report." . $x . " = '" . $x_value ."' ";
	                echo "\n";
		}
		$i++;
        }
	$sql=$sql . "WHERE id=" . $id;
	echo $sql;
	//include ('conn.php');
	//$result = $conn->query($sql);
	//$conn->close();
	//unset($_SESSION["edititem"]);
//	header("Location: displaytable.php");
	exit;
}
//-----------------------------------------------------end submit edit page
if(isset($_POST["edititem"])){
    	echo  "  <link rel='stylesheet' type='text/css' href='css/grid.css'/>\n";
	echo "</head>\n<body>";
	require('./php/title.php');

	require "conn.php";
	$sql = "SELECT * FROM or_report WHERE id=" . $_POST["edititem"];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		//load data into 'table[][]'
		$i=0;
		while($row = $result->fetch_assoc()) {
			$table[$i]=$row;
			$i++;
		}
			//List keys and print as table headers
		echo "<div class='grid-container'>\n<div>\n";
		echo "<form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . ">";
		echo "<input type='hidden' name=table value='or_report'><br>\n";
		$i=0;
		foreach($table[0] as $x =>$x_value){
			switch ($i) {
			  case 0:
			    echo  html_heading("PATIENT",3);
//			    echo "DO NOT CHANGE 'id'<br />";
			    break;
			  case 10:
			    echo  "</div><div>" . html_heading("TIMES",3);
			    break;
			  case 19:
			    echo "</div><div>" . html_heading("SITE",3);
			    break;
			  case 25:
			    echo  "</div><div>" . html_heading("CATH",3);
			    break;
			  case 34:
			    echo "</div><div>" . html_heading("COUNTS",3);
			    break;
			  case 48:
			    echo "</div><div>" . html_heading("PROCEDURE",3);
			    break;
			  case 60:
			    echo "</div><div>" . html_heading("DEVICES",3);
			    break;
			  case 69:
			    echo "</div><div>" . html_heading("WARMING",3);
			    break;
			  case 75:
			    echo html_heading("CAUTERY",3);
			    break;
			  case 83:
			    echo "</div><div>" . html_heading("TOURNIQUET",3);
			    break;
			  default:
			}
			if ($x == "id"){
				echo "<input type='hidden' name='" . $x . "' value='" . $x_value . "'>\n";
			} else {
				echo $x . ":<input type='text' name='" . $x . "' value='" . $x_value . "'><br>\n";
			}
/*				if ($i > 1) {
				if ($x_value == ""){
					echo $x . ": <STRONG>---</STRONG><br />";
				} else {
					echo $x . ": " . "<STRONG>". $x_value . "</STRONG><br />";
				}
			}*/
			$i++;
		}
	} else {
		echo "0 results";
	}
	echo "</div></div><input type='submit' name='submit' value='Submit Form'></form><br>";
		//+++


	$conn->close();
	require "php/footer.php";
	echo "</body></html>";
	exit();
}
//--------------------------------------------------------------------------------------end edit
if(isset($_POST['aedititem'])) {
        //echo "edit: " . $_POST['edititem'];
	//$_SESSION['edititem']=$_POST['edititem'];
    	echo  "  <link rel='stylesheet' type='text/css' href='css/grid.css'/>\n";
	echo "</head>\n<body>";
	require('./php/title.php');
	require('conn.php');

	$sql = "SELECT * FROM or_report WHERE id=" . $_POST['edititem'];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		echo "<h1>Report: " . $row["Log_Date"] . ", " . $row["Patient_Last_Name"] . " " . substr($row["Patient_First_Name"],0,1) .".</h1>";
		echo "<a href='ioreport.php' style='" .
		  "background-color: #20285b;" .
		  "display:inline-block;" .
		  "color: white;" .
		  "padding: 16px 16px;" .
		  "text-decoration: none;" .
		  "text-align:center;" .
		  "width: 150px;'>back</a>";
		echo "<div class='grid-container'><div>";
		$i=0;
			foreach($row as $x =>$x_value){
				switch ($i) {
				  case 1:
				    echo  html_heading("PATIENT",3);
				    break;
				  case 10:
				    echo  "</div><div>" . html_heading("TIMES",3);
				    break;
				  case 19:
				    echo "</div><div>" . html_heading("SITE",3);
				    break;
				  case 25:
				    echo  "</div><div>" . html_heading("CATH",3);
				    break;
				  case 34:
				    echo "</div><div>" . html_heading("COUNTS",3);
				    break;
				  case 48:
				    echo "</div><div>" . html_heading("PROCEDURE",3);
				    break;
				  case 60:
				    echo "</div><div>" . html_heading("DEVICES",3);
				    break;
				  case 69:
				    echo "</div><div>" . html_heading("WARMING",3);
				    break;
				  case 75:
				    echo html_heading("CAUTERY",3);
				    break;
				  case 83:
				    echo "</div><div>" . html_heading("TOURNIQUET",3);
				    break;
				  default:
				}
				if ($i > 1) {
					if ($x_value == ""){
						echo $x . ": <STRONG>---</STRONG><br />";
					} else {
						echo $x . ": " . "<STRONG>". $x_value . "</STRONG><br />";
					}
				}
				$i++;
			}
		}
	} else {
		echo "0 results";
	}
	echo "</div></div>";
	$conn->close();
	include "php/footer.php";
	echo "</body></html>";
	exit;
}

//..............................................................................................................
//unused
if(isset($_POST['deleteitem'])) {
        echo "delete: " . $_POST['deleteitem'];
	$_SESSION['deleteitem']=$_POST['deleteitem'];
	header("Location: delete.php");
}
echo  "  <link rel='stylesheet' type='text/css' href='css/grid.css'/>\n";
echo "</head><body>";
require("php/title.php");
require('conn.php');

//sort based on the table selected
$sql = "SELECT * FROM or_report";
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
	echo "<br \><h1>Intraoperative Surgical Reports<h1>";
	//echo "<h1>TOTAL " .  $_SESSION['activetable'] . ": " . count($table) . "<h1>";
	//List keys and print as table headers going across the top row
	$feild=0;
	echo tablehead("Log Date");
	foreach($table[0] as $x =>$x_value){
		echo "<th>" . $x . "</th>";
		if (!isset($PrimaryKey)){
			$PrimaryKey=$x;
		}
		$feild++;
		if ( $feild > 5){
			break;
		}
	}
	echo "<th></th>";
	//echo "<th>DELETE</th>";
	echo "<form method='post'>";
	for($r=0;$r<count($table);$r++){
		echo "<tr>";
		$feild=0;
		echo tablecell($table[$r]["Log_Date"]);
		foreach($table[$r] as $x =>$x_value){
			echo tablecell($x_value);
			$feild++;
			if ( $feild > 5){
				break;
			}
		}
		echo tablecell("<button type='submit' name='edititem' value='" . $table[$r][$PrimaryKey] . "' >VIEW</button>");
	//	echo tablecell("<button type='submit' name='deleteitem' value='" . $table[$r][$PrimaryKey] . "' >delete</button>");
		echo "</tr>";
	}
	echo "</form></TABLE>";
} else {
	echo "0 results";
}
$conn->close();
include "php/footer.php";
?>
</body>
</html>
