<?php include 'cherry.php';?>

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
			 <button onclick="goBack()">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script> 
	<div id="container" >
		
		<div id="content">
		<table style="width:100%">
<!--<tr>
<td>Barcode</td>
<td>First Name</td>
<td>Lastname</td>
<td>Dob</td>
</tr>-->

<?php
$row = 1;


  


echo "<h2>" . $fname . "</h2>";

if (($handle = fopen("./csv/" . $_GET["csvfile"] . ".csv", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $bcode[$row] = $data[0];
	$fname[$row] = $data[1];
	$lname[$row] = $data[2];
	$dob[$row] = $data[3]; 
	$row++;
	}
	fclose($handle);

}
for ($i=0; $i <= count($bcode); $i++) {
	echo "<tr>";
	echo "<td>" . $bcode[$i] . "</td>";
	echo "<td>" . $fname[$i] . "</td>";
	echo "<td>" . $lname[$i] . "</td>";
	echo "<td>" . $dob[$i] . "</td>";
	echo "</tr>";
}
echo "</table>";
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
