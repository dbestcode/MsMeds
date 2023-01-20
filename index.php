<?php

/* File: index.php
 * @author nicholai.best@gmail.com
 * @date see below
 * @desc Default page, user can enter their ID, Pin and Patient ID/MRN
 * 
 */
 
define('LAST_WORK','1/8/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');
define('AUTH_CODE','54792390');

// Values for $_POST['originForm']
// Used for detemining what data is being sent
define('FRM_USER_ID',0);      // User ID Scaned, login
define('FRM_PIN',1);          // Passwrod entered
define('FRM_PATIENT_CODE',2); // Patient armabdn scanned
define('FRM_NEW_CASE',3); // Patient armabdn scanned
define('FRM_ADD_USER','4');


define('DEBUG_ON','0');

require_once('common-items.php');
session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);

printDebug(DEBUG_ON);

if (isset($_POST['originForm'])){
  switch ($_POST['originForm']) {
  case FRM_USER_ID:
  // User ID Entered
    CheckUserID($_POST["barcode"]);
    pageMain(htmlLoginForm());
    break;
  case FRM_ADD_USER:
    echo "sumbitted user password for new user";
    insertUser();
    exit;
    break;
  case FRM_PIN:
    CheckPassword();
    exit;
    break;
  case FRM_NEW_CASE:
    $conn = ConnectDB();
    $sql = "DELETE FROM drug_admins WHERE PatientID=" . $_POST["PatientID"];
    $result = $conn->query($sql);
    $sql = "DELETE FROM nurse_notes WHERE PatientID=" . $_POST["PatientID"];
    $result = $conn->query($sql);
    header("Location: patient.php");
    break;
  case FRM_PATIENT_CODE:
  // Patient barcode scanned, open patient
    pageOpenPatient();
    break;
  }
} 
else
{
  pageMain(htmlLoginForm());
}

function htmlLoginForm(){
/* called middle of page
 * Produces content based on current login status
 *  e.x. UserID verified, pin vailidated, patient located
 * Varibles passed to SetSeeion change based on what is set in the Session variable already
 */
  $htmlpage = "";
	/* User is verified with a password, promt for a patient ID
	 * Post:PatientBarcode
	 */ 
	if (isset($_SESSION["UserID"]) && isset($_SESSION["AuthPass"])) 
  {
		$htmlpage .= "
    <p><h3>Please scan the Patient ID band<br/> or enter the MRN</h3>
		<br><form action='".$_SERVER['PHP_SELF']."' method='post'>
    <input name='originForm' type='hidden' value='".FRM_PATIENT_CODE."'>
		<input type='text' name='PatientBarcode' autofocus></form></p>";
	/* A Valid user ID has been entered, prompt for a 'pin'
	 * Post:UnHashPin
	 */
	} 
  elseif (isset($_SESSION["UserID"])) 
  {
		$htmlpage .= "
    <br><h2>Welcome " . $_SESSION["uFirstName"] . "!</h2>
		<p>Enter your PIN
		<br><form action='".$_SERVER['PHP_SELF']."' method='post'>
    <input name='originForm' type='hidden' value='".FRM_PIN."'>
    <input type='password' name='UnHashPin' autofocus>
    </form>
		or <a href='logout.php'>return to login</a>";
	/* No session variables of consiquence are set prompt for user name
	 * post:barcode
	 */
	} 
  else 
  {
		$htmlpage .= "
    <p>Please scan your ID now.</p>
		<br><form action='".$_SERVER['PHP_SELF']."' method='post' onsubmit='return validateForm()'>
    <input name='originForm' type='hidden' value='".FRM_USER_ID."'>
    <input type='text' name='barcode' autofocus></form>";
	}
  return $htmlpage;
}

function pageMain($htmlcontent){
  $validscript ="
    <script>
    function validateForm() {
      let x = document.forms[\"input\"][\"barcode\"].value;
      if (x == \"\") {
      alert(\"Please Scan a Valid Barcode\");
      return false;
      }
    }
    </script>";
    echo getHead(PAGE_TITLE,LAST_WORK,$validscript).getTitle("")."
  <div id='ccontainer' class='container' style='height:400px'>
    <div class='vhcenter' style='text-align:center'>
      <img src='img/logo.png' width='150'>".
     $htmlcontent."
    </div>
  </div>";
  echo getTail();
}

function pageOpenPatient(){
  if(isset($_POST["PatientBarcode"])) {
    $conn = ConnectDB();
    $unsafe_variable = $_POST["PatientBarcode"];
    $safe_variable = mysqli_real_escape_string($conn,$unsafe_variable);
    //open record with barcode scanned
    $sql = "SELECT * FROM `patients` WHERE Barcode='$safe_variable'";
    $result = $conn->query($sql);
    //A patient has been found
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $_SESSION["PatientID"] = $row["id"];
        $_SESSION["pFirstName"] = $row["FirstName"];
        $_SESSION["pLastName"] = $row["LastName"];
        $_SESSION["pDOB"] = $row["DOB"];
        $_SESSION["pBarcode"] = $row["Barcode"];
        $_SESSION["Provider"] = $row["Provider"];
        $_SESSION["MarFile"] = $row["MarFile"];
        $_SESSION["HpFile"] = $row["HpFile"];
        $_SESSION["OrdersFile"] = $row["OrdersFile"];
        $_SESSION["ReportFile"] = $row["ReportFile"];
        $_SESSION["HpFile"] = $row["HpFile"];
      }
      printDebug(DEBUG_ON,$_SESSION["PatientID"]);
      //header("Location: opencase.php");
      
      // checking for current records(meds or notes), if found redirect to 'opencase.php' for option to delete
      $sql = "SELECT * FROM `drug_admins` WHERE PatientID=" . $_SESSION["PatientID"];
      $resultone = $conn->query($sql);
      $sql = "SELECT * FROM `nurse_notes` WHERE PatientID=" . $_SESSION["PatientID"];
      $resulttwo = $conn->query($sql);

      if (($resultone->num_rows > 0)||($resulttwo->num_rows > 0)) 
      {
        //header("Location: opencase.php");
        //-------------------------------------------
        $htmlnewcase = "<h2>Simulation in progress</h2>". 
        $_SESSION["pFirstName"] . " " . $_SESSION["pLastName"] . " " . $_SESSION["pDOB"] . "		
        has a session open.<br>
        <a href='patient.php' style='
        background-color: #20285b;
        display:inline-block;
        color: white;
        padding: 16px 16px;
        text-decoration: none;
        text-align:center;
        width: 150px;'>Continue Case?</a>
        <form method='post' action='".htmlspecialchars($_SERVER['PHP_SELF'])."'>
        <input name='originForm' type='hidden' value='".FRM_NEW_CASE."'>
        <input type='hidden' name='PatientID' value='".htmlspecialchars($_SESSION['PatientID'])."'><br>
        <input type='submit' name='submit' value='Start New Case?'><br>
        </form>
        <br/><strong>NOTE: 'Start New Case' will clear all progress.</strong><br>";
        pageMain($htmlnewcase);
      } 
      else 
      {
        header("Location: patient.php");
        exit;
      }

      /*if ($_SESSION["AccessLevel"] == 7){
        header("Location: oper.php");
      } else {
        header("Location: patient.php");
      }*/
    } else {
      echo "Not found!";
    }
    $conn->close();
    }
}

// check userId against database, 
function CheckUserID($barcode){
  $conn = ConnectDB();
  $safe_variable = mysqli_real_escape_string($conn,$barcode);
  //open record with barcode scanned
  $sql = "SELECT id,FirstName,LastName,Barcode,AccessLevel,Pin FROM `users` WHERE Barcode='$barcode'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $_SESSION["UserID"] = $row["id"];
      $_SESSION["uFirstName"] = $row["FirstName"];
      $_SESSION["uLastName"] = $row["LastName"];
      $_SESSION["AccessLevel"] = $row["AccessLevel"];
      $_SESSION["PinHash"] = $row["Pin"];
    }
  } 
  else
  {
    pageMain(htmlAddUserForm($safe_variable));
    exit;
  }
  $conn->close();
}

// Check password/pin and redirects base on correctness
function CheckPassword(){
  if(isset($_SESSION["PinHash"]) && isset($_POST["UnHashPin"])) {
    if (hash('md5',$_POST["UnHashPin"]) == $_SESSION["PinHash"]){
      echo "<h1>Access Granted.</h1>";
      //echo hash('md5',$_POST["UnHashPin"]);
      $_SESSION["AuthPass"]=AUTH_CODE;
      unset($_SESSION["PinHash"]);
    } elseif (empty($_SESSION["PinHash"])) {
      echo "<h1>Account has no pin.<br>Access Granted.</h1>";
      //echo hash('md5',$_POST["UnHashPin"]);
      $_SESSION["AuthPass"]=AUTH_CODE;
      unset($_SESSION["PinHash"]);
    } else {
      echo "
      <H1>PIN INVALID</H1>
      <meta http-equiv='refresh' content='2;url=index.php'>";
      exit;
    }
    if ($_SESSION["AccessLevel"] == 3){
      header("Location: settings.php");
    } else {
      header("Location: index.php");
    }
  } 
}

// Inserts the new user data into the database
function insertUser(){
  $sql="INSERT INTO users";
	$i=0;
	$feilds="id, ";
	$values="NULL, ";
 	foreach($_POST as $x =>$x_value){
                if($i==2){	//fname
			$feilds = $feilds . $x . ", ";
			$values = $values . "'" . $x_value . "', ";
                } elseif($i==3){ //lname
			$feilds = $feilds . $x . ", ";
			$values = $values . "'" . $x_value . "', ";
                } elseif($i==6){ //barcode
			$feilds = $feilds . $x . ", ";
			$values = $values . "'" . $x_value . "', ";
		} elseif ($i==4){
			$feilds = $feilds . $x . ", ";
                					//PIN, storing the hash not the pin
			$values = $values . "'" . hash('md5',$x_value) . "', ";
		}
		$i++;

        }
	$feilds = $feilds . "AccessLevel";
	$values = $values . "'1'";

	$sql= $sql . " (" . $feilds . ") VALUES (" . $values . ")";
	printDebug(DEBUG_ON,$sql);
	
	$conn=ConnectDB();
	$result = $conn->query($sql);
	echo $result;
	$conn->close();
	if ($result == 1){
		echo "<p>You have been added.  Returning to login screen...";
    $_SESSION["UserID"] = $_POST["id"];
    $_SESSION["uFirstName"] = $_POST["FirstName"];
    $_SESSION["uLastName"] = $_POST["LastName"];
    $_SESSION["AccessLevel"] = $_POST["AccessLevel"];
    $_SESSION["AuthPass"]=AUTH_CODE;
    header("Location: index.php");
	} else {
		echo "<p>Something went wrong...  Returning to login screen...";
	}
	echo "<meta http-equiv='refresh' content='2;url=index.php'>";
}

// @return html for the add user form
function htmlAddUserForm($barcode){
  $html = "
  <script>
  //fuction to make user enter first and last name
  function validateNewUser() {
    //grab data from from boxes
    const fn = document.forms['newuser']['FirstName'].value;
    const ln = document.forms['newuser']['LastName'].value;
    const pin = document.forms['newuser']['Pin'].value;
    const dpin = document.forms['newuser']['dPin'].value;
    //verfity name feilds are not empty and pin matches IF set
    if (fn == '') {
      alert('Enter a first name');
      return false;
    }else if (ln == '') {
      alert('Enter a last name');
      return false;
    }else if (pin !== dpin) {
      alert('Pins do not match...');
      return false;
    }
  }
  </script>

  <form name='newuser' method='post' action='". htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return validateNewUser()'>
  <H2>Register New User</H2>
  <p>A pin recomeneded but is not required.  If you use no pin your data and your patient's<br/>
  data will NOT be secure.  You should alway take security precautions using patient data.</p>
  <table>
  <form method='post' action=/additem.php>
  <input type='hidden' name=table value=users>
  <input type='hidden' name='id'>
  <tr><td>FirstName</td><td><input type='text' name='FirstName' autofocus><br></td></tr>
  <tr><td>LastName</td><td><input type='text' name='LastName'><br></td></tr>
  <tr><td>Pin</td><td><input type='password' name='Pin'><br></td></tr>
  <tr><td>Pin(Again)</td><td><input type='password' name='dPin'><br></td></tr>
  <tr><td></td><td><input type='hidden' readonly='true' name='Barcode' value='$barcode'><br></td></tr>
  <tr><td></td><td><input type='hidden' readonly='true' name='AccessLevel' value='1'><br></td></tr>
  <input type='hidden' name='originForm' value='".FRM_ADD_USER."'>
  <tr>
  <td><a href='index.php' style='background-color: #20285b;border: none; color: white; padding: 16px 32px; text-decoration: none;  margin: 4px 2px; cursor: pointer;'>Cancel</a></td>
  <td><input type='submit' name='submit' value='Submit Form'><br></td></tr>
  </table>
  </form>";
  return $html;
}
?>
