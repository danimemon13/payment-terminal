<?php


session_start();

$_SERVER['REMOTE_ADDR']="127.0.0.1";
$_SERVER['HTTP_X_FORWARDED_FOR']="127.0.0.1";

error_reporting(E_ALL ^ E_NOTICE);
require("functions.php"); 


/*********************      new adjustment        **********************************************/
/* jm modificatinos */
$link = mysqli_connect('142.11.200.186', 'estudentarea_crm_user', 'H3()*TilgFd~', 'estudentarea_crm_database');
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$item_description = (!empty($_REQUEST["item_description"])) ? strip_tags(str_replace("'", "`", $_REQUEST["item_description"])) : '';
$query = "select * from invoice where invoice_no='$item_description'";
$result = mysqli_query($link,$query) or die('Query failed: ' . mysqli_error($link));
$row = mysqli_fetch_array($result);
$amount = $row['amount'];
$_SESSION["currency_session"] = $row['currency'];
if($_SESSION["currency_session"])
$currency=$_SESSION["currency_session"];
else
$currency="AUD";
/*********************      new adjustment        **********************************************/

$statementdescriptor="OCTALOGO.COM";
$admin_email="billing@octalogo.com";
$pay1="octalogo@logoscientist.com";


switch ($_REQUEST["site"])
{
case 1:
$statementdescriptor="OCTALOGO.COM";
$admin_email="billing@octalogo.com";
$pay1="octalogo@logoscientist.com";

break;

case 2:
$statementdescriptor="LOGOSCIENTIST.NET";
$admin_email="billing@logoscientist.com";
$pay1=$admin_email;
break;

case 3:
$statementdescriptor="CHAT247LLC.COM";
$admin_email="billing@chat247llc.com";
$pay1=$admin_email;
break;

case 4:
$statementdescriptor="Logo & Web Services";
$admin_email="billing@designquotations.com";
$pay1=$admin_email;
break;

case 5:
$statementdescriptor="APPOCTA.COM";
$admin_email="billing@appocta.com";
$pay1=$admin_email;
break;

case 6:
$statementdescriptor="DESIGNPARAMOUNT.COM";
$admin_email="billing@designparamount.com";
$pay1=$admin_email;
break;

case 7:
$statementdescriptor="LOGOSANCTUARY.COM";
$admin_email="billing@logosanctuary.com";
$pay1=$admin_email;
break;

default:
$statementdescriptor="Payment Hub";
$admin_email="payment@merchantpaymenthub.com";
$pay1=$admin_email;
$customer_notif ='info@merchantpaymenthub.com';
break;
}

/* end*/

//THIS IS TITLE ON PAGES
$title = "".$statementdescriptor."Terminal v1.0"; //site title

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


//service name   |   price  to charge   | Billing period  "Day", "Week", "Month", "Year"   |  how many periods of previous field per billing period | trial period in days | Trial amount
$recur_services = array(
				 array("Service 1 monthly WITH 30 DAYS TRIAL", "49.99", "Month", "1", "30", "24.99"),
				 array("Service 1 monthly", "49.99", "Month", "1", "0", "0"),
				 array("Service 1 quaterly", "149.99", "Month", "3", "0", "0"),
				 array("Service 1 semi-annualy", "249.99", "Month", "6", "0", "0"),
				 array("Service 1 annualy", "349.99", "Year", "1", "0", "0")
				);
				
//IF YOU'RE GOING LIVE FOLLOWING VARIABLE SHOULD BE SWITCH TO true IT WILL AUTOMATICALLY REDIRECT ALL NON-HTTTPS REQUESTS TO HTTPS - MAKE SURE SSL IS INSTALLED ALREADY.
$redirect_non_https = true;
// IF YOU'RE GOING LIVE FOLLOWING VARIABLE SHOULD BE SWITCH TO true
//$liveMode = true;
$liveMode = false;

/* Please note that Stripe.com will accept payments only in your account currency. 
 * You can set your account currency here: https://manage.stripe.com/account
 * A list with Stripe Test Credit Cards Numbers can be found here: https://stripe.com/docs/testing 
 * 
 * */
if(!$liveMode){
//TEST MODE   
define('PublishableKey', 'pk_test_ctiZlzq8wTChq9nMwIwn0Iv4');  //CHANGE THIS
define('SecretKey', 'sk_test_95Q3GKaDHZLJfexsN07TS3fd'); // AND THIS
define('AccountCurrency', $currency); //usd, eur, gbp, aud, cad
define('TEST_MODE', 'TRUE');

} else {
//LIVE MODE
define('PublishableKey', 'pk_live_N2pS7CxmG6S6lVkwbkX46UBs00y4THY3SY'); //CHANGE THIS
define('SecretKey', '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');// AND THIS
define('AccountCurrency', $currency); //usd, eur, gbp, aud, cad
define('TEST_MODE', 'FALSE');
}
date_default_timezone_set("US/Eastern"); // !!!IMPORTANT!!! PLEASE CHANGE THIS TO YOUR TIMEZONE - according to the list from here http://php.net/manual/en/timezones.php
/*******************************************************************************************************
    PAYPAL CONFIGURATION VARIABLES
********************************************************************************************************/
$enable_paypal = true; //shows/hides paypal payment option from payment form.
$paypal_merchant_email = $pay1;
$paypal_success_url = "https://www.octagroup.net/pg/paynow/paypal_thankyou.php";
$paypal_cancel_url = "https://www.octagroup.net/pg/paynow/paypal_cancel.php";
$paypal_ipn_listener_url = "https://www.octagroup.net/pg/paynow/paypal_listener.php";
$paypal_custom_variable = "some_var";
$paypal_currency = $currency;
$sandbox = false; //if you want to test payments with your sandbox account change to true (you must have account at https://developer.paypal.com/ and YOU MUST BE LOGGED IN WHILE TESTING!)
if($liveMode){ $sandbox = false; } else { $sandbox = true; }


//DO NOT CHANGE ANYTHING BELOW THIS LINE, UNLESS SURE OF COURSE
define("PAYMENT_MODE",$payment_mode);
if(!$sandbox){
    define("PAYPAL_URL_STD","https://www.paypal.com/cgi-bin/webscr");
} else {
    define("PAYPAL_URL_STD","https://www.sandbox.paypal.com/cgi-bin/webscr");
}
//DO NOT CHANGE ANYTHING BELOW THIS LINE, UNLESS SURE OF COURSE

if($redirect_non_https){
	if ($_SERVER['SERVER_PORT']!=443) {
		$sslport=443; //whatever your ssl port is
		$url = "http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                header("Location: $url");
		exit();
	}
}
?>