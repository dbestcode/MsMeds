<?php

/* File: index.php
 * @author nicholai.best@gmail.com
 * @date see below
 * @desc Default page, user can enter their ID, Pin and Patient ID/MRN
 * 		 All info is sent to SetSession.php for handling
 * 		 SetSession to be moved into this file at some point
 * 
 */
 
define('LAST_WORK','1/8/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');

// Values for $_POST['originForm']
// Used for detemining what data is being sent
define('FRM_USER_ID',0);      // User ID Scaned, login
define('FRM_PIN',1);          // Passwrod entered
define('FRM_PATIENT_CODE',2); // Patient armabdn scanned

pageMain();

function SessionType(){
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
		<br><form name='input' action='SetSession.php' method='post'>
    <input name='originForm' type='hidden' value='".FRM_PATIENT_CODE."'>
		<input type='text' name='PatientBarcode' autofocus></form></p>";
	/* A Valid user ID has been entered, prompt for a 'pin'
	 * Post:apin
	 */
	} 
  elseif (isset($_SESSION["UserID"])) 
  {
		$htmlpage .= "
    <br><h2>Welcome " . $_SESSION["uFirstName"] . "!</h2>
		<p>Enter your PIN
		<br><form name='input' action='SetSession.php' method='post'><input type='password' name='apin' autofocus>
    <input name='originForm' type='hidden' value='".FRM_PIN."'></form>
		or <a href='logout.php'>return to login</a>";
	/* No session variables of consiquence are set prompt for user name
	 * post:barcode
	 */
	} 
  else 
  {
		$htmlpage .= "
    <p>Please scan your ID now.</p>
		<br><form name='input' action='SetSession.php' onsubmit='return validateForm()' method='post'>
    <input name='originForm' type='hidden' value='".FRM_USER_ID."'>
    <input type='text' name='barcode' autofocus></form>";
	}
  return $htmlpage;
}

function pageMain(){
  session_start();
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
  require_once('common-items.php');

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
    
     SessionType()."
     
    </div>
  </div>";
  echo getTail();
}
?>
