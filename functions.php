<?php 

/*
 * @return standard html head
 */
function getHead($title,$lastworked){
  $txthtml="<!DOCTYPE html>
<html>
<!-- 
@date" .$lastworked. "
12 Lead Simulator 

@author nicholai.best@gmail.com
-->
<head>
  <link rel='stylesheet' href='css/main.css'>
  <meta http-equiv='refresh' content='300'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'> 
  <link rel='shortcut icon' type='image/png' href='img/favicon.png'/>
      <title>Ms. Meds</title>
    <meta http-equiv='content-type' content='text/html;charset=utf-8' />
    <meta name='author'	content='Nicholai Best'>
    <meta name='generator' content='nano 4.8' />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <link rel='shortcut icon' type='image/png' href='img/favicon.png'/>
    <link rel='stylesheet' type='text/css' href='css/layout.css'/>
    <link rel='stylesheet' href='css/w3mobile.css'>
  <title>".$title."</title>
  </head>";
  
  /*
  function print_head($pagetype){
  switch ($pagetype) {
  case "basic":
    echo "Your favorite color is red!";
    break;
  default:
    echo  "  <title>Ms. Meds</title>\n";
    echo  "  <meta http-equiv='content-type' content='text/html;charset=utf-8' />\n";
    echo  "  <meta name='author'	content='Nicholai Best'>\n";
    echo  "  <meta name='generator' content='nano 4.8' />\n";
    echo  "  <meta name='viewport' content='width=device-width, initial-scale=1' />\n";
    echo  "  <link rel='shortcut icon' type='image/png' href='img/favicon.png'/>";
    echo  "  <link rel='stylesheet' type='text/css' href='css/layout.css'/>\n";
    echo  "  <link rel='stylesheet' href='css/w3mobile.css'>\n";
  }
}
  */
  return $txthtml; 
}

/*
 * @return footer of page
 */
function getTail(){
  $txthtml="<div class='cntr' style=\'padding:.5em;\'><a class='nav-button' href='https://www.iosimulation.com'>about msmeds-ecg</a></div>";
  return $txthtml;
}

/*
 * @return title bar
 */
function getTitle($subtitle){
//---------------------------------------------
	$txthtml ="<div id='lilheader' class='three-col-grid'>
	<div><a href='index.php'><img src='img/logo.png' height=50px style='float:left'></a></div>
	<div><h2 style='text-align:center;font-family:helvetica, serif;'><a href='index.php' style='text-decoration:none;'>Ms. Meds</a></h2></div>
	<div style='text-align:right;margin-left:auto;margin-right:0'>";

	if(isset($_SESSION['AuthPass'])){
		$txthtml .= "Hello " . $_SESSION["uFirstName"] . "!<br>";
		switch($_SESSION["AccessLevel"]){
			case 2:
			//faculty
				$txthtml .= "<a href='drugs.php' class='abutton'>Student Activity</a>";
				break;
			case 3:
			//Sim Staff view
				$txthtml .= "<a href='drugs.php' class='abutton'>Student Activity</a>";
	//	        $txthtml .= "<a href='oper.php' class='abutton'>Surgical Portal</a>";
	//	        $txthtml .= "<a href='setglu.php' class='abutton'>Set Glucose</a>";
				$txthtml .= "<a href='admin.php' class='abutton'>Admin Portal</a>";
				break;
			case 4:
			//DEV VIEW
				$txthtml .= "<a href='drugs.php' class='abutton'>Student Activity</a>";
				$txthtml .= "<a href='ioreport.php' class='abutton'>Surgical Portal</a>";
				$txthtml .= "<a href='setglu.php' class='abutton'>Set Glucose</a>";
				$txthtml .= "<a href='admin.php' class='abutton'>Admin Portal</a>";
				break;
			case 7:
			//SURG Tech
				$txthtml .= "<a href='ioreport.php' class='abutton'>Surgical Portal</a>";
				break;
		}
		
		

	}
	$txthtml .= "<a href='index.php' class='abutton'>Open Patient</a>";
	$txthtml .= "<a href='logout.php' class='abutton'>Logout</a>";
	$txthtml .= "
	</div>
	</div>";
	return $txthtml;
}
/*
///////////////////////////////////////////////////
  $txthtml="<div class='cntr'>
  <h1>ms.meds - ecg</h1>
  <a href='index.php'><p><img src='img/logo.png'></p></a>
  <p>a simulated ECG machine</p>
  <h2>".$subtitle."</h2></div>";
  return $txthtml;
}

?>
*/
?>
