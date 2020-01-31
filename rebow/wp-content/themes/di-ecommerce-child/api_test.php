<?php
	// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_f2M2RsRhrXDsuX95Bo2kIGxm0016Bnedrx');

\Stripe\PaymentIntent::create([
  'amount' => 1000,
  'currency' => 'gbp',
  'payment_method_types' => ['card'],
  'receipt_email' => 'patilyogesh1000@gmail.com',
]);


?>