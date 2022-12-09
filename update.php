<?php
/* @file update.php
 * @author nicholai.best@gmail.com
 * @desc adds pdfs to server or deletes old pdfs
 * 
 * @param none
 * @return none
 */
 
// uses $_SESSION['pass']
define('LAST_WORK','12/8/22'); //< --- @date
define('PDF_DIR','./patient_files/');
define('PAGE_TITLE','ECG Simulator');
define('SETTINGS_PASSWORD','simulation');

$target_dir = "patient_files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

/*
 * @file functions.php
 * @includes getHead(title,last work date),getTitle(subheading),getTail
 */
require("functions.php");

/*
//basic debug lines
echo "Startdebug <br>";
echo var_dump($_POST)."<br />Sesson";
session_start();
print_r($_SESSION);
echo " End Debug<br />";
*/

/*
 * @return logout form html
 */
function frmLogout(){
   $formhtml ="
  <form action='".$_SERVER['PHP_SELF']."' method='post'>
    <input type='submit' value='logout' name='logout'>
  </form>
  ";
  return $formhtml;
}
/*
 * @return password form html
 */
function frmPassword(){
  $formhtml="
  <form action='".$_SERVER['PHP_SELF']."' method='post'>
  Enter Password:
  <input type='text' name='sampleText'><br/>
  <input type='submit' value='submit' name='submit'>
  </form>
  ";
  return $formhtml;
}

/*
 * @param string $msg message to be alerted
 * @return a js alert box with $msg as alert text
 */
function JSAlert($msg){
  return "<script>alert('".$msg."');</script>";
}

/*
 * @echos html for list of links to files in ./pdfs
 */
function printLinks(){
	//load array with file names with paths
	$dirContents = array_diff(scandir(PDF_DIR), array('..', '.'));
	
	$gramDir=array();
	$gramName=array();
	//load two arrays with file names striped of '.pdf' and path two file
	foreach ($dirContents as $x){
	  array_push($gramDir,PDF_DIR.$x);
	  array_push($gramName,basename($x, ".pdf"));
	}
	//prints list of links
	for($i=0;$i < count($gramDir);$i++){
	  echo "<p class='grh' onclick='selectGram(".$i.")'>".$gramName[$i]." - <button type='submit' name='fileToDelete' value='".$gramDir[$i]."'>DELETE</button></p>";
	}
}

/*
 * @echos js that holds arrays of the file names
 */
function printjs(){
	//load array with file names and paths
	$dirContents = array_diff(scandir(PDF_DIR), array('..', '.'));
	$i = 0;
	echo"const gramDir = [";
	foreach ($dirContents as $x){
	  //echo "gramDir[".$i."] = '".PDF_DIR.$x."';\n";
	  if ($i === 0){
	    echo "'".PDF_DIR.$x."'";
	  } else {
		  echo ",\n '".PDF_DIR.$x."'";
	  }
	  //echo "gramDir".PDF_DIR.$x."', '");
	  //array_push($gramName,basename($x, ".pdf"));
	  $i++;
	}
	echo "];";

	echo"
  function validateDeletetion() {
    if (!confirm('Delete file?')) {
      alert('Canceled...');
      return false;
    }else{
      return true;
    }
  }
  /*
  * @param i int index of pdf to be viewed
  * @desc sets inner html of id 'gramSpace' to the apriate code to view the pdf
  */
  function selectGram(i){
    //display embeded pdf, button to close and button to return to index
    const linkStart = \"<div class ='boxgram' ><embed style='width:100%;height:90%'src='\";
    const linkEnd = \"'/><button onclick='selectGram(-1)'>close</button></div>\"

    if (i === -1){
      document.getElementById('gramspace').innerHTML = '';
    }else{
    document.getElementById('gramspace').innerHTML = linkStart + gramDir[i] + linkEnd;
    }
  }
  /*
  * @called onclick in selectGram
  * @desc displays text and retirect to index.php
  */
  function sendGram(){
    document.getElementById('all').innerHTML = '<meta http-equiv = \"refresh\" content = \"3; url = index.php\" /><h1>Results Sent! Returning to home screen...</h1><br />If you are not redirected in a few seconds, <a href=\'index.php\'>click here</a>';
  }
  ";
}

/*
 * @return html for top of page
 */
function retHead(){
  $headhtml="
  <!DOCTYPE html>
  <!--
  Files Last Updated:" .LAST_WORK. "
  -->
  <html>
  <head>
  <title>".PAGE_TITLE."</title>
  <link rel='stylesheet' href='css/main.css'>
  <meta http-equiv = 'refresh' content = '300; url = ./index.php' />
  <style>
  .boxgram{
    position:absolute;
    top:0;
    z-index:1020;
    overflow:auto;
    text-align:center;
    width:100%;
    height:100%
  }
  </style>
  <script src=\"js/include.js\"></script>
  </head>
  <body>
  <div id='all'>
  <script>heads();</script>
  <h2 class='cntr'>Manage ECGs</h2>";
  return $headhtml;
}
/* ========================================
 * BEGIN PAGE LOGIC
 * ========================================
 */
session_start();

//logic to load page or show password
if(isset($_POST['logout'])) {
  session_unset();
  header('Location: '.$_SERVER['PHP_SELF']);
  exit;
}
else if(isset($_POST['sampleText']) AND $_POST['sampleText'] == SETTINGS_PASSWORD) //POST password is correct, set SESSION password and load rest of page
{
  $_SESSION['pass']=true;
} 
else if(!isset($_SESSION['pass'])) //SESSON password and POST password not set, only show password form & exit
{
  
  echo retHead().frmPassword();
  exit;
} 

/*
 * If $_POST['file'] is set, delete the file
 */
if(isset($_POST["fileToDelete"])) {
  //echo "nothing deleted, uncomment lines 105-109";
  echo JSAlert("Deleted: ".$_POST["fileToDelete"]);
  $file = fopen($_POST["file"],"w");
  fwrite($file,"Hello World. Testing!");
  fclose($file);
  unlink($_POST["fileToDelete"]);
}

/*
 * If $_POST['fileToUpload'] is set, delete the file
 *
if(isset($_POST['fileToUpload'])){
  echo $_POST['fileToUpload'];
  $target_dir = "pdfs/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  echo basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" && $imageFileType != "pdf" ) {
    echo "Sorry, only PDFs files are allowed."; // not true images can bee as well:JPG, JPEG, PNG & GIF
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    
  }
}*/

/*
 * Check for file upload
 */ 
if(isset($_FILES["fileToUpload"]["name"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  $uploadOk = 1;
    // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br />";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.<br />";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "pdf" ) {
    echo "Sorry, only jpg, jpeg, png & pdf files are allowed.<br />";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br />";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}

/*
 * echo header w/ js printing title
 * call printLinks() for pdfs file links
 * call printjs() for js with arrays of files names
 */

echo getHead(PAGE_TITLE,LAST_WORK)."
<body>
".getTitle("Upload").frmLogout()."
  <h1>Upload Result</h1>
  
  <form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>
    Select image:<br />
    <input type='file' name='fileToUpload' id='fileToUpload'>
    <input type='submit' value='Upload File' name='submit'>
  </form>


  <h1>Results Available:</h1>
  <form method='post' action=".htmlspecialchars($_SERVER["PHP_SELF"])." onsubmit='return validateDeletetion()'>
";

printLinks();

echo"
  </form>
  <div id='gramspace'></div>

  </div>
  <script>
";

printjs();

echo "
  </script>
  </body>
  </html>
";

?>
