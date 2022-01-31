<?php
session_start();


function printdrugs(){
	$target_file = "txt/" . $_SESSION["PatientID"];
	if (file_exists($target_file)) { 	
		$row = 1;
		if (($handle = fopen($target_file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$bcode[$row] = $data[0];
				$fname[$row] = $data[1];
				$lname[$row] = $data[2];
				$dob[$row] = $data[3]; 
				$row++;
			}
			fclose($handle);
		}
		for ($i=1; $i <= count($bcode); $i++) {
			echo "<tr>";
			echo "<td>" . $bcode[$i] . "</td>";
			echo "<td>" . $fname[$i] . "</td>";
			echo "<td>" . $lname[$i] . "</td>";
			echo "<td>" . $dob[$i] . "</td>";
			echo "</tr>";
		}
	}
}

function printnotes(){
	$filename = "txt/" . $_SESSION["PatientID"] . ".nur";
	if (file_exists($filename)) {
	$myfile = fopen($filename, "r") or die("Patient has no notes.");
	echo fread($myfile,filesize($filename));
	fclose($myfile);
	}
}

session_start();

error_reporting(E_ALL);

if(!isset($_SESSION["NurseID"])){
	header("Location: logout.php");
	exit;
}

if(!isset($_SESSION["PatientID"])){
	header("Location: logout.php");
	exit;
}

if(isset($_GET['nursenote'])) {
	//header("Location: http://www.google.com");
	$fname = "txt/" . $_SESSION["PatientID"] . ".nur";
	
	//$foutput = "<h4 id='nnote'>Nurse: " . $_SESSION['NurseID'] . "</h4><br>" . $_GET['ntime'] . "<P id='nnote'>" . $_GET['nnote'] . "<p>" .PHP_EOL;
	//$foutput = "<hr><h4 id='nnote'>" . $_GET['ntime'] . "</h4><br>" . PHP_EOL . "<table>" . PHP_EOL . "<tr><td>HR</td><td>" . $_GET['nhr'] . "</td></tr>" . PHP_EOL . "<tr><td>RR</td><td>" . $_GET['nrr'] . "</td></tr>" . PHP_EOL . "<tr><td>BP</td><td>" . $_GET['nbp'] . "</td></tr>" . PHP_EOL . "<tr><td>O2</td><td>" . $_GET['noo'] . "</td></tr>" . PHP_EOL . "</table><BR>" . PHP_EOL . $_GET['nnote'] . PHP_EOL . "<p id='nnote'>" . $_SESSION['NurseID'] . "<p>";
	$foutput = "<table id='nnote'>" . PHP_EOL;
	$foutput .= "<tr>" . PHP_EOL;
    $foutput .= "<th colspan='4'><span id='noteh'>Note Charted " . $_GET['ntime'] . " by " . $_SESSION['NurseID'] . "</span></th>" . PHP_EOL;
  $foutput .= "</tr>" . PHP_EOL;
  $foutput .= "<tr>" . PHP_EOL;
    $foutput .= "<td>HR</td>" . PHP_EOL;
    $foutput .= "<td>" . $_GET['nhr'] . "</td>" . PHP_EOL;
    $foutput .= "<td rowspan='4'><p id='notep'>" . PHP_EOL . $_GET['nnote'] . PHP_EOL;
$foutput .= "</p</td>" . PHP_EOL;
  $foutput .= "</tr>" . PHP_EOL;
  $foutput .= "<tr>" . PHP_EOL;
    $foutput .= "<td>RR</td>" . PHP_EOL;
    $foutput .= "<td>" . $_GET['nrr'] . "</td>" . PHP_EOL;
  $foutput .= "</tr>" . PHP_EOL;
  $foutput .= "<tr>" . PHP_EOL;
    $foutput .= "<td>BP</td>" . PHP_EOL;
    $foutput .= "<td>" . $_GET['nbp'] . "</td>" . PHP_EOL;
  $foutput .= "</tr>" . PHP_EOL;
  $foutput .= "<tr>" . PHP_EOL;
    $foutput .= "<td>O2</td>" . PHP_EOL;
    $foutput .= "<td>" . $_GET['noo'] . "</td>" . PHP_EOL;
  $foutput .= "</tr>" . PHP_EOL;
$foutput .= "</table>" . PHP_EOL;

	file_put_contents("txt/" . $_SESSION["PatientID"] . ".nur", $foutput, FILE_APPEND);
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
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">

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
	<div  id="container">
	
	<div id="container" >
		<?php echo "<H3>User: <strong>" . $_SESSION["NurseID"] . "</strong><br>Patient: <strong>" . $_SESSION["PatientID"] . "</strong></H3>";?>
		<br>
		<a href='logout.php' style='text-align:right;background-color:#fa661c;padding:5px'>Logout</a></div>
<div class="tab">
  
  <button class="tablinks" onclick="openTab(event, 'DHistory')">Labs & Radiology</button>
  <button class="tablinks" onclick="openTab(event, 'administer')" id="defaultOpen">Administer Medications</button>
  <button class="tablinks" onclick="openTab(event, 'emar')">Medication Orders</button>
  <button class="tablinks" onclick="openTab(event, 'nursenote')">Nursing Note</button>
</div>

<div id="emar" class="tabcontent">
  <div id="content">
	  <H2>eMar</H2>
		<iframe src="<?php echo "pdf/" . $_SESSION["PatientMAR"]; ?>" type="application/pdf" width="100%" height="600px" align="middle"></iframe>
		</div>
</div>

<div id="nursenote" class="tabcontent">
	
	<form method='GET' action="<?php echo $_SERVER["PHP_SELF"];?>">  
	Time & Date: <BR>
	<input type='text' name='ntime' value="<?php echo date("m-d-y") . " " . date("h:ia");?>"><BR>
	<h5>Vitals</h5>
	HR:<input type='text' name='nhr'>
	RR:<input type='text' name='nrr'><br>
	BP:<input type='text' name='nbp'>
	O2:<input type='text' name='noo'><br>
	 
	Nursing Note:<BR> <textarea name='nnote' rows='5' cols='50'></textarea>

	<br><br>
	<input type='submit' name='nursenote' value='Submit'>  
	</form>
	<?php 
	printnotes();
	?>
	
  </div>


</div>

<div id="administer" class="tabcontent">
  	<div id="content">
		<h2 style='text-align:center'>Scan a medication to dispense:
		
		<form name='input' action='ScanDrug.php' method='get' style="text-align:center;"><input type='text' name='drugid' autofocus><input type="submit"></form>
		</p>
	</div>
	<div id="content">
		<h2 style='text-align:center'>Medications Administered</h2>
		<table style="width:100%">
		<tr>
		<th>Time given</th>
		<th>Drug</th>
		<th>Nurse</th>
		<th>Station</th>
		</tr>
		<?php 
		printdrugs();
		?>
		</table>
		</div>
</div>

<script>
document.getElementById("defaultOpen").click();	
	
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
		
		
		
			
	</div>


		</div>
		<div id="footer">
		<?php include 'footer.php';?>
		</div>
	</div>
	</div>

</body>

</html>


