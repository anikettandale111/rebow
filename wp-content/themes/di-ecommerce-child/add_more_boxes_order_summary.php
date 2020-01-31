<?php /* Template Name: add_more_boxes_order_summary*/ ?>
<?php require_once("user_check_login.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php
		require_once('session_values.php');
		get_header(); 
		//print_r($_SESSION);
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
		                <button type="" class="btn btn-small blue-bg float-right txt-white">Submit</button>
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
					}else{
						$payments_data = get_payments_data($current_order_id);
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

						$pickup_date =(isset($session_data->end_date)) ? $session_data->end_date : $pickup_empty_boxes_data['date'];

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

					//$deliver_empty_boxes_data['address']

					//$order_type =  $data['order_type'];
					$product_data = get_package_data($data['product_id']);

					if($data['order_type']=="RENTAL"){
						if($data['product_id']!=0){
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
						}
					}else{

						$storage_start_date = $delivery_date;

						$storage_end_date = $pickup_date;

						$storage_period = $data['order_time_period'];

						$storage_facility_location ="141 W Avenue 34, Los Angeles, CA 90031";

						if($data['product_id']!=0){
							$product_name = $product_data['product_name'];

							$box_count = $product_data['box_count'];
						}else{
							$box_count = $product_data['box_count'];
						}

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
				                  	<label for=""><b><?php echo $added_box_no;?> ReBow™ Boxes</b></label>
				                </div>
				                <div class="col-sm-12">
				                  	<div class="row-form">
					                    <div class="col-from-field">
					                       <p><b><?php echo $breadcrumb2;?> :</b></p>
					                    </div>
					                    <div class="col-from-field">
					                       <label for=""><?php echo $product_display_period;?></label>
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
				                  	<label for=""><b><?php echo "Storage Start Date: ".get_custom_formatted_date($storage_start_date);?></b></label>
				                </div>
				                <div class="col-sm-12">
				                  	<label for=""><b><?php echo "Storage End Date: ".get_custom_formatted_date($storage_end_date);?></b></label>
				                </div>
				                <div class="col-sm-12">
				                  	<div class="row-form">
					                    <div class="col-from-field">
					                       <p><b><?php echo $breadcrumb2;?> :</b></p>
					                    </div>
					                    <div class="col-from-field">
					                       <label for=""><?php echo $storage_period;?></label>
					                    </div>
				                  	</div>
				                </div>
				                <div class="col-sm-12">
				                  	<label for=""><b><?php echo "Storage Facility Location :  ".$storage_facility_location;?></b></label>
				                </div>

				                <div class="col-sm-12">
				                  	<label for=""><b><?php echo "Number of Boxes in Storage :  ".$product_name." - ".$box_count;?></b></label>
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
		                  <em><a id="edit_payment_details" href="">Edit</a></em>
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
		                  <label>$<?php echo $delivery_cost;?></label>
		                </div>
		              </div>
		              <div class="row-form">
		                <div class="col-from-field p-0">
		                  <p>Pick Up : </p>
		                </div>
		                <div class="col-from-field p-0">
		                  <label>$<?php echo $pickup_cost;?></label>
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
		                    <input type="checkbox"/>
		                    <div class="control-indicator"></div>
		                  </label>
		                </div>
		                <div class="clearfix"></div>
		                <div class="col-from-field">
		                  <button id="submit_order3" type="" class="btn btn-secondary">Submit Order</button>
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
		<?php get_footer();?>
		
		<script>
			
			jQuery('#submit_order3').click(function(){
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