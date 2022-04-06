<div id='lilheader' class='three-col-grid'>
	<div><a href="index.php"><img src="img/logo.png" height=64px style="float:left"></a></div>
	<div><h2 style="text-align:center;font-family:helvetica, serif;">Ms. Meds</h2></div>
	<div style="text-align:right;margin-left:auto;margin-right:0"><?php
if(isset($_SESSION['AuthPass'])){
	echo "Hello " . $_SESSION["uFirstName"] . "!<br>";
	switch($_SESSION["AccessLevel"]){
	    case 2:
	    //faculty
	        echo "<a href='drugs.php' class='abutton'>Student Activity</a>";
	        break;
	    case 3:
	    //Sim Staff view
	        echo "<a href='drugs.php' class='abutton'>Student Activity</a>";
//	        echo "<a href='oper.php' class='abutton'>Surgical Portal</a>";
//	        echo "<a href='setglu.php' class='abutton'>Set Glucose</a>";
	        echo "<a href='admin.php' class='abutton'>Admin Portal</a>";
	        break;
	    case 4:
	    //DEV VIEW
	        echo "<a href='drugs.php' class='abutton'>Student Activity</a>";
	        echo "<a href='ioreport.php' class='abutton'>Surgical Portal</a>";
	        echo "<a href='setglu.php' class='abutton'>Set Glucose</a>";
	        echo "<a href='admin.php' class='abutton'>Admin Portal</a>";
	        break;
	    case 7:
	    //SURG Tech
	        echo "<a href='ioreport.php' class='abutton'>Surgical Portal</a>";
	        break;
	}
	echo "<a href='index.php' class='abutton'>Open Patient</a>";
	echo "<a href='logout.php' class='abutton'>Logout</a>";
}

?></div>
</div>
