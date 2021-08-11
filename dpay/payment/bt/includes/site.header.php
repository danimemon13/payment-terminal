<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.11.custom.css" />
<link rel="stylesheet" media="screen" href="css/colorbox.css" />
<script src="js/jquery.tools-1.2.5.min.js"></script>
<script src="js/jquery-ui-1.8.11.custom.min.js" language="javascript" type="text/javascript"></script>
<script src="js/jquery.colorbox-min.js"></script>
<script src="js/ccvalidations.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<script>
    $(document).ready(function(){
        $(".ccinfo").show();
        $("a[rel='hint']").colorbox();
        $(":radio[name=cctype]").click(function(){
            if($(this).hasClass("isPayPal")){
                 $(".ccinfo").slideUp("fast");
            } else {
                 $(".ccinfo").slideDown("fast");
            }
            resetCCHightlight();
        });

        $("input[name=ccn]").bind('paste', function(e) {
                var el = $(this);
                setTimeout(function() {
                    var text = $(el).val();
                    resetCCHightlight();
                    checkNumHighlight(text);
                }, 100);
        });
    });
</script>
<?
$isadmin=$_GET['isadmin'];

if($isadmin)
{
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
        <script src="./js/jquery.numpad.js"></script>
        <link rel="stylesheet" href="./js/jquery.numpad.css">

		<!-- jQuery.NumPad -->
		<script type="text/javascript">
			// Set NumPad defaults for jQuery mobile. 
			// These defaults will be applied to all NumPads within this document!
			$.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
			$.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
			$.fn.numpad.defaults.displayTpl = '<input type="text" readonly class="form-control" />';
			$.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
			$.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
			$.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};
			
			// Instantiate NumPad once the page is ready to be shown
			$(document).ready(function(){
				$('.text-basic').numpad();
				
			});
		</script>
 <?
        
}  
?>      

<noscript>
<style>
	.noscriptCase { display:none; }
	#accordion .pane { display:block;}
</style>
</noscript>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
   <script type="text/javascript">
   Stripe.setPublishableKey('<?php echo PublishableKey; ?>');

   function stripeResponseHandler(status, response) {
   if (response.error) {
   $('.submit-btn input').css({"cursor":"pointer","opacity":"1"});
   // show the errors on the form, hide the submit button while processing
   $('form.pppt_form').prepend('<div id="stripe_error" style="display:none" class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><div id="stripe_error_message" ></div></div></div><br />');
   $('#stripe_error').css("display","block");
   $("#stripe_error_message").html(response.error.message);
   //$('#loading-sp').hide();
   return false;
   } else {
   $('.submit-btn input').css({"cursor":"none","opacity":"0.3"});	
   $('#stripe_error').css("display","none");	
   var form$ = $("#ff1");
   // token contains id, last4, and card type
   var token = response['id'];
   // insert the token into the form so it gets submitted to the server
   form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
   // and submit
           form$.get(0).submit();
       }
   }

   $(document).ready(function() {
   $("#ff1").submit(function(event) {

    if($("input[type='radio'][name='cctype']:checked").val()=="PP"){
      document.ff1.submit();
    } else { 

        var validation = checkForm();

        if(validation){
//          $('#loading-sp').show().delay( 1800 );
$('#loading-sp').show();
   	setTimeout(function() { 
       $('#loading-sp').fadeOut(); 
   }, 9000);

       Stripe.createToken({
       /* User Details */
       name: $('#ccname').val(),
       address_line1: $('#address').val(),
       address_zip: $('#zip').val(),
       address_state: $('#state').val(),
       address_country: $('#country').val(),
       address_city: $('#city').val(),	
       /* Card Details */	
       number: $('#ccn').val(),
       cvc: $('#cvv').val()
       }, stripeResponseHandler);
       return false;

     }
    }
    });

    

   });
   </script>
</head>
<body>