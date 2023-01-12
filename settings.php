<?php 
// File: admin.php
// Main menu for administrator for MsMeds

define('LAST_WORK','1/8/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');

// Values for $_POST['originForm']
// Used for detemining what data is being sent
define('FRM_USER_ID',0);      // User ID Scaned, login
define('FRM_PIN',1);          // Passwrod entered
define('FRM_PATIENT_CODE',2); // Patient armabdn scanned

require('./php/cherry.php');
require_once('./common-items.php');

ValidateUser();

if(isset($_POST['ast'])) {
	$_SESSION['activetable']=$_POST['ast'];
	echo $_POST[ast];
	if($_POST['submit']=="View/Edit"){
		header("Location: displaytable.php");
	} else {
		header("Location: additem.php");
	}
} else {
	unset($_SESSION['activetable']);
}

pageMainMenu();

function pageMainMenu(){

echo getHead('Settings',LAST_WORK,'');
/*
	<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a, .dropbtn {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
  background-color: #fa661c;
}

li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #fa661c}

.dropdown:hover .dropdown-content {
  display: block;
}

</style>*/


echo getTitle('');

echo "
<div id='content'>
<div id='ccontainer' class='container' style='height:400px;width:800;'>
<h1>Administration Portal</h1>
<a href='../phpmyadmin'><h4>phpMyAdmin</h4></a>(edit paitents, medications, users, other data...)

<form action=".htmlspecialchars($_SERVER['PHP_SELF'])." method='post'>
<p style='text-align:left'>";

    $tables = array("patients", "users", "drugs", "patient_files","or_report");
    $tablelabels = array("Patients", "System Users", "Medications", "Supplemental Patient Files","IO reports");
    $i=0;
    foreach ($tables as $value) {
        echo "<input type='radio' id='a$value' name='ast' value='$value'>";
        echo "<label for='a$value'>" . $tablelabels[$i] . "</label><br />";
        $i++;
    }
echo "
</p>
<input type='submit' name='submit' value='View/Edit'>
<input type='submit' name='submit' value='Add New Item'>
</form>
</p>
<br>
</br>or
<a href='uploadfiles.php'><h4>Upload Files/PDFs</h4></a></a>
</br>or
<a href='update.php'><h4>Upload Files/PDFs(IN TESTING!!!)</h4></a></a>
<br>
</div></div>".getTail();

}
