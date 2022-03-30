<?php
session_start();
include "cherry.php";
require('php/head.php');


if(isset($_POST['submit']))
{
	//itmm will be added to patient files, which are 'misc'
	if($_POST["doctype"]=="other"){
		include ('conn.php');
		$sql = "INSERT INTO patient_files (id,PatientID,Label,FileName) VALUES (NULL, '" . 
			$_POST["patientid"] . "', '" . $_POST["doclabel"] ."', '" .  
			basename($_FILES["fileToUpload"]["name"]) . "')";
		$result = $conn->query($sql);
		echo $result . "<br>";
		$conn->close();
	} else {
		switch($_POST["doctype"]){
		 case "mar":
			$feild="MarFile";
			break;
		 case "hp":
			$feild="HpFile";
			break;
		 case "orders":
			$feild="OrdersFile";
			break;
		 case "report":
			$feild="ReportFile";
			break;
		}
		include ('conn.php');
		$sql = "UPDATE patients SET ". $feild . " = '" . basename($_FILES["fileToUpload"]["name"]) .
			"' WHERE id = " . $_POST["patientid"];
		//foreach ($_POST as $key=>$val){
		//	echo $key." ".$val."<br/>";
		//}
		//echo $sql;exit();
		$result = $conn->query($sql);
		echo $result . "<br>";
		$conn->close();
	}
	$target_dir = "patient_files/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$fname = basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 1000000) {
	    echo "Sorry, your file is too large.<br> 1 MB Max size";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "pdf" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only PDF or image files are allowed.";
	    $uploadOk = 0;
	}
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
	echo "<a href='admin.php'>admin menu</a> or <a href='uploadfiles.php'>upload more?</a>";
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<?php print_head("default"); ?>

<script>
//returns the ID of the patient selected and chaneges the input box to reflect ID.
function showHint(str) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("patientid").value =
    this.responseText;
  }
  xhttp.open("GET", "getid.php?q="+str);
  xhttp.send();
}
</script>

</head>

<body>
<?php require ("php/title.php"); ?>
	<div id="container" >
		<div id="content">

		<h3>Upload Patient Document</h3>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
		Select file to upload:<br>
		<form method='post' action=/edit.php>
		<table class="nnote">
		<tr><td>File</td><td><input type="file" name="fileToUpload" id="fileToUpload"></td></tr>
		<tr><td>Patient</td><td>
<?php
//----------------------------------------------
include ('conn.php');
$sql = "SELECT * FROM patients ORDER by `patients`.`LastName`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  //$i=0;
  echo "<input list='patientn' name='patientna' onkeyup='showHint(this.value)'>";
  echo "<datalist id='patientn'>";
  while($row = $result->fetch_assoc()) {
	echo "<option value='" . $row["LastName"] . "-" . $row["FirstName"] . "'>\n";
	$namelist[$i]=$row;
	$i++;
  }
  echo "</datalist>";

} else {
  echo "0 results";
  exit;
}
$conn->close();
/*echo "<br>Patient ID List<span style='font-size:10px'>";
for($i = 0; $i < count($namelist); $i++) {
	echo "<br>" . $namelist[$i]['id'] . ": " . $namelist[$i]['FirstName']. " " . $namelist[$i]['LastName'];
}*/
echo "</span>";
//----------------------------------------------
?>
		<input type='hidden' readonly=true name='patientid' id='patientid' value=''>
		<br></td></tr>
		<tr><td>Type</td><td>
		<input type='radio' id="mar" name='doctype' value='mar' checked="checked">
		<label for="mar">MAR</label><br>
		<input type='radio' id="hp" name='doctype' value='hp'>
		<label for="hp">H & P</label><br>
		<input type='radio' id="orders" name='doctype' value='orders'>
		<label for="orders">Active Orders</label><br>
		<input type='radio' id="report" name='doctype' value='report'>
		<label for="report">Shift Report</label><br>
		<input type='radio' id="other" name='doctype' value='other'>
		<label for="other">Other:</label><input type="text" name="doclabel"><br>

		<br></td></tr>
		<tr><td><input type="submit" value="Upload File" name="submit"></td><td><a href='admin.php' style='
		  background-color: #20285b;
		  border: none;
		  color: white;
		  padding: 16px 32px;
		  text-decoration: none;
		  margin: 4px 2px;
		  cursor: pointer;
		  width: 150px;
		  
		'>Cancel</a></td></tr>
		<br>

		</TABLE>
			
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
