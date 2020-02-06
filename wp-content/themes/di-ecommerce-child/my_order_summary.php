<?php /* Template Name: my_orders_summary1*/ ?>
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
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<h5>Welcome <?php echo (wp_get_current_user()->display_name);
					$user_id = wp_get_current_user()->id;
				?></h5>
			</div>
			<div class="row">
				<div class="col-md-3">
					<ul>
						<li><a href="#">MY ORDERS</a></li>
						<li><a href="/rebow/my-information/">MY INFORMATION</a></li>
						<li><a href="/rebow/payment-information/">PAYMENT INFO</a></li>
						<li><a href="/rebow/support/">SUPPORT</a></li>
					</ul>
				</div>
				<div class="vl"></div>
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
				<div class="col-md-8">
					<h2>MY ORDERS > ORDER #<?php echo $current_order_id;?></h2>
					<br/>

					<span><b>Order # <?php echo $current_order_id;?>: <?php echo $payments_data['status_text'];?></b></span>

					<br/>
					<?php
					if($data['parent_order_id']!=0){
						echo "<b>NOTE: </b> This order is in addition to: #".$data['parent_order_id'];
					}
					?>
					<br/>
					<span><b>Order Date: <?php echo date($data['created_at']);?></b></span>

					<div id="product_info">
						<?php if($data['product_id']!=0){?>
							
							<?php if($product_data['product_name']!='Custom Order'){?>
							<b><?php echo $product_data['product_name']." Package - ".$product_data['box_count']." Boxes".$product_data['product_range'];?></b>
							<ul>
								Includes*
								<li><?php echo $product_data['box_count'];?> ReBow™ Boxes</li>
								<li><?php echo $product_data['nestable_dollies_count'];?> Nestable ReBow™ Dollies</li>
								<li><?php echo $product_data['lables_count'];?> Labels</li>

								<li><?php echo $product_data['zipties_count'];?> Security Zip Ties</li>
							</ul>
						<?php }else{?>
							<b><?php echo $product_data['product_name']." Package - ".$data['box_count']." Boxes";?></b>
							<ul>
								Includes*
								<li><?php echo $data['box_count'];?> ReBow™ Boxes</li>
								<li><?php echo ($data['box_count']/4);?> Nestable ReBow™ Dollies</li>
								<li><?php echo $data['box_count'];?> Labels</li>

								<li><?php echo $data['box_count'];?> Security Zip Ties</li>
							</ul>
						<?php }?>	
						<?php }else{?>
							<b><?php echo $data['added_box_count']." Boxes";?></b>
							<span><b><?php echo $data['order_type']." Period: ";?><?php echo $data['order_time_period'];?></b></span>
							<ul>
								Includes*
								<li><?php echo ($data['added_box_count']);?> ReBow™ Boxes</li>
								<li><?php echo ($data['added_box_count']/4);?> Nestable ReBow™ Dollies</li>
								<li><?php echo $data['added_box_count'];?> Labels</li>

								<li><?php echo $data['added_box_count'];?> Security Zip Ties</li>
							</ul>
						<?php }?>
					</div>
					<button type="submit" id="add_more_boxes" class="btn btn-secondary">Add more boxes</button>
					<span><b><?php echo $data['order_type']." Period: ";?><?php echo $data['order_time_period'];?></b></span>
					<div>
						<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;"><span style="color: white;align:left;"><?php echo $data['order_type']." DETAILS";?></span>
							<span id="change_pickup_delivey_dates" style="color: white;align:right;" href="">Change</span>
						</div>
						<?php if($data['order_type']=="RENTAL"){?>
							<span><b><?php echo $data['order_type']." Start Date";?></b>:<?php echo $deliver_empty_boxes_data['date'];?></span>
							<br/>
							<span><b><?php echo $data['order_type']." End Date";?></b>:<?php echo $pickup_empty_boxes_data['date'];?></span>

						<?php }else{?>
							<span><b><?php echo $data['order_type']." Start Date";?></b>:<?php echo $deliver_empty_boxes_data['date'];?></span>
							<br/>
							<span><b><?php echo $data['order_type']." End Date";?></b>:<?php echo $pickup_empty_boxes_data['date'];?></span>
							<span>Storage Facility Location :  141 W Avenue 34, Los Angeles, CA 90031</span>
							<span>Number of Boxes in Storage : <?php echo $data['box_count'];?></span>
						<?php }?>
					</div>
					<div>
						<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;"><span style="color: white;align:left;">Delievery & Pickup Details</span>
							<span id="change_delivery_pickup_info" style="color: white;align:right;">Change</span>
						</div>
						
						<div class="row">
							<?php if($data['order_type']=="RENTAL"){?>
							<div class="col-md-6">
								<span>Delivery Address  :</span><br/>
								<span><?php echo $deliver_empty_boxes_data['address'];?></span>
								<span>Delivery Date :<?php echo get_custom_formatted_date($deliver_empty_boxes_data['date']);?></span><br/>
								<span>Optional Delivery Time :</span><br/>
								<span><?php echo str_replace("_"," ",$deliver_empty_boxes_data['preferred_time']);?></span><br/>
								<span><?php echo str_replace("_"," ",$deliver_empty_boxes_data['alternative_time']);?></span><br/>
								*We will confirm these times with you within 24-48 hours after your order
							</div>
							</div class="col-md-6">
								<span>Pickup Address  :</span><br/>
								<span><?php echo $pickup_empty_boxes_data['address'];?></span>
								<span>Delivery Date :<?php echo get_custom_formatted_date($pickup_empty_boxes_data['date']);?></span><br/>
								<span>Optional Delivery Time :</span><br/>
								<span><?php echo str_replace("_"," ",$pickup_empty_boxes_data['preferred_time']);?></span><br/>
								<span><?php echo str_replace("_"," ",$pickup_empty_boxes_data['alternative_time']);?></span><br/>
								*We will confirm these times with you within 24-48 hours after your order
							</div>
						<?php }else{?>
								<div class="col-md-6">
								<span>Delivery Address  :</span><br/>
								<span><?php echo $deliver_empty_boxes_data['address'];?></span>
								<span>Delivery Date :<?php echo $deliver_empty_boxes_data['date'];?></span><br/>
								<span>Optional Delivery Time :</span><br/>
								<span><?php echo str_replace("_"," ",$deliver_empty_boxes_data['preferred_time']);?></span><br/>
								<span><?php echo str_replace("_"," ",$deliver_empty_boxes_data['alternative_time']);?></span><br/>
								*We will confirm these times with you within 24-48 hours after your order
							</div>
							</div class="col-md-6">
								<span>Pickup Address  :</span><br/>
								<span><?php echo $pickup_empty_boxes_data['address'];?></span>
								<span>Delivery Date :<?php echo $pickup_empty_boxes_data['date'];?></span><br/>
								<span>Optional Delivery Time :</span><br/>
								<span><?php echo str_replace("_"," ",$pickup_empty_boxes_data['preferred_time']);?></span><br/>
								<span><?php echo str_replace("_"," ",$pickup_empty_boxes_data['alternative_time']);?></span><br/>
								*We will confirm these times with you within 24-48 hours after your order
							</div>
						<?php }?>
						</div>
					</div>
						<div class="rectangle justify-content-md-center" style="height: 59px;border:1px solid black;background-color: #002F6C;"><span style="color: white;align:left;">PAYMENT DETAILS</span>
							<a style="color: white;align:right;" href="">Change</a>
						</div>
						<span><b>Subtotal:</b> <?php echo ($data['product_price']+$data['added_box_price']);?></span><br/>
						<span><b>Delivery :</b> <?php echo ($data['delivery_cost']);?></span><br/>
						
						<span><b>Pickup :</b> <?php echo ($data['pickup_cost']);?></span><br/>
						
						<span><b>Sales Tax :</b> <?php echo ($data['sales_tax']);?></span><br/>

						<span><b>Total :</b> <?php echo ($data['total_price']);?></span><br/>
						<span>Your card ending in <?php echo substr($payments_data['Card_Number'],-4)?> was charged <?php echo ($data['total_price']);?></span>
				</div>	
			</div>
		</div> 
		<?php get_footer();?>
		<script>
			jQuery(document).ready(function() {
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