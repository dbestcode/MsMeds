<?php 
// File: admin.php
// Main menu for administrator for MsMeds
require('./php/cherry.php');
require_once('./php/head.php');

/*
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
}*/

?>

<html>

<head>
<?php print_head("admin");?>
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

</style>
</head>

<body>
<?php include "./php/title.php" ?>
<!--	<form method="post">
<ul>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><input type="submit" name="ast" value="patients"></a>
    <div class="dropdown-content">
      <a><input type="submit" name="aast" value="patients"></a>
    </div>
  </li>

  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><input type="submit" name="ast" value="drugs"></a>
    <div class="dropdown-content">
      <a><input type="submit" name="aast" value="add"></a>

      <a href="additem.php?table=drugs">Add New Drug</a>
    </div>
  </li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><input type="submit" name="ast" value="users"></a>
    <div class="dropdown-content">
      <a href="additem.php?table=users">Add New User</a>
    </div>
  </li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><input type="submit" name="ast" value="patient_files"></a>
    <div class="dropdown-content">
	<a href="uploadfiles.php">Upload New File</a>
    </div>
  </li>
  <li><a href="logout.php">Logout</a></li>
</ul>
	</form>
-->
<div id="content">
<div id="ccontainer" class='container' style='height:400px;width:800;'>
<h1>Administration Portal</h1>
<a href='../phpmyadmin'><h4>phpMyAdmin</h4></a>(edit paitents, medications, users, other data...)
<!---
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
<p style="text-align:left">
<?php
    /*$tables = array("patients", "users", "drugs", "patient_files","or_report");
    $tablelabels = array("Patients", "System Users", "Medications", "Supplemental Patient Files","IO reports");
    $i=0;
    foreach ($tables as $value) {
        echo "<input type='radio' id='a$value' name='ast' value='$value'>";
        echo "<label for='a$value'>" . $tablelabels[$i] . "</label><br />";
        $i++;
    }*/
?>
</p>
<input type="submit" name="submit" value="View/Edit">
<input type="submit" name="submit" value="Add New Item">
</form>
</p>
<br>-->
</br>or
<a href='uploadfiles.php'><h4>Upload Files/PDFs</h4></a></a>
<br>
</div></div>
<?php include './php/footer.php';?>
</body></html>
