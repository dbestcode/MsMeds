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
  <title>".$title."</title>
  </head>";
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
  $txthtml="<div class='cntr'>
  <h1>ms.meds - ecg</h1>
  <a href='index.php'><p><img src='img/logo.png'></p></a>
  <p>a simulated ECG machine</p>
  <h2>".$subtitle."</h2></div>";
  return $txthtml;
}

?>
