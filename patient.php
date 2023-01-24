<?php
/* @file	patient.php
 * @author	nicholai.best@gmail.com
 * @date	see below
 * @desc	Main patient viewing page, functions at top for various html printing
 * 			
 */
define('LAST_WORK','1/9/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');
define('AUTH_CODE','54792390');

session_start();
error_reporting(E_ALL);
//included for html table drawing
require('common-items.php');

/* Prints a list of all patient files that are not standard
 * 
 * data from from 'patient_files' sql table in 'sudo_meds'
 */
function print_files(){
	$conn = ConnectDB();
	$sql = "SELECT * FROM patient_files WHERE PatientID=" . $_SESSION["PatientID"];
	$result = $conn->query($sql);
	//makes table of all files found prints a row for each record
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

/* Prints drugs given for the mar section
 * pulls from 'drug_admins' sql table 
 */
function print_drug_admin(){
	// Create connection
	$conn = ConnectDB();
 	//--load drug_admins from database into array 'medorders'
	$sql = "SELECT * FROM drug_admins WHERE drug_admins.PatientID=" . $_SESSION["PatientID"] . " ORDER BY drug_admins.RealTime DESC";
	$result = $conn->query($sql);
	//makes table of all files found prints a row for each record
	if ($result->num_rows > 0) {
		echo "<table class='drug_table'>";
		echo "<tr>";
		echo "<th>Time given</th>";
		echo "<th>Drug</th>";
		echo "<th>Clinician</th>";
		echo "</tr>\n";
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo tablecell($row["AdminTime"]);
			echo tablecell($row["DrugName"]);
			echo tablecell($row["UserInitals"]);
			echo "</tr>\n";
		}
		echo "</table>";
	//if none found amke empty table
	} else {
		echo "<table id='drug_table' style='width:80%'>";
		echo "<tr>";
		echo "<th>Time given</th>";
		echo "<th>Drug</th>";
		echo "<th>Clinician</th>";
		echo "</tr>\n<tr>";
		echo tablecell("---") . tablecell("No medications have been administered yet."). tablecell("---");
		echo "</tr>\n";
		echo "</table>";
	}
	$conn->close();
}

// Prints all care notes found
function select_notes(){
	// Create connection &	// Check connection
	$conn = ConnectDB();
	//select from notes but join to add user info in place of UID
	$sql = "SELECT n.DateTime, n.HR, n.RR, n.Bp, n.Spo, n.Note, u.FirstName,u.LastName FROM nurse_notes as n INNER JOIN users as u ON u.id=n.UserID WHERE n.PatientID=" . 
	$_SESSION["PatientID"] . " ORDER BY n.DateTime DESC";
	$result = $conn->query($sql);
	//print a table with all records for this patient
	if ($result->num_rows > 0) {
		echo "<table class='nnote'>";
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<th colspan='4'>Note Charted " . $row["DateTime"] . " by " . $_SESSION['uFirstName'] . "</th>";
			echo "</tr>";
			echo tablerow(tablecell("HR:<br>" . $row["HR"]) .	tablecell("RR:<br>" . $row["RR"])) ;
			echo tablerow(tablecell("BP:<br>" . $row["Bp"]) .	tablecell("SpO<sub>2</sub><br>" . $row["Spo"])) ;
			echo tablerow("<td colspan='4'><p id='notep' style='white-space: pre-wrap;'>" . $row["Note"] 
			. "</td>");
		}
		echo "</table>";
	//empty if none found
	} else {
		echo "<table class='nnote'>";
		echo tablerow(tablecell("No notes made yet."));
		echo "</table>";
	}
	$conn->close();
}

/* Prints the default txt for the care note box 
 * called in the Nursing Notes tab
 */
function printdefaultnote($filename){
	if (file_exists($filename)) {
		$myfile = fopen($filename, "r") or die("Patient has no notes.");
		echo fread($myfile,filesize($filename));
		fclose($myfile);
	}
}

/* If page is being self-called to add nursing note
 * this triggers and adds the note to the sql table
 * needs PDO added
 */
if(isset($_POST['newnote'])) {
	//db connection object
	$conn = ConnectDB();
	//escape all user input for injections
	foreach ($_POST as $key=>$val){
		$sqlsafe=mysqli_real_escape_string($conn,$val);
		$safevar[$key]=htmlspecialchars($sqlsafe);
	}
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
	$result = $conn->query($sql);
  $conn->close();
}

/* If page is being self-called to add med the has been given
 * if a $_POST["drugid"] will only exsist if a med has been given
 */
if(isset($_POST["drugid"])) {
	$conn = ConnectDB();
	$unsafe_variable = $_POST["drugid"];
	$safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
	//open record with barcode scanned
	$sql = "SELECT * FROM `drugs` WHERE Barcode='$safe_variable'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
			$medication=$row;
	  }
	  $_POST["admintime"] =$_POST["admintime"] . " - " . date("m/d/y");
          $sql = "INSERT INTO drug_admins (DrugID, DrugName, PatientID, UserID, UserInitals, AdminTime)" .
                " VALUES ('" . $medication["id"] . "', '" . $medication["DrugName"] . "', '" . $_SESSION["PatientID"] . "', '" . $_SESSION["UserID"] . "', '" .
                 $_SESSION["uFirstName"] . "', '" . $_POST["admintime"] . "')";
          $result = $conn->query($sql);
        } else {
	  $_POST['drugid']=0;
	}
        $conn->close();
}


/* ===============================================
 * HEADING
 * =============================================== 
 */
 
/* -----------------------------------------------
 * begin print page here
 * -----------------------------------------------
 */
$validscript ="
<script>

function validateMedAdmin() {
	const x = document.forms['adminmed']['admintime'].value;
	const id = document.forms['adminmed']['drugid'].value;
	if (x == '') {
		alert('Enter a time, move to next box and scan a drug');
		return false;
	}
  if (id == '') {
		alert('Enter a time, move to next box and scan a drug');
		return false;
	}
	const rights = ['Patient', 'Medication', 'Dose', 'Time', 'Route', 'Documentation'];

	let txt = '';
	for (let x in rights) {
		txt += rights[x] + '?\n';
	}
	if (confirm('Do you have the right \n' +txt )) {
		//alert('Proceed with Medication Administration');
	} else {
		alert('Administration Canceled...');
		return false;
	}
}
</script>
";
echo getHead(PAGE_TITLE,LAST_WORK,$c).getTitle("");


	


echo "
<div style='text-align:center'>
	
  <pre><strong>Patient:</strong> " .	$_SESSION["pFirstName"] . " " .	$_SESSION["pLastName"] . 
  "<strong>    DOB: </strong>" . $_SESSION["pDOB"] . 
  "<strong>    MRN: </strong>" . $_SESSION["pBarcode"] . 
  "<strong>    Provider: </strong>" . $_SESSION["Provider"] . "</pre>
  
</div>
<div class='pt-menu'>
  <button class='tablinks' onclick='openTab(event, \"home\")'>Overview</button>
	<button class='tablinks' onclick='openTab(event, \"report\")' id='defaultOpen'>Shift Report</button>
	<button class='tablinks' onclick='openTab(event, \"hp\")'>H & P</button>
	<button class='tablinks' onclick='openTab(event, \"mdorders\")'>Orders</button>
	<button class='tablinks' onclick='openTab(event, \"DHistory\")'> Diagnostics(Labs, Rad, etc..)</button>
	<button class='tablinks' onclick='openTab(event, \"emar\")' id='dbutton'>Medications</button>
	<button class='tablinks' onclick='openTab(event, \"nursenote\")' id='nbutton'>Care Notes</button>	
</div>

<div id='emar' class='tabcontent'>
<div class='two-col-grid'>
  <div><h2>Medication Ordered</h2>";
echo "  <embed src='patient_files/" . $_SESSION["MarFile"] . 
    "#view=FitH&navpanes=0&toolbar=0' type='application/pdf' width='100%' height='800px' align='middle' />
  </div>
  <!--col 2 -->
		<div>
			<h2>Administer Medications</h2>
      <span class='warning'><ol>
        <li>Enter a time for administration</li>
        <li>Tab to next box</li>
        <li>Scan a medication</li>
      </ol></span>";
			echo "<form name='adminmed' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) ."' onsubmit='return validateMedAdmin()' method='post'>
			<table class='nnote'>
			<tr><td>'Sim' Time:(e.x. 1415)</td><td><input type='text' name='admintime' ></td></tr>
			<tr><td>Scan Medication:<br></td><td><input type='text' name='drugid' autofocus>";
			
			if(isset($_POST["drugid"])) {
				if($_POST["drugid"]=="0") {
					echo "<span style='color:red;font-weight:bold;'>DRUG NOT FOUND</span>";
				}
			}
      echo"
        </td></tr>
			</table>
			<input type='submit' style='display: none' />
			</form>
			" .print_drug_admin(). "
		</div>
	</div>
</div>";
?>

<div id="nursenote" class="tabcontent">
	<div class="two-col-grid">
		<div><h2>New Note:</h2>
			<table class='nnote'>
			<form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
			<tr><td>"Sim" Time:</td><td><input type='text' name='DateTime' value="<?php echo date("m/d/y") . " :";?>"></td></tr>
			<tr><td colspan="2">Note:<br /> <textarea name='Note' rows='10' cols='60'><?php printdefaultnote("txt/default-note.txt"); ?></textarea></td><tr>
			<tr><td colspan="2" style='text-align:center'><strong>Vitals</strong></td></tr>
			<tr><td>Heart Rate:<br><input type='text' name='HR' value='0'></td><td>Respiration Rate:<br><input type='text' name='RR' value='0'></td></tr>
			<tr><td>Blood Pressure:<br /><input type='text' name='Bp' value='0'></td><td>SpO<sub>2</sub>:<br /><input type='text' name='Spo'  value='0'></td></tr>
			<tr><td colspan="2"><input type='submit' name='newnote' value='Chart'></td></tr>
			</form>
			</table>
		</div>
		<div>
			<h2>Patient Care Notes:</h2>
			<?php select_notes();?>
		</div>
	</div>
</div>

<div id="home" class="tabcontent">

	<h1 style="text-align: center;"><strong>Overview</strong></h1> 
	<p><strong>Shift Report:</strong></p> 
	<p>This is the report from the off going clinician.&nbsp; 
	It contains a short overview of the patient and their last assessment.</p> 
	<p><strong>H &amp; P (History and Physical):</strong></p> 
	<p>Patient's medical, family, social histories.
	</p> <p><strong>Orders:</strong></p> 
	<p>This section includes Patient demographics, Active Orders and Provider orders. &nbsp;
	Includes identifying information such as name, date of birth and other information.</p> 
	<p><strong>Other Documents:</strong></p> 
	<p>Contains any other information in patient chart such as labs, radiology reports, cardiographics and anything else.</p> 
	<p><strong>Medications:</strong></p> 
	<p>Contains Medication Orders and record of all medication given before and during you simulation.</p> 
	<p><strong>Care Notes:</strong></p> 
	<p>A place to chart note on your patient&rsquo;s care, status and vitals.</p></td>
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
//changes default page if user has just administered a drug or added a note

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

