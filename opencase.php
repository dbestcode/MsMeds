<?php
session_start();
//require('php/patientaccess.php');
if(isset($_POST['submit']))
{
	include ('conn.php');
	$sql = "DELETE FROM drug_admins WHERE PatientID=" . $_POST["patient"];
	$result = $conn->query($sql);
	$sql = "DELETE FROM nurse_notes WHERE PatientID=" . $_POST["patient"];
	$result = $conn->query($sql);
	echo $result;
/*$myfile = fopen("txt/" . $_POST["patient"] . ".nur", "w") or die("Unable to open file!");
$txt = "";
fwrite($myfile, $txt);
fclose($myfile);
*/
	if ($_SESSION["AccessLevel"] == 7){
		header("Location: oper.php");
		exit();
	} else {
		header("Location: patient.php");
	}
}
session_start();
require_once('php/head.php');
?>
<!DOCTYPE html>
<html>
<head>
	<?php print_head("default");?>
</head>
<body>
	<?php require('./php/title.php'); ?>
	<div id="ccontainer" >
		<div id="content" style='text-align:center;'>
		<?php
		if (isset($_SESSION["PatientID"])) {
			echo "<h2>Simulation in progress</h2> <br><h3>'" . 
				$_SESSION["pFirstName"] . " " . $_SESSION["pLastName"] . "' "; //. $_SESSION["pDOB"] . " ";
		}
		?> has a session open.  </h3>

		<a href='
		<?php
			if ($_SESSION["AccessLevel"] == 7){
				echo "oper.php";
			} else {
				echo "patient.php";
			}
		?>
		' style='
		  background-color: #20285b;
		  display:inline-block;
		  color: white;
		  padding: 16px 16px;
		  text-decoration: none;
		  text-align:center;
		  width: 150px;'>Continue Case?</a>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		   <input type="hidden" name="patient" value="<?php echo htmlspecialchars($_SESSION['PatientID']) ?>"><br>
		   <input type="submit" name="submit" value="Start New Case?"><br>
		</form>
		<br/><strong>NOTE: 'Start New Case' will clear all progress.</strong><br>
		</div>

	</div>
		<?php include './php/footer.php';?>
</body>
</html>
