<?php /* Template Name: checkout*/ ?>
<?php 
    require_once("stripe_config.php");
    require_once 'stripe-php/init.php';
    require_once 'db_config.php';
    if ( is_user_logged_in() ) {

      $user_status=1;
    
    }else{
      $user_status=0;
    }
    //\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
    
    if($user_status==1){

      $user_id = wp_get_current_user()->id;

      $email = wp_get_current_user()->user_email;

      $active_card_data = get_active_payment_data($user_id,$user_email);

      $payment_method_id = $active_card_data['payment_method_id'];
      
      $paymentMethod = \Stripe\PaymentMethod::retrieve($payment_method_id);

      $card_number = $paymentMethod->card->last4;

      $exp_month = $paymentMethod->card->exp_month;

      $exp_year = $paymentMethod->card->exp_year;

      $zipcode = $paymentMethod->billing_details->address->postal_code;

      $cards_data = get_cards_data($user_id,$email);


      $intent = \Stripe\SetupIntent::create();
      //print_r($cards_data);
      //exit;
      //print_r($cards_data);
      //print_r($paymentMethod);

    }else{
      $intent = \Stripe\SetupIntent::create();
    }
    
    function get_cards_data($user_id,$email){

        $query = "SELECT * FROM payments p JOIN wp_users u ON p.user_id= u.ID JOIN payment_methods_stripe ps ON ps.email = u.user_email where p.user_id=$user_id and ps.email='$email'";

        $res = mysql_query($query);

        while($row = mysql_fetch_assoc($res)){
            $data[] = $row;
        }
        return $data;
    }
      
    function get_active_payment_data($user_id,$email){

        $query = "SELECT * FROM payments p JOIN wp_users u ON p.user_id= u.ID JOIN payment_methods_stripe ps ON ps.email = u.user_email where p.user_id=$user_id and ps.email='$email' and p.active=1";
        $res = mysql_query($query);

        $row = mysql_fetch_assoc($res);

        return $row;
    }
    /*$customer_cards = \Stripe\Customer::allSources(
      'cus_GWKerwMEW1y5ND'
    );
    $cust = json_encode($customer_cards);
   
    print_r($customer_cards);
    print_r($cust);*/
?>
<html lang="en">
	<body>
    <head>
      <link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
    </head>
		<?php 
		require_once('session_values.php');
		require_once('stripe_config.php');
		//get_header();
		require_once('header2.php');

		$months_array = array("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
		?>
		<!--<div class="container-fluid">-->
		<!-- page heading -->
<section class="page-header mt-10">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col text-center">
        <h1>Complete Checkout</h1>
      </div>
    </div>
  </div>
</section>

<!-- start checkout Details -->
<section class="my-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <div class="grey-bg p-5">
          <div class="row">
            <div class="col-sm-12">
              <input type="hidden" id="user_status" value="<?php echo $user_status;?>"/>
              <form class="checkout-form form" id="paymentFrm">
                <?php //if($user_status!=1){?>
                <div id="new_user_checkout">
                  <div class="form-row">
                    <div class="form-group col-md-12 mb-0">
                      <label for="inputEmail4">Your Name:</label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      
                      <input type="text" class="form-control" id="firstName" value="<?php echo $firstName;?>" placeholder="First Name" required>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="lastName" required value="<?php echo $lastName;?>" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                      <label for="inputAddress">Payment Type :</label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <div class="selectholder">
                        	<label>Payment Type</label>
                        	<select id="payment_type" required>
              							<option value="">Select</option>
              							<option value="Mastercard">Mastercard</option>
              							<option value="Visa">Visa</option>
              							<option value="American_Express">American Express</option>
              							
              						</select>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/payment-method-img.png" alt="">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <span id="card-number" class="form-control">
                            <!-- Stripe Card Element -->
                      </span>
                      <!--<input type="text" name="card-number" class="form-control" id="card-number" value="<?php //echo $cardNumber;?>" placeholder="Card Number*"/>-->
                    </div>
                    <div class="form-group col-md-3">
                      <!--<input type="text" name="card-cvc" id="card-cvc" value="<?php //echo $CCV;?>" placeholder="CCV*"/>-->
                      <span id="card-cvc" class="form-control">
                            <!-- Stripe CVC Element -->
                      </span>
                    </div>
                  </div>
                <div class="form-row">
                  <div class="form-group col-md-12 mb-0">
                    <label for="inputEmail4">Expiration Date :</label>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <span id="card-exp" class="form-control">
                      <!-- Stripe Card Expiry Element -->
                    </span>
                  </div>
                      <!--<div class="form-group col-md-4">
                        <select id="month">
                          <option value="01">January</option>
                          <option value="02">February</option>
                          <option value="03">March</option>
                          <option value="04">April</option>
                          <option value="05">May</option>
                          <option value="06">June</option>
                          <option value="07">July</option>
                          <option value="08">August</option>
                          <option value="09">September</option>
                          <option value="10">October</option>
                          <option value="11">November</option>
                          <option value="12">December</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <select id="Year">
                          <option value="2020">2020</option>
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
                      </div>-->
                  
                </div>
                  <!-- <div class="form-row" style="display:none;">
                    <div class="form-group col-md-8">
                      <div id="card-element"></div>
                    </div>
                  </div> -->
                  
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-12 mb-0">
                    <label for="inputEmail4">Billing Address :</label>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <div class="location-pin">
                      <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
                    </div>
                    <input class="addrs" type="text" placeholder="Address*" name="billingaddress" id="billingaddress" value="<?php //echo $billing_address;?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="city" required placeholder="City*" value="<?php //echo $city;?>" >
                  </div>
                  <div class="form-group col-md-3">
                    <div class="selectholder">
                      	<label>State*</label>
                      	<select id="state" required>
              							<option selected value="">State</option>
              							<option value="Alabama">Alabama</option>
              							<option value="Alaska">Alaska</option>
              							<option value="California">California</option>
              					</select>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="zipcode" placeholder="Zip Code*">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="promocode" placeholder="Promo Code">
                  </div>
                </div>
                 <div class="form-row">
                  <div class="form-group col-md-12">
                    <label class="control control-checkbox">I agree to ReBow’s <strong>Terms and Conditions</strong> and I agree to let ReBow charge my card for the amount shown below
                      <input id="terms_conditions" type="checkbox" required/>
                      <div class="control-indicator"></div>
                    </label>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label class="control control-checkbox">I would like to receive news and updates from ReBow
                      <input id="news_updates" type="checkbox"/>
                      <div class="control-indicator"></div>
                    </label>
                  </div>
                </div>
                <button type="button" id="submit_order" data-secret="<?= $intent->client_secret ?>" class="submit_order_new btn btn-secondary" onclick="test_card()">Submit Order</button>
              </form>
              <div class="row my-3">
                <div class="col-sm-12">
                  <h6 class="card-charge">Your card will be charged $<?php echo $total_price;?></h6>
                </div>
                <div class="col-sm-12 mt-3">
                  <p>Please review your order and make sure all information is correct before submitting.</p>
                </div>
              </div>
              <div class="col-sm-12 pl-0 powered">
                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/lock.png" alt="">
                <p>This form is secure and encrypted.</p>
                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/powered-by-stripe.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Right side -->
      <div class="col-sm-12 col-md-4 checkout">
        <div class="row justify-content-end">
          <div class="col-sm-12 text-right pr-0">
            <button class="submit_order_new btn btn-secondary mb-3" id="submit_order1" data-secret="<?= $intent->client_secret ?>" onclick="test_card()">Submit Order</button>
            <p>Your card will be charged $<?php echo $total_price;?></p>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-12 blue-bg p-3">
            <p>ORDER SUMMARY</p>
          </div>
          <div class="col-sm-12 p-0">
            <div class="grey-bg px-4 pt-4">
                <p class="pkg">Items:</p>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div class="col-md-8 p-0">
                      <ul class="pkg-info">
                        <li><span id="product_name"> <?php echo $product_name;?></span> / <span id="box_count"><?php echo $period_data_span;?></span></li>
    					           <li id="addedboxesfield" class="hide_added_boxes_data"><span id="addedboxno"><?php echo $added_box_no;?> </span> Added Boxes
    					           </li>
                      </ul>
                    </div>
                    <div class="col-md-4 p-0 text-right align-self-end">
                       <span id="price_text">$<?php echo $display_data_price; ?></span>
                        <div class="clearfix"></div>
                        <span id="addedboxprice" class="hide_added_boxes_data">$<?php echo $added_box_price;?></span>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div class="col-md-8 p-0 align-self-end">
                      <p class="my-0">Subtotal</p>
                    </div>
                    <div class="col-md-4 p-0 text-right">
                      <span id="subtotal" class="text-muted">$<?php echo $subtotal_price;?></span>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div class="col-md-8 p-0 align-self-end">
                      <p id="deliveryinfo" class="my-0">Delivery - <span id="delivery_floor_level"><?php echo $apartment_level_delivery_text;?></span></p>
                      <p id="pickupinfo" class="my-0">Pickup - <span id="pickup_floor_level"><?php echo $apartment_level_pickup_text;?></span></p>
                    </div>
                    <div class="col-md-4 p-0 text-right align-self-end">
                      <span id="delivery_cost" class="text-muted">$<?php echo $delivery_cost;?></span>
                      <div class="clearfix"></div>
                      <span id="pickup_cost" class="text-muted">$<?php echo $pickup_cost;?></span>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div class="col-md-8 p-0 align-self-end">
                      <p class="my-0">Sales Tax</p>
                    </div>
                    <div class="col-md-4 p-0 text-right align-self-end">
                      <span id="sales_tax" class="text-muted">$<?php echo $sales_tax;?></span>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between total">
                    <span>Total</span>
                    <strong id="total_price">$<?php echo $total_price;?></strong>
                  </li>

                  <li id="promo_price_div" class="list-group-item d-flex justify-content-between hidecm">
                    <span>Promo Price</span>
                    <label>$<span id="promo_price">$<?php echo $promo_price;?></span></label>
                  </li>
                  <li id="new_total_price_div" class="list-group-item d-flex justify-content-between hidecm">
                    <span>New Total</span>
                    <label>$<span id="new_total_price"><?php echo $new_total_price;?></span></label>
                  </li>
                </ul>
              </div>
          </div>
        </div>
        <!-- information -->
        <div class="row mt-2">
          <div class="col-sm-9 p-3 blue-bg">
            <p>YOUR INFORMATION </p>
          </div>
          <div class="col-sm-3 p-3 blue-bg edit">
            <em class="text-right"><a href="/rebow/personal-information/">EDIT</a></em>
          </div>
          <div class="col-sm-12 p-0">
           <div class="grey-bg p-4 pt-4">
             <div class="row">
               <div class="col-sm-12 pb-2 information">
                 <label for="">Name :</label>
                 <p><?php echo $firstName." ".$lastName;?></p>
               </div>
             </div>
             <div class="row">
               <div class="col-sm-12 pb-2 information">
                 <label for="">Email :</label>
                 <p><?php echo $email;?></p>
               </div>
             </div>
             <div class="row">
               <div class="col-sm-12 pb-2 information">
                <label for="">Company Name  :</label>
                <p><?php echo $companyName;?></p>
              </div>
             </div>
             <div class="row">
               <div class="col-sm-12 pb-2 information">
                  <label for="">Phone Number:</label>
                  <p><?php echo $phoneNumber;?></p>
                </div>
             </div>
              <div class="row">
               <div class="col-sm-12 pb-2 information">
                  <label for="">Secondary Phone Number:</label>
                  <p><?php echo $SecondaryPhoneNumber;?></p>
                </div>
             </div>
           </div>
          </div>
        </div>
        <!-- Order Details -->
        <div class="row">
          <div class="col-sm-9 p-3 blue-bg">
            <p>ORDER DETAILS </p>
          </div>
          <div class="col-sm-3 p-3 blue-bg edit">
            <em class="text-right"><a href="/rebow/selectperiod/">EDIT</a></em>
          </div>
          <div class="col-sm-12 p-0">
           <div class="grey-bg p-4 pt-4">
            <?php if($period_datas=='STORAGE'){?>
            <ul class="pkg-info">
              
                <li class=""><?php echo $period_datas." - ".$product_name." - ".$box_count." Boxes"?></li>
              
            </ul>
            <label class="time-period">Storage Period : <span><?php echo $period_data_value;?></span></label>
            <?php }else{?>
              <ul class="pkg-info">
                <?php $product_range_text=($product_range!="")? "(".$product_range.")" :"";?>
                <li class=""><?php echo $product_name." Package".$product_range_text;?></li>
              </ul>
            <label class="time-period">Rental Period: <span><?php echo $period_data_value;?></span></label>
            <?php }?>
            <small class="ml-3"><em>  Includes : </em></small>
            <ul class="includs">
              <li><?php echo $box_count?> Boxes</li>
              <li><?php echo $nestable_dollies_count;?> Nestable Dollies</li>
              <li><?php echo $labels_count;?> Labels</li>
              <li><?php echo $zipties_count;?> Security Zip Ties</li>
            </ul>
            <ul class="pkg-info mt-3 hide_added_boxes_data">
              <li class=""><?php echo $added_box_no." Boxes - Added";?></li>
            </ul>
            <small class="ml-3 hide_added_boxes_data"><em>  Includes : </em></small>
            <ul class="includs hide_added_boxes_data">
              <li><?php echo ($added_box_no/4);?> Nestable Dollies</li>
              <li><?php echo $added_box_no;?> Labels</li>
              <li><?php echo $added_box_no;?> Zipties</li>
            </ul>

           </div>
          </div>
        </div>
        <!-- Delivery and pickup details -->
        <div class="row">
          <div class="col-sm-9 p-3 blue-bg">
            <p>DELIVERY & PICK UP DETAILS</p>
          </div>
          <div class="col-sm-3 p-3 blue-bg edit">
            <em class="text-right"><a href="/rebow/delivery_pickup/">EDIT</a></em>
          </div>
          <div class="col-sm-12 p-0">
          	<?php if($period_datas=="RENTAL"){?>
           	<div class="grey-bg p-4 pt-4 delivery-details">
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for="">Delivery Address  : </label>
                		<div class="clearfix"></div>
                 		<p><?php echo $delivery_address;?></p>
                 		<p><?php echo $apt_unit_delivery;?></p>
               		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Delivery Date :</label>
                 		<p><?php 
                    $date=date_create($delivery_date);
                    echo date_format($date,"M d, Y");
                    //cho $delivery_date;?></p>
               		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for="">Optional Delivery Times :</label>
                		<p><?php echo str_replace("_"," ",$preferred_delivery_time)." PST OR ".str_replace("_"," ",$alternate_delivery_time)." PST";?></p>
              		</div>
             	</div>
              <div class="row">
                  <div class="col-sm-12 pb-2 information">
                    <label for="">Delivery :</label>
                      <p><span id="delivery_floor_level"><?php echo $apartment_level_delivery_text;?></span></p>
                  </div>
              </div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">Pick Up Address:</label>
                      <div class="clearfix"></div>
                  		<p><?php echo $pickup_address;?></p>
                      <p><?php echo $apt_unit_pickup;?></p>
                	</div>
             	</div>
              	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Pick Up Date</label>
                  		<p>
                        <?php
                        $date = date_create($pickup_date);
                        echo date_format($date,"M d, Y");
                        //echo $pickup_date;?>
                      </p>
                	</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  	<label for="">Optional Pick Up Times :</label>
                  	<p><?php echo str_replace("_"," ",$preferred_pickup_time)." PST OR ".str_replace("_"," ",$alternate_pickup_time)." PST";?></p>
                	</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Pick Up :</label>
                  		<p><span id="pickup_floor_level"><?php echo $apartment_level_pickup_text;?></span></p>
                	</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  	<label for="">*We will confirm these times with you  within 24-48 hours after your order</label>
                	</div>
             	</div>
            </div>
          <?php }else{?>
     		<div class="grey-bg p-4 pt-4 delivery-details">
     			    <div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for=""><b>ITEMS GOING INTO STORAGE</b></label>
               		</div>
              </div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for="">Delivery Address  : </label>
                		<div class="clearfix"></div>
                 		<p><?php echo $delivery_address;?></p><br>
                 		<p><?php echo $apt_unit_delivery;?></p>
               		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Delivery Date :</label>
                 		<p><?php echo $delivery_date;?></p>
               		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for="">Optional Delivery Times :</label>
                		<p><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></p>
              		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">Pick up Address :</label>
                  		<p><?php echo $pickup_address_packed;?><br/><?php echo $apt_unit_pickup_packed;?></p>
                	</div>
             	</div>
              <div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Pick Up Date</label>
                  		<p><?php echo $pickup_date_packed;?></p>
                	</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">Optional Pick Up Times :</label>
                  		<p><?php echo $preferred_pickup_time_packed." PST OR ".$alternate_pickup_time_packed." PST";?></p>
                	</div>
             	</div>
             	<div class="row">
                  <div class="col-sm-12 pb-2 information">
                    <label for="">Pick up :</label>
                      <p><span id="pickup_floor_level"><?php echo $apartment_level_pickup;?></span></p>
                  </div>
              </div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">*We will confirm these times with you  within 24-48 hours after your order</label>
                	</div>
             	</div>
            </div>

            <div class="grey-bg p-4 pt-4 delivery-details">
     			<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for=""><b>ITEMS GOING OUT OF STORAGE</b></label>
               		</div>
               	</div>
             	
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for="">Delivery Address  : </label>
                		<div class="clearfix"></div>
                 		<p><?php echo $delivery_address_packed;?></p><br>
                 		<p><?php echo $apt_unit_delivery_packed?></p>
               		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Delivery Date :</label>
                 		<p><?php echo $delivery_date;?></p>
               		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                		<label for="">Optional Delivery Times :</label>
                		<p><?php echo $preferred_delivery_time_packed." PST OR ".$alternate_delivery_time_packed." PST";?></p>
              		</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">Pick up Address:</label>
                  		<p><?php echo $pickup_address;?><br/><?php echo $apt_unit_pickup;?></p>
                	</div>
             	</div>
              	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                 		<label for="">Pick Up Date</label>
                  		<p><?php echo $pickup_date;?></p>
                	</div>
             	</div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">Optional Pick Up Times :</label>
                  		<p><?php echo $preferred_pickup_time." PST OR ".$alternate_pickup_time." PST";?></p>
                	</div>
             	</div>
             	<div class="row">
                  <div class="col-sm-12 pb-2 information">
                    <label for="">Pick Up :</label>
                      <p><span id="pickup_floor_level"><?php echo $apartment_level_pickup;?></span></p>
                  </div>
              </div>
             	<div class="row">
               		<div class="col-sm-12 pb-2 information">
                  		<label for="">*We will confirm these times with you  within 24-48 hours after your order</label>
                	</div>
             	</div>
            </div>
            <?php }?>
           	
          </div>
        </div>
      </div>
    </div>
  </div>
</section>	
		<!--</div>-->
		<?php get_footer(); ?>

		<!-- Stripe JavaScript library -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBtVumWdkvUED3b_Ct75wcYXsJQmKQWuXM"></script>
    <script>
      //var searchInput = 'delivery_address';

      jQuery(document).ready(function () {
        //alert(1);
          set_lat_long1("billingaddress");

      });

      function set_lat_long1(searchInput){
        var autocomplete;
          autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
              types: ['geocode'],
          });
        
          google.maps.event.addListener(autocomplete, 'place_changed', function () {
              var near_place = autocomplete.getPlace();

              //document.getElementById(latvar).value = near_place.geometry.location.lat();
              //document.getElementById(longvar).value = near_place.geometry.location.lng();
              
              //document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
              //document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
          });
      }
    </script>
		<script src="https://js.stripe.com/v3/"></script>

		<script>
        // Set your publishable key: remember to change this to your live publishable key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        //var user_status = document.getElementById('user_status').value;
        //alert(user_status);
        
        var stripe = Stripe('pk_test_jtWtIVtWDtzfftY59MQaNGJQ00ZZy89Axo');
        // cardButton.addEventListener('click', function(ev) {
            var elements = stripe.elements();
          // Set up Stripe.js and Elements to use in checkout form
          // var style = {
          //   base: {
          //     color: "Red",
          //   }
          // };

          // var cardElement = elements.create('card',{ style: style,value:'424242' });
          // cardElement.mount('#card-element');

          // var cardholderName = document.getElementById('firstName');
          var cardButton = document.getElementById('submit_order');
          
          var clientSecret = cardButton.dataset.secret;

          // Try to match bootstrap 4 styling
          var style = {
              base: {
                  'lineHeight': '1.35',
                  'fontSize': '1.11rem',
                  'color': 'green',
                  'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
              }
          };

          // Card number
          var card = elements.create('cardNumber', {
              'placeholder': 'Card Number*',
              'style': style
          });
          card.mount('#card-number');

          // CVC
          var cvc = elements.create('cardCvc', {
              'placeholder': 'CCV*',
              'style': style
          });
          cvc.mount('#card-cvc');

          // Card expiry
          var exp = elements.create('cardExpiry', {
              'placeholder': 'MM/YY',
              'style': style
          });
          exp.mount('#card-exp');


      jQuery(document).ready(function() {

        jQuery("#month").change(function(event) {
          //console.log("keydown");
          var month = jQuery(this).val();
          console.log(month);

         jQuery("input[name='exp-date']").val(month);

        });
        jQuery("#Year").change(function(event) {
          //console.log("keydown");
          var Year = jQuery(this).val();
          console.log(Year);

          //jQuery('#card-exp').val(Year);

        });
         


        var added_box_count_field = jQuery('#added_box_count_field').val();
        //alert(added_box_count_field);
        if(added_box_count_field==0){
          jQuery('.hide_added_boxes_data').hide();
        }else{
          jQuery('.hide_added_boxes_data').show();
        }

        var user_status = document.getElementById('user_status').value;
        //alert(user_status);
        if(user_status==0){
          //set_up_stripe_for_first_user();
        }else{

          //set_up_stripe_for_existing_user();
            //var submit_screct = jQuery('#submit_order').attr('data-secret');
            /*var submit_secret = document.getElementById("submit_order").getAttribute("data-secret");
            if(submit_secret!=""){
              document.getElementById("submit_order").setAttribute("data-secret","");
            }
            */

        }
        function set_up_stripe_for_first_user(){
          
          //alert("new_user");
          var elements = stripe.elements();
          // Set up Stripe.js and Elements to use in checkout form
          alert(1);
          var style = {
              base: {
                color: "#32325d",
              }
            
          };

          var cardElement = elements.create('card',{ style: style });
          cardElement.mount('#card-element');

          var cardholderName = document.getElementById('firstName');
          var cardButton = document.getElementById('submit_order');
            //var cardholder_name = document.getElementById('firstName').value;
          
            //jQuery('input[name="cardnumber"').val('<?php //echo $card_number?>');
            //jQuery('input[name="exp-date"').val('<?php //echo $exp_month?>');
            //jQuery('input[name="cvc"').val('***>');

          var clientSecret = cardButton.dataset.secret;
            /*var cardnumber = '<?php// echo $card_number?>';
            setTimeout(function(){ 
              document.getElementsByName('cardnumber')[0].value = cardnumber;
              document.getElementsByName('exp-date')[0].value = exp_month;
              document.getElementsByName('cvc')[0].value = '***'; 
            }, 3000);*/
            
            //alert(clientSecret);
            
        }

        function set_up_stripe_for_existing_user (){
          //alert(123);
           alert(2);
          //alert("new_user");
          //11var intent = "<?php //echo $intent = \Stripe\SetupIntent::create();?>";
          var elements = stripe.elements();
          // Set up Stripe.js and Elements to use in checkout form
          var style = {
            base: {
              color: "#32325d",
            }
          };

          var cardElement = elements.create('card',{ style: style });
          cardElement.mount('#card-element');

          var cardholderName = document.getElementById('firstName');
          var cardButton = document.getElementById('submit_order');
          
          var clientSecret = cardButton.dataset.secret;
          
            cardButton.addEventListener('click', function(ev) {
              ev.preventDefault();
              stripe.confirmCardSetup(
                clientSecret,
                {
                  payment_method: {
                    card: cardElement,
                    billing_details: {name: cardholderName.value}
                  }
                }
              ).then(function(result) {
                if (result.error) {
                  // Display error.message in your UI.
                  console.log(result);
                  //alert("unsuccessful");
                } else {
                  //console.log(result);
                  //alert("successful");
                  var data = JSON.stringify(result);
                  var user_status = jQuery('#user_status').val();
                  var billing_address = jQuery('#billing_address').val();
                  var period_data_field = jQuery('#period_data_field').val();
                  var city = jQuery('#city').val();
                  var state = jQuery('#state').val();
                  
                  var datastring = "ajax_request=send_card_intent2&user_status="+user_status+"&result="+data+"&state="+state+"&billing_address="+billing_address+"&city="+city+"&period_data_field="+period_data_field;
                  
                  //var result = <?php //echo json_encode($data) ?>;
                  jQuery.ajax({
                    url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                    method : "POST",
                    data : datastring,
                    //contentType: "application/json; charset=utf-8",

                    success: function(result){
                        //alert(1);
                        console.log(result);

                        var jsonOBJ = JSON.parse(result);
                        if(jsonOBJ.subscription_status=="active" || jsonOBJ.payment_status=="succeeded"){
                          jQuery(location).attr('href', '/rebow/order-confirmation/');
                        }
                        //jQuery(location).attr('href', '/rebow/order-confirmation/');
                    }
                  });
                }
              });
            });
        }
			/*function stripeResponseHandler(status, response) {
		      console.log('card status: ', status);
		      console.log('token: ', response.id);
		      $.ajax({
		        type: 'POST',
		        url: 'https://checkout.stripe.com/checkout.js',
		        headers: {
		          stripeToken: response.id
		        },
		        data: {
		          number: ccNum,
		          cvc: ccCVC,
		          exp_month: ccMonth,
		          exp_year: ccYear
		        },
		        success: (response) => {
		          console.log('successful payment: ', response);
		        },
		        error: (response) => {
		          console.log('error payment: ', response);
		        }
		      })
		    }*/
			//Stripe.setPublishableKey('<?php //echo STRIPE_PUBLISHABLE_KEY; ?>');

			

        jQuery('#select_card').change(function(){
          
          var selected_card = jQuery('#select_card').val();
         // alert(selected_card);
          if(selected_card=="add_new_card"){

            document.getElementById("submit_order").setAttribute("data-secret",submit_secret);
            jQuery('#exp_month').attr("type","hidden");
            jQuery('#exp_year').attr("type","hidden");

            jQuery('.new_card_element').show();
            set_up_stripe_for_existing_user();
          }else{
            jQuery('#exp_month').attr("type","text");
            jQuery('#exp_year').attr("type","text");
            jQuery('.new_card_element').hide();
          }

        });
				var added_box_count_field = jQuery('#added_box_count_field').val();
				//alert(added_box_count_field);
				if(added_box_count_field>0){
					jQuery('#addedboxesfield').show();
				}
        $( "#promocode" ).blur(function() {
          //alert('promocode check');
          var promocode = $('#promocode').val();
          if(promocode!=''){
            datastring = "ajax_request=promocode_check&promocode="+promocode;
            var total_price = $('#total_price_field').val();
            jQuery.ajax({
                url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                method : "POST",
                data : datastring,
                success: function(result){
                    //alert(1);
                  console.log(result);
                  var jsonOBJ = JSON.parse(result);
                  console.log(jsonOBJ);
                  if(jsonOBJ.msg=="Invalid Coupon Code"){
                    alert("Invalid Coupon Code");
                  }else if(jsonOBJ.msg=="Valid Coupon"){
                    jQuery('#promo_price_div').removeClass('hidecm');
                    jQuery('#new_total_price_div').removeClass('hidecm');
                    //alert("Valid Coupon Code");
                    if(jsonOBJ.promotion_type=="Fixed_Amount"){
                      var discount_amount = jsonOBJ.discount_amount;
                      //console.log(discount_amount);
                    }else if(jsonOBJ.promotion_type=="Percentage_Off"){
                      var Percentage_Off = jsonOBJ.percentage_off;
                      
                      var discount_amount = (total_price*Percentage_Off)/100;
                      
                    } 
                    console.log(discount_amount);
                    jQuery('#promo_price').text(discount_amount);
                    console.log(total_price);
                    var new_total_price = (total_price-discount_amount);
                    new_total_price = new_total_price.toFixed(2);
                    console.log(new_total_price);
                    jQuery('#new_total_price').text(new_total_price);
                  }
                }
              });

          }
        });
				jQuery('#submit_order1').click(function() {
					//datastring = "ajax_request=goto_order_confirmation_page&firstName="+firstName+"&lastName="+lastName+"&payment_type="+payment_type+"&cardNumber="+cardNumber+"&CCV="+ccv+"&month="+exp_month+"&Year="+exp_year+"&billingaddress="+billingaddress+"&city="+city+"&zipcode="+zipcode+"&state="+state+"&period_data_field="+period_data_field;
					
					//alert(datastring);
					
					/*jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);

						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});*/
          
				});
        // jQuery('#paymentFrm').submit(function(event){
        //     //alert("clicked");
        //     event.preventDefault();
        //     var period_data_field = jQuery('#period_data_field').val();
        //     var selected_card = jQuery('#select_card').val();
        //     if(user_status!=0&&selected_card!='add_new_card'){
        //       var datastring = "ajax_request=charge_using_existing_card&user_status="+user_status+"&period_data_field="+period_data_field;

        //       jQuery.ajax({
        //         url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
        //         method : "POST",
        //         data : datastring,
        //         success: function(result){
        //           console.log(result);
        //           var jsonOBJ = JSON.parse(result);
        //           if(jsonOBJ.subscription_status=="active" || jsonOBJ.payment_status=="succeeded"){
        //             jQuery(location).attr('href', '/rebow/order-confirmation/');
        //           }
                  
        //         }
        //       });
        //     }
            
        //     //alert(1);
        // })
				// jQuery("#paymentFrm1").submit(function(event){
		  //       	// Disable the submit button to prevent repeated clicks
    //           //alert("Clicked");
		  //       	event.preventDefault();
		  //       	//jQuery('#submit_order').attr("disabled", "disabled");

		  //       	var datastring = "";
    // 					var period = jQuery('#period').val(); 

    // 					var period_data_field = jQuery('#period_data_field').val();
    					
    // 					var firstName = jQuery('#firstName').val();
    // 					//alert(firstName);
    // 					var lastName = jQuery('#lastName').val();

    // 					var account_holder_name = firstName+" "+lastName;

    // 					var payment_type = jQuery('#payment_type').val();

    // 					var cardNumber = jQuery('#cardNumber').val();
    // 					//alert(cardNumber);

    // 					var ccv = jQuery('#CCV').val();
    // 					//alert(ccv);
    // 					var exp_month = jQuery('#month').val();
    // 					//alert(exp_month);
    // 					var exp_year = jQuery('#Year').val();
    // 					//alert(exp_year);
    // 					var billingaddress = jQuery('#billingaddress').val();

    // 					var city = jQuery('#city').val();

    // 					var zipcode = jQuery('#zipcode').val();

    // 					var state = jQuery('#state').val();
    // 					var address_country ='US';
    // 					var currency ='USD';
    // 					//var promocode = jQuery('#promocode').val();

    //           //payment_checkout();
    // 					//var result = create_token(currency,cardNumber,account_holder_name,city,state,zipcode,address_country,exp_month,exp_year,ccv);
    // 					//console.log(result);

    // 					//console.log(result.id);

    // 					/*datastring = "ajax_request=goto_order_confirmation_page&firstName="+firstName+"&lastName="+lastName+"&payment_type="+payment_type+"&cardNumber="+cardNumber+"&CCV="+ccv+"&month="+exp_month+"&Year="+exp_year+"&billingaddress="+billingaddress+"&city="+city+"&zipcode="+zipcode+"&state="+state+"&period_data_field="+period_data_field;
    					
    // 					//alert(datastring);
    					
    // 					jQuery.ajax({
    // 						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
    // 						method : "POST",
    // 						data : datastring,
    // 						success: function(result){
    						    
    						    
    // 						    console.log(result);

    						    
    // 						}
    // 					});*/
		  //       });
			});
    function test_card(){

          if(jQuery('#payment_type').val()==''){
            alert('Fill all required field');
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#new_user_checkout").offset().top
            }, 1000);
            setTimeout(function(){
              jQuery('#payment_type').focus();
            },1000);
            return false;
          }

          if(jQuery('#billingaddress').val()==''){
            alert('Fill all required field');
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#new_user_checkout").offset().top
            }, 1000);
            setTimeout(function(){
              jQuery('#billingaddress').focus();
            },1000);
            return false;
          }
          
          if(jQuery('#city').val()==''){
            alert('Fill all  required field');
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#new_user_checkout").offset().top
            }, 1000);
            setTimeout(function(){
              jQuery('#city').focus();
            },1000);
            return false;
          }

          if(jQuery('#state').val()==''){
            alert('Fill all required field');
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#new_user_checkout").offset().top
            }, 1000);
            setTimeout(function(){
              jQuery('#state').focus();
            },1000);
            return false;
          }

          if(!jQuery('#terms_conditions').is(":checked")){
            alert('Please select the checkbox');
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#new_user_checkout").offset().top
            }, 1000);
            setTimeout(function(){
              jQuery('#terms_conditions').focus();
            },1000);
            return false;
          }

              //ev.preventDefault();
              var name = jQuery('#name').val();
              stripe.confirmCardSetup(
                clientSecret,
                {
                  payment_method: {
                    card: card,
                    billing_details: {name: name}
                  }
                }
              ).then(function(result) {
                if (result.error) {
                  // Display error.message in your UI.
                  console.log(result);
                  //alert("unsuccessful");
                } else {
                  //console.log(result);
                  //alert("successful");
                  var zipcode = jQuery('#zipcode').val();

                  var billingaddress = jQuery('#billingaddress').val();
                  var promocode = jQuery('#promocode').val();
                  var promo_price = Number(jQuery('#promo_price').text());
                  var new_total_price = Number(jQuery('#new_total_price').text());
                  var user_status = jQuery('#user_status').val();
                  if(user_status==0){
                    var data = JSON.stringify(result);
                    //var user_status = jQuery('#user_status').val();
                    var datastring = "ajax_request=send_card_intent&user_status="+user_status+"&result="+data+"&promo_price="+promo_price+"&new_total_price="+new_total_price+"&billingaddress="+billingaddress+"&promocode="+promocode;
                    //var result = <?php //echo json_encode($data) ?>;
                    jQuery.ajax({
                      url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                      method : "POST",
                      data : datastring,
                      //contentType: "application/json; charset=utf-8",

                      success: function(result){

                          console.log(result);
                          var jsonObj = JSON.parse(result);
                          console.log(jsonObj);
                          if(jsonObj.subscription_status=="active" || jsonObj.payment_status=="succeeded"){

                            var period = jQuery('#period').val(); 

                            var period_data_field = jQuery('#period_data_field').val();
                            
                            var firstName = jQuery('#firstName').val();
                            //alert(firstName);
                            var lastName = jQuery('#lastName').val();

                            var account_holder_name = firstName+" "+lastName;

                            var payment_type = jQuery('#payment_type').val();

                            //var cardNumber = jQuery('#cardNumber').val();
                            //alert(cardNumber);

                            //var ccv = jQuery('#CCV').val();
                            //alert(ccv);
                            //var exp_month = jQuery('#month').val();
                            //alert(exp_month);
                            //var exp_year = jQuery('#Year').val();
                            //alert(exp_year);

                            var payment_method_id = jsonObj.payment_method_id;

                            var billingaddress = jQuery('#billingaddress').val();

                            var city = jQuery('#city').val();

                            var zipcode = jQuery('#zipcode').val();

                            var state = jQuery('#state').val();
                            var address_country ='US';
                            var currency ='USD';  
                            
                            datastring = "ajax_request=goto_order_confirmation_page&firstName="+firstName+"&lastName="+lastName+"&payment_type="+payment_type+"&billingaddress="+billingaddress+"&city="+city+"&state="+state+"&period_data_field="+period_data_field+"&payment_method_id="+payment_method_id+"&user_status="+user_status+"&promo_price="+promo_price+"&new_total_price="+new_total_price+"&zipcode="+zipcode+"&promocode="+promocode;
                            
                            //alert(datastring);
                            
                            jQuery.ajax({
                              url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                              method : "POST",
                              data : datastring,
                              success: function(result){
                                  console.log(result);
                                  var jsonobj = JSON.parse(result);
                                  var user_id = jsonobj.user_id;
                                  jQuery(location).attr('href', '/rebow/order-confirmation/?user_id='+user_id);
                              }
                            });
                          }else{
                            alert("Payment Failed");
                          }
                      }
                    });
                  }else{
                      var data = JSON.stringify(result);
                      //var user_status = jQuery('#user_status').val();
                      var billing_address = jQuery('#billing_address').val();
                      var period_data_field = jQuery('#period_data_field').val();
                      var city = jQuery('#city').val();
                      var state = jQuery('#state').val();

                      var payment_type = jQuery('#payment_type').val();

                      var zipcode = jQuery('#zipcode').val();
                      
                      var datastring = "ajax_request=send_card_intent2&user_status="+user_status+"&result="+data+"&state="+state+"&billing_address="+billing_address+"&city="+city+"&period_data_field="+period_data_field+"&promo_price="+promo_price+"&new_total_price="+new_total_price+"&zipcode="+zipcode;
                      
                      //var result = <?php //echo json_encode($data) ?>;
                      jQuery.ajax({
                        url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                        method : "POST",
                        data : datastring,
                        //contentType: "application/json; charset=utf-8",

                        success: function(result){
                            //alert(1);
                            console.log(result);

                            var jsonOBJ = JSON.parse(result);
                            if(jsonOBJ.subscription_status=="active" || jsonOBJ.payment_status=="succeeded"){
                              jQuery(location).attr('href', '/rebow/order-confirmation/');
                            }else{
                              alert("Payment Failed");
                            }
                            //jQuery(location).attr('href', '/rebow/order-confirmation/');
                        }
                      });
                  }
                  
                }
              });
            // });
        }

		</script>
	</body>
</html>