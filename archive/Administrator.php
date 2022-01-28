<?php include 'cherry.php';?>

<html>

<head>
	<title>SimMedDispense</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.22" />
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>
	<link rel="stylesheet" href="css/w3mobile.css"> 
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
<div id="ccontainer">
	<div id="ccontainer">
	<div id="header">
		<div id="ccontainer" style="float:left"><img src="img/logo.gif" height=90px style="float:left"></div>
	</div>
	
	</div>
	<div id="ccontainer" style="width:60%; margin:0 auto">
		<div id="lilheader">
		<h1 style="font-size:40px;text-align:center;font-family:helvetica, serif;">Simulation Medication Dispensing System</h1>	
		</div>
<ul>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Patients</a>
    <div class="dropdown-content">
      <a href='DisplayPatients.php?csvfile=patients'>View Patients</a>
      <a href="pdf/?C=N;O=A">MARs</a>
      <a href='AddPatient.php'>Add New Patient</a>

    </div>
  </li>
  
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Drugs</a>
    <div class="dropdown-content">
      <a href="DisplayPatients.php?csvfile=drugs">View Drugs</a>
      <a href="AddDrug.php">Add New Drug</a>
    </div>
  </li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Students</a>
    <div class="dropdown-content">
      <a href="DisplayPatients.php?csvfile=students">View All</a>
    </div>
  </li>
	<li><a href="LoadPDFs.php">Upload MAR Files</a></li>
<li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Data Files</a>
    <div class="dropdown-content">
      <a href="LoadCSVs.php">Upload Data Files</a>
      <a href="./csv/drugs.csv">drugs.csv</a>
      <a href="./csv/patients.csv">patients.csv</a>
      <a href="./csv/students.csv">students.csv</a>
    </div>
  </li>
  <li><a href="logout.php">Logout</a></li>
</ul>			
	<div id="container" >

		<div id="content">
			Remind Nicholai to add some information on how to use this page.<br>

		</div>
		<div id="footer">
		<?php include 'footer.php';?>
		</div>
	</div>
	</div>
</div>
</body>

</html>
