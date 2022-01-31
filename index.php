<?php
function CheckSession(){
/*called middle of page
Produces content based on current login status
e.x. UserID verified, patient located, Access level etc...*/
	if (isset($_SESSION["UserID"]) && isset($_SESSION["AuthPass"])) {
		//if (isset($_SESSION["PatientID"])) {
				/* Redirect browser */
				//header("Location: patient.php");
				//exit;
		//} else {
			echo "<br><h2>Welcome " . $_SESSION["uFirstName"] . "!</h2>";
			echo ("<p>Please scan or type the Patient ID or MAR");
			echo ("<br><form name='input' action='SetSession.php' method='post'><input type='text' name='PatientBarcode' autofocus></form></p>");
		//}
	} elseif (isset($_SESSION["UserID"])) {
		echo ("<p>Enter your PIN");
		echo ("<br><form name='input' action='SetSession.php' method='post'><input type='password' name='apin' autofocus></form></p>");
		echo ("or <a href='logout.php'>cancel</a>");
	} else {
		echo ("<p>Please scan your ID now.");
		//barcode is ACCTULLY the barcode for the login NOT the UserID from the database
		echo ("<br><form name='input' action='SetSession.php' method='post'><input type='text' name='barcode' autofocus></form></p>");
	}
}

session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);

//if(isset($_POST["barcode"])) {
//	$_SESSION["UserID"] = $_POST["barcode"];
//}
require_once('./php/head.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php 
	print_head("default");
?>
</head>
<body>
<?php require('./php/title.php');?>
	<div id="ccontainer" class='container' style='height:400px'>
	<div class='vhcenter' style='text-align:center'>
		<?php
		/* if (isset($_SESSION["UserID"])) {
			echo "<h5>User: <strong>" . $_SESSION["uFirstName"] . "</strong></h5>";
			echo "<br><a href='logout.php' style='text-align:right;background-color:#fa661c;padding:5px'>Log off</a>";
		}*/
		CheckSession();
		?>
	</div></div>
<!--<div style='position:absolute;bottom:0;width:100%'>-->
<?php include './php/footer.php';?>
-main
</body>
</html>
