<?php
/******************************************************************************
#                      PHP Stripe Payment Terminal v1.3
#******************************************************************************
#      Author:     Convergine.com
#      Email:      info@convergine.com
#      Website:    http://www.convergine.com
#
#
#      Version:    1.3
#      Copyright:  (c) 2013 - Convergine.com
#
#*******************************************************************************/

session_start();

$_SERVER['REMOTE_ADDR']="127.0.0.1";
$_SERVER['HTTP_X_FORWARDED_FOR']="127.0.0.1";


error_reporting(E_ALL ^ E_NOTICE);
require("functions.php"); 


/* jm modificatinos */

if($_GET["currency"])
$_SESSION["currency_session"]=$_GET["currency"];

if($_SESSION["currency_session"])
$currency=$_SESSION["currency_session"];
else
$currency="USD";

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
$statementdescriptor="OCTACHAT.COM";
$admin_email="billing@octachat.com";
$pay1=$admin_email;
break;

default:
$statementdescriptor="OCTALOGO.COM";
$admin_email="billing@octalogo.com";
$pay1="octalogo@logoscientist.com";

break;
}

/* end*/

//THIS IS TITLE ON PAGES
$title = "".$statementdescriptor." Payment Terminal v1.0"; //site title
//THIS IS ADMIN EMAIL FOR NEW PAYMENT NOTIFICATIONS.
//$admin_email = "billing@octalogo.com"; //this email is for notifications about new payments


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
$liveMode = true;

/* Please note that Stripe.com will accept payments only in your account currency. 
 * You can set your account currency here: https://manage.stripe.com/account
 * A list with Stripe Test Credit Cards Numbers can be found here: https://stripe.com/docs/testing 
 * 
 * */
if(!$liveMode){
//TEST MODE   
define('PublishableKey', 'test_publishable_key');  //CHANGE THIS
define('SecretKey', 'test_secretkey'); // AND THIS
define('AccountCurrency', $currency); //usd, eur, gbp, aud, cad
define('TEST_MODE', 'TRUE');

} else {
//LIVE MODE
define('PublishableKey', 'pk_live_pjp4sD70olzzBuOFp8Ni66oL'); //CHANGE THIS
define('SecretKey', 'sk_live_DIEMnrtqGyiplI4GIsvjdab3');// AND THIS
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
		$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		header("Location: $url");
		exit();
	}
}
?>