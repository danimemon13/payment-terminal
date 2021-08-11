<?php 
include('db.php');
//session_unset();
  //  session_destroy();
session_start();

if(isset($_POST['submit']))
{
	$input = mysql_real_escape_string($_POST['inputpay']);

	$sql =  mysql_query("select * from `payment` where `last4digit` = '".$input."' ");
 	
 	$count = mysql_num_rows($sql);
	
 	if($count > 0 )
 	{
 		$select = 'yes';
 	}
 	else
	{
		$not = 'not found';
 	}
	
}


if(isset($_POST['save']))
{

	$digits = $_POST['digits'];
	$cid =		$_POST['cid'];
	$email = $_POST['email'];
	$sales = $_POST['sales'];
	$amount = $_POST['amount'];
	$type = $_POST['type'];
	$desc = $_POST['desc'];
	$state = $_POST['state'];
	define('PublishableKey', 'pk_live_pjp4sD70olzzBuOFp8Ni66oL'); //CHANGE THIS
define('SecretKey', 'sk_live_DIEMnrtqGyiplI4GIsvjdab3');// AND THIS
define('AccountCurrency', $type); //usd, eur, gbp, aud, cad
define('TEST_MODE', 'FALSE');
date_default_timezone_set("US/Eastern"); 
	require '../paynow/includes/Stripe.php';
	
						Stripe::setApiKey(SecretKey);
					try {
								    	$customer1=Stripe_Charge::create(array(
			    	/* Add here more options or the charge */
                        "amount" => number_format($amount,2,".","")*100,
		            	"currency" => AccountCurrency,
		            	"statement_descriptor" => $state,
		            	"customer" => $cid,
		            	"description" => $desc		            	
					));
					$stripe_success = 1;
					$cvcchk= $customer1->sources->cvc_check;
$zipchk= $customer1->sources->address_zip_check; 
$addrchk= $customer1->sources->address_line1_check;

$cvcchk0= $customer1->sources->data[0]->cvc_check;
$zipchk0= $customer1->sources->data[0]->address_zip_check; 
$addrchk0= $customer1->sources->data[0]->address_line1_check;


$return_msg = 'Your payment was successful. CVC check: '.$cvcchk0.' '.$cvcchk.'. Address check: '.$addrchk0.' '.$addrchk.'. ZIP CODE check: '.$zipchk0.' '.$zipchk.'';

					}
					catch(Exception $e){
						$stripe_success = 2;
						$return_msg = $e->getMessage();
					}
					
					if($stripe_success){
	

	$sql = mysql_query("INSERT INTO `transaction` VALUES ('','$cid','$email','$sales','$amount','$type','$desc','$state') ");

	if($sql)
	{
		  $_SESSION['save'] = 'your record has been sucessfully saved '.$return_msg.'';
		  
	}
	
	
	
	$sql =  mysql_query("select * from `payment` where `customer_id` = '".$cid."' ");
	$row = mysql_fetch_array($sql);
	
	
	$headers  = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: '".$state."' <noreply@".$state."> \n";
                            $subject = "Recharge Payment success $amount $type";
                            $message =  "Recharge payment was successfully received through Stripe.com  Customer ID: ".$cid." Last 4 digit ".$row['last4digit']." <br />";
                            $message .= "CVC check: $cvcchk0  ".$cvcchk.". Address check: $addrchk0 ".$addrchk.". ZIP CODE check: $zipchk0  ".$zipchk."<br />";
                            $message .= "from ".$row['firstname']." ".$row['lastname']."  on by $sales ".date('m/d/Y')." at ".date('g:i A').".<br /> Payment total is: ".(strtolower(AccountCurrency)=="gbp"?"pound":(strtolower(AccountCurrency)=="aud"?"AUD":"$")).number_format($amount,2);
                            if($show_services){
                                $message .= "<br />Payment was made for \"".$services[$service][0]."\"";
                            } else {
                                $message .= "<br />Payment description: \"".$desc."\"";
                            }
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: ".$row['firstname']." ".$row['lastname']."<br />";
                            $message .= "Email: ".$email."<br />";
                            $message .= "Address: ".$row['address']."<br />";
                            $message .= "City: ".$row['city']."<br />";
                            $message .= "Country: ".$row['country']." <br />";
                            $message .= "State/Province: ".$row['state']." Sales person email : ".$_POST['sales']."<br />";
                            $message .= "ZIP/Postal Code: ".$row['zip']." ".$row['phone']."<br />";
                            $admin_email ="billing@".$state."";
                            mail($admin_email,$subject,$message,$headers);
                            if($_POST['sales']!= "")
                            mail($_POST['sales'],$subject,$message,$headers);

                            /******************************************************************
                            CUSTOMER EMAIL NOTIFICATION
                            ******************************************************************/
                            $subject = "Payment Received!";
                            $message =  "Dear ".$row['fname'].",<br />";
                            $message .= "<br /> Thank you, Your card ending with ".$row['last4digit']." has been successfull charged.";
                            $message .= "<br /><br />";
                            if ($show_services) {
                                $message .= "<br />Payment was made for \"" . $services[$service][0] . "\"";
                            } else {
                                $message .= "<br />Payment was made for: \"" . $desc . "\"";
                            }
                            $message .= "<br />Payment amount: ".(strtolower(AccountCurrency)=="gbp"?"pound":(strtolower(AccountCurrency)=="aud"?"AUD":"$")) . number_format($amount, 2);
                            $message .= "<br /><br />Billing Information:<br />";
                            $message .= "Full Name: " . $row['fname'] . " " . $row['lname'] . "<br />";
                            $message .= "Email: " . $email . "<br />";
                            $message .= "Address: " . $row['address'] . "<br />";
                            $message .= "City: " . $row['city'] . "<br />";
                            $message .= "Country: " . $row['country'] . "<br />";
                            $message .= "State/Province: " . $row['state'] . "<br />";
                            $message .= "ZIP/Postal Code: " . $row['zip'] . "<br />";
			    $message .= "Statement Descriptor: " . $state . "<br />";
                            $message .= "<br /><br /> For any questions, Please contact  ".$admin_email."<br /><br />Kind Regards,<br />" . $state;
                            mail($email,$subject,$message,$headers);

                            //-----> send notification end
                            $show_form=0;
                            
	

					}
					
	header('location:index.php');
}



?>


<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!--webfonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text.css'/>
		<!--//webfonts-->
</head>
 
<body>
	
	<div class="main">
		<form action="index.php" method="post">
		

    		<h1><span>Payment</span> <lable>Gateway</lable> </h1>
  			<div class="inset">
	  			

				<?php 
				if(isset($select))
				{
					$row = mysql_fetch_array($sql);

				?>

						
							<p>
				    		 <label for="email">Last 4 Digits</label>
			   	 			<input type="number" placeholder=""  readonly value="<?php echo $row['last4digit']; ?>" name="digits" required/>
							</p>




							<p>
				    		 <label for="email">Customer Id</label>
			   	 			<input type="text" placeholder=""  readonly  value="<?php echo $row['customer_id']; ?>" name="cid" required/>
							</p>



							<p>
				    		 <label for="email">E-mail </label>
			   	 			<input type="text" placeholder="" readonly value="<?php echo $row['email']; ?>" name="email" required/>
							</p>

							<p>
				    		 <label for="email">Sale Person </label>
			   	 			<input type="text" placeholder=""  name="sales" required/>
							</p>

							<p>
				    		 <label for="email">Amount</label>
			   	 			<input type="text" placeholder=""  name="amount" required/>
							</p>

							<p>
				    		 <label for="email">Select Payment Type </label>

					    		<select class="curr_type" name="type">
					    			<option value="USD" >USD</option>
					    			<option value="AUD">AUD</option>
					    			<option value="GBP">GBP</option>
					    		</select>
							</p>

							<p>
				    		 <label for="email">Desciption</label>
			   	 			<input type="text" placeholder="" name="desc" required/>
							</p>
							<p>
				    		 <label for="email">Statement Description</label>
				    		 					    		<select class="state" name="state">
					    			<option value="OCTALOGO.COM" >OCTALOGO.COM</option>
					    			<option value="LOGOSCIENTIST.NET">LOGOSCIENTIST.NET</option>
					    			<option value="OCTACHAT.COM">OCTACHAT.COM</option>
					    		</select>
			   	 			
							</p>

							<p class="p-container">

							 	 <input type="submit" value="Enter" name="save" >
							</p>
						


				<?php 

			}
			else
			{?>


			<p>
	    		 <label for="email">Enter Last 4 Digits</label>
   	 			<input type="number" placeholder="Enter last four digits" maxlength="4" name="inputpay" required/>
			</p>


			
			   	<?php if(isset($not))
			   	{
			   		echo ' <label for="email" style="color:red; ">Number you have entered is incorrect</label>';	
			   	}
			   	
			   	if(isset($_SESSION['save']))
			   	{

			   		echo ' <label for="email">'.$_SESSION['save'].'</label>';
			   		
			   	}

			   	 ?>
			<p class="p-container">

			 	 <input type="submit" value="Enter" name="submit">
			</p>

			<?php 
					}
			?>
 				

 			</div>


 	 
		 </form>
	</div>  
			
   	<div class="copy-right">
			<p>Design by <a href="http://octalogo.com/">OCTALOGO</a></p> 
	</div>

				<!-----//end-copyright---->
</body>
</html>