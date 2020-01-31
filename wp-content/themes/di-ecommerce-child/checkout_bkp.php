<?php /* Template Name: checkout*/ ?>

<html lang="en">
	<body>
		<?php 
		require_once('session_values.php');
		get_header();
		?>
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<h1>Checkout</h1>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-7 mb-3 check-area">
					<label>Your Name*</label>
					<br/>
					<input type="text" name="firstName" id="firstName" value="<?php echo $firstName;?>" required placeholder="First Name*"/> 
					<input type="text" name="lastName" id="lastName" required value="<?php echo $lastName;?>" placeholder="Last Name*"/>
					<br/>
					<label>Payment Type*</label>
					<br/>
					<select id="payment_type">
						<option value="">Select</option>
						<option value="Mastercard">Mastercard</option>
						<option value="Visa">Visa</option>

						<option value="American_Express">American Express</option>
						
					</select>
					<br/>
					<input type="text" name="cardNumber" id="cardNumber" required value="<?php echo $cardNumber;?>" placeholder="Card Number*"/>
					<input type="text" name="CCV" id="CCV" required value="<?php echo $CCV;?>" placeholder="CCV*"/>
					<br/>
					<label>Expiration Date*</label>
					<select id="month">
						<option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
						
					</select>
					<select id="Year">
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
					<br/>
					<label>Billing Address*</label>
					<br/>
					<input type="text" name="billingaddress" id="billingaddress" required  placeholder="Address*"/>
					<br/>
					<input type="text" name="city" id="city" required  placeholder="
					City*"/>
					<select id="state" required>
						<option val="">State</option>
						<option val="Alabama">Alabama</option>
						<option val="Alaska">Alaska</option>
						<option val="California">California</option>
					</select>
					<input type="text" name="zipcode" id="zipcode" required  placeholder="
					Zip Code*"/>

					<br/>
					<input type="text" name="promocode" id="promocode" required  placeholder="Promocode"/>
					<input id="iagreecheck" type="checkbox"><span>I agree to ReBow’s Terms and Conditions and I agree to let ReBow charge my card for the amount shown below</span>
					<br/>
					<input id="newscheck" type="checkbox"><span>I would like to recieve news and updates from rebow.</span>
					<br/>
					<button type="submit" id="submit_order" class="btn btn-secondary">SUBMIT ORDER</button>
					<p>Your Card will be charged <?php echo $total_price;?></p>
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
	    				<?php }?>
		    		</div>		
				</div>
			</div>
		</div>
		<?php get_footer(); ?>
		<script>
			jQuery(document).ready(function() {
				jQuery('#submit_order').click(function() {
					var datastring = "";
					var period = jQuery('#period').val(); 

					var period_data_field = jQuery('#period_data_field').val();
					
					var firstName = jQuery('#firstName').val();
					alert(firstName);
					var lastName = jQuery('#lastName').val();

					var payment_type = jQuery('#payment_type').val();

					var cardNumber = jQuery('#cardNumber').val();

					var CCV = jQuery('#CCV').val();

					var month = jQuery('#month').val();

					var Year = jQuery('#Year').val();

					var billingaddress = jQuery('#billingaddress').val();

					var city = jQuery('#city').val();

					var zipcode = jQuery('#zipcode').val();

					var state = jQuery('#state').val();

					//var promocode = jQuery('#promocode').val();

					datastring = "ajax_request=goto_order_confirmation_page&firstName="+firstName+"&lastName="+lastName+"&payment_type="+payment_type+"&cardNumber="+cardNumber+"&CCV="+CCV+"&month="+month+"&Year="+Year+"&billingaddress="+billingaddress+"&city="+city+"&zipcode="+zipcode+"&state="+state+"&period_data_field="+period_data_field;
					
					//alert(datastring);
					
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);

						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});

				});
			});
		</script>
	</body>
</html>