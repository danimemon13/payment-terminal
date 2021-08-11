<?

$ip=$_SERVER['REMOTE_ADDR'];
$key="6C8C63B661";

if($_POST['lname'] =="")
{
$query = "http://api.ip2location.com/?ip=" . $ip . "&key=" . $key;
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

if($ipcountry == "PK")
{
echo "access denied";
exit;
}
}





?>