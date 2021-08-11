<?php
/******************************************************************************
 * #                      PHP Stripe Payment Terminal v1.3
 * #******************************************************************************
 * #      Author:     Convergine.com
 * #      Email:      info@convergine.com
 * #      Website:    http://www.convergine.com
 * #
 * #
 * #      Version:    1.3
 * #      Copyright:  (c) 2013 - Convergine.com
 * #
 * #*******************************************************************************/

// email
$to_custom = $admin_email;
$cc_custom = "";

$province = str_replace("-US-", "", $state);

$sMessageResponse = '';
$phone = $_REQUEST['phone'];

# PLEASE DO NOT EDIT FOLLOWING LINES IF YOU'RE NOT SURE ------->
if ($show_services) {
    if ($payment_mode == "RECUR") {
        $amount = number_format($recur_services[$service][1], 2, ".", "");
    } else {
        $amount = number_format($services[$service][1], 2, ".", "");
    }
    $item_description = $services[$service][0];
} else {
    $amount = number_format($amount, 2, ".", "");
}
$amount = str_replace(",", "", $amount);

$continue = false;
if (!empty($amount) && is_numeric($amount)) {
    $cctype = (!empty($_POST['cctype'])) ? strip_tags(str_replace("'", "`", strip_tags($_POST['cctype']))) : '';
    $ccname = (!empty($_POST['ccname'])) ? strip_tags(str_replace("'", "`", strip_tags($_POST['ccname']))) : '';
    $ccn = (!empty($_POST['ccn']))?strip_tags(str_replace("'","`",strip_tags($_POST['ccn']))):'';
    //$exp1 = (!empty($_POST['exp1']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp1']))):'';
    //$exp2 = (!empty($_POST['exp2']))?strip_tags(str_replace("'","`",strip_tags($_POST['exp2']))):'';
    //$cvv = (!empty($_POST['cvv']))?strip_tags(str_replace("'","`",strip_tags($_POST['cvv']))):'';
    $ipcountry = $_POST['ipcountry'];
    
    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://lookup.binlist.net/".$ccn,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: 8b88b621-9410-c3bb-8125-73eef19e66ef"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$response  = json_decode($response);

$binresponse = "Country: " . $response->country->name . "<br>";
$binresponse .= "Bank: " . $response->bank->name . "<br>";
$binresponse .= "Bank URL: " . $response->bank->url . "<br>";
$binresponse .= "Bank Phone: " . $response->bank->phone . "<br>";


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
    $continue = true;

    switch ($cctype) {
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

    $transactID = time() . "-" . rand(1, 999);
    require 'Stripe.php';
    if ($continue && $cctype != "PAYPAL") {
        ###########################################################################
        ###	Stripe.com PROCESSING
        ###########################################################################
        //PROCESS PAYMENT BY WEBSITE PAYMENTS PRO

        /* Stripe error holder */
        $sMessageResponse .= "<br /><div>Your payment was <b>DECLINED</b>!";
        $sMessageResponse .= "<div id='stripe_error_message' >";
        /* Here Stripe will output the error message */
        $sMessageResponse .= "</div>";
        $mess = '<div id="stripe_error" style="display:none !important;" class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' . $sMessageResponse . '</div></div><br />';


        switch ($payment_mode) {
            case "ONETIME":
                if (!empty($_POST["process"]) && $_POST["process"] == "yes") :

                    /* Set Item Description */
                    //foreach($services as $items => $item){
                    //	if($item[1] == $amount){
                    //		$item_description = $item[0];
                    //	}
                    //}

                    /* Create and Send Stripe Request */
                    Stripe::setApiKey(SecretKey);
                    try {
                        if (!isset($_POST['stripeToken']))
                            throw new Exception("The Stripe Token was not generated correctly");

                        /* JM modification */
                        try {

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

                            $shipping['phone'] = $phone;
                            $shipping['name'] = $email;
                            //$shipping['address']=$address;
                            $shipping['address']['line1'] = $address;

                            $testdesc = "" . $email . " " . $phone . "";

                            $fname = isset($_POST['fname']) ? $_POST['fname'] : $firstName;
                            $lname = isset($_POST['lname']) ? $_POST['lname'] : $lastName;
                            $meta_email = isset($_POST['email']) ? $_POST['email'] : 'you should not see this';


                            $token = $_POST['stripeToken'];
                            $customer = Stripe_Customer::create(array(
                                    "card" => $token,
                                    //'source'=>$card,
                                    'shipping' => $shipping,
                                    'description' => $testdesc,
                                    'email'=>$email,
                                    'metadata'=>array(
                                        'firstName' =>$fname,
                                        'lastName' => $lname,
                                        'company' => $company,
                                        'email' => $meta_email,
                                        'phone' => $phone,
                                        /*// Billing
                                        'billingAddress' => [
                                            'firstName' => isset($_POST['fname']) ? $_POST['fname'] : $firstName,
                                            'lastName' => isset($_POST['lname']) ? $_POST['lname'] : $firstName,
                                            'company' => $company,
                                            'streetAddress' => $address,
                                            'locality' => $city,
                                            'region' => $state,
                                            'postalCode' => $zip
                                        ]*/
                                    )

                                    // "email" => $email
                                )
                            );


                            $customer_info = "========== CUSTOMER DETAIL ==========" . "\r\n" . "ID : " . $customer->id . "\r\n" . "First Name : " . $fname . "\r\n"
                                . "Last Name : " . $lname . "\r\n"  . "Company : " . $company . "\r\n"
                                . "Email : " . $meta_email . "\r\n"  . "Phone : " . $phone . "\r\n";

                            $customer_id = $customer->id;
                            $cvcchk0 = $customer->sources->data[0]->cvc_check;
                            $zipchk0 = $customer->sources->data[0]->address_zip_check;
                            $addrchk0 = $customer->sources->data[0]->address_line1_check;
                            $last4 = $customer->sources->data[0]->last4;

                            $stripe_success = 1;
                            /* You may adjust this success message. to your needs */
                            $return_msg = 'Your payment was successful. CVC check: ' . $cvcchk . '. Address check: ' . $addrchk . '. ZIP CODE check: ' . $zipchk . '';

                        } catch (Exception $e) {
                            $stripe_success = 2;
                            $return_msg = $e->getMessage();
                        }

                        /* end */

                        if ($stripe_success == 1) {

                            // Get Customer ID
                            /*$customerID = $customer->id;
                            $customer_info = "========== CUSTOMER DETAIL ==========" . "\r\n" . "ID : " . $customer->id . "\r\n" . "First Name : " . $customer->customer->firstName . "\r\n"
                                . "Last Name : " . $customer->customer->lastName . "\r\n"  . "Company : " . $customer->customer->company . "\r\n"
                                . "Email : " . $customer->customer->email . "\r\n"  . "Phone : " . $customer->customer->phone . "\r\n";*/

                            // Generate Random number
                            $rand = floatVal('2.'.rand(20, 90));
                            $rand2 = floatVal('2.'.rand(20, 90));
                            $original_amount = $amount;
                            $amount = $amount - $rand;
                            $amount = $amount - $rand2;
                            $transaction_1 = Stripe_Charge::create(array(
                                /* Add here more options or the charge */
                                "amount" => number_format($amount, 2, ".", "") * 100,
                                "currency" => AccountCurrency,
                                "statement_descriptor" => $statementdescriptor,
                                "customer" => $customer_id,
                                "description" => $item_description
                            ));

                            $trans_first = "========== TRANSACTION # 1 ==========" . "\r\n" .  "ID : " . $transaction_1->id . "\r\n"
                                . "Status : " . ucfirst($transaction_1->object) . "\r\n"  . "Amount : " . ' ' . $currency . $amount
                                . "\r\n" . "CreatedAt : " . date('Y-m-d') . "\r\n";

                            // card info
                            $credit_card_info = "========== PAYMENT DETAIL ==========" . "\r\n" .  "Last 4 Digits : " . $last4 . "\r\n"
                                .  "Card Type : " . $cctype . "\r\n" .  "Card Expire Month : " . $_POST['exp1'] . "\r\n"
                                .  "Card Expire Year : " . $_POST['exp2'] . "\r\n";



                            $transaction_2 = Stripe_Charge::create(array(
                                /* Add here more options or the charge */
                                "amount" => number_format($rand, 2, ".", "") * 100,
                                "currency" => AccountCurrency,
                                "statement_descriptor" => $statementdescriptor,
                                "customer" => $customer_id,
                                "description" => $item_description
                            ));

                            $trans_second = "========== TRANSACTION # 2 ==========" . "\r\n" .  "ID : " . $transaction_2->id . "\r\n"
                                . "Status : " . ucfirst($transaction_2->object) . "\r\n"  . "Amount : " . ' ' . $currency . $rand
                                . "\r\n" . "CreatedAt : " . date('Y-m-d') . "\r\n";

                            // Sum Transaction
                           // $sum_transaction = "========== TOTAL AMOUNT ==========" . "\r\n" .  "Transaction # 1 : " . $amount . "\r\n"
                             //   . "Transaction # 2 : " . $rand . "\r\n" . "Total Amount : " . ($original_amount) . "\r\n" ;

                            $transaction_3 = Stripe_Charge::create(array(
                                /* Add here more options or the charge */
                                "amount" => number_format($rand2, 2, ".", "") * 100,
                                "currency" => AccountCurrency,
                                "statement_descriptor" => $statementdescriptor,
                                "customer" => $customer_id,
                                "description" => $item_description
                            ));

                            $trans_third = "========== TRANSACTION # 3 ==========" . "\r\n" .  "ID : " . $transaction_3->id . "\r\n"
                                . "Status : " . ucfirst($transaction_3->object) . "\r\n"  . "Amount : " . ' ' . $currency . $rand2
                                . "\r\n" . "CreatedAt : " . date('Y-m-d') . "\r\n";

                            // Sum Transaction
                            $sum_transaction = "========== TOTAL AMOUNT ==========" . "\r\n" .  "Transaction # 1 : " . $amount . "\r\n"
                                . "Transaction # 2 : "  . $rand . "\r\n" 
                                . "Transaction # 3 : "  . $rand2 . "\r\n"    
                                . "Total Amount : " . ($original_amount) . "\r\n" ;

                            
                            // Send email First and Second transaction
                            $to = $to;
                            $subject_total = "Transaction Success # " . $statementdescriptor;
                            //$txt = "ID : " . $transaction->id . "\r\n" . "Type : " . $transaction->type . "\r\n" . "Amount : " . $currency . " " . $transaction->amount . "\r\n";
                            $txt_desc = $customer_info . $credit_card_info . $trans_first . $trans_second . $trans_third . $sum_transaction;
                            $headers_custom = "From: 'Stripe Payment Terminal' <noreply@".str_replace('www.', '', $_SERVER['HTTP_HOST'])."> \r\n" .
                                "CC: $cc_custom";
                            mail($to_custom,$subject_total,$txt_desc,$headers_custom);


                            $stripe_success = 1;
                            /* You may adjust this success message. to your needs */
                            //$return_msg = 'Your payment was successful.';
                            $cvcchk = $customer1->sources->cvc_check;
                            $zipchk = $customer1->sources->address_zip_check;
                            $addrchk = $customer1->sources->address_line1_check;

                            $stripe_success = 1;
                            /* You may adjust this success message. to your needs */
                            $return_msg = 'Your payment was successful. CVC check: ' . $cvcchk0 . ' ' . $cvcchk . '. Address check: ' . $addrchk0 . ' ' . $addrchk . '. ZIP CODE check: ' . $zipchk0 . ' ' . $zipchk . '';
                            //$return_msg = 'Your payment was successful.';
                            // update in mysql




//mysql_select_db('octapay_stripe_pg') or die('Could not select database');

$link = mysqli_connect('142.11.200.189', 'projectsilos_crm_user', 'H3()*TilgFd~', 'projectsilos_payment');
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
// Performing SQL query
                            $query = "INSERT INTO payment (customer_id, ccname, address, city, country, email, phone, exp1, exp2, firstname, lastname, state, site, date, ip, last4digit,company,gateway, officephone) VALUES ('$customer_id', '$ccname', '$address', '$city', '$country', '$email', '$phone', '$exp1', '$exp2', '$fname', '$lname', '$state', '$statementdescriptor', CURRENT_TIMESTAMP, '$ip', '" . $last4 . "', '$company','Stripe', '$phone2')";
                            $result = mysqli_query($link,$query) or die('Query failed: ' . mysqli_error($link));

                            /************** 3 transaction will show in CRM********************/
                            $tr_1 = $transaction_1->id;
                            $tr_2 = $transaction_2->id;
                            $tr_3 = $transaction_3->id;
                            $sql = mysqli_query($link,"INSERT INTO `transaction` (`customer_id`, `email`, `sales`, `amount`, `currency`, `description`, `statement`, `transaction_id`) VALUES ('$customer_id','$email','$semail','$amount','$currency','$item_description','$statementdescriptor','$tr_1') ");
                            $sql = mysqli_query($link,"INSERT INTO `transaction` (`customer_id`, `email`, `sales`, `amount`, `currency`, `description`, `statement`, `transaction_id`) VALUES ('$customer_id','$email','$semail','$rand','$currency','$item_description','$statementdescriptor','$tr_2') ");
                            $sql = mysqli_query($link,"INSERT INTO `transaction` (`customer_id`, `email`, `sales`, `amount`, `currency`, `description`, `statement`, `transaction_id`) VALUES ('$customer_id','$email','$semail','$rand2','$currency','$item_description','$statementdescriptor','$tr_3') ");
                            /************** 3 transaction will showin CRM********************/



                            //if ($_POST['tw'] != "0")
                                //include 'teamwork/teamwork.php';  


                        }
                    }
                    catch (Exception $e) {
                        $stripe_success = 2;
                        $return_msg = $e->getMessage();
                    }


                    // Process the payment and output the results
                    switch ($stripe_success) {

                        case 1:  // Successs
                            $sMessageResponse = "<br/><div id='mnbhide'>YOU HAVE BEEN SUCCESSFULLY CHARGED A TOTAL AMOUNT OF ".$AccountCurrency . $original_amount." IN 3 SEPARATE TRANSACTIONS.</div>";
                            $sMessageResponse .= "<br /><div>Your payment was <b>APPROVED</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= "Gateway Response:" . $return_msg;
                            $sMessageResponse .= "</div>";
                            $sMessageResponse .= "<br/><a href='https://merchantpaymenthub.com'>Return to payment page</a><br /><br/></div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">' . $sMessageResponse . '</div></div><br />';

                            #**********************************************************************************************#
                            #		THIS IS THE PLACE WHERE YOU WOULD INSERT ORDER TO DATABASE OR UPDATE ORDER STATUS.
                            #**********************************************************************************************#

                            #**********************************************************************************************#
                            /******************************************************************
                             * ADMIN EMAIL NOTIFICATION
                             ******************************************************************/
                            $headers = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: '" . $statementdescriptor . "' <noreply@" . $statementdescriptor . "> \n";
                            $subject = "New Payment Received $original_amount $currency $company";
                            $message = "New payment was successfully received through Stripe.com<br />  Customer ID: " . $customer_id . " Last 4 digit $last4 <br />";
                            $message .= "CVC check: $cvcchk0  " . $cvcchk . ". Address check: $addrchk0 " . $addrchk . ". ZIP CODE check: $zipchk0  " . $zipchk . "<br />";
                            /*
                            $message .= "from ".$fname." ".$lname."  on ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: ".(strtolower(AccountCurrency)=="gbp"?"pound":(strtolower(AccountCurrency)=="usd"?"USD":"$")).number_format($amount,2);
                            */
                            $message .= "from " . $fname . " " . $lname . "  on " . date('m/d/Y') . " at " . date('g:i A') . ".<br />
                            Payment total is:" . $currency . number_format($original_amount, 2);
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment description: \"" . $item_description . "\"";
                            }
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . " <a href='http://www.whatsmyip.org/ip-geo-location/?ip=" . $ip . "'>" . $ip . "</a> $ipcountry <br />";
                            $message .= "State/Province: " . $state . " Sales person email : " . $_POST['semail'] . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . " " . $phone . " Office phone $phone2<br /><br />";
                            $message .= "BIN Details: <br/>" . $binresponse . "<br />";
                            
                            mail($admin_email,$subject,$message,$headers);


                            //mail($to_custom,$subject,$message,$headers);
                            if ($_POST['semail'] != "")
                                mail($_POST['semail'],$subject,$message,$headers);

                                /******************************************************************
                                 * CUSTOMER EMAIL NOTIFICATION
                                 ******************************************************************/
                                $subject = "Payment Received!";
                            $message = "Dear " . $fname . ",<br />";
                            $message .= "<br /> Thank you for your payment.";
                            $message .= "<br /><br />";
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment was made for: \"" . $item_description . "\"";
                            }
                            $message .= "<br />Payment amount: " . (strtolower(AccountCurrency) == "gbp" ? "pound" : (strtolower(AccountCurrency) == "usd" ? "USD" : "$")) . number_format($original_amount, 2);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br />";
                            $message .= "Statement Descriptor: " . $statementdescriptor . "<br />";
                            $message .= "<br /><br /> For any questions, Please contact  " . $admin_email . "<br /><br />Kind Regards,<br />" . $statementdescriptor;
                            mail($email,$subject,$message,$headers);
                            //mail($email,$subject,$message,$headers);


                            //-----> send notification end
                            $show_form = 0;

                            break;

                        case 2:  // Declined
                            $sMessageResponse = "<br /><div>Your payment was <b>DECLINED</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= $return_msg;
                            $sMessageResponse .= "</div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' . $sMessageResponse . '</div></div><br />';
                            break;

                        case 3:  // Error
                            $sMessageResponse = "<br /><div>Payment processing returned <b>ERROR</b>!";
                            $sMessageResponse .= "<div>";
                            $sMessageResponse .= $return_msg;
                            $sMessageResponse .= "</div>";
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' . $sMessageResponse . '</div></div><br />';
                            break;
                    }
                    break;
                endif; /* End if form submitted */
            case "RECUR":
                /*******************************************************************************************************
                 * RECURRING PROCESSING
                 *******************************************************************************************************/
                $arb_interval = get_arb_interval($recur_services[$service][2], $recur_services[$service][3]);
                $ccnamet = explode(" ", $ccname);
                $firstName = isset($ccnamet[0]) ? $ccnamet[0] : $ccname;
                $lastName = str_replace($firstName, "", implode(" ", $ccnamet));
                $firstName = trim($firstName);
                $lastName = trim($lastName);
                if (!empty($_POST["process"]) && $_POST["process"] == "yes") :


                    if ($recur_services[$service][4] > 0) {
                        $trial_s = $recur_services[$service][4];
                        $account_balance = $recur_services[$service][5] * 100;
                        $trial_end = time() + ($trial_s * 24 * 60 * 60);

                    } else {
                        $trial_s = null;
                        $trial_end = null;
                        $quantity = 1;
                    }

                    /* Create Plan if does not exists */
                    try {
                        Stripe::setApiKey(SecretKey);
                        Stripe_Plan::create(array(
                                "amount" => number_format($amount, 2, ".", "") * 100,
                                "interval" => $arb_interval[0],
                                "interval_count" => $arb_interval[1],
                                "trial_period_days" => $trial_s,
                                "name" => $recur_services[$service][0],
                                "currency" => AccountCurrency,
                                "id" => $recur_services[$service][0])
                        );
                    } catch (Exception $p) {
                        $plan_error = $p->getMessage();
                    }
                    /* Create and Send Stripe Request */
                    try {
                        if (!isset($_POST['stripeToken']))
                            throw new Exception("The Stripe Token was not generated correctly");

                        $token = $_POST['stripeToken'];
                        $customer = Stripe_Customer::create(array(
                                "card" => $token,
                                "plan" => $recur_services[$service][0],
                                "trial_end" => $trial_end,
                                "account_balance" => $account_balance,
                                "email" => $email)
                        );
                        $subscriptionId = $customer->id;
                        $stripe_success = 1;
                        /* You may adjust this success message. to your needs */
                        $return_msg = 'Your payment was successful.';
                    } catch (Exception $e) {
                        $stripe_success = 2;
                        $return_msg = $e->getMessage();
                    }

                    if ($stripe_success) {


                        if ($stripe_success == 2) {

                            $my_status = "<div>Subscription Un-successful!<br/>";
                            $my_status .= $subscriptionId . "<br />";
                            #$my_status .="Response Code: ".$resultCode."<br />";
                            #$my_status .="Response Reason Code: ".$code."<br />";
                            #$my_status .="Response Text: ".$text."<br /><br />";
                            $error = 0;
                            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' . $return_msg . '</div></div><br />';

                        } elseif ($stripe_success == 1) {

                            $my_status = "<br/><div>Subscription Created Successfully!<br/>";
                            $my_status .= "Subscription ID: " . $subscriptionId . "<br />";
                            $my_status .= "Thank you for your payment<br /><br />";
                            $my_status .= "Gateway Response:<br />";
                            $my_status .= $return_msg . "<br />";
                            #$my_status .="Response Reason Code: ".$code."<br />";
                            #$my_status .="Response Text: ".$text."<br /><br />";
                            $my_status .= "You will receive confirmation email within 5 minutes.<br/><br/><a href='index.php'>Return to payment page</a></div><br/>";
                            $error = 0;
                            $mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">' . $my_status . '</div></div><br />';
                            /******************************************************************
                             * ADMIN EMAIL NOTIFICATION
                             ******************************************************************/
                            $headers = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: 'Stripe Payment Terminal' <noreply@" . str_replace('www.', '', $_SERVER['HTTP_HOST']) . "> \n";
                            $subject = "New Recurring Payment Received";
                            $message = "New recurring payment was successfully received through Stripe.com <br />";
                            $message .= "from " . $fname . " " . $lname . "  on " . date('m/d/Y') . " at " . date('g:i A') . ".<br /> Payment total is: " . (strtolower(AccountCurrency) == "gbp" ? "&pound;" : "$") . number_format($amount, 2);
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $recur_services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment description: \"" . $item_description . "\"";
                            }
                            $message .= "<br/>Start Date: " . date("Y-m-d") . "<br />";
                            $message .= "Billing Frequency: " . $recur_services[$service][3] . " " . $recur_services[$service][2] . "<br />";
                            $message .= "Subscription ID: " . $subscriptionId . "<br />";
                            #$message .= "Reference ID: ".$refId."<br /><br />";
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br /><br />";

                            $message .= "If for any reason you need to cancel this subscription you can follow <a href='http://" . $_SERVER["SERVER_NAME"] . str_replace("/index.php", "", $_SERVER["REQUEST_URI"]) . "/cancel.php?subid=" . $subscriptionId . "'>this link</a><br />";
                            mail($admin_email, $subject, $message, $headers);

                            /******************************************************************
                             * CUSTOMER EMAIL NOTIFICATION
                             ******************************************************************/
                            $subject = "Payment Received!";
                            $message = "Dear " . $fname . ",<br />";
                            $message .= "<br /> Thank you for your payment.";
                            $message .= "<br /><br />";
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $recur_services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment description: \"" . $item_description . "\"";
                            }
                            $message .= "<br/>Start Date: " . date("Y-m-d") . "<br />";
                            $message .= "Billing Frequency: " . $recur_services[$service][3] . " " . $recur_services[$service][2] . "<br />";
                            $message .= "Subscription ID: " . $subscriptionId . "<br />";
                            $message .= "Reference ID: " . $refId;
                            $message .= "<br />Payment amount: " . (strtolower(AccountCurrency) == "gbp" ? "&pound;" : (strtolower(AccountCurrency) == "eur" ? "&euro;" : "$")) . number_format($amount, 2);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $fname . " " . $lname . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $address . "<br />";
                            $message .= "City: " . $city . "<br />";
                            $message .= "Country: " . $country . "<br />";
                            $message .= "State/Province: " . $state . "<br />";
                            $message .= "ZIP/Postal Code: " . $zip . "<br /><br />";
                            $message .= "If for any reason you need to cancel this subscription you can follow <a href='http://" . $_SERVER["SERVER_NAME"] . str_replace("/index.php", "", $_SERVER["REQUEST_URI"]) . "/cancel.php?subid=" . $subscriptionId . "'>this link</a>";
                            $message .= "<br /><br />Kind Regards,<br />" . $_SERVER['HTTP_HOST'];
                            mail($email, $subject, $message, $headers);
                            //-----> send notification end
                            $show_form = 0;
                            #**********************************************************************************************#
                            #		THIS IS THE PLACE WHERE YOU WOULD INSERT ORDER TO DATABASE OR UPDATE ORDER STATUS.
                            #**********************************************************************************************#

                            #**********************************************************************************************#
                        }
                    } else {
                        $count = 0;
                        $my_status = "<div>Transaction Un-successful!<br/>";
                        $my_status .= "There was an error with your credit card processing.<br/>";
                        $error = 1;
                        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' . $return_msg . '</div></div><br />';
                    }
                endif; /* End submit form condition for Recurr  */
                break;
        }


    } else if ($continue && $cctype == "PAYPAL") {
        require('includes/paypal.class.php');
        $paypal = new paypal_class;

        $paypal->add_field('business', $paypal_merchant_email);
        $paypal->add_field('return', $paypal_success_url);
        $paypal->add_field('cancel_return', $paypal_cancel_url);
        $paypal->add_field('notify_url', $paypal_ipn_listener_url);

        if ($payment_mode == "ONETIME") {
            if ($show_services) {
                $paypal->add_field('item_name_1', strip_tags(str_replace("'", "", $services[$service][0])));
            } else {
                $paypal->add_field('item_name_1', strip_tags(str_replace("'", "", $item_description)));
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
            $paypal->add_field('currency_code', $paypal_currency);


            $_SESSION["fname"] = $fname;
            $_SESSION["lname"] = $lname;
            $_SESSION["address"] = $address;
            $_SESSION["city"] = $city;
            $_SESSION["country"] = $country;
            $_SESSION["email"] = $email;
            $_SESSION["phone"] = $phone;
            $_SESSION["state"] = $state;
            $_SESSION["company"] = $company;
            $_SESSION["phone2"] = $phone2;
            $_SESSION["semail"] = $semail;
            $_SESSION["amount"] = $amount;
            $_SESSION["currency"] = $currency;
            $_SESSION["item_description"] = $item_description;
            $_SESSION["statementdescriptor"] = $statementdescriptor;
            $_SESSION["site"] = $site;
            $_SESSION["tw"] = $tw;
            $_SESSION["admin_email"] = $admin_email;


        } else if ($payment_mode == "RECUR") {
            if ($show_services) {
                $paypal->add_field('item_name', strip_tags(str_replace("'", "", $recur_services[$service][0])));
            } else {
                $paypal->add_field('item_name', strip_tags(str_replace("'", "", $item_description)));
            }
            $paypal->add_field('item_number', $transactID);

            //TRIAL PERIOD
            if ($recur_services[$service][4] != "0") {
                $paypal->add_field('a1', $recur_services[$service][5]);
                $paypal->add_field('p1', $recur_services[$service][4]);
                $paypal->add_field('t1', "D");
            }
            $paypal->add_field('a3', $amount);
            $paypal_duration = getDurationPaypal($recur_services[$service][2]); //get duration based on recurring_services array
            $paypal->add_field('p3', $recur_services[$service][3]);
            $paypal->add_field('t3', (is_array($paypal_duration) ? $paypal_duration[0] : $paypal_duration));
            $paypal->add_field('src', '1');
            $paypal->add_field('no_note', '1');
            $paypal->add_field('no_shipping', '1');
            $paypal->add_field('custom', $paypal_custom_variable);
            $paypal->add_field('currency_code', $paypal_currency);
        }
        $show_form = 0;
        $mess = $paypal->submit_paypal_post(); // submit the fields to paypal


    }


} elseif (!is_numeric($amount) || empty($amount)) {
    if ($show_services) {
        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please select service you\'re paying for.</p></div></div><br />';
    } else {
        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error!</strong> Please type amount to pay for services!</p></div></div><br />';
    }
    $show_form = 1;
}
# END OF PLEASE DO NOT EDIT IF YOU'RE NOT SURE
?>