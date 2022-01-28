<?PHP 
session_start();
if(!isset($_SESSION["AuthPass"])){
	header("Location: logout.php");
}
?>
<html>

<head>
	<title>SimMedDispense</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.22" />
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>
	<link rel="stylesheet" href="css/w3mobile.css">
	<style>
	table{
		border-collapse: collapse;
	}

	table, th, td {
		border: 1px solid black;
	}
	</style>
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
			
			
		<form action="upload.php" method="post" enctype="multipart/form-data">
		Select file to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload Data File" name="submit">
		<a href='logout.php' style='
  background-color: #20285b;
  border: none;
  color: white;
  padding: 16px 32px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
'>Cancel</a>
		</form>
		<p>Select a csv file to upload.  Excel files can be edited and the exported as a 'comma delimited file'.  Be sure to use only file with following format:</p>
			<h3>patient.csv format:</h3>
			<table>
				<tr><td>Last Name</td><td>First Name</td><td>MRN</td><td>DOB(mm-dd-yyyy)</td></tr>
				<tr><td>Last Name</td><td>First Name</td><td>MRN</td><td>DOB(mm-dd-yyyy)</td></tr>
				<tr><td>Last Name</td><td>First Name</td><td>MRN</td><td>DOB(mm-dd-yyyy)</td></tr>
			</table>
			<h3>student.csv format:</h3>
			<table>
				<tr><td>Barcode #</td><td>First Name</td><td>Last Name</td><td>Date Enrolled(mm-dd-yyyy)</td></tr>
				<tr><td>Barcode #</td><td>First Name</td><td>Last Name</td><td>Date Enrolled(mm-dd-yyyy)</td></tr>
				<tr><td>Barcode #</td><td>First Name</td><td>Last Name</td><td>Date Enrolled(mm-dd-yyyy)</td></tr>
			</table>
			<h3>drugs.csv format:</h3>
			<table>
				<tr><td>Drug Name</td><td>Barcode #</td></tr>
				<tr><td>Drug Name</td><td>Barcode #</td></tr>
				<tr><td>Drug Name</td><td>Barcode #</td></tr>
				<tr><td>Drug Name</td><td>Barcode #</td></tr>
				</table>
			
		</div>
		<div id="footer">
		<?php include 'footer.php';?>
		</div>
	</div>
	</div>
</div>
</body>

</html>
