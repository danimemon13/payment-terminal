<?php
	//end IP location
	require("includes/config.php"); //important file. Don't forget to edit it!
	//DEFAULT PARAMETERS FOR FORM [!DO NOT EDIT!]
	$show_form = 1;
	$mess = "";
	//REQUEST VARIABLES
	$item_description = (!empty($_REQUEST["item_description"])) ? strip_tags(str_replace("'", "`", $_REQUEST["item_description"])) : '';
	//$amount = (!empty($_REQUEST["amount"])) ? strip_tags(str_replace("'", "`", $_REQUEST["amount"])) : '';
	$fname = (!empty($_REQUEST["fname"])) ? strip_tags(str_replace("'", "`", $_REQUEST["fname"])) : '';
	$lname = (!empty($_REQUEST["lname"])) ? strip_tags(str_replace("'", "`", $_REQUEST["lname"])) : '';
	$email = (!empty($_REQUEST["email"])) ? strip_tags(str_replace("'", "`", $_REQUEST["email"])) : '';
	$address = (!empty($_REQUEST["address"])) ? strip_tags(str_replace("'", "`", $_REQUEST["address"])) : '';
	$city = (!empty($_REQUEST["city"])) ? strip_tags(str_replace("'", "`", $_REQUEST["city"])) : '';
	$country = (!empty($_REQUEST["country"])) ? strip_tags(str_replace("'", "`", $_REQUEST["country"])) : 'US';
	$state = (!empty($_REQUEST["state"])) ? strip_tags(str_replace("'", "`", $_REQUEST["state"])) : '';
	$zip = (!empty($_REQUEST["zip"])) ? strip_tags(str_replace("'", "`", $_REQUEST["zip"])) : '';
	$service = (!empty($_REQUEST['service'])) ? strip_tags(str_replace("'", "`", strip_tags($_REQUEST['service']))) : '0';
	//$company = (!empty($_REQUEST['company']))?strip_tags(str_replace("'","`",strip_tags($_REQUEST['company']))):'';
	$phone2 = (!empty($_REQUEST['phone2'])) ? strip_tags(str_replace("'", "`", strip_tags($_REQUEST['phone2']))) : '';
	$tw = (!empty($_REQUEST['tw'])) ? strip_tags(str_replace("'", "`", strip_tags($_REQUEST['tw']))) : '';
	$site = (!empty($_REQUEST['site'])) ? strip_tags(str_replace("'", "`", strip_tags($_REQUEST['site']))) : '';
	//FORM SUBMISSION PROCESSING
	if (!empty($_POST["process"]) && $_POST["process"] == "yes") {
	
	    //if($company =="")
	    $company = "$fname $lname";
	    //$company = "";
	    require("includes/form.processing.php");
	}
	//REQUIRE SITE HEADER TEMPLATE
	require "includes/site.header.php";
	
	
	//JM modification
	
	if ($_REQUEST["item"])
	    $item_description = $_REQUEST["item"];
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Payment Terminal</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="assets/images/favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.css">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/style.css" />
		<link rel="stylesheet" href="assets/css/responsive.css" />
		
		
        <link rel="stylesheet" href="./js/jquery.numpad.css">
		
		<style type="text/css">
			#loading-sp {
			display: none;
			background: #000;
			opacity: 0.77;
			bottom: 0;
			left: 0;
			position: fixed;
			right: 0;
			top: 0;
			z-index: 9999999;
			}
			#load {
			position: absolute;
			height: 36px;
			top: 40%;
			overflow: visible;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			cursor: default;
			color: #fff;
			text-align: center;
			width: 100%;
			}
			#load div {
			position: absolute;
			width: 20px;
			height: 36px;
			opacity: 0;
			font-family: Helvetica, Arial, sans-serif;
			animation: move 2s linear infinite;
			-o-animation: move 2s linear infinite;
			-moz-animation: move 2s linear infinite;
			-webkit-animation: move 2s linear infinite;
			transform: rotate(180deg);
			-o-transform: rotate(180deg);
			-moz-transform: rotate(180deg);
			-webkit-transform: rotate(180deg);
			color: #cdcdcd;
			font-weight: bold;
			font-size: 16px;
			}
			#load div:nth-child(2) {
			animation-delay: 0.2s;
			-o-animation-delay: 0.2s;
			-moz-animation-delay: 0.2s;
			-webkit-animation-delay: 0.2s;
			}
			#load div:nth-child(3) {
			animation-delay: 0.4s;
			-o-animation-delay: 0.4s;
			-webkit-animation-delay: 0.4s;
			-webkit-animation-delay: 0.4s;
			}
			#load div:nth-child(4) {
			animation-delay: 0.6s;
			-o-animation-delay: 0.6s;
			-moz-animation-delay: 0.6s;
			-webkit-animation-delay: 0.6s;
			}
			#load div:nth-child(5) {
			animation-delay: 0.8s;
			-o-animation-delay: 0.8s;
			-moz-animation-delay: 0.8s;
			-webkit-animation-delay: 0.8s;
			}
			#load div:nth-child(6) {
			animation-delay: 1s;
			-o-animation-delay: 1s;
			-moz-animation-delay: 1s;
			-webkit-animation-delay: 1s;
			}
			#load div:nth-child(7) {
			animation-delay: 1.2s;
			-o-animation-delay: 1.2s;
			-moz-animation-delay: 1.2s;
			-webkit-animation-delay: 1.2s;
			}
			@keyframes move {
			0% {
			left: 0;
			opacity: 0;
			}
			35% {
			left: 41%;
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			65% {
			left: 59%;
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			100% {
			left: 100%;
			-moz-transform: rotate(-180deg);
			-webkit-transform: rotate(-180deg);
			-o-transform: rotate(-180deg);
			transform: rotate(-180deg);
			opacity: 0;
			}
			}
			@-moz-keyframes move {
			0% {
			left: 0;
			opacity: 0;
			}
			35% {
			left: 41%;
			-moz-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			65% {
			left: 59%;
			-moz-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			100% {
			left: 100%;
			-moz-transform: rotate(-180deg);
			transform: rotate(-180deg);
			opacity: 0;
			}
			}
			@-webkit-keyframes move {
			0% {
			left: 0;
			opacity: 0;
			}
			35% {
			left: 41%;
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			65% {
			left: 59%;
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			100% {
			left: 100%;
			-webkit-transform: rotate(-180deg);
			transform: rotate(-180deg);
			opacity: 0;
			}
			}
			@-o-keyframes move {
			0% {
			left: 0;
			opacity: 0;
			}
			35% {
			left: 41%;
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			65% {
			left: 59%;
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
			opacity: 1;
			}
			100% {
			left: 100%;
			-o-transform: rotate(-180deg);
			transform: rotate(-180deg);
			opacity: 0;
			}
			}
		</style>
	</head>
	<body>
	    
		<div class="index-wrap">
		    <?php include "includes/javascript.validation.php"; ?>
		    <div class="bg"
                 style="width:100%;display:none; height:200%; background-color:gray; z-index: 999; position: absolute; opacity: 0.56;">
                <h1>Processing take a minute</h1>
            </div>
			<section class="sec-1">
				<div class="container">
					<div class="pg-top">
						<p class="title">Payment Hub TERMINAL</p>
						<p class="sub-title">PAY & PROCEED</p>
					</div>
					<?php echo $mess; ?>
					<form id="ff1" name="ff1" method="post" action="" enctype="multipart/form-data" onsubmit="return false;" class="payment-form">
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<p class="g-title">Payment Information</p>
								</div>
							</div>
							<?php if ($show_services || $payment_mode == "RECUR") {
								echo "<label>Service: </label><select name='service' id='service' class='long-field' onchange='checkFieldBack(this)'><option value=''>Please Select</option>";
								switch ($payment_mode) {
								
								    case"ONETIME":
								        //IF services specified in config file - we show services.
								
								        foreach ($services as $k => $v) {
								            echo "<option value='" . $k . "' " . ($service == $k ? "selected" : "") . ">" . $v[0] . " (" . (strtolower(AccountCurrency) == "gbp" ? "&pound;" : (strtolower(AccountCurrency) == "eur" ? "&euro;" : "$")) . number_format($v[1], 2) . ")" . "</option>";
								        }
								        echo "</select><div class='clr'></div>";
								        break;
								    case"RECUR":
								        //IF services specified in config file - we show services.
								
								        foreach ($recur_services as $k => $v) {
								            echo "<option value='" . $k . "' " . ($service == $k ? "selected" : "") . ">" . $v[0] . " (" . (strtolower(AccountCurrency) == "gbp" ? "&pound;" : (strtolower(AccountCurrency) == "eur" ? "&euro;" : "$")) . number_format($v[1], 2) . ")" . "</option>";
								        }
								        echo "</select><div class='clr'></div>";
								
								        break;
								}
								} else { ?>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">Description</label>
									<input type="text" name="item_description" id="item_description" readonly value="<?php echo $item_description; ?>" onkeyup="checkFieldBack(this);">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">Amount: <?php echo strtoupper($currency); ?></label>
									<input name="semail" type="hidden" value="<?php echo $_GET['semail']; ?>">
									<input name="tw" type="hidden" value="<?php echo $_GET['tw']; ?>">
									<input type="text" name="amount" id="amount" readonly value="<?php echo $amount; ?>" onkeyup="checkFieldBack(this);noAlpha(this);" onkeypress="noAlpha(this);">
								</div>
							</div>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<p class="g-title">Billing Information</p>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">First Name</label>
									<input type="text" placeholder="Enter Your First Name" name="fname" id="fname" value="<?php echo $fname; ?>">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">Last Name</label>
									<input type="text" placeholder="Enter Your Last Name" name="lname" id="lname" value="<?php echo $lname; ?>">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">Address</label>
									<input type="text" placeholder="Enter Address" name="address" id="address" value="<?php echo $address; ?>">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-6">
										<div class="form-group">
											<label for="">City</label>
											<input type="text" placeholder="Enter City" name="city" id="city" value="<?php echo $city; ?>">
											<input name="ipcountry" type="hidden" value="<? echo $ipcountry ?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-6">
										<div class="form-group">
											<label for="">Country</label>
											<select name="country" id="country"></select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">State/Province</label>
									<select name="state" id="state">
									      <option value="">Please Select</option>
                            <optgroup label="Australian Provinces">
                                <option value="-AU-NSW">New South
                                    Wales
                                </option>
                                <option value="-AU-QLD">Queensland
                                </option>
                                <option value="-AU-SA">South
                                    Australia
                                </option>
                                <option value="-AU-TAS">Tasmania
                                </option>
                                <option value="-AU-VIC">Victoria
                                </option>
                                <option value="-AU-WA">Western
                                    Australia
                                </option>
                                <option value="-AU-ACT">Australian
                                    Capital Territory
                                </option>
                                <option value="-AU-NT">Northern
                                    Territory
                                </option>
                            </optgroup>
                            <optgroup label="Canadian Provinces">
                                <option value="AB">Alberta</option>
                                <option value="BC">British Columbia
                                </option>
                                <option value="MB">Manitoba</option>
                                <option value="NB">New Brunswick</option>
                                <option value="NF">Newfoundland</option>
                                <option value="NT">Northwest
                                    Territories
                                </option>
                                <option value="NS">Nova Scotia</option>
                                <option value="NVT">Nunavut</option>
                                <option value="ON">Ontario</option>
                                <option value="PE">Prince Edward Island
                                </option>
                                <option value="QC">Quebec</option>
                                <option value="SK">Saskatchewan</option>
                                <option value="YK">Yukon</option>
                            </optgroup>
                            <optgroup label="US States">
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="BVI">British Virgin
                                    Islands
                                </option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="GU">Guam</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MP">Mariana Islands
                                </option>
                                <option value="MPI">Mariana Islands
                                    (Pacific)
                                </option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina
                                </option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina
                                </option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="USVI">VI U.S. Virgin
                                    Islands
                                </option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="DC">Washington, D.C.
                                </option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </optgroup>
                            <!-- FOR STRIPE UK -->
                            <optgroup label="England">
                                <option>Bedfordshire</option>
                                <option>Berkshire</option>
                                <option>Bristol</option>
                                <option>Buckinghamshire
                                </option>
                                <option>Cambridgeshire
                                </option>
                                <option>Cheshire</option>
                                <option>City of London
                                </option>
                                <option>Cornwall</option>
                                <option>Cumbria</option>
                                <option>Derbyshire</option>
                                <option>Devon</option>
                                <option>Dorset</option>
                                <option>Durham</option>
                                <option>East Riding
                                    of Yorkshire
                                </option>
                                <option>East Sussex</option>
                                <option>Essex</option>
                                <option>Gloucestershire
                                </option>
                                <option>Greater London
                                </option>
                                <option>Greater
                                    Manchester
                                </option>
                                <option>Hampshire</option>
                                <option>Herefordshire</option>
                                <option>Hertfordshire</option>
                                <option>Isle of Wight</option>
                                <option>Kent</option>
                                <option>Lancashire</option>
                                <option>Leicestershire
                                </option>
                                <option>Lincolnshire</option>
                                <option>Merseyside</option>
                                <option>Norfolk</option>
                                <option>North Yorkshire
                                </option>
                                <option>Northamptonshire
                                </option>
                                <option>Northumberland
                                </option>
                                <option>Nottinghamshire
                                </option>
                                <option>Oxfordshire</option>
                                <option>Rutland</option>
                                <option>Shropshire</option>
                                <option>Somerset</option>
                                <option>South Yorkshire
                                </option>
                                <option>Staffordshire</option>
                                <option>Suffolk</option>
                                <option>Surrey</option>
                                <option>Tyne and Wear</option>
                                <option>Warwickshire</option>
                                <option>West Midlands</option>
                                <option>West Sussex</option>
                                <option>West Yorkshire
                                </option>
                                <option>Wiltshire</option>
                                <option>Worcestershire
                                </option>
                            </optgroup>
                            <optgroup label="Scotland">
                                <option>Aberdeenshire</option>
                                <option>Angus</option>
                                <option>Argyllshire</option>
                                <option>Ayrshire</option>
                                <option>Banffshire</option>
                                <option>Berwickshire</option>
                                <option>Buteshire</option>
                                <option>Cromartyshire</option>
                                <option>Caithness</option>
                                <option>Clackmannanshire
                                </option>
                                <option>Dumfriesshire</option>
                                <option>Dunbartonshire
                                </option>
                                <option>East Lothian</option>
                                <option>Fife</option>
                                <option>Inverness-shire
                                </option>
                                <option>Kincardineshire
                                </option>
                                <option>Kinross</option>
                                <option>
                                    Kirkcudbrightshire
                                </option>
                                <option>Lanarkshire</option>
                                <option>Midlothian</option>
                                <option>Morayshire</option>
                                <option>Nairnshire</option>
                                <option>Orkney</option>
                                <option>Peeblesshire</option>
                                <option>Perthshire</option>
                                <option>Renfrewshire</option>
                                <option>Ross-shire</option>
                                <option>Roxburghshire</option>
                                <option>Selkirkshire</option>
                                <option>Shetland</option>
                                <option>Stirlingshire</option>
                                <option>Sutherland</option>
                                <option>West Lothian</option>
                                <option>Wigtownshire</option>
                            </optgroup>
                            <optgroup label="Wales">
                                <option>Anglesey</option>
                                <option>Brecknockshire
                                </option>
                                <option>Caernarfonshire
                                </option>
                                <option>Carmarthenshire
                                </option>
                                <option>Cardiganshire</option>
                                <option>Denbighshire</option>
                                <option>Flintshire</option>
                                <option>Glamorgan</option>
                                <option>Merioneth</option>
                                <option>Monmouthshire</option>
                                <option>Montgomeryshire
                                </option>
                                <option>Pembrokeshire</option>
                                <option>Radnorshire</option>
                            </optgroup>
                            <optgroup label="Northern Ireland">
                                <option>Antrim</option>
                                <option>Armagh</option>
                                <option>Down</option>
                                <option>Fermanagh</option>
                                <option>Londonderry</option>
                                <option>Tyrone</option>
                            </optgroup>
                            <!-- FOR STRIPE UK END-->
                            <option value="N/A">Other</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-6">
										<div class="form-group">
											<label for="">Zip/Postal Code</label>
											<input type="text" placeholder="Zip/Postal Code" name="zip" id="zip" value="<?php echo $zip; ?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-6">
										<div class="form-group">
											<label for="">Email Address</label>
											<input type="text" placeholder="Email" name="email" id="email" value="<?php echo $email; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<p class="g-title">Credit Card Information</p>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group radio-group">
									<label class="d-block">I Have</label>
									<div>
										<input name="cctype" value="V" type="radio" id="visa">
										<label for="visa"><img class="img-fluid" src="assets/images/visa.png" alt="icon"></label>
									</div>
									<div>
										<input name="cctype" value="M" type="radio"  id="master-card">
										<label for="master-card"><img class="img-fluid" src="assets/images/master-card.png" alt="icon"></label>
									</div>
									<div>
										<input name="cctype" value="A" type="radio"  id="american-express">
										<label for="american-express"><img class="img-fluid" src="assets/images/american-express.png" alt="icon"></label>
									</div>
									<div>
										<input name="cctype" value="D" type="radio" id="discover">
										<label for="discover"><img class="img-fluid" src="assets/images/discover.png" alt="icon"></label>
									</div>
									<?php if ($enable_paypal && $_GET['pp'] != 0) { ?>
									<input name="cctype" type="radio" value="PP" class="lft-field isPayPal"/> <img src="images/ico_paypal.png" width="37" height="11" align="absmiddle" class="lft-field paypal cardhide PP"/>
									<?php } ?>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">Card Holder Name</label>
									<input type="text" placeholder="Full Name" name="ccname" id="ccname">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">Card Number</label>
									<div class="card-info">
										<input type="text" class="number <? if ($isadmin) echo " text-basic"; ?>" placeholder="Card Number" name="ccn" id="ccn"
											onkeyup="checkNumHighlight(this.value);checkFieldBack(this);noAlpha(this);" value=""
											onkeypress="checkNumHighlight(this.value);noAlpha(this);"
											onblur="checkNumHighlight(this.value);" onchange="checkNumHighlight(this.value);"
											maxlength="16" <? if ($isadmin) echo "style=\"background-color: rgb(248, 248, 248);\""; ?>>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-6">
										<div class="form-group">
											<label for="">Expiration Month:</label>
											<select name="exp1" id="exp1" onchange="checkFieldBack(this);">
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-6">
										<div class="form-group">
											<label for="">Expiration Year:</label>
											<select name="exp2" id="exp2" class="small-field" onchange="checkFieldBack(this);">
												<option value="2021">2021</option>
												<option value="2022">2022</option>
												<option value="2023">2023</option>
												<option value="2024">2024</option>
												<option value="2025">2025</option>
												<option value="2026">2026</option>
												<option value="2027">2027</option>
												<option value="2028">2028</option>
												<option value="2029">2029</option>
												<option value="2030">2030</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="">CVV</label>
									<div class="card-info">
										<input type="text" class="number" id="cvv" placeholder="CVV" maxlength="5">
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group radio-group check-group">
									<input type="checkbox" id="cc_terms" checked>
									<label><a href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">I agree to terms and conditions</a></label>
									<!--<label><a >I agree to terms and conditions</a></label>-->
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="captcha-box">
									<style>
										.g-recaptcha{margin:25px 60px;} 
									</style>
									<div class="g-recaptcha" data-sitekey="6Lc-plMaAAAAAJKcBEFIDehinU8gkK3r5KfS3ASW"></div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 mt-3">
							    <input type="hidden" name="process" value="yes"/>
								<button class="submit">PAY NOW</button>
								<!--<div class="submit"><input  type="submit" name="submit" ></div>-->
								
							</div>
						</div>
				</div>
				</form>
		</div>
		</section>
		<footer>
			<div class="container">
				<div class="footer-icon">
					<div>
						<img class="img-fluid" src="assets/images/nortan.png" alt="icon">
					</div>
					<div>
						<img class="img-fluid" src="assets/images/mcafee.png" alt="icon">
					</div>
					<div>
						<img class="img-fluid" src="assets/images/bbb.png" alt="icon">
					</div>
					<div>
						<img class="img-fluid" src="assets/images/trustee.png" alt="icon">
					</div>
				</div>
			</div>
		</footer>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Terms & Conditions</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p>You accept that you are making the payment for delivery of services only. We are not liable for the results and outcome of the product / services usage at your end. You must use the products / services within ethical, legal and defined protocols. Any hazardous or illegal use of our services is strongly prohibited.
Customer must make the payment with his own card. If you are using the card of anyone else, without his consent, this is a serious crime, and if, the person has given you the consent, you should provide that consent and inform the billing team prior to making the payments. If any transaction is claimed to be unknown to the cardholder, customer will be held responsible for that and he can, if required, face the legal proceedings until the case is resolved from bank and cardholders’ end. 
Amount is charged for services and processing. 35% of the amount is administrative and processing fee that is not refundable if your services process is initiated and experts started their work on. 
You can claim the refund of your money only if, 1) services are not processed; 2) up to 50% refund can be applied if working started but not delivered; 3) up to 25% refund if service is delivered but you are not satisfied. All refunds must be claimed within 15 days of delivery or 30 days of order placement date. All refunds are processed through proper investigation and if you are qualified for a refund, you will receive it within 30 days (after refund claim request).
Please note that while making the payments, you should provide all necessary details to be worked upon, any changes in instructions may incur additional services fee
</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<!--<button type="button" class="btn btn-primary">Save changes</button>-->
					</div>
				</div>
			</div>
		</div>
		<?php require "includes/site.footer.php"; ?>
		<div id="loading-sp" style="display: none;">
			<div id="load">
				Please Wait. Your transaction is processing...
			</div>
		</div>
		
		<?php echo $zopim_zendesk; ?>
		