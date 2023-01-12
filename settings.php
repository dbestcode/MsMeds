<?php 
// File: admin.php
// Main menu for administrator for MsMeds

define('LAST_WORK','1/8/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');

// Values for $_POST['originForm']
// Used for detemining what data is being sent
define('FRM_VIEW_TABLE',0);   // View a table
define('FRM_EDIT_ITEM',1);          // Edit an Item
define('FRM_DEL_ITEM',2); // Delete an item
define('FRM_NEW_ITEM',3); // Delete an item

// Values for $_POST['selectedTable']
define('TBL_PATIENTS',0);
define('TBL_USERS',1);
define('TBL_DRUGS',2);
define('TBL_IO_REPORT',3);


require_once('./common-items.php');

ValidateUser();

//echo $_POST['originForm'] . "-".$_POST['selectedTable'];

if (isset($_POST['originForm'])){
  switch ($_POST['originForm']) {
  case FRM_VIEW_TABLE:
  // What am I?
    pageViewTable();
    exit;
    break;
  case FRM_EDIT_ITEM:
  // What am I?
    pageEditRow();
    exit;
    break;
  case FRM_DEL_ITEM:
  // What am I?
    exit;
    break;
  case FRM_NEW_ITEM:
  // What am I?
    exit;
    break;
  }
} 
else
{
  pageMainMenu();
}

// Display a table
function pageViewTable(){
  
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

  echo getHead('','').getTitle('');

  $conn = ConnectDB();
  //sort based on the table selected
  switch ($_POST["selectedTable"]){
  case TBL_PATIENTS:
    $sql = "SELECT * FROM `patients` ORDER BY `patients`.`LastName` ASC";
    break;
  case TBL_USERS:
    $sql = "SELECT * FROM `users`  \n" . "ORDER BY `users`.`LastName` ASC, `users`.`FirstName` ASC";
    break;
  case TBL_DRUGS:
    $sql = "SELECT * FROM `drugs` ORDER BY `drugs`.`DrugName` ASC";
    break;
  case TBL_IO_REPORT:
    $sql = "SELECT * FROM `patient_files` ORDER BY `patient_files`.`FileName` ASC, `patient_files`.`Label`  DESC";
    break;
  }
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<TABLE class='drug_table'>";
    //load data into 'table[][]'
    $i=0;
    while($row = $result->fetch_assoc()) {
      $table[$i]=$row;
      $i++;
    }
    //count of rows
    echo "<br><h1>TOTAL " . count($table) . "<h1>";
    //List keys and print as table headers
    foreach($table[0] as $x =>$x_value){
      echo "<th>" . $x . "</th>";
      if (!isset($PrimaryKey)){
        $PrimaryKey=$x;
      }
    }
    
    echo "<th>EDIT</th>";

    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>
    <input type='hidden' name='originForm' value='".FRM_EDIT_ITEM."'>
    <input type='hidden' name='selectedTable' value='".$_POST["selectedTable"]."'><br />";
    for($r=0;$r<count($table);$r++){
      echo "<tr>";
      foreach($table[$r] as $x =>$x_value){
        echo tablecell($x_value);
      }
      echo tablecell("<button type='submit' name='itemIndex' value='" . $table[$r][$PrimaryKey] . "' >edit</button>");
      //echo tablecell("<button type='submit' name='deleteitem' value='" . $table[$r][$PrimaryKey] . "' >delete</button>");
      //echo tablecell("<a href=edit.php?table=" . $_SESSION["selectedTable"] ."&id=" . $table[$r][$PrimaryKey] . ">Edit</a>");
      //echo tablecell("<a href=delete.php?table=" . $_SESSION["selectedTable"] ."&id=" . $table[$r][$PrimaryKey] . ">Delete</a>");
      echo "</tr></button>";
    }
    echo "</form></TABLE>";
  } else {
    echo "0 results";
  }
  $conn->close();
  echo getTail();
}
/*

		header("Location: additem.php");

*/


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


echo getTitle('Admin Portal');
echo "<div class='centre'>
<form action=".htmlspecialchars($_SERVER['PHP_SELF'])." method='post'>
  <input type='hidden' name='originForm' value='".FRM_VIEW_TABLE."'><br />
  <button type='submit' id='apatients' name='selectedTable' value='".TBL_PATIENTS."'>Patients</button><br />
  <button type='submit' id='ausers' name='selectedTable' value='".TBL_USERS."'>Users</button><br />
  <button type='submit' id='adrugs' name='selectedTable' value='".TBL_DRUGS."'>Medications</button><br />
  <button type='submit' id='aor_report' name='selectedTable' value='".TBL_IO_REPORT."'>OR Reports</button><br />
</form></div>";
echo getTail();
/*echo "
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
        echo "
        <input type='radio' id='a$value' name='ast' value='$value'>";
        echo "
        <label for='a$value'>" . $tablelabels[$i] . "</label><br />";
        $i++;
    }
echo "
</p>
<input type='submit' name='submit' value='View/Edit'>
<input type='submit' name='submit' value='Add New Item'>
</form>";*/





/*</p>
<br>
</br>or
<a href='uploadfiles.php'><h4>Upload Files/PDFs</h4></a></a>
</br>or
<a href='update.php'><h4>Upload Files/PDFs(IN TESTING!!!)</h4></a></a>
<br>*/


}

function pageEditRow(){
switch ($_POST["selectedTable"]){
  case TBL_DRUGS:
    $strSelectedTable='drugs';
    break;
  case TBL_USERS:
    $strSelectedTable='users';
    break;
  case TBL_PATIENTS:
    $strSelectedTable='patients';
    break;
  case TBL_IO_REPORT:
    $strSelectedTable='io_report';
    break;
}

/*if(isset($_POST['submit']))
{
	$sql="UPDATE ";
	$i=0;
 	foreach($_POST as $x =>$x_value){
                if($i==0){
			$sql=$sql . $x_value . " SET ";
		} elseif($i==1){
			$id=$x_value;
		} elseif($i==2){
                	$sql = $sql . $x . " = '" . $x_value ."' ";
		} elseif ($i==count($_POST)-1){
                	echo "'REMOVED ";
		} else {
                	$sql = $sql . ", " . $x . " = '" . $x_value ."' ";
	                echo "</tr>\n";
		}
		$i++;

        }
	$sql=$sql . "WHERE id=" . $id;
	include ('conn.php');
	$result = $conn->query($sql);
	$conn->close();
	unset($_SESSION["edititem"]);
	header("Location: displaytable.php");
	exit;
}*/


echo getHead('Settings',LAST_WORK,'').getTitle('');

$conn = ConnectDB();

$sql = "SELECT * FROM $strSelectedTable WHERE id=" . $_POST["itemIndex"];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	//load data into 'table[][]'
	$i=0;
	while($row = $result->fetch_assoc()) {
		$table[$i]=$row;
		$i++;
	}
		//List keys and print as table headers
	echo "
  <form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . ">";
	echo "
  <table>";
	echo "<tr>
  ";
	echo tablecell("<input type='hidden' name='selectedTable' value=".$_POST["selectedTable"]."><br>");
  echo tablecell("<input type='hidden' name='itemIndex' value=".$_POST["itemIndex"]."><br>");
	echo "</tr>
  ";
	foreach($table[0] as $x =>$x_value){
//switch based on column, if a file for patient is the column, use a dropdown box (input list)
		switch($x){
		case "id":
			echo "<tr>";
			echo tablecell("<input type='hidden' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
			echo "</tr>\n";
			break;
    case "MarFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
      echo tablecell("<input type='file' name='fileToUpload' id='fileToUpload'>");
			echo "</tr>\n";
			break;
		case "HpFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
      echo tablecell("<input type='file' name='fileToUpload' id='fileToUpload'>");
			echo "</tr>\n";
			break;
		case "OrdersFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "'  style='width:300px'><br>");
      echo tablecell("<input type='file' name='fileToUpload' id='fileToUpload'>");
			echo "</tr>\n";
			break;
		case "ReportFile":
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input list='uploads' name='" . $x . "' value='" . $x_value . "' style='width:300px'><br>");
      echo tablecell("<input type='file' name='fileToUpload' id='fileToUpload'>");
			echo "</tr>\n";
			break;
		default:
			echo "<tr>";
			echo tablecell($x);
			echo tablecell("<input type='text' name='" . $x . "' value='" . $x_value . "'><br>");
			echo "</tr>\n";
		}

	}
	echo "</TABLE>";
	echo "<input type='submit' name='submit' value='Submit Form'></form><br>";
}

$conn->close();

echo getTail();



}

?>