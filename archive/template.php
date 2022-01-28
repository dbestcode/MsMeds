<?php 
session_start();
if(isset($_GET['submit'])) 
{
	$file = fopen("./csv/patients.csv", "a");
	echo $_POST["bcode"] . "," . $_POST["fname"] . "," . $_POST["lname"] . "," . $_POST["dob"];
	fputcsv($file, array($_POST["bcode"],$_POST["bcode"],$_POST["bcode"],$_POST["bcode"]));
	
	fclose($file);
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
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

			<input type="checkbox" name="vehicle1" value="Bike">I have a bike
			<br>
			<input type="checkbox" name="vehicle2" value="Car">I have a car 
			<br><br>
			<input type="submit">
		</form> 

		</div>
		<div id="footer">
		<?php include 'footer.php';?>
		</div>
	</div>
	</div>
</div>
</body>

</html>
