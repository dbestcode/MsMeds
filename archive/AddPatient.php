<?php include 'cherry.php';

if(isset($_GET['submit'])) 
{
	//add patient info to patients.csv
	$file = fopen("./csv/patients.csv", "a");
	fputcsv($file, array($_GET["lname"],$_GET["fname"],$_GET["bcode"],$_GET["dob"]));
	fclose($file);
    
	//upload Patient MAR pdf
    
    $target_dir = "pdf/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$fname = basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if file already exists
	/*if ($fname == "patients.csv"){    
		$uploadOk = 1;
	} elseif($fname == "drugs.csv") {
		$uploadOk = 1;
	} elseif ($fname == "students.csv") {
		$uploadOk = 1;
	} else {
		echo "That is not a vaild file name. <br>Only patients.csv, drugs.csv and students.csv";
	    $uploadOk = 0;
	}*/
	
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 1500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	//if($FileType != "pdf") {
	//    echo "Sorry, only .pdf files are allowed, no " . $FileType . " files.";
	//    $uploadOk = 0;
	//}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
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
		
		</td><div id="lilheader">
		<h1 style="font-size:40px;text-align:center;font-family:helvetica, serif;">Simulation Medication Dispensing System</h1>	
		</div>
			
	<div id="container" >
		<div id="content">
		 
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='GET'>
		<table>
		<tr><td>Patient Barcode: </td><td><input type='text' name='bcode'></td></tr>
		<tr><td>Patient First Name: </td><td><input type='text' name='fname'></td></tr>
		<tr><td>Patient Last Name: </td><td><input type='text' name='lname'></td></tr>
		<tr><td>Patient DOB: </td><td><input type='text' name='dob'></td></tr>
		<tr><td>Select an MAR</td><td><input type='file' name='fileToUpload' id='fileToUpload'></td></tr>
		<tr><td><a href='index.php' style='
  background-color: #20285b;
  border: none;
  color: white;
  padding: 16px 32px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
'>Cancel</a></td><td><input type='submit' name='submit' value='Add New Patient'></td></tr>
		</table>
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
