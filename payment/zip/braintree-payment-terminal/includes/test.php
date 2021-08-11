<?

require 'braintree/lib/Braintree.php';

/* Please do not edit here. START */
Braintree_Configuration::environment('production');
Braintree_Configuration::merchantId('wx762ps4cnzwnhry');
Braintree_Configuration::publicKey('z54d9k7qpb9dbk4b');
Braintree_Configuration::privateKey('93824adc3cf229090b35e840cbd23b4b');

$clientToken = Braintree_ClientToken::generate();

echo  $_REQUEST['payment_method_nonce'];

?>
<html>
<body>

<form id="checkout" method="post" action="test.php">
  <div id="payment-form"></div>
  <input type="submit" value="Pay $10">
</form>

<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<script>
// We generated a client token for you so you can test out this code
// immediately. In a production-ready integration, you will need to
// generate a client token on your server (see section below).
var clientToken = "<? echo $clientToken;?>";

braintree.setup(clientToken, "dropin", {
  container: "payment-form"
});
</script>
</body>
</html>