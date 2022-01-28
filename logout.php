<?php
session_start();
?>
<!DOCTYPE html>
<meta http-equiv="refresh" content="1;url=index.php"> 
<html>
<body>

<?php
if (isset($_GET["msg"])){
	echo $_GET["msg"];
} else {
	echo "You have been logged out.";
}
// remove all session variables
session_unset();
// destroy the session
session_destroy();
//include 'php/footer.php';
?>

</body>
</html>
