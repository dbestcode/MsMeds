<?php
function CheckSession(){
/*called middle of page
Produces content based on current login status
e.x. UserID verified, patient located, Access level etc...*/
	echo "<img style='border:5px outset #dddddd;padding:10px;' src='img/logo.png' width='200'>";
	if (isset($_SESSION["UserID"]) && isset($_SESSION["AuthPass"])) {
		echo ("<p><h3>Please scan the Patient ID band<br/> or enter the MRN</h3>");
		echo ("<br><form name='input' action='SetSession.php' method='post'>");
		echo ("<input type='text' name='PatientBarcode' autofocus></form></p>");
	/*switch($_SESSION["AccessLevel"]){
		    case 3:
			header("Location: admin.php");
		        break;
		}
		if (isset($_SESSION["PatientID"])) {
				// Redirect browser 
				header("Location: patient.php");
				exit;
		} else {
			echo "<br><h2>Welcome " . $_SESSION["uFirstName"] . "!</h2>";
			echo ("<p>Please scan or type the Patient ID or MAR");
			echo ("<br><form name='input' action='SetSession.php' method='post'><input type='text' name='PatientBarcode' autofocus></form></p>");
		}*/
	} elseif (isset($_SESSION["UserID"])) {
		echo "<br><h2>Welcome " . $_SESSION["uFirstName"] . "!</h2>";
		echo ("<p>Enter your PIN");
		echo ("<br><form name='input' action='SetSession.php' method='post'><input type='password' name='apin' autofocus></form></p>");
		echo ("or <a href='logout.php'>return to login</a>");
	} else {
		echo ("<p>Please scan your ID now.</p>");
		//barcode is ACCTULLY the barcode for the login NOT the UserID from the database
		echo ("<br><form name='input' action='SetSession.php' onsubmit='return validateForm()' method='post'><input type='text' name='barcode' autofocus></form>");
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
    <?php CheckSession(); ?>
  </div>
</div>
<?php include './php/footer.php';?>
</body>
</html>
