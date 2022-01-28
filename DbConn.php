<?php
//wraper class for mysqli, has login info and logs each statment run into 'access' table
class DbConn extends mysqli
{
    public function __construct(){
	$servername = "localhost";
        $username = "simlab";
        $password = '$imlab4ever';
        $dbname = "sudo_meds";
        parent::__construct($servername, $username, $password, $dbname);
        if ($this->connect_error) {
            die("Connection failed: " . $this->connect_error);
        }
    }
    public function logquery($command){
	//create log statemtent
        $statement= str_replace("`","",$command);
        $statement= str_replace("'","",$statement);
        $statement="INSERT INTO `access` (`id`, `IP`, `Access_Time`,`Comment`) " . 
            "VALUES (NULL,'" . $_SERVER['REMOTE_ADDR'] .
            "', CURRENT_TIMESTAMP, \"" . $statement . "\")";
//	echo $statement;
	$this->query($statement);
        //run statement
        return $this->query($command);
    }
}


/*
//example code
$dbconn = new DbConn();
$sql="select * from patients";
//echo $sql;
$result = $dbconn->logquery($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
        echo $row["FirstName"];
  }
}
$dbconn->close();
*/
?>
