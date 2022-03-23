<?php 
/*
Page adds new users, currently no ddos protection
*/
session_start();
// Check vailidity of the barcode
//if a barcode has not been sent, redirect barcode needed.
if(isset($_GET["barcode"])){
  if (strpos($_GET["barcode"], "edId") == 1) { //vaildidate that the barcode starts with MedId
    echo "";
    //$_SESSION["ncode"] = $_GET["barcode"];
  } else {
    echo "<meta http-equiv='refresh' content='1;url=index.php'>";
    echo "<h1>Invaild Barcode ID</h1>";
    exit ();
  }
} else {
  header("Location: index.php");
}

require_once('./php/head.php');
require_once('./php/draw.php');
//catch submission
if(isset($_POST['submit'])){
	//$name = $_POST['id'];
	$sql="INSERT INTO ";
	$i=0;
	$feilds="";
	$values="";
 	foreach($_POST as $x =>$x_value){
                if($i==0){
			$sql=$sql . $x_value;
		} elseif($i==1){
			$feilds = $feilds . "id, ";
			$values = $values . "NULL, ";
		} elseif ($i==count($_POST)-4){
			$feilds = $feilds . $x . ", ";
                					//PIN, storing the hash not the pin
			$values = $values . "'" . hash('md5',$x_value) . "', ";
		} elseif ($i==count($_POST)-2){
                	$feilds = $feilds . $x;		//last item, omit comma connting the string
			$values = $values . "'" . $x_value . "'";
		} elseif ($i==count($_POST)-1){
							//sumit value is in the POSt array, ignoring so not added to sql stament
		} else {
			$feilds = $feilds . $x . ", ";
			$values = $values . "'" . $x_value . "', ";
		}
		$i++;

        }
	$sql= $sql . " (" . $feilds . ") VALUES (" . $values . ")";
	/*echo "<br>" . $sql;
	echo "<br>";
	echo "Feilds:" . $feilds;
	echo "<br>";
	echo "Values" . $values;
	echo $sql;
	*/
	include ('conn.php');
	$result = $conn->query($sql);
//	echo $result;
	$conn->close();
	if ($result == 1){
		echo "<p>You have been added.  Returning to login screen...";
	} else {
		echo "<p>Something went wrong...  Returning to login screen...";
	}
	echo "<meta http-equiv='refresh' content='2;url=index.php'>";
	exit;
}

function print_form(){
	$_POST["authcode"]="SuperSim22";
	if(!(isset($_POST["authcode"]))){
		echo "<form method='post' action='". htmlspecialchars($_SERVER['PHP_SELF']) . "'>";
		echo "<H2>New User Authrization Code:</H2>";
		echo "Please enter your authorization code:<table>";
		echo "<tr><td colspan='2'><input type='password' name='authcode' value='' autofocus><br></td></tr>";
		echo "<input type='hidden' name='barcode' value='" . $_GET['barcode'] . "'><br></td></tr>";
		echo "<tr>";
		echo "<td><a href='index.php' style='background-color: #20285b;border: none; color: white; padding: 16px 32px; text-decoration: none;  margin: 4px 2px; cursor: pointer;'>Cancel</a></td>";
		echo "<td><input type='submit' name='submita' value='Submit Form'><br></td></tr>";
		echo "</table>";
		echo "</form>";
	} else if ($_POST["authcode"]=="SuperSim22"){
		echo "<form name='newuser' method='post' action='". htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return validateNewUser()'>";
		echo "<H2>Register New User</H2>";
		echo "<p>A pin recomeneded but is not required.  If you use no pin your data and your patient's<br/>" .
			 "data will NOT be secure.  You should alway take security precautions using patient data.</p>";
		echo "<table>";
		echo "<form method='post' action=/additem.php>";
		echo "<input type='hidden' name=table value=users>";
		echo "<input type='hidden' name='id'>";
		echo "<tr><td>FirstName</td><td><input type='text' name='FirstName' autofocus><br></td></tr>";
		echo "<tr><td>LastName</td><td><input type='text' name='LastName'><br></td></tr>";
		echo "<tr><td>Pin</td><td><input type='password' name='Pin'><br></td></tr>";
		echo "<tr><td></td><td><input type='hidden' readonly='true' name='Barcode' value='" . $_GET['barcode'] . "'><br></td></tr>";
		echo "<tr><td></td><td><input type='hidden' readonly='true' name='AccessLevel' value='1'><br></td></tr>";
		echo "<tr>";
		echo "<td><a href='index.php' style='background-color: #20285b;border: none; color: white; padding: 16px 32px; text-decoration: none;  margin: 4px 2px; cursor: pointer;'>Cancel</a></td>";
		echo "<td><input type='submit' name='submit' value='Submit Form'><br></td></tr>";
		echo "</table>";
		echo "</form>";

	}else{
		echo "NOT A VALID CODE<br>";
		echo "<meta http-equiv='refresh' content='1;url=index.php'>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php print_head("default"); ?>

<script>
//fuction to make user enter first and last name
function validateNewUser() {
	//grab data from from boxes
	const fn = document.forms["newuser"]["FirstName"].value;
	const ln = document.forms["newuser"]["LastName"].value;
	//const pin = document.forms["newuser"]["Pin"].value;  //can be added
	//verfity they are not empty
	if (fn == "") {
		alert("Enter a first name");
		return false;
	}else if (ln == "") {
		alert("Enter a last name");
		return false;
	}
}
</script>

</head>

<body>
<?php require "./php/title.php" ?>
<div class='container' style="height:500px">
	<div class='vhcenter'>
		<?php print_form(); ?>
	</div>
</div>
<?php require './php/footer.php';?>
</body>
</html>


