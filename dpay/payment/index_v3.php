<?php

  $site_host = $_SERVER['HTTP_HOST'] ;
  
  if(strpos($site_host,".dev.pk") || $site_host == "localhost")
  {
    define('ENVIRONMENT', 'development');
  }
  else{
    define('ENVIRONMENT', 'production');
  }

if(ENVIRONMENT == 'development'){
  
  $link = mysql_connect('localhost', 'root', '')  or die('Could not connect: ' . mysql_error());
  mysql_select_db('pg_payment') or die('Could not select database');
}
else{
  $link = mysql_connect('mysql1003.mochahost.com', 'octapay_ustripe', 'P@Str!pe')
    or die('Could not connect: ' . mysql_error());

  mysql_select_db('octapay_stripe') or die('Could not select database');
}

if (mysqli_connect_errno()) {
    printf("Соединение не установлено: %s\n", mysqli_connect_error());
    exit();
}



if(count($_POST) > 0){

  if($_POST['cemail'] != '' && $_POST['cname'] != '' && $_POST['myproducts'] != ''){
  
  $myproducts = $_POST['myproducts']  ;
  $productData = $_POST['cproduct'.$myproducts] ;
  $query = "INSERT INTO userdata 
  (sales_email,email,name,item,product_detail,amount,currency,site_id,gateway)
  VALUES   
  (
  '".$_POST['semail']."',
  '".$_POST['cemail']."',
  '".$_POST['cname']."',
  '".$_POST['item']."',
  '".$productData."',
  '".$_POST['amount']."',
  '".$_POST['currency']."',
  '".$_POST['site']."',
  '".$_POST['gateway']."'
  )
  ";
  //echo $query;exit;
  mysql_query($query);
  //$lastID = $mysqli->insert_id;


       switch($_POST['currency'])
       {
       case "USD":
       if($_POST['site']==2)
       $coac="202620446";
       if($_POST['site']==1 or $_POST['site']==3 )
       $coac="102625075";
       break;
       case "GBP":
       $coac="102668005";
       break;
       case "AUD":
       $coac="102669721";
       break;
       }
                  
                        
                            

if($_POST['cemail'] != "" && $_POST['semail']!="")
{


                            if($_POST['gateway']==1)
                            $gatewayurl="https://www.octagroup.net/pg/bt/index.php?amount=".$_POST['amount']."&currency=".$_POST['currency']."&item=".$_POST['item']."&semail=".$_POST['semail']."&site=".$_POST['site']."&pp=".$_POST['pp']."&tw=".$_POST['tw']."";
                            if($_POST['gateway']==2)
                            $gatewayurl="https://www.octagroup.net/pg/paynow/index.php?amount=".$_POST['amount']."&currency=".$_POST['currency']."&item=".$_POST['item']."&semail=".$_POST['semail']."&site=".$_POST['site']."&pp=".$_POST['pp']."&tw=".$_POST['tw']."";
                            if($_POST['gateway']==3)
                            $gatewayurl="https://www.2checkout.com/checkout/purchase?sid=".$coac."&mode=2CO&li_0_type=".$_POST['item']."&li_0_name=".$_POST['item']."&li_0_price=".$_POST['amount']."";
                            
   
   
$headers  = "MIME-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=utf-8\n";
                            $headers .= "From: ".$_POST['semail']."\n";
   if($_POST['site']==1)
   $website="OctaLogo.com";
   elseif ($_POST['site'] ==2)
   $website="LogoScientist.net";
   elseif ($_POST['site'] ==3)
   $website="OctaChat.com";                         
                            
                            

                            
                            $subject = "$website Invoice ";
                            $message =  "Dear Customer<br />";
                            $message .= "<br /><br />An invoice of amount <b/>".$_POST['currency']." ".$_POST['amount']." </b>has been generated for<br />";

                            $message .= "<b>".$_POST['item']."</b><br />";
                            $message .= "<br /><br /><a href='".$gatewayurl."'>Click here to process this invoice now</a><br />";

                            $message .= "<br /><br />Please contact ".$_POST['semail']." for any questions.<br /><br /><br />Thank you,<br />$website";
                            mail($_POST['cemail'],$subject,$message,$headers);
                            mail($_POST['semail'],$subject,$message,$headers);

$message2 = " An email has been sent to customer with following content<br \><br \>";



}
elseif($_POST['amount'] != "")
{
  // $2courl="https://www.2checkout.com/checkout/purchase?sid=1303908&mode=2CO&li_0_type=product&li_0_name=customAmount&li_0_price=1.00" 
   
   
                               if($_POST['gateway']==1)
                            $gatewayurl="https://www.octagroup.net/pg/bt/index.php?amount=".$_POST['amount']."&currency=".$_POST['currency']."&item=".$_POST['item']."&semail=".$_POST['semail']."&site=".$_POST['site']."&pp=".$_POST['pp']."&tw=".$_POST['tw']."";
                            if($_POST['gateway']==2)
                            $gatewayurl="https://www.octagroup.net/pg/paynow/index.php?amount=".$_POST['amount']."&currency=".$_POST['currency']."&item=".$_POST['item']."&semail=".$_POST['semail']."&site=".$_POST['site']."&pp=".$_POST['pp']."&tw=".$_POST['tw']."";
                            if($_POST['gateway'] ==3)
                            $gatewayurl="https://www.2checkout.com/checkout/purchase?sid=".$coac."&mode=2CO&li_0_type=".$_POST['item']."&li_0_name=".$_POST['item']."&li_0_price=".$_POST['amount']."";
                            
                           
exit(header("Location: ".$gatewayurl.""));
}
$errorMEssage = '';


}
else{
    $messageError = "Please provide the client information";
}

}



?>
<!DOCTYPE html>
<!-- saved from url=(0041)http://jmansoor.coffeecup.com/forms/form/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <!-- Start of the headers for CoffeeCup Web Form Builder -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="./form_files/form_init.js" data-name="" id="form_init_script">
    </script><link rel="stylesheet" type="text/css" href="./form_files/jquery-ui-1.8.5.custom.css"><link rel="stylesheet" type="text/css" href="./form_files/normalize.css"><link rel="stylesheet" type="text/css" href="./form_files/jquery.signaturepad.css"><script type="text/javascript" src="./form_files/jquery-1.4.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./form_files/default.css" id="theme">
    <!-- End of the headers for CoffeeCup Web Form Builder -->
    <title>
      form for New payment -- To recharge <a href="https://www.octagroup.net/pg/recharge/index.php">clikc here</a>
    </title>
  <script type="text/javascript" src="./form_files/jquery-ui-1.8.9.custom.min.js"></script><script type="text/javascript" src="./form_files/jquery.ui.datepicker.js"></script><script type="text/javascript" src="./form_files/easyXDM.min.js"></script><script type="text/javascript" src="./form_files/jquery.validate.js"></script><script type="text/javascript" src="./form_files/jquery.metadata.js"></script><script type="text/javascript" src="./form_files/jquery.placeholder.min.js"></script><script type="text/javascript" src="./form_files/validation_data.js"></script><script type="text/javascript" src="./form_files/validation.js"></script><script type="text/javascript" src="./form_files/conditionals.js"></script><script type="text/javascript" src="./form_files/jquery.signaturepad.min.js"></script><script type="text/javascript" src="./form_files/messages_validation.js"></script><script type="text/javascript" src="./form_files/messages_datepicker.js"></script></head>
  
  <body><!-- Start of the body content for CoffeeCup Web Form Builder -->
<style>#docContainer .fb_cond_applied{ display:none; }</style><noscript>&lt;style&gt;#docContainer .fb_cond_applied{ display:inline-block; }&lt;/style&gt;</noscript><form id="docContainer" enctype="multipart/form-data" method="POST"  novalidate="novalidate" class="fb-toplabel fb-100-item-column selected-object" data-form="publish">
  <div id="fb-form-header1" class="fb-form-header" style="min-height: 0px;">
    <a id="fb-link-logo1" class="fb-link-logo" target="_blank"><img alt="Alternative text" title="Alternative text" id="fb-logo1" class="fb-logo" src="./form_files/image_default.png" style="display:none"></a>
  </div>
  <div id="section1" class="section">
    <div id="column1" class="column ui-sortable"><div style="display:none; min-height:200px;" id="fb_confirm_inline">
      </div><div style="display:none;" id="fb_error_report">
      </div><div id="item1" class="fb-item fb-100-item-column">
        <div class="fb-header">
          <h2 style="display: inline;">
            Link Generator for Payment <br> <? echo "".(isset($message2) ? $message2 : '')."".(isset($subject) ? $subject : '')."";?> <br> <?=(isset($message) ? $message : '')?><br>
          </h2>
        </div>
      </div><div id="item3" class="fb-item fb-25-item-column" style="opacity: 1;">
<div style="color:red;width: 220px;"> <?=$messageError?> </div>
        <div class="fb-grouplabel">
          <label id="item3_label_0" style="display: inline; font-style: normal;">Amount</label>
        </div>
        <div class="fb-input-box">
          <input type="text" id="item3_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="amount" required="">
        </div>
      </div><div id="item5" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item5_label_0" style="display: inline;">Currency</label>
        </div>
        <div class="fb-dropdown">
          <select id="item5_select_1" data-hint="" name="currency">
            <option id="item5_0_option" selected="" value="USD">
              USD
            </option>
            <option id="item5_1_option" value="AUD">
              AUD
            </option>
            <option id="item5_2_option" value="GBP">
              GBP
            </option>
          </select>
        </div>
      </div><div id="item4" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item4_label_0" style="display: inline;">Description</label>
        </div>
        <div class="fb-input-box">
          <input type="text" id="item4_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="item">
        </div>
      </div><div id="item7" class="fb-item fb-three-column fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item7_label_0" style="display: inline;">Website</label>
        </div>
        <div class="fb-radio">
          <label id="item7_0_label"><input type="radio" checked="" id="item7_0_radio" data-hint="" name="site" value="1"><span class="fb-fieldlabel" id="item7_0_span">Octalogo.com</span></label>
          <label id="item7_1_label"><input type="radio" id="item7_1_radio" name="site" value="2"><span class="fb-fieldlabel" id="item7_1_span">LogoScientist.net</span></label>
          <label id="item7_2_label"><input type="radio" id="item7_2_radio" name="site" value="3"><span class="fb-fieldlabel" id="item7_2_span">Octachat.com</span></label>
        </div>
      </div>
      <div id="item7" class="fb-item fb-three-column fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item7_label_0" style="display: inline;">Payment gateway</label>
        </div>
        <div class="fb-radio">
          <label id="item7_0_label"><input type="radio"  id="item7_0_radio" data-hint="" name="gateway" value="1" checked="checked"><span class="fb-fieldlabel" id="item7_0_span">Braintree</span></label>
          <label id="item7_1_label"><input type="radio" id="item7_1_radio" name="gateway" value="2" ><span class="fb-fieldlabel" id="item7_1_span">Stripe</span></label>
         
          <label id="item7_1_label"><input type="radio" id="item7_1_radio" name="gateway" value="3" ><span class="fb-fieldlabel" id="item7_1_span">2CO or 2co PAYPAL</span></label>
           
        </div>
      </div>
      <div id="item9" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item9_label_0" style="display: inline;">Sales person email</label>
        </div>
        <div class="fb-input-box">
          <input type="text" id="item9_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="semail">
          <div class="fb-hint" style="color: rgb(136, 136, 136); font-weight: normal; font-style: normal;">
            This email will get an alert when the customer will make the payment other
            then default alert emails of billing@...
          </div>
        </div>

        <div id="item9" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item9_label_0" style="display: inline;">Customer  email *</label>
        </div>
        <div class="fb-input-box">
          <input type="text" id="item9_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="cemail">
          <!--div class="fb-hint" style="color: rgb(136, 136, 136); font-weight: normal; font-style: normal;">
            OPTIONAL... Customer will get an alert with a link of payment in email. Sales person will also get a copy of that email. 
          </div-->
          </div>
        </div>


        <div id="item9" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item9_label_0" style="display: inline;">Customer Name *</label>
        </div>
        <div class="fb-input-box">
          <input type="text" id="item9_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="cname">
          <!--div class="fb-hint" style="color: rgb(136, 136, 136); font-weight: normal; font-style: normal;">
            OPTIONAL... Customer will get an alert with a link of payment in email. Sales person will also get a copy of that email. 
          </div-->

          </div>
        </div>


        <div id="item9" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel">
          <label id="item9_label_0" style="display: inline;">Product Type *</label>
        </div>
        <div class="fb-input-box">

        <select  data-hint="" name="myproducts" id="myproduct">
          <option id="item5_0_option" selected="" value="0">
              Select Package Type
          </option>
          <option id="item5_0_option" value="1">
              Logo Packages
          </option>
          <option id="item5_0_option" value="2">
              Website Design
          </option>
          <option id="item5_0_option" value="3">
              Corporate Branding
          </option>          
          <option id="item5_0_option" value="4">
              Mobile Application
          </option> 
        </select>

        <?php
        $logo = array(
          '1'=>'Logo Packages - Basic Logo',
          '2'=>'Logo Packages - Startup Logo',
          '3'=>'Logo Packages - Professional Logo',
          '4'=>'Logo Packages - Identity Logo',
          '5'=>'Logo Packages - Corporate Logo',
          '6'=>'Logo Packages - Elite Logo'
          );
        $website = array(
          '1'=>'Website Design - Basic Web Package',
          '2'=>'Website Design - Startup Web Package',
          '3'=>'Website Design - Professional Web',
          '4'=>'Website Design - E-Commerce Web Package',
          '5'=>'Website Design - Corporate Web',
          '6'=>'Website Design - Elite Web',
          '7'=>'Website Design - Scientific Basic Combo',
          '8'=>'Website Design - Scientific Start Up Combo',
          '9'=>'Website Design - Scientific Professional Combo',
          '10'=>'Website Design - Scientific Elite Combo'
          );
        $corporate = array(
          '1'=>'Corporate Branding - Basic Stationary Package',
          '2'=>'Corporate Branding - Startup Stationary Package',
          '3'=>'Corporate Branding - 1 Page Flyer Package',
          '4'=>'Corporate Branding - Professional Stationary Pack',
          '5'=>'Corporate Branding - Tri-Fold Brochure Package',
          '6'=>'Corporate Branding - Sinage Design',
          '7'=>'Corporate Branding - Car Wrap Design',
          '8'=>'Corporate Branding - 4 Page Brochure Package',
          '9'=>'Corporate Branding - 8 Page Executive Brochure Package'
          );
        $app = array(
          '1'=>'Android App Package',
          '2'=>'iPhone App Package',          
          );
        ?>

        <div id="item9" class="fb-item fb-100-item-column">
        <div class="fb-grouplabel" style="display:none" id="headerID">
          <label id="item9_label_0" style="display: inline;">Product Detail *</label>
        </div>
        <div class="fb-input-box">
        <select  data-hint="" name="cproduct1" id="myproduct_logo" style="display: none;">
        <?php
        foreach ($logo as $key => $value) {
        ?>
        <option value="<?=$value?>"><?=$value?></option>            
        <?php
        }
        ?>            
        </select>
        



        <select  data-hint="" name="cproduct2" id="myproduct_web" style="display: none;">
        <?php
        foreach ($website as $key => $value) {
        ?>
        <option value="<?=$value?>"><?=$value?></option>            
        <?php
        }
        ?>            
        </select>

        <select  data-hint="" name="cproduct3" id="myproduct_corporate" style="display: none;">
        <?php
        foreach ($corporate as $key => $value) {
        ?>
        <option value="<?=$value?>"><?=$value?></option>            
        <?php
        }
        ?>            
        </select>

        <select  data-hint="" name="cproduct4" id="myproduct_app" style="display: none;">
        <?php
        foreach ($app as $key => $value) {
        ?>
        <option value="<?=$value?>"><?=$value?></option>            
        <?php
        }
        ?>            
        </select>


        </div>
        </div>

        <script type="text/javascript">
        $(document).ready(function(){
          $( "#myproduct" ).change(function() {
              var myproduct = $( "#myproduct" ).val();
              $( "#headerID" ).show();
              if(myproduct == 1){
                $( "#myproduct_web" ).hide();
                $( "#myproduct_corporate" ).hide();
                $( "#myproduct_app" ).hide();
                $( "#myproduct_logo" ).show();                                
              }
              else if(myproduct == 2){
                $( "#myproduct_logo" ).hide();
                $( "#myproduct_corporate" ).hide();
                $( "#myproduct_app" ).hide();
                $( "#myproduct_web" ).show(); 
              }
              else if(myproduct == 3){
                $( "#myproduct_logo" ).hide();
                $( "#myproduct_web" ).hide();
                $( "#myproduct_app" ).hide();
                $( "#myproduct_corporate" ).show(); 
              }              
              else if(myproduct == 4){
                $( "#myproduct_logo" ).hide();
                $( "#myproduct_web" ).hide();
                $( "#myproduct_corporate" ).hide(); 
                $( "#myproduct_app" ).show();
              }   
          });
        });
        </script>


        <!--select id="item5_select_1" data-hint="" name="cproduct">
            <option id="item5_0_option" selected="" value="Logo Design">
              Logo Design
            </option>
            <option id="item5_0_option" selected="" value="Identity Logo">
              
              Identity Logo

            </option>
            <option id="item5_0_option" selected="" value="Corporate Logo Design">
              Corporate Logo Design
            </option>
            <option id="item5_0_option" selected="" value="Elite Logo Design">
              Elite Logo Design
            </option>
            <option id="item5_1_option" value="E-Commerce Web">
              E-Commerce Web
            </option>
            <option id="item5_1_option" value="Elite Web">
              Elite Web
            </option>
            <option id="item5_1_option" value="Corporate Web">
              Corporate Web
            </option>
            <option id="item5_2_option" value="Stationary">
              Stationary
            </option>
            <option id="item5_2_option" value="Sinage Design">              
                Sinage Design 
            </option>
            <option value="Car Wrap Design" id="item5_2_option">              
              Car Wrap Design
            </option>
            <option id="item5_2_option" value="Flyer">
              Flyer 
            </option>
            <option id="item5_2_option" value="Brochure">
              Brochure
            </option>
            <option id="item5_2_option" value="Other">
              Other
            </option>
          </select-->



          
          <!--div class="fb-hint" style="color: rgb(136, 136, 136); font-weight: normal; font-style: normal;">
            OPTIONAL... Customer will get an alert with a link of payment in email. Sales person will also get a copy of that email. 
          </div-->

          </div>
        </div>


        <div class="fb-input-box">
          Show Paypal option 0 or 1<input type="text" value="0" id="item9_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="pp" disabled>
          <div class="fb-hint" style="color: rgb(136, 136, 136); font-weight: normal; font-style: normal;">
            OPTIONAL... USE 2CO for paypal
          </div>
          </div>
        <div class="fb-input-box">
          Create Teamwork project 0 NO or 1 Yes <input type="text" value="1" id="item9_text_1" maxlength="254" placeholder="" autocomplete="off" data-hint="" name="tw">
          <div class="fb-hint" style="color: rgb(136, 136, 136); font-weight: normal; font-style: normal;">
            OPTIONAL... Create the project in Teamwork website automatically once payment successful ? put 1 if yes 0 if no. by default its ON 
          </div>
         </div>  
      </div></div>
  </div>
  <div id="fb-submit-button-div" class="fb-item-alignment-left fb-footer" style="min-height:0px;">
    <input type="submit"  value="Submit">
  </div>
  
</form>
<!-- End of the body content for CoffeeCup Web Form Builder -->



</body></html>