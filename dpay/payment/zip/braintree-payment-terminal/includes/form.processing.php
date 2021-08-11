<?php
/******************************************************************************
#                     PHP BrainTree Payment Terminal v1.0
#******************************************************************************
#      Author:     Convergine.com
#      Email:      info@convergine.com
#      Website:    http://www.convergine.com
#
#
#      Version:    1.0
#      Copyright:  (c) 2013 - Convergine.com
#
#*******************************************************************************/
$province = str_replace("-AU-", "", $state);
$subscriptionId = '';
$text = '';

	# PLEASE DO NOT EDIT FOLLOWING LINES IF YOU'RE NOT SURE ------->
        if ($show_services) {
            if($payment_mode=="RECUR"){
                $amount = number_format($recur_services[$service][1], 2,'.','');
            } else {
                $amount = number_format($services[$service][1], 2,'.','');
            }
            $item_description = $services[$service][0];
        }


		$continue = false;
		if(!empty($amount) && is_numeric($amount)){ 	
			$cctype = (!empty($_POST['cctype']))?strip_tags(str_replace("'","`",strip_tags($_POST['cctype']))):'';
			$ccname = (!empty($_POST['ccname']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccname']))):'';
			$ccn = (!empty($_POST['ccn']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccn']))):'';
			$exp1 = (!empty($_POST['exp1']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp1']))):'';
			$exp2 = (!empty($_POST['exp2']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp2']))):'';
			$cvv = (!empty($_POST['cvv']))?strip_tags(str_replace("'","`",strip_tags($_POST['cvv']))):'';
			
			
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

            $transactID = mktime()."-".rand(1,999);
            
			
            if($continue && $cctype!="PAYPAL"){
				###########################################################################
				###	BrainTree PROCESSING
				###########################################################################
				
				
			/* BrainTree error holder */	
            $sMessageResponse .= "<br /><div>Your payment was <b>DECLINED</b>!";
            $sMessageResponse .= "<div id='stripe_error_message' >";
			/* Here BrainTree will output the error message */
            $sMessageResponse .= "</div>";
            $mess = '<div id="stripe_error" style="display:none !important;" class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';
				

                switch($payment_mode){
                case "ONETIME":
					if(!empty($_POST["process"]) && $_POST["process"]=="yes") :
					
					$ccnamet = explode(" ",$ccname);
                    $firstName = isset($ccnamet[0])?$ccnamet[0]:$ccname;
                    $lastName = str_replace($firstName,"",implode(" ",$ccnamet));
                    $firstName = trim($firstName);
                    $lastName = trim($lastName);
							
					 $result = Braintree_Transaction::sale(array(
					    'amount'     => str_replace(',', '', number_format($amount,2)),
					    'creditCard' => array( /* Credit card Details */
					        'number' => $ccn,
					'expirationDate' => $exp1.'/'.$exp2,
							   'cvv' => $cvv
					    ),'customer' => array( /* Customer Details */
					    'firstName'  => isset($_POST['fname']) ? $_POST['fname'] : $firstName,
						  'lastName' => isset($_POST['lname']) ? $_POST['lname'] : $firstName,
							 'email' => isset($_POST['email']) ? $_POST['email'] : 'you should not see this'
					  )
					));		
					
					$return_msg = '';
					if ($result->success) { /* if ok */
						$success = 1;
					    
					} else if ($result->transaction) { /* if nok and transaction atempt */
						$success = 3;
						$return_msg.= $result->transaction->processorResponseText;
					    #print_r("Error processing transaction:");
					    #print_r("\n  message: " . $result->message);
					    #print_r("\n  code: " . $result->transaction->processorResponseCode);
					    #print_r("\n  text: " . $result->transaction->processorResponseText);
					
					} else { /* if nok show all errors */
						$success = 2;
						$return_msg.= $result->message;
						
					    #print_r("Message: " . $result->message);
					    #print_r("\nValidation errors: \n");
					    #print_r($result->errors->deepAll());
					}
					
                    // Process the payment and output the results
                    switch ($success) {

                        case 1:  // Successs
                            $sMessageResponse= "<br /><div>Transaction was <b>APPROVED</b>!";
                            $sMessageResponse .= "<div>";
                            if(!empty($return_msg)){
                            $sMessageResponse .= $return_msg."<br />"; }
							if($result->transaction){
							$sMessageResponse .= 'Transaction ID: <b>'.strtoupper($result->transaction->id)."</b><br />";	}
                            $sMessageResponse .= "Thank you for your payment. <br /> You will receive confirmation email shortly.</div>";
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
                            $headers .= "From: 'BrainTree Payment Terminal' <noreply@".$_SERVER['HTTP_HOST']."> \n";
                            $subject = "New Payment Received";
                            $message =  "New payment was successfully received through BrainTree <br />";
                            $message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: $".number_format($amount,2);
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            }
                            $message .= "<br />Transaction ID: " .  strtoupper($result->transaction->id);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: ".$fname." ".$lname."<br />";
                            $message .= "Email: ".$email."<br />";
                            $message .= "Address: ".$address."<br />";
                            $message .= "City: ".$city."<br />";
                            $message .= "Country: ".$country."<br />";
                            $message .= "State/Province: ".$state."<br />";
                            $message .= "ZIP/Postal Code: ".$zip."<br />";
                            mail($admin_email,$subject,$message,$headers);

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
                            $message .= "<br />Payment amount: $" . number_format($amount, 2);
                            $message .= "<br />Transaction ID: " .  strtoupper($result->transaction->id);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br />";

                            $message .= "<br /><br />Kind Regards,<br />" . $_SERVER['HTTP_HOST'];
                            mail($email,$subject,$message,$headers);

                            //-----> send notification end
                            $show_form=0;

                        break;

                        case 2:  // Declined
                            $sMessageResponse= "<br /><div>Transaction was <b>DECLINED</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= $return_msg;
							if($result->transaction){
							$sMessageResponse .= '<br />Transaction ID: <b>'.strtoupper($result->transaction->id)."</b><br />";	}
                            $sMessageResponse .= "<br /><br /></div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';
                        break;

                        case 3:  // Error
                            $sMessageResponse= "<br /><div>Payment processing returned <b>ERROR</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= $return_msg;
                            $sMessageResponse .= "<br /></div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$sMessageResponse.'</div></div><br />';
                        break;
                    }
                break;
				endif; /* End if form submitted */
                case "RECUR":
                /*******************************************************************************************************
                RECURRING PROCESSING
                *******************************************************************************************************/
                
                    $ccnamet = explode(" ",$ccname);
                    $firstName = isset($ccnamet[0])?$ccnamet[0]:$ccname;
                    $lastName = str_replace($firstName,"",implode(" ",$ccnamet));
                    $firstName = trim($firstName);
                    $lastName = trim($lastName);
					if(!empty($_POST["process"]) && $_POST["process"]=="yes") :
					if(isset($_POST['service'])){
						$service = $_POST['service'];
						$text = '';
						
						$newcustomer = Braintree_Customer::create(array(
							'firstName'  => isset($_POST['fname']) ? $_POST['fname'] : $firstName,
							'lastName'   => isset($_POST['lname']) ? $_POST['lname'] : $firstName,
							'email'		 => isset($_POST['email']) ? $_POST['email'] : 'you should not see this',
						    'creditCard' => array(
						        'cardholderName' => trim($ccname),
						        'number' => $ccn,
						        'cvv' => $cvv,
						        'expirationDate' => $exp1.'/'.$exp2,
						        'options' => array(
						            'verifyCard' => true
						        )
						    )
						));
						

						if($newcustomer->success){ /* if valid Credit Card and customer was created or exists */
									$i=0;
								$token = $newcustomer->customer->creditCards[$i]->token;
								foreach($newcustomer->customer->creditCards as $k => $creditC){
									if($creditC->cardholderName == trim($ccname) && $creditC->last4 == substr($ccn, 0,-4) && $creditC->expirationDate == $exp1.'/'.$exp2) :
									/* check all Credit Cards and select the current used one */
									$token = $newcustomer->customer->creditCards[$i]->token;	
									endif;
									$i++;	
								}
								$success = 1;
								   /* everything was ok, will subscribe the customer */
								   $result = Braintree_Subscription::create(array(
									  'paymentMethodToken' => $token,
									  'planId' => $service,
									  'trialDuration' => $recur_services[$service][4],
									  'trialDurationUnit' => $recur_services[$service][3]
									
									));
									
								if(!$result->success){ /* if errors on subscribe */
									$success = 2;
									if($result->message){
										$text = $result->message;}
										else{
											$text = $result->_attributes['message'];
										}
								}else{ /* everything was ok. get subscripton id for cancel.php case */
									$subscriptionId = $result->subscription->id;
								}	 
						}else{ /* invalid credit card, or customer not created */
							$success = 2;
							$text = $newcustomer->message;
						}
						
						
						
                        if($success == 2){

                            $my_status="<div>Subscription Un-successful!<br/>";
                            $my_status .=$subscriptionId."<br />";
                            #$my_status .="Response Code: ".$resultCode."<br />";
                            #$my_status .="Response Reason Code: ".$code."<br />";
                            $my_status .="Response Text: ".$text."<br /><br />";
                            $error=1;
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';

                        } elseif($success == 1) {

                            $my_status="<br/><div>Subscription Created Successfully!<br/>";
                            $my_status .= "Subscription ID: <b>" . strtoupper($subscriptionId) . "</b><br />";
                            $my_status .="Thank you for your payment<br /><br />";
                            #$my_status .="Gateway Response:<br />";
                            #$my_status .="Response Code: ".$resultCode."<br />";
                            #$my_status .="Response Reason Code: ".$code."<br />";
                            #$my_status .="Response Text: ".$text."<br /><br />";
                            $my_status .= "You will receive confirmation email shortly.<br/><br/><a href='index.php'>Return to payment page</a></div><br/>";
                            $error=0;
                            $mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
                            /******************************************************************
                            ADMIN EMAIL NOTIFICATION
                            ******************************************************************/
                            $headers  = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: 'BrainTree Payment Terminal' <noreply@".$_SERVER['HTTP_HOST']."> \n";
                            $subject = "New Recurring Payment Received";
                            $message = "New recurring payment was successfully received through BrainTree <br />";
                            $message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: $".number_format($amount,2);
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$recur_services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$item_description."\"";
                            }
                            $message .= "<br/>Start Date: ".date("Y-m-d")."<br />";
                            $message .= "Billing Frequency: ".$recur_services[$service][2]. " Month(s)<br />";
                            $message .= "Subscription ID: ". strtoupper($subscriptionId)."<br />";

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
                            $message .= "Billing Frequency: ".$recur_services[$service][2]. " Month(s)<br />";
                            $message .= "Subscription ID: ". strtoupper($subscriptionId)."<br />";

                            $message .= "<br />Payment amount: $" . number_format($amount, 2);
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
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
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
                        $paypal_duration = "M"; //get duration based on recurring_services array
                        $paypal->add_field('p3', $recur_services[$service][2]);
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
				$mess.= $amount;
			} else { 
				$mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please type amount to pay for services!</p></div></div><br />';
			}
			$show_form=1; 
		} 
	# END OF PLEASE DO NOT EDIT IF YOU'RE NOT SURE
?>