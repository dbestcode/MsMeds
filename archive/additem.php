<?php 
/*
passing a table to this generates a form for adding 
rows to the table based on the data
currently in the table.  */


session_start();
//for pretty table code
require_once('./php/draw.php');
//vailidate admin status
require ("php/cherry.php");
require ("php/head.php");

//catch the submission of the new data
if(isset($_POST['submit']))
{
	$sql="INSERT INTO " . $_SESSION["activetable"];
	$i=0;
	$feilds="";
	$values="";
 	//loop thorught the array to produce a insert statement
	foreach($_POST as $x =>$x_value){
                if($i==0){
			$sql=$sql . $x_value;
		} elseif($i==1){
			$feilds = $feilds . "id, ";
			$values = $values . "NULL, ";
		} elseif ($i==count($_POST)-2){
                	$feilds = $feilds . $x;
			$values = $values . "'" . $x_value . "'";
		} elseif ($i==count($_POST)-1){
		} else {
			$feilds = $feilds . $x . ", ";
			$values = $values . "'" . $x_value . "', ";
		}
		$i++;
        }
	$sql= $sql . " (" . $feilds . ") VALUES (" . $values . ")";
	/*echo "<br>" . $sql;
	echo "<br>";
	echo "Feilds:" . $feilds;
	echo "<br>";
	echo "Values" . $values;*/
	include ('conn.php');
	$result = $conn->query($sql);
	if ($result == 1) {
		echo "Item Added!";
	}
	echo "<br />" . $result;
	$conn->close();
	exit;
}
?>

<html>
<head>
<?php print_head("admin"); ?>
</head>

<body>
<?php
require("php/title.php");
echo "<h1>ADD ITEM</H1>";
require ("conn.php");
$unsafe_variable = $_SESSION["activetable"];
$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
$sql = "SELECT * FROM ". $safe_variable;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	//load data into 'table[][]'
	while($row = $result->fetch_assoc()) {
		$table=$row;
	}
		//List keys and print as table headers
	echo "<form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . ">";
	echo "<table>";
	echo "<tr>";
			// hide the table name, we dont want user input
	echo tablecell("<input type='hidden' name=table value=" .  htmlspecialchars($_GET["table"]) . "><br>");
	echo tablecell("DO NOT CHANGE 'id'");
	echo "</tr>\n";
	$i=0;
	foreach($table as $x =>$x_value){
//Name: <input type="text" name="name"><br>
		echo "<tr>";
		echo tablecell($x);
		if($i==0){
			// hide the id, we dont want user input
			echo tablecell("<input type='hidden' name='" . $x . "'><br>");
		} else {
			echo tablecell("<input type='text' name='" . $x . "'><br>");
		}
		echo "</tr>\n";
		$i++;
	}
	echo "<tr>\n";
	echo tablecell("<a href='admin.php'>Cancel</a>");
	echo tablecell("<input type='submit' name='submit' value='Submit Form'><br>");
	echo "</tr></TABLE>";
} else {
  echo "0 results";
}
$conn->close();
require('php/footer.php');?>
</body></html>


