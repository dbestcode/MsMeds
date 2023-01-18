<?php
require('php/cherry.php');
if(isset($_POST['submit']))
{
	include ('conn.php');
	$sql = "DELETE FROM " . $_SESSION["activetable"] . " WHERE id=" . $_SESSION["deleteitem"];
	echo $sql;
	$result = $conn->query($sql);
	//echo $result;
	$conn->close();
	echo "<br><a href='javascript:history.back(2);'>Back</a>";
	header("Location: displaytable.php?table=" . $_POST["table"]);
}
//echo "DELETE FROM " . $_GET["table"] . " WHERE id=" . $_GET["id"];
?>
<html>
<body style="text-align:center">
<h1>ACTION: DELETE RECORD</h1>
<p>WARNING THIS CANNOT BE REVERSED!!!
<?php 
echo "<br>ITEM:" . $_SESSION["deleteitem"];
?>

<br><br>PROCEED?</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
   <input type="submit" name="submit" value="DELETE RECORD?"><br>
</form>

</body>
</html>
