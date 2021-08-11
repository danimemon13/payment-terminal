<?php

	//REQUIRE CONFIGURATION FILE
	require("includes/config.php"); //important file. Don't forget to edit it!

	//REQUIRE SITE HEADER TEMPLATE		
	require "includes/site.header.php"; 
	
	                $fname=$_SESSION["fname"];
                        $lname=$_SESSION["lname"];
                        $address=$_SESSION["address"];
                        $city=$_SESSION["city"];
                        $country=$_SESSION["country"];                      
                        $email=$_SESSION["email"];
                        $phone=$_SESSION["phone"];
                        $state=$_SESSION["state"];
                        $company=$_SESSION["company"];
                        $phone2=$_SESSION["phone2"];
                        $semail=$_SESSION["semail"];
                        $amount=$_SESSION["amount"];
                        $currency=$_SESSION["currency"];
                        $item_description=$_SESSION["item_description"];
                        $statementdescriptor=$_SESSION["statementdescriptor"];
                        $site=$_SESSION["site"];
                        $tw=$_SESSION["tw"];
                        $admin_email=$_SESSION["admin_email"];
                        
$link = mysql_connect('mysql1003.mochahost.com', 'octapay_ustripe', 'P@Str!pe')
    or die('Could not connect: ' . mysql_error());

mysql_select_db('octapay_stripe') or die('Could not select database');

// Performing SQL query
$query = "INSERT INTO octapay_stripe.payment (customer_id, ccname, address, city, country, email, phone, exp1, exp2, firstname, lastname, state, site, date, ip, last4digit,company,gateway, officephone) VALUES ('$email', '$ccname', '$address', '$city', '$country', '$email', '$phone', '$exp1', '$exp2', '$fname', '$lname', '$state', '$statementdescriptor', CURRENT_TIMESTAMP, '$ip', '".$last4."', '$company','paypal', '$phone2')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$sql = mysql_query("INSERT INTO `transaction` VALUES ('','$email','$email','$semail','$amount','$currency','$item_description','$statementdescriptor') ");
   
  if ($_POST['tw']!="0")  					
  include '/home/octapay/public_html/pg/paynow/includes/teamwork/teamwork.php';
                         
      #**********************************************************************************************#
                            #		THIS IS THE PLACE WHERE YOU WOULD INSERT ORDER TO DATABASE OR UPDATE ORDER STATUS.
                            #**********************************************************************************************#

                            #**********************************************************************************************#
                            /******************************************************************
                            ADMIN EMAIL NOTIFICATION
                            ******************************************************************/
                            $headers  = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: '".$statementdescriptor."' <noreply@".$statementdescriptor."> \n";
                            $subject = "New PP Payment Received $amount $currency $company";
                            $message =  "<a href='$teamworkurl'>Team Work project created. Click here to access it</a> <br>New PP payment was successfully received through Stripe.com  Customer ID: ".$customer_id." Last 4 digit $last4 <br />";
                            $message .= "CVC check: $cvcchk0  ".$cvcchk.". Address check: $addrchk0 ".$addrchk.". ZIP CODE check: $zipchk0  ".$zipchk."<br />";
                            $message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: ".(strtolower($currency)=="gbp"?"pound":(strtolower($currency)=="aud"?"AUD":"$")).number_format($amount,2);
                           
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: ".$fname." ".$lname."<br />";
                            $message .= "Email: ".$email."<br />";
                            $message .= "Address: ".$address."<br />";
                            $message .= "City: ".$city."<br />";
                            $message .= "Country: ".$country." <a href='http://www.whatsmyip.org/ip-geo-location/?ip=".$ip."'>".$ip."</a> $ipcountry <br />";
                            $message .= "State/Province: ".$state." Sales person email : ".$semail."<br />";
                            $message .= "ZIP/Postal Code: ".$zip." ".$phone." Office phone $phone2<br />";
                            mail($admin_email,$subject,$message,$headers);
                            if($semail!= "")
                            mail($semail,$subject,$message,$headers);
                   
                        
                        
                        
?>
<div align="center" class="wrapper">
    <div class="form_container">
    	<h1>Thank you!</h1>
            <div id="accordion">
                <p>Thank you for your payment. You will receive confirmation email from us shortly.<br /><br />
                    <a href="index.php">Back To Terminal</a></p>
            </div>
    </div>
</div>
<?php require "includes/site.footer.php"; ?>