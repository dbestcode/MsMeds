<!DOCTYPE html>
<html>
	
<head>
	<title>
		How to call PHP function
		on the click of a Button ?
	</title>
</head>

<body style="text-align:center;">
	
	<h1 style="color:green;">
		GeeksforGeeks
	</h1>
	
	<h4>
		How to call PHP function
		on the click of a Button ?
	</h4>
	
	<?php
if(isset($_POST['item'])) {
	echo $_POST['item'];
}
		if(array_key_exists('button1', $_POST)) {
			button1();
		}
		else if(array_key_exists('button2', $_POST)) {
			button2();
		}
		function button1() {
			echo "This is Button1 that is selected";
		}
		function button2() {
			echo "This is Button2 that is selected";
		}
	?>

	<form method="post">
		<button type="submit" name="item" class="button" value="1" text="edit">fds</button>
		<input type="submit" name="item" class="button" value="2" />
		<input type="submit" name="item" class="button" value="3" />
		<input type="submit" name="item" class="button" value="4" />
	</form>
</head>

</html>
