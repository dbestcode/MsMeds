<div id='lilheader' class='three-col-grid'>
	<div><a href="index.php"><img src="img/logo.png" height=64px style="float:left"></a></div>
	<div><h2 style="text-align:center;font-family:helvetica, serif;">Ms. Meds</h2></div>
	<div style="text-align:right;margin-left:auto;margin-right:0"><?php
if(isset($_SESSION['AuthPass'])){
	echo "Hello " . $_SESSION["uFirstName"];
	echo "! <br><a href='logout.php'>Logout</a>";
}
?></div>
</div>
