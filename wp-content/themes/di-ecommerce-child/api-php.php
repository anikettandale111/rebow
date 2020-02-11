<?php
//session_start();
require_once("../../../wp-load.php");

require_once("session_handler.php");

require_once("db_config.php");

require_once("stripe_config.php");

// Include Stripe PHP library 
require_once 'stripe-php/init.php';

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
//$storesession = new rebow_session();

//print_r($_REQUEST);
$ajax_resquest_type = $_REQUEST['ajax_request'];

function check_if_user_already_exist(){
    $query = "SELECT count(*) as 'count' FROM wp_users where user_email='$email'";

    $res = mysql_query($query);

    $row = mysql_fetch_row($res);

    return $row[0];
}
if($ajax_resquest_type=="promocode_check"){

    $promocode = $_REQUEST['promocode'];
    $current_date = date('Y-m-d'); 

    //echo "Query: ".
    $query = "SELECT * from promotions where coupon_code='$promocode' and promotion_start_date < '$current_date' and promotion_end_date > '$current_date' and coupon_status=1";

    //$res_array = array();
    $res = mysql_query($query);
    //print_r($res);
    if (mysql_num_rows($res) == 0) {
        $msg = "Invalid Coupon Code";
    }else{
        $row = mysql_fetch_assoc($res);

        
        $msg = "Valid Coupon";
        $promotion_type = $row['promotion_type'];
        $promotion_description = $row['promotion_description'];

        $discount_amount = $row['discount_amount'];
        $percentage_off = $row['percentage_off'];

        $minimum_spend = $row['minimum_spend'];

        
    }
    

    $json_array= array('msg'=>$msg,'promotion_type'=>$promotion_type,'promotion_description'=>$promotion_description,'discount_amount'=>$discount_amount,'percentage_off'=>$percentage_off,'minimum_spend'=>$minimum_spend);
    
    echo $json_array1 = json_encode($json_array);

}
if($ajax_resquest_type=="get_modal_data"){

    $prduct_id = $_REQUEST['product_id'];

    $product_data = get_product_data($prduct_id);

    $product_name = $product_data['product_name'];

    $product_box_count = $product_data['box_count'];

    $product_range = $product_data['product_range'];

    $week2_pricing = number_format(get_rental_price($prduct_id,2,2));

    $week3_pricing = number_format(get_rental_price($prduct_id,2,3));

    $week4_pricing = number_format(get_rental_price($prduct_id,2,4));

    $month1_pricing = number_format(get_storage_price($prduct_id,1,1));
    
    $month2_pricing = number_format(get_storage_price($prduct_id,1,2));
    
    $month3_pricing = number_format(get_storage_price($prduct_id,1,3));
    
    $json_array= array('product_name'=>$product_name,'product_box_count'=>$product_box_count,'product_range'=>$product_range,'week2_pricing'=>$week2_pricing,'week3_pricing'=>$week3_pricing,'week4_pricing'=>$week4_pricing,'month1_pricing'=>$month1_pricing,'month2_pricing'=>$month2_pricing,'month3_pricing'=>$month3_pricing);
    
    echo $json_array1 = json_encode($json_array);
}
if($ajax_resquest_type=="charge_using_existing_card"){

    $storesession = get_rebow_session();
    
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

    $user_status = $_REQUEST['user_status'];
    $payment_status = "";
    if($storesession->period_data_value=="Month to Month"){
        try{
            //echo "payment_method: ".$intent->setupIntent->payment_method;
            /*$customer = \Stripe\Customer::create([
                'email'=>$email,
                'payment_method' => $intent->setupIntent->payment_method, 
                'invoice_settings' => [
                    'default_payment_method' => $intent->setupIntent->payment_method
                ]     
            ]);*/
            //echo "customer_stripe_id".
            $customer_stripe_id = retrieve_customer_id($email);

            //echo "payment_method_id".
            $payment_method_id = retrieve_payment_method_id($customer_stripe_id);

            $customers = \Stripe\Customer::update(
                $customer_stripe_id,
                ['invoice_settings' => [
                    'default_payment_method' => $payment_method_id
                ] ]

            );

            /*$customer = \Stripe\Customer::retrieve(
              $customer_stripe_id
            );

            print_r($customer);*/
            //$payment_method_id = retrieve_payment_method_id($customer_stripe_id);
            //$customer_stripe_id = $customer->id;
            $status = 1;

            $product = \Stripe\Product::create([
              'name' => $product_name,
              'type' => 'service',
            ]);

            $plan = \Stripe\Plan::create([
                'currency' => 'USD',
                'interval' => 'day',
                'interval_count' => 1,
                'product' => $product->id,
                'nickname' => $plan_name,
                'amount' => $total_price,
            ]);

            $subscriptions = \Stripe\Subscription::create([
              'customer' => $customer_stripe_id,
              'items' => [['plan' => $plan->id]],
            ]);

            $subscription_status = $subscriptions->status;
            //insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
            //insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);

        }catch (\Stripe\Exception\CardException $e) {
          // Error code will be authentication_required if authentication is needed
          echo 'Error code is:' . $e->getError()->code;
          $payment_intent_id = $e->getError()->payment_intent->id;
          $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }
    }else{
        //echo "customer_stripe_id: ".
        $customer_stripe_id = retrieve_customer_id($user_email);
        //echo "payment_method_id: ".
        $payment_method_id = retrieve_payment_method_id($customer_stripe_id);
        //echo "intent->setupIntent->payment_method: ".$intent->setupIntent->payment_method;
        /*$customer = \Stripe\Customer::create([
            'email' => $email,
            'payment_method' => $intent->setupIntent->payment_method,
        ]);*/
        try {

            //$customer_stripe_id = $customer->id;
            $status=1;
            //$payment_methods = \Stripe\PaymentMethod::retrieve($intent->setupIntent->payment_method);
            //$payment_method->attach(['customer' => $customer_stripe_id]);
            
            $paymentIntent = \Stripe\PaymentIntent::create([
              'amount' => $total_price,
              'currency' => 'USD',
              'customer' => $customer_stripe_id,
              'payment_method' => $payment_method_id,
              'off_session' => true,
              'confirm' => true,
            ]);
            $payment_status = $paymentIntent->status;

            $transaction_tocken = $paymentIntent->id;
            //insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
            //insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);
        } catch (\Stripe\Exception\CardException $e) {
          // Error code will be authentication_required if authentication is needed
          echo 'Error code is:' . $e->getError()->code;
          $payment_intent_id = $e->getError()->payment_intent->id;
          $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }

    }
    //$storesession = get_rebow_session();
    $period_data_field = $_REQUEST['period_data_field'];

    if ( is_user_logged_in() ) {
        $user_status=1;
    }

    //$storesession = get_rebow_session();
    //print_r($storesession);
    $delivery_date = $storesession->delivery_date;
    $preferred_delivery_time = $storesession->preferred_delivery_time;
    $alternate_delivery_time = $storesession->alternate_delivery_time;
    $delivery_address = $storesession->delivery_address;
    $apt_unit_delivery = $storesession->apt_unit_delivery;
    $apartment_level_delivery = $storesession->apartment_level_delivery;
    $delivery_address_loc_lat = $storesession->delivery_address_loc_lat;
    $delivery_address_loc_long = $storesession->delivery_address_loc_long;

    $pickup_date = $storesession->pickup_date;
    $pickup_address = $storesession->pickup_address;
    $preferred_pickup_time = $storesession->preferred_pickup_time;
    $alternate_pickup_time = $storesession->alternate_pickup_time;
    $apt_unit_pickup = $storesession->apt_unit_pickup;
    $apartment_level_pickup = $storesession->apartment_level_pickup;
    $pickup_address_loc_lat = $storesession->pickup_address_loc_lat;
    $pickup_address_loc_long = $storesession->pickup_address_loc_long;

    if($period_data_field=="STORAGE"){

        $delivery_date_packed = $storesession->delivery_date_packed;
        $preferred_delivery_time_packed = $storesession->preferred_delivery_time_packed;
        $alternate_delivery_time_packed = $storesession->alternate_delivery_time_packed;
        $delivery_address_packed = $storesession->delivery_address_packed;
        $apt_unit_delivery_packed = $storesession->apt_unit_delivery_packed;
        $apartment_level_packed_delivery = $storesession->apartment_level_packed_delivery;
        $delivery_address_packed_loc_lat = $storesession->delivery_address_packed_loc_lat;
        $delivery_address_packed_loc_long = $storesession->delivery_address_packed_loc_long;

        $pickup_date_packed = $storesession->pickup_date_packed;
        $preferred_pickup_time_packed = $storesession->preferred_pickup_time_packed;
        $alternate_pickup_time_packed = $storesession->alternate_pickup_time_packed;
        $pickup_address_packed = $storesession->pickup_address_packed;
        $apt_unit_pickup_packed = $storesession->apt_unit_pickup_packed;
        $apartment_level_packed = $storesession->apartment_level_packed;
        $pickup_address_packed_loc_lat = $storesession->pickup_address_packed_loc_lat;
        $pickup_address_packed_loc_long = $storesession->pickup_address_packed_loc_long;

    }

    $product_id = $storesession->product_id;

    $display_period = $storesession->display_period;

    $dp_period = $storesession->dp_period;

    $product_name = $storesession->product_name;

    $box_count = $storesession->box_count;

    $added_box_count =  $storesession->added_box_count;

    $sales_tax = $storesession->sales_tax;

    $added_box_price = $storesession->added_box_price;

    $product_price = $storesession->product_price;

    $subtotal = $storesession->subtotal;

    $delivery_cost = $storesession->delivery_cost;

    $pickup_cost = $storesession->pickup_cost;

    $total_price = $storesession->total_price;

    $zip_current= $storesession->zip_current;

    $zip_new = $storesession->zip_new;
    //$order_time_period =  $display_period." ".1$dp_period;
    if(isset($storesession->period_data_value)&&!empty($storesession->period_data_value)){
        $order_time_period =  $storesession->period_data_value;
    }else{
        $order_time_period =  $display_period." ".$dp_period;
    }
    if($user_status==1){
        $user_id = wp_get_current_user()->id;

        $email = wp_get_current_user()->user_email;

    }else{
        $email = $storesession->email;
        $pass = rand_string(10);
        
        $data = array('user_pass'=>$pass,'user_login'=>$storesession->email,'user_email'=>$storesession->email,'first_name'=>$storesession->firstName,'last_name'=>$storesession->lastName);
        $user_id = wp_new_user($data);
        
        if($user_id){
            $subject ="Rebow Account Activation";
            $array1= array('name1'=>$email,'name2'=>$pass);
            //$filepath = "template-parts/mail/mail-subscribe.php";
            $body = file_get_contents("template-parts/mail/mail-account_activation.php");

            foreach($array1 as $key=>$value){
                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }
    }
    $cuid=0;
    $order_id = insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$period_data_field,$order_time_period,$zip_current,$zip_new,$user_id,$cuid,$subtotal);
    
    $shipping_type ="Delivery Empty Boxes";

    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date,$delivery_address,$preferred_delivery_time,$alternate_delivery_time,$apt_unit_delivery,$apartment_level_delivery,$user_id,$delivery_address_loc_lat,$delivery_address_loc_long);

    if($period_data_field=="STORAGE"){

        $shipping_type ="Pickup Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date_packed,$pickup_address_packed,$preferred_pickup_time_packed,$alternate_pickup_time_packed,$apt_unit_pickup_packed,$apartment_level_packed,$user_id,$pickup_address_packed_loc_lat,$pickup_address_packed_loc_long);

        $shipping_type ="Delivery Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date_packed,$delivery_address_packed,$preferred_delivery_time_packed,$alternate_delivery_time_packed,$apt_unit_delivery_packed,$apartment_level_packed_delivery,$user_id,$delivery_address_packed_loc_lat,$delivery_address_packed_loc_long);
    }
    
    $shipping_type ="Pickup Empty Boxes";
    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date,$pickup_address,$preferred_pickup_time,$alternate_pickup_time,$apt_unit_pickup,$apartment_level_pickup,$user_id,$pickup_address_loc_lat,$pickup_address_loc_long);

    if($payment_status=='succeeded'||$subscription_status=="active"){
        $transaction_status = "Paid";
    }else{
        $transaction_status = "Unsucessful";
    }

    //$transaction_status = "Paid";
    $transaction_amount = $total_price;

    insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount);

    $order_status="Order Received";
    $active=1;
    insert_into_order_tracking($order_id,$user_id,$order_status,$active);

    //set_rebow_session($storesession);
    //print_r($storesession);
    //$firstName = $_REQUEST['firstName'];

    //$lastName = $_REQUEST['lastName'];

    //$payment_type = $_REQUEST['payment_type'];

    //$cardNumber = $_REQUEST['cardNumber'];

    //$month = $_REQUEST['month'];

    //$Year = $_REQUEST['Year'];

    //$billing_address = $_REQUEST['billingaddress'];

    //$city = $_REQUEST['city'];

    //$zipcode = $_REQUEST['zipcode'];

    ///$state = $_REQUEST['state'];



    /*$payment_method_id = $_REQUEST['payment_method_id'];

    $paymentMethod = \Stripe\PaymentMethod::retrieve($payment_method_id);

    $card_number = $paymentMethod->card->last4;

    $exp_month = $paymentMethod->card->exp_month;

    $exp_year = $paymentMethod->card->exp_year;

    $zipcode = $paymentMethod->billing_details->address->postal_code;

    insert_into_payments($order_id,$user_id,$payment_type,$firstName,$lastName,$card_number,$exp_month,$exp_year,$billing_address,$city,$zipcode,$promocode,$state,$user_id);
 
    $first_name = $storesession->firstName;
    $last_name = $storesession->lastName;
    $email = $storesession->email;
    $company_name = $storesession->companyName;
    //$email = $storesession->company_name;
    $phone_number = $storesession->phoneNumber;
    $SecondaryPhoneNumber = $storesession->SecondaryPhoneNumber;
    $hearabotus = $storesession->selecthearus;

    insert_customers_data($user_id,$first_name,$last_name,$email,$company_name,$phone_number,$SecondaryPhoneNumber,$hearabotus);*/
    
    if($order_id!=0){

        if($period_data_field=="RENTAL"){
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");

            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);

            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }
            //echo $body;
            $res_mail = wp_mail($email, $subject, $body);
        }else{
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");
            
            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);
                
            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }

    }
    $json_array = array('payment_status'=>$payment_status,'order_id'=>$order_id);
    echo json_encode($json_array);
}

function retrieve_customer_id($user_email){

    //echo "Query: ".
    $query = "SELECT stripe_customer_id from cutomers_stripe where email='$user_email' limit 1";

    $res = mysql_query($query);

    $row = mysql_fetch_row($res);

    return $row[0];
} 

function retrieve_payment_method_id($customer_stripe_id){

    $query = "SELECT payment_method_id from payment_methods_stripe where customer_stripe_id='$customer_stripe_id' limit 1";

    $res = mysql_query($query);

    $row = mysql_fetch_row($res);

    return $row[0];
}
if($ajax_resquest_type=="add_new_payment_method"){

    $user_id = wp_get_current_user()->id;

    $user_email = wp_get_current_user()->user_email;

   // echo "customer_stripe_id: ".
    $customer_stripe_id = retrieve_customer_id($user_email);

    $intent = json_decode(stripslashes($_REQUEST['result']));

    $firstName = $_REQUEST['firstName'];
    $lastName = $_REQUEST['lastName'];
    $billingaddress = $_REQUEST['billingaddress'];

    $payment_type = $_REQUEST['payment_type'];

    //print_r($intent);
    //echo "payment_method_id: ".
    $payment_method_id = $intent->setupIntent->payment_method;

    $payment_method = \Stripe\PaymentMethod::retrieve(
      $payment_method_id
    );
    //print_r($payment_method);
    $paymethod_attach = $payment_method->attach([
      'customer' => $customer_stripe_id,
    ]);
    $status=1;
    $cuid = $paymethod_attach->customer;
    insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$user_email,$status);

    $card_number = $payment_method->card->last4;

    $exp_month = $payment_method->card->exp_month;

    $exp_year = $payment_method->card->exp_year;

    $zipcode = 0;
    //$zipcode = $payment_method->billing_details->address->postal_code;
    $order_id =0;
    $city = "";
    $promocode = "";
    $state = "";
    
    insert_into_payments($order_id,$user_id,$payment_type,$firstName,$lastName,$card_number,$exp_month,$exp_year,$billingaddress,$city,$zipcode,$promocode,$state,$user_id,$payment_method_id);

    
}
if($ajax_resquest_type=="send_card_intent2"){
    //echo "in";
    //print_r($_REQUEST);
    $intent = json_decode(stripslashes($_REQUEST['result']));
    //print_r($intent);
    $storesession = get_rebow_session();

    $total_price = $storesession->total_price;
    $new_total_price = $_REQUEST['new_total_price'];

    if(!empty($new_total_price)){
        $total_price = $new_total_price;
    }
    
    //dollars to cents

    $total_price = round($total_price,2);
    $total_price = ($total_price)*100;

    $email = $storesession->email;

    $firstName = $storesession->firstName;

    $lastName = $storesession->lastName;

    $name = $firstName." ".$lastName;

    $itemName = 'Rebow Product';
    
    $product_name = "Product_".rand(10,100000);

    $plan_name = "Plan_".rand(10,100000);

    $user_status = $_REQUEST['user_status'];

    //echo "user_status: ".$user_status;
    if($user_status==1){
        $user_id = wp_get_current_user()->id;

        $user_email = wp_get_current_user()->user_email;

        ///$payment_method_id = $intent->setupIntent->payment_method;

        if($storesession->period_data_value=="Month to Month"){
            try{
                //echo "payment_method: ".$intent->setupIntent->payment_method;
                /*$customer = \Stripe\Customer::create([
                    'email'=>$email,
                    'payment_method' => $intent->setupIntent->payment_method, 
                    'invoice_settings' => [
                        'default_payment_method' => $intent->setupIntent->payment_method
                    ]     
                ]);*/
                //$customer_stripe_id = $customer->id;

                $customer_stripe_id = retrieve_customer_id($user_email);

                //echo "payment_method_id: ".
                $payment_method_id = $intent->setupIntent->payment_method;
                //retrieve_payment_method_id($customer_stripe_id);
               
                $status=1;

                $payment_methods = \Stripe\PaymentMethod::retrieve($intent->setupIntent->payment_method);

                $payment_methods->attach(['customer' => $customer_stripe_id]);

                //retrieve_payment_method_id($customer_stripe_id);

                $customer = \Stripe\Customer::update(
                    $customer_stripe_id,
                    ['invoice_settings' => [
                        'default_payment_method' => $payment_method_id
                    ]     
                ]);

                $product = \Stripe\Product::create([
                  'name' => $product_name,
                  'type' => 'service',
                ]);

                $plan = \Stripe\Plan::create([
                    'currency' => 'USD',
                    'interval' => 'day',
                    'interval_count' => 1,
                    'product' => $product->id,
                    'nickname' => $plan_name,
                    'amount' => $total_price,
                ]);

                $subscriptions = \Stripe\Subscription::create([
                  'customer' =>  $customer_stripe_id,
                  'items' => [['plan' => $plan->id]],
                ]);

                $subscription_status = $subscriptions->status;
                insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);

            }catch (\Stripe\Exception\CardException $e) {
              // Error code will be authentication_required if authentication is needed
              $error_code = $e->getError()->code;
              //$payment_intent_id = $e->getError()->payment_intent->id;
              //$payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            }catch (\Stripe\Exception\RateLimitException $e) {
                 $error_code = $e->getError()->code;
              // Too many requests made to the API too quickly
            } catch (\Stripe\Exception\InvalidRequestException $e) {
              // Invalid parameters were supplied to Stripe's API
                 $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\AuthenticationException $e) {
              // Authentication with Stripe's API failed
              // (maybe you changed API keys recently)
                 $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
              // Network communication with Stripe failed
                 $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\ApiErrorException $e) {
              // Display a very generic error to the user, and maybe send
              // yourself an email
                 $error_code = $e->getError()->code;
            }catch (\Stripe\Exception\UnexpectedValueException $e) {
              // Something else happened, completely unrelated to Stripe
                echo "catch found";
                 $error_code = $e->getError()->code;
            } catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
                 $error_code = $e->getError()->code;
            }

        }else{
            //echo "intent->setupIntent->payment_method: ".$intent->setupIntent->payment_method;
            /*$customer = \Stripe\Customer::create([
                'email' => $email,
                'payment_method' => $intent->setupIntent->payment_method,
            ]);*/
            //echo "customer_stripe_id: ".
            
            try {
                $customer_stripe_id = retrieve_customer_id($user_email);

                //echo "payment_method_id: ".
                $payment_method_id = $intent->setupIntent->payment_method;
                //retrieve_payment_method_id($customer_stripe_id);
               
                $status=1;
                $payment_methods = \Stripe\PaymentMethod::retrieve($intent->setupIntent->payment_method);
                $payment_methods->attach(['customer' => $customer_stripe_id]);
                
                $paymentIntent = \Stripe\PaymentIntent::create([
                  'amount' => $total_price,
                  'currency' => 'USD',
                  'customer' => $customer_stripe_id,
                  'payment_method' => $payment_method_id,
                  'off_session' => true,
                  'confirm' => true,
                ]);

                $payment_status = $paymentIntent->status;
                insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);
            }catch (\Stripe\Exception\CardException $e) {
              // Error code will be authentication_required if authentication is needed
                $error_code = $e->getError()->code;
              //$payment_intent_id = $e->getError()->payment_intent->id;
              ///$payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            }catch (\Stripe\Exception\RateLimitException $e) {
                $error_code = $e->getError()->code;
              // Too many requests made to the API too quickly
            } catch (\Stripe\Exception\InvalidRequestException $e) {
              // Invalid parameters were supplied to Stripe's API
                $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\AuthenticationException $e) {
              // Authentication with Stripe's API failed
              // (maybe you changed API keys recently)
                $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
              // Network communication with Stripe failed
                $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\ApiErrorException $e) {
              // Display a very generic error to the user, and maybe send
              // yourself an email
                $error_code = $e->getError()->code;
            } catch (\Stripe\Exception\UnexpectedValueException $e) {
              // Something else happened, completely unrelated to Stripe
                echo "catch found";
                $error_code = $e->getError()->code;
            } catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
                $error_code = $e->getError()->code;
            }
   
        }

            
    }
    $period_data_field = $_REQUEST['period_data_field'];

    if ( is_user_logged_in() ) {
        $user_status=1;
    }

    //$storesession = get_rebow_session();
    //print_r($storesession);
    $delivery_date = $storesession->delivery_date;
    $preferred_delivery_time = $storesession->preferred_delivery_time;
    $alternate_delivery_time = $storesession->alternate_delivery_time;
    $delivery_address = $storesession->delivery_address;
    $apt_unit_delivery = $storesession->apt_unit_delivery;
    $apartment_level_delivery = $storesession->apartment_level_delivery;
    $delivery_address_loc_lat = $storesession->delivery_address_loc_lat;
    $delivery_address_loc_long = $storesession->delivery_address_loc_long;

    $pickup_date = $storesession->pickup_date;
    $pickup_address = $storesession->pickup_address;
    $preferred_pickup_time = $storesession->preferred_pickup_time;
    $alternate_pickup_time = $storesession->alternate_pickup_time;
    $apt_unit_pickup = $storesession->apt_unit_pickup;
    $apartment_level_pickup = $storesession->apartment_level_pickup;
    $pickup_address_loc_lat = $storesession->pickup_address_loc_lat;
    $pickup_address_loc_long = $storesession->pickup_address_loc_long;

    if($period_data_field=="STORAGE"){

        $delivery_date_packed = $storesession->delivery_date_packed;
        $preferred_delivery_time_packed = $storesession->preferred_delivery_time_packed;
        $alternate_delivery_time_packed = $storesession->alternate_delivery_time_packed;
        $delivery_address_packed = $storesession->delivery_address_packed;
        $apt_unit_delivery_packed = $storesession->apt_unit_delivery_packed;
        $apartment_level_packed_delivery = $storesession->apartment_level_packed_delivery;
        $delivery_address_packed_loc_lat = $storesession->delivery_address_packed_loc_lat;
        $delivery_address_packed_loc_long = $storesession->delivery_address_packed_loc_long;

        $pickup_date_packed = $storesession->pickup_date_packed;
        $preferred_pickup_time_packed = $storesession->preferred_pickup_time_packed;
        $alternate_pickup_time_packed = $storesession->alternate_pickup_time_packed;
        $pickup_address_packed = $storesession->pickup_address_packed;
        $apt_unit_pickup_packed = $storesession->apt_unit_pickup_packed;
        $apartment_level_packed = $storesession->apartment_level_packed;
        $pickup_address_packed_loc_lat = $storesession->pickup_address_packed_loc_lat;
        $pickup_address_packed_loc_long = $storesession->pickup_address_packed_loc_long;

    }

    $product_id = $storesession->product_id;

    $display_period = $storesession->display_period;

    $dp_period = $storesession->dp_period;

    $product_name = $storesession->product_name;

    $box_count = $storesession->box_count;

    $added_box_count =  $storesession->added_box_count;

    $sales_tax = $storesession->sales_tax;

    $added_box_price = $storesession->added_box_price;

    $product_price = $storesession->product_price;

    $subtotal = $storesession->subtotal;

    $delivery_cost = $storesession->delivery_cost;

    $pickup_cost = $storesession->pickup_cost;

    $total_price = $storesession->total_price;

    $zip_current= $storesession->zip_current;

    $zip_new = $storesession->zip_new;
    //$order_time_period =  $display_period." ".1$dp_period;
    if(isset($storesession->period_data_value)&&!empty($storesession->period_data_value)){
        $order_time_period =  $storesession->period_data_value;
    }else{
        $order_time_period =  $display_period." ".$dp_period;
    }
    if($user_status==1){
        $user_id = wp_get_current_user()->id;

        $email = wp_get_current_user()->user_email;

    }else{
        $email = $storesession->email;
        $pass = rand_string(10);
        
        $data = array('user_pass'=>$pass,'user_login'=>$storesession->email,'user_email'=>$storesession->email,'first_name'=>$storesession->firstName,'last_name'=>$storesession->lastName);
        $user_id = wp_new_user($data);
        
        if($user_id){
            $subject ="Rebow Account Activation";
            $array1= array('name1'=>$email,'name2'=>$pass);
            //$filepath = "template-parts/mail/mail-subscribe.php";
            $body = file_get_contents("template-parts/mail/mail-account_activation.php");

            foreach($array1 as $key=>$value){
                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }
    }
    $cuid=0;
    $order_id = insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$period_data_field,$order_time_period,$zip_current,$zip_new,$user_id,$cuid,$subtotal);
    
    $shipping_type ="Delivery Empty Boxes";

    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date,$delivery_address,$preferred_delivery_time,$alternate_delivery_time,$apt_unit_delivery,$apartment_level_delivery,$user_id,$delivery_address_loc_lat,$delivery_address_loc_long);

    if($period_data_field=="STORAGE"){

        $shipping_type ="Pickup Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date_packed,$pickup_address_packed,$preferred_pickup_time_packed,$alternate_pickup_time_packed,$apt_unit_pickup_packed,$apartment_level_packed,$user_id,$pickup_address_packed_loc_lat,$pickup_address_packed_loc_long);

        $shipping_type ="Delivery Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date_packed,$delivery_address_packed,$preferred_delivery_time_packed,$alternate_delivery_time_packed,$apt_unit_delivery_packed,$apartment_level_packed_delivery,$user_id,$delivery_address_packed_loc_lat,$delivery_address_packed_loc_long);
    }
    
    $shipping_type ="Pickup Empty Boxes";
    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date,$pickup_address,$preferred_pickup_time,$alternate_pickup_time,$apt_unit_pickup,$apartment_level_pickup,$user_id,$pickup_address_loc_lat,$pickup_address_loc_long);

    if($payment_status=='succeeded'||$subscription_status=="active"){
        $transaction_status = "Paid";
    }else{
        $transaction_status = "Unsucessful";
    }

    //$transaction_status = "Paid";
    $transaction_amount = $total_price;

    insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount);

    $order_status="Order Received";
    $active=1;
    insert_into_order_tracking($order_id,$user_id,$order_status,$active);

    //set_rebow_session($storesession);
    //print_r($storesession);
    //$firstName = $_REQUEST['firstName'];

    //$lastName = $_REQUEST['lastName'];

    //$payment_type = $_REQUEST['payment_type'];

    //$cardNumber = $_REQUEST['cardNumber'];

    //$month = $_REQUEST['month'];

    //$Year = $_REQUEST['Year'];
    
    $billing_address = $_REQUEST['billingaddress'];

    $city = $_REQUEST['city'];

    $zipcode = $_REQUEST['zipcode'];

    $state = $_REQUEST['state'];

    /*$payment_method_id = $_REQUEST['payment_method_id'];*/

    $paymentMethod = \Stripe\PaymentMethod::retrieve($payment_method_id);

    $card_number = $paymentMethod->card->last4;

    $exp_month = $paymentMethod->card->exp_month;

    $exp_year = $paymentMethod->card->exp_year;

    //$zipcode = $paymentMethod->billing_details->address->postal_code;

    insert_into_payments($order_id,$user_id,$payment_type,$firstName,$lastName,$card_number,$exp_month,$exp_year,$billing_address,$city,$zipcode,$promocode,$state,$user_id,$payment_method_id);

    /*$first_name = $storesession->firstName;
    $last_name = $storesession->lastName;
    $email = $storesession->email;
    $company_name = $storesession->companyName;
    //$email = $storesession->company_name;
    $phone_number = $storesession->phoneNumber;
    $SecondaryPhoneNumber = $storesession->SecondaryPhoneNumber;
    $hearabotus = $storesession->selecthearus;
    
    insert_customers_data($user_id,$first_name,$last_name,$email,$company_name,$phone_number,$SecondaryPhoneNumber,$hearabotus);*/
    
    if($order_id!=0){

        if($period_data_field=="RENTAL"){
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");

            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);

            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }
            //echo $body;
            $res_mail = wp_mail($email, $subject, $body);
        }else{
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");
            
            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);
                
            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }

    }
    $json_array = array('payment_status'=>$payment_status,'subscription_status'=>$subscription_status,'order_id'=>$order_id,'error_code'=>$error_code);
    echo json_encode($json_array);
}

if($ajax_resquest_type=="send_card_intent3"){
    //echo "in";
    //print_r($_REQUEST);
    $intent = json_decode(stripslashes($_REQUEST['result']));
    //print_r($intent);
    $storesession = get_rebow_session();

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

    $user_status = $_REQUEST['user_status'];

    //echo "user_status: ".$user_status;
    if($user_status==1){
        $user_id = wp_get_current_user()->id;

        "USer Email: ".$user_email = wp_get_current_user()->email;

        ///$payment_method_id = $intent->setupIntent->payment_method;

        if($storesession->period_data_value=="Month to Month"){
            try{
                //echo "payment_method: ".$intent->setupIntent->payment_method;
                /*$customer = \Stripe\Customer::create([
                    'email'=>$email,
                    'payment_method' => $intent->setupIntent->payment_method, 
                    'invoice_settings' => [
                        'default_payment_method' => $intent->setupIntent->payment_method
                    ]     
                ]);*/
                //$customer_stripe_id = $customer->id;

                $customer_stripe_id = retrieve_customer_id($user_email);

                $payment_method_id = retrieve_payment_method_id($customer_stripe_id);

                $status = 1;

                $product = \Stripe\Product::create([
                  'name' => $product_name,
                  'type' => 'service',
                ]);

                $plan = \Stripe\Plan::create([
                    'currency' => 'USD',
                    'interval' => 'day',
                    'interval_count' => 1,
                    'product' => $product->id,
                    'nickname' => $plan_name,
                    'amount' => $total_price,
                ]);

                $subscriptions = \Stripe\Subscription::create([
                  'customer' =>  $customer_stripe_id,
                  'items' => [['plan' => $plan->id]],
                ]);

                $subscription_status = $subscriptions->status;
                insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);

            }catch (\Stripe\Exception\CardException $e) {
              // Error code will be authentication_required if authentication is needed
              echo 'Error code is:' . $e->getError()->code;
              $payment_intent_id = $e->getError()->payment_intent->id;
              $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            }
        }else{
            //echo "intent->setupIntent->payment_method: ".$intent->setupIntent->payment_method;
            /*$customer = \Stripe\Customer::create([
                'email' => $email,
                'payment_method' => $intent->setupIntent->payment_method,
            ]);*/
            echo "customer_stripe_id: ".
            $customer_stripe_id = retrieve_customer_id($user_email);

            echo "payment_method_id: ".
            $payment_method_id = retrieve_payment_method_id($customer_stripe_id);
            try {
               
                $status=1;
                //$payment_methods = \Stripe\PaymentMethod::retrieve($intent->setupIntent->payment_method);
                //$payment_method->attach(['customer' => $customer_stripe_id]);
                
                $paymentIntent = \Stripe\PaymentIntent::create([
                  'amount' => $total_price,
                  'currency' => 'USD',
                  'customer' => $customer_stripe_id,
                  'payment_method' => $payment_method_id,
                  'off_session' => true,
                  'confirm' => true,
                ]);

                $payment_status = $paymentIntent->status;
                //insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                //insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);
            } catch (\Stripe\Exception\CardException $e) {
              // Error code will be authentication_required if authentication is needed
              echo 'Error code is:' . $e->getError()->code;
              $payment_intent_id = $e->getError()->payment_intent->id;
              $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            }   
        }

            
    }
    $period_data_field = $_REQUEST['period_data_field'];

    if ( is_user_logged_in() ) {
        $user_status=1;
    }

    //$storesession = get_rebow_session();
    //print_r($storesession);
    $delivery_date = $storesession->delivery_date;
    $preferred_delivery_time = $storesession->preferred_delivery_time;
    $alternate_delivery_time = $storesession->alternate_delivery_time;
    $delivery_address = $storesession->delivery_address;
    $apt_unit_delivery = $storesession->apt_unit_delivery;
    $apartment_level_delivery = $storesession->apartment_level_delivery;
    $delivery_address_loc_lat = $storesession->delivery_address_loc_lat;
    $delivery_address_loc_long = $storesession->delivery_address_loc_long;

    $pickup_date = $storesession->pickup_date;
    $pickup_address = $storesession->pickup_address;
    $preferred_pickup_time = $storesession->preferred_pickup_time;
    $alternate_pickup_time = $storesession->alternate_pickup_time;
    $apt_unit_pickup = $storesession->apt_unit_pickup;
    $apartment_level_pickup = $storesession->apartment_level_pickup;
    $pickup_address_loc_lat = $storesession->pickup_address_loc_lat;
    $pickup_address_loc_long = $storesession->pickup_address_loc_long;

    if($period_data_field=="STORAGE"){

        $delivery_date_packed = $storesession->delivery_date_packed;
        $preferred_delivery_time_packed = $storesession->preferred_delivery_time_packed;
        $alternate_delivery_time_packed = $storesession->alternate_delivery_time_packed;
        $delivery_address_packed = $storesession->delivery_address_packed;
        $apt_unit_delivery_packed = $storesession->apt_unit_delivery_packed;
        $apartment_level_packed_delivery = $storesession->apartment_level_packed_delivery;
        $delivery_address_packed_loc_lat = $storesession->delivery_address_packed_loc_lat;
        $delivery_address_packed_loc_long = $storesession->delivery_address_packed_loc_long;

        $pickup_date_packed = $storesession->pickup_date_packed;
        $preferred_pickup_time_packed = $storesession->preferred_pickup_time_packed;
        $alternate_pickup_time_packed = $storesession->alternate_pickup_time_packed;
        $pickup_address_packed = $storesession->pickup_address_packed;
        $apt_unit_pickup_packed = $storesession->apt_unit_pickup_packed;
        $apartment_level_packed = $storesession->apartment_level_packed;
        $pickup_address_packed_loc_lat = $storesession->pickup_address_packed_loc_lat;
        $pickup_address_packed_loc_long = $storesession->pickup_address_packed_loc_long;

    }

    $product_id = $storesession->product_id;

    $display_period = $storesession->display_period;

    $dp_period = $storesession->dp_period;

    $product_name = $storesession->product_name;

    $box_count = $storesession->box_count;

    $added_box_count =  $storesession->added_box_count;

    $sales_tax = $storesession->sales_tax;

    $added_box_price = $storesession->added_box_price;

    $product_price = $storesession->product_price;

    $subtotal = $storesession->subtotal;

    $delivery_cost = $storesession->delivery_cost;

    $pickup_cost = $storesession->pickup_cost;

    $total_price = $storesession->total_price;

    $zip_current= $storesession->zip_current;

    $zip_new = $storesession->zip_new;
    //$order_time_period =  $display_period." ".1$dp_period;
    if(isset($storesession->period_data_value)&&!empty($storesession->period_data_value)){
        $order_time_period =  $storesession->period_data_value;
    }else{
        $order_time_period =  $display_period." ".$dp_period;
    }
    if($user_status==1){
        $user_id = wp_get_current_user()->id;

        $email = wp_get_current_user()->user_email;

    }else{
        $email = $storesession->email;
        $pass = rand_string(10);
        
        $data = array('user_pass'=>$pass,'user_login'=>$storesession->email,'user_email'=>$storesession->email,'first_name'=>$storesession->firstName,'last_name'=>$storesession->lastName);
        $user_id = wp_new_user($data);
        
        if($user_id){
            $subject ="Rebow Account Activation";
            $array1= array('name1'=>$email,'name2'=>$pass);
            //$filepath = "template-parts/mail/mail-subscribe.php";
            $body = file_get_contents("template-parts/mail/mail-account_activation.php");

            foreach($array1 as $key=>$value){
                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }
    }
    $cuid=0;
    $order_id = insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$period_data_field,$order_time_period,$zip_current,$zip_new,$user_id,$cuid,$subtotal);
    
    $shipping_type ="Delivery Empty Boxes";

    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date,$delivery_address,$preferred_delivery_time,$alternate_delivery_time,$apt_unit_delivery,$apartment_level_delivery,$user_id,$delivery_address_loc_lat,$delivery_address_loc_long);

    if($period_data_field=="STORAGE"){

        $shipping_type ="Pickup Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date_packed,$pickup_address_packed,$preferred_pickup_time_packed,$alternate_pickup_time_packed,$apt_unit_pickup_packed,$apartment_level_packed,$user_id,$pickup_address_packed_loc_lat,$pickup_address_packed_loc_long);

        $shipping_type ="Delivery Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date_packed,$delivery_address_packed,$preferred_delivery_time_packed,$alternate_delivery_time_packed,$apt_unit_delivery_packed,$apartment_level_packed_delivery,$user_id,$delivery_address_packed_loc_lat,$delivery_address_packed_loc_long);
    }
    
    $shipping_type ="Pickup Empty Boxes";
    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date,$pickup_address,$preferred_pickup_time,$alternate_pickup_time,$apt_unit_pickup,$apartment_level_pickup,$user_id,$pickup_address_loc_lat,$pickup_address_loc_long);

    if($payment_status=='succeeded'||$subscription_status=="active"){
        $transaction_status = "Paid";
    }else{
        $transaction_status = "Unsucessful";
    }

    //$transaction_status = "Paid";
    $transaction_amount = $total_price;

    insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount);

    $order_status="Order Received";
    $active=1;
    insert_into_order_tracking($order_id,$user_id,$order_status,$active);

    //set_rebow_session($storesession);
    //print_r($storesession);
    //$firstName = $_REQUEST['firstName'];

    //$lastName = $_REQUEST['lastName'];

    //$payment_type = $_REQUEST['payment_type'];

    //$cardNumber = $_REQUEST['cardNumber'];

    //$month = $_REQUEST['month'];

    //$Year = $_REQUEST['Year'];
    
    $billing_address = $_REQUEST['billingaddress'];

    $city = $_REQUEST['city'];

    //$zipcode = $_REQUEST['zipcode'];

    $state = $_REQUEST['state'];

    /*$payment_method_id = $_REQUEST['payment_method_id'];*/

    $paymentMethod = \Stripe\PaymentMethod::retrieve($payment_method_id);

    $card_number = $paymentMethod->card->last4;

    $exp_month = $paymentMethod->card->exp_month;

    $exp_year = $paymentMethod->card->exp_year;

    $zipcode = $paymentMethod->billing_details->address->postal_code;

    insert_into_payments($order_id,$user_id,$payment_type,$firstName,$lastName,$card_number,$exp_month,$exp_year,$billing_address,$city,$zipcode,$promocode,$state,$user_id,$payment_method_id);

    /*$first_name = $storesession->firstName;
    $last_name = $storesession->lastName;
    $email = $storesession->email;
    $company_name = $storesession->companyName;
    //$email = $storesession->company_name;
    $phone_number = $storesession->phoneNumber;
    $SecondaryPhoneNumber = $storesession->SecondaryPhoneNumber;
    $hearabotus = $storesession->selecthearus;
    
    insert_customers_data($user_id,$first_name,$last_name,$email,$company_name,$phone_number,$SecondaryPhoneNumber,$hearabotus);*/
    
    if($order_id!=0){

        if($period_data_field=="RENTAL"){
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");

            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);

            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }
            //echo $body;
            $res_mail = wp_mail($email, $subject, $body);
        }else{
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");
            
            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);
                
            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }

    }
    $json_array = array('payment_status'=>$payment_status,'subscription_status'=>$subscription_status,'order_id'=>$order_id);
    echo json_encode($json_array);
}
if($ajax_resquest_type=="send_card_intent"){
    //echo "in";
    //print_r($_REQUEST);
    $intent = json_decode(stripslashes($_REQUEST['result']));
    //print_r($intent);
    $storesession = get_rebow_session();

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

    $user_status = $_REQUEST['user_status'];

    //echo "user_status: ".$user_status;
    if($user_status==1){
        $payment_method_id = $intent->setupIntent->payment_method;
        if($storesession->period_data_value=="Month to Month"){
            try{
                //echo "payment_method: ".$intent->setupIntent->payment_method;
                $customer = \Stripe\Customer::create([
                    'email'=>$email,
                    'payment_method' => $intent->setupIntent->payment_method, 
                    'invoice_settings' => [
                        'default_payment_method' => $intent->setupIntent->payment_method
                    ]     
                ]);
                //$customer_stripe_id = $customer->id;
                $status = 1;

                $product = \Stripe\Product::create([
                  'name' => $product_name,
                  'type' => 'service',
                ]);

                $plan = \Stripe\Plan::create([
                    'currency' => 'USD',
                    'interval' => 'day',
                    'interval_count' => 1,
                    'product' => $product->id,
                    'nickname' => $plan_name,
                    'amount' => $total_price,
                ]);

                $subscriptions = \Stripe\Subscription::create([
                  'customer' =>  $customer->id,
                  'items' => [['plan' => $plan->id]],
                ]);
                $subscription_status = $subscriptions->status;
                insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);

            }catch (\Stripe\Exception\CardException $e) {
              // Error code will be authentication_required if authentication is needed
              echo 'Error code is:' . $e->getError()->code;
              $payment_intent_id = $e->getError()->payment_intent->id;
              $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            }
        }else{
            //echo "intent->setupIntent->payment_method: ".$intent->setupIntent->payment_method;
            $customer = \Stripe\Customer::create([
                'email' => $email,
                'payment_method' => $intent->setupIntent->payment_method,
            ]);
            try {

                $customer_stripe_id = $customer->id;
                $status=1;
                //$payment_methods = \Stripe\PaymentMethod::retrieve($intent->setupIntent->payment_method);
                //$payment_method->attach(['customer' => $customer_stripe_id]);
                
                $paymentIntent = \Stripe\PaymentIntent::create([
                  'amount' => $total_price,
                  'currency' => 'USD',
                  'customer' => $customer->id,
                  'payment_method' => $intent->setupIntent->payment_method,
                  'off_session' => true,
                  'confirm' => true,
                ]);
                $payment_status = $paymentIntent->status;
                insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);
            } catch (\Stripe\Exception\CardException $e) {
              // Error code will be authentication_required if authentication is needed
              echo 'Error code is:' . $e->getError()->code;
              $payment_intent_id = $e->getError()->payment_intent->id;
              $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
            }   
        }

            
    }else{
        $user_exist_status = check_if_user_already_exist($email);

        if($user_exist_status==0){
            $payment_method_id = $intent->setupIntent->payment_method;
            if($storesession->period_data_value=="Month to Month"){
                try{
                    //echo "payment_method: ".$intent->setupIntent->payment_method;
                    $customer = \Stripe\Customer::create([
                        'email'=>$email,
                        'payment_method' => $intent->setupIntent->payment_method, 
                        'invoice_settings' => [
                            'default_payment_method' => $intent->setupIntent->payment_method
                        ]     
                    ]);
                    //$customer_stripe_id = $customer->id;
                    $status = 1;

                    $product = \Stripe\Product::create([
                      'name' => $product_name,
                      'type' => 'service',
                    ]);

                    $plan = \Stripe\Plan::create([
                        'currency' => 'USD',
                        'interval' => 'day',
                        'interval_count' => 1,
                        'product' => $product->id,
                        'nickname' => $plan_name,
                        'amount' => $total_price,
                    ]);

                    $subscriptions = \Stripe\Subscription::create([
                      'customer' =>  $customer->id,
                      'items' => [['plan' => $plan->id]],
                    ]);
                    $subscription_status = $subscriptions->status;
                    insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                    insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);
                }catch (\Stripe\Exception\CardException $e) {
                  // Error code will be authentication_required if authentication is needed
                  echo 'Error code is:' . $e->getError()->code;
                  $payment_intent_id = $e->getError()->payment_intent->id;
                  $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                }
            }else{
                //echo "intent->setupIntent->payment_method: ".$intent->setupIntent->payment_method;
                    $customer = \Stripe\Customer::create([
                        'email' => $email,
                        'payment_method' => $intent->setupIntent->payment_method,
                    ]);
                    try {

                        $customer_stripe_id = $customer->id;
                        $status=1;
                        //$payment_methods = \Stripe\PaymentMethod::retrieve($intent->setupIntent->payment_method);
                        //$payment_method->attach(['customer' => $customer_stripe_id]);
                        
                        $paymentIntent = \Stripe\PaymentIntent::create([
                          'amount' => $total_price,
                          'currency' => 'USD',
                          'customer' => $customer->id,
                          'payment_method' => $intent->setupIntent->payment_method,
                          'off_session' => true,
                          'confirm' => true,
                        ]);
                        $payment_status = $paymentIntent->status;
                        insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status);
                        insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status);
                    } catch (\Stripe\Exception\CardException $e) {
                      // Error code will be authentication_required if authentication is needed
                      echo 'Error code is:' . $e->getError()->code;
                      $payment_intent_id = $e->getError()->payment_intent->id;
                      $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                    }   
            }
        }else{
            $msg = "User Already Exist";
        }
    }
    $json_array = array('user_status'=>$user_status,'user_exist_status'=>$user_exist_status,'period_value'=>$storesession->period_data_value,'payment_status'=>$payment_status,'subscription_status'=>$subscription_status,'payment_method_id'=>$payment_method_id,"msg"=>$msg);
    echo $json_array1 = json_encode($json_array);
}
function insert_stripe_customers_data($customer_stripe_id,$firstName,$lastName,$email,$status){
    
    //echo "Query: ".
   $query = "INSERT INTO cutomers_stripe(`stripe_customer_id`,`first_name`,`last_name`,`email`,`datetime`,`status`)
        VALUES ('$customer_stripe_id','$firstName','$lastName','$email',NOW(),$status)";

    $res = mysql_query($query);

}

function insert_stripe_payments_data($customer_stripe_id,$payment_method_id,$email,$status){
    
    //echo "Query: ".
    $query = "INSERT INTO payment_methods_stripe(`customer_stripe_id`,`payment_method_id`,`email`,`datetime`,`active`)
        VALUES ('$customer_stripe_id','$payment_method_id','$email',NOW(),$status)";

    $res = mysql_query($query);

}
//$email= $_REQUEST['email_id'];
if($ajax_resquest_type=="update_payment_info"){
    $user_id = wp_get_current_user()->id;

    $card_number = $_REQUEST['card_number'];

    $month = $_REQUEST['month'];

    $Year = $_REQUEST['Year'];

    $billingzip = $_REQUEST['billingzip'];

    echo $query = "UPDATE payments SET Card_Number=$card_number, Expiry_month=$month,Expiry_year=$Year,zipcode=$billingzip,updated_at=NOW()
    WHERE user_id=$user_id";

    mysql_query($query);
}
if($ajax_resquest_type=="goto_order_summary"){

    $current_id = $_REQUEST['current_id'];
    $storesession=get_rebow_session();
    $storesession->current_order_id=$current_id;
    set_rebow_session($storesession);
}
function get_user_customer_data($user_id){
    //mysql_query()
    $query = "SELECT * FROM customers where user_id=$user_id";

    $res = mysql_query($query);
}
if($ajax_resquest_type=="user_set_session_for_personal_info"){

    $user_id = wp_get_current_user()->id;

    get_user_customer_data($user_id);

    $firstName = $_REQUEST['firstName'];

    $lastName = $_REQUEST['lastName'];

    $email = $_REQUEST['email'];

    $companyName = $_REQUEST['companyName'];

    $phoneNumber = $_REQUEST['phoneNumber'];

    $SecondaryPhoneNumber = $_REQUEST['SecondaryPhoneNumber'];

    $selecthearus = $_REQUEST['selecthearus'];
}
if($ajax_resquest_type=="order_confirmation_added_boxes"){

    $user_id = wp_get_current_user()->id;

    $email = wp_get_current_user()->user_email;

    $storesession=get_rebow_session();
    //print_r($storesession);
    $current_order_id = $storesession->current_order_id; 
    
    $period_data_field = $storesession->period_datas;

    if($period_data_field=="RENTAL"){
        $period_data = 0;
    }else{
        $period_data = 1;
    }

    $added_box_count = $storesession->added_box_count;

    $added_box_price = $storesession->added_box_price;

    $display_period = $storesession->display_period;

    $delivery_cost = $storesession->delivery_cost;

    $subtotal = $storesession->subtotal;

    $pickup_cost = $storesession->pickup_cost;

    $sales_tax = $storesession->sales_tax;

    $total_price = $storesession->total_price;

    $dp_period =($period_data==0)? "Weeks" : "Months";
    /*Delivery Data*/
    $delivery_date = $storesession->delivery_date;

    $preferred_delivery_time = $storesession->preferred_delivery_time;

    $alternate_delivery_time = $storesession->alternate_delivery_time;

    $delivery_address = $storesession->delivery_address;

    $apt_unit_delivery = $storesession->apt_unit_delivery;

    $apartment_level_delivery = $storesession->apartment_level_delivery;

    $delivery_address_loc_lat = $storesession->delivery_address_loc_lat;

    $delivery_address_loc_long = $storesession->delivery_address_loc_long;

    /*Pickup Data*/

    $pickup_date = $storesession->pickup_date;

    $preferred_pickup_time = $storesession->preferred_pickup_time;

    $alternate_pickup_time = $storesession->alternate_pickup_time;

    $pickup_address = $storesession->pickup_address;

    $apt_unit_pickup = $storesession->apt_unit_pickup;

    $apartment_level_pickup = $storesession->apartment_level_pickup;

    $pickup_address_loc_lat = $storesession->pickup_address_loc_lat;

    $pickup_address_loc_long = $storesession->pickup_address_loc_long;

    if($period_data_field=="STORAGE"){

        $delivery_date_packed = $storesession->delivery_date_packed;
        $preferred_delivery_time_packed = $storesession->preferred_delivery_time_packed;
        $alternate_delivery_time_packed = $storesession->alternate_delivery_time_packed;
        $delivery_address_packed = $storesession->delivery_address_packed;
        $apt_unit_delivery_packed = $storesession->apt_unit_delivery_packed;
        $apartment_level_packed_delivery = $storesession->apartment_level_packed_delivery;
        $delivery_address_packed_loc_lat = $storesession->delivery_address_packed_loc_lat;
        $delivery_address_packed_loc_long = $storesession->delivery_address_packed_loc_long;

        $pickup_date_packed = $storesession->pickup_date_packed;
        $preferred_pickup_time_packed = $storesession->preferred_pickup_time_packed;
        $alternate_pickup_time_packed = $storesession->alternate_pickup_time_packed;
        $pickup_address_packed = $storesession->pickup_address_packed;
        $apt_unit_pickup_packed = $storesession->apt_unit_pickup_packed;
        $apartment_level_packed = $storesession->apartment_level_packed;
        $pickup_address_packed_loc_lat = $storesession->pickup_address_packed_loc_lat;
        $pickup_address_packed_loc_long = $storesession->pickup_address_packed_loc_long;

    }
    $total_amount = round($storesession->total_price,2);
    //dollars to cents
    $total_amount = ($total_amount)*100;
    $box_count=0;

    $product_price=0;

    $order_time_period =  $display_period." ".$dp_period;

    $zip_current = 0;

    $zip_new = 0;

    $product_id = 0;

    $customer_stripe_id = retrieve_customer_id($user_email);

    $payment_method_id = retrieve_payment_method_id($customer_stripe_id);

    //$customer_stripe_id = get_customer_data_stripe($user_id);
    //$payment_method_id = get_payment_method_data($customer_stripe_id);
    
    $paymentIntent = \Stripe\PaymentIntent::create([
      'amount' => $total_amount,
      'currency' => 'USD',
      'customer' => $customer_stripe_id,
      'payment_method' => $payment_method_id,
      'off_session' => true,
      'confirm' => true,
    ]);
    
    $paymentIntent->amount_received;
    $payment_status = $paymentIntent->status;

    if($paymentIntent->status=="succeeded"){
        $transaction_status="Paid";
    }else{
        $transaction_status="Unsucessful";
    }
    //$amount_received = ($paymentIntent->amount_received/100);
    $order_id = insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$period_data_field,$order_time_period,$zip_current,$zip_new,$user_id,$current_order_id,$subtotal);
    
    $shipping_type ="Delivery Empty Boxes";

    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date,$delivery_address,$preferred_delivery_time,$alternate_delivery_time,$apt_unit_delivery,$apartment_level_delivery,$user_id,$delivery_address_loc_lat,$delivery_address_loc_long);

    if($period_data_field=="STORAGE"){

        $shipping_type ="Pickup Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date_packed,$pickup_address_packed,$preferred_pickup_time_packed,$alternate_pickup_time_packed,$apt_unit_pickup_packed,$apartment_level_packed,$user_id,$pickup_address_packed_loc_lat,$pickup_address_packed_loc_long);

        $shipping_type ="Delivery Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date_packed,$delivery_address_packed,$preferred_delivery_time_packed,$alternate_delivery_time_packed,$apt_unit_delivery_packed,$apartment_level_packed_delivery,$user_id,$delivery_address_packed_loc_lat,$delivery_address_packed_loc_long);
    }
    
    $shipping_type ="Pickup Empty Boxes";
    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date,$pickup_address,$preferred_pickup_time,$alternate_pickup_time,$apt_unit_pickup,$apartment_level_pickup,$user_id,$pickup_address_loc_lat,$pickup_address_loc_long);

    //$transaction_status = "Paid";
    $transaction_amount = $total_price;

    insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount);

    $order_status="Order Received";
    $active=1;
    insert_into_order_tracking($order_id,$user_id,$order_status,$active);

    if($period_data_field=="RENTAL"){

        $subject ="Order Confirmation - Added Boxes";

        $body = file_get_contents("template-parts/mail/order_confirmation_extra_boxes.php");

        $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'order_completion_date'=>$pickup_date);

        foreach($array_rental as $key=>$value){

            $body = str_replace($key,$value,$body);
        }
        //echo $body;
        $res_mail = wp_mail($email, $subject, $body);
    }
    $json_array = array('order_id'=>$order_id,'payment_status'=>$payment_status,'transaction_status'=>$transaction_status);

    echo $json_array1 = json_encode($json_array);
}
if($ajax_resquest_type=="order_submit"){

    $user_id = wp_get_current_user()->id;

    $email = wp_get_current_user()->user_email;

    $storesession=get_rebow_session();
    //print_r($storesession);
    $current_order_id = $storesession->current_order_id; 
    
    $period_data_field = $storesession->period_datas;

    if($period_data_field=="RENTAL"){
        $period_data = 0;
    }else{
        $period_data = 1;
    }

    $added_box_count = $storesession->added_box_count;

    $added_box_price = $storesession->added_box_price;

    $display_period = $storesession->display_period;

    $subtotal = $storesession->subtotal;

    $delivery_cost = $storesession->delivery_cost;

    $pickup_cost = $storesession->pickup_cost;

    $sales_tax = $storesession->sales_tax;

    $total_price = $storesession->total_price;
    if(empty($total_price)){
        $total_price = $_REQUEST['total_price'];
    }
    $dp_period =($period_data==0)? "Weeks" : "Months";
    /*Delivery Data*/

    $period_data_field = $_REQUEST['period_data_field'];
    $delivery_date = (isset($storesession->delivery_date)) ? $storesession->delivery_date : $_REQUEST['delivery_date'];

    $preferred_delivery_time = (isset($storesession->preferred_delivery_time)) ? $storesession->preferred_delivery_time : $_REQUEST['preferred_delivery_time'];

    $alternate_delivery_time = (isset($storesession->alternate_delivery_time)) ? $storesession->alternate_delivery_time : $_REQUEST['alternate_delivery_time'];

    $delivery_address = (isset($storesession->delivery_address)) ? $storesession->delivery_address : $_REQUEST['delivery_address'];

    $apt_unit_delivery = (isset($storesession->apt_unit_delivery)) ? $storesession->apt_unit_delivery : $_REQUEST['apt_unit_delivery'];

    $apartment_level_delivery = (isset($storesession->apartment_level_delivery)) ? $storesession->apartment_level_delivery : $_REQUEST['apartment_level_delivery'];

    $delivery_address_loc_lat = (isset($storesession->delivery_address_loc_lat)) ? $storesession->delivery_address_loc_lat : $_REQUEST['delivery_address_loc_lat'];

    $delivery_address_loc_long = (isset($storesession->delivery_address_loc_long)) ? $storesession->delivery_address_loc_long : $_REQUEST['delivery_address_loc_long'];


    /*Pickup Data*/

    $pickup_date = (isset($storesession->pickup_date)) ? $storesession->pickup_date : $_REQUEST['pickup_date'];

    $preferred_pickup_time = (isset($storesession->preferred_pickup_time)) ? $storesession->preferred_pickup_time : $_REQUEST['preferred_pickup_time'];

    $alternate_pickup_time = (isset($storesession->alternate_pickup_time)) ? $storesession->alternate_pickup_time : $_REQUEST['alternate_pickup_time'];

    $pickup_address = (isset($storesession->pickup_address)) ? $storesession->pickup_address : $_REQUEST['pickup_address'];

    $apt_unit_pickup = (isset($storesession->apt_unit_pickup)) ? $storesession->apt_unit_pickup : $_REQUEST['apt_unit_pickup'];

    $apartment_level_pickup = (isset($storesession->apartment_level_pickup)) ? $storesession->apartment_level_pickup : $_REQUEST['apartment_level_pickup'];


    $pickup_address_loc_lat = (isset($storesession->pickup_address_loc_lat)) ? $storesession->pickup_address_loc_lat : $_REQUEST['pickup_address_loc_lat'];

    $pickup_address_loc_long = (isset($storesession->pickup_address_loc_long)) ? $storesession->pickup_address_loc_long : $_REQUEST['pickup_address_loc_long'];


    $product_id = $storesession->product_id;

    $product_data = get_product_data($product_id);

    $product_name = $product_data['product_name'];

    //$box_count = $product_data['box_count'];

    $product_range = $product_data['product_range'];

    $box_count= (isset($storesession->box_count)) ? $storesession->box_count : 0;

    $order_time_period =  $display_period." ".$dp_period;

    $zip_current = (isset($storesession->zip_current)) ? $storesession->zip_current : 0;

    $zip_new = (isset($storesession->zip_new)) ? $storesession->zip_new : 0;

    $product_id = (isset($storesession->product_id)) ? $storesession->product_id : 0;

    $product_price = (isset($storesession->product_price)) ? $storesession->product_price : 0;

    if($period_data_field=="STORAGE"){

        $delivery_date_packed = (isset($storesession->delivery_date_packed)) ? $storesession->delivery_date_packed : $_REQUEST['delivery_date_packed'];

        $preferred_delivery_time_packed = (isset($storesession->preferred_delivery_time_packed)) ? $storesession->preferred_delivery_time_packed : $_REQUEST['preferred_delivery_time_packed'];
        
        $alternate_delivery_time_packed = (isset($storesession->alternate_delivery_time_packed)) ? $storesession->alternate_delivery_time_packed : $_REQUEST['alternate_delivery_time_packed'];

        $delivery_address_packed = (isset($storesession->delivery_address_packed)) ? $storesession->delivery_address_packed : $_REQUEST['delivery_address_packed'];

        $apt_unit_delivery_packed = (isset($storesession->apt_unit_delivery_packed)) ? $storesession->apt_unit_delivery_packed : $_REQUEST['apt_unit_delivery_packed'];

        $apartment_level_packed_delivery = (isset($storesession->apartment_level_packed_delivery)) ? $storesession->apartment_level_packed_delivery : $_REQUEST['apartment_level_packed_delivery'];
        
        $delivery_address_packed_loc_lat = (isset($storesession->delivery_address_packed_loc_lat)) ? $storesession->delivery_address_packed_loc_lat : $_REQUEST['delivery_address_packed_loc_lat'];

        $delivery_address_packed_loc_long = (isset($storesession->delivery_address_packed_loc_long)) ? $storesession->delivery_address_packed_loc_long : $_REQUEST['delivery_address_packed_loc_long'];
        
        $pickup_date_packed = (isset($storesession->pickup_date_packed)) ? $storesession->pickup_date_packed : $_REQUEST['pickup_date_packed'];

        $preferred_pickup_time_packed = (isset($storesession->preferred_pickup_time_packed)) ? $storesession->preferred_pickup_time_packed : $_REQUEST['preferred_pickup_time_packed'];

        $alternate_pickup_time_packed = (isset($storesession->alternate_pickup_time_packed)) ? $storesession->alternate_pickup_time_packed : $_REQUEST['alternate_pickup_time_packed'];

        $pickup_address_packed = (isset($storesession->pickup_address_packed)) ? $storesession->pickup_address_packed : $_REQUEST['pickup_address_packed'];

        $alternate_pickup_time_packed = (isset($storesession->alternate_pickup_time_packed)) ? $storesession->alternate_pickup_time_packed : $_REQUEST['alternate_pickup_time_packed'];

        $pickup_address_packed = (isset($storesession->pickup_address_packed)) ? $storesession->pickup_address_packed : $_REQUEST['pickup_address_packed'];

        $apt_unit_pickup_packed = (isset($storesession->apt_unit_pickup_packed)) ? $storesession->apt_unit_pickup_packed : $_REQUEST['apt_unit_pickup_packed'];

        $apartment_level_packed = (isset($storesession->apartment_level_packed)) ? $storesession->apartment_level_packed : $_REQUEST['apartment_level_packed'];

        $pickup_address_packed_loc_lat = (isset($storesession->pickup_address_packed_loc_lat)) ? $storesession->pickup_address_packed_loc_lat : $_REQUEST['pickup_address_packed_loc_lat'];

        $pickup_address_packed_loc_long = (isset($storesession->pickup_address_packed_loc_long)) ? $storesession->pickup_address_packed_loc_long : $_REQUEST['pickup_address_packed_loc_long'];
    
    }

    $customer_stripe_id = retrieve_customer_id($email);

    $payment_method_id = retrieve_payment_method_id($customer_stripe_id);
    //echo "total_price".$total_price;
    $total_amount = round($total_price,2);
    //dollars to cents
    $total_amount1 = ($total_amount)*100;
    //$customer_stripe_id = get_customer_data_stripe($user_id);
    //$payment_method_id = get_payment_method_data($customer_stripe_id);
    
    $paymentIntent = \Stripe\PaymentIntent::create([
      'amount' => $total_amount1,
      'currency' => 'USD',
      'customer' => $customer_stripe_id,
      'payment_method' => $payment_method_id,
      'off_session' => true,
      'confirm' => true,
    ]);

    $total_amount = $paymentIntent->amount_received;
    $payment_status = $paymentIntent->status;
    
    $order_id = insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$period_data_field,$order_time_period,$zip_current,$zip_new,$user_id,$current_order_id,$subtotal);
    //$shipping_type ="Delivery Empty Boxes";

    $shipping_type ="Delivery Empty Boxes";

    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date,$delivery_address,$preferred_delivery_time,$alternate_delivery_time,$apt_unit_delivery,$apartment_level_delivery,$user_id,$delivery_address_loc_lat,$delivery_address_loc_long);

    if($period_data_field=="STORAGE"){

        $shipping_type ="Pickup Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date_packed,$pickup_address_packed,$preferred_pickup_time_packed,$alternate_pickup_time_packed,$apt_unit_pickup_packed,$apartment_level_packed,$user_id,$pickup_address_packed_loc_lat,$pickup_address_packed_loc_long);

        $shipping_type ="Delivery Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date_packed,$delivery_address_packed,$preferred_delivery_time_packed,$alternate_delivery_time_packed,$apt_unit_delivery_packed,$apartment_level_packed_delivery,$user_id,$delivery_address_packed_loc_lat,$delivery_address_packed_loc_long);
    }
    
    $shipping_type ="Pickup Empty Boxes";
    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date,$pickup_address,$preferred_pickup_time,$alternate_pickup_time,$apt_unit_pickup,$apartment_level_pickup,$user_id,$pickup_address_loc_lat,$pickup_address_loc_long);

    /*if($period_data_field=="RENTAL"){
        $subject ="Order Confirmation - Data Change Request";
        $body = file_get_contents("template-parts/mail/delivery_change_request.php");

        $array_rental = array('order_id'=>$order_id,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);

        foreach($array_rental as $key=>$value){

            $body = str_replace($key,$value,$body);
        }
        $res_mail = wp_mail($email, $subject, $body);
    }*/
    //echo "Box Count: ".$box_count;
    $shipping_type = 'Pickup Empty Boxes';
    $pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);
    
    $rental_end_date = $pickup_empty_boxes_data['date']; 
    $dayDiff = day_diff_between_two_dates($pickup_date,$rental_end_date);
    $daydiffrence = (int) filter_var($dayDiff, FILTER_SANITIZE_NUMBER_INT);
    //print_r($pickup_empty_boxes_data);
    //print_r($pickup_empty_boxes_data);
    $current_order_id;
    //echo "preferred_delivery_time: ".
    $preferred_delivery_time;
    //echo "apartment_level_delivery: ".
    $apartment_level_delivery;

    if($period_data_field=="RENTAL"&&$daydiffrence>6){

        $subject = "Order Confirmation - Rental Period Extend";
        $body = file_get_contents("template-parts/mail/rental_extension_confirm.php");

        $array_rental = array('order_id'=>$order_id,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,);

        foreach($array_rental as $key=>$value){

            $body = str_replace($key,$value,$body);
        }
        $res_mail = wp_mail($email, $subject, $body);

    }
    $order_status="Order Received";
    $active=1;
    $transaction_status = "Paid";
    $transaction_amount = $total_price;

    insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount);
    insert_into_order_tracking($order_id,$user_id,$order_status,$active);

    $json_array = array('order_id'=>$order_id,'delivery_date'=>$delivery_date,'pickup_date'=>$pickup_date,'payment_status'=>$payment_status);
    echo $json_array1 = json_encode($json_array);
}
function day_diff_between_two_dates($new_date,$db_date){
    /*$datetime1 = new DateTime($new_date);
    $datetime2 = new DateTime($db_date);
    $interval = $datetime1->diff($datetime2);*/

    $datetime1 = date_create($new_date);
    $datetime2 = date_create($db_date);
    $interval = date_diff($datetime1, $datetime2);

    return $interval->format('%d days');
    //echo $interval->format('%R%a days');
}
if($ajax_resquest_type=="remove_payment_method"){
    $query = "UPDATE payments SET active=0,updated_at=NOW() WHERE payment_id=$_POST[rowid]";
    if($query){
        echo "Payment method removed successfully.";
    }else{
        echo "Sorry, Please try agan.";
    }
    mysql_query($query);
}
if($ajax_resquest_type=="add_more_boxes1"){

    //$product_id = $_REQUEST['product_id'];
    $period_datas = $_REQUEST['period_datas'];

    if($period_datas=="RENTAL"){
        $period_data = 0;
    }else{
        $period_data = 1;
    }

    $storesession=get_rebow_session();
    //$storesession->product_id=$product_id;
    $storesession->period_data=$period_data;
    $storesession->period_datas=$period_datas;
    set_rebow_session($storesession);

}
if($ajax_resquest_type=="add_more_boxes_submit"){

    $add_box_count = $_REQUEST['add_box_count'];

    $display_period = $_REQUEST['selectperiod1'];

    $subtotal = $_REQUEST['subtotal'];

    $delivery_cost = $_REQUEST['delivery_cost'];

    $pickup_cost = $_REQUEST['pickup_cost'];

    $sales_tax = $_REQUEST['sales_tax'];

    $total_price = $_REQUEST['total_price'];

    $added_box_price = $_REQUEST['added_box_price'];

    $storesession=get_rebow_session();
    
    $storesession->added_box_count = $add_box_count;

    $storesession->added_box_price = $subtotal;

    $storesession->display_period = $display_period;

    $storesession->subtotal = $subtotal;

    $storesession->delivery_cost = $delivery_cost;

    $storesession->pickup_cost = $pickup_cost;

    $storesession->sales_tax = $sales_tax;

    $storesession->total_price = $total_price;

    $storesession->added_box_price = $added_box_price;

    set_rebow_session($storesession);
    //print_r($storesession);
}
if($ajax_resquest_type=="added_boxes_pickup_delivery_info"){

    $period_data_field = $_REQUEST['period_data_field'];

    $delivery_date = $_REQUEST['delivery_date'];

    $delivery_date = $_REQUEST['delivery_date'];

    $preferred_delivery_time = $_REQUEST['preferred_delivery_time'];

    $alternate_delivery_time = $_REQUEST['alternate_delivery_time'];

    $delivery_address = $_REQUEST['delivery_address'];

    $apt_unit_delivery = $_REQUEST['apt_unit_delivery'];

    $apartment_level_delivery = $_REQUEST['apartment_level_delivery'];

    $delivery_address_loc_lat = $_REQUEST['delivery_address_loc_lat'];

    $delivery_address_loc_long = $_REQUEST['delivery_address_loc_long'];


    $pickup_date = $_REQUEST['pickup_date'];

    $preferred_pickup_time = $_REQUEST['preferred_pickup_time'];

    $alternate_pickup_time = $_REQUEST['alternate_pickup_time'];

    $pickup_address = $_REQUEST['pickup_address'];

    $apt_unit_pickup = $_REQUEST['apt_unit_pickup'];

    $apartment_level_pickup = $_REQUEST['apartment_level_pickup'];

    $pickup_address_loc_lat = $_REQUEST['pickup_address_loc_lat'];

    $pickup_address_loc_long = $_REQUEST['pickup_address_loc_long'];

    $delivery_cost = $_REQUEST['delivery_cost'];

    $pickup_cost = $_REQUEST['pickup_cost'];

    $sales_tax = $_REQUEST['sales_tax'];

    $total_price = $_REQUEST['total_price'];

   
    $storesession = get_rebow_session();
    //print_r($storesession);
    $storesession->delivery_date = $delivery_date;
    $storesession->preferred_delivery_time = $preferred_delivery_time;
    $storesession->alternate_delivery_time = $alternate_delivery_time;
    $storesession->delivery_address = $delivery_address;
    $storesession->apt_unit_delivery = $apt_unit_delivery;
    $storesession->apartment_level_delivery = $apartment_level_delivery;
    $storesession->delivery_address_loc_lat = $delivery_address_loc_lat;
    $storesession->delivery_address_loc_long = $delivery_address_loc_long;


    $storesession->pickup_date = $pickup_date;
    $storesession->preferred_pickup_time = $preferred_pickup_time;
    $storesession->alternate_pickup_time = $alternate_pickup_time;
    $storesession->pickup_address = $pickup_address;
    $storesession->apt_unit_pickup = $apt_unit_pickup;
    $storesession->apartment_level_pickup = $apartment_level_pickup;
    $storesession->pickup_address_loc_lat = $pickup_address_loc_lat;
    $storesession->pickup_address_loc_long = $pickup_address_loc_long;

    $storesession->delivery_cost = $delivery_cost;
    $storesession->pickup_cost = $pickup_cost;
    $storesession->sales_tax = $sales_tax;
    $storesession->total_price = $total_price;
    
    if($period_data_field=='STORAGE'){ 

        $pickup_date_packed = $_REQUEST['pickup_date_packed'];
        
        $preferred_pickup_time_packed = $_REQUEST['preferred_pickup_time_packed'];

        $alternate_pickup_time_packed = $_REQUEST['alternate_pickup_time_packed'];

        $pickup_address_packed = $_REQUEST['pickup_address_packed'];

        $apt_unit_pickup_packed = $_REQUEST['apt_unit_pickup_packed'];

        $apartment_level_packed = $_REQUEST['apartment_level_packed'];

        $pickup_address_packed_loc_lat = $_REQUEST['pickup_address_packed_loc_lat'];

        $pickup_address_packed_loc_long = $_REQUEST['pickup_address_packed_loc_long'];



        $delivery_date_packed = $_REQUEST['delivery_date_packed'];
        
        $preferred_delivery_time_packed = $_REQUEST['preferred_delivery_time_packed'];

        $alternate_delivery_time_packed = $_REQUEST['alternate_delivery_time_packed'];

        $delivery_address_packed = $_REQUEST['delivery_address_packed'];

        $apt_unit_delivery_packed = $_REQUEST['apt_unit_delivery_packed'];

        $apartment_level_packed_delivery = $_REQUEST['apartment_level_packed_delivery'];

        $delivery_address_packed_loc_lat = $_REQUEST['delivery_address_packed_loc_lat'];

        $delivery_address_packed_loc_long = $_REQUEST['delivery_address_packed_loc_long'];


        $storesession->pickup_date_packed = $pickup_date_packed;
        $storesession->preferred_pickup_time_packed = $preferred_pickup_time_packed;
        $storesession->alternate_pickup_time_packed = $alternate_pickup_time_packed;
        $storesession->pickup_address_packed = $pickup_address_packed;
        $storesession->apt_unit_pickup_packed = $apt_unit_pickup_packed;
        $storesession->apartment_level_packed = $apartment_level_packed;
        $storesession->pickup_address_packed_loc_lat = $pickup_address_packed_loc_lat;
        $storesession->pickup_address_packed_loc_long = $pickup_address_packed_loc_long;


        $storesession->selectaddress = $selectaddress;
        
        $storesession->delivery_date_packed = $delivery_date_packed;
        $storesession->preferred_delivery_time_packed = $preferred_delivery_time_packed;
        $storesession->alternate_delivery_time_packed = $alternate_delivery_time_packed;
        $storesession->delivery_address_packed = $delivery_address_packed;
        $storesession->apt_unit_delivery_packed = $apt_unit_delivery_packed;
        $storesession->apartment_level_packed_delivery = $apartment_level_packed_delivery;
        $storesession->delivery_address_packed_loc_lat = $delivery_address_packed_loc_lat;
        $storesession->delivery_address_packed_loc_long = $delivery_address_packed_loc_long;
        
    }
    set_rebow_session($storesession);

}
if($ajax_resquest_type=="edit_pickup_delivery_info"){

    $delivery_date = $_REQUEST['delivery_date'];

    $preferred_delivery_time = $_REQUEST['preferred_delivery_time'];

    $alternate_delivery_time = $_REQUEST['alternate_delivery_time'];

    $delivery_address = $_REQUEST['delivery_address'];

    $apt_unit_delivery = $_REQUEST['apt_unit_delivery'];

    $apartment_level_delivery = $_REQUEST['apartment_level_delivery'];

    $delivery_address_loc_lat = $_REQUEST['delivery_address_loc_lat'];

    $delivery_address_loc_long = $_REQUEST['delivery_address_loc_long'];


    $pickup_date = $_REQUEST['pickup_date'];

    $preferred_pickup_time = $_REQUEST['preferred_pickup_time'];

    $alternate_pickup_time = $_REQUEST['alternate_pickup_time'];

    $pickup_address = $_REQUEST['pickup_address'];

    $apt_unit_pickup = $_REQUEST['apt_unit_pickup'];

    $apartment_level_pickup = $_REQUEST['apartment_level_pickup'];

    $pickup_address_loc_lat = $_REQUEST['pickup_address_loc_lat'];

    $pickup_address_loc_long = $_REQUEST['pickup_address_loc_long'];


    $delivery_cost = $_REQUEST['delivery_cost'];

    $pickup_cost = $_REQUEST['pickup_cost'];
   
    $storesession = get_rebow_session();
    //print_r($storesession);
    $storesession->delivery_date = $delivery_date;
    $storesession->preferred_delivery_time = $preferred_delivery_time;
    $storesession->alternate_delivery_time = $alternate_delivery_time;
    $storesession->delivery_address = $delivery_address;
    $storesession->apt_unit_delivery = $apt_unit_delivery;
    $storesession->apartment_level_delivery = $apartment_level_delivery;
    $storesession->delivery_address_loc_lat = $delivery_address_loc_lat;
    $storesession->delivery_address_loc_long = $delivery_address_loc_long;

    $storesession->pickup_date = $pickup_date;
    $storesession->preferred_pickup_time = $preferred_pickup_time;
    $storesession->alternate_pickup_time = $alternate_pickup_time;
    $storesession->pickup_address = $pickup_address;
    $storesession->apt_unit_pickup = $apt_unit_pickup;
    $storesession->apartment_level_pickup = $apartment_level_pickup;
    $storesession->pickup_address_loc_lat = $pickup_address_loc_lat;
    $storesession->pickup_address_loc_long = $pickup_address_loc_long;

    $storesession->delivery_cost = $delivery_cost;
    $storesession->pickup_cost = $pickup_cost;
    
    if($period_data_field=='STORAGE'){ 

        $pickup_date_packed = $_REQUEST['pickup_date_packed'];
        
        $preferred_pickup_time_packed = $_REQUEST['preferred_pickup_time_packed'];

        $alternate_pickup_time_packed = $_REQUEST['alternate_pickup_time_packed'];

        $pickup_address_packed = $_REQUEST['pickup_address_packed'];

        $apt_unit_pickup_packed = $_REQUEST['apt_unit_pickup_packed'];

        $apartment_level_packed = $_REQUEST['apartment_level_packed'];

        $pickup_address_packed_loc_lat = $_REQUEST['pickup_address_packed_loc_lat'];

        $pickup_address_packed_loc_long = $_REQUEST['pickup_address_packed_loc_long'];


        $delivery_date_packed = $_REQUEST['delivery_date_packed'];
        
        $preferred_delivery_time_packed = $_REQUEST['preferred_delivery_time_packed'];

        $alternate_delivery_time_packed = $_REQUEST['alternate_delivery_time_packed'];

        $delivery_address_packed = $_REQUEST['delivery_address_packed'];

        $apt_unit_delivery_packed = $_REQUEST['apt_unit_delivery_packed'];

        $apartment_level_packed_delivery = $_REQUEST['apartment_level_packed_delivery'];

        $delivery_address_packed_loc_lat = $_REQUEST['delivery_address_packed_loc_lat'];

        $delivery_address_packed_loc_long = $_REQUEST['delivery_address_packed_loc_long'];


        $storesession->pickup_date_packed = $pickup_date_packed;
        $storesession->preferred_pickup_time_packed = $preferred_pickup_time_packed;
        $storesession->alternate_pickup_time_packed = $alternate_pickup_time_packed;
        $storesession->pickup_address_packed = $pickup_address_packed;
        $storesession->apt_unit_pickup_packed = $apt_unit_pickup_packed;
        $storesession->apartment_level_packed = $apartment_level_packed;
        $storesession->pickup_address_packed_loc_lat = $pickup_address_packed_loc_lat;
        $storesession->pickup_address_packed_loc_long = $pickup_address_packed_loc_long;

        $storesession->selectaddress = $selectaddress;
        $storesession->delivery_address_packed = $delivery_address_packed;
        $storesession->apt_unit_delivery_packed = $apt_unit_delivery_packed;
        $storesession->apartment_level_packed_delivery = $apartment_level_packed_delivery;
        $storesession->delivery_address_packed_loc_lat = $delivery_address_packed_loc_lat;
        $storesession->delivery_address_packed_loc_long = $delivery_address_packed_loc_long;
        
    }
    set_rebow_session($storesession);

}
if($ajax_resquest_type=="goto_order_summary2"){

    $product_id = $_REQUEST['product_id'];
    $period_datas = $_REQUEST['period_datas'];

    $added_box_count = $_REQUEST['added_box_count'];
    $pickup_cost = $_REQUEST['pickup_cost'];
    $delivery_cost = $_REQUEST['delivery_cost'];

    $added_box_price = $_REQUEST['added_box_price'];

    if($period_datas=="RENTAL"){
        $period_data = 0;
    }else{
        $period_data = 1;
    }
    $storesession=get_rebow_session();

    $storesession->product_id=$product_id;
    $storesession->period_data=$period_data;
    $storesession->period_datas=$period_datas;
    $storesession->added_box_count=$added_box_count;
    $storesession->pickup_cost=$pickup_cost;
    $storesession->delivery_cost=$delivery_cost;
    $storesession->added_box_price=$added_box_price;

    set_rebow_session($storesession);
}

if($ajax_resquest_type=="goto_order_summary3"){

    $display_period = $_REQUEST['display_period'];
    $dp_period = $_REQUEST['dp_period'];
    $box_count = $_REQUEST['box_count'];
    $added_box_count = $_REQUEST['added_box_count'];
    $added_box_price = $_REQUEST['added_box_price'];
    $product_price = $_REQUEST['product_price'];
    $subtotal = $_REQUEST['subtotal'];
    $delivery_cost = $_REQUEST['delivery_cost'];
    $pickup_cost = $_REQUEST['pickup_cost'];
    $sales_tax = $_REQUEST['sales_tax'];
    $total_price = $_REQUEST['total_price'];
    $period_datas = $_REQUEST['period_datas'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];

    if($period_datas=="RENTAL"){
        $period_data = 0;
    }else{
        $period_data = 1;
    }
    $storesession=get_rebow_session();
    $storesession->display_period=$display_period;
    $storesession->dp_period=$dp_period;
    $storesession->box_count=$box_count;
    $storesession->added_box_count=$added_box_count;
    $storesession->added_box_price=$added_box_price;
    $storesession->product_price=$product_price;
    $storesession->subtotal=$subtotal;
    $storesession->delivery_cost=$delivery_cost;
    $storesession->pickup_cost=$pickup_cost;
    $storesession->sales_tax=$sales_tax;
    $storesession->total_price=$total_price;
    $storesession->period_datas=$period_datas;
    $storesession->start_date=$start_date;
    $storesession->end_date=$end_date;
    $storesession->delivery_date=$start_date;
    $storesession->pickup_date=$end_date;
    //print_r($storesession);
    set_rebow_session($storesession);
}
if($ajax_resquest_type=="submit_support_request"){
    $user_id = wp_get_current_user()->id;

    $name = $_REQUEST['name'];

    $name_array = explode(" ",$name);

    $firstName = $name_array[0];

    $lastName = $name_array[1];

    $email = $_REQUEST['email'];

    $needhelpwith = $_REQUEST['needhelpwith'];

    $supportmsg = $_REQUEST['supportmsg'];

    $active = 1;

    echo $query = "INSERT INTO support(user_id,Full_Name,email,needhelpwith,message,active,updated_at)
            VALUES ($user_id,'$name','$email','$needhelpwith','$supportmsg',$active,NOW())";

    mysql_query($query);

    $subject ="Rebow Support request";
    $array1= array('name1'=>$firstName,'name2'=>$lastName,'name3'=>$email,'name4'=>$supportmsg);
    //$filepath = "template-parts/mail/mail-subscribe.php";
    $body = file_get_contents("template-parts/mail/mail-support.php");
    foreach($array1 as $key=>$value){

        $body = str_replace($key,$value,$body);
    }
    $res_mail = wp_mail($email, $subject, $body);

}
//$email= $_REQUEST['email_id'];
if($ajax_resquest_type=="remove_payment_info"){
    $user_id = wp_get_current_user()->id;


    echo $query = "UPDATE payments SET active=0,updated_at=NOW()
    WHERE user_id=$user_id";

    mysql_query($query);
}

if($ajax_resquest_type=="add_payment_info"){
    $user_id = wp_get_current_user()->id;

    $payment_type = $_REQUEST['payment_type'];

    $firstName = $_REQUEST['firstName'];

    $lasttName = $_REQUEST['lasttName'];

    $select_card_number = $_REQUEST['select_card_number'];

    $selectmonth = $_REQUEST['selectmonth'];

    $selectYear = $_REQUEST['selectYear'];

    $BillingAddress = $_REQUEST['BillingAddress'];

   // $new_billing_address = $_REQUEST['new_billing_address'];

    $active=1;

    echo $query = "INSERT INTO payments(user_id,payment_type,First_Name,Last_Name,Card_Number,Expiry_month,Expiry_year,active,billing_address,created_at,updated_at)
    VALUES ($user_id,'$payment_type','$firstName','$lasttName',$select_card_number,$selectmonth,$selectYear,$active,'$BillingAddress',NOW(),NOW())";

    mysql_query($query);

}
if($ajax_resquest_type=="subscribemail"){
    $email= $_REQUEST['email_id'];
	if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        // MailChimp API credentials
        $apiKey = '93f5cffd21f2e3243d1ef7f04e4c3cd7-us3';
        $listID = 'b270083c2a';
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
        
        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed'
        ]);
        
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // store the status message based on response code
        if ($httpCode == 200) {
            //$_SESSION['msg'] = '<p style="color: #34A853">You have successfully subscribed to Rebow.</p>';
            $msg = "You have successfully subscribed to Rebow";
            $query = "INSERT INTO subscriber_list (subscriber_id,email,status,updated_at)
                    VALUES (NULL,'$email',1,NOW())";
            mysql_query($query);


            $to = $email;
            $subject ="Rebow subscriber";
            $array1= array('name1'=>$email);
            //$filepath = "template-parts/mail/mail-subscribe.php";
            $body = file_get_contents("template-parts/mail/mail-subscribe.php");
            foreach($array1 as $key=>$value){
                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($to, $subject, $body);

            //echo $res_mail = mail_send_function($to,$subject,$array1,$body);
            //break;
        } else {
            switch ($httpCode) {
                case 214:
                    echo $msg = 'You are already subscribed.';
                	
                    break;
                default:
                    echo $msg = 'Some problem occurred, please try again.';
                	
                    break;
            }
            //$_SESSION['msg'] = '<p style="color: #EA4335">'.$msg.'</p>';
        }
    }else{
        echo $msg = 'Please enter valid email address.';
    	
    }
    return $res_mail;
}

if($ajax_resquest_type=="zipcheck"){
    //echo "fdfgdfg";
    $zip_current = $_REQUEST['zip_current'];
    $zip_new = $_REQUEST['zip_new'];
    $msgdisplay = $_REQUEST['alert'];
    if(empty($zip_current) || empty($zip_new)){
        $msg = "Zip code empty.Please fill the zipcode and check again.";
    }else {
        $sql= "select count(*) from zipcodes where zipcode IN ('$zip_current','$zip_new');";
        
        $result = mysql_query($sql);

        $row = mysql_fetch_row($result);
        
        $countzip = $row[0];
        if($countzip==2){
            //echo $msg = "<div class='alert' style='padding: 20px;background-color: #f44336;color: white;'> We service your area! Choose a package to get started or create your own. </div>";
            $msg='We service your area! Choose a package to get started or create your own.';
            $status='Zip code validation successfull';
            $match=1;
            //$session_store1 = new STORE_SESSION();
            //$storesession->set_zip_current($zip_current);
            //$storesession->set_zip_new($zip_new);
            //$storesession->set_zip_status($status);
            //$storesession->order_values;
            $storesession = get_rebow_session();
            $storesession->zip_current = $zip_current;
            $storesession->zip_new = $zip_new;
            $storesession->zip_status = $status;
            $status=true;
            set_rebow_session($storesession);
            //$session_store1->set_order_values($variable_value);

            //$serialobj= serialize($storesession);
            //$_SESSION['STORE_SESSION'] =  $serialobj;
        }else if($countzip==1&&($zip_current==$zip_new)){
            
            $msg='We service your area! Choose a package to get started or create your own.';
            $status='Zip code validation successfull';
            $match=1;
            //$session_store1 = new STORE_SESSION();
            //$storesession->set_zip_current($zip_current);
            //$storesession->set_zip_new($zip_new);
            //$storesession->set_zip_status($status);
            //$storesession->order_values;
            $storesession = get_rebow_session();
            $storesession->zip_current = $zip_current;
            $storesession->zip_new = $zip_new;
            $storesession->zip_status = $status;
            $status=true;
            set_rebow_session($storesession);
        }else{
            $status=false;
            $match=0;
            //echo $msg = "<div class='alert' style='padding: 20px;background-color: #f44336;color: white;'>Sorry! We do not service this area at this time. Please contact us to check availabilty for a custom order. </div>";
            $msg='Sorry! We do not service this area at this time. Please contact us to check availabilty for a custom order. ';
            $status='Zip code validation unsuccessfull';
        }
    }
    
    echo json_encode(array('msg'=>$msg,'status'=>$status,'alert'=>$msgdisplay,'match'=>$match));

}

if($ajax_resquest_type=="zipcheck2"){
    //echo "fdfgdfg";
    $zip_current = $_REQUEST['zip_current'];
    $zip_new = $_REQUEST['zip_new'];
    $msgdisplay = $_REQUEST['alert'];
    if(empty($zip_current) || empty($zip_new)){
        $msg = "Zip code empty.Please fill the zipcode and check again.";
    }else {
        $sql= "select count(*) from zipcodes where zipcode IN ('$zip_current','$zip_new');";
        
        $result = mysql_query($sql);

        $row = mysql_fetch_row($result);
        
        $countzip = $row[0];
        if($countzip==2){
            //echo $msg = "<div class='alert' style='padding: 20px;background-color: #f44336;color: white;'> We service your area! Choose a package to get started or create your own. </div>";
            $msg='We service your area! Choose a package to get started or create your own.';
            $status='Zip code validation successfull';
            $match=1;
            //$session_store1 = new STORE_SESSION();
            //$storesession->set_zip_current($zip_current);
           // $storesession->set_zip_new($zip_new);
            //$storesession->set_zip_status($status);
            //$storesession->order_values;$match=0;
            /*$storesession = get_rebow_session();
            $storesession->zip_current = $zip_current;
            $storesession->zip_new = $zip_new;
            $storesession->zip_status = $status;
            $status=true;
            set_rebow_session($storesession);*/
            //$session_store1->set_order_values($variable_value);

            //$serialobj= serialize($storesession);
            //$_SESSION['STORE_SESSION'] =  $serialobj;
        }else if($countzip==1&&($zip_current==$zip_new)){
            $msg='We service your area! Choose a package to get started or create your own.';
            $status='Zip code validation successfull';
            $match=1;
        }else{
            $match=0;
            //echo $msg = "<div class='alert' style='padding: 20px;background-color: #f44336;color: white;'>Sorry! We do not service this area at this time. Please contact us to check availabilty for a custom order. </div>";
            $msg='Sorry! We do not service this area at this time. Please contact us to check availabilty for a custom order. ';
            $status='Zip code validation unsuccessfull';
        }
    }
    
    echo json_encode(array('msg'=>$msg,'status'=>$status,'alert'=>$msgdisplay,'match'=>$match));

}

if($ajax_resquest_type=="contact_submit"){ 
    
    $fullName = $_REQUEST['fullName'];
    //break;
    $email = $_REQUEST['email'];
    $phonenumber = $_REQUEST['phonenumber'];
    $needhelp = $_REQUEST['needhelp'];
    $message = mysql_escape_string($_REQUEST['message']);
    //$message="";
    //mysql_set_charset('utf8');
    //$db = mysql_select_db("rebow");
    $sql="insert into wp_contacts (Full_Name,email,phonenumber,needhelp,message,created_at)
    values ('$fullName','$email','$phonenumber','$needhelp','$message',NOW());";

    $result = mysql_query($sql);

    if($result==1){
        echo $msg="Inserted Successfully";
    }else{
        echo $msg="Something went wrong";
        echo mysql_error();
    }
    //return $msg;
}
function split_value($data){
    return  explode("_",$data);
}
if($ajax_resquest_type=="setsessionvalues"){

    $result = $_REQUEST['variable_value'];

    
     get_rebow_session();

     $product_id = split_value($result)[2];

     

    $period_data= (strcasecmp(split_value($result)[1],'rental')==0) ? 0 : 1;

    if($period_data==1){
        $period_data_value = "Month to Month";
    }
     //$product_type= (strcasecmp($split_value($result)[1],'rental')==0) ? 0 : 1;
     //$storesession->set_order_values($variable_value);
     $storesession->product_id = $product_id;
     $storesession->period_data = $period_data;
     $storesession->period_data_value = $period_data_value;

     set_rebow_session($storesession);
     //$serialobj= serialize($storesession);
     //$_SESSION['STORE_SESSION'] =  $serialobj;
     //$variable_value = $_REQUEST['variable_value'];

     //$_SESSION[$variable_name] = $variable_value;

     //$variable_value;

}

if($ajax_resquest_type=="custom_order_session"){

    $custom_box_count = $_REQUEST['custom_box_count'];

    $period_data = $_REQUEST['period_data'];


    $product_id = $_REQUEST['product_id'];

    $product_type = $_REQUEST['product_type'];

    get_rebow_session();

    $storesession->box_count = $custom_box_count;

    $storesession->period_data = $period_data;

    $storesession->product_id = $product_id;

    set_rebow_session($storesession);
     //$serialobj= serialize($storesession);
     //$_SESSION['STORE_SESSION'] =  $serialobj;
     //$variable_value = $_REQUEST['variable_value'];

     //$_SESSION[$variable_name] = $variable_value;

     //$variable_value;

}

if($ajax_resquest_type=="gotonextpage"){

    $product_id = $_REQUEST['product_id'];

    $display_period = $_REQUEST['display_period'];

    $dp_period = $_REQUEST['dp_period'];

    $product_name = $_REQUEST['product_name'];

    $box_count = $_REQUEST['box_count'];

    $added_box_count = $_REQUEST['added_box_count'];
    
    $sales_tax = $_REQUEST['sales_tax'];
    echo "Sales_tax: ".$sales_tax;

    $added_box_price = $_REQUEST['added_box_price'];

    $product_price = $_REQUEST['product_price'];

    $subtotal = $_REQUEST['subtotal'];

    $delivery_cost = $_REQUEST['delivery_cost'];

    $pickup_cost = $_REQUEST['pickup_cost'];

    //$sales_tax = $_REQUEST['sales_tax'];

    $total_price = $_REQUEST['total_price'];

    $period_data_value = $_REQUEST['period_data_value'];

    $storesession = get_rebow_session();

    $storesession->product_id = $product_id;

    $storesession->display_period = $display_period;

    $storesession->dp_period = $dp_period;

    $storesession->product_name = $product_name;

    $storesession->box_count = $box_count;

    $storesession->added_box_count = $added_box_count;

    $storesession->sales_tax = $sales_tax;

    $storesession->added_box_price = $added_box_price;

    $storesession->product_price = $product_price;

    $storesession->subtotal = $subtotal;

    $storesession->pickup_cost = $pickup_cost;

    $storesession->delivery_cost = $delivery_cost;

    $storesession->total_price = $total_price;

    $storesession->period_data_value = $period_data_value;

    set_rebow_session($storesession);


}
if($ajax_resquest_type=="show_upadated_package_info"){ 
    
    $product_id = $_REQUEST['product_id'];
    //break;
    $product_name = $_REQUEST['product_name'];

    $selectperiod1 = $_REQUEST['selectperiod1'];

    $period = $_REQUEST['period'];

    //$tax_rates = $_REQUEST['tax_rates'];

    if( isset( $_REQUEST['new_addedboxprice'] ) ) {
        $new_addedboxprice = $_REQUEST['new_addedboxprice'];
    }
    if( isset( $_REQUEST['added_box_count'] ) ) {
        $added_box_count = $_REQUEST['added_box_count'];

    }else{
        
        $added_box_count=0;
    }
    
    //$storage_cost_per_month = $_REQUEST['storage_cost_per_month'];

    //$rental_cost_per_week = $_REQUEST['rental_cost_per_week'];

    $period_data = explode("_",$selectperiod1);

    $duration = $period_data[0];

    $rentalorstorage = $period_data[1];

    $product_name = str_replace("_"," ",$product_name);
    
    $sql="SELECT * FROM products WHERE product_id=".$product_id;

    $result = mysql_query($sql);

    $row = mysql_fetch_assoc($result);

    $product_name = $row['product_name'];

    $product_type = $row['product_type'];

    $product_range = $row['product_range'];

    $box_count = $row['box_count'];

    $nestable_dollies_count = $row['nestable_dollies_count'];

    $labels_count = $row['labels_count'];

    $zipties_count = $row['zipties_count'];

    //$rental_period = 2;
    //$duration = 2;
    $rental_cost_per_week = get_base_pricing('Rental_cost_per_1_box_per_1_week');

    $storage_cost_per_month = get_base_pricing('Monthly_storage_cost_per_box');

    $tax_rates = get_tax_rate();

    if($period=="STORAGE"){
        //$apartment_level = 
        if(isset($_REQUEST['apartment_level_delivery'])){
            $apartment_level_delivery = $_REQUEST['apartment_level_delivery'];
            $apartment_level_delivery_cost = get_pickup_delivery_cost($apartment_level_delivery,$box_count);
        }
        if(isset($_REQUEST['apartment_level_packed'])){
            $apartment_level_packed = $_REQUEST['apartment_level_packed'];
            $apartment_level_packed_cost = get_pickup_delivery_cost($apartment_level_packed,$box_count);
        }
        if(isset( $_REQUEST['apartment_level_packed_delivery'])){
            $apartment_level_packed_delivery = $_REQUEST['apartment_level_packed_delivery'];
            $apartment_level_packed_delivery_cost = get_pickup_delivery_cost($apartment_level_packed_delivery,$box_count);
        }
        if(isset( $_REQUEST['apartment_level_pickup'])){
            $apartment_level_pickup = $_REQUEST['apartment_level_pickup'];
            $apartment_level_pickup_cost = get_pickup_delivery_cost($apartment_level_pickup,$box_count);
        }
        $delivery_cost = $apartment_level_delivery_cost+$apartment_level_packed_delivery_cost;
        $pickup_cost = $apartment_level_packed_cost+$apartment_level_pickup_cost;

    }else if($period=="RENTAL"){
        if(isset($_REQUEST['apartment_level_delivery'])){
            $apartment_level_delivery = $_REQUEST['apartment_level_delivery'];
            $apartment_level_delivery_cost = get_pickup_delivery_cost($apartment_level_delivery,$box_count);
        }
        if(isset( $_REQUEST['apartment_level_pickup'])) {
            $apartment_level_pickup = $_REQUEST['apartment_level_pickup'];
            $apartment_level_pickup_cost = get_pickup_delivery_cost($apartment_level_pickup,$box_count);
        }
        $delivery_cost = $apartment_level_delivery_cost;
        $pickup_cost = $apartment_level_pickup_cost;
    }
    if($rentalorstorage=="Weeks"){
        $rental_period = 2;
        $price = get_rental_price($product_id,$rental_period,$duration);
        $new_addedboxprice = ($added_box_count * $rental_cost_per_week * $duration);
    }else{
        $rental_period = 1;
        $price = get_storage_price($product_id,$rental_period,$duration);
        $new_addedboxprice = ($added_box_count * $storage_cost_per_month * $duration);
    }

    $subtotal = $price + $new_addedboxprice;

    $sales_tax = ($subtotal*$tax_rates)/100;
    
    $total_price = $price+$sales_tax+$new_addedboxprice+$delivery_cost+$pickup_cost;

    $json_array =  array('product_name'=>$product_name,'product_type'=>$product_type,'product_range'=>$product_range,'box_count'=>$box_count,'nestable_dollies_count'=>$nestable_dollies_count,'labels_count'=>$labels_count,'new_addedboxprice'=>$new_addedboxprice,'subtotal'=>$subtotal,'zipties_count'=>$zipties_count,'price'=>$price,'total_price'=>$total_price,'added_box_count'=>$added_box_count,'sales_tax'=>$sales_tax,'delivery_cost'=>$delivery_cost,'pickup_cost'=>$pickup_cost,'period'=>$period,'apartment_level_delivery_cost'=>$apartment_level_delivery_cost);

    echo $json_array1 = json_encode($json_array);

}
if($ajax_resquest_type=="delivery_boxes_data"){
    $delivery_date = $_REQUEST['delivery_date'];

    $preferred_delivery_time = $_REQUEST['preferred_delivery_time'];

    $alternate_delivery_time = $_REQUEST['alternate_delivery_time'];

    $delivery_address = $_REQUEST['delivery_address'];

    $apt_unit = $_REQUEST['apt_unit'];

    $period = $_REQUEST['period'];



    if($period=='RENTAL'){
        $pickup_date = date('Y-m-d', strtotime($delivery_date. ' + 13 days'));
    }else{
        $pickup_date = date('Y-m-d', strtotime($delivery_date. ' + 2 days'));
    }

    $json_array =  array('pickup_date'=>$pickup_date);

    echo $json_array1 = json_encode($json_array);
}

if($ajax_resquest_type==="goto_payments_page"){

    $product_id = $_REQUEST['product_id'];

    $display_period = $_REQUEST['display_period'];

    $dp_period = $_REQUEST['dp_period'];

    $product_name = $_REQUEST['product_name'];

    $box_count = $_REQUEST['box_count'];

    $added_box_count = $_REQUEST['added_box_count'];

    $sales_tax = $_REQUEST['sales_tax'];

    $added_box_price = $_REQUEST['added_box_price'];

    $product_price = $_REQUEST['product_price'];

    $subtotal = $_REQUEST['subtotal'];

    $delivery_cost = $_REQUEST['delivery_cost'];

    $pickup_cost = $_REQUEST['pickup_cost'];

    $total_price = $_REQUEST['total_price'];


    $firstName = $_REQUEST['firstName'];

    $lastName = $_REQUEST['lastName'];

    $email = $_REQUEST['email'];

    $companyName = $_REQUEST['companyName'];

    $phoneNumber = $_REQUEST['phoneNumber'];

    $SecondaryPhoneNumber = $_REQUEST['SecondaryPhoneNumber'];

    $selecthearus = $_REQUEST['selecthearus'];

    $storesession = get_rebow_session();

    $storesession->product_id = $product_id;

    $storesession->display_period = $display_period;

    $storesession->dp_period = $dp_period;

    $storesession->product_name = $product_name;

    $storesession->box_count = $box_count;

    $storesession->added_box_count = $added_box_count;

    $storesession->sales_tax = $sales_tax;

    $storesession->added_box_price = $added_box_price;

    $storesession->product_price = $product_price;

    $storesession->subtotal = $subtotal;

    $storesession->pickup_cost = $pickup_cost;

    $storesession->delivery_cost = $delivery_cost;

    $storesession->total_price = $total_price;

    $storesession->firstName = $firstName;

    $storesession->lastName = $lastName;

    $storesession->email = $email;

    $storesession->companyName = $companyName;

    $storesession->phoneNumber = $phoneNumber;

    $storesession->SecondaryPhoneNumber = $SecondaryPhoneNumber;

    $storesession->selecthearus = $selecthearus;

    set_rebow_session($storesession);
    
}

if($ajax_resquest_type=="goto_order_confirmation_page"){

    $period_data_field = $_REQUEST['period_data_field'];
    if ( is_user_logged_in() ) {

        $user_status=1;
    
    }
    $storesession = get_rebow_session();
    //print_r($storesession);
    $delivery_date = $storesession->delivery_date;
    $preferred_delivery_time = $storesession->preferred_delivery_time;
    $alternate_delivery_time = $storesession->alternate_delivery_time;
    $delivery_address = $storesession->delivery_address;
    $apt_unit_delivery = $storesession->apt_unit_delivery;
    $apartment_level_delivery = $storesession->apartment_level_delivery;
    $delivery_address_loc_lat = $storesession->delivery_address_loc_lat;
    $delivery_address_loc_long = $storesession->delivery_address_loc_long;

    $pickup_date = $storesession->pickup_date;
    $pickup_address = $storesession->pickup_address;
    $preferred_pickup_time = $storesession->preferred_pickup_time;
    $alternate_pickup_time = $storesession->alternate_pickup_time;
    $apt_unit_pickup = $storesession->apt_unit_pickup;
    $apartment_level_pickup = $storesession->apartment_level_pickup;
    $pickup_address_loc_lat = $storesession->pickup_address_loc_lat;
    $pickup_address_loc_long = $storesession->pickup_address_loc_long;

    if($period_data_field=="STORAGE"){

        $delivery_date_packed = $storesession->delivery_date_packed;
        $preferred_delivery_time_packed = $storesession->preferred_delivery_time_packed;
        $alternate_delivery_time_packed = $storesession->alternate_delivery_time_packed;
        $delivery_address_packed = $storesession->delivery_address_packed;
        $apt_unit_delivery_packed = $storesession->apt_unit_delivery_packed;
        $apartment_level_packed_delivery = $storesession->apartment_level_packed_delivery;
        $delivery_address_packed_loc_lat = $storesession->delivery_address_packed_loc_lat;
        $delivery_address_packed_loc_long = $storesession->delivery_address_packed_loc_long;

        $pickup_date_packed = $storesession->pickup_date_packed;
        $preferred_pickup_time_packed = $storesession->preferred_pickup_time_packed;
        $alternate_pickup_time_packed = $storesession->alternate_pickup_time_packed;
        $pickup_address_packed = $storesession->pickup_address_packed;
        $apt_unit_pickup_packed = $storesession->apt_unit_pickup_packed;
        $apartment_level_packed = $storesession->apartment_level_packed;
        $pickup_address_packed_loc_lat = $storesession->pickup_address_packed_loc_lat;
        $pickup_address_packed_loc_long = $storesession->pickup_address_packed_loc_long;
    }
    $product_id = $storesession->product_id;

    $display_period = $storesession->display_period;

    $dp_period = $storesession->dp_period;

    $product_name = $storesession->product_name;

    $box_count = $storesession->box_count;

    $added_box_count =  $storesession->added_box_count;

    $sales_tax = $storesession->sales_tax;

    $added_box_price = $storesession->added_box_price;

    $product_price = $storesession->product_price;

    $subtotal = $storesession->subtotal;

    $delivery_cost = $storesession->delivery_cost;

    $pickup_cost = $storesession->pickup_cost;

    $total_price = $storesession->total_price;

    $new_total_price = $_REQUEST['new_total_price'];

    if(!empty($new_total_price)){
        $total_price = $new_total_price;
    }

    $zip_current= $storesession->zip_current;

    $zip_new = $storesession->zip_new;
    //$order_time_period =  $display_period." ".1$dp_period;
    if(isset($storesession->period_data_value)&&!empty($storesession->period_data_value)){
        $order_time_period =  $storesession->period_data_value;
    }else{
        $order_time_period =  $display_period." ".$dp_period;
    }
    if($user_status==1){
        $user_id = wp_get_current_user()->id;

        $email = wp_get_current_user()->user_email;

    }else{
        $email = $storesession->email;
        $pass = rand_string(10);
        
        $data = array('user_pass'=>$pass,'user_login'=>$storesession->email,'user_email'=>$storesession->email,'first_name'=>$storesession->firstName,'last_name'=>$storesession->lastName);
        $user_id = wp_new_user($data);
        
        if($user_id){
            $subject ="Rebow Account Activation";
            $array1= array('name1'=>$email,'name2'=>$pass);
            //$filepath = "template-parts/mail/mail-subscribe.php";
            $body = file_get_contents("template-parts/mail/mail-account_activation.php");

            foreach($array1 as $key=>$value){
                $body = str_replace($key,$value,$body);
            }
            $res_mail = wp_mail($email, $subject, $body);
        }
    }
    $cuid=0;
    $order_id = insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$period_data_field,$order_time_period,$zip_current,$zip_new,$user_id,$cuid,$subtotal);
    
    $shipping_type ="Delivery Empty Boxes";

    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date,$delivery_address,$preferred_delivery_time,$alternate_delivery_time,$apt_unit_delivery,$apartment_level_delivery,$user_id,$delivery_address_loc_lat,$delivery_address_loc_long);

    if($period_data_field=="STORAGE"){

        $shipping_type ="Pickup Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date_packed,$pickup_address_packed,$preferred_pickup_time_packed,$alternate_pickup_time_packed,$apt_unit_pickup_packed,$apartment_level_packed,$user_id,$pickup_address_packed_loc_lat,$pickup_address_packed_loc_long);

        $shipping_type ="Delivery Packed Boxes";
        insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$delivery_date_packed,$delivery_address_packed,$preferred_delivery_time_packed,$alternate_delivery_time_packed,$apt_unit_delivery_packed,$apartment_level_packed_delivery,$user_id,$delivery_address_packed_loc_lat,$delivery_address_packed_loc_long);
    }
    
    $shipping_type ="Pickup Empty Boxes";
    insert_into_shipping_info($order_id,$period_data_field,$shipping_type,$pickup_date,$pickup_address,$preferred_pickup_time,$alternate_pickup_time,$apt_unit_pickup,$apartment_level_pickup,$user_id,$pickup_address_loc_lat,$pickup_address_loc_long);


    $transaction_status = "Paid";
    $transaction_amount = $total_price;

    insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount);

    $order_status="Order Received";
    $active=1;
    insert_into_order_tracking($order_id,$user_id,$order_status,$active);

    /*$storesession->product_id = $product_id;

    $storesession->display_period = $goto_order_confirmation_page;

    $storesession->dp_period = $dp_period;

    $storesession->product_name = $product_name;

    $storesession->box_count = $box_count;

    $storesession->added_box_count = $added_box_count;

    $storesession->sales_tax = $sales_tax;

    $storesession->added_box_price = $added_box_price;

    $storesession->product_price = $product_price;

    $storesession->subtotal = $subtotal;

    $storesession->pickup_cost = $pickup_cost;

    $storesession->delivery_cost = $delivery_cost;

    $storesession->total_price = $total_price;*/

    //set_rebow_session($storesession);
    //print_r($storesession);
    $firstName = $_REQUEST['firstName'];

    $lastName = $_REQUEST['lastName'];

    $payment_type = $_REQUEST['payment_type'];

    //$cardNumber = $_REQUEST['cardNumber'];

    //$month = $_REQUEST['month'];

    //$Year = $_REQUEST['Year'];

    $billing_address = $_REQUEST['billingaddress'];

    $city = $_REQUEST['city'];

    $zipcode = $_REQUEST['zipcode'];

    $state = $_REQUEST['state'];

    $payment_method_id = $_REQUEST['payment_method_id'];

    $paymentMethod = \Stripe\PaymentMethod::retrieve($payment_method_id);

    $card_number = $paymentMethod->card->last4;

    $exp_month = $paymentMethod->card->exp_month;

    $exp_year = $paymentMethod->card->exp_year;

    //$zipcode = $paymentMethod->billing_details->address->postal_code;

    insert_into_payments($order_id,$user_id,$payment_type,$firstName,$lastName,$card_number,$exp_month,$exp_year,$billing_address,$city,$zipcode,$promocode,$state,$user_id,$payment_method_id);
 
    $first_name = $storesession->firstName;
    $last_name = $storesession->lastName;
    $email = $storesession->email;
    $company_name = $storesession->companyName;
    //$email = $storesession->company_name;
    $phone_number = $storesession->phoneNumber;
    $SecondaryPhoneNumber = $storesession->SecondaryPhoneNumber;
    $hearabotus = $storesession->selecthearus;

    insert_customers_data($user_id,$first_name,$last_name,$email,$company_name,$phone_number,$SecondaryPhoneNumber,$hearabotus,$delivery_address,$pickup_address);
    
    if($order_id!=0){

        if($period_data_field=="RENTAL"){
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");

            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);

            foreach($array_rental as $key=>$value){

                $body = str_replace($key,$value,$body);
            }

            //echo $body;
            $res_mail = wp_mail($email, $subject, $body);
        }else{
            $subject ="Order Confirmation";
            $body = file_get_contents("template-parts/mail/order_confirmation_rental.php");
            
            $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'subtotal'=>$subtotal,'Delivery_Cost'=>$delivery_cost,'Pickup_Cost'=>$pickup_cost,'Sales_tax'=>$sales_tax,'total_price'=>$total_price,'card_ending'=>$cardNumber,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$preferred_delivery_time,'floor_level_delivery'=>$apartment_level_delivery,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$preferred_pickup_time,'floor_level_pickup'=>$apartment_level_pickup);
                
                foreach($array_rental as $key=>$value){

                    $body = str_replace($key,$value,$body);
                }
                $res_mail = wp_mail($email, $subject, $body);
        }

    }

    $json_array = array('user_id'=>$user_id);
    echo $json_array1 = json_encode($json_array);
    //wp_insert_user($user_data);
    //set_rebow_session($storesession);
}
if($ajax_resquest_type=="goto_personal_info_page"){

    $period_data_field = $_REQUEST['period_data_field'];

    $delivery_date = $_REQUEST['delivery_date'];

    $preferred_delivery_time = $_REQUEST['preferred_delivery_time'];

    $alternate_delivery_time = $_REQUEST['alternate_delivery_time'];

    $delivery_address = $_REQUEST['delivery_address'];

    $apt_unit_delivery = $_REQUEST['apt_unit_delivery'];

    $apartment_level_delivery = $_REQUEST['apartment_level_delivery'];

    
    $delivery_address_loc_lat = $_REQUEST['delivery_address_loc_lat'];

    $delivery_address_loc_long = $_REQUEST['delivery_address_loc_long'];

    $pickup_date = $_REQUEST['pickup_date'];

    $preferred_pickup_time = $_REQUEST['preferred_pickup_time'];

    $alternate_pickup_time = $_REQUEST['alternate_pickup_time'];

    $pickup_address = $_REQUEST['pickup_address'];

    $apt_unit_pickup = $_REQUEST['apt_unit_pickup'];

    $apartment_level_pickup = $_REQUEST['apartment_level_pickup'];

    $pickup_address_loc_lat = $_REQUEST['pickup_address_loc_lat'];

    $pickup_address_loc_long = $_REQUEST['pickup_address_loc_long'];

    $storesession = get_rebow_session();
    //print_r($storesession);
    $storesession->delivery_date = $delivery_date;
    $storesession->preferred_delivery_time = $preferred_delivery_time;
    $storesession->alternate_delivery_time = $alternate_delivery_time;
    $storesession->delivery_address = $delivery_address;
    $storesession->apt_unit_delivery = $apt_unit_delivery;
    $storesession->apartment_level_delivery = $apartment_level_delivery;
    $storesession->delivery_address_loc_lat = $delivery_address_loc_lat;
    $storesession->delivery_address_loc_long = $delivery_address_loc_long;

    $storesession->pickup_date = $pickup_date;
    $storesession->preferred_pickup_time = $preferred_pickup_time;
    $storesession->alternate_pickup_time = $alternate_pickup_time;
    $storesession->pickup_address = $pickup_address;
    $storesession->apt_unit_pickup = $apt_unit_pickup;
    $storesession->apartment_level_pickup = $apartment_level_pickup;
    $storesession->pickup_address_loc_lat = $pickup_address_loc_lat;
    $storesession->pickup_address_loc_long = $pickup_address_loc_long;

    $product_id = $_REQUEST['product_id'];

    $display_period = $_REQUEST['display_period'];

    $dp_period = $_REQUEST['dp_period'];

    $product_name = $_REQUEST['product_name'];

    $box_count = $_REQUEST['box_count'];

    $added_box_count = $_REQUEST['added_box_count'];

    $sales_tax = $_REQUEST['sales_tax_field'];

    $added_box_price = $_REQUEST['added_box_price'];

    $product_price = $_REQUEST['product_price'];

    $subtotal = $_REQUEST['subtotal'];

    $delivery_cost = $_REQUEST['delivery_cost'];

    $pickup_cost = $_REQUEST['pickup_cost'];

    $total_price = $_REQUEST['total_price'];

    $period_data_value = $_REQUEST['period_data_value'];

    $storesession->product_id = $product_id;

    $storesession->display_period = $display_period;

    $storesession->dp_period = $dp_period;

    $storesession->product_name = $product_name;

    $storesession->box_count = $box_count;

    $storesession->added_box_count = $added_box_count;

    $storesession->sales_tax = $sales_tax;

    $storesession->added_box_price = $added_box_price;

    $storesession->product_price = $product_price;

    $storesession->subtotal = $subtotal;

    $storesession->pickup_cost = $pickup_cost;

    $storesession->delivery_cost = $delivery_cost;

    $storesession->total_price = $total_price;

    $storesession->period_data_value = $period_data_value;

    ///set_rebow_session($storesession);
    //print_r($storesession);
    if($period_data_field=='STORAGE'){ 

        $pickup_date_packed = $_REQUEST['pickup_date_packed'];
        
        $preferred_pickup_time_packed = $_REQUEST['preferred_pickup_time_packed'];

        $alternate_pickup_time_packed = $_REQUEST['alternate_pickup_time_packed'];

        $pickup_address_packed = $_REQUEST['pickup_address_packed'];

        $apt_unit_pickup_packed = $_REQUEST['apt_unit_pickup_packed'];

        $apartment_level_packed = $_REQUEST['apartment_level_packed'];

        $pickup_address_packed_loc_lat = $_REQUEST['pickup_address_packed_loc_lat'];

        $pickup_address_packed_loc_long = $_REQUEST['pickup_address_packed_loc_long'];
        //$selectaddress = $_REQUEST['selectaddress'];

        $delivery_date_packed = $_REQUEST['delivery_date_packed'];

        $preferred_delivery_time_packed = $_REQUEST['preferred_delivery_time_packed'];

        $alternate_delivery_time_packed = $_REQUEST['alternate_delivery_time_packed'];

        $delivery_address_packed = $_REQUEST['delivery_address_packed'];

        $apt_unit_delivery_packed = $_REQUEST['apt_unit_delivery_packed'];

        $apartment_level_packed_delivery = $_REQUEST['apartment_level_packed_delivery'];

        $delivery_address_packed_loc_lat = $_REQUEST['delivery_address_packed_loc_lat'];

        $delivery_address_packed_loc_long = $_REQUEST['delivery_address_packed_loc_long'];

        $storesession->pickup_date_packed = $pickup_date_packed;
        $storesession->preferred_pickup_time_packed = $preferred_pickup_time_packed;
        $storesession->alternate_pickup_time_packed = $alternate_pickup_time_packed;
        $storesession->pickup_address_packed = $pickup_address_packed;
        $storesession->apt_unit_pickup_packed = $apt_unit_pickup_packed;
        $storesession->apartment_level_packed = $apartment_level_packed;
        $storesession->pickup_address_packed_loc_lat = $pickup_address_packed_loc_lat;
        $storesession->pickup_address_packed_loc_long = $pickup_address_packed_loc_long;
        //$storesession->selectaddress = $selectaddress;

        $storesession->delivery_date_packed = $delivery_date_packed;
        $storesession->preferred_delivery_time_packed = $preferred_delivery_time_packed;
        $storesession->alternate_delivery_time_packed = $alternate_delivery_time_packed;

        $storesession->delivery_address_packed = $delivery_address_packed;
        $storesession->apt_unit_delivery_packed = $apt_unit_delivery_packed;
        $storesession->apartment_level_packed_delivery = $apartment_level_packed_delivery;
        $storesession->delivery_address_packed_loc_lat = $delivery_address_packed_loc_lat;
        $storesession->delivery_address_packed_loc_long = $delivery_address_packed_loc_long;
        
    }
    set_rebow_session($storesession);
}

function get_pickup_delivery_cost($apartment_level,$box_count){
    if($apartment_level=="Elevator"){
        if($box_count<50){
            $apartment_level_delivery_cost = 25;
        }else if($box_count>49&&$box_count<100){
            $apartment_level_delivery_cost = 50;
        }
    }else if($apartment_level=="Stairs"){
        if($box_count<50){
            $apartment_level_delivery_cost = 50;
        }else if($box_count>49&&$box_count<100){
            $apartment_level_delivery_cost = 100;
        }
    }else{
        $apartment_level_delivery_cost = 0;
    }
    return $apartment_level_delivery_cost;
}
function rand_string( $length ) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}
function insert_into_orders($product_id,$display_period,$dp_period,$box_count,$added_box_count,$product_price,$added_box_price,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$order_type,$order_time,$current_address_zipcode,$new_address_zipcode,$user_id,$parent_order_id,$subtotal){

    $query = "INSERT INTO orders_data(`parent_order_id`,`user_id`,`product_id`,`order_type`,`box_count`,`added_box_count`,`product_price`,`order_time_period`,`added_box_price`,`subtotal`,`pickup_cost`,`delivery_cost`,`sales_tax`,`total_price`,`current_address_zipcode`,`new_address_zipcode`,`created_at`,`updated_at`,`active`)
        VALUES ($parent_order_id,$user_id,$product_id,'$order_type',$box_count,$added_box_count,$product_price,'$order_time',$added_box_price,$subtotal,$delivery_cost,$pickup_cost,$sales_tax,$total_price,$current_address_zipcode,$new_address_zipcode,NOW(),NOW(),1)";

    $res = mysql_query($query);

    $id= mysql_insert_id();

    return $id;
}
function insert_into_shipping_info($order_id,$order_type,$shipping_type,$date,$address,$preferred_time,$alternative_time,$apartment_unit_info,$floor_level,$user_id,$latitude,$longitude){
    $query = "INSERT INTO order_shipping(`user_id`,`order_id`,`order_type`,`shipping_type`,`date`,`address`,`preferred_time`,`alternative_time`,`apartment_unit_info`,`floor_level`,`latitude`,`longitude`,`created_at`,`updated_at`,`active`)
        VALUES ($user_id,$order_id,'$order_type','$shipping_type','$date','$address','$preferred_time','$alternative_time','$apartment_unit_info','$floor_level','$latitude','$longitude',NOW(),NOW(),1)";

    $res = mysql_query($query);
}

function insert_into_payments($order_id,$user_id,$payment_type,$First_Name,$Last_Name,$Card_Number,$Expiry_month,$Expiry_year,$billing_address,$city,$zipcode,$promocode,$state,$user_id,$payment_method_id){
    //echo "Query: ".
    $query = "INSERT INTO payments(`order_id`,`user_id`,`payment_type`,`First_Name`,`Last_Name`,`Card_Number`,`Expiry_month`,`Expiry_year`,`billing_address`,`city`,`state`,`zipcode`,`promocode`,`active`,`created_at`,`abandoned`, `paymentmethod_id`)
        VALUES ($order_id,$user_id,'$payment_type','$First_Name','$Last_Name',$Card_Number,$Expiry_month,$Expiry_year,'$billing_address','$city','$state',$zipcode,'$promocode',1,NOW(),1,
        '$payment_method_id')";

    $res = mysql_query($query);
}

function wp_new_user($data) {

    // Separate Data
    $default_newuser = array(
        'user_pass' =>  $data['user_pass'],
        'user_login' => $data['user_login'],
        'user_email' => $data['user_email'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'role'=> 'subscriber'
    );

    $user_id = wp_insert_user($default_newuser);
    //print_r($user_id);
   
    return $user_id;
}
function insert_customers_data($user_id,$first_name,$last_name,$email,$company_name,$phone_number,$SecondaryPhoneNumber,$hearabotus,$delivery_address,$pickup_address){
    $query = "INSERT INTO customers(user_id,first_name,last_name,email,company_name,phone_number,SecondaryPhoneNumber,hearabotus,status,delivery_address,pickup_address)
    VALUES ($user_id,'$first_name','$last_name','$email','$company_name','$phone_number','$SecondaryPhoneNumber','$hearabotus',1,'$delivery_address','$pickup_address')";
    mysql_query($query);

}
function insert_into_order_tracking($order_id,$user_id,$order_status,$active){

    $query = "INSERT INTO order_tracking(`order_id`,`user_id`,`order_status`,`active`,`created_at`,`updated_at`)
    VALUES ($order_id,$user_id,'$order_status',$active,NOW(),NOW())";

    mysql_query($query);

}

function insert_into_transactions($order_id,$user_id,$transaction_status,$transaction_tocken,$transaction_amount){
    $query = "INSERT INTO transactions(`order_id`,`user_id`,`transaction_status`,`transaction_tocken`,transaction_amount,`transaction_time`)
    VALUES ($order_id,$user_id,'$transaction_status','$transaction_tocken','$transaction_amount',NOW())";

    mysql_query($query);
    
}
function mail_send_function($to,$subject,$replace_array,$body){

    //$body = file_get_contents($file_path);
    foreach($replace_array as $key=>$value){
        $body = str_rplace($key,$value,$body);
    }   
    $res_mail = wp_mail($to, $subject, $body);
    return $res_mail;
}
?>