<?

$username = "junaid";
$password = "jdma1979";
$hostname = "junaid.cp06vnakfzku.us-west-2.rds.amazonaws.com"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";





?>