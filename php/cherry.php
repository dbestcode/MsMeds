<?PHP 
//added to admin pages to stop people without pass from viewing
session_start();
if($_SESSION["AccessLevel"]==4){
	echo "<a href='admin.php'>RETURN TO ADMIN MENU</a>";
} else if($_SESSION["AccessLevel"]==3){
	echo "<a href='admin.php'>RETURN TO ADMIN MENU</a>";
} else {
	echo "USER NOT AUTHORIZED";
	header("Location: logout.php");
}
?>
