<?php /* Template Name: delivery_pickup*/ ?>

<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php
		require_once('session_values.php');
		//get_header();
		require_once('header2.php');
		?>
		
			<section class="page-header mt-10">
			  <div class="container">
			    <div class="row justify-content-center">
			      <div class="col text-center">
			        <h1>Pickup & Dropoff Details</h1>
			      </div>
			    </div>
			  </div>
			</section>
			<!-- Start  breadcrumb -->
			<section class="mt-4">
			  <div class="container">
			    <div class="row justify-content-center">
			      <div class="col-sm-12 p-0">
			        <nav class="bc" aria-label="breadcrumb">
			          <ol class="breadcrumb1">
			            <li class="breadcrumb-item"><a href="#">Pricing</a></li>
			            <li class="breadcrumb-item"><a href="#"><?php echo $breadcrumb1;?></a></li>
			            <li class="breadcrumb-item"><a href="#"><?php echo $breadcrumb2;?></a></li>
			            <li class="breadcrumb-item active" aria-current="page">DELIVERY DETAILS</li>
			          </ol>
			        </nav>
			      </div>
			    </div>
			  </div>
			</section>
			<!-- End breadcrumb -->
			<section class="rp" id="deliver_boxes">

			  <div class="container">
			  	<div class="grey-bg p-5">
				    <div class="row">
				      <div class="col-sm-12 mb-4 form-header">
				        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/warehouse-godown.png" alt="">
				        <p>Delivery of your ReBow™ Boxes :</p>
				      </div>
				    </div>
				    <div class="row justify-content-start">
				      <form id="delivery_box_submit" action="" class="checkout-form">
				        <div class="row">
				            <label class="col-sm-12 col-md-2 mt-3" for="">Delivery Date* : </label>
				            <div class="col-sm-12 col-md-3">
				            	<input id="delivery_date_field" type="hidden" value="<?php echo $delivery_date;?>">

				              	<input id="delivery_date" required class="global_date" type="text" placeholder="Choose Date" name="delivery_date" <?php echo (($delivery_date)) ? 'value="'.get_custom_formatted_date($delivery_date).'"' : 'value ="" placeholder="Choose  Date"' ?>  readonly>
				              	<input type="hidden" id="delivery_address_loc_lat" value="<?php echo $delivery_address_loc_lat;?>"/>
			    				<input type="hidden" id="delivery_address_loc_long" value="<?php echo $delivery_address_loc_long;?>"/>
				            </div>
				        </div>
				        <div class="row pt-4">
				          <label class="col-sm-12 col-md-2">Preferred<br>Delivery Time* : </label>
				          <div class="col-sm-12 col-md-2">
				            <!--<div class="selectholder">
				              <label>Choose Time</label>-->
				              	<select id="preferred_delivery_time" required>
									<option value="">Select</option>
									<?php 
									foreach($time_slots_array as $key=>$value){
										if($key==$preferred_delivery_time){
											echo "<option selected value=$key>$value</option>";
										}else{
											echo "<option value=$key>$value</option>";
										}
									}
									?>
								</select>
				            <!--</div>-->
				          </div>
				          <label class="col-sm-12 col-md-2">Alternate<br>Delivery Time* : </label>
				          <div class="col-sm-12 col-md-2">
				            <!--<div class="selectholder">
				            <label>Choose Time</label>-->
				            <select id="alternate_delivery_time" required>
								<option value="">Select</option>
								<?php 
								foreach($time_slots_array as $key=>$value){
									if($key==$alternate_delivery_time){
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
				        <div class="row pt-4">
				          <label for="" class="col-sm-12 col-md-2 mt-3">Delivery Address*:</label>
				          <div class="col-sm-12 col-md-5">
				              <div class="location-pin">
				                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
				              </div>
				              <input id="delivery_address" class="addrs" type="text" placeholder="Enter Delivery Address" value="<?php echo $delivery_address;?>" required>
				          </div>
				          <div class="col-sm-12 col-md-3">
				            <input id="apt_unit_delivery" type="text" placeholder="Apt # / Unit" value="<?php echo $apt_unit_delivery;?>">
				          </div>
				        </div>
				        <div class="row pt-4">
				          <div class="col-sm-12 pb-2">
				            <label for="">Do you live in a walk-up or elevator building?* <a href="#javascript;" class="txt-grey" data-toggle="modal" data-target=".bd-example-modal-lg"><u>Whats This?</u></a></label>
				          </div>
				          <div class="col-sm-12 col-md-2">
				            <div class="md-selectholder">
				              <!--<label>Choose Time</label>-->
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
				            </div>
				          </div>
				        </div>
				        <button type="submit" id="continue_delivery" type="" class="btn btn-secondary">CONTINUE</button>
				      </form>
				    </div>
				</div>
			  </div>
			</section>
			<div class="clearfix"></div>
			<section class="rp mt-4" id="pick_up_packed_boxes">
			  <div class="container">
			  	<div class="grey-bg p-5">
				    <div class="row">
				      <div class="col-sm-12 mb-4 form-header">
				        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
				        <p>Pick Up your Packed ReBow™ Boxes For Storage: </p>
				      </div>
				    </div>
				    <div class="row justify-content-start">
				      <form id="pick_up_packed_boxes_submit" action="" class="checkout-form">
				        <div class="row">
				            <label class="col-sm-12 col-md-2 mt-3" for="">Pick Up Date* : </label>
				            <div class="col-sm-12 col-md-3">
				            	<input id="pickup_date_packed_field" type="hidden" value="<?php echo $pickup_date_packed;?>">
				             	<label id="pickup_date_packed" class="date-print" for="" ><?php echo get_custom_formatted_date($pickup_date_packed);?></label>
				            </div>
				        </div>
				        <div class="row">
				        	<label class="col-sm-12 col-md-6 dark-gray-bg mt-1 p-3">*You can keep your ReBow boxes for 48 hours complimentary to pack.
							<br/>Want to keep your ReBow boxes longer ? <b>Call Us!</b></label>
				        </div>
				        <div class="row pt-4">
				          <label class="col-sm-12 col-md-2">Preferred<br>Pick Up Time* : </label>
				          <div class="col-sm-12 col-md-2">
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
				          <label class="col-sm-12 col-md-2">Alternate<br>Pick Up Time* : </label>
				          <div class="col-sm-12 col-md-2 pb-4">
				            <!--<div class="selectholder">
				            <label>Choose Time</label>-->
				            <select id="alternate_pickup_time_packed" required>
								<option value="">Select</option>
								<?php 
								foreach($time_slots_array as $key=>$value){
									if($key==$alternate_pickup_time_packed){
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
				        <div class="row">
				          <div class="col-sm-12">
				            <label class="control control-checkbox">Same as delivery address
				              <input id="checkbox1" type="checkbox"/>
				              <div class="control-indicator"></div>
				            </label>
				          </div>
				        </div>
				        <div class="row pt-4">
				          	<label for="" class="col-sm-12 col-md-2 mt-3">Pick Up Address*:</label>
				          	<div class="col-sm-12 col-md-5">
				              	<div class="location-pin">
				                	<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
				              	</div>
				              	<input id="pickup_address_packed" class="addrs" type="text" placeholder="Enter Delivery Address" value="<?php echo $pickup_address_packed;?>" required>
				              	<input type="hidden" id="pickup_address_packed_loc_lat" value="<?php echo $pickup_address_packed_loc_lat;?>" />
			    				<input type="hidden" id="pickup_address_packed_loc_long" value="<?php echo $pickup_address_packed_loc_long;?>" />
				          	</div>
				          <div class="col-sm-12 col-md-3">
				            <input id="apt_unit_pickup_packed" type="text" placeholder="Apt # / Unit" value="<?php echo $apt_unit_pickup_packed;?>" >
				          </div>
				        </div>
				        <div class="row pt-4 pb-2">
				          <div class="col-sm-12 ">
				            <label for="">Do you live in a walk-up or elevator building?* <a href="#javascript;" class="txt-grey" data-toggle="modal" data-target=".bd-example-modal-lg"><u>Whats This?</u></a></label>
				          </div>
				          <div class="col-sm-12 col-md-2 mb-2">
				            <!--<div class="selectholder">
				              <label>Choose Time</label>-->
				              <select id="apartment_level_packed" class="apartment_level" required>
								<option value="">Select</option>
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
				        </div>
				        
				        <button type="submit" id="continue_pickup_packed_boxes" type="" class="btn btn-secondary">CONTINUE</button>
				      </form>
				    </div>
				</div>
			  </div>
			</section>
			<div class="clearfix"></div>
			<section class="rp mt-4" id="delivery_packed_boxes">
			  <div class="container">
			  	<div class="grey-bg p-5">
			    <div class="row">
			      <div class="col-sm-12 mb-4 form-header">
			        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
			        <p>Delivery of your Stored Items :</p>
			      </div>
			    </div>
			    <div class="row justify-content-start">
			      <form id="delivery_packed_boxes_submit" action="" class="checkout-form">
			        <div class="row">
			            <label class="col-sm-12 col-md-2 mt-3" for="">Delivery Date* : </label>
			            <div class="col-sm-12 col-md-3">
			            	<input id="delivery_date_packed_field" type="hidden" value="<?php echo $delivery_date_packed;?>" />

			             	<label id="delivery_date_packed" class="date-print" for="" ><?php echo get_custom_formatted_date($delivery_date_packed);?></label>
			            </div>
			        </div>
			        <div class="row pt-4">
			          <label class="col-sm-12 col-md-2">Preferred<br>Delivery Time* : </label>
			          <div class="col-sm-12 col-md-2">
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
			          <label class="col-sm-12 col-md-2">Alternate<br>Delivery Time* : </label>
			          <div class="col-sm-12 col-md-2">
			            <!--<div class="selectholder">
			            <label>Choose Time</label>-->
			            <select id="alternate_delivery_time_packed" required>
							<option value="">Select</option>
							<?php 
							foreach($time_slots_array as $key=>$value){
								if($key==$alternate_pickup_time_packed){
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
			        <!--<div class="row">
			        <div class="col-sm-12">
			            <label class="control control-checkbox">Same as delivery address
			              <input id="checkbox_new" type="checkbox"/>
			              <div class="control-indicator"></div>
			            </label>
			          </div>
			        </div>-->
			        <div class="row pt-4">
			          <label for="" class="col-sm-12 col-md-2 mt-3">Pick Up Address*:</label>
			          <div class="col-sm-12 col-md-5">
				            <div class="location-pin">
				               <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
				            </div>
			              	<input id="delivery_address_packed" class="addrs" type="text" placeholder="Enter Delivery Address" value="<?php echo $delivery_address_packed;?>" required>
			              	<input type="hidden" id="delivery_address_packed_loc_lat" value="<?php echo $delivery_address_packed_loc_lat;?>"/>
			    			<input type="hidden" id="delivery_address_packed_loc_long" value="<?php echo $delivery_address_packed_loc_long;?>"/>
			          </div>
			          <div class="col-sm-12 col-md-3">
			            <input id="apt_unit_delivery_packed" type="text" placeholder="Apt # / Unit" value="<?php echo $apt_unit_delivery_packed;?>">
			          </div>
			        </div>
			        <div class="row pt-4">
			          <div class="col-sm-12 pb-2">
			            <label for="">Do you live in a walk-up or elevator building?* <a href="#javascript;" class="txt-grey" data-toggle="modal" data-target=".bd-example-modal-lg"><u>Whats This?</u></a></label>
			          </div>
			          <div class="col-sm-12 col-md-2 pb-2">
			            <!--<div class="selectholder">
			              <label>Choose Time</label>-->
			              <select id="apartment_level_packed_delivery" class="apartment_level" required>
							<option value="">Select</option>
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
			        </div>
			        <button type="submit" id="continue_delivery_packed_boxes" type="" class="btn btn-secondary">CONTINUE</button>
			      </form>
			    </div>
				</div>
			  </div>
			</section>
			<div class="clearfix"></div>
			<section class="rp mt-4" id="pick_up_boxes">
			  <div class="container">
			  	<div class="grey-bg p-5">
			    <div class="row">
			      <div class="col-sm-12 mb-4 form-header">
			        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
			        <p>Pick Up your Empty Boxes: </p>
			      </div>
			    </div>
			    <div class="row justify-content-start">
			      <form id="pick_up_boxes_submit" action="" class="checkout-form">
			        <div class="row">
			            <label class="col-sm-12 col-md-2 mt-3" for="">Pick Up Date* : </label>
			            <div class="col-sm-12 col-md-3">
			            	<input type="hidden" id="pickup_date_field" value="<?php echo $pickup_date;?>" />
			             	<label id="pickup_date" class="date-print" for="" ><?php echo get_custom_formatted_date($pickup_date);?></label>
			            </div>
			        </div>
			        <div class="row pt-4">
			          <label class="col-sm-12 col-md-2">Preferred<br>Pick Up Time* : </label>
			          <div class="col-sm-12 col-md-2">
			            <!--<div class="selectholder">
			              <label>Choose Time</label>-->
			              	<select id="preferred_pickup_time" required>
								<option value="">Select</option>
								<?php 
								foreach($time_slots_array as $key=>$value){
									if($key==$preferred_pickup_time){
										echo "<option selected value=$key>$value</option>";
									}else{
										echo "<option value=$key>$value</option>";
									}
								}
								?>
							</select>
			            <!--</div>-->
			          </div>
			          <label class="col-sm-12 col-md-2">Alternate<br>Pick Up Time* : </label>
			          <div class="col-sm-12 col-md-2">
			            <!--<div class="selectholder">
			            <label>Choose Time</label>-->
			            <select id="alternate_pickup_time" required>
							<option value="">Select</option>
							<?php 
							foreach($time_slots_array as $key=>$value){
								if($key==$alternate_pickup_time){
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
			        <div class="row">
			          <div class="col-sm-12">
			          	<?php if($period_data==0){
			          		$checkbox_label_text = "Same as delivery address";
			          	}else{

			          		$checkbox_label_text = "Same as delivery address of your stored items";
			          	}
			          	?>
			            <label class="control control-checkbox"><?php echo $checkbox_label_text;?>
			              <input id="checkbox2" type="checkbox"/>
			              <div class="control-indicator"></div>
			            </label>
			          </div>
			        </div>
			        <div class="row pt-4">
			          	<label for="" class="col-sm-12 col-md-2 mt-3">Pick Up Address*:</label>
			          	<div class="col-sm-12 col-md-5">
			              <div class="location-pin">
			                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
			              </div>
			              	<input id="pickup_address" class="addrs" type="text" placeholder="Enter Pickup Address" value="<?php echo $pickup_address;?>" required>
			              	<input type="hidden" id="pickup_address_loc_lat" value="<?php echo $pickup_address_loc_lat;?>" />
			    			<input type="hidden" id="pickup_address_loc_long" value="<?php echo $pickup_address_loc_long;?>" />
			          	</div>
			          <div class="col-sm-12 col-md-3">
			            <input id="apt_unit_pickup" type="text" placeholder="Apt # / Unit" value="<?php echo $apt_unit_pickup;?>">
			          </div>
			        </div>
			        <div class="row pt-4">
			          <div class="col-sm-12 pb-2">
			            <label for="">Do you live in a walk-up or elevator building?* <a href="#javascript;" class="txt-grey" data-toggle="modal" data-target=".bd-example-modal-lg"><u>Whats This?</u></a></label>
			          </div>
			          <div class="col-sm-12 col-md-2">
			            <!--<div class="selectholder">
			              <label>Choose Time</label>-->
			              	<select id="apartment_level_pickup" class="apartment_level" required>
								<option value="">Select</option>
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
			        </div>
			        <br/>
			        <button type="submit" id="continue_pickup" type="" class="btn btn-secondary">NEXT</button>
			      </form>
			    </div>
				</div>
			  </div>
			</section>
			<div class="clearfix"></div>
			<section id="order_summary" class="mt-2">
				<div class="container">
					<div class="package-selection">
				    	<div class="row justify-content-center my-5">
					      	<div class="col-sm-12 col-md-3 text-center">
					        	<h4 class="order-summary">Order Summary </h4>
					      	</div>
					    </div>
				    	<div class="row mr-3">
			    			<div class="col-sm-12 col-md-4 text-center mt-5">
						        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/dollies.png" alt="">
						    </div>
				      		<div class="col-sm-12 col-md-4">
	        					<div class="ps">
					    			<label for="">Your Package Selection :</label>
		          					<div class="md-selectholder">
						    			<select id="selectpackage">
						    				<?php
						    				
						    				//print_r($datas);
						    				foreach($datas as $row){
						    					//$product_name1 = $row['product_name'];
						    					$product_box_count = $row['box_count'];
						    					//$row['product_name'];
						    					$id = $row['product_id'];
						    					$val= $id."/".$row['product_name']."/".$product_box_count;
						    					
						    					if($id==$product_id){
						    						echo "<option selected value='$val'>".$row['product_name']."</option>";
						    					}else{
						    						echo "<option value='$val'>".$row['product_name']."</option>";
						    					}
						    				}
						    				
						    				?>
						    				
						    			</select>
					    			</div>
								   	<small>
						                <em>Includes<sup>*</sup> :</em>
						            </small>
						            <div class="clearfix"></div>
					                <ul class="includes pt-1 mb-2">
						                <li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  <span id="nestable_dollies_count"><?php echo $nestable_dollies_count;?> Nestable Dollies
						                  </span>
						                </li>
						                <li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  <span id="labels_count">
						                  	<?php echo $labels_count;?> Labels
						                  </span> 
						              	</li>
						                <li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  <span id="zipties_count">
						                  	<?php echo $zipties_count;?> Security Zip Ties
						                  </span>
						              	</li>
						                <?php if($period_data==0){?>
						                <li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  Free Delivery &amp; Pickup 
						             	</li>
						             	<?php }else{?>
						             	<li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  2 Day Complimentary
						             	</li>
						             	<li>
						             		Packing / Unpacking Window &nbsp;<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" title="" data-toggle="modal" data-target="#exampleModalCenter"/>
						             	</li>
						             	<?php }?>
					              	</ul>
					              	<label>Rental Time Period:</label>
						            <div class="md-selectholder">
						                <!--<label>Select Period</label>-->
						               	<select id="selectperiod1">
					    				<?php
					    				foreach($array1 as $key=>$value){
					    					
					    					if($value==$period_data_value){
					    						echo "<option selected value=$key> $value</option>";
					    					}else{
					    						echo "<option value=$key> $value</option>";
					    					}
					    				}
					    				?>
					    				
					    				</select>
						            </div>
				    			</div>
				    			<button type="submit" id="add_more_boxes" class="btn btn-secondary">Add more boxes</button>
			    			</div>
			    			
			    			<div class="col-sm-12 col-md-4">
						        <div class="grey-bg px-5 pt-5 mb-3">
						          	<p class="pkg">PACKAGE:</p>
						          	<ul class="list-group mb-3">
						            	<li class="list-group-item d-flex justify-content-between lh-condensed">
							             	<div class="col-md-8 p-0">
							                  <ul class="pkg-info">
							                    <li><span id="product_name"><?php echo $product_name;?></span> / <span id="box_count"><?php echo $box_count;?> </span> Boxes </li>
							                    <li id="period_data_span"><?php echo $period_data_span;?></li>
							                    <li class="addedboxfield"><span id="addedboxno"><?php echo $added_box_no;?></span> Added Boxes</li>
							                  </ul>
							                </div>
							                <div class="col-md-4 p-0 text-right align-self-end">
							                   <span id="product_price" class="text-muted">$<?php echo $display_data_price?></span>
							                    <div class="clearfix"></div>
							                    <span id="addedboxprice" class="addedboxfield text-muted">$<?php echo $added_box_price;?></span>
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
							                <p class="my-0">Delivery - <span id="delivery_floor_level"><?php echo $apartment_level_delivery_text;?></span></p>
							                <p class="my-0">Pickup - <span id="pickup_floor_level"><?php echo $apartment_level_pickup_text;?></span></p>
							              </div>
							              <div class="col-md-4 p-0 text-right align-self-end">
							                <span id="delivery_cost" class="text-muted"><?php 
							                if($delivery_cost==0){
							                	echo $delivery_cost_text;
							                }else{
							                	echo "$".$delivery_cost;
							                }
							                ?></span>
							                <div class="clearfix"></div>
							                <span id="pickup_cost" class="text-muted">
						                	<?php 
							                	if($pickup_cost==0){
							                		echo $pickup_cost_text;
								                }else{
								                	echo "$".$pickup_cost;
								                }
						                	?>
							            </li>
							            <li class="list-group-item d-flex justify-content-between lh-condensed">
							              <div class="col-md-8 p-0 align-self-end">
							                <p class="my-0">Sales Tax</p>
							              </div>
							              <div class="col-md-4 p-0 text-right align-self-end">
							                <span id="sales_tax" class="text-muted">$<?php echo $sales_tax;?></span>
							              </div>
							            </li>
							            <li class="list-group-item d-flex justify-content-between">
							              <span>Total</span>
							              <strong id="total_price">$<?php echo $total_price;?></strong>
							            </li>
							        </ul>
					    		</div>		
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</section>
			<div class="clearfix"></div>
		    <section class="my-5">
			  <div class="container">
			    <div class="row justify-content-center">
			      <div class="col-sm-12 col-md-8">
			        <div class="nt-sure text-center">
			          <h5>Not sure what might work ?</h5>
			          <p>Call one of our service representatives at: <a href="tel:3232771111">323 - 277 - 1111</a></p>
			        </div>
			      </div>
			    </div>
			  </div>
			</section>
		    <?php 
		    	$query = "select keyy,value from lookup_table where description='Boxes'";
					$res = mysql_query($query);	
			?>
 			<!-- Add more Boxes -->
			<section  id="add_more_boxes_area" class="hide grey-bg py-5">
			  <div class="container">
			    <div class="row justify-content-center">
			      <div class="col-sm-12 col-md-4">
			        <h3 class="text-h">Add More Boxes!</h3>
			      </div>
			    </div>
			    <div class="row justify-content-center">
			      	<div class="col-sm-12 col-md-3">
			        	<img class="mt-5" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/more-boxes.png" alt="">
			      	</div>
			    	<div class="col-sm-12 col-md-4 mt-5">
			        <p>Need more ReBow™ Boxes?<br>You can add them in sets of 4.</p>
			        <div class="row mt-4">
			          	<div class="col-sm-12 col-md-3">
			            	<p class="pt-2">Quantity</p>
			          	</div>
 						<div class="col-sm-12 col-md-8">
				            <!--<div class="selectholder">
				                <label>Choose Boxes</label>-->
	 							<select id="add_box_count">
	 								<?php while($row=mysql_fetch_assoc($res)){ 

	 									echo "<option value=".$row['keyy'].">".$row['value']."</option>";
	 								
	 								}?>
	 							</select>
	 						<!--</div>-->
	 					</div>
	 					<div class="col-sm-12 col-md-1">
				            <button id="add_more_boxes785" type="submit" class="btn btn-secondary">Add</button>
				        </div>
 						<div class="col-sm-12">
				          <span>Price</span>
				          <label id="added_box_price" for=""><?php echo $box_count_price;?></label>
				        </div>
				        <div class="col-sm-12 mt-3">
				          	<p>Every 4 Boxes includes : </p>
				          	<ul class="includes pt-1 mb-2">
				              	<li>
					                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
					                  <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
					                </svg>
				                1 Nestable ReBow<sup>™</sup> Dolly </li>
				              	<li>
					                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
					                  <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
					                </svg>
				                4 Labels
				            	</li>
				              	<li>
					                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
					                  <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
					                </svg>
				                4 Security Zip Ties
				            	</li>
				            </ul>
				        </div>
 					</div>
			    </div>
			</section>
			
			<!-- Frequently Asked Questions -->
			<section class="mt-5">
			  <div class="container">
			    <div class="row justify-content-center">
			      <div class="col-sm-12 col-md-5 faq-h my-5">
			        <h3 class="light-blue">Frequently Asked Questions </h3>
			      </div>
			    </div>
			    <div class="row row justify-content-around">
			      <div class="col-sm-12 col-md-5">
			        <div class="faq-ques">
			          <h6>How long do I get to keep the ReBow™ Boxes I rent?</h6>
			          <p>To start, every order has a minimum rental term of 2 weeks. Anything after that is up to you. Boxes will be charged on a weekly basis after the 2 week minimum.</p>
			        </div>
			        <div class="faq-ques">
			          <h6>What if I need to reschedule my delivery date ?</h6>
			          <p>You can do so by logging into your account or you can call us. You must reschedule your delivery day 48 hours in advance. </p>
			        </div>
			         <div class="faq-ques">
			          <h6>Are there delivery and pickup fees?</h6>
			          <p>Delivery and pickup services are free in our coverage area. For locations outside our service area call to check availability—additional charges may apply. Click here to check our coverage area.</p>
			        </div>
			      </div>
			      <div class="col-sm-12 col-md-5">
			        <div class="faq-ques">
			          <h6>What if I need more boxes after I placed my order?</h6>
			          <p>You can log into your account and add more boxes to your order or you can simply place a new order on our website and we’ll be happy to deliver additional ReBow boxes.</p>
			          <p>If you can’t find your account login information, <a href="javascript:;">contact</a> us.</p>
			        </div>
			        <div class="faq-ques">
			          <h6>Will ReBow™ pack or move my stuff?</h6>
			          <p>No, ReBow™ is not a moving company, we only rent and/or store ReBow boxes. If you're looking for a moving company, we highly recommend our sister company Ortiz Bros. Moving & Storage :323-221-3393.</p>
			        </div>
			        <div class="faq-ques">
			          <h6>Will ReBow™ deliver the boxes inside my house ?</h6>
			          <p>We only offer standard curbside delivery, however if needed we can deliver & pickup your ReBow Boxes inside your building for additional charges. Charges are dependent upon factors such as stairs, elevators, distance from the street, and the quantity of boxes. Cost options can be found here.</p>
			        </div>
			      </div>
			    </div>
			    <div class="row justify-content-center my-5">
			      <div class="col-md-3">
			        <button id="back_to_order" type="submit" class="btn btn-secondary">BACK TO MY ORDER</button>
			      </div>
			    </div>
			  </div>
			</section>
				
		<?php get_footer(); ?>
		<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="/rebow/wp-content/themes/di-ecommerce-child/assets/js/order_summary_js.js"></script>
		<script src="/rebow/wp-content/themes/di-ecommerce-child/assets/js/delievery_pickup.js"></script>
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

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


