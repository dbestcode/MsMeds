<?php 
// File: admin.php
// Main menu for administrator for MsMeds

define('LAST_WORK','1/17/2023'); //< --- @date
define('PAGE_TITLE','Ms.Meds - EHR');
define('PROJECT_VERSION','1.1');

define('PDF_DIR','./patient_files/');

// Values for $_POST['originForm']
// Used for detemining what data is being sent
define('FRM_VIEW_TABLE',0);   // View a table
define('FRM_SELECT_ITEM',1);  // Edit an Item
define('FRM_UPDATE_ITEM',2);  // Edit an Item
define('FRM_DEL_ITEM',3);     // Delete an item
define('FRM_NEW_ITEM',4);     // New item
define('FRM_NEW_DOC',5);      // New document upload
define('FRM_DEL_DOC',6);      // Delete Document upload


// Values for $_POST['selectedTable'] i.e. the table names in the DB
define('TBL_PATIENTS','patients');
define('TBL_USERS','users');
define('TBL_DRUGS','drugs');
define('TBL_IO_REPORT','io_report');
define('TBL_PATIENT_FILES','patient_files');

/* Basically any generic function 
 * 
 * getHead
 * getTitle
 * getTail
 * table*
 * ConnectDB
 */
require_once('./common-items.php');
ValidateUser();

$updatemessage = '';
if (isset($_POST['originForm'])){
  switch ($_POST['originForm']) {
  case FRM_VIEW_TABLE:
  // view whole datatable
    pageViewTable();
    exit;
    break;
  case FRM_SELECT_ITEM:
  // View a single record in a datatable
    pageSelectItem($updatemessage);
    exit;
    break;
  case FRM_UPDATE_ITEM:
  // alter a record in a datatable
    UpdateRow($updatemessage);
    pageSelectItem($updatemessage);
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
  case FRM_DEL_DOC:
  // What am I?
    delDocument($updatemessage);
    pageSelectItem($updatemessage);
    exit;
    break;
  case FRM_NEW_DOC:
    newDocument($updatemessage);
    pageSelectItem($updatemessage);
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
  
  if(isset($_POST['deleteitem'])) {
          echo "delete: " . $_POST['deleteitem'];
    $_SESSION['deleteitem']=$_POST['deleteitem'];
    header("Location: delete.php");
  }

  echo getHead('','').getTitle('');

  $conn = ConnectDB();
  // sort based on the table selected, YES this could be single statement
  // BUT each table need a different sort... so why !?
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
    <input type='hidden' name='originForm' value='".FRM_SELECT_ITEM."'>
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


function pageMainMenu(){
  echo getHead('Settings',LAST_WORK,'');
  echo getTitle('Admin Portal');
  echo "
<div class='centre'>
  
  <form action=".htmlspecialchars($_SERVER['PHP_SELF'])." method='post'>
  <h3>Edit Table</h3>
    <input type='hidden' name='originForm' value='".FRM_VIEW_TABLE."'><br />
    <button class = 'abutton' type='submit' id='apatients' name='selectedTable' value='".TBL_PATIENTS."' style='width:150px;'>Patients</button><br />
    <button class = 'abutton' type='submit' id='adrugs' name='selectedTable' value='".TBL_DRUGS."' style='width:150px;'>Medications</button><br />
    <button class = 'abutton' type='submit' id='ausers' name='selectedTable' value='".TBL_USERS."' style='width:150px;'>Users</button><br />";
    //<button class = 'abutton' type='submit' id='aor_report' name='selectedTable' value='".TBL_IO_REPORT."'>OR Reports</button><br />
    echo"
    </form>
</div>";
  echo getTail();
}

function pageSelectItem(&$msg){

  echo getHead('Settings',LAST_WORK,'').getTitle('');
  echo "
  <div class='middle-col-grid'>
    <div></div>
    <div>";
  $conn = ConnectDB();

  $sql = "SELECT * FROM ".$_POST["selectedTable"]." WHERE id=" . $_POST["itemIndex"];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    //load data into 'table[][]'
    $i=0;
    while($row = $result->fetch_assoc()) {
      $table[$i]=$row;
    }
      //List keys and print as table headers
    echo "
    <form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . " enctype='multipart/form-data'>";
    echo "
    <table>";
    echo "<tr>
    ";
    echo tablecell("<input type='hidden' name='selectedTable' value=".$_POST["selectedTable"]."><br>");
    echo tablecell("<input type='hidden' name='originForm' value='".FRM_UPDATE_ITEM."'><br />");
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
      case "HpFile":
      case "OrdersFile":
      case "ReportFile":
        echo "<tr>";
        echo tablecell($x.": ");
        echo tablecell("<a href='".PDF_DIR.$x_value . "' target='_blank'>$x_value</a>");
        echo tablecell("<input type='file' name='$x' id='$x'>");
        echo "</tr>\n";
        break;
      case "Pin":
      //hide the hash or password
        echo "<tr>";
        echo tablecell($x.": ");
        echo tablecell("<input type='password' name='" . $x . "' value='" . $x_value . "'><br>");
        echo "</tr>\n";
        break;
      case "AccessLevel":
        echo "<tr>";
        echo tablecell($x.": ");
        echo tablecell("<input type='text' name='" . $x . "' value='" . $x_value . "' disabled><br>");
        echo "</tr>\n";
        break;
      default:
        echo "<tr>";
        echo tablecell($x.": ");
        echo tablecell("<input type='text' name='" . $x . "' value='" . $x_value . "'><br>");
        echo "</tr>\n";
      }

    }
    echo "
    </TABLE>
    <input type='submit' name='submit' value='Update'></form>$msg";
  }

  $conn->close();
  
  if ($_POST["selectedTable"]==TBL_PATIENTS){
    // Display misc lab files uploaded
    $conn = ConnectDB();
    $sql = "SELECT * FROM patient_files WHERE PatientID=" . $_POST["itemIndex"];
    $result = $conn->query($sql);
    echo "<form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . " enctype='multipart/form-data'>
    <input type='hidden' name='selectedTable' value=".$_POST["selectedTable"]."><br>
    <input type='hidden' name='originForm' value='".FRM_DEL_DOC."'><br />
    <input type='hidden' name='itemIndex' value=".$_POST["itemIndex"]."><br>";
    
    echo "
    <h3>Labs, Radiology, Misc Docs</h3>
    <table class='drug_table'>
      <tr><th>Documents</th><th></th></tr><tr><td></td><td></td></tr>";
    
    
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo tablecell("<a href='patient_files/" . $row["FileName"] . "' target='_blank'>" . $row["Label"] . "</a>");
      echo tablecell("<button type='submit' name='fileIndex' value='" . $row['id'] . "' >DELETE</button>");
      echo "</tr>\n";
    }
    echo "</form>
    </table>
    ";
    echo "<form method='post' action=". htmlspecialchars($_SERVER['PHP_SELF']) . " enctype='multipart/form-data'>";
    echo "<input type='hidden' name='selectedTable' value=".$_POST["selectedTable"]."><br>";
    echo "<input type='hidden' name='originForm' value='".FRM_NEW_DOC."'><br />";
    echo "<input type='hidden' name='itemIndex' value=".$_POST["itemIndex"]."><br>";
    echo"
    <h3>Add Document</h3>
    
    Label for Document:<input type='text' name='doclabel'><BR/>
    <input type='file' name='newDoc' id='newDoc'><BR/>
    <input type='submit' name='submit' value='Add Document'>
    </form>";

    $conn->close();
  }

  echo "
  </div>
  <div></div>
  </div>";
  echo getTail();
}

function newDocument(&$msg){
  echo 'Post:<br>';
  foreach($_POST as $x =>$x_value){
    echo $x . " - " . $x_value . "<br>";
  }
 
  if (basename($_FILES["newDoc"]["name"]) != '') // form sent no file, use what is in the database
  {
    $target_file = PDF_DIR . basename($_FILES["newDoc"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    $check = getimagesize($_FILES[$x]["tmp_name"]);
    $uploadOk = 1;
    // Check file size
    if ($_FILES["newDoc"]["size"] > 500000) {
      $msg = "Sorry, your file is too large.<br />";
      $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && 
      $imageFileType != "png" && 
      $imageFileType != "jpeg" && 
      $imageFileType != "pdf" ) 
    {
      $msg = "Sorry, only jpg, jpeg, png & pdf files are allowed.<br />";
      $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $msg = "Sorry, your file was not uploaded.<br />";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["newDoc"]["tmp_name"], $target_file)) {
        $msg = htmlspecialchars(basename( $_FILES["newDoc"]["name"])). " has been uploaded.";
        $conn = ConnectDB();
        $sql = "INSERT INTO ".TBL_PATIENT_FILES." (id,PatientID,Label,FileName) VALUES (NULL, '" . 
        $_POST["itemIndex"] . "', '" . $_POST["doclabel"] ."', '" .  
        basename($_FILES["newDoc"]["name"]) . "')";
        $result = $conn->query($sql);
        $conn->close();
      } else {
        $msg = "Sorry, there was an error uploading your file.";
      }
    }    
  }
}

function delDocument(&$msg){
  $conn = ConnectDB();
  $sql = "SELECT * FROM ".TBL_PATIENT_FILES." WHERE id=" . $_POST["fileIndex"];
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $sql = "DELETE FROM ".TBL_PATIENT_FILES." WHERE id=" . $_POST["fileIndex"];
  $result = $conn->query($sql);
  $conn->close();
  unlink(PDF_DIR . $row['FileName']);
  $msg = JSAlert("Deleted: ".$row['FileName']);
}

function UpdateRow(&$msg){
  //get the table row to be updated
  $msg="updated!";
  $conn = ConnectDB();
  $sql = "SELECT * FROM ".$_POST["selectedTable"]." WHERE id=" . $_POST["itemIndex"];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) 
  {
    $TableRow = $result->fetch_assoc();
  } 
  else
  {
    echo "DATABASE ERROR";
    exit();
  }
  
  // only used if a patient is edited
  foreach($_FILES as $x =>$x_value){
    // check for blank file submission for each pdf
    // if so dont update the value 
    
    if (basename($_FILES[$x]["name"]) != '') // form sent no file, use what is in the database
    {
      $target_file = PDF_DIR . basename($_FILES[$x]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      if(isset($_FILES[$x]["name"])) {
        $check = getimagesize($_FILES[$x]["tmp_name"]);
        $uploadOk = 1;
        // Check file size
        if ($_FILES[$x]["size"] > 500000) {
          echo "Sorry, your file is too large.<br />";
          $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && 
          $imageFileType != "png" && 
          $imageFileType != "jpeg" && 
          $imageFileType != "pdf" ) 
        {
          echo "Sorry, only jpg, jpeg, png & pdf files are allowed.<br />";
          $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.<br />";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES[$x]["tmp_name"], $target_file)) {
            $sqlfiles .=", " . $x . " = '" . basename($_FILES[$x]["name"]) ."'";
            //echo "The file ". htmlspecialchars( basename( $_FILES[$x]["name"])). " has been uploaded.";
            
            //$file = fopen(PDF_DIR . $TableRow[$x],"w");
            //fwrite($file,"Hello World. Testing!");
            //fclose($file);
            // Delete the old file
            unlink(PDF_DIR . $TableRow[$x]);
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
      }
    }
  }

  //beging consrtuing sql statment to update the record
	$sql="UPDATE ".$_POST["selectedTable"] . " SET ";
	$i=0;
 	foreach($_POST as $x =>$x_value){
    // Password can be updated
    // if it doesnt equal the current hash, rehash sent data and store hash.
    if ($x == 'Pin'){
      if ($TableRow['Pin'] != $x_value){
        $x_value = hash('md5',$x_value);  
      }
    } 
    if($i==0){
    } elseif ($i==count($_POST)-1){ //skip all these as they info about table and form
    } elseif($i==1){
    } elseif($i==2){
    } elseif($i==3){
    } elseif($i==4){
      $sql .= $x . " = '" . $x_value ."' ";
    } else {
      $sql .= ", " . $x . " = '" . $x_value ."'";
    }
    $i++;
  }
	$sql .= $sqlfiles . " WHERE id = " . $_POST["itemIndex"];

  $result = $conn->query($sql);
	$conn->close();
  //INSERT INTO `patients` (`id`, `FirstName`, `LastName`, `Barcode`, `DOB`, `Immortal`, `Provider`, `MarFile`, `HpFile`, `OrdersFile`, `ReportFile`) 
  //                VALUES (NULL, 'name', 'name', '5435943', '01/23/1059', 'a', 'Aldo Castaneda M.D.', 'blank.pdf', 'blank.pdf', 'blank.pdf', 'blank.pdf')
  
  //UPDATE `patients` SET `FirstName` = 'Juanita1', `LastName` = 'Ibarraa',
  //       `Barcode` = '84956224d', `DOB` = '1242', `HpFile` = 'd', `OrdersFile` = 's' WHERE `patients`.`id` = 23 
}
?>
