<?

	//REQUIRE CONFIGURATION FILE
	function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
	if($_GET['ip'] =="")
	$ip= getUserIP();
	else
	$ip=$_GET['ip'];
	//deny access if accessing from pk
	
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
$city=$_GET['city'];



if (strpos($ipcountry, 'DCH') !== false) 
{

$array = explode(';', $ipcountry);


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

$subject="ad: $city ,".$_SERVER['HTTP_HOST']." FishyIP $ip ".$array[6]." , ".$array[7]."";

if($iprange!="")
$message_content="Fishy IP <br> $ipcountry<br><br><b><a href='http://ipinfo.io/".$row['asn']."'> Verify these IPs</a></b><br>";
else
$message_content="Fishy IP <br> $ipcountry<br><br><b><a href='http://iplocation.net?query=$ip'> Find the IP Range</a></b><br>";



           $to = "jm@octagroup.net";
            $subject = $subject;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= "From: jabuowais@gmail.com" . "\r\n" .
"Reply-To: jabuowais@gmail.com" . "\r\n" .
"X-Mailer: PHP/" . phpversion();
            $message = "<html><head>" .
                   "<meta http-equiv='Content-Language' content='en-us'>" .
                   "<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>" .
                   "</head><body>" .$message_content.        
                   "<br>".$iprange."<br>http referrer ".$_SERVER['HTTP_REFERER']."<br></body></html>";
          mail($to, $subject, $message, $headers);
$isspam="?lucky&city=$city";

}




header('Location:  /'.$_GET['p'].''.$isspam.'');
exit();

?>