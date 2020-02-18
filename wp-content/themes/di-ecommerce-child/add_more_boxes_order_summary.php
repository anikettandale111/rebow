<?php /* Template Name: add_more_boxes_order_summary*/ ?>
<?php require_once("user_check_login.php");?>
<?php 
 require_once("stripe_config.php");
 require_once 'stripe-php/init.php';
require_once("db_config.php");
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
 $intent = \Stripe\SetupIntent::create();
?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php
		require_once('session_values.php');
		get_header(); 
		//print_r($_SESSION);
		//print_r($session_data);
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
		                  <li><a href="">ORDER SUMMARY</a></li>
		                </ul>
		              </div>
		              <div class="col-sm-12 col-md-3">
		                <button type="button" class="submit_order3 btn btn-small blue-bg float-right txt-white">Submit</button>
		              </div>
		            </div>
		          </div>
		        </div>
		        <?php 

					$query = "select * from orders_data where order_id=".$current_order_id;
					$res = mysql_query($query);

					$data = mysql_fetch_assoc($res);
					//echo $data['parent_order_id'];
					if($data['parent_order_id']!=0){
						$payments_data = get_payments_data_user($user_id);
						//echo "in";
					}else{
						//echo "else";
						$payments_data = get_payments_data_user($user_id);
						//print_r($payments_data);
					}
					//print_r($payments_data);

					$payee_name = $payments_data['First_Name']." ".$payments_data['Last_Name'];

					$Card_Number = substr($payments_data['Card_Number'],-4);

					$card_expiry = $payments_data['Expiry_month']."/".$payments_data['Expiry_year'];

					$billing_address = $payments_data['billing_address'];

					//$payments_data = get_payments_data($current_order_id);

					$subtotal = (isset($session_data->subtotal))?$session_data->subtotal:$subtotal_price;

					$salestax = (isset($session_data->sales_tax))?$session_data->sales_tax:$sales_tax;
					//$salestax = round($salestax,2);
					$totalprice = (isset($session_data->total_price))?$session_data->total_price:$total_price;
					//$totalprice = round($totalprice 
					$delivery_cost_price = $delivery_cost - $data['delivery_cost'];

					$pickup_cost_price = $pickup_cost - $data['pickup_cost'];

					if($data['order_type']=="RENTAL"){
						$shipping_type = 'Delivery Empty Boxes';
						$deliver_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

						$shipping_type = 'Pickup Empty Boxes';
						$pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

						/*Delivery Date*/
						$delivery_date =(isset($session_data->delivery_date)) ? $session_data->delivery_date : $deliver_empty_boxes_data['date'];

						$preferred_delivery_time =(isset($session_data->preferred_delivery_time)) ? $session_data->preferred_delivery_time : $deliver_empty_boxes_data['preferred_time'];

						$alternate_delivery_time =(isset($session_data->alternate_delivery_time)) ? $session_data->alternate_delivery_time : $deliver_empty_boxes_data['alternative_time'];

						$delivery_address =(isset($session_data->delivery_address)) ? $session_data->delivery_address : $deliver_empty_boxes_data['address'];

						$apt_unit_delivery =(isset($session_data->apt_unit_delivery)) ? $session_data->apt_unit_delivery : $deliver_empty_boxes_data['apartment_unit_info'];

						$apartment_level_delivery =(isset($session_data->apartment_level_delivery)) ? $session_data->apartment_level_delivery : $deliver_empty_boxes_data['floor_level'];

						/*Pickup Date*/

						$pickup_date =(isset($session_data->pickup_date)) ? $session_data->pickup_date : $pickup_empty_boxes_data['date'];

						$preferred_pickup_time =(isset($session_data->preferred_pickup_time)) ? $session_data->preferred_pickup_time : $deliver_empty_boxes_data['preferred_time'];

						$alternate_pickup_time =(isset($session_data->alternate_pickup_time)) ? $session_data->alternate_pickup_time : $deliver_empty_boxes_data['alternative_time'];

						$pickup_address =(isset($session_data->pickup_address)) ? $session_data->pickup_address : $deliver_empty_boxes_data['address'];

						$apt_unit_pickup =(isset($session_data->apt_unit_pickup)) ? $session_data->apt_unit_pickup : $deliver_empty_boxes_data['apartment_unit_info'];

						$apartment_level_pickup =(isset($session_data->apartment_level_pickup)) ? $session_data->apartment_level_pickup : $deliver_empty_boxes_data['floor_level'];

					}else{

						$shipping_type = 'Delivery Empty Boxes';
						$deliver_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

						$shipping_type = 'Pickup Packed Boxes';
						$pickup_packed_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

						$shipping_type = 'Delivery Packed Boxes';
						$delivery_packed_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

						$shipping_type = 'Pickup Empty Boxes';
						$pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

						/*Delivery Date*/
						$delivery_date =(isset($session_data->delivery_date)) ? $session_data->delivery_date : $deliver_empty_boxes_data['date'];

						$preferred_delivery_time =(isset($session_data->preferred_delivery_time)) ? $session_data->preferred_delivery_time : $deliver_empty_boxes_data['preferred_time'];

						$alternate_delivery_time =(isset($session_data->alternate_delivery_time)) ? $session_data->alternate_delivery_time : $deliver_empty_boxes_data['alternative_time'];

						$delivery_address =(isset($session_data->delivery_address)) ? $session_data->delivery_address : $deliver_empty_boxes_data['address'];

						$apt_unit_delivery =(isset($session_data->apt_unit_delivery)) ? $session_data->apt_unit_delivery : $deliver_empty_boxes_data['apartment_unit_info'];

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

						$pickup_date =(isset($session_data->pickup_date)) ? $session_data->pickup_date : $pickup_empty_boxes_data['date'];
						
						$preferred_pickup_time =(isset($session_data->preferred_pickup_time)) ? $session_data->preferred_pickup_time : $pickup_empty_boxes_data['preferred_time'];

						$alternate_pickup_time =(isset($session_data->alternate_pickup_time)) ? $session_data->alternate_pickup_time : $pickup_empty_boxes_data['alternative_time'];

						$pickup_address =(isset($session_data->pickup_address)) ? $session_data->pickup_address : $pickup_empty_boxes_data['address'];

						$apt_unit_pickup =(isset($session_data->apt_unit_pickup)) ? $session_data->apt_unit_pickup : $pickup_empty_boxes_data['apartment_unit_info'];

						$apartment_level_pickup =(isset($session_data->apartment_level_pickup)) ? $session_data->apartment_level_pickup : $pickup_empty_boxes_data['floor_level'];
					}

					//$deliver_empty_boxes_data['address']

					//$order_type =  $data['order_type'];
					$product_data = get_package_data($data['product_id']);

					if($data['order_type']=="RENTAL"){
						/*if($data['product_id']!=0){
							//echo "in else";
							$product_display_name = $product_data['product_name']." Package - ".$product_data['box_count']." Boxes (".$product_data['product_range'].")";

							$product_display_period = $display_period." ".$dp_period;

							$product_box_count = $product_data['box_count']." ReBow™ Boxes";

							$product_nestable_dollies_count = $product_data['nestable_dollies_count']." Nestable ReBow™ Dollies";

							$product_labels_count = $product_data['zipties_count']." Labels";

							$product_zipties_count = $product_data['zipties_count']." Security Zip Ties";

						}else{

							$product_display_name = $data['added_box_count']." Boxes";

							$product_display_period = $dp_period." ".$display_period;

							$product_box_count = $data['added_box_count']." ReBow™ Boxes";

							$product_nestable_dollies_count = ($data['added_box_count']/4)." Nestable ReBow™ Dollies";

							$product_labels_count = $data['added_box_count']." Labels";

							$product_zipties_count = $data['added_box_count']." Security Zip Ties";
						}*/
					}else{

						$storage_start_date = $delivery_date;

						$storage_end_date = $pickup_date;

						$storage_period = $period_data_value;

						$storage_facility_location ="141 W Avenue 34, Los Angeles, CA 90031";

						$box_count = $added_box_no;
						/*if($data['product_id']!=0){
							$product_name = $product_data['product_name'];

							$box_count = $product_data['box_count'];
						}else{
							$box_count = $product_data['box_count'];
						}*/

					}


				?>
		        <!-- Order Details -->
		        <div class="row">
		          <div class="blue-bg w mx-3 py-2 pl-4">
		            <div class="row">
		              <div class="col-sm-12 py-2 o-summary">
		                <small class="pl-2 white-color">ORDER DETAILS</small>
		                <div class="edit float-right pr-3">
		                  <em><a id="edit_order_details" href="/rebow/add-moreboxes/">Edit</a></em>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <?php if($data['order_type']=="RENTAL"){?>
		        <div class="row col-order col-order-details">
		          	<div class="col-sm-12">
			            <div class="grey-bg py-4 px-5">
			              	<div class="row">
				                <div class="col-sm-12">
				                  	<label class="ax-md" for=""><?php echo $added_box_no;?> ReBow™ Boxes</label>
				                </div>
				                <div class="col-sm-12">
				                  	<div class="row-form">
					                    <div class="col-from-field">
					                       <p><?php echo ucwords(strtolower($breadcrumb2));?> :</p>
					                    </div>
					                    <div class="col-from-field">
					                       <label class="ax-md" for=""><?php echo $period_data_value;?></label>
					                    </div>
				                  	</div>
				                </div>
				                <div class="col-sm-12 order-details">
				                  	<div class="row-form">
				                     	<div class="col-from-field">
					                        <small>
					                          <em>Includes : </em>
					                        </small>
					                        <ul class="includs">
					                          <li><?php echo ($added_box_no/4);?> Nestable Dollies</li>
					                          <li><?php echo ($added_box_no);?> Labels</li>
					                          <li><?php echo ($added_box_no);?> Security Zip Ties</li>
					                        </ul>
				                     	</div>
				                  	</div>
				                </div>
			              	</div>
			            </div>
		          	</div>
		        </div>
		    	<?php }else{?>
		    		<div class="row col-order col-order-details">
		          	<div class="col-sm-12">
			            <div class="grey-bg py-4 px-5">
			              	<div class="row">
				                <div class="col-sm-12">
				                  	<label class="ax-md" for=""><?php echo "Storage Start Date: ".get_custom_formatted_date($storage_start_date);?></label>
				                </div>
				                <div class="col-sm-12">
				                  	<label class="ax-md" for=""><?php echo "Storage End Date: ".get_custom_formatted_date($storage_end_date);?></label>
				                </div>
				                <div class="col-sm-12">
				                  	<div class="row-form">
					                    <div class="col-from-field">
					                       <p><?php echo $breadcrumb2;?> :</p>
					                    </div>
					                    <div class="col-from-field">
					                       <label class="ax-li" for=""><?php echo $storage_period;?></label>
					                    </div>
				                  	</div>
				                </div>
				                <div class="col-sm-12">
				                  	<label class="ax-md" for=""><?php echo "Storage Facility Location :  ".$storage_facility_location;?></label>
				                </div>

				                <div class="col-sm-12">
				                  	<label class="ax-md" for=""><?php echo "Number of Boxes in Storage : ".$box_count;?> Boxes</label>
				                </div>
			              	</div>
			            </div>
		          	</div>
		        </div>
		    	<?php } ?>
		        <!-- Payment Information -->
		        <div class="row">
		          <div class="blue-bg w mx-3 py-2 pl-4">
		            <div class="row">
		              <div class="col-sm-12 py-2 o-summary">
		                <small class="pl-2 white-color">PAYMENT INFORMATION</small>
		                <div class="edit float-right pr-3">
		                  <em><a id="edit_payment_details" onclick="hide_fields(<?php echo $payments_data['payment_id'];?>)" href="#javascript;" data-toggle="modal" data-target="#myModal2">Edit</a></em>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="row col-order payment-info">
		          <div class="col-sm-12">
		            <div class="grey-bg py-4 px-5">
		              <div class="row">
		                <div class="col-sm-12">
		                  <div class="row-form">
		                      <div class="col-from-field p-0">
		                        <p>Credit Card :</p>
		                      </div>
		                      <div class="col-from-field p-0">
		                        <label for="">**************<?php echo $Card_Number;?></label>
		                      </div>
		                  </div>
		                </div>
		                <div class="col-sm-12">
		                    <div class="row-form">
		                       <div class="col-from-field p-0">
		                          <p>Expiration : </p>
		                       </div>
		                       <div class="col-from-field p-0">
		                         <label for="">**/**</label>
		                       </div>
		                    </div>
		                    <div class="row-form">
		                       <div class="col-from-field p-0">
		                         <p>CCV :</p>
		                       </div>
		                       <div class="col-from-field p-0">
		                         <label for="">***</label>
		                       </div>
		                    </div>
		                     <div class="row-form">
		                       <div class="col-from-field billing">
		                        <p>Billing Address :</p>
		                         <address>
		                           <?php echo $billing_address;?>
		                         </address>
		                       </div>
		                     </div>
		                </div>
		                </div>
		            </div>
		            </div>
		          </div>
		          <!-- DELIVERY & PICK UP DETAILS  -->
		        <div class="row">
		          <div class="blue-bg w mx-3 py-2 pl-4">
		            <div class="row">
		              <div class="col-sm-12 py-2 o-summary">
		                <small class="pl-2 white-color">DELIVERY & PICK UP DETAILS </small>
		                <div class="edit float-right pr-3">
		                  <em><a id="edit_delivery_pickup_details" href="/rebow/add-more-boxes-pickup-delivery/">Edit</a></em>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="row col-order">
		          <div class="col-sm-12">
		            <div class="grey-bg py-4 px-5">
		              <div class="row">
		                <div class="col-sm-12 col-md-6">
		                  <div class="row-form">
		                    <div class="col-from-field">
		                      <p>Delivery Address  : </p>
		                      <address>
		                        <?php echo $delivery_address;?><br>
		                        <?php echo $apt_unit_delivery;?>
		                      </address>
		                    </div>
		                  </div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>Delivery Date :</p>
		                    </div>
		                    <div class="col-from-field">
		                      <label for=""><?php echo get_custom_formatted_date($delivery_date);?></label>
		                    </div>
		                  </div>
		                  <div class="clearfix"></div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>Optional Delivery Times : </p>
		                      <label for=""><?php echo str_replace("_"," ",$preferred_delivery_time);?></label>
		                      <p>or </p>
		                      <label for=""><?php echo str_replace("_"," ",$alternate_delivery_time);?></label>
		                    </div>
		                  </div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>*We will confirm these times with you<br> within 24-48 hours after your order</p>
		                    </div>
		                  </div>
		                </div>
		                <div class="col-sm-12 col-md-6">
		                  <div class="row-form">
		                    <div class="col-from-field">
		                      <p>Pickup Address  : </p>
		                      <address>
		                        <?php echo $pickup_address;?><br>
		                        <?php echo $apt_unit_pickup;?>
		                      </address>
		                    </div>
		                  </div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>Pickup Date :</p>
		                    </div>
		                    <div class="col-from-field">
		                      <label for=""><?php echo get_custom_formatted_date($pickup_date);?></label>
		                    </div>
		                  </div>
		                  <div class="clearfix"></div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>Optional Pickup Times : </p>
		                      <label for=""><?php echo str_replace("_"," ",$preferred_pickup_time);?></label>
		                      <p>or </p>
		                      <label for=""><?php echo str_replace("_"," ",$alternate_pickup_time);?></label>
		                    </div>
		                  </div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>*We will confirm these times with you<br> within 24-48 hours after your order</p>
		                    </div>
		                  </div>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <!-- Total  -->
		        <div class="col-subtotal-total my-5 pl-3">
		          <div class="row">
		            <div class="col-sm-12">
		              <div class="row-form">
		                <div class="col-from-field">
		                  <p>Subtotal :</p>
		                </div>
		                <div class="col-from-field">
		                  <label>$<?php echo $subtotal;?></label>
		                </div>
		              </div>
		              <div class="row-form">
		                <div class="col-from-field p-0">
		                  <p>Delivery: </p>
		                </div>
		                <div class="col-from-field p-0">
		                  <label><?php 
		                  	if($delivery_cost==0){
		                  		$delivery_cost_text= "Free";
		                  	}else if($delivery_cost==25){
		                  		$delivery_cost_text= "Elevator";
		                  	}else if($delivery_cost==50){
		                  		$delivery_cost_text= "Stairs";
		                  	}
		                  	echo $delivery_cost_text;?>
		                  	
		                </label>
		                </div>
		              </div>
		              <div class="row-form">
		                <div class="col-from-field p-0">
		                  <p>Pick Up : </p>
		                </div>
		                <div class="col-from-field p-0">
		                <label><?php 
		                  	if($pickup_cost==0){
		                  		$pickup_cost_text= "Free";
		                  	}else if($pickup_cost==25){
		                  		$pickup_cost_text= "Elevator";
		                  	}else if($pickup_cost==50){
		                  		$pickup_cost_text= "Stairs";
		                  	}
		                  	echo $pickup_cost_text;?>
		                  	
		                </label>
		                </div>
		              </div>
		              <div class="row-form">
		                <div class="col-from-field pb-0">
		                  <p>Sales Tax: </p>
		                </div>
		                <div class="col-from-field pb-0">
		                  <label>$<?php echo $sales_tax=round($sales_tax,2);?></label>
		                </div>
		              </div>
		              <div class="row-form total">
		                <div class="col-from-field p-0">
		                  <p>Total :</p> 
		                </div>
		                <div class="col-from-field p-0">
		                  <label>$<?php echo $total_price=round($total_price,2);?></label>
		                </div>
		                <div class="clearfix"></div>
		                <div class="col-from-field">
		                  <label class="control control-checkbox">You confirm that the changes above are correct and you agree to let<br> ReBow charge the card ending in <?php echo substr($payments_data['Card_Number'],-4);?> for : $<?php echo $total_price;?>
		                    <input id="confirm_order" type="checkbox"/>
		                    <div class="control-indicator"></div>
		                  </label>
		                </div>
		                <div class="clearfix"></div>
		                <div class="col-from-field">
		                  <button type="button" class="submit_order3 btn btn-secondary">Submit Order</button>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>

		      </div>
		    </div>
		  </div>
		</section>
		<div id="myModal2" class="modal fade" role="dialog2">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        
		        <h4 class="modal-title">Add New Payment:</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>
		      <div class="modal-body">
		      	<form class="checkout-form form" id="add_new_payment_form">
                <?php //if($user_status!=1){?>
                <div id="new_user_checkout">
                  <div class="form-row add_pay">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputAddress">Payment Type :</label>
	                    </div>
                  	</div>
                  	<div class="form-row add_pay">
                    	<div class="form-group col-md-5">
                      		<div class="selectholder">
	                      		<label>Payment Type</label>
	                     		<select id="payment_type" required>
									<option value="">Select</option>
									<option value="Mastercard">Mastercard</option>
									<option value="Visa">Visa</option>
									<option value="American_Express">American Express</option>
									
								</select>
								<input type="hidden" id="rowid" value=""/>
                      		</div>
                    	</div>
                  	</div>
                  	<div class="form-row add_pay">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">First Name:</label>
	                    </div>
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">Last Name:</label>
	                    </div>
	                </div>
                  	<div class="form-row add_pay">
	                    <div class="form-group col-md-6">
	                      	<input type="text" class="form-control" id="firstName" value="<?php echo $firstName;?>" placeholder="First Name" required>
	                    </div>
	                    <div class="form-group col-md-6">
	                      	<input type="text" class="form-control" id="lastName" required value="<?php echo $lastName;?>" placeholder="Last Name">
	                    </div>
	                </div>
	                <div class="form-row ">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">Card Number:</label>
	                    </div>
	                    <div class="form-group col-md-4 mb-0">
	                      <label for="inputEmail4">CCV:</label>
	                    </div>
	                </div>
	                <div class="form-row">
	                    <div class="form-group col-md-6">
	                      	
	                      	<span id="card-number" class="form-control">
		                        <!-- Stripe Card Element -->
		                    </span>
	                    </div>
	                    <div class="form-group col-md-4">
	                      	
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
	                </div>
	                  <!--<div class="form-row">
	                    <div class="form-group col-md-8">
	                      <div id="card-element"></div>
	                    </div>
	                  </div>-->
                </div>
                
                <div class="form-row add_pay">
                  <div class="form-group col-md-12 mb-0">
                    <label for="inputEmail4">Billing Address :</label>
                  </div>
                </div>
                <div class="form-row add_pay">
                  <div class="form-group col-md-8">
                    <div class="location-pin">
                      <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
                    </div>
                    <input class="addrs" type="text" placeholder="Address*" name="billingaddress" id="billingaddress" value="<?php echo $billing_address;?>" required>
                  </div>
                </div>

               
                <button type="button" id="add_new_payment_method" name="" data-secret="<?= $intent->client_secret ?>" onclick="add_payment_info()" class="submit_order_new btn btn-secondary">Submit</button>
              </form>
		      </div>
		    </div>

		  </div>
		</div>
		<?php get_footer();?>
		<script src="https://js.stripe.com/v3/"></script>
		<!-- jQuery is used only for this example; it isn't required to use Stripe -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			var stripe = Stripe('pk_test_jtWtIVtWDtzfftY59MQaNGJQ00ZZy89Axo');
	        // cardButton.addEventListener('click', function(ev) {
	        
        	//alert(1);
        	var elements = stripe.elements();
        	// Set up Stripe.js and Elements to use in checkout form

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
	            'placeholder': 'CVC*',
	            'style': style
	        });
	        cvc.mount('#card-cvc');

	        // Card expiry
	        var exp = elements.create('cardExpiry', {
	            'placeholder': 'MM/YY',
	            'style': style
	        });
	        exp.mount('#card-exp');	

	        function hide_fields(payment_id){
				jQuery('.modal-title').text("Update Payment Info");
				jQuery('.add_pay').hide();
				alert(payment_id);
				jQuery('#rowid').val(payment_id);
				jQuery.ajax({
                  	url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                  	method : "POST",
                  	data : {ajax_request:'get_payment_method',rowid:payment_id,},
                  	success: function(result){
                      	console.log(result);
                      	
                      	var jsonobj = JSON.parse(result);
                      	console.log(jsonobj);

                      	jQuery('#firstName').val(jsonobj.First_Name);

                      	jQuery('#lastName').val(jsonobj.Last_Name);
                      	
                      	if(jsonobj.billing_address==""){
                      		jsonobj.billing_address ="Beverly Road, Los Angeles";
                      	}
                      	jQuery('#billingaddress').val(jsonobj.billing_address);

                      	//$('#pament_method_'+rowid).remove();
                      	//window.location.reload();
                  	}
                });
				//alert(jQuery(this).attr("id"));
			}
			function add_payment_info(){
				var modal_title = jQuery('.modal-title').text();
				/*if(jQuery('#payment_type').val()==''){
		            setTimeout(function(){
		              jQuery('#payment_type').focus();
		            },1000);
		            return false;
		        }
	          	if(jQuery('#billingaddress').val()==''){
		            setTimeout(function(){
		              jQuery('#billingaddress').focus();
		            },1000);
		            return false;
		        }
          
		        if(jQuery('#firstName').val()==''){
		            setTimeout(function(){
		              jQuery('#firstName').focus();
		            },1000);
		            return false;
		        }

		        if(jQuery('#lastName').val()==''){
		            setTimeout(function(){
		              jQuery('#lastName').focus();
		            },1000);
		            return false;
		        }*/
		        if(modal_title=="Update Payment Info"){

		        	var rowid = jQuery('#rowid').val();
		        	alert(rowid);
		        	jQuery.ajax({
                      	url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                      	method : "POST",
                      	data : {ajax_request:'remove_payment_method',rowid:rowid},
                      	success: function(result){
                          	//alert(result);
                          	//$('#pament_method_'+rowid).remove();
                          	//window.location.reload();
                      	}
                    });
		        }
		        var cardButton = document.getElementById('add_new_payment_method');
          
	          	var clientSecret = cardButton.dataset.secret;

	          	// Try to match bootstrap 4 styling
		        

		        var firstName = jQuery('#firstName').val();
		        
		        var billingaddress = jQuery('#billingaddress').val();
		        alert("billingaddress: "+billingaddress);
		        //var zipcode = jQuery('input[name="postal"]').val();

		        stripe.confirmCardSetup(
                clientSecret,
                {
                  payment_method: {
                    card: card,
                    billing_details: {
                    	name: firstName,
                    	address: {
                    		line1: billingaddress,
                    		//postal_code: zipcode
                    	}
                    }
                  }
                }
              	).then(function(result) {
	                if (result.error) {
	                  
	                  console.log(result);
	                  //alert("unsuccessful");
	                } else {
	                  
	                  //var user_status = jQuery('#user_status').val();
	                  	var payment_type = jQuery('#payment_type').val();
	                  	var firstName = jQuery('#firstName').val();
	                  	var lastName = jQuery('#lastName').val();
	                  	var billingaddress = jQuery('#billingaddress').val();

	                    var data = JSON.stringify(result);
	                    
	                    var datastring = "ajax_request=add_new_payment_method&firstName="+firstName+"&lastName="+lastName+"&billingaddress="+billingaddress+"&payment_type="+payment_type+"&result="+data;
	                    
	                    jQuery.ajax({
	                      	url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
	                      	method : "POST",
	                      	data : datastring,
	                      	success: function(result){
	                          	console.log(result);
	                          	window.location.reload();
	                      	}
	                    });
	                  
	                }
	            });
			}
			jQuery('.submit_order3').click(function(){

				if(!jQuery('#confirm_order').is(":checked")){
		            alert('Please select the checkbox');
		            
		            setTimeout(function(){
		              jQuery('#confirm_order').focus();
		            },1000);
		            return false;
		        }

				var datastring = "ajax_request=order_confirmation_added_boxes";
				jQuery.ajax({
					url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
					method : "POST",
					data : datastring,
					success: function(result){

					    console.log(result);
					    var jsonObj = JSON.parse(result);
					    console.log(jsonObj);

					    //jQuery('#new_order_id').val(jsonObj.order_id);
					    jQuery(location).attr('href', '/rebow/order-confirmation2/');
					}
				});

			});

			jQuery('#edit_order_details').click(function(){
				jQuery(location).attr('href', '/rebow/add-moreboxes/');
			});
			jQuery('#edit_payment_details').click(function(){
				
			});

			jQuery('#edit_delivery_pickup_details').click(function(){
				jQuery(location).attr('href', '/rebow/add-more-boxes-pickup-delivery/');
			});
			
		</script>
	</body>
</html>