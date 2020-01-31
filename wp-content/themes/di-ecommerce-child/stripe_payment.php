<?php
require_once("../../../wp-load.php");

require_once ("session_values.php");
require_once("db_config.php");
require_once("stripe_config.php");

//$storesession = new rebow_session();
// Include Stripe PHP library 
require_once 'stripe-php/init.php';

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
//print_r($_REQUEST);
$ajax_resquest_type = $_REQUEST['ajax_request'];

if($ajax_resquest_type=="pass_tokens"){
	// Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_REQUEST['token'];

    $storesession=get_rebow_session();

    $total_price = round($storesession->total_price,2);
    //dollars to cents
    $total_price = ($total_price)*100;

    $email = $storesession->email;

    $firstName = $storesession->firstName;

    $lastName = $storesession->lastName;

    $name = $firstName." ".$lastName;

    $itemName = 'Rebow Product';
    
    $product_name = "Product_".rand(10,100000);

    $plan_name = "Plan_".rand(10,100000);

    if($storesession->period_data_value=="Month to Month"){

        $customer = \Stripe\Customer::create(array( 
            'email' => $email,
            'name' => $name,
            'source'  => $token
        ));
        $customer_stripe_id = $customer->id;
        $status = 1;

        $product = \Stripe\Product::create([
          'name' => $product_name,
          'type' => 'service',
        ]);

        $plan = \Stripe\Plan::create([
            'currency' => 'USD',
            'interval' => 'month',
            'product' => $product->id,
            'nickname' => $plan_name,
            'amount' => $total_price,
        ]);

        $subscriptions = \Stripe\Subscription::create([
          'customer' =>  $customer_stripe_id,
          'items' => [['plan' => $plan->id]],
        ]);

        insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
    }else{


        $intent = \Stripe\PaymentIntent::create([
            'amount' => $total_price,
            'currency' => 'USD',
            'setup_future_usage' => 'off_session',
        ])
        // Set API key  
        //\Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
         
        // Add customer to stripe 
        $customer = \Stripe\Customer::create(array( 
            'email' => $email,
            'name' => $name,
            'source'  => $token
        ));
        //$customer_stripe_id = $customer->id;
        $status = 1;

        // Charge a credit or a debit card 
        /*$charge = \Stripe\Charge::create(array( 
            'customer' => $customer->id, 
            'amount' => $total_price, 
            'currency' => $currency, //cents to dollars using currency=>usd
            'description' => $itemName
        ));

        echo $charge->paid;*/

        
        /*\Stripe\Plan::create([
          'amount' => $total_price,
          'currency' => $currency,
          'interval' => 'month',
          'product' => ['name' => 'Gold special'],
        ]);*/
        /*
        $plan = \Stripe\Plan::create([
            'currency' => 'usd',
            'interval' => 'month',
            'product' => 'prod_GGe4JgaQPGbCVk',
            'nickname' => 'Gold special',
            'amount' => $total_price,
        ]);


        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => $plan->id]],
        ]);
        /*$charge = \Stripe\PaymentIntent::create([
            'customer' => $customer->id,
            'amount' => 2000,
            'currency' => 'usd',//cents to dollars using currency=>usd
            'payment_method_types' => ['card'],
        ]);
        */
        //return $charge;
    }


}
if($ajax_resquest_type=="retrieve_customer"){
    $charge = \Stripe\Customer::retrive([
        ''
    ]);
}

if($ajax_resquest_type=="remove_customer"){
    $charge = \Stripe\Customer::deleteSource([
        ''
    ]);
}

if($ajax_resquest_type=="retrieve_payment_info"){
    $charge = \Stripe\Customer::retrive([
        ''
    ]);
}
if($ajax_resquest_type=="update_payment_info"){
    \Stripe\Customer::createSource(
      'cus_GHp8iiwFDy6iG9',
      ['source' => 'tok_mastercard']
    ); 
}
if($ajax_resquest_type=="order_confirmation_added_boxes1"){
    $email = wp_get_current_user()->email;

    $email = "yogisecondspace@gmail.com";

    $customer_id_stripe = get_customer_id_stripe($email);

    $customer_id_stripe_data = retrieve_customer($customer_id_stripe);

    //print_r($customer_id_stripe_data);
    $storesession=get_rebow_session();

    $total_price = round($storesession->total_price,2);
    //dollars to cents
    echo "".$total_price = ($total_price)*100;

    $email = $storesession->email;

    $firstName = $storesession->firstName;

    $lastName = $storesession->lastName;

    $name = $firstName." ".$lastName;

    $itemName = 'Rebow Product';

    // Set API key 
    //\Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
     
    $charge = \Stripe\Charge::create(array( 
        'customer' => $customer_id_stripe_data->id, 
        'amount' => $total_price, 
        'currency' => $currency, //cents to dollars using currency=>usd
        'description' => $itemName
    ));
}

function retrieve_customer($customer_id_stripe){
   $customer_id_stripe_data = \Stripe\Customer::retrieve($customer_id_stripe);
   return $customer_id_stripe_data;
}
function get_customer_id_stripe($email){

   $query = "select * from cutomers_stripe where email='$email' limit 1"; 

   $res = mysql_query($query);

   $row=mysql_fetch_assoc($res);
   return $row['stripe_customer_id'];
}
function update_stripe_card_data(){

}
function update_customer($customer_id_stripe)
{
    \Stripe\Customer::update(
      $customer_id_stripe,
      ['metadata' => ['order_id' => '6735']]
    );
}
function create_paymet_intent(){
    \Stripe\PaymentIntent::create([
      'amount' => 2000,
      'currency' => 'gbp',
      'payment_method_types' => ['card'],
    ]);
}

function retreive_pay_intent($customer_id_stripe){
    \Stripe\PaymentIntent::retrieve(
      $customer_id_stripe
    );
}
function update_pay_intent($customer_id_stripe){
    \Stripe\PaymentIntent::update(
      $customer_id_stripe,
      ['metadata' => ['order_id' => '6735']]
    );
}

function confirm_pay_intent($payment_intent){
    $payment_intent->confirm([
      'payment_method' => 'pm_card_visa',
    ]);
}

/*function confirm_pay_intent($payment_intent){
    $payment_intent->confirm([
      'payment_method' => 'pm_card_visa',
    ]);
}
*/
function get_all_payments1()
{
    \Stripe\PaymentIntent::all(['limit' => 3]);
}

function get_all_payments()
{
    \Stripe\PaymentIntent::all(['limit' => 3]);
}

function cretae_product($name,$type,$desc,$attr_array){
    \Stripe\Product::create([
      'name' => $name,
      'type' => $type,
      'description' => $desc,
      'attributes' => $attr_array,
    ]);
}



function insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status){
    
    //echo "Query: ".
    $query = "INSERT INTO cutomers_stripe(`stripe_customer_id`,`first_name`,`last_name`,`email`,`datetime`,`status`)
        VALUES ('$customer_stripe_id','$firstName','$lastName','$email',NOW(),$status)";

    $res = mysql_query($query);

}

?>