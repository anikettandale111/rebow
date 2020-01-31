<?php /* Template Name: my_orders_change_dates*/ ?>
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

					$subtotal = (isset($session_data->subtotal)) ? $session_data->subtotal : ($data['product_price']+$data['added_box_price']);

					$delivery_cost = (isset($session_data->delivery_cost)) ? $session_data->delivery_cost : ($data['delivery_cost']);

					$pickup_cost = (isset($session_data->pickup_cost)) ? $session_data->pickup_cost : ($data['pickup_cost']);

					$sales_tax = (isset($session_data->sales_tax)) ? $session_data->sales_tax : ($data['sales_tax']);

					$total_price = (isset($session_data->total_price)) ? $session_data->total_price : ($data['total_price']);

					$total_price = (isset($session_data->total_price)) ? $session_data->total_price : ($data['total_price']);

					$pickup_date = (isset($session_data->end_date)) ? $session_data->end_date : ($pickup_empty_boxes_data['date']);
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
		            <!--<div class="row">
		              <div class="col-12">
		                <label for="">Order #<?php //echo $current_order_id;?> :</label>
		                <p><?php //echo $payments_data['payment_status'];?></p>
		              </div>
		            </div>-->
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
		          <div class="col-sm-12 col-md-4 pl-5 order-details">
		            <?php if($data['product_id']!=0){?>
						<?php if($product_data['product_name']!='Custom Order'){?>
							<p><?php echo ucfirst(strtolower($product_data['product_name']))." Package - ".$product_data['box_count']." Boxes"."<br/>".$product_data['product_range'];?></p>
							<p><?php echo ucfirst(strtolower($data['order_type']));?> Period : <?php echo $data['order_time_period'];?></p>
							<ul class="pkg-info">
								Includes*
								<li><em><?php echo $product_data['box_count'];?> ReBow™ Boxes</em></li>
								<li><em><?php echo $product_data['nestable_dollies_count'];?> Nestable ReBow™ Dollies</em></li>
								<li><em><?php echo $product_data['box_count'];?> Labels</em></li>

								<li><em><?php echo $product_data['zipties_count'];?> Security Zip Ties</em></li>
							</ul>
						<?php }else{?>
							<p><?php echo $product_data['product_name']." Package - ".$data['box_count']." Boxes";?></p>
							<ul class="pkg-info">
								Includes*
								<li><em><?php echo $data['box_count'];?> ReBow™ Boxes</em></li>
								<li><em><?php echo ($data['box_count']/4);?> Nestable ReBow™ Dollies</em></li>
								<li><em><?php echo $data['box_count'];?> Labels</em></li>

								<li><em><?php echo $data['box_count'];?> Security Zip Ties</em></li>
							</ul>
						<?php }?>	
					<?php }else{?>
						<p><?php echo $data['added_box_count']." Boxes";?></p>
						<p><?php echo $data['order_type']." Period: ";?><?php echo $data['order_time_period'];?></p>
						<ul class="pkg-info">
							Includes*
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
							<p><?php echo $data['order_type']." End Date";?></p>: <input id="end_date" type="date" value="<?php echo $pickup_date;?>"></input>
		                </div>
		              </div>
		             
		            </div>
		          </div>
		        </div>
		        
		        <!-- payments Details -->

	            <div class="row">
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
	                <label id="subtotal" for="">$<?php echo $data['subtotal'];?></label>
	              </div>
	              <div class="col-sm-12 st-details pl-5 pb-0">
	                <p>Delivery:</p>
	                <label id="delivery_cost" for="">$<?php echo $data['delivery_cost'];?></label>
	              </div>
	              <div class="col-sm-12 st-details pl-5">
	                <p>Pick Up :</p>
	                <label id="pickup_cost" for="">$<?php echo $data['pickup_cost'];?></label>
	              </div>
	              <div class="col-sm-12 st-details pl-5 pb-0">
	                <p>Sales Tax :</p>
	                <label id="sales_tax" for="">$<?php echo $data['sales_tax'];?></label>
	              </div>
	              <div class="col-sm-12 st-details pl-5">
	                <p>Total :</p>
	                <label id="total_price1" for="">$<?php echo $data['total_price'];?></label>
	              </div>
	            </div>
	            <div class="row justify-content-end my-5">
		          <div class="bottom-btn">
		            <button id="cancel" type="cancel" class="btn btn-grey mr-4">Cancel</button>
		            <button id="next" type="submit" class="btn btn-secondary">NEXT</button>
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
			jQuery("#back_btn").click(function (){
			  window.history.back();
			});
			jQuery( "#end_date" ).change(function() {

			    var start_date = jQuery('#start_date').val();
			    //alert(start_date);
			    var end_date = jQuery('#end_date').val();

			    var dayDff = get_day_diffrence(start_date,end_date);
			    //alert(dayDff);
			    price_calculation(dayDff);
			    
			});
			function get_day_diffrence(start_date,end_date){
			    var startDay = new Date(start_date);
    			var endDay = new Date(end_date);

    			var millisecondsPerDay = 1000 * 60 * 60 * 24;
			    var millisBetween = endDay.getTime() - startDay.getTime();
     			var days = millisBetween / millisecondsPerDay;

			    // Round down.
			    var dayDiff = Math.floor(days);
			    return dayDiff;
			}

			function price_calculation(dayDff){

				var previous_product_price = "<?php echo ($data['product_price']);?>";
				var previous_added_box_price = "<?php echo $data['added_box_price'];?>";
				var previous_delivery_cost = "<?php echo ($data['delivery_cost']);?>";

				var previous_pickup_cost = "<?php echo ($data['pickup_cost']);?>";

				var default_product_cost = Number(jQuery('#default_product_cost').val());
				var tax_rates = Number(jQuery('#tax_rates').val());
				var period_data_field = jQuery('#period_data_field').val();
				var box_count = Number(jQuery('#box_count_field').val());
				var added_box_count = Number(jQuery('#added_box_count_field').val());

				var delivery_cost = Number(jQuery('#delivery_cost_field').val());

				var pickup_cost = Number(jQuery('#pickup_cost_field').val());

				var tax_rates = Number(jQuery('#tax_rates').val());

				if(period_data_field=="RENTAL"){
					//alert(dayDff/7);
					var period=Math.ceil(dayDff/7);
				}

				var product_price = default_product_cost * box_count * period;

				var added_boxes_price = default_product_cost * added_box_count * period;

				product_price = product_price-previous_product_price;

				added_boxes_price = added_boxes_price-previous_added_box_price;

				var subtotal = (product_price+added_boxes_price);
				//alert(subtotal);
				console.log(subtotal);
				delivery_cost = delivery_cost-previous_delivery_cost;
				//alert(delivery_cost);
				console.log(delivery_cost);
				pickup_cost = pickup_cost-previous_pickup_cost;
				//alert(pickup_cost);
				console.log(pickup_cost);
				var total_price = subtotal+delivery_cost+pickup_cost;
				console.log(total_price);
				//alert(total_price);

				var sales_tax = (total_price*tax_rates)/100;
				console.log(sales_tax);
				total_price = total_price + sales_tax;
				console.log(total_price);

				/*SET values to input fields*/	
				jQuery('#product_price_field').val(product_price);

				jQuery('#added_box_price_field').val(added_boxes_price);

				jQuery('#subtotal_field').val(subtotal);

				jQuery('#sales_tax_field').val(sales_tax);

				//jQuery('#delivery_cost_field').val(delivery_cost);

				//jQuery('#pickup_cost_field').val(pickup_cost);

				jQuery('#total_price_field').val(total_price);

				jQuery('#display_period').val(period);

				/*SET values to main fields*/

				jQuery('#pickup_cost').text(pickup_cost);

				jQuery('#delivery_cost').text(delivery_cost);


				jQuery('#subtotal').text(subtotal);

				jQuery('#sales_tax').text(sales_tax);

				jQuery('#total_price1').text(total_price);

				jQuery('#total_price2').text(total_price);
				//jQuery('#delivery_cost').val(delivery_cost);

			}
			jQuery( "#next" ).click(function() {

			    var display_period = jQuery('#display_period').val();

			    var dp_period = jQuery('#dp_period').val();

			    //var dp_period = jQuery('#dp_period').val();

			    var box_count = jQuery('#box_count_field').val();

			    var added_box_count = jQuery('#added_box_count_field').val();

			    var added_box_price = jQuery('#added_box_price_field').val();

			    var product_price = jQuery('#product_price_field').val();

			    var subtotal = jQuery('#subtotal_field').val();

			    var delivery_cost = jQuery('#delivery_cost_field').val();

			    var pickup_cost = jQuery('#pickup_cost_field').val();

			    var sales_tax = jQuery('#sales_tax_field').val();

			    var total_price = jQuery('#total_price_field').val();

			    var tax_rates = jQuery('#tax_rates').val();

			    var default_product_cost = jQuery('#default_product_cost').val();

			    var period_data = jQuery('#period_data_field').val(); 

			    var start_date = jQuery('#start_date').val();

			    var end_date = jQuery('#end_date').val();

			    var datastring = "ajax_request=goto_order_summary3&display_period="+display_period+"&dp_period="+dp_period+"&box_count="+box_count+"&added_box_count="+added_box_count+"&added_box_price="+added_box_price+"&product_price="+product_price+"&subtotal="+subtotal+"&delivery_cost="+delivery_cost+"&pickup_cost="+pickup_cost+"&sales_tax="+sales_tax+"&total_price="+total_price+"&period_datas="+period_data+"&start_date="+start_date+"&end_date="+end_date;
			    
			    //alert(datastring);

			    jQuery.ajax({
					url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    
					    //var JSONobj = JSON.parse(result);
					    console.log(result);
					    jQuery(location).attr('href', '/rebow/my-order-summary');
					    //alert(result);
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
		</script>
	</body>
</html>