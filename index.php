<?php

/* File: index.php
 * Auth: N. best
 * date: 11/22
 * desc: Default page, user can enter their ID, Pin and Patient ID/MRN
 * 		 All info is sent to SetSession.php for handling
 * 		 SetSession to be moved into this file at some point
 * 
 */

function SessionType(){
/* called middle of page
 * Produces content based on current login status
 *  e.x. UserID verified, pin vailidated, patient located
 * Varibles passed to SetSeeion change based on what is set in the Session variable already
 */
	echo "<img src='img/logo.png' width='150'>";
	
	/* User is verified with a password, promt for a patient ID
	 * Post:PatientBarcode
	 */ 
	if (isset($_SESSION["UserID"]) && isset($_SESSION["AuthPass"])) {
		echo ("<p><h3>Please scan the Patient ID band<br/> or enter the MRN</h3>");
		echo ("<br><form name='input' action='SetSession.php' method='post'>");
		echo ("<input type='text' name='PatientBarcode' autofocus></form></p>");
	/* A Valid user ID has been entered, prompt for a 'pin'
	 * Post:apin
	 */
	} elseif (isset($_SESSION["UserID"])) {
		echo "<br><h2>Welcome " . $_SESSION["uFirstName"] . "!</h2>";
		echo ("<p>Enter your PIN");
		echo ("<br><form name='input' action='SetSession.php' method='post'><input type='password' name='apin' autofocus></form></p>");
		echo ("or <a href='logout.php'>return to login</a>");
	/* No session variables of consiquence are set prompt for user name
	 * post:barcode
	 */
	} else {
		echo ("<p>Please scan your ID now.</p>");
		echo ("<br><form name='input' action='SetSession.php' onsubmit='return validateForm()' method='post'>" . 
				"<input type='text' name='barcode' autofocus></form>");
	}
}

session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);
require_once('./php/head.php');

?>
<!DOCTYPE html>
<html>
<head>
	<script>
	function validateForm() {
	  let x = document.forms["input"]["barcode"].value;
	  if (x == "") {
		alert("Please Scan a Valid Barcode");
		return false;
	  }
	}
	</script>

	<?php
	  print_head("default");
	?>
</head>
<body>
<?php require('./php/title.php');?>
<div id="ccontainer" class='container' style='height:400px'>
  <div class='vhcenter' style='text-align:center'>
    <?php SessionType(); ?>
  </div>
</div>
<?php include './php/footer.php';?>
</body>
</html>
