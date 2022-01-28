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

<body>
	<div id="header">
		<div id="navmenu">
			<ul>
			<li><img src="img\logo.gif" style="float:right" height="50"/></li>
			
			
			</ul>
			
		</div>
	</div>
	<div id="container">
		<div id="content">
			<p>Please scan your ID now</p>
			<form name="input" action="setNurse.php" method="get"><input type="text" name="nID" autofocus>
			<?php echo $_SESSION["NurseID"] ?>
		</div>
		<div id="footer">
			PCHS Simlab | ©2019 Pennsylvania College of Health Sciences | All Rights Reserved 
		</div>
	</div>
</body>

</html>
