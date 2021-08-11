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
$province = str_replace("-AU-", "", $state);

$sMessageResponse = '';
$phone=$_REQUEST['phone'];

	# PLEASE DO NOT EDIT FOLLOWING LINES IF YOU'RE NOT SURE ------->
        if ($show_services) {
            if($payment_mode=="RECUR"){
                $amount = number_format($recur_services[$service][1], 2,".","");
            } else {
                $amount = number_format($services[$service][1], 2,".","");
            }
            $item_description = $services[$service][0];
        } else {
            $amount = number_format($amount,2,".","");
        }
        $amount = str_replace(",","",$amount);

		$continue = false;
		if(!empty($amount) && is_numeric($amount)){ 	
			$cctype = (!empty($_POST['cctype']))?strip_tags(str_replace("'","`",strip_tags($_POST['cctype']))):'';
			$ccname = (!empty($_POST['ccname']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccname']))):'';
			//$ccn = (!empty($_POST['ccn']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccn']))):'';
			//$exp1 = (!empty($_POST['exp1']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp1']))):'';
			//$exp2 = (!empty($_POST['exp2']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp2']))):'';
			//$cvv = (!empty($_POST['cvv']))?strip_tags(str_replace("'","`",strip_tags($_POST['cvv']))):'';
$ipcountry= $_POST['ipcountry'];			
/*			
            if($cctype!="PP"){
                //CREDIT CARD PHP VALIDATION
                if(empty($ccn) || empty($cctype) || empty($exp1) || empty($exp2) || empty($ccname) || empty($cvv) || empty($address) || empty($state) || empty($city)){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Not all required fields were filled out.</p></div></div><br />';
                } else { $continue = true; }

                if(!is_numeric($cvv)){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> CVV number can contain numbers only.</p></div></div><br />';
                } else {
                    $continue = true;
                }

                if(!is_numeric($ccn)){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Credit Card number can contain numbers only.</p></div></div><br />';
                } else {
                    $continue = true;
                }

                if(date("Y-m-d", strtotime($exp2."-".$exp1."-01")) < date("Y-m-d")){
                    $continue = false;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Your credit card is expired.</p></div></div><br />';
                } else {
                    $continue = true;
                }

                if($continue){
                    //echo "1";
                    if(validateCC($ccn,$cctype)){
                        $continue = true;
                    } else {
                        $continue = false;
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> The number you\'ve entered does not match the card type selected.</p></div></div><br />';
                    }
                }

                if($continue){
                    if(luhn_check($ccn)){
                        $continue = true;
                    } else {
                        $continue = false;
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Invalid credit card number.</p></div></div><br />';
                    }
                }

            } else {
                $continue = true;
            }
            
            */
            $continue= true;
			
			switch($cctype){
				case "V":
					$cctype = "VISA";
				break;
				case "M":
					$cctype = "MASTERCARD";
				break;
                case "DI":
                    $cctype = "DINERS CLUB";
                break;
				case "D":
					$cctype = "DISCOVER";
				break;
				case "A":
					$cctype = "AMEX";
				break;
                case "PP":
                    $cctype = "PAYPAL";
                break;
			}

            $transactID = time()."-".rand(1,999);
            
            if($continue && $cctype!="PAYPAL"){
				###########################################################################
				###	Stripe.com PROCESSING
				###########################################################################
				//PROCESS PAYMENT BY WEBSITE PAYMENTS PRO
				
			/* Stripe error holder */	
            $sMessageResponse .= "<br /><div>Your payment was <b>DECLINED</b>!";
            $sMessageResponse .= "<div id='stripe_error_message' >";
				/* Here Stripe will output the error message */
            $sMessageResponse .= "</div>";
            $mess = '<div id="stripe_error" style="display:none !important;" class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';
				

                switch($payment_mode){
                case "ONETIME":
					
					
					/*	   
					$card['object']='card';
					$card['exp_month']=$exp1;
					$card['exp_year']=$exp2;
					$card['number']=$ccn;
					$card['address_city']=$city;
					$card['address_country']=$country;
					$card['address_line1']=$address;
					$card['address_state']=$state;
					$card['address_zip']=$zip;
					$card['cvc']=$cvv;
					$card['name']=$ccname;
					//$card['currency']=$currency;
					*/
					
								if(!empty($_POST["process"]) && $_POST["process"]=="yes") :
					
					$ccnamet = explode(" ",$ccname);
                    $firstName = isset($ccnamet[0])?$ccnamet[0]:$ccname;
                    $lastName = str_replace($firstName,"",implode(" ",$ccnamet));
                    $firstName = trim($firstName);
                    $lastName = trim($lastName);
							
					 $result = Braintree_Transaction::sale(array(
					    'amount'     => str_replace(',', '', number_format($amount,2)),
                                            'merchantAccountId' => $braintreeaccount,
					    'paymentMethodNonce' => $token
					    ,'options' => array(
    'submitForSettlement' => True),'customer' => array( /* Customer Details */
					    'firstName'  => isset($_POST['fname']) ? $_POST['fname'] : $firstName,
						  'lastName' => isset($_POST['lname']) ? $_POST['lname'] : $firstName,
							 'email' => isset($_POST['email']) ? $_POST['email'] : 'you should not see this'
							 , 'phone' => $phone)
					  ));		
					//, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country
					$return_msg = '';
					if ($result->success) { /* if ok */
						$success = 1;
						$stripe_success=1;
											/* You may adjust this success message. to your needs */
    					$return_msg = 'Your payment was successful. CVC check: '.$cvcchk0.' '.$cvcchk.'. Address check: '.$addrchk0.' '.$addrchk.'. ZIP CODE check: '.$zipchk0.' '.$zipchk.'';
    					//$return_msg = 'Your payment was successful.';
    					// update in mysql
    					
$link = mysql_connect('mysql1003.mochahost.com', 'octapay_ustripe', 'P@Str!pe')
    or die('Could not connect: ' . mysql_error());

mysql_select_db('octapay_stripe') or die('Could not select database');

// Performing SQL query
$query = "INSERT INTO octapay_stripe.payment (customer_id, ccname, address, city, country, email, phone, exp1, exp2, firstname, lastname, state, site, date, ip, last4digit,company,gateway, officephone) VALUES ('$customer_id', '$ccname', '$address', '$city', '$country', '$email', '$phone', '$exp1', '$exp2', '$fname', '$lname', '$state', '$statementdescriptor', CURRENT_TIMESTAMP, '$ip', '".$last4."', '$company','braintree', '$phone2')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$sql = mysql_query("INSERT INTO `transaction` VALUES ('','$customer_id','$email','$semail','$amount','$currency','$item_description','$statementdescriptor') ");

  if ($_POST['tw']!="0")  					
  include '/home/octapay/public_html/pg/paynow/includes/teamwork/teamwork.php';   


					    
					} else if ($result->transaction) { /* if nok and transaction atempt */
						$success = 3;
						$stripe_success=3;
						$return_msg.= $result->transaction->processorResponseText;
					    #print_r("Error processing transaction:");
					    #print_r("\n  message: " . $result->message);
					    #print_r("\n  code: " . $result->transaction->processorResponseCode);
					    #print_r("\n  text: " . $result->transaction->processorResponseText);
					
					} else { /* if nok show all errors */
						$success = 2;
						$stripe_success=2;
						$return_msg.= $result->message;
						
					    #print_r("Message: " . $result->message);
					    #print_r("\nValidation errors: \n");
					    #print_r($result->errors->deepAll());
					}
					
					

						

    					
    				
					 		


                    // Process the payment and output the results
                    switch ($stripe_success) {

                        case 1:  // Successs
                            $sMessageResponse= "<br /><div>Your payment was <b>APPROVED</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= "Gateway Response:".$return_msg;
                            $sMessageResponse .= "</div>";
                            $sMessageResponse .= "<br/><a href='index.php'>Return to payment page</a><br /><br/></div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';

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
                            $subject = "New Payment Received $amount $currency $company";
                            $message =  "<a href='$teamworkurl'>Team Work project created. Click here to access it</a> <br>New payment was successfully received through <b>BrainTree.com</b>  Customer ID: ".$customer_id." Last 4 digit $last4 <br />";
                            $message .= "CVC check: $cvcchk0  ".$cvcchk.". Address check: $addrchk0 ".$addrchk.". ZIP CODE check: $zipchk0  ".$zipchk."<br />";
                            $message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: ".(strtolower(AccountCurrency)=="gbp"?"pound":(strtolower(AccountCurrency)=="aud"?"AUD":"$")).number_format($amount,2);
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            }
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: ".$fname." ".$lname."<br />";
                            $message .= "Email: ".$email."<br />";
                            $message .= "Address: ".$address."<br />";
                            $message .= "City: ".$city."<br />";
                            $message .= "Country: ".$country." <a href='http://www.whatsmyip.org/ip-geo-location/?ip=".$ip."'>".$ip."</a> $ipcountry <br />";
                            $message .= "State/Province: ".$state." Sales person email : ".$_POST['semail']."<br />";
                            $message .= "ZIP/Postal Code: ".$zip." ".$phone." Office phone $phone2<br />";
                            mail($admin_email,$subject,$message,$headers);
                            if($_POST['semail']!= "")
                            mail($_POST['semail'],$subject,$message,$headers);

                            /******************************************************************
                            CUSTOMER EMAIL NOTIFICATION
                            ******************************************************************/
                            $subject = "Payment Received!";
                            $message =  "Dear ".$fname.",<br />";
                            $message .= "<br /> Thank you for your payment.";
                            $message .= "<br /><br />";
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment was made for: \"" . $item_description . "\"";
                            }
                            $message .= "<br />Payment amount: ".(strtolower(AccountCurrency)=="gbp"?"pound":(strtolower(AccountCurrency)=="aud"?"AUD":"$")) . number_format($amount, 2);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br />";
			    $message .= "Statement Descriptor: " . $statementdescriptor . "<br />";
                            $message .= "<br /><br /> For any questions, Please contact  ".$admin_email."<br /><br />Kind Regards,<br />" . $statementdescriptor;
                            mail($email,$subject,$message,$headers);
  

  
                            //-----> send notification end
                            $show_form=0;

                        break;

                        case 2:  // Declined
                            $sMessageResponse= "<br /><div>Your payment was <b>DECLINED</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= $return_msg;
                            $sMessageResponse .= "</div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';
                        break;

                        case 3:  // Error
                            $sMessageResponse= "<br /><div>Payment processing returned <b>ERROR</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= $return_msg;
                            $sMessageResponse .= "</div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';
                        break;
                    }
                break;
				endif; /* End if form submitted */
                case "RECUR":
                /*******************************************************************************************************
                RECURRING PROCESSING
                *******************************************************************************************************/
                    $arb_interval = get_arb_interval($recur_services[$service][2],$recur_services[$service][3]);
                    $ccnamet = explode(" ",$ccname);
                    $firstName = isset($ccnamet[0])?$ccnamet[0]:$ccname;
                    $lastName = str_replace($firstName,"",implode(" ",$ccnamet));
                    $firstName = trim($firstName);
                    $lastName = trim($lastName);
					if(!empty($_POST["process"]) && $_POST["process"]=="yes") :
					 
					
					if($recur_services[$service][4] > 0){
						$trial_s = $recur_services[$service][4];
						$account_balance = $recur_services[$service][5]*100;
						$trial_end = time() + ($trial_s * 24 * 60 * 60);
						
					}else{
						$trial_s = null;
						$trial_end = null;
						$quantity = 1;
					}
					
					/* Create Plan if does not exists */
					

                    if ($stripe_success){

                       

                        if($stripe_success == 2){

                            $my_status="<div>Subscription Un-successful!<br/>";
                            $my_status .=$subscriptionId."<br />";
                            #$my_status .="Response Code: ".$resultCode."<br />";
                            #$my_status .="Response Reason Code: ".$code."<br />";
                            #$my_status .="Response Text: ".$text."<br /><br />";
                            $error=0;
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$return_msg.'</div></div><br />';

                        } elseif($stripe_success == 1) {

                            $my_status="<br/><div>Subscription Created Successfully!<br/>";
                            $my_status .= "Subscription ID: " . $subscriptionId . "<br />";
                            $my_status .="Thank you for your payment<br /><br />";
                            $my_status .="Gateway Response:<br />";
                            $my_status .=$return_msg."<br />";
                            #$my_status .="Response Reason Code: ".$code."<br />";
                            #$my_status .="Response Text: ".$text."<br /><br />";
                            $my_status .= "You will receive confirmation email within 5 minutes.<br/><br/><a href='index.php'>Return to payment page</a></div><br/>";
                            $error=0;
                            $mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
                            /******************************************************************
                            ADMIN EMAIL NOTIFICATION
                            ******************************************************************/
                            $headers  = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: 'Stripe Payment Terminal' <noreply@".str_replace('www.', '', $_SERVER['HTTP_HOST'])."> \n";
                            $subject = "New Recurring Payment Received";
                            $message = "New recurring payment was successfully received through Stripe.com <br />";
                            $message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: ".(strtolower(AccountCurrency)=="gbp"?"&pound;":"$").number_format($amount,2);
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$recur_services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            }
                            $message .= "<br/>Start Date: ".date("Y-m-d")."<br />";
                            $message .= "Billing Frequency: ".$recur_services[$service][3]. " ". $recur_services[$service][2]."<br />";
                            $message .= "Subscription ID: ".$subscriptionId."<br />";
                            #$message .= "Reference ID: ".$refId."<br /><br />";
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: ".$fname." ".$lname."<br />";
                            $message .= "Email: ".$email."<br />";
                            $message .= "Address: ".$address."<br />";
                            $message .= "City: ".$city."<br />";
                            $message .= "Country: ".$country."<br />";
                            $message .= "State/Province: ".$state."<br />";
                            $message .= "ZIP/Postal Code: ".$zip."<br /><br />";

                            $message .= "If for any reason you need to cancel this subscription you can follow <a href='http://".$_SERVER["SERVER_NAME"].str_replace("/index.php","",$_SERVER["REQUEST_URI"])."/cancel.php?subid=".$subscriptionId."'>this link</a><br />";
                            mail($admin_email,$subject,$message,$headers);

                            /******************************************************************
                            CUSTOMER EMAIL NOTIFICATION
                            ******************************************************************/
                            $subject = "Payment Received!";
                            $message =  "Dear ".$fname.",<br />";
                            $message .= "<br /> Thank you for your payment.";
                            $message .= "<br /><br />";
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$recur_services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            }
                            $message .= "<br/>Start Date: ".date("Y-m-d")."<br />";
                            $message .= "Billing Frequency: ".$recur_services[$service][3]. " ". $recur_services[$service][2]."<br />";
                            $message .= "Subscription ID: ".$subscriptionId."<br />";
                            $message .= "Reference ID: ".$refId;
                            $message .= "<br />Payment amount: ".(strtolower(AccountCurrency)=="gbp"?"&pound;":(strtolower(AccountCurrency)=="eur"?"&euro;":"$")) . number_format($amount, 2);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br /><br />";
                            $message .= "If for any reason you need to cancel this subscription you can follow <a href='http://".$_SERVER["SERVER_NAME"].str_replace("/index.php","",$_SERVER["REQUEST_URI"])."/cancel.php?subid=".$subscriptionId."'>this link</a>";
                            $message .= "<br /><br />Kind Regards,<br />" . $_SERVER['HTTP_HOST'];
                            mail($email,$subject,$message,$headers);
                            //-----> send notification end
                            $show_form=0;
                            #**********************************************************************************************#
                            #		THIS IS THE PLACE WHERE YOU WOULD INSERT ORDER TO DATABASE OR UPDATE ORDER STATUS.
                            #**********************************************************************************************#

                            #**********************************************************************************************#
                        }
                    }  else  {
                        $count=0;
                        $my_status="<div>Transaction Un-successful!<br/>";
                        $my_status .="There was an error with your credit card processing.<br/>";
                        $error=1;
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$return_msg.'</div></div><br />';
                    }
				endif; /* End submit form condition for Recurr  */	
                break;
            }
			

			} else if($continue && $cctype=="PAYPAL"){
                require('includes/paypal.class.php');
                $paypal = new paypal_class;

                $paypal->add_field('business', $paypal_merchant_email);
                $paypal->add_field('return', $paypal_success_url);
                $paypal->add_field('cancel_return', $paypal_cancel_url);
                $paypal->add_field('notify_url', $paypal_ipn_listener_url);

                    if($payment_mode=="ONETIME"){
                        if($show_services){
                            $paypal->add_field('item_name_1', strip_tags(str_replace("'","",$services[$service][0])));
                        } else {
                            $paypal->add_field('item_name_1', strip_tags(str_replace("'","",$item_description)));
                        }
                        $paypal->add_field('amount_1', $amount);
                        $paypal->add_field('item_number_1', $transactID);
                        $paypal->add_field('quantity_1', '1');
                        $paypal->add_field('custom', $paypal_custom_variable);
                        $paypal->add_field('upload', 1);
                        $paypal->add_field('cmd', '_cart');
                        $paypal->add_field('txn_type', 'cart');
                        $paypal->add_field('num_cart_items', 1);
                        $paypal->add_field('payment_gross', $amount);
                        $paypal->add_field('currency_code',$paypal_currency);
                        
                        
                        $_SESSION["fname"]=$fname;
                        $_SESSION["lname"]=$lname;
                        $_SESSION["address"]=$address;
                        $_SESSION["city"]=$city;
                        $_SESSION["country"]=$country;                      
                        $_SESSION["email"]=$email;
                        $_SESSION["phone"]=$phone;
                        $_SESSION["state"]=$state;
                        $_SESSION["company"]=$company;
                        $_SESSION["phone2"]=$phone2;
                        $_SESSION["semail"]=$semail;
                        $_SESSION["amount"]=$amount;
                        $_SESSION["currency"]=$currency;
                        $_SESSION["item_description"]=$item_description;
                        $_SESSION["statementdescriptor"]=$statementdescriptor;
                        $_SESSION["site"]=$site;
                        $_SESSION["tw"]=$tw;
                        $_SESSION["admin_email"]=$admin_email;
                        
                        

                    } else if($payment_mode=="RECUR"){
                        if($show_services){
                            $paypal->add_field('item_name', strip_tags(str_replace("'","",$recur_services[$service][0])));
                        } else {
                            $paypal->add_field('item_name', strip_tags(str_replace("'","",$item_description)));
                        }
                        $paypal->add_field('item_number', $transactID);

                        //TRIAL PERIOD
                        if($recur_services[$service][4]!="0"){
                            $paypal->add_field('a1', $recur_services[$service][5]);
                            $paypal->add_field('p1', $recur_services[$service][4]);
                            $paypal->add_field('t1', "D");
                        }
                        $paypal->add_field('a3', $amount);
                        $paypal_duration = getDurationPaypal($recur_services[$service][2]); //get duration based on recurring_services array
                        $paypal->add_field('p3', $recur_services[$service][3]);
                        $paypal->add_field('t3', (is_array($paypal_duration)?$paypal_duration[0]:$paypal_duration));
                        $paypal->add_field('src', '1');
                        $paypal->add_field('no_note', '1');
                        $paypal->add_field('no_shipping', '1');
                        $paypal->add_field('custom', $paypal_custom_variable);
                        $paypal->add_field('currency_code',$paypal_currency);
                    }
                    $show_form=0;
                    $mess = $paypal->submit_paypal_post(); // submit the fields to paypal


            }


				
		} elseif(!is_numeric($amount) || empty($amount)) { 
			if($show_services){
				$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please select service you\'re paying for.</p></div></div><br />';
			} else { 
				$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please type amount to pay for services!</p></div></div><br />';
			}
			$show_form=1; 
		} 
	# END OF PLEASE DO NOT EDIT IF YOU'RE NOT SURE
?>