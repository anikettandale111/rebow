<?php /* Template Name: edit_delivery_pickup*/ ?>
<?php require_once("user_check_login.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php
		require_once('session_values.php');
		get_header(); 
		?>
		
		<?php	
			if($period_datas=="RENTAL"){
				$shipping_type = 'Delivery Empty Boxes';
				$deliver_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);
				
				$shipping_type = 'Pickup Empty Boxes';
				$pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

				/*Delivery Date*/
				$delivery_date =(isset($session_data->delivery_date)) ? $session_data->delivery_date : $deliver_empty_boxes_data['date'];

				$delivery_time =(isset($session_data->preferred_delivery_time)) ? $session_data->preferred_delivery_time : $deliver_empty_boxes_data['preferred_time'];

				$delivery_address =(isset($session_data->delivery_address)) ? $session_data->delivery_address : $deliver_empty_boxes_data['address'];

				$apt_unit_delivery =(isset($session_data->apt_unit_delivery)) ? $session_data->apt_unit_delivery : $deliver_empty_boxes_data['apartment_unit_info'];

				$apartment_level_delivery =(isset($session_data->apartment_level_delivery)) ? $session_data->apartment_level_delivery : $deliver_empty_boxes_data['floor_level'];

				/*Pickup Date*/

				$pickup_date =(isset($session_data->end_date)) ? $session_data->end_date : $pickup_empty_boxes_data['date'];

				$pickup_time =(isset($session_data->pickup_time)) ? $session_data->pickup_time : $deliver_empty_boxes_data['preferred_time'];

				$pickup_address =(isset($session_data->pickup_address)) ? $session_data->pickup_address : $deliver_empty_boxes_data['address'];

				$apt_unit_pickup =(isset($session_data->apt_unit_pickup)) ? $session_data->apt_unit_pickup : $deliver_empty_boxes_data['apartment_unit_info'];

				$apartment_level_pickup =(isset($session_data->apartment_level_pickup)) ? $session_data->apartment_level_pickup : $deliver_empty_boxes_data['floor_level'];

			}else{
				//get_storage_data($current_order_id);
				$shipping_type = 'Delivery Empty Boxes';
				$deliver_empty_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

				$shipping_type = 'Pickup Packed Boxes';
				$pickup_packed_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

				$shipping_type = 'Delivery Packed Boxes';
				$delivery_packed_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

				$shipping_type = 'Pickup Empty Boxes';
				$pickup_empty_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

				/*Delivery Date*/
				$delivery_date =(isset($session_data->delivery_date)) ? $session_data->delivery_date : $deliver_empty_boxes_data['date'];

				$preferred_delivery_time =(isset($session_data->preferred_delivery_time)) ? $session_data->preferred_delivery_time : $deliver_empty_boxes_data['preferred_time'];

				$alternate_delivery_time =(isset($session_data->alternate_delivery_time)) ? $session_data->alternate_delivery_time : $deliver_empty_boxes_data['alternative_time'];

				$delivery_address =(isset($session_data->delivery_address)) ? $session_data->delivery_address : $deliver_empty_boxes_data['address'];

				$apt_unit_delivery =(isset($session_data->apt_unit_delivery)) ? $session_data->preferred_delivery_time : $deliver_empty_boxes_data['apartment_unit_info'];

				$apartment_level_delivery =(isset($session_data->apartment_level_delivery)) ? $session_data->apartment_level_delivery : $deliver_empty_boxes_data['floor_level'];

				/*Pickup Packed Boxes Data*/

				$pickup_date_packed =(isset($session_data->pickup_date_packed)) ? $session_data->pickup_date_packed : $pickup_packed_boxes_data['date'];
				
				$preferred_pickup_time_packed =(isset($session_data->preferred_pickup_time_packed)) ? $session_data->preferred_pickup_time_packed : $pickup_packed_boxes_data['preferred_time'];

				$alternate_pickup_time_packed =(isset($session_data->alternate_pickup_time_packed)) ? $session_data->alternate_pickup_time_packed : $pickup_packed_boxes_data['alternative_time'];

				$pickup_address_packed =(isset($session_data->pickup_address_packed)) ? $session_data->pickup_address_packed : $pickup_packed_boxes_data['address'];

				$apt_unit_pickup_packed =(isset($session_data->apt_unit_pickup_packed)) ? $session_data->apt_unit_pickup_packed : $pickup_packed_boxes_data['apartment_unit_info'];

				$apartment_level_packed =(isset($session_data->apartment_level_packed)) ? $session_data->apartment_level_packed : $pickup_packed_boxes_data['floor_level'];


				/*Delivery of Packed Boxes */
				$delivery_date_packed =(isset($session_data->delivery_date_packed)) ? $session_data->delivery_date_packed : $deliver_empty_boxes_data['date'];

				$preferred_delivery_time_packed =(isset($session_data->preferred_delivery_time_packed)) ? $session_data->preferred_delivery_time_packed : $deliver_empty_boxes_data['preferred_time'];

				$alternate_delivery_time_packed =(isset($session_data->alternate_delivery_time_packed)) ? $session_data->alternate_delivery_time_packed : $deliver_empty_boxes_data['alternative_time'];

				$delivery_address_packed =(isset($session_data->delivery_address_packed)) ? $session_data->delivery_address_packed : $deliver_empty_boxes_data['address'];

				$apt_unit_delivery_packed =(isset($session_data->apt_unit_delivery_packed)) ? $session_data->apt_unit_delivery_packed : $deliver_empty_boxes_data['apartment_unit_info'];

				$apartment_level_delivery =(isset($session_data->apartment_level_delivery)) ? $session_data->apartment_level_delivery : $deliver_empty_boxes_data['floor_level'];

				/*Pickup Empty Boxes Data*/

				$pickup_date =(isset($session_data->end_date)) ? $session_data->end_date : $pickup_empty_boxes_data['date'];
				
				$preferred_pickup_time =(isset($session_data->preferred_pickup_time)) ? $session_data->preferred_pickup_time : $pickup_empty_boxes_data['preferred_time'];

				$alternate_pickup_time =(isset($session_data->alternate_pickup_time)) ? $session_data->alternate_pickup_time : $pickup_empty_boxes_data['alternative_time'];

				$pickup_address =(isset($session_data->pickup_address)) ? $session_data->pickup_address : $pickup_empty_boxes_data['address'];

				$apt_unit_pickup =(isset($session_data->apt_unit_pickup)) ? $session_data->preferred_delivery_time : $pickup_empty_boxes_data['apartment_unit_info'];

				$apartment_level_pickup =(isset($session_data->apartment_level_pickup)) ? $session_data->apartment_level_pickup : $pickup_empty_boxes_data['floor_level'];
			}
		?>
		<!-- FAQ heading -->
		<section class="faq-header">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col text-center">
						<h1>Welcome <?php echo (wp_get_current_user()->display_name);
						$user_id = wp_get_current_user()->id;?></h1>
					</div>
				</div>
			</div>	
		</section>	

		<!-- Start accoordion -->
		<section>
		  <div class="container">
		    <div class="row">
		      <ul class="account">
		        <li class="selected"><a href="/rebow/my-orders/">My Orders</a></li>
		        <li><a href="/rebow/my-information/">My Information</a></li>
		        <li><a href="/rebow/payment-information/">Payment info</a></li>
		        <li><a href="/rebow/support/">Support</a></li>
		      </ul>
		      <div class="rhs-account mb-5 view-order">
		        <div class="row justify-content-left">
		          <div class="col-sm-12 mb-2">
		            <!-- Start order bredcrumb-->
		            <div class="row">
		              <div class="col-sm-12 col-md-9">
		                <ul class="order-breadcrumb">
		                  <li><a href="">MY ORDERS</a></li>
		                  <li><a href="">ORDER # <?php echo $current_order_id;?></a></li>
		                </ul>
		              </div>
		              <div class="col-sm-12 col-md-3">
		                <button type="submit" id="submit_changes1" class="btn btn-small blue-bg float-right txt-white">NEXT</button>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="row">
		          <div class="col-sm-12">
		            <div id="back_btn" class="blue-bg pl-3 py-2">
		              <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/back-arrow.png" alt="">
		              <small class="pl-2 white-color">BACK</small>
		            </div>
		          </div>
		        </div>
		        <div class="row col-order" id="deliver_boxes">
		          	<div class="col-sm-12">
			            <div class="grey-bg p-5">
			              <div class="row">
			                <div class="col-sm-12 mb-4 form-header p-0">
			                  <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/warehouse-godown.png" alt="">
			                  <p class="txt-blue mt-3">Delivery of your ReBow™ Boxes :</p>
			                </div>
			              </div>
			              <div class="row justify-content-start">
			                <form id="edit_details_pickup_delivery" action="" class="checkout-form">
			                  <div class="row-form">
			                    <div class="col-from-field">
			                      <p>Delivery Date* :</p>
			                    </div>
			                    <div class="col-from-field">
			                      <label id="delivery_date" for=""><?php echo $delivery_date;?></label>
			                    </div>
			                  </div>
			                  <div class="row-form">
			                    <div class="col-from-field custom-label">
			                      <p>Delivery Time* :</p>
			                    </div>
			                    <div class="col-from-field">
			                      <!--<div class="selectholder">
			                        <label>Choose Time</label>-->
									<select id="preferred_delivery_time" required>
										<option value="">Select</option>
										<?php 
										foreach($time_slots_array as $key=>$value){
											if($key==$delivery_time){
												echo "<option selected value=$key>$value</option>";
											}else{
												echo "<option value=$key>$value</option>";
											}
										}
										?>
									</select>
			                      <!--</div>-->
			                    </div>
			                  </div>
			                  
			                  
			                  <div class="row-form">
			                    <div class="col-from-field custom-label">
			                      <p>Delivery Address*:</p>
			                    </div>
			                    <div class="col-from-field">
			                      <div class="location-pin">
			                          <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
			                      </div>
			                        <input id="delivery_address" class="addrs" type="text" value="<?php echo $delivery_address;?>" placeholder="Enter Delivery Address">
			                        <input id="apt_unit_delivery" class="small-input ml-3" type="text" value="<?php echo $apt_unit_delivery;?>" placeholder="Apt # / Unit">
			                        <input type="hidden" id="delivery_address_loc_lat" value="<?php echo $delivery_address_loc_lat;?>"/>
			    					<input type="hidden" id="delivery_address_loc_long" value="<?php echo $delivery_address_loc_long;?>"/>
			                    </div>
			                  </div>
			                  <div class="col-from-field">
			                    <p>Do you live in a walk-up or elevator building?* <a class="wt-this" href="#javascript;" data-toggle="modal" data-target=".bd-example-modal-lg" >Whats This?</a></p>
			                  </div>
			                  <div class="clearfix"></div>
			                  <div class="col-from-field">
			                    <!--<div class="selectholder">
			                      <label>Choose Time</label>-->
			                      	<select id="apartment_level_delivery" class="apartment_level" required>
										<option value="">Select</option>
										<?php 
										foreach($elevator_bulding_array as $key=>$value){
											if($key==$apartment_level_delivery){
												echo "<option selected value=$key>$value</option>";
											}else{
												echo "<option value=$key>$value</option>";
											}
										}	
										?>
									</select>
			                    <!--</div>-->
			                  </div>
			                  <div class="clearfix"></div>
			                </form>
			              </div>
			            </div>
		          	</div>
		        </div>
		        <!-- 2nd form -->
		        <div class="row mt-3" id="pick_up_packed_boxes">
		          	<div class="col-sm-12">
			            <div class="grey-bg p-5">
			              	<div class="row">
				                <div class="col-sm-12 mb-4 form-header p-0">
				                  	<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
				                  <p class="txt-blue">Pick Up of your ReBow™ Boxes :</p>
				                </div>
			              	</div>
			              	<div class="row justify-content-start">
			                  	<div class="row-form">
				                    <div class="col-from-field">
				                      <p>Pick Up Date* :</p>
				                    </div>
			                    	<div class="col-from-field">
			                      		<label id="pickup_date_packed" for=""><?php echo $pickup_date_packed;?></label>
			                    	</div>
			                  	</div>
			                  	<div class="row-form">
				                    <div class="col-from-field custom-label">
				                      <p>Pick Up Time* :</p>
				                    </div>
				                    <div class="col-from-field">
				                      <!--<div class="selectholder">
				                        <label>Choose Time</label>-->
				                        <select id="preferred_pickup_time_packed" required>
											<option value="">Select</option>
											<?php 
											foreach($time_slots_array as $key=>$value){
												if($key==$preferred_pickup_time_packed){
													echo "<option selected value=$key>$value</option>";
												}else{
													echo "<option value=$key>$value</option>";
												}
											}
											?>
										</select>
				                      <!--</div>-->
				                    </div>
				                </div>
			                    
			                  	<div class="row-form">
				                    <div class="col-from-field custom-label">
				                      <p>Pick Up Address*:</p>
				                    </div>
				                    <div class="col-from-field">
				                      <div class="location-pin">
				                          <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
				                      </div>
				                        <input id="pickup_address_packed" class="addrs" type="text" value="<?php echo $pickup_address_packed;?>" placeholder="Enter Delivery Address">
				                        <input id="apt_unit_pickup_packed" class="small-input ml-3" type="text" value="<?php echo $apt_unit_pickup_packed;?>" placeholder="Apt # / Unit">
				                        <input type="hidden" id="pickup_address_packed_loc_lat" value="<?php echo $pickup_address_packed_loc_lat;?>" />
			    						<input type="hidden" id="pickup_address_packed_loc_long" value="<?php echo $pickup_address_packed_loc_long;?>" />
				                    </div>
			                  	</div>
			                  <div class="col-from-field">
			                    <p>Do you live in a walk-up or elevator building?* <a class="wt-this" href="#javascript;" data-toggle="modal" data-target=".bd-example-modal-lg">Whats This?</a></p>
			                  </div>
			                  <div class="clearfix"></div>
			                  <div class="col-from-field">
			                    <!--<div class="selectholder">
			                      <label>Choose Time</label>-->
			                      	<select id="apartment_level_packed" class="apartment_level" required>
										<option value="Select">Select</option>
										<?php 
										foreach($elevator_bulding_array as $key=>$value){
											if($key==$apartment_level_packed){
												echo "<option selected value=$key>$value</option>";
											}else{
												echo "<option value=$key>$value</option>";
											}
										}
										?>
									</select>
			                    <!--</div>-->
			                  </div>
			                  <div class="clearfix"></div>
			                
			              </div>
			            </div>
		          	</div>
		        </div>
		        <!-- 3rd form -->
		        <div class="row mt-3" id="delivery_packed_boxes">
		          	<div class="col-sm-12">
			            <div class="grey-bg p-5">
			              <div class="row">
			                <div class="col-sm-12 mb-4 form-header p-0">
			                  <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
			                  <p class="txt-blue">Delivery of Stored Items :</p>
			                </div>
			              </div>
			              <div class="row justify-content-start">
			                <form action="" class="checkout-form">
			                  <div class="row-form">
			                    <div class="col-from-field">
			                      <p>Delivery Date* :</p>
			                    </div>
			                    <div class="col-from-field">
			                      <label id="delivery_date_packed" for=""><?php echo $delivery_date_packed;?></label>
			                    </div>
			                  </div>
			                  <div class="row-form">
			                    <div class="col-from-field custom-label">
			                      <p>Delivery Time* :</p>
			                    </div>
			                    <div class="col-from-field">
			                      <!--<div class="selectholder">
			                        <label>Choose Time</label>-->
			                        <select id="preferred_delivery_time_packed" required>
										<option value="">Select</option>
										<?php 
										foreach($time_slots_array as $key=>$value){
											if($key==$preferred_pickup_time_packed){
												echo "<option selected value=$key>$value</option>";
											}else{
												echo "<option value=$key>$value</option>";
											}
										}
										?>
									</select>
			                      <!--</div>-->
			                    </div>
			                  </div>
			                  
			                  <div class="row-form">
			                    <div class="col-from-field custom-label">
			                      <p>Delivery Address*:</p>
			                    </div>
			                    <div class="col-from-field">
			                      <div class="location-pin">
			                          <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
			                      </div>
			                        <input id="delivery_address_packed" class="addrs" type="text" placeholder="Enter Delivery Address" value="<?php echo $delivery_address_packed;?>">
			                        <input id="apt_unit_delivery_packed" class="small-input ml-3" type="text" value="<?php echo $apt_unit_delivery_packed;?>" placeholder="Apt # / Unit">
			                        <input type="hidden" id="delivery_address_packed_loc_lat" value="<?php echo $delivery_address_packed_loc_lat;?>"/>
			    					<input type="hidden" id="delivery_address_packed_loc_long" value="<?php echo $delivery_address_packed_loc_long;?>"/>
			                    </div>
			                  </div>
			                  <div class="col-from-field">
			                    <p>Do you live in a walk-up or elevator building?* <a class="wt-this" href="#javascript;" data-toggle="modal" data-target=".bd-example-modal-lg">Whats This?</a></p>
			                  </div>
			                  <div class="clearfix"></div>
			                  <div class="col-from-field">
			                    <!--<div class="selectholder">
			                      <label>Choose Time</label>-->
			                      	<select id="apartment_level_packed_delivery" class="apartment_level" required>
										<option value="Select">Select</option>
										<?php 
										foreach($elevator_bulding_array as $key=>$value){
											if($key==$apartment_level_packed){
												echo "<option selected value=$key>$value</option>";
											}else{
												echo "<option value=$key>$value</option>";
											}
										}
										?>
									</select>
			                    <!--</div>-->
			                  </div>
			                  <div class="clearfix"></div>
			                </form>
			              </div>
			            </div>
		          	</div>
		        </div>
		        <!-- 4th form -->
		        <div class="row mt-3" id="pick_up_boxes">
		          	<div class="col-sm-12">
			            <div class="grey-bg p-5">
			              <div class="row">
			                <div class="col-sm-12 mb-4 form-header p-0">
			                  <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
			                  <p class="txt-blue">Pick Up Empty ReBow™ Boxes  :</p>
			                </div>
			              </div>
			              <div class="row justify-content-start">
			                <form action="" class="checkout-form">
			                  <div class="row-form">
			                    <div class="col-from-field">
			                      <p>Pick Up Date* :</p>
			                    </div>
			                    <div class="col-from-field">
			                      <label id="pickup_date" for=""><?php echo $pickup_date;?></label>
			                    </div>
			                  </div>
			                  	<div class="row-form">
				                    <div class="col-from-field custom-label">
				                      <p>Pick Up Time* :</p>
				                    </div>
				                    <div class="col-from-field">
				                      <!--<div class="selectholder">
				                        <label>Choose Time</label>-->
				                        <select id="preferred_pickup_time" required>
											<option value="">Select</option>
											<?php 
											foreach($time_slots_array as $key=>$value){
												if($key==$pickup_time){
													echo "<option selected value=$key>$value</option>";
												}else{
													echo "<option value=$key>$value</option>";
												}
											}
											?>
										</select>
				                      <!--</div>-->
				                    </div>
			                  	</div>
			                  	
			                  <div class="row-form">
			                    <div class="col-from-field custom-label">
			                      <p>Pick Up Address*:</p>
			                    </div>
			                    <div class="col-from-field">
			                      <div class="location-pin">
			                          <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
			                      </div>
			                        <input id="pickup_address" class="addrs" type="text" placeholder="Enter Delivery Address" value="<?php echo $pickup_address;?>">
			                        <input id="apt_unit_pickup" class="small-input ml-3" type="text" placeholder="Apt # / Unit" value="<?php echo $apt_unit_pickup;?>">

			                        <input type="hidden" id="pickup_address_loc_lat" value="<?php echo $pickup_address_loc_lat;?>" />
			    					<input type="hidden" id="pickup_address_loc_long" value="<?php echo $pickup_address_loc_long;?>" />
			                    </div>
			                  </div>
			                  <div class="col-from-field">
			                    <p>Do you live in a walk-up or elevator building?* <a class="wt-this" href="#javascript;" data-toggle="modal" data-target=".bd-example-modal-lg">Whats This?</a></p>
			                  </div>
			                  <div class="clearfix"></div>
			                  <div class="col-from-field">
			                    <!--<div class="selectholder">
			                      <label>Choose Time</label>-->
			                     	<select id="apartment_level_pickup" class="apartment_level">
										<option value="Select">Select</option>
										<?php 
										foreach($elevator_bulding_array as $key=>$value){
											if($key==$apartment_level_pickup){
												echo "<option selected value=$key>$value</option>";
											}else{
												echo "<option value=$key>$value</option>";
											}
										}
										?>
									</select>
			                    <!--</div>-->
			                  </div>
			                  <div class="clearfix"></div>
			                </form>
			              </div>
			            </div>
		          	</div>
		        </div>
		        <!--start Note -->
		        <div class="row">
		          <div class="col-sm-12 mt-3">
		            <div class="dark-grey-bg">
		            <p class="note">* Note : Any changes made to delivery time, or location must be done Monday - Friday 48 hours in advance of delivery time and date.  Example  : If delivery is scheduled for 2pm on Monday, all changes must be adjusted before Friday at 2pm.</p>
		            </div>
		          </div>
		        </div>
		        <!-- button -->
		        <div class="row justify-content-end my-5">
		          <div class="bottom-btn">
		            <button id="cancel" type="button" class="btn btn-grey mr-4">Cancel</button>
		            <button id="submit_changes" type="submit" class="btn btn-secondary">NEXT</button>
		          </div>
		        </div>
		        </div>

		      </div>
		    </div>
		  </div>
		</section>
		<div id="cancel-order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content text-center">
		      <div class="modal-header border-0">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="justify-content-end modal-body pb-5 px-5">
		        <h4 class="txt-grey">Are you sure you want to cancel?</h4>
		        <p>Your changes will not be saved.</p>
		        <button id="yes" type="submit" class="btn btn-secondary">YES</button>
		        <button id="no" type="submit" class="btn btn-grey mr-4">NO</button>
		      </div>
		    </div>
		  </div>
		</div>

		<?php get_footer();?>
		<script>
			jQuery(document).ready(function() {
				jQuery("#back_btn").click(function (){
				  window.history.back();
				});
				$('#back_btn').hover(function() {
			      	$(this).css('cursor','pointer');
			  	});
				var period_data = jQuery('#period_data_field').val();
				if(period_data=="RENTAL"){
					jQuery('#deliver_boxes').show();
					jQuery('#pick_up_boxes').show();
					jQuery('#delivery_packed_boxes').hide();
					jQuery('#pick_up_packed_boxes').hide();
					
				}
				jQuery('.apartment_level').change(function(){
					//alert('clicked');
					var apartment_level_delivery = jQuery('#apartment_level_delivery').val();
				
					var apartment_level_packed = jQuery('#apartment_level_packed').val();

					var apartment_level_packed_delivery = jQuery('#apartment_level_packed_delivery').val();

					var apartment_level_pickup = jQuery('#apartment_level_pickup').val();

					var added_box_count_field = Number(jQuery('#added_box_count_field').val());

					var box_count = added_box_count_field;
					
					var apartment_level_delivery_cost = get_pickup_delivery_cost(apartment_level_delivery,box_count);
					
					var apartment_level_packed_cost = get_pickup_delivery_cost(apartment_level_packed,box_count);
					
					var apartment_level_packed_delivery_cost = get_pickup_delivery_cost(apartment_level_packed_delivery,box_count);
					
					var apartment_level_pickup_cost = get_pickup_delivery_cost(apartment_level_pickup,box_count);
					
					var delivery_cost = apartment_level_delivery_cost+apartment_level_packed_delivery_cost;
					//alert(delivery_cost);
					var pickup_cost = apartment_level_packed_cost+apartment_level_pickup_cost;
					//alert(pickup_cost);

					jQuery('#delivery_cost_field').val(delivery_cost);

					jQuery('#pickup_cost_field').val(pickup_cost);

					//jQuery('#sales_tax_field').val(sales_tax);
 
				});

				jQuery('#submit_changes').click(function(event) {
					alert(1);
					//event.preventDefault()
					//jQuery('#edit_details_pickup_delivery').submit();
					//var previous_delivery_cost = "<?php //echo (isset($session_data->delivery_cost)) ? $session_data->delivery_cost : 0;?>";

					//var previous_pickup_cost = "<?php //echo (isset($session_data->pickup_cost)) ? $session_data->pickup_cost : 0;?>";

					var period = jQuery('#period').val();

					var period_data_field = jQuery('#period_data_field').val();
					/*Form 1*/
					var delivery_date = jQuery('#delivery_date').text().trim();

					var preferred_delivery_time = jQuery('#preferred_delivery_time').val();

					var alternate_delivery_time = jQuery('#alternate_delivery_time').val();

					var delivery_address = jQuery('#delivery_address').val();

					var apt_unit_delivery = jQuery('#apt_unit_delivery').val();

					var apartment_level_delivery = jQuery('#apartment_level_delivery').val();

					var delivery_address_loc_lat = jQuery('#delivery_address_loc_lat').val();

					var delivery_address_loc_long = jQuery('#delivery_address_loc_long').val();

					/*END Form 1*/

					/*Form 4*/

					var pickup_date = jQuery('#pickup_date').text().trim();

					var preferred_pickup_time = jQuery('#preferred_pickup_time').val();

					var alternate_pickup_time = jQuery('#alternate_pickup_time').val();

					var pickup_address = jQuery('#pickup_address').val();

					var apt_unit_pickup = jQuery('#apt_unit_pickup').val();

					var apartment_level_pickup = jQuery('#apartment_level_pickup').val();

					var pickup_address_loc_lat = jQuery('#pickup_address_loc_lat').val();

					var pickup_address_loc_long = jQuery('#pickup_address_loc_long').val();

					var delivery_cost = jQuery('#delivery_cost_field').val();

					//delivery_cost = delivery_cost-previous_delivery_cost;

					alert(delivery_cost);

					var pickup_cost = jQuery('#pickup_cost_field').val();

					//pickup_cost = pickup_cost-previous_pickup_cost;

					alert(delivery_cost);
						
						

					if(period_data_field=="STORAGE"){

						/*Form 2*/
						var pickup_date_packed = jQuery('#pickup_date_packed').text();

						var preferred_pickup_time_packed = jQuery('#preferred_pickup_time_packed').val();
						
						var alternate_pickup_time_packed = jQuery('#alternate_pickup_time_packed').val();

						var pickup_address_packed = jQuery('#pickup_address_packed').val();

						var apt_unit_pickup_packed = jQuery('#apt_unit_pickup_packed').val();

						var apartment_level_packed = jQuery('#apartment_level_packed').val();

						var pickup_address_packed_loc_lat = jQuery('#pickup_address_loc_lat').val();

						var pickup_address_packed_loc_long = jQuery('#pickup_address_loc_long').val();

						/*END Form 2*/

						/*Form 3*/
						//var selectaddress = jQuery('#selectaddress').val();
						var delivery_date_packed = jQuery('#delivery_date_packed').text();

						var preferred_delivery_time_packed = jQuery('#preferred_delivery_time_packed').val();
						
						var alternate_delivery_time_packed = jQuery('#alternate_delivery_time_packed').val();

						var delivery_address_packed = jQuery('#delivery_address_packed').val();

						var apt_unit_delivery_packed = jQuery('#apt_unit_delivery_packed').val();

						var apartment_level_packed_delivery = jQuery('#apartment_level_packed_delivery').val();
						var delivery_address_packed_loc_lat = jQuery('#pickup_address_loc_lat').val();

						var delivery_address_packed_loc_long = jQuery('#pickup_address_loc_long').val();

						/*END Form 3*/

						datastring = "ajax_request=edit_pickup_delivery_info&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&apartment_level_delivery="+apartment_level_delivery+"&pickup_date="+pickup_date+"&preferred_pickup_time="+preferred_pickup_time+"&alternate_pickup_time="+alternate_pickup_time+"&pickup_address="+pickup_address+"&apt_unit_pickup="+apt_unit_pickup+"&apartment_level_pickup="+apartment_level_pickup+"&pickup_date_packed="+pickup_date_packed+"&preferred_pickup_time_packed="+preferred_pickup_time_packed+"&alternate_pickup_time_packed="+alternate_pickup_time_packed+"&pickup_address_packed="+pickup_address_packed+"&apt_unit_pickup_packed="+apt_unit_pickup_packed+"&apartment_level_packed="+apartment_level_packed+"&delivery_date_packed="+delivery_date_packed+"&delivery_address_packed="+delivery_address_packed+"&apt_unit_delivery_packed="+apt_unit_delivery_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&preferred_delivery_time_packed="+preferred_delivery_time_packed+"&alternate_delivery_time_packed="+alternate_delivery_time_packed+"&delivery_cost="+delivery_cost+"&pickup_cost="+pickup_cost+"&delivery_address_loc_lat="+delivery_address_loc_lat+"&delivery_address_loc_long="+delivery_address_loc_long+"&pickup_address_loc_lat="+pickup_address_loc_lat+"&pickup_address_loc_long="+pickup_address_loc_long+"&delivery_address_packed_loc_lat="+delivery_address_packed_loc_lat+"&delivery_address_packed_loc_long="+delivery_address_packed_loc_long+"&pickup_address_packed_loc_lat="+pickup_address_packed_loc_lat+"&pickup_address_packed_loc_long="+pickup_address_packed_loc_long;
					}else{
						datastring = "ajax_request=edit_pickup_delivery_info&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&apartment_level_delivery="+apartment_level_delivery+"&pickup_date="+pickup_date+"&preferred_pickup_time="+preferred_pickup_time+"&alternate_pickup_time="+alternate_pickup_time+"&pickup_address="+pickup_address+"&apt_unit_pickup="+apt_unit_pickup+"&apartment_level_pickup="+apartment_level_pickup+"&delivery_cost="+delivery_cost+"&pickup_cost="+pickup_cost+"&delivery_address_loc_lat="+delivery_address_loc_lat+"&delivery_address_loc_long="+delivery_address_loc_long+"&pickup_address_loc_lat="+pickup_address_loc_lat+"&pickup_address_loc_long="+pickup_address_loc_long;
					}

					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    console.log(result);

						    jQuery(location).attr('href', '/rebow/my-order-summary');
						}
					});
					
				});
				jQuery("#cancel").click(function() {
					//alert(1);
					jQuery('#cancel-order').modal('show');
				});
				jQuery("#yes").click(function() {

					jQuery(location).attr('href', '/rebow/view-order/');
				
				});
				jQuery("#no").click(function() {

					
					jQuery(location).attr('href', '#');
					jQuery('#cancel-order').modal('hide');
					
				});

			});
			function get_pickup_delivery_cost(apartment_level,box_count){
				//alert(box_count);
			    if(apartment_level=="Elevator"){
			        if(box_count<50){
			            var delivery_cost = 25;
			        }else if(box_count>49 && box_count<100){
			            delivery_cost = 50;
			        }
			    }else if(apartment_level=="Stairs"){
			        if(box_count<50){
			            delivery_cost = 50;
			        }else if(box_count>49 && box_count<100){
			            delivery_cost = 100;
			        }
			    }else{
			        delivery_cost = 0;
			    }
			    return delivery_cost;
			}

		</script>

		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBtVumWdkvUED3b_Ct75wcYXsJQmKQWuXM"></script>
		<script>
			//var searchInput = 'delivery_address';

			jQuery(document).ready(function () {
				//alert(1);
			   	set_lat_long("delivery_address",'delivery_address_loc_lat','delivery_address_loc_long');
			   	set_lat_long("pickup_address_packed",'pickup_address_packed_loc_lat','pickup_address_packed_loc_long');
			   	set_lat_long("delivery_address_packed",'delivery_address_packed_loc_lat','delivery_address_packed_loc_long');
			   	set_lat_long("pickup_address",'pickup_address_loc_lat','pickup_address_loc_long');

			});

			function set_lat_long(searchInput,latvar,longvar){
				var autocomplete;
			    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
			        types: ['geocode'],
			    });
				
			    google.maps.event.addListener(autocomplete, 'place_changed', function () {
			        var near_place = autocomplete.getPlace();

			        document.getElementById(latvar).value = near_place.geometry.location.lat();
			        document.getElementById(longvar).value = near_place.geometry.location.lng();
					
			        //document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
			        //document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
			    });
			}
		</script>
	</body>
</html>