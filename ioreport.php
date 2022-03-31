<?php
//require("php/cherry.php");

if(isset($_POST['edititem'])) {
        echo "edit: " . $_POST['edititem'];
	$_SESSION['edititem']=$_POST['edititem'];
	header("Location: edit.php");
}

if(isset($_POST['deleteitem'])) {
        echo "delete: " . $_POST['deleteitem'];
	$_SESSION['deleteitem']=$_POST['deleteitem'];
	header("Location: delete.php");
}

require_once('php/draw.php');
require_once( "php/head.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php print_head("admin");?>
</head>
<body>

<?php
require("php/title.php");
require('conn.php');
//sort based on the table selected

$sql = "SELECT * FROM or_report";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<TABLE ><tr><td>";
	while($row = $result->fetch_assoc()) {
	$i=0;
//	  	    	echo tablerow("<th>Patient</th><th></th>");
		foreach($row as $x =>$x_value){
			switch ($i) {
			  case 10:
			  echo "<h3>---</h3>";
//	  	    	echo tablerow("<th>Times</th><th></th>");
			    break;
			  case 19:
//  		    	echo tablerow("<th></th><th></th>");
			    break;
			  case 30:
//  		    	echo tablerow("<th></th><th></th>");
echo "</td><td>";
			  case 60:
//  		    	echo tablerow("<th></th><th></th>");
echo "</td><td>";
			    break;
			  default:
			}
			if ($i > 1) {
//				echo tablerow(tablecell($x) . tablecell($x_value));
				echo "<br />\n<strong>" . $x . ":</strong>" . $x_value;
			}
			$i++;
		}
	}
} else {
	echo "0 results";
}
echo "</td></tr></table>";
$conn->close();
include "php/footer.php";
?>
</body></html>
