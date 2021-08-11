    <?php

session_start();

$link = mysqli_connect('142.11.200.189', 'projectsilos_crm_user', 'H3()*TilgFd~', 'projectsilos_crm_database');
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$_SERVER['REMOTE_ADDR']="127.0.0.1";
$_SERVER['HTTP_X_FORWARDED_FOR']="127.0.0.1";

error_reporting(E_ALL ^ E_NOTICE);
require("functions.php"); 


$item_description = (!empty($_REQUEST["item_description"])) ? strip_tags(str_replace("'", "`", $_REQUEST["item_description"])) : '';
$query = "select * from invoice where invoice_no='$item_description'";

$result = mysqli_query($link,$query) or die('Query failed: ' . mysqli_error($link));

$row = mysqli_fetch_array($result);
if(!empty($row)){
}
else{
    echo "Invalid Invoice No";
    die();
}
$amount = $row['amount'];
$_SESSION["currency_session"] = $row['currency'];
if($_SESSION["currency_session"])
$currency=$_SESSION["currency_session"];
else
$currency="AUD";
/*
$sql2="Select short_code,email,zopim FROM brands WHERE short_code = '".$_GET["brand"]."'";
$result = mysqli_query($link,$sql2) or die('Query failed: ' . mysqli_error($link));
$row2=mysqli_fetch_assoc($result);

$zopim_zendesk = $row2["zopim"];

$statementdescriptor=$row2["short_code"];
$admin_email=$row2["email"];
$pay1=$admin_email;*/
$statementdescriptor="Payment Hub";
$admin_email="payment@merchantpaymenthub.com";
$pay1=$admin_email;
$customer_notif ='info@merchantpaymenthub.com';


//THIS IS TITLE ON PAGES
$title = "".$statementdescriptor." Payment Terminal v1.0"; //site title



//IF YOU NEED TO ADD MORE SERVICES JUST ADD THEM THE SAME WAY THEY APPEAR BELOW.
$services = array(
				  array("Service 1", "49.99"),
				  array("Service 2", "149.99"),
				  array("Service 3", "249.99"),
				  array("Service 4", "349.99"),
			);			
//NOW, IF YOU WANT TO ACTIVATE THE DROPDOWN WITH SERVICES ON THE TERMINAL
//ITSELF, CHANGE BELOW VARIABLE TO TRUE;			
$show_services = false;

// set  to   RECUR  - for recurring payments, ONETIME - for onetime payments
$payment_mode = "ONETIME";


$recur_services = array(
				 array("Service 1 monthly WITH 30 DAYS TRIAL", "49.99", "Month", "1", "30", "24.99"),
				 array("Service 1 monthly", "49.99", "Month", "1", "0", "0"),
				 array("Service 1 quaterly", "149.99", "Month", "3", "0", "0"),
				 array("Service 1 semi-annualy", "249.99", "Month", "6", "0", "0"),
				 array("Service 1 annualy", "349.99", "Year", "1", "0", "0")
				);
				

$redirect_non_https = false;


// IF YOU'RE GOING LIVE FOLLOWING VARIABLE SHOULD BE SWITCH TO true
$liveMode = true;
//$liveMode = false;

if(!$liveMode){
//TEST MODE  


define('PublishableKey', 'pk_test_mBKngEQFDoNMBXa1q0IS4qmu00xLzTIq6n');  //CHANGE THIS
define('SecretKey', 'sk_test_KlYjB3eeyiLQ5WCY61JC4wM300gBGqvFnH'); // AND THIS
define('AccountCurrency', $currency); //usd, eur, gbp, aud, cad
define('TEST_MODE', 'TRUE');

} else {
//LIVE MODE
define('PublishableKey', 'pk_live_N2pS7CxmG6S6lVkwbkX46UBs00y4THY3SY'); //CHANGE THIS
define('SecretKey', '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');// AND THIS
define('AccountCurrency', $currency); //usd, eur, gbp, aud, cad
define('TEST_MODE', 'FALSE');
}
date_default_timezone_set("US/Eastern"); 


if($redirect_non_https){
	if ($_SERVER['SERVER_PORT']!=443) {
		$sslport=443; //whatever your ssl port is
		$url = "http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                header("Location: $url");
		exit();
	}
}
?>