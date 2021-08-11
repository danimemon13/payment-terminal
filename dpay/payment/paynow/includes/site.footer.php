<div class="pppro_footer"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
<script src="js/jquery.tools-1.2.5.min.js"></script>
<script src="js/jquery-ui-1.8.11.custom.min.js" language="javascript" type="text/javascript"></script>
<script src="js/jquery.colorbox-min.js"></script>
<script src="js/ccvalidations.js"></script>

<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/countries.js"></script> 
<script src="assets/js/custom.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
        
<script src="./js/jquery.numpad.js"></script>

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
<script>
    populateCountries("country", "state");
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


<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
   <script type="text/javascript">
   Stripe.setPublishableKey('<?php echo PublishableKey; ?>');

   function stripeResponseHandler(status, response) {
   if (response.error) {
   $('.submit-btn input').css({"cursor":"pointer","opacity":"1"});
   // show the errors on the form, hide the submit button while processing
   $('form.payment-form').prepend('<div id="stripe_error" style="display:none" class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;     margin: 4px 167px;"><div id="stripe_error_message"></div></div></div><br />');
   $('#stripe_error').css("display","block");
  $("#stripe_error_message").html(response.error.message);
  $('#loading-sp').hide();
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
        var recaptchaResponse = grecaptcha.getResponse();
        if(recaptchaResponse){
        if(validation){
          $('#loading-sp').show();
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
       cvc: $('#cvv').val(),
       exp_month: $('#exp1').val(),
       exp_year: $('#exp2').val().substr(2)
       }, stripeResponseHandler);
       return false;

     }
        }else{
            alert('Make sure you have checked the captcha.');
        }
    }
    });
    
    if($("#mnbhide").length == 0) {
      $('.payment-form').css('display','block');
    } else {
        $('.payment-form').css('display','none');
    }

   });
   </script>
	</body>
</html>