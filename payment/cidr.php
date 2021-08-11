<?



function imask($this)
{
// use base_convert not dechex because dechex is broken and returns 0x80000000 instead of 0xffffffff
return base_convert((pow(2,32) - pow(2, (32-$this))), 10, 16);
}

function imaxblock($ibase, $tbit)
{
while ($tbit > 0)
{
$im = hexdec(imask($tbit-1));
$imand = $ibase & $im;
if ($imand != $ibase)
{
break;
}
$tbit--;
}
return $tbit;
}

function range2cidrlist($istart, $iend)
{
// this function returns an array of cidr lists that map the range given
$s = explode(".", $istart);
// PHP ip2long does not handle leading zeros on IP addresses! 172.016 comes back as 172.14, seems to be treated as octal!
$start = "";
$dot = "";
while (list($key,$val) = each($s))
{
$start = sprintf("%s%s%d",$start,$dot,$val);
$dot = ".";
}
$end = "";
$dot = "";
$e = explode(".",$iend);
while (list($key,$val) = each($e))
{
$end = sprintf("%s%s%d",$end,$dot,$val);
$dot = ".";
}
$start = ip2long($start);
$end = ip2long($end);
$result = array();
while ($end > $start)
{
$maxsize = imaxblock($start,32);
$x = log($end - $start + 1)/log(2);
$maxdiff = floor(32 - floor($x));
$ip = long2ip($start);
if ($maxsize < $maxdiff)
{
$maxsize = $maxdiff;
}
array_push($result,"$ip/$maxsize");
$start += pow(2, (32-$maxsize));
}
return $result;
}


$rstart=$_GET['rs'];
$rend=$_GET['re'];

$result= range2cidrlist($rstart, $rend);

echo "".$result[0]." ".$result[1]." ";

echo " $rstart and $rend";



?>