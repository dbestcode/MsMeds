<?PHP 
//added to admin pages to stop people without pass from viewing
session_start();
if($_SESSION["AccessLevel"]!=3){
	echo "USER NOT AUTHORIZED";
	header("Location: logout.php");
} else {
	echo "<a href='admin.php'>RETURN TO ADMIN MENU</a>";
}
?>
