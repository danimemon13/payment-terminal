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
$fp = fsockopen ($host, 80, $errno, $errstr, 60) or die('Can not open
connection to server.');
if (!$fp) {
echo "$errstr ($errno)<br>\n";
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


if (strpos($ipcountry, 'DCH') !== false) 
    echo "Fishy IP <br> <br> $ipcountry";
else
echo " good ip <br> <br> $ipcountry" ;
?>
