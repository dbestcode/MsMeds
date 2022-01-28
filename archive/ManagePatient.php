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
		<?PHP 
		//$_SESSION["PatientID"] add back in
		$target_file = "txt/Paul-Horn.files";
		if (file_exists($target_file)) { 	
			if (($handle = fopen($target_file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					echo $data[0];
					if ($data[1] == "1") {
						echo "<input type='radio' name=" . $data[0] . " value='1' checked> visible";
						echo "<input type='radio' name=" . $data[0] . " value='0'> hidden<br>";
					} else {
						echo "<input type='radio' name=" . $data[0] . " value='1'> visible";
						echo "<input type='radio' name=" . $data[0] . " value='0' checked> hidden<br>";
					}
				}
				fclose($handle);
			}
		}
		?>
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
