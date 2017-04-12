<?php


// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:



$the_amount = '200';
echo $_POST['stripeToken'];
//require_once('/path/to/stripe-php/init.php');
require (plugin_dir_path(__FILE__) . '/stripe-php-4.7.0/init.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_ZmA7m9ZpVReJH7yFrlyL4wkL");

// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:
$token = $_POST['stripeToken'];
echo "<h1>" .$token. "</h1>";
// Charge the user's card:
$charge = \Stripe\Charge::create(array(
  "amount" => $the_amount,
  "currency" => "eur",
  "description" => "Example charge",
  "source" => $token,
));

?>