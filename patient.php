<?php
session_start();
function tablecell($celldata) {
	return "<td>".$celldata."</td>";
}
function tablerow($celldata) {
	return "<tr>".$celldata."</tr>";
}
function print_files(){
	include "conn.php";
 	//--load drug_admins from database into array 'medorders'
	$sql = "SELECT * FROM patient_files WHERE PatientID=" . $_SESSION["PatientID"];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<table class='drug_table'>";
		echo "<tr>";
		echo "<th>Patient Document</th>";
		echo "</tr>\n";
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo tablecell("<a href='patient_files/" . $row["FileName"] . "' target='_blank'>" . $row["Label"] . "</a>");
			echo "</tr>\n";
		}
		echo "</table>";

	}
	$conn->close();
}
function print_drug_admin(){
	// Create connection &	// Check connection
	include "conn.php";
 	//--load drug_admins from database into array 'medorders'
	$sql = "SELECT * FROM drug_admins WHERE drug_admins.PatientID=" . $_SESSION["PatientID"];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<table class='drug_table'>";
		echo "<tr>";
		echo "<th>Time given</th>";
		echo "<th>Drug</th>";
		echo "<th>Nurse</th>";
		echo "</tr>\n";
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo tablecell($row["AdminTime"]);
			echo tablecell($row["DrugName"]);
			echo tablecell($row["UserInitals"]);
			echo "</tr>\n";
		}
		echo "</table>";

	} else {
		echo "<table id='drug_table' style='width:80%'>";
		echo "<tr>";
		echo "<th>Time given</th>";
		echo "<th>Drug</th>";
		echo "<th>Nurse</th>";
		echo "</tr>\n<tr>";
		echo tablecell("---") . tablecell("No medications have been administered yet."). tablecell("---");
		echo "</tr>\n";
		echo "</table>";
	}
	$conn->close();

}

function select_notes(){
	// Create connection &	// Check connection
	include "conn.php";
 	//--load drug_admins from database into array 'medorders'
	$sql = "SELECT n.DateTime, n.HR, n.RR, n.Bp, n.Spo, n.Note, u.FirstName,u.LastName FROM nurse_notes as n INNER JOIN users as u ON u.id=n.UserID WHERE n.PatientID=" . 
	$_SESSION["PatientID"] . " ORDER BY n.DateTime DESC";

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<table class='nnote'>";
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<th colspan='4'>Note Charted " . $row["DateTime"] . " by " . $_SESSION['uFirstName'] . "</th>";
			echo "</tr>";
			echo tablerow(tablecell("HR:<br>" . $row["HR"]) .	tablecell("RR:<br>" . $row["RR"])) ;
			echo tablerow(tablecell("BP:<br>" . $row["Bp"]) .	tablecell("SpO<sub>2</sub><br>" . $row["Spo"])) ;
			echo tablerow("<td colspan='4'><p id='notep'><pre>" . $row["Note"] 
			. "</pre></td>");
		}
		echo "</table>";

	} else {
		echo "<table class='nnote'>";
		echo tablerow(tablecell("No notes made yet."));
		echo "</table>";
	}
	$conn->close();

}

function printnotes(){
	//called in the Nursing Notes tab to prpagate the notes
	$filename = "txt/" . $_SESSION["PatientID"] . ".nur";
	if (file_exists($filename)) {
		$myfile = fopen($filename, "r") or die("Patient has no notes.");
		echo fread($myfile,filesize($filename));
		fclose($myfile);
	}
}
function printdefaultnote($filename){
	//called in the Nursing Notes tab to prpagate the note
	if (file_exists($filename)) {
	$myfile = fopen($filename, "r") or die("Patient has no notes.");
	echo fread($myfile,filesize($filename));
	fclose($myfile);
	}
}

error_reporting(E_ALL);
//Logout and clear session if UserID or Patient ID not set proper
//require('php/patientaccess.php');
//if this is a reload add nursing note to file
if(isset($_POST['newnote'])) {
	//db connection object
	include "conn.php";
	//escape all user input for injections
	foreach ($_POST as $key=>$val){
		$sqlsafe=mysqli_real_escape_string($conn,$val);
		$safevar[$key]=htmlspecialchars($sqlsafe);
//		echo $safevar[$key];
	}
//	echo "<br>";
	$sql="INSERT INTO `nurse_notes` (`id`, `UserID`, `PatientID`, `DateTime`, `HR`, `RR`, `Bp`, `Spo`, `Note`) VALUES " .
	"(NULL, '" .
	$_SESSION["UserID"] . "', '" .
	$_SESSION["PatientID"] . "', " .
	"CURRENT_TIMESTAMP, '" .
	$safevar["HR"] . "', '" .
	$safevar["RR"] . "', '" .
	$safevar["Bp"] . "', '" .
	$safevar["Spo"] . "', '" .
	$safevar["Note"] . "')";
//	echo $sql;
//	exit;
	$result = $conn->query($sql);
        $conn->close();
}
if(isset($_POST["drugid"])) {
        include "conn.php";
//      echo "Finding Drug...   " . $_POST["drugid"] . "<BR>";
        $unsafe_variable = $_POST["drugid"];
        $safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
        //open record with barcode scanned
        $sql = "SELECT * FROM `drugs` WHERE Barcode='$safe_variable'";
        $result = $conn->query($sql);
	if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
                $medication=$row;
          }
          $sql = "INSERT INTO drug_admins (DrugID, DrugName, PatientID, UserID, UserInitals, AdminTime)" .
                " VALUES ('" . $medication["id"] . "', '" . $medication["DrugName"] . "', '" . $_SESSION["PatientID"] . "', '" . $_SESSION["UserID"] . "', '" .
                 $_SESSION["uFirstName"] . "', '" . $_POST["admintime"] . "')";
          $result = $conn->query($sql);
        } else {
	  $_POST['drugid']=0;
	}
        $conn->close();
}


require('php/head.php');
?>
<!DOCTYPE html?
<html>
<head>
<?php print_head("patient");?>
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
	 -webkit-animation: fadeEffect 1s;
	 animation: fadeEffect 1s;
	}
	th, td {
	  padding: 5px;
	}
	@-webkit-keyframes fadeEffect{
	 from {opacity: 0;}
	 to {opacity:1 ;}
	}
	@keyframes fadeEffect{
	 from {opacity: 0;}
	 to {opacity:1 ;}
	}
</style>
</head>

<body>
<?php include "php/title.php";?>
<div style="text-align:center">
	<?php echo "<div><pre><strong>Patient:</strong> " .	$_SESSION["pFirstName"] . " " .	$_SESSION["pLastName"] . 
		" <strong>    DOB: </strong>" . $_SESSION["pDOB"] . "<strong>    MRN: </strong>" . $_SESSION["pBarcode"] . "<strong>    Provider: </strong>" . $_SESSION["Provider"] .
		"</pre></div>";
	?>
</div>
<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'home')" id="defaultOpen">Home</button>
  <button class="tablinks" onclick="openTab(event, 'report')">Shift Report</button>
  <button class="tablinks" onclick="openTab(event, 'hp')">H & P</button>
  <button class="tablinks" onclick="openTab(event, 'mdorders')">Orders</button>
  <button class="tablinks" onclick="openTab(event, 'DHistory')"> Other Docs(Labs, Rad, etc...)</button>
  <button class="tablinks" onclick="openTab(event, 'emar')" id="dbutton">Medications</button>
  <button class="tablinks" onclick="openTab(event, 'nursenote')" id="nbutton">Care Notes</button>
</div>
<div id="emar" class="tabcontent">
  	<div class="two-col-grid">
		<div><h2>Medication Orders</h2>
		<?php
		echo "<embed src='patient_files/" . $_SESSION["MarFile"] ;
		echo "#view=FitH&navpanes=0&toolbar=0' type='application/pdf' width='100%' height='800px' align='middle' />";
		?>
		</div>
		<div>
			<h2>Medications Given</h2>
			<form name='input' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='post'>
			<table class='nnote'>
			<tr><td>"Sim" Time:</td><td><input type='text' name='admintime' value="<?php echo date("m/d/y") . " :????";?>" autofocus ></td></tr>
			<tr><td>Scan Medication:<br></td><td><input type='text' name='drugid'>
<?php 
if(isset($_POST["drugid"])) {
	if($_POST["drugid"]=="0") {
		echo "<span style='color:red;font-weight:bold;'>DRUG NOT FOUND</span>";
	}
}
?></td></tr>
			<tr><td colspan="2"><input type='submit' value="Administer"></td></tr>
			</table>
			</form>
			<?php print_drug_admin();?>
		</div>
	</div>
</div>

<div id="nursenote" class="tabcontent">
 <div class="two-col-grid">
  <div><h2>New Note:</h2>

   <table class='nnote'>
	<form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	<tr><td>"Sim" Time:</td><td><input type='text' name='DateTime' value="<?php echo date("m/d/y") . " :";?>"></td></tr>
	<tr><td colspan="2">
	Note:<BR> <textarea name='Note' rows='10' cols='60'><?php printdefaultnote("txt/default-note.txt"); ?></textarea>
	</td><tr>
	<tr><td colspan="2" style='text-align:center'><strong>Vitals</strong></td></tr>
	<tr><td>Heart Rate:<br><input type='text' name='HR' value='0'></td><td>Respiration Rate:<br><input type='text' name='RR' value='0'></td></tr>
	<tr><td>Blood Pressure:<br><input type='text' name='Bp' value='0'></td><td>SpO<sub>2</sub>:<br><input type='text' name='Spo'  value='0'></td></tr>


	<tr><td colspan="2"><input type='submit' name='newnote' value='Chart'></td></tr>
	</form>
   </table>
  </div>
  <div>
	<h2>Patient Care Notes:</h2>
	<?php 
	//printnotes();
	select_notes();
	?>
	</div>
  </div>
 </div>
</div>

<div id="home" class="tabcontent">
<h1 style="text-align: center;"><strong>Overview</strong></h1> <p><strong>Shift Report:</strong></p> <p>This is the report from the off going nurse.&nbsp; It contains a short overview of the patient and their last assessment.</p> <p><strong>H &amp; P (History and Physical):</strong></p> <p>Patient's medical, family, social histories.</p> <p><strong>Orders:</strong></p> <p>This section includes Patient demographics, Active Orders and Provider orders. &nbsp;Includes identifying information such as name, date of birth and other information.</p> <p><strong>Other Documents:</strong></p> <p>Contains any other information in patient chart such as labs, radiology reports, cardiographics and anything else.</p> <p><strong>Medications:</strong></p> <p>Contains Medication Orders and record of all medication given before and during you simulation.</p> <p><strong>Care Notes:</strong></p> <p>A place to chart note on your patient&rsquo;s care, status and vitals.</p></td>

</div>
<div id="mdorders" class="tabcontent">
<?php
echo "<embed src='patient_files/" . $_SESSION["OrdersFile"] . "#navpanes=0&toolbar=0' type='application/pdf' width='100%' height='800px' align='middle' />";
?>
</div>

<div id="report" class="tabcontent">
<?php
echo "<embed src='patient_files/" . $_SESSION["ReportFile"] . "#navpanes=0&toolbar=0' type='application/pdf' width='100%' height='800px' align='middle' />";
?>
</div>

<div id="hp" class="tabcontent">
<?php
echo "<embed src='patient_files/" . $_SESSION["HpFile"] . "#navpanes=0&toolbar=0' type='application/pdf' width='100%' height='800px' align='middle' />";
?>
</div>
<div id="DHistory" class="tabcontent">
<?php print_files(); ?>
</div>

<script>
<?php
if(isset($_POST['newnote'])) {
    echo "document.getElementById('nbutton').click();";
} elseif(isset($_POST["drugid"])) {
    echo "document.getElementById('dbutton').click();";
} else {
    echo "document.getElementById('defaultOpen').click();";
}
?>

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
<?php require 'php/footer.php';?>
	</div>
</body>
</html>

