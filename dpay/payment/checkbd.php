<?



    					
$link = mysql_connect('mysql1003.mochahost.com', 'octapay_ustripe', 'P@Str!pe')
    or die('Could not connect: ' . mysql_error());

mysql_select_db('octapay_stripe') or die('Could not select database');


/*
// Performing SQL query
$query = "INSERT INTO octapay_stripe.payment (customer_id, ccname, address, city, country, email, phone, exp1, exp2, firstname, lastname, state, site, date, ip, last4digit,company,gateway, officephone) VALUES ('$customer_id', '$ccname', '$address', '$city', '$country', '$email', '$phone', '$exp1', '$exp2', '$fname', '$lname', '$state', '$statementdescriptor', CURRENT_TIMESTAMP, '$ip', '".$last4."', '$company','Stripe', '$phone2')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$sql = mysql_query("INSERT INTO `transaction` VALUES ('','$customer_id','$email','$semail','$amount','$currency','$item_description','$statementdescriptor') ");


*/



// Make a MySQL Connection
$query = "SELECT * FROM octapay_stripe.payment where country='au' and  ipcheck != '' ;"; 
	 
$result = mysql_query($query) or die(mysql_error());

$iprange="";

while($row = mysql_fetch_array($result)){
	
	






	$ip=$row['ip'];
	//deny access if accessing from pk
/*	
$key="6C8C63B661";


$query = "http://api.ip2location.com/?ip=" . $ip . "&key=" . $key."&package=WS23";
$url = parse_url($query);
$host = $url["host"];
$path = $url["path"] . "?" . $url["query"];
$fp = @fsockopen ($host, 80, $errno, $errstr, 60) or die('Can not open
connection to server.');
if (!$fp) {
//echo "$errstr ($errno)<br>\n";
} else {
fputs ($fp, "GET $path HTTP/1.0\r\nHost: " . $host .
"\r\n\r\n");
while (!feof($fp)) {
$tmp .= fgets ($fp, 128);
}
$array = split("\r\n", $tmp);
$ipcountry = $array[count($array)-1];
fclose ($fp);
}
*/

$ipcountry=$row['ipcheck'];

$data1 = mysql_query("SELECT * FROM octapay_stripe.transaction WHERE email = '".$row['email']."';");
if (!$data1) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row1 = mysql_fetch_array($data1);



if (strpos($ipcountry, 'DCH') !== false) 
{

$array = explode(';', $ipcountry);




echo "<br><br><br><b>badIP ".$row['ip']."<br> $ipcountry<br>".$row['country']."<br>".$row['firstname']."".$row['lastname']."<br> ".$row['company']."<br>".$row['site']."<br> ".$row['state']." <br>".$row['address']." <br>".$row['city']."<br>".$row1['amount']."".$row1['currency']." ".$row['email']." </b>";

//mysql_query("update octapay_stripe.payment set badip=1 , ipcheck='$ipcountry' where customer_id='".$row['customer_id']."'");


/*

if(0)
{
$username = "asn";
$password = "asnip";
$hostname = "166.62.28.111"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or $error=1;


mysql_select_db('asnip');

// Make a MySQL Connection
$query = "SELECT * FROM asn where ascode ='".$array[6]."';"; 
	 
$result = mysql_query($query) or die(mysql_error());

$iprange="";

while($row = mysql_fetch_array($result)){
	$iprange  .="".$row['cidr']."\n\n<br>";
	
}
}

*/
}
else
{




echo "<br><br><br>Good ip ".$row['ip']."<br> $ipcountry<br>".$row['ipcheck']."<br>".$row['firstname']."".$row['lastname']."<br> ".$row['company']." <br>".$row['site']."<br> ".$row['state']." <br>".$row['address']." ".$row['city']."<br>".$row1['amount']."".$row1['currency']."";


//mysql_query("update octapay_stripe.payment set badip=0 , ipcheck='$ipcountry' where customer_id='".$row['customer_id']."'");

}


}

?>