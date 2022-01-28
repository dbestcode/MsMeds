<?php 
session_start();
if(!isset($_SESSION["UserID"])){
	header("Location: logout.php");
	exit;
}

if(isset($_POST['submit']))
{
	//$name = $_POST['id'];
	//echo "You have Updated: <b> $name </b><br>";
	$sql="INSERT INTO ";
	$i=0;
	$feilds="";
	$values="";
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
	/* echo "<br>" . $sql;
	echo "<br>";
	echo "Feilds:" . $feilds;
	echo "<br>";
	echo "Values" . $values;*/
	include ('conn.php');
	$result = $conn->query($sql);
	$conn->close();
	exit;
}


?>

<html>

<head>
	<title>SimMedDispense</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.22" />
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>
	<link rel="stylesheet" href="css/w3mobile.css">
	
</head>

<body>
<div id="ccontainer">
	<div id="ccontainer">
	<div id="header">
		<div id="ccontainer" style="float:left"><img src="img/logo.gif" height=90px style="float:left"></div>
	</div>
	</div>
	<div id="ccontainer" style="width:60%; margin:0 auto">
		<div id="lilheader">
		<h1 style="font-size:40px;text-align:center;font-family:helvetica, serif;">Simulation Medication Dispensing System</h1>	
		</div>

	<div id="container" >
		<div id="content">
<?php
require_once('draw.php');


include "cherry.php";
include ('conn.php');
$unsafe_variable = "1234";
$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
$sql = "SELECT * FROM ". $_GET["table"];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	//load data into 'table[][]'
	while($row = $result->fetch_assoc()) {
		$table=$row;
	}
		//List keys and print as table headers
	echo "<form method='post' action=". $_SERVER['PHP_SELF'] . ">";
	echo "<table>";
	echo "<tr>";
			// hide the table name, we dont want user input
	echo tablecell("<input type='hidden' name=table value=" .  $_GET["table"] . "><br>");
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
//maybe add code to send to an error page?
//  header("Location: AddStudent.php?barcode=" . $_POST["barcode"]);
}
$conn->close();
?>


		</div>
		<div id="footer">
		<?php include 'footer.php';?>
		</div>
	</div>
	</div>
</div>
</body>

</html>


