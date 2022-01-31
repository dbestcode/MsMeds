<?php
session_start();
?>
<!DOCTYPE html >

<head>
	<title>SimMedDispense</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.22" />
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>
	
</head>
<?php
if(isset($_POST["uid"])) {
	$_SESSION["NurseID"] = $_POST["uid"];
}
?>
<body>
	<div id="header">
		<div id="navmenu">
			<ul>
			<li><img src="img\logo.gif" style="float:right" height="50"/></li>
			<li><a href>SimMeDispense</a></li>
			<li><a href=logout.php>logout</a></li>
			</ul>
			
		</div>
	</div>
	<div id="container">
		<div id="content">
			<br>User ID:<?php echo $_SESSION["NurseID"]; ?>
		</div>
		<div id="footer">
			PCHS Simlab | ©2019 Pennsylvania College of Health Sciences | All Rights Reserved 
			<?php 
				echo "<BR>";
				print_r($_SESSION);
			?>
		</div>
	</div>
</body>

</html>
