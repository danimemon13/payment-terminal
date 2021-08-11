<?php 



$con = mysql_connect("mysql1003.mochahost.com","octapay_ustripe","P@Str!pe") or die(mysql_error());
if(!$con){
    die('Connection Failed'.mysql_error());
}
$con = mysql_select_db("octapay_stripe") or die(mysql_error());




?>