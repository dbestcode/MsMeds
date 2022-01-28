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
session_start();
if(isset($_GET["drugid"])) {
	echo "Finding Drug...   " . $_GET["drugid"] . "<BR>";
	$file_name = "txt/" . $_SESSION["PatientID"];

	if ($_GET["drugid"] == "killthispatient"){
		$file = fopen($file_name, "w");
		fputcsv($file, "");
		fclose($file);
		$file_name = $file_name . ".nur";
		$file = fopen($file_name, "w");
		fputcsv($file, "");
		fclose($file);
		echo "Killing File....";
	} else {
		if (($handle = fopen("./csv/drugs.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if ($data[1] == $_GET["drugid"]){
					echo "Found!";
					$druggiven = $data[0];
				}
			}
			fclose($handle);
		}
		if (isset($druggiven)){
			echo "<br>" . $druggiven;
			$file_name = "txt/" . $_SESSION["PatientID"];
			$file = fopen($file_name, "a");
			fputcsv($file, array(date("d-m-Y h:i A"),$druggiven,$_SESSION["NurseID"],gethostbyaddr($_SERVER['REMOTE_ADDR'])));
			fclose($file);
		} else {
			header("Location: AddDrug.php?drugid=" . $_GET["drugid"]);
		}
	}
}
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
