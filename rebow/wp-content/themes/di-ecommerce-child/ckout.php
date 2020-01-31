<?php /* Template Name: checkout1*/ ?>

<html lang="en">
	<body>
		<?php 
		require_once('session_values.php');
		require_once('stripe_config.php');
		get_header();
		?>
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<h1>Checkout</h1>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-7 mb-3 check-area">
					<form id="paymentFrm">
						<div class="form-group">
							<label>Your Name*</label>
							<br/>
							<input type="text" name="firstName" id="firstName" value="<?php echo $firstName;?>" required placeholder="First Name*"/>
						</div>
						<div class="form-group">
							<input type="text" name="lastName" id="lastName" required value="<?php echo $lastName;?>" placeholder="Last Name*"/>
						</div>
						<br/>
						<div class="form-group">
							<label>Payment Type*</label>
						
							<select id="payment_type">
								<option value="">Select</option>
								<option value="Mastercard">Mastercard</option>
								<option value="Visa">Visa</option>

								<option value="American_Express">American Express</option>
								
							</select>
						</div>
						<br/>
						<div class="form-group">
							<input type="number" name="cardNumber" id="cardNumber" required value="<?php echo $cardNumber;?>" placeholder="Card Number*" data-stripe="number"/>
						</div>
						<div class="form-group">
							<input type="text" name="CCV" id="CCV" data-stripe="cvc" required value="<?php echo $CCV;?>" placeholder="CCV*"/>
						</div>
						<br/>
						<div class="form-group">
							<label>Expiration Date*</label>
							<select id="month" data-stripe="exp_month">
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
						<div class="form-group">
							<select id="Year" data-stripe="exp_year">
								<option value="2019">2019</option>
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
						</div>
						<br/>
						<div class="form-group">
							<label>Billing Address*</label>
						
							<input type="text" name="billingaddress" id="billingaddress" required  placeholder="Address*"/>
						</div>
						<br/>
						<div class="form-group">
							<input type="text" name="city" id="city" required  placeholder="City*"/>
						</div>
						<div class="form-group">
							<select id="state" required>
								<option val="">State</option>
								<option val="Alabama">Alabama</option>
								<option val="Alaska">Alaska</option>
								<option val="California">California</option>
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="zipcode" id="zipcode" required data-stripe="address_zip" placeholder="Zip Code*"/>

						</div>
						<br/>
						<div class="form-group">
							<input type="text" name="promocode" id="promocode" required  placeholder="Promocode"/>
						</div>
						<div class="form-group">
							<input id="iagreecheck" type="checkbox"><span>I agree to ReBow’s Terms and Conditions and I agree to let ReBow charge my card for the amount shown below</span>
						</div>
						<br/>
						<div class="form-group">
							<input id="newscheck" type="checkbox">
							<span>I would like to recieve news and updates from rebow.</span></input>
						</div>
						<br/>
						<button type="submit" id="submit_order" class="btn btn-secondary">SUBMIT ORDER</button>
						<p>Your Card will be charged <?php echo $total_price;?></p>
					</form>
				</div>
				<div class="col-md-5 mb-3">
					<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Order Summary</h3>

					</div>
					<div class="col-sm-12 col-md-12 text-center check-area">
		    				<h5>Items</h5>
		    				<ul>
		    					<li><span id="product_name"> <?php echo $product_name;?></span> / <span id="box_count"><?php echo $box_count;?></span> Boxes</li>

		    					<li><span id="price_text"><?php echo $display_price; ?></li>
		    					
		    					<li id="addedboxesfield" class="hide"><span id="addedboxno"><?php echo $added_box_no;?> </span> Added Boxes  : <span id="addedboxprice">
		    						<?php echo $added_box_price;?></span>
		    					</li>

		    				</ul>
		    				<hr/>
		    				<label>Subtotal</label>: <span id="subtotal"><?php echo $subtotal_price;?></span>
		    				<br/>
		    				<div id="deliverycost"><label id="deliveryinfo">Delivery - Curb</label>: <span id="delivery_cost"><?php echo $delivery_cost;?></span></div>
		    				
		    				<div id="pickupcost"><label id="pickupinfo">Pickup - Stairs</label>: <span id="pickup_cost"><?php echo $pickup_cost;?></span></div>
								
		    				<label>Sales Tax</label>:  <span id="sales_tax"><?php echo $sales_tax;?></span>
							<br/>
		    				<label>Total</label>:  <span id="total_price"><?php echo $total_price;?></span>
		    			</div>

		    		<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Your Information</h3>
						<a style="color: white;" href="/rebow/personal-information/">EDIT</a>
					</div>
					<div class="col-sm-12 col-md-12 text-center check-area">
		    				
		    				<ul>
		    					<li>Name : <?php echo $firstName." ".$lastName;?></li>

		    					<li>Email : <?php echo $email;?></li>
		    					
		    					<li>Company Name: <?php echo $companyName;?></li>

		    					<li>Phone Number: <?php echo $phoneNumber;?></li>

		    					<li>Secondary Phone Number: <?php echo $SecondaryPhoneNumber;?></li>
		    				</ul>
		    		</div>		
		    		<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Order Details</h3>
						<a style="color: white;" href="/rebow/selectperiod/">EDIT</a>
					</div>
					<div class="col-sm-12 col-md-12 text-center check-area">
		    				
		    				<ul>
		    					<li><b><?php echo $period_datas." - ".$product_name." - ".$box_count." Boxes"?></b></li>

		    					<li><?php echo "<b>$period_datas PERIOD</b> : $display_period $dp_period";?></li>
		    					Includes:
		    					<ul>
			    					<li><?php echo $box_count?> Boxes</li>

			    					<li><?php echo $nestable_dollies_count;?> Nestable Dollies</li>

			    					<li><?php echo $labels_count;?> Labels</li>
			    				</ul>

			    				<ul>
			    					<li><?php echo $added_box_no." Boxes - Added";?></li>
			    					Includes:
			    					<li><?php echo ($added_box_no/4);?> Nestable Dollies</li>

			    					<li><?php echo $added_box_no;?> Labels</li>

			    					<li><?php echo $added_box_no;?> Zipties</li>
			    				</ul>

		    				</ul>
		    		</div>		

		    		<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Delivery & Pickup Details</h3>
						<a style="color: white;" href="/rebow/delivery_pickup/">EDIT</a>
					</div>

					<div class="col-sm-12 col-md-12 text-center check-area">
		    			
		    			<?php if($period_datas=="RENTAL"){?>
		    				<ul>
		    					<li><b>Delivery Address:</b></li>
		    					<li><?php echo $delivery_address;?></li> 

		    					<li><b>Delivery Date: </b><?php echo $delivery_date;?></li> 

		    					<li><b>Optional Delivery Times: </b><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></li> 

		    					<li>Pickup Address</li> 

		    					<li><?php echo $pickup_address;?></li> 

		    					<li><b>Pickup Date: </b><?php echo $pickup_date;?></li> 

		    					<li><b>Optional Pickup Times: </b><?php echo $preferred_pickup_time."PST OR ".$alternate_pickup_time." PST";?></li> 

		    				</ul>

	    					<p>*We will confirm these times with you within 24-48 hours after your order</p>
		    			
		    			<?php }else{?>
		    				<b>ITEMS GOING INTO STORAGE :</b>	
		    				<ul>
		    					<li><b>Delivery Address:</b></li>
		    					<li><?php echo $delivery_address;?></li> 

		    					<li><b>Delivery Date: </b><?php echo $delivery_date;?></li> 

		    					<li><b>Optional Delivery Times: </b><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></li> 

		    					<li>Pickup Address</li> 

		    					<li><?php echo $pickup_address_packed;?></li> 

		    					<li><b>Pickup Date: </b><?php echo $pickup_date_packed;?></li> 

		    					<li><b>Optional Pickup Times: </b><?php echo $preferred_pickup_time_packed." PST OR ".$alternate_pickup_time_packed." PST";?></li> 

		    				</ul>
		    				<hr/>
		    				<b>ITEMS MOVING OUT OF STORAGE:</b>	
		    				<ul>
		    					<li><b>Delivery Address:</b></li>
		    					<li><?php echo $delivery_address_packed;?></li> 

		    					<li><b>Delivery Date: </b><?php echo $delivery_date;?></li> 

		    					<li><b>Optional Delivery Times: </b><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></li> 

		    					<li>Pickup Address</li> 

		    					<li><?php echo $pickup_address;?></li> 

		    					<li><b>Pickup Date: </b><?php echo $pickup_date;?></li> 

		    					<li><b>Optional Pickup Times: </b><?php echo $preferred_pickup_time."PST OR ".$alternate_pickup_time." PST";?></li> 

		    				</ul>
	    					<p>*We will confirm these times with you within 24-48 hours after your order</p>

	    					<p class="payment-status"></p>
	    				<?php }?>
		    		</div>		
				</div>
			</div>
		</div>
		<?php get_footer(); ?>

		<!-- Stripe JavaScript library -->
		<script src="https://js.stripe.com/v2/"></script>

		<!-- jQuery is used only for this example; it isn't required to use Stripe -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		<script>
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
			Stripe.setPublishableKey('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

			function create_token(currency,card_number,account_holder_name,address_city,address_state,address_zip,address_country,exp_month,exp_year,cvc){

				Stripe.createToken({
				  currency: currency,
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc,
				  name: account_holder_name,
				  address_city: address_city,
				  address_state: address_state,
				  address_zip: address_zip,
				  address_country: address_country,

				},stripeResponseHandler);

				/*Stripe.createToken({
				  
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc
				},stripeResponseHandler);*/

			}


			function retrieve_customer(){

				Stripe.createToken({
				  currency: currency,
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc,
				  name: account_holder_name,
				  address_city: address_city,
				  address_state: address_state,
				  address_zip: address_zip,
				  address_country: address_country,

				},stripeResponseHandler);
				
				/*Stripe.createToken({
				  
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc
				},stripeResponseHandler);*/

			}
			function stripeResponseHandler(status, response) {
				//alert(response);
			    if (response.error) {
			        // Enable the submit button
			        $('#submit_order').removeAttr("disabled");
			        // Display the errors on the form
			        //$(".payment-status").html('<p>'+response.error.message+'</p>');
			        alert(response.error.message);
			    } else {
			        var form$ = $("#paymentFrm");
			        // Get token id
			        var token = response.id;
			        // Insert the token into the form
			        //alert(token);
			        form$.append("<input type='hidden' id='stripeToken' name='stripeToken' value='" + token + "' />");
			        var datastring="ajax_request=pass_tokens&token="+token;
			        //alert(datastring)
			        $.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/stripe_payment.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    
						    alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});
			    }

			   // return response;
			}
			jQuery(document).ready(function() {
				var added_box_count_field = jQuery('#added_box_count_field').val();
				//alert(added_box_count_field);
				if(added_box_count_field>0){
					jQuery('#addedboxesfield').show();
				}
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
				jQuery("#paymentFrm").submit(function(event){
		        	// Disable the submit button to prevent repeated clicks

		        	event.preventDefault();
		        	jQuery('#submit_order').attr("disabled", "disabled");

		        	var datastring = "";
					var period = jQuery('#period').val(); 

					var period_data_field = jQuery('#period_data_field').val();
					
					var firstName = jQuery('#firstName').val();
					//alert(firstName);
					var lastName = jQuery('#lastName').val();

					var account_holder_name = firstName+" "+lastName;

					var payment_type = jQuery('#payment_type').val();

					var cardNumber = jQuery('#cardNumber').val();
					//alert(cardNumber);

					var ccv = jQuery('#CCV').val();
					//alert(ccv);
					var exp_month = jQuery('#month').val();
					//alert(exp_month);
					var exp_year = jQuery('#Year').val();
					//alert(exp_year);
					var billingaddress = jQuery('#billingaddress').val();

					var city = jQuery('#city').val();

					var zipcode = jQuery('#zipcode').val();

					var state = jQuery('#state').val();
					var address_country ='US';
					var currency ='USD';
					//var promocode = jQuery('#promocode').val();
					var result = create_token(currency,cardNumber,account_holder_name,city,state,zipcode,address_country,exp_month,exp_year,ccv);

					//var stripeToken = jQuery('#stripeToken').val();

					//alert(stripeToken);
					//console.log(result);

					//console.log(result.id);
		        });
			});


		</script>
	</body>
</html><?php /* Template Name: checkout*/ ?>

<html lang="en">
	<body>
		<?php 
		require_once('session_values.php');
		require_once('stripe_config.php');
		get_header();
		?>
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<h1>Checkout</h1>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-7 mb-3 check-area">
					<form id="paymentFrm">
						<div class="form-group">
							<label>Your Name*</label>
							<br/>
							<input type="text" name="firstName" id="firstName" value="<?php echo $firstName;?>" required placeholder="First Name*"/>
						</div>
						<div class="form-group">
							<input type="text" name="lastName" id="lastName" required value="<?php echo $lastName;?>" placeholder="Last Name*"/>
						</div>
						<br/>
						<div class="form-group">
							<label>Payment Type*</label>
						
							<select id="payment_type">
								<option value="">Select</option>
								<option value="Mastercard">Mastercard</option>
								<option value="Visa">Visa</option>

								<option value="American_Express">American Express</option>
								
							</select>
						</div>
						<br/>
						<div class="form-group">
							<input type="number" name="cardNumber" id="cardNumber" required value="<?php echo $cardNumber;?>" placeholder="Card Number*" data-stripe="number"/>
						</div>
						<div class="form-group">
							<input type="text" name="CCV" id="CCV" data-stripe="cvc" required value="<?php echo $CCV;?>" placeholder="CCV*"/>
						</div>
						<br/>
						<div class="form-group">
							<label>Expiration Date*</label>
							<select id="month" data-stripe="exp_month">
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
						<div class="form-group">
							<select id="Year" data-stripe="exp_year">
								<option value="2019">2019</option>
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
						</div>
						<br/>
						<div class="form-group">
							<label>Billing Address*</label>
						
							<input type="text" name="billingaddress" id="billingaddress" required  placeholder="Address*"/>
						</div>
						<br/>
						<div class="form-group">
							<input type="text" name="city" id="city" required  placeholder="City*"/>
						</div>
						<div class="form-group">
							<select id="state" required>
								<option val="">State</option>
								<option val="Alabama">Alabama</option>
								<option val="Alaska">Alaska</option>
								<option val="California">California</option>
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="zipcode" id="zipcode" required data-stripe="address_zip" placeholder="Zip Code*"/>

						</div>
						<br/>
						<div class="form-group">
							<input type="text" name="promocode" id="promocode" required  placeholder="Promocode"/>
						</div>
						<div class="form-group">
							<input id="iagreecheck" type="checkbox"><span>I agree to ReBow’s Terms and Conditions and I agree to let ReBow charge my card for the amount shown below</span>
						</div>
						<br/>
						<div class="form-group">
							<input id="newscheck" type="checkbox">
							<span>I would like to recieve news and updates from rebow.</span></input>
						</div>
						<br/>
						<button type="submit" id="submit_order" class="btn btn-secondary">SUBMIT ORDER</button>
						<p>Your Card will be charged <?php echo $total_price;?></p>
					</form>
				</div>
				<div class="col-md-5 mb-3">
					<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Order Summary</h3>

					</div>
					<div class="col-sm-12 col-md-12 text-center check-area">
		    				<h5>Items</h5>
		    				<ul>
		    					<li><span id="product_name"> <?php echo $product_name;?></span> / <span id="box_count"><?php echo $box_count;?></span> Boxes</li>

		    					<li><span id="price_text"><?php echo $display_price; ?></li>
		    					
		    					<li id="addedboxesfield" class="hide"><span id="addedboxno"><?php echo $added_box_no;?> </span> Added Boxes  : <span id="addedboxprice">
		    						<?php echo $added_box_price;?></span>
		    					</li>

		    				</ul>
		    				<hr/>
		    				<label>Subtotal</label>: <span id="subtotal"><?php echo $subtotal_price;?></span>
		    				<br/>
		    				<div id="deliverycost"><label id="deliveryinfo">Delivery - Curb</label>: <span id="delivery_cost"><?php echo $delivery_cost;?></span></div>
		    				
		    				<div id="pickupcost"><label id="pickupinfo">Pickup - Stairs</label>: <span id="pickup_cost"><?php echo $pickup_cost;?></span></div>
								
		    				<label>Sales Tax</label>:  <span id="sales_tax"><?php echo $sales_tax;?></span>
							<br/>
		    				<label>Total</label>:  <span id="total_price"><?php echo $total_price;?></span>
		    			</div>

		    		<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Your Information</h3>
						<a style="color: white;" href="/rebow/personal-information/">EDIT</a>
					</div>
					<div class="col-sm-12 col-md-12 text-center check-area">
		    				
		    				<ul>
		    					<li>Name : <?php echo $firstName." ".$lastName;?></li>

		    					<li>Email : <?php echo $email;?></li>
		    					
		    					<li>Company Name: <?php echo $companyName;?></li>

		    					<li>Phone Number: <?php echo $phoneNumber;?></li>

		    					<li>Secondary Phone Number: <?php echo $SecondaryPhoneNumber;?></li>
		    				</ul>
		    		</div>		
		    		<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Order Details</h3>
						<a style="color: white;" href="/rebow/selectperiod/">EDIT</a>
					</div>
					<div class="col-sm-12 col-md-12 text-center check-area">
		    				
		    				<ul>
		    					<li><b><?php echo $period_datas." - ".$product_name." - ".$box_count." Boxes"?></b></li>

		    					<li><?php echo "<b>$period_datas PERIOD</b> : $display_period $dp_period";?></li>
		    					Includes:
		    					<ul>
			    					<li><?php echo $box_count?> Boxes</li>

			    					<li><?php echo $nestable_dollies_count;?> Nestable Dollies</li>

			    					<li><?php echo $labels_count;?> Labels</li>
			    				</ul>

			    				<ul>
			    					<li><?php echo $added_box_no." Boxes - Added";?></li>
			    					Includes:
			    					<li><?php echo ($added_box_no/4);?> Nestable Dollies</li>

			    					<li><?php echo $added_box_no;?> Labels</li>

			    					<li><?php echo $added_box_no;?> Zipties</li>
			    				</ul>

		    				</ul>
		    		</div>		

		    		<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;">
						<h3>Delivery & Pickup Details</h3>
						<a style="color: white;" href="/rebow/delivery_pickup/">EDIT</a>
					</div>

					<div class="col-sm-12 col-md-12 text-center check-area">
		    			
		    			<?php if($period_datas=="RENTAL"){?>
		    				<ul>
		    					<li><b>Delivery Address:</b></li>
		    					<li><?php echo $delivery_address;?></li> 

		    					<li><b>Delivery Date: </b><?php echo $delivery_date;?></li> 

		    					<li><b>Optional Delivery Times: </b><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></li> 

		    					<li>Pickup Address</li> 

		    					<li><?php echo $pickup_address;?></li> 

		    					<li><b>Pickup Date: </b><?php echo $pickup_date;?></li> 

		    					<li><b>Optional Pickup Times: </b><?php echo $preferred_pickup_time."PST OR ".$alternate_pickup_time." PST";?></li> 

		    				</ul>

	    					<p>*We will confirm these times with you within 24-48 hours after your order</p>
		    			
		    			<?php }else{?>
		    				<b>ITEMS GOING INTO STORAGE :</b>	
		    				<ul>
		    					<li><b>Delivery Address:</b></li>
		    					<li><?php echo $delivery_address;?></li> 

		    					<li><b>Delivery Date: </b><?php echo $delivery_date;?></li> 

		    					<li><b>Optional Delivery Times: </b><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></li> 

		    					<li>Pickup Address</li> 

		    					<li><?php echo $pickup_address_packed;?></li> 

		    					<li><b>Pickup Date: </b><?php echo $pickup_date_packed;?></li> 

		    					<li><b>Optional Pickup Times: </b><?php echo $preferred_pickup_time_packed." PST OR ".$alternate_pickup_time_packed." PST";?></li> 

		    				</ul>
		    				<hr/>
		    				<b>ITEMS MOVING OUT OF STORAGE:</b>	
		    				<ul>
		    					<li><b>Delivery Address:</b></li>
		    					<li><?php echo $delivery_address_packed;?></li> 

		    					<li><b>Delivery Date: </b><?php echo $delivery_date;?></li> 

		    					<li><b>Optional Delivery Times: </b><?php echo $preferred_delivery_time."PST OR ".$alternate_delivery_time." PST";?></li> 

		    					<li>Pickup Address</li> 

		    					<li><?php echo $pickup_address;?></li> 

		    					<li><b>Pickup Date: </b><?php echo $pickup_date;?></li> 

		    					<li><b>Optional Pickup Times: </b><?php echo $preferred_pickup_time."PST OR ".$alternate_pickup_time." PST";?></li> 

		    				</ul>
	    					<p>*We will confirm these times with you within 24-48 hours after your order</p>

	    					<p class="payment-status"></p>
	    				<?php }?>
		    		</div>		
				</div>
			</div>
		</div>
		<?php get_footer(); ?>

		<!-- Stripe JavaScript library -->
		<script src="https://js.stripe.com/v2/"></script>

		<!-- jQuery is used only for this example; it isn't required to use Stripe -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		<script>
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
			Stripe.setPublishableKey('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

			function create_token(currency,card_number,account_holder_name,address_city,address_state,address_zip,address_country,exp_month,exp_year,cvc){

				Stripe.createToken({
				  currency: currency,
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc,
				  name: account_holder_name,
				  address_city: address_city,
				  address_state: address_state,
				  address_zip: address_zip,
				  address_country: address_country,

				},stripeResponseHandler);

				/*Stripe.createToken({
				  
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc
				},stripeResponseHandler);*/

			}


			function retrieve_customer(){

				Stripe.createToken({
				  currency: currency,
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc,
				  name: account_holder_name,
				  address_city: address_city,
				  address_state: address_state,
				  address_zip: address_zip,
				  address_country: address_country,

				},stripeResponseHandler);
				
				/*Stripe.createToken({
				  
				  number: card_number,
				  exp_month: exp_month,
				  exp_year: exp_year,
				  cvc: cvc
				},stripeResponseHandler);*/

			}
			function stripeResponseHandler(status, response) {
				//alert(response);
			    if (response.error) {
			        // Enable the submit button
			        $('#submit_order').removeAttr("disabled");
			        // Display the errors on the form
			        //$(".payment-status").html('<p>'+response.error.message+'</p>');
			        alert(response.error.message);
			    } else {
			        var form$ = $("#paymentFrm");
			        // Get token id
			        var token = response.id;
			        // Insert the token into the form
			        //alert(token);
			        form$.append("<input type='hidden' id='stripeToken' name='stripeToken' value='" + token + "' />");
			        var datastring="ajax_request=pass_tokens&token="+token;
			        //alert(datastring)
			        $.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/stripe_payment.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    
						    alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});
			    }

			   // return response;
			}
			jQuery(document).ready(function() {
				var added_box_count_field = jQuery('#added_box_count_field').val();
				//alert(added_box_count_field);
				if(added_box_count_field>0){
					jQuery('#addedboxesfield').show();
				}
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
				jQuery("#paymentFrm").submit(function(event){
		        	// Disable the submit button to prevent repeated clicks

		        	event.preventDefault();
		        	jQuery('#submit_order').attr("disabled", "disabled");

		        	var datastring = "";
					var period = jQuery('#period').val(); 

					var period_data_field = jQuery('#period_data_field').val();
					
					var firstName = jQuery('#firstName').val();
					//alert(firstName);
					var lastName = jQuery('#lastName').val();

					var account_holder_name = firstName+" "+lastName;

					var payment_type = jQuery('#payment_type').val();

					var cardNumber = jQuery('#cardNumber').val();
					//alert(cardNumber);

					var ccv = jQuery('#CCV').val();
					//alert(ccv);
					var exp_month = jQuery('#month').val();
					//alert(exp_month);
					var exp_year = jQuery('#Year').val();
					//alert(exp_year);
					var billingaddress = jQuery('#billingaddress').val();

					var city = jQuery('#city').val();

					var zipcode = jQuery('#zipcode').val();

					var state = jQuery('#state').val();
					var address_country ='US';
					var currency ='USD';
					//var promocode = jQuery('#promocode').val();
					var result = create_token(currency,cardNumber,account_holder_name,city,state,zipcode,address_country,exp_month,exp_year,ccv);

					//var stripeToken = jQuery('#stripeToken').val();

					//alert(stripeToken);
					//console.log(result);

					//console.log(result.id);
		        });
			});


		</script>
	</body>
</html>