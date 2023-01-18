<?php 
define('LAST_WORK','1/17/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');

session_start();
/*if (isset($_SESSION["UserID"]) && isset($_SESSION["AuthPass"]) && ($_SESSION["AccessLevel"]!=1)) {
} else {
	header("Location: logout.php");
}*/

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once('./common-items.php');

require_once('./php/head.php');

$extra ="<meta http-equiv='refresh' content='5' >";
echo getHead('Drug Administrations',LAST_WORK,$extra);
  echo getTitle('Drug Administrations');




echo "<a href='index.php'>Home</a>";
$conn = ConnectDB();
//--load drug_admins from database into array 'medorders'
$sql = "SELECT patients.LastName, patients.FirstName ,drug_admins.UserInitals, drug_admins.DrugName, drug_admins.AdminTime,drug_admins.RealTime FROM drug_admins  INNER JOIN patients ON drug_admins.PatientID = patients.id ORDER BY drug_admins.RealTime DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<table class='drug_table'>";
	echo "<tr>";
	echo "<th>Patient</th>";
	echo "<th>Nurse</th>";
	echo "<th>Drug</th>";
	echo "<th>Sim time given</th>";
	echo "<th>Real time given</th>";
	echo "</tr>\n";
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo tablecell($row["FirstName"] . " " .$row["LastName"]);
		echo tablecell($row["UserInitals"]);
		echo tablecell($row["DrugName"]);
		echo tablecell($row["AdminTime"]);
		echo tablecell($row["RealTime"]);
		echo "</tr>\n";
	}
	echo "</table>";

} else {
	echo "<table id='drug_table' style='width:80%'>";
	echo "<tr>";
	echo "<th>Time given</th>";
	echo "<th>Drug</th>";
	echo "<th>Nurse</th>";
	echo "</tr>\n<tr>";
	echo tablecell("---") . tablecell("No medications have been administered yet."). tablecell("---");
	echo "</tr>\n";
	echo "</table>";
}
$conn->close();
require "php/footer.php";
?>
</body></html>
