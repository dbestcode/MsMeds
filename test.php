<?php
$rip= $_SERVER['REMOTE_ADDR'];
$sql="INSERT INTO `access` (`id`, `IP`, `Access_Time`,`Comment`) " .
			"VALUES (NULL,'" . $rip . "', CURRENT_TIMESTAMP, 'tHIS IS A TEST')";
echo $sql;
require "conn.php";
$result = $conn->query($sql);
echo $result;
$conn->close();
?>
