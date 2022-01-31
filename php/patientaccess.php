<?PHP 
//added to admin pages to stop people without pass from viewing
if(!isset($_SESSION["UserID"])){
	header("Location: logout.php");
	exit;
}

if(!isset($_SESSION["PatientID"])){
	header("Location: logout.php");
	exit;
}
?>
