<?PHP
/* @desc basically 'functions.php
 * common functions which are used on many pages
 */
function getHead($title,$lastworked,$extrahtml=""){
  $txthtml="
<!DOCTYPE html>
<html>
<!-- 
@date " .$lastworked. "
Simulated Devices
@author nicholai.best@gmail.com
-->

<head>
  <meta http-equiv='content-type' content='text/html;charset=utf-8' />
  <meta name='author'	content='Nicholai Best'>
  <meta name='generator' content='geany 1.27' />
  <meta name='viewport' content='width=device-width, initial-scale=1' />
  <link rel='shortcut icon' type='image/png' href='img/favicon.png'/>
  <link rel='stylesheet' type='text/css' href='css/layout.css'/>
  
  <link rel='stylesheet' href='css/main.css'>
  <link href='https://fonts.googleapis.com/css?family=Press Start 2P' rel='stylesheet'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'> 
  <link rel='shortcut icon' type='image/png' href='img/favicon.png'/>
  <title>".$title."</title>".$extrahtml."
</head>";
  return htmlComment('head',$txthtml); 
}

//from <body> to end of top meneu of page, used on all pages
function getTitle($subtitle){
  $titlehtml = "
<body>
<div id='lilheader' class='three-col-grid'>
  <div><a href='index.php'><img src='img/logo.png' height=50px style='float:left'></a></div>
  <div>
    <h2 class='retro-font centre'><a href='index.php' style='text-decoration:none;'>Ms. Meds</a></h2>
  </div>
  <div style='text-align:right;margin-left:auto;margin-right:0;' class='top-nav-font'>";

  if(isset($_SESSION['AuthPass'])){
    $titlehtml .= "Hello " . $_SESSION["uFirstName"] . "!<br>";
    switch($_SESSION["AccessLevel"]){
        case 2:
        //faculty
            $titlehtml .= "<a href='drugs.php' class='abutton'>Student Activity</a>";
            break;
        case 3:
        //Sim Staff view
            $titlehtml .= "<a href='drugs.php' class='abutton'>Student Activity</a>";
  //	        $titlehtml .= "<a href='oper.php' class='abutton'>Surgical Portal</a>";
            $titlehtml .= "<a href='settings.php' class='abutton'>Admin Portal</a>";
            break;
        case 4:
        //DEV VIEW
            $titlehtml .= "
            <a href='drugs.php' class='abutton'>Student Activity</a>
            <a href='ioreport.php' class='abutton'>Surgical Portal</a>
            <a href='settings.php' class='abutton'>Admin Portal</a>";
            break;
        case 7:
        //SURG Tech
            $titlehtml .= "<a href='ioreport.php' class='abutton'>Surgical Portal</a>";
            break;
    }
    $titlehtml .= "<a href='index.php' class='abutton'>Open Patient</a>
    <a href='logout.php' class='abutton'>Logout</a>";
    
  }
$titlehtml .= "
  </div>
</div>
<div class='centre'><h3>".$subtitle."</h3></div>";

  return htmlComment('title',$titlehtml);

  
}

/* @return HTML for page footer*/
function getTail(){
  $txthtml = "
  <div class='four-col-grid'>
  <div><!--Written by Nicholai Best, nicholai.best@gmail.com--></div>
  <div class='center-col'>
    <p style='text-align:center'>MsMeds v1.1 ©2023 All Rights Reserved | <a href='https://www.iosimulation.com'>iosimulation.com</a></p>
  </div>
  <div>";
/* NEVER UNCOMMENT UNLESS DEBUGING!!!!! Major Security Threat
 
foreach ($_SESSION as $key=>$val){
echo $key." ".$val."<br/>";
}
*/
 
  $txthtml .="
</body>
</html>";
  return htmlComment('tail',$txthtml);
}

//-------------basic function for html saving-----------
//@returns html for common page items
function htmlComment($sectionTitle,$htmlTxt)
{
  $txthtml = "\n<!-- BEGIN ".$sectionTitle." -->";
  $txthtml .= $htmlTxt;
  $txthtml .= "\n<!-- END ".$sectionTitle." -->";
  return $txthtml;
}

//return a random string of the legnth in param
function randomString($strlength)
{
    
		//$a='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $a='0123456789';
		$res='';
		for($i = 0; $i<$strlength; $i++)
		{
			$res.=$a[mt_rand(0,strlen($a)-1)];
		}
		return $res;
}

//various table tag wrapping
function tablecell($celldata) {
	return "<td>".$celldata."</td>";
}
function tablerow($celldata) {
	return "
  <tr>".$celldata."</tr>";
}
function tablehead($celldata) {
	return "
  <th>".$celldata."</th>";
}
function html_heading($celldata,$size) {
	return "
  <h" . $size . ">".$celldata."</h" . $size  . ">";
}

//connects to the sudo_meds DB, used on most pages
function ConnectDB(){
  $servername = "localhost";
  $username = "simlab";
  $password = "Icould$1mallday!";
  $dbname = "sudo_meds";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } else {
    return $conn;
  }
}

//validate admin creds
function ValidateUser(){
  // if clearance is high enough and they have correctly enterd a pin proceed
  // other wise settings pages do not display
  if ($_SESSION["AuthPass"]=54792390) {
    if (($_SESSION["AccessLevel"]==4) || ($_SESSION["AccessLevel"]==3)) {
      return;
    } else {
      echo "USER NOT AUTHORIZED";
      header("Location: logout.php");
    }
  } else {
    echo "USER NOT AUTHORIZED";
    header("Location: logout.php");
  }
}

function JSAlert($msg){
  return "<script>alert('".$msg."');</script>";
}

function printDebug($debugOn,$altContent=''){
  if($debugOn){
    echo "DEBUG ON<br/>";
    if ($altContent == ''){
      echo '<H3>POST:</H3>';
      foreach($_POST as $x =>$x_value){
        echo $x . " - " . $x_value . "<br>";
      }
      echo '<H3>SESSION:</H3>';
      foreach($_SESSION as $x =>$x_value){
        echo $x . " - " . $x_value . "<br>";
      }    
    } else {
      echo $altContent;
    }
  }
}
?>
