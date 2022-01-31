<?php
//prints header based on '$pagetype', unused future proofing
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

?>
