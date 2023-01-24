<?php
session_start();
//included for some html drawing help
require_once('php/draw.php');

//prints all patient files 
function print_files(){
	include "conn.php";
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

//prints drugs given
function print_drug_admin(){
	// Create connection
	include "conn.php";
 	//--load drug_admins_or from database into array 'medorders'
	$sql = "SELECT * FROM drug_admins_or WHERE drug_admins_or.PatientID=" . $_SESSION["PatientID"] . " ORDER BY drug_admins_or.RealTime DESC";
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

//prints all care notes found
function select_notes(){
	// Create connection &	// Check connection
	include "conn.php";
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
			echo tablerow("<td colspan='4'><p id='notep'><pre>" . $row["Note"] 
			. "</pre></td>");
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

function printdefaultnote($filename){
	//called in the Nursing Notes tab to prpagate the note
	if (file_exists($filename)) {
	$myfile = fopen($filename, "r") or die("Patient has no notes.");
	echo fread($myfile,filesize($filename));
	fclose($myfile);
	}
}
error_reporting(E_ALL);

//Catch if this is a reload add nursing note to file
if(isset($_POST['newnote'])) {
	//db connection object
	include "conn.php";
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

//catch if a med has been given
if(isset($_POST["admdrugid"])) {
        include "conn.php";
        $unsafe_variable = $_POST["admdrugid"];
        $safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
        //open record with barcode scanned
        $sql = "SELECT * FROM `drugs` WHERE Barcode='$safe_variable'";
        $result = $conn->query($sql);
	if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
                $medication=$row;
          }
	  $_POST["admintime"] =$_POST["admintime"] . " - " . date("m/d/y");
          $sql = "INSERT INTO drug_admins_or (DrugID, DrugName, PatientID, UserID, UserInitals, AdminTime)" .
                " VALUES ('" . $medication["id"] . "', '" . $medication["DrugName"] . "', '" . $_SESSION["PatientID"] . "', '" . $_SESSION["UserID"] . "', '" .
                 $_SESSION["uFirstName"] . "', '" . $_POST["admintime"] . "')";
          $result = $conn->query($sql);
        } else {
	  $_POST['admdrugid']=0;
	}
        $conn->close();
}

//catch if a report has been submitted
if(isset($_POST["Patient_Last_Name"])) {
	$sql = "INSERT INTO `or_report` (`id`, ";
	$i=0;
	$values="";
	foreach ($_POST as $key=>$val){
		$i++;
		if ($i == count($_POST)) {
			$values = $values . "'" . $val . "', CURRENT_TIMESTAMP)";
			$sql = $sql . "`" . $key . "`, `Log_Date`) VALUES ( NULL, ";
		} else {
			$values = $values . "'" . $val . "', ";
			$sql = $sql . "`" . $key . "`, ";
		//echo $key." - ".$val."<br/>";
		}
	}
	$sql = $sql . $values;
//	echo $sql;
        include "conn.php";
//        $unsafe_variable = $_POST["admdrugid"];
//        $safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
        //open record with barcode scanned
        $result = $conn->query($sql);
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
		.row {
	  display: grid;
	  grid-template-columns: 50% 50%;
	}
	.column {
	  padding: 2px;
	}

.sm-in{
    width: 3em;
}


</style>

<script>

function validateMedAdmin() {
	const x = document.forms["adminmed"]["admintime"].value;
	const id = document.forms["adminmed"]["drugid"].value;
	if (x == "") {
		alert("Enter a 'Sim' time");
		return false;
	}
	const rights = ["Patient", "Medication", "Dose", "Time", "Route", "Documentation"];

	let txt = "";
	for (let x in rights) {
		txt += rights[x] + "?\n";
	}
	if (confirm("Do you have the right \n" +txt )) {
		alert("Proceed with Medication Administration");
	} else {
		alert("Administration Canceled...");
		return false;
	}
}
</script>
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
<input type=button onClick=window.open("mkrpt.php","demo","width=800,height=600,left=100,top=100,toolbar=0,status=0,"); value="Create Operative Report">
	<button class="tablinks" onclick="openTab(event, 'emar')" id="defaultOpen">Medications</button>
	<button class="tablinks" onclick="openTab(event, 'report')"> Shift Report</button>
	<button class="tablinks" onclick="openTab(event, 'hp')">History  & Physical</button>
	<button class="tablinks" onclick="openTab(event, 'mdorders')">Providers Orders</button>
	<button class="tablinks" onclick="openTab(event, 'DHistory')"> Diagnostics(Labs, Rad, etc..)</button>
	<button class="tablinks" onclick="openTab(event, 'consents')">Consents</button>
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
			<form name='adminmed' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' onsubmit='return validateMedAdmin()' method='post'>
			<table class='nnote'>
			<tr><td>'Sim' Time:(e.x. 1415)</td><td><input type='text' name='admintime' ></td></tr>
			<tr><td>Scan Medication:<br></td><td><input type='text' name='admdrugid' autofocus>
			<?php 
			if(isset($_POST["drugid"])) {
				if($_POST["drugid"]=="0") {
					echo "<span style='color:red;font-weight:bold;'>DRUG NOT FOUND</span>";
				}
			}
			?></td></tr>
			<!-- <tr><td colspan="2"><input type='submit' value="Administer"></td></tr> -->
			</table>
			<input type="submit" style="display: none" />
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

<div id="consents" class="tabcontent">
	<h3>Patient Consents:</h3>

	<pre>
INFORMED CONSENT TO SURGERY


1. Title of Form. 

This form is called an “Informed Consent Form.” It is your doctor’s obligation to provide you with the information you need in order to decide whether to consent to the surgery or special procedure that your doctors have recommended. The purpose of this form is to verify that you have received this information and have given your consent to the surgery or special procedure recommended to you. you should read this form carefully and ask questions of your doctors so that you understand the operation or procedure before you decide whether or not to give your consent. If you have questions, you are encouraged and expected to ask them before you sign this form. Your doctors are not employees or agents of the hospital. They are independent medical practitioners.

2. Recommendation

Your doctors have recommended the following operation or procedure: ___________________
____________________________________________________________________________
____________________________________________________________________________ and the following type of anesthesia: ______________________________________________.

Upon your authorization and consent, this operation or procedure, together with any different or further procedures which, in the opinion of the doctor(s) performing the procedure, may be indicated due to any emergency, will be performed on you. The operations or procedures will be performed by the doctor named below (or, in the event the doctor is unable to perform or complete the procedure, a qualified substitute doctor), together with associates and assistants, including anesthesiologists, pathologists, and radiologists from the medical staff of (name of hospital) ________________________________ to whom the doctor(s) performing the procedure may assign designated responsibilities.

3. Practitioner

Name of the practitioner who is performing the procedure or administering the medical treatment: ___________________________________________________________________.
The hospital maintains personnel and facilities to assist your doctors in their performance of various surgical operations and other special diagnostic or therapeutic procedures. However, your doctors, surgeons and the persons in attendance for the purpose of performing specialized medical services such as anesthesia, radiology, or pathology are not employees or agents of the hospital or of doctor(s) performing the procedure. They are usually independent medical practitioners.

4. Standard Risks

All operations and procedures carry the risk of unsuccessful results, complications, injury or even death, from both known and unforeseen causes, and no warranty or guarantee is made as to result or cure. you have the right to be informed of:

    • The nature of the operation or procedure, including other care, treatment or medications;
    • Potential benefits, risks or side effects of the operation or procedure, including potential problems that might occur with the anesthesia to be used and during recuperation;
    • The likelihood of achieving treatment goals;
    • Reasonable alternatives and the relevant risks, benefits and side effects related to such alternatives, including the possible results of not receiving care or treatment; and 
    • Any independent medical research or significant economic interests your doctor may have related to the performance of the proposed operation or procedure.

Except in cases of emergency, operations or procedures are not performed until you have had the opportunity to receive this information and have given your consent. You have the right to give or refuse consent to any proposed operation or procedure at any time prior to its performance.

5. Conditions (if any)

By your signature below, you authorize the pathologist to use his or her discretion in disposition or use of any member, organ or tissue removed from your person during the operation or procedure set forth above, subject to the following conditions (if any): _____________________
____________________________________________________________________________.

6. Anesthesia

Your doctor will discuss with you the risks and benefits of the recommended operation or procedure, including the following (the patient’s doctor is responsible for the content of the information provided below):

A.	The nature of the operation or procedure and the anesthesia, including the surgical site and laterality if applicable: ______________________________________________________.

B.	The expected benefits or effects of the operation or procedure and anesthesia: _______
____________________________________________________________________________.

The possible risks and/or complications of the operation or procedure and anesthesia, including potential problems that might occur during recuperation include, but are not limited to: ________
____________________________________________________________________________.

C.	Due to the following specific medical condition(s): ______________________________, additional risks and/ or complications of the operation or procedure and anesthesia include, but are not limited to: _____________________________________________________________.

D.	Alternative methods of treatment, including the nature of such treatments, their expected benefits or effects, and their possible risks and complications include: ____________________
____________________________________________________________________________. 

E.	Other issues discussed with the patient: ______________________________________
____________________________________________________________________________.

If your doctor determines that there is a reasonable possibility that you may need a blood transfusion as a result of the surgery or procedure to which you are consenting, your doctor will inform you of this and will provide you with information concerning the benefits and risks of the various options for blood transfusion, including pre-donation by yourself or others. You also have the right to have adequate time before your procedure to arrange for pre-donation, but you can waive this right if you do not wish to wait.

Transfusion of blood or blood products involves certain risks, including the transmission of disease such as hepatitis or Human Immunodeficiency Virus (HIV), and you have a right to consent or refuse consent to any transfusion. You should discuss any questions that you may have about transfusions with your doctor.

Your signature on this form indicates that:

    • You have read and understand the information provided in this form;
    • Your doctor has adequately explained to you the operation or procedure and the anesthesia set forth above, along with the risks, benefits, and the other information described above in this form;
    • You have had a chance to ask your doctors questions;
    • You have received all of the information you desire concerning the operation or procedure and the anesthesia; and
    • You authorize and consent to the performance of the operation or procedure and the anesthesia.


Date: _______________________ Time: _______________________   ☐ AM ☐ PM


Signature: ________________________________________________
(Patient / Legal Representative)

If signed by someone other than the patient, indicate their name: _____________________

Relationship: _____________________


Physician Certification


I, the undersigned physician, hereby certify that I have discussed the procedure described in this consent
form with this patient (or the patient’s legal representative), including:

•	The risks and benefits of the procedure;
•	Any adverse reactions that may reasonably be expected to occur;
•	Any alternative efficacious methods of treatment which may be medically viable;
•	The potential problems that may occur during recuperation; and
•	Any research or economic interest I may have regarding this treatment.

I understand that I am responsible for filling in all blanks in paragraphs 2, 3 and 6. I further certify that the patient was encouraged to ask questions and that all questions were answered.


Date: _______________________ Time: _______________________   ☐ AM ☐ PM

Signature: ________________________________________________
(Physician)

Print Name: ________________________________________________
(Physician)

Consent to Blood Transfusion

Your signature below indicates that:

    • You have received a copy of the brochure, A Patient’s Guide to Blood Transfusion
    • You have received from your doctor concerning the risks and benefits of blood transfusion and any alternative therapies and their risks and benefits.
    • You have had the opportunity to discuss this matter with your doctor, including pre-donation.
    • Subject to any special instructions listed below, you consent to such blood transfusion as your doctor may order in connection with the operation or procedure described in this consent form.

Special Instructions: ___________________________________________________________
____________________________________________________________________________.
(Describe here any specific instructions for patient’s blood transfusion, e.g. pre-donation, direct donation, etc.)

Date: _______________________ Time: _______________________   ☐ AM ☐ PM


Signature: ________________________________________________
(Patient / Legal Representative)

If signed by someone other than the patient, indicate their name: _____________________

Relationship: _____________________

Interpreter’s Statement

I have accurately and completely read the foregoing document to (patient or patient’s legal representative) ________________________________ in the patient’s or legal representative’s primary language _________________ (state the language). He or She understood all of the terms and conditions and acknowledged his or her agreement by signing the document in my presence.

Date: _______________________ Time: _______________________   ☐ AM ☐ PM

Signature: ________________________________________________
(Interpreter)

Print Name: ________________________________________________
(Interpreter)
</pre>
</div>

<div id="opreport" class="tabcontent">
<!--					OP REPORT FORM								-->
<div>
  <h2 style='text-align:center;''>SURGERY INTRAOPERATIVE REPORT</h2>
<form name='orreport' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='post'>
  <div class='row'>
    <div class='column'>
      <fieldset id='PATIENT OVERVIEW'>
        <legend><b>PATIENT OVERVIEW:</legend>
        Patient ID: <input name='Patient_ID' type='hidden' value='<?php echo $_SESSION["PatientID"];?>' /> <br />
        Patient Last Name: <input name='Patient_Last_Name' type='text' value='<?php echo $_SESSION["pLastName"];?>' /> <br />
        Patient First Name: <input name='Patient_First_Name' type='text' value='<?php echo $_SESSION["pFirstName"];?>' /> <br />
        Patient DOB: <input name='Patient_DOB' type='text' value='<?php echo $_SESSION["pDOB"];?>' /> <br />
        <input name="Sex" type="radio" value="male" checked="checked" /> Male
        <input name="Sex" type="radio" value="female" /> Female <br />
        Patient Idenified in OR:<input name='Verify_ID' type='checkbox' value='1' /> <br />
        Preoperative diagnosis: <input name='Diagnosis' type='text' value='' /> <br />
        Allergies:<br />
        <textarea name="Allergies" cols="30" rows="2">or NKDA?</textarea><br />
        Patient Type: <input name='Patient_Type' type='text' value='(in patient, out, add-on, ED)' /> <br />
      </fieldset>

      <fieldset id='Surgical times'>
        <legend>Surgical times</legend>
        Patient in OR: <input name="Patient_In_OR" type="text" value="" /> <br />
        Anesthesia Start: <input name="Anesthesia_Start" type="text" value="" class='sm-in' />
        End: <input name="Anesthesia_End" type="text" value="" class='sm-in' /> <br />
        Surgical Start: <input name="Surgical_Start" type="text" value="" class='sm-in' />
        End: <input name="Surgical_End" type="text" value="" class='sm-in' /> <br />
        Surgeon IN: <input name="Surgeon_In" type="text" value="" class='sm-in' />
        OUT: <input name="Surgeon_Out" type="text" value="" class='sm-in' /> <br />
        Assitant IN: <input name="Assistant_In" type="text" value="" class='sm-in' />
        OUT: <input name="Assistant_Out" type="text" value="" class='sm-in' /> <br />
      </fieldset>

      <fieldset id='Position'>
        <legend>Patient Position:</legend>
        <input name="Patient_Position" type="radio" value="supline" checked="checked" /> supline <br />
        <input name="Patient_Position" type="radio" value="lithotomy" /> lithotomy <br />
        <input name="Patient_Position" type="radio" value="lateral" /> lateral <br />
        <input name="Patient_Position" type="radio" value="prone" /> prone <br />
        <input name="Patient_Position" type="radio" value="fowlers" /> fowlers <br />
        </input>
      </fieldset>
        <fieldset id='Site Prep'>
          <legend>Site Prep:</legend>
          Site: <input name="Site" type="text" value="" /> <br />
          <input name="Hair_Removal" type="checkbox" value="1" /> Hair removal<br />
          Removal Method: <input name="Removal_Method" type="text" value="" /> <br />
          Prep Solution: <input name="Prep_Solution" type="text" value="" /> <br />
          Applied By: <input name="Prep_Solution_Applied_By" type="text" value="" /> <br />
        </fieldset>
        <fieldset id='Catheter'>
          <legend>Catheter</legend>
          Type: <input name='Cath_Type' type='text' value='' /> <br />
          Size: <input name='Cath_Size' type='text' value='' /> <br />
          Placed by: <input name='Cath_Placed_By' type='text' value='' /> <br />
          Urine:<br /><textarea name='Urine_Description' cols="30" rows="2">Long text.</textarea><br />
        </fieldset>
        <fieldset id='Implant'>
          <legend>Implant(s):</legend>
          Model: <input name='Implant_Model' type='text' value='' /> <br />
          Size: <input name='Implant_Size' type='text' value='' /> <br />
          Manufacturer: <input name='Implant_Manu' type='text' value='' /> <br />
          Site: <input name='Implant_Site' type='text' value='' /> <br />
          Lot #: <input name='Implant_Lot' type='text' value='' /> <br />
        </fieldset>
        <fieldset id='Counts'>
          <legend>Counts:</legend>
          Initial Count: <br />
          Sharps:<input name="Init_Sharps" type="text" value="" class='sm-in' />
          Sponges: <input name="Init_Sponges" type="text" value="" class='sm-in' />
          Intruments: <input name="Init_Instruments" type="text" value="" class='sm-in' /> <br />
          Personnel: <input name="Init_Personnel" type="text" value="" />
          <hr />
          Final Count: <br />
          Sharps:<input name="Final_Sharps" type="text" value="" class='sm-in' />
          Sponges: <input name="Final_Sponges" type="text" value="" class='sm-in' />
          Intruments: <input name="Final_Instruments" type="text" value="" class='sm-in' /> <br />
          Personnel: <input name="Final_Personnel" type="text" value="" /> <br />
          Correct:<input name="Count_Correct" type="text" value="" class='sm-in' />
          Incorrect: <input name="Count_Incorrect" type="text" value="" class='sm-in' /> <br />
          <input name="ROPI" type="checkbox" value="1" /> Retained object protocol implemented<br />
          <input name="Count_Notified" type="checkbox" value="1" /> Surgeon notified <br />
        </fieldset>
        <fieldset id='discharge'>
          <legend>Discharge(PACU, Day surgery, Other):</legend>
          Discharged to: <input name="Discharged_To" type="text" value="" /><br />
          <hr />
          Via(Litter/Hospital bed ): <input name="Discharge_Via" type="text" value="" /> <br />
        </fieldset>
      <fieldset id='submit'>
        <legend>Submit Report</legend>
        <button type="submit">Submit</button>
      </fieldset>
    </div>
    <div class='column'>
      <fieldset id='Operative Procedure'>
        <legend>Operative Procedure:</legend>
        Procedure:<input name='Procedure' type='text' value='' /> <br />
        Surgeon: <input name="Surgeon_Name" type="text" value="" /> <br />
        Assitant: <input name="Assistiant_Name" type="text" value="" /> <br />
        Anesthesiologist: <input name="Anesthesiologist_Name" type="text" value="" /> <br />
        Anesthesia Type: <input name="Anesthesia_Type" type="text" value="" /> <br />
      </fieldset>

      <fieldset id='Positional Aids'>
        <legend>Positional Aids:</legend>
        Axillary roll:<input name='Axillary_Roll' type='checkbox' value='1' /><br />
        Bean bag:<input name='BeanBag' type='checkbox' value='1' /><br />
        Chest rolls:<input name='ChestRolls' type='checkbox' value='1' /><br />
        Foam head rest:<input name='FoamHeadRest' type='checkbox' value='1' /><br />
        Foot board:<input name='FootBoard' type='checkbox' value='1' /><br />
        Gel head rest:<input name='GelHeadRest' type='checkbox' value='1' /><br />
        Kidney brace:<input name='KidneyBrace' type='checkbox' value='1' /><br />
        Leg strap:<input name='LegStrap' type='checkbox' value='1' /><br />
        Pillows:<input name='Pillows' type='checkbox' value='1' /><br />
        Shoulder roll:<input name='ShoulderRoll' type='checkbox' value='1' /><br />
        Stirrups:<input name='Stirrups' type='checkbox' value='1' /><br />
        Other:<input name='Other_Postional' type='checkbox' value='1' /><br />
      </fieldset>

      <fieldset id='SCD'>
          <legend>SCDs:</legend>
          Unit: <input name='SCD_Unit' type='text' value='' /> <br />
          Setting: <input name='SCD_Setting' type='text' value='' /> <br />
          Knee length: <input name='SCD_Knee_Length' type='text' value='' /> <br />
          Thight Length: <input name='SCD_Thigh_Length' type='text' value='' /> <br />
        </fieldset>

      <fieldset id='wamrth'>
        <legend>Warmth:</legend>
        Warm blankets applied<input name='Warming_Blanket' type='checkbox' value='1' /><br />
        Forced air blanket:<input name='Warming_Blanket' type='checkbox' value='1' /> <br />
        Unit#:<input name='Blanket_Unit' type='text' value='' class='sm-in'/> <br />
        Setting:<input name='Blanket_Setting' type='text' value=''/> <br />
        <hr/>
        Warm irrigation used:<input name='Warm_Irrigation' type='checkbox' value='1' /><br />
        Exposure limited to surgical site:<input name='Warm_Site' type='checkbox' value='1' /><br />
       	Room temperature increased:<input name='Room_Temperature_Increased' type='checkbox' value='1' /><br />
      </fieldset>
      
      <fieldset id='Cautery'>
        <legend>Cautery:</legend>
        ESU:<input name='Cautery_ESU' type='text' value='' /> <br />
        Cut:<input name='Cautery_Cut' type='text' value='' /> <br />
        Coag:<input name='Cautery_Coag' type='text' value='' /> <br />
        Pad site:<input name='Cautery_Pad_Site' type='text' value='' /> <br />
        Bipolar :<input name='Cautery_Bipolar' type='text' value='' /> <br />
        Setting:<input name='Cautery_Setting' type='text' value='' /> <br />
        Dispersive pad site checked at removal <input name='Cautery_Dispersive_Pad_Site_Checked_At_Removal' type='checkbox' value='1' /><br />
        Shaved:<input name='Cautery_Shaved' type='checkbox' value='1' /><br />
      </fieldset>

      <fieldset id='Tourniquet'>
        <legend>Tourniquet:</legend>
        Unit :<input name='Tourniquet_Unit' type='text' value='' /> <br />
        Site:<input name='Tourniquet_Site' type='text' value='' /> <br />
        Pressure(mmHg):<input name='Tourniquet_Pressure' type='text' value='' /> <br />
        Applied by:<input name='Tourniquet_Applied_By' type='text' value='' /> <br />
        Padded:<input name='Tourniquet_Padded' type='checkbox' value='1' /><br />
        <hr />
        TIME UP: <input class='sm-in' name="TourniquetUpOne" type="text" value="" />
        TIME DOWN: <input class='sm-in' name="TourniquetDownOne" type="text" value="" /> <br />
        TIME UP: <input class='sm-in' name="TourniquetUpTwo" type="text" value="" />
        TIME DOWN: <input class='sm-in' name="TourniquetDownTwo" type="text" value="" /> <br />
        TIME UP: <input class='sm-in' name="TourniquetUpThree" type="text" value="" />
        TIME DOWN: <input class='sm-in' name="TourniquetDownThree" type="text" value="" /> <br />
      </fieldset>
    </div>
  </div>
</form>
  </div>
<!--														-->
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

