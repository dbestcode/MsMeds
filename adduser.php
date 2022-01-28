<?php 
/*
Page adds new users, currently no ddos protection
*/
session_start();
require_once('./php/head.php');
//if a barcode has not been sent, redirect barcode needed.
if(isset($_GET["barcode"])){
	//vaildidate that the barcode starts with MedId(no currently in use)
	if (strpos($_GET["barcode"], "edId") == 1) {
		$_SESSION["ncode"] = $_GET["barcode"];
	} else {
		//echo "invaild Barcode ID";
		//header("Location: index.php");
	}
} else {
	//echo "<meta http-equiv='refresh' content='1;url=index.php'>";
}

//catch submission
if(isset($_GET['submit'])){
	//$name = $_POST['id'];
	$sql="INSERT INTO ";
	$i=0;
	$feilds="";
	$values="";
 	foreach($_GET as $x =>$x_value){
		echo $i . ": " .$x . "=>" .  $x_value . "<br>";
                if($i==0){
			$sql=$sql . $x_value;
		} elseif($i==1){
			$feilds = $feilds . "id, ";
			$values = $values . "NULL, ";
		} elseif ($i==count($_GET)-3){
			$feilds = $feilds . $x . ", ";
                					//PIN, storing the hash not the pin
			$values = $values . "'" . hash('md5',$x_value) . "', ";
		} elseif ($i==count($_GET)-2){
                	$feilds = $feilds . $x;		//last item, omit comma connting the string
			$values = $values . "'" . $x_value . "'";
		} elseif ($i==count($_GET)-1){
							//sumit value is in the GET array, ignoring so not added to sql stament
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
	echo $result;
	$conn->close();
	header("Location: logout.php");
}

if(isset($_GET["barcode"])){
	if (strpos($_GET["barcode"], "edId") == 1) {//vaildidate that the barcode starts with MedId
	$_SESSION["ncode"] = $_GET["barcode"];
	} else {
		//echo "invaild Barcode ID";
		//header("Location: index.php");
	}
} else {
//	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php print_head("default"); ?>
</head>

<body>
<?php require "./php/title.php" ?>
<div class='container' style="height:500px">
	<div class='vhcenter'>
		<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<H2>Register New User</H2>
		<table>
		<form method='post' action=/additem.php>
		<input type='hidden' name=table value=users>
		<input type='hidden' name='id'>
		<tr><td>FirstName</td><td><input type='text' name='FirstName' autofocus><br></td></tr>
		<tr><td>LastName</td><td><input type='text' name='LastName'><br></td></tr>
		<tr><td>Barcode</td><td><input type='text' readonly='true' name='Barcode' value='<?PHP echo $_GET["barcode"]; ?>'><br></td></tr>
		<tr><td>Pin</td><td><input type='text' name='Pin'><br></td></tr>
		<tr><td>AccessLevel</td><td><input type='text' readonly='true' name='AccessLevel' value='1'><br></td></tr>
		<tr>
		<td><a href='index.php' style='
				  background-color: #20285b;
				  border: none;
				  color: white;
				  padding: 16px 32px;
				  text-decoration: none;
				  margin: 4px 2px;
				  cursor: pointer;
				'>Cancel</a></td>
		<td><input type='submit' name='submit' value='Submit Form'><br></td></tr>
		</table>
		</form>
</div>
</div>
<?php require './php/footer.php';?>
</body>
</html>

