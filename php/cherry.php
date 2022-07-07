<?PHP 
// file: cherry.php
// added toany  admin pages to stop unauthrized access
session_start();
// if clearance is high enough and they have correctly enterd a pin proceed
// other wise admin pages do not display
if ($_SESSION["AuthPass"]=54792390) {
	if (($_SESSION["AccessLevel"]==4) || ($_SESSION["AccessLevel"]==3)) {
		echo "";
	} else {
		echo "USER NOT AUTHORIZED";
		header("Location: logout.php");
	}
} else {
	echo "USER NOT AUTHORIZED";
	header("Location: logout.php");
}
?>
