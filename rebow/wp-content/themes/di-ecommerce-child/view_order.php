<?php /* Template Name: view_order*/ ?>
<?php require_once("user_check_login.php");?>
<?php require_once("db_config.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php require_once('session_values.php');
		//print_r($session_data);
		get_header();?>
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
				<?php 
					
					$query = "select * from orders_data where order_id=".$current_order_id;
					$res = mysql_query($query);
					//echo "in query";
					$data = mysql_fetch_assoc($res);
					if($data['parent_order_id']!=0){
						$payments_data = get_payments_data($current_order_id);
					}else{
						$payments_data = get_payments_data_user($user_id);
					}

					$tansactions_data = get_transactions_data($current_order_id);

					function get_transactions_data($current_order_id){
						
						$query = "SELECT * from transactions where order_id=$current_order_id";

						$res = mysql_query($query);

						$row = mysql_fetch_assoc($res);

						return $row;
					}
					if($data['order_type']=="RENTAL"){
						$shipping_type = 'Delivery Empty Boxes';
						$deliver_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

						$shipping_type = 'Pickup Empty Boxes';
						$pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

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
					}

					$product_data = get_package_data($data['product_id']);
					//print_r($product_data);

				?>
		      <div class="rhs-account mb-5 view-order">
		        <div class="row justify-content-left">
		          <div class="col-sm-12 mb-2">
		            <!-- Start order bredcrumb-->
		            <ul class="order-breadcrumb">
		              <li><a href="">MY ORDERS</a></li>
		              <li><a href="">ORDER # <?php echo $current_order_id;?></a></li>
		            </ul>
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
		        <div class="row col-order">
		          <div class="col-sm-12 p-5">
		            <div class="row">
		              <div class="col-12">
		                <label for="">Order #<?php echo $current_order_id;?> :</label>
		                <p><?php echo $tansactions_data['transaction_status'];?></p>
		              </div>
		            </div>
		            <div class="row">
		              <div class="col-12">
		                <label for="">Date Ordered:</label>
		                <p><?php $date=date_create($data['created_at']);
							echo date_format($date,"M d, Y"); //echo date($data['created_at']);?></p>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="row">
		          <div class="col-sm-12 col-md-4 pl-5">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/dollies.png" alt="">
		            <div class="clearfix"></div>
		            <button type="submit" id="add_more_boxes" class="btn btn-secondary mt-4">ADD REBOW BOXES</button>
		          </div>
		          <div class="col-sm-12 col-md-5 pl-5 order-details">
		            <?php if($data['product_id']!=0){?>
						<?php if($product_data['product_name']!='Custom Order'){?>
							<p><?php echo ucwords(strtolower($product_data['product_name']))." Package - ".$product_data['box_count']." Boxes"."<br/>(".$product_data['product_range'].")";?></p>
							<p><?php echo ucfirst(strtolower($data['order_type']));?> Period : <?php echo $data['order_time_period'];?></p>
							<ul class="pkg-info">
								<em>Includes:</em>
								<li><em><?php echo $product_data['box_count'];?> ReBow™ Boxes</em></li>
								<li><em><?php echo $product_data['nestable_dollies_count'];?> Nestable ReBow™ Dollies</em></li>
								
								<li><em><?php echo $product_data['zipties_count'];?> Security Zip Ties</em></li>
								<li><em><?php echo $product_data['box_count'];?> Labels</em></li>

							</ul>
						<?php }else{?>
							<p><?php echo $product_data['product_name']." Package - ".$data['box_count']." Boxes";?></p>
							<ul class="pkg-info">
								Includes:
								<li><em><?php echo $data['box_count'];?> ReBow™ Boxes</em></li>
								<li><em><?php echo ($data['box_count']/4);?> Nestable ReBow™ Dollies</em></li>
								<li><em><?php echo $data['box_count'];?> Security Zip Ties</em></li>
								<li><em><?php echo $data['box_count'];?> Labels</em></li>
							</ul>
						<?php }?>	
					<?php }else{?>
						<p><?php echo $data['added_box_count']." Boxes";?></p>
						<p><?php echo $data['order_type']." Period: ";?><?php echo $data['order_time_period'];?></p>
						<ul class="pkg-info">
							Includes:
							<li><em><?php echo ($data['added_box_count']);?> ReBow™ Boxes</em></em></li>
							<li><em><?php echo ($data['added_box_count']/4);?> Nestable ReBow™ Dollies</li>
							<li><em><?php echo $data['added_box_count'];?> Labels</em></li>

							<li><em><?php echo $data['added_box_count'];?> Security Zip Ties</em></li>
						</ul>
					<?php }?>
		          </div>
		        </div>
		        <div class="storage-details mt-5 mb-3">
		          <div class="row">
		            <div class="col-sm-12">
		              <div class="grey-bg py-4 dt">
		                <div class="row">
		                  <div class="col-sm-10 dtc">
		                    <img class="pl-5" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/storage.png" alt="">
		                    <p class="txt-grey"><?php echo $data['order_type'];?> DETAILS </p>
		                  </div>
		                  <div class="col-sm-2">
		                    <em id="change_pickup_delivey_dates"class="txt-blue">CHANGE</em>
		                  </div>
		                </div>
		              </div>
		            </div>
		            <?php if($data['order_type']=="RENTAL"){?>
		            <div class="col-sm-12 mt-4">
		            
		              <div class="row">
		                <div class="col-sm-12 col-md-6 st-details pl-5">
		                  <p>Rental Start Date : </p>
		                  <label for=""><?php 
		                  	$date=date_create($deliver_empty_boxes_data['date']);
							echo date_format($date,"M d, Y");
		                  //echo $deliver_empty_boxes_data['date'];?></label>
		                </div>
		                <div class="col-sm-12 col-md-6 st-details pl-5">
		                  <p>Rental End Date : </p>
		                  <label for=""><?php 
		                  	$date=date_create($pickup_empty_boxes_data['date']);
							echo date_format($date,"M d, Y");
		                  //echo $pickup_empty_boxes_data['date'];?></label>
		                </div>
		              </div>
		             
		            </div>
		            <?php }else{?>
		            <div class="col-sm-12 mt-4">
		            
		              <div class="row">
		                <div class="col-sm-12 col-md-6 st-details pl-5">
		                  <p>Storage Start Date : </p>
		                  <p for=""><?php 
		                  	$date=date_create($deliver_empty_boxes_data['date']);
							echo date_format($date,"M d, Y");	

		                  //echo $deliver_empty_boxes_data['date'];?></p>
		                </div>
		                <div class="col-sm-12 col-md-6 st-details pl-5">
		                  <p>Storage End Date : </p>
		                  <p for=""><?php 
		                  	$date=date_create($pickup_empty_boxes_data['date']);
							echo date_format($date,"M d, Y");
		                  //echo $pickup_empty_boxes_data['date'];?></p>
		                </div>
		              </div>
		              <div class="row">
		                <div class="col-sm-12 st-details pl-5">
		                  <p>Storage Facility Location : </p>
		                  <p for="">141 W Avenue 34, Los Angeles, CA 90031</p>
		                </div>
		              </div>
		              <div class="row">
		                <div class="col-sm-12 st-details pl-5">
		                  <p>Number of Boxes in Storage : </p>
		                  <p for=""> <?php echo $data['box_count'];?> Boxes</p>
		                </div>
		              </div>

		              <div class="row">
		                <div class="col-sm-12">
		                <div class="blue-bg m-3 p-3">
		                  <p>We provide a  48 hour complimentary window to pack and unpack. If you adjust the storage time above that will be reflected below. <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/white-question-mark.png" alt=""> Want to keep your ReBow boxes longer ? <strong>Call Us : 322 - 277 - 1111</strong></p>
		                </div>
		                </div>
		              </div>
		            </div>
		            <?php }?>
		          </div>
		        </div>
		        <div class="storage-details">
		          <div class="col-sm-12">
		              <div class="grey-bg py-3 dt">
		                <div class="row">
		                  <div class="col-sm-10 dtc">
		                    <img class="pl-5" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
		                    <p class="txt-grey">DELIVERY & PICK UP DETAILS</p>
		                  </div>
		                  <div class="col-sm-2">
		                    <em id="change_delivery_pickup_info" class="txt-blue">CHANGE</em>
		                  </div>
		                </div>
		              </div>
		            </div>
		            <?php if($data['order_type']=="STORAGE"){?>
		            <!-- Itesm going to storage -->
		            <div class="row justify-content-center">
		              <div class="col-sm-12 dt">
		                <div class="dtc px-5">
		                  <img class="mt-3" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/item-going.png" alt="">
		                  <p>ITEMS GOING INTO STORAGE </p>
		                </div>
		              </div>
		              <div class="col-sm-12">
		                <hr>
		              </div>
		            </div>
		            <div class="row justify-content-center mt-4">
		              <div class="col-sm-12 col-md-5">
		                <h6 class="text-center">DELIVERY OF YOUR REBOW ORDER :</h6>
		                <div class="grey-bg p-4">
		                  <div class="st-details">
		                      <p>Scheduled Delivery* :</p>
		                      <label for=""><?php 
		                      	$date=date_create($deliver_empty_boxes_data['date']);
								echo date_format($date,"M d, Y");
		                      //echo $deliver_empty_boxes_data['date'];?></label>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Window :</p>
		                      <label for=""><?php echo str_replace("_"," ",$deliver_empty_boxes_data['preferred_time']);?></label>
		                    </div>
		                    <div class="st-details">
		                        <p>Delivery Address  :</p>
		                        <div class="clearfix"></div>
		                        <address>
		                          <?php echo $deliver_empty_boxes_data['address'];?><br>
		                          <?php echo $deliver_empty_boxes_data['apartment_unit_info'];?>
		                        </address>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Notes :</p>
		                      <label for=""><?php echo $deliver_empty_boxes_data['floor_level'];?></label>
		                    </div>
		                </div>
		              </div>
		              <div class="col-sm-12 col-md-5">
		                <h6>PICK UP REBOW BOXES FOR STORAGE :</h6>
		               <div class="grey-bg p-4">
		                 <div class="st-details">
		                      <p>Scheduled Delivery* :</p>
		                      <label for="">
		                      	<?php 
		                      	$date=date_create($pickup_packed_boxes_data['date']);
								echo date_format($date,"M d, Y"); 
		                      	//echo $pickup_packed_boxes_data['date'];?></label>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Window :</p>
		                      <label for=""><?php echo str_replace("_"," ",$pickup_packed_boxes_data['preferred_time']);?></label>
		                    </div>
		                    <div class="st-details">
		                        <p>Delivery Address  :</p>
		                        <div class="clearfix"></div>
		                        <address>
		                          <?php echo $pickup_packed_boxes_data['address'];?> <br>
		                          <?php echo $pickup_packed_boxes_data['apartment_unit_info'];?>
		                        </address>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Notes :</p>
		                      <label for=""><?php echo $pickup_packed_boxes_data['floor_level'];?></label>
		                    </div>
		               </div>
		              </div>
		            </div>
		            
		            <!-- Itesm moving to storage -->
		            <div class="row justify-content-center mt-4">
		              <div class="col-sm-12 dt">
		                <div class="dtc px-5">
		                  <img class="mt-3" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/item-moving.png" alt="">
		                  <p>ITEMS MOVING OUT OF STORAGE</p>
		                </div>
		              </div>
		              <div class="col-sm-11">
		                <hr>
		              </div>
		            </div>
		            <div class="row justify-content-center mt-4">
		              <div class="col-sm-12 col-md-5">
		                <h6 class="text-center">DELIVERY OF STORED ITEMS:</h6>
		                <div class="grey-bg p-4">
		                  <div class="st-details">
		                      <p>Scheduled Delivery* :</p>
		                      <label for=""><?php 
		                      	$date=date_create($delivery_packed_boxes_data['date']);
								echo date_format($date,"M d, Y");
		                      // echo $delivery_packed_boxes_data['date'];?></label>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Window :</p>
		                      <label for=""><?php echo str_replace("_"," ",$delivery_packed_boxes_data['preferred_time']);?></label>
		                    </div>
		                    <div class="st-details">
		                        <p>Delivery Address  :</p>
		                        <div class="clearfix"></div>
		                        <address>
		                          <?php echo $delivery_packed_boxes_data['address'];?> <br>
		                          <?php echo $delivery_packed_boxes_data['apartment_unit_info'];?>
		                        </address>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Notes :</p>
		                      <label for=""><?php echo $delivery_packed_boxes_data['floor_level'];?></label>
		                    </div>
		                </div>
		              </div>
		              <div class="col-sm-12 col-md-5">
		                <h6>PICK UP EMPTY REBOW BOXES :</h6>
		               <div class="grey-bg p-4">
		                 <div class="st-details">
		                      <p>Scheduled Delivery* :</p>
		                      <label for=""><?php 
		                      $date=date_create($pickup_empty_boxes_data['date']);
								echo date_format($date,"M d, Y");
		                      //echo $pickup_empty_boxes_data['date'];?></label>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Window :</p>
		                      <label for=""><?php echo str_replace("_"," ",$pickup_empty_boxes_data['preferred_time']);?></label>
		                    </div>
		                    <div class="st-details">
		                        <p>Delivery Address  :</p>
		                        <div class="clearfix"></div>
		                        <address>
		                          <?php echo $pickup_empty_boxes_data['address'];?> <br>
		                          <?php echo $pickup_empty_boxes_data['apartment_unit_info'];?>
		                        </address>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Notes :</p>
		                      <label for=""><?php echo $pickup_empty_boxes_data['floor_level'];?></label>
		                    </div>
		               </div>
		              </div>
		            </div>
		            <!--start Note -->
		            <div class="row">
		              <div class="col-sm-12 my-5">
		                <div class="dark-grey-bg">
		                <p class="note">* Note : Any changes made to delivery time, or location must be done Monday - Friday 48 hours in advance of delivery time and date.  Example  : If delivery is scheduled for 2pm on Monday, all changes must be adjusted before Friday at 2pm.</p>
		                </div>
		              </div>
		            </div>
		        <?php }else{?>
		        	
		        	<div class="row justify-content-center mt-4">
		              <div class="col-sm-12 col-md-5 mt-4">
		                <h6 class="text-center">DELIVERY OF YOUR REBOW ORDER :</h6>
		                <div class="grey-bg p-4">
		                  <div class="st-details">
		                      <p>Scheduled Delivery* :</p>
		                      <label for=""><?php 
		                      	$date=date_create($deliver_empty_boxes_data['date']);
								echo date_format($date,"M d, Y");
		                      //echo $deliver_empty_boxes_data['date'];?></label>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Window :</p>
		                      <label for=""><?php echo str_replace("_"," ",$deliver_empty_boxes_data['preferred_time']);?></label>
		                    </div>
		                    <div class="st-details">
		                        <p>Delivery Address  :</p>
		                        <div class="clearfix"></div>
		                        <address>
		                          <?php echo $deliver_empty_boxes_data['address'];?><br>
		                          <?php echo $deliver_empty_boxes_data['apartment_unit_info'];?>
		                        </address>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Notes :</p>
		                      <label for=""><?php echo $deliver_empty_boxes_data['floor_level'];?></label>
		                    </div>
		                </div>
		              </div>
		              <div class="col-sm-12 col-md-5 mt-4">
		                <h6>PICK UP EMPTY REBOW BOXES :</h6>
		               <div class="grey-bg p-4">
		                 <div class="st-details">
		                      <p>Scheduled Delivery* :</p>
		                      <label for=""><?php 
		                      $date=date_create($pickup_empty_boxes_data['date']);
								echo date_format($date,"M d, Y");
		                      //echo $pickup_empty_boxes_data['date'];?></label>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Window :</p>
		                      <label for=""><?php echo str_replace("_"," ",$pickup_empty_boxes_data['preferred_time']);?></label>
		                    </div>
		                    <div class="st-details">
		                        <p>Delivery Address  :</p>
		                        <div class="clearfix"></div>
		                        <address>
		                          <?php echo $pickup_empty_boxes_data['address'];?> <br>
		                          <?php echo $pickup_empty_boxes_data['apartment_unit_info'];?>
		                        </address>
		                    </div>
		                    <div class="st-details">
		                      <p>Delivery Notes :</p>
		                      <label for=""><?php echo $pickup_empty_boxes_data['floor_level'];?></label>
		                    </div>
		               </div>
		              </div>
		            </div>
		        <?php }?>
		            <!-- payments Details -->

		            <div class="row mt-4">
		              <div class="col-sm-12">
		              <div class="grey-bg py-3 dt">
		                <div class="row">
		                  <div class="col-sm-12 dtc">
		                    <img class="pl-5" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/card-icon.png" alt="">
		                    <p class="txt-grey">PAYMENT DETAILS</p>
		                  </div>
		                </div>
		              </div>
		            </div>
		            </div>
		            <div class="row my-4">
		              <div class="col-sm-12 st-details pl-5">
		                <p>Subtotal :</p>
		                <label for="">$<?php echo $data['subtotal'];?></label>
		              </div>
		              <div class="col-sm-12 st-details pl-5 pb-0">
		                <p>Delivery:</p>
		                <label for="">$<?php echo $data['delivery_cost'];?></label>
		              </div>
		              <div class="col-sm-12 st-details pl-5">
		                <p>Pick Up :</p>
		                <label for="">$<?php echo $data['pickup_cost'];?></label>
		              </div>
		              <div class="col-sm-12 st-details pl-5 pb-0">
		                <p>Sales Tax :</p>
		                <label for="">$<?php echo $data['sales_tax'];?></label>
		              </div>
		              <div class="col-sm-12 st-details pl-5">
		                <p>Total :</p>
		                <label for="">$<?php echo $data['total_price'];?></label>
		              </div>
		            </div>

		        </div>

		      </div>
		    </div>
		  </div>
		</section>
		
		<?php get_footer();?>
		<script>
			jQuery(document).ready(function() {
				jQuery("#back_btn").click(function (){
				  window.history.back();
				});
				jQuery('#change_pickup_delivey_dates').click(function(event) {
					
					//var current_id = jQuery(this).attr('id');
					//alert(current_id);
					var period_datas = "<?php echo $data['order_type'];?>";

					var product_id = "<?php echo $data['product_id'];?>";

					var added_box_count = "<?php echo $data['added_box_count'];?>";

					var pickup_cost = "<?php echo $data['pickup_cost'];?>";

					var delivery_cost = "<?php echo $data['delivery_cost'];?>";

					var added_box_price = "<?php echo $data['added_box_price'];?>";
					//alert(period_datas);
					//jQuery(location).attr('href', '/rebow/my-orders-2');

					var datastring = "ajax_request=goto_order_summary2&period_datas="+period_datas+"&product_id="+product_id+"&added_box_count="+added_box_count+"&pickup_cost="+pickup_cost+"&delivery_cost="+delivery_cost+"&added_box_price="+added_box_price+"&product_id="+product_id;
					
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    jQuery(location).attr('href', '/rebow/my-orders-2');
						    //alert(result);
						}
					});
				});
				jQuery('#add_more_boxes').click(function(event) {

					
					//jQuery(location).attr('href', '/rebow/add-moreboxes');
					var period_datas = "<?php echo $data['order_type'];?>";

					var product_id = "<?php echo $data['product_id'];?>";


					var datastring = "ajax_request=add_more_boxes1&period_datas="+period_datas+"&product_id="+product_id;
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    jQuery(location).attr('href', '/rebow/add-moreboxes');
						    //alert(result);
						}
					});
				});

				jQuery('#change_delivery_pickup_info').click(function(event) {
					var period_datas = "<?php echo $data['order_type'];?>";

					var product_id = "<?php echo $data['product_id'];?>";

					var added_box_count = "<?php echo $data['added_box_count'];?>";

					var added_box_price = "<?php echo $data['added_box_price'];?>";

					var pickup_cost = "<?php echo $data['pickup_cost'];?>";

					var delivery_cost = "<?php echo $data['delivery_cost'];?>";

					var datastring = "ajax_request=goto_order_summary2&period_datas="+period_datas+"&product_id="+product_id+"&added_box_count="+added_box_count+"&pickup_cost="+pickup_cost+"&delivery_cost="+delivery_cost+"&added_box_price="+added_box_price+"&product_id="+product_id;

					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    jQuery(location).attr('href', '/rebow/edit-delivery-pickup');
						    //alert(result);
						}
					});
				});
			});
		</script>
	</body>
</html>