<?php /* Template Name: add_more_boxes*/ ?>
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
		<?php 
    		$query = "select keyy,value from lookup_table where description='Boxes'";
			$res = mysql_query($query);	
		?>
		<?php
			$order_type = get_order_data_add($current_order_id);

			function get_order_data_add($current_order_id){
				$query = "select order_type from orders_data where order_id=".$current_order_id;

				$res = mysql_query($query);
					//echo "in query";
				$row = mysql_fetch_row($res);

				return $row[0];
			}
			$tax_rate = get_tax_rate();
			if($added_box_price==0||empty($added_box_price)){
				$added_box_price = (4*3*2);

				$subtotal = $added_box_price;

				$delivery_cost_text = 'FREE';

				$pickup_cost_text = 'FREE';

				$sales_tax = ($subtotal * $tax_rate)/100;

				$total_price = $subtotal+$sales_tax;

			}

		?>
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
		              <div class="col-sm-12">
		                <ul class="order-breadcrumb">
		                  <li><a href="">MY ORDERS</a></li>
		                  <li><a href="">ORDER #<?php echo $current_order_id;?> - ADD REBOW BOXES</a></li>
		                </ul>
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
		        <div class="row col-order">
		          <div class="col-sm-12">
		            <div class="py-5 px-3">
		              <div class="row">
		                <div class="col-sm-12 mb-4 form-header p-0">
		                  <label for="">Need more ReBow™ Boxes ? You can add a minimum of 4 Boxes</label>
		                </div>
		              </div>

		              <div class="row justify-content-start">
		                <div class="col-sm-12 col-md-4">
		                  <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/group-of-dollies.png" alt="">
		                </div>
		                <div class="col-sm-12 col-md-6 add-more-box">
		                  <p class="mb-3">Need more ReBow™ Boxes?<br>You can add them in sets of 4.</p>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p class="txt-blue"><b>Quantity :</b></p>
		                    </div>
		                    <div class="col-from-field">
		                      <!--<div class="selectholder">
		                        <label>Choose Time</label>-->
		                        
								<select id="add_box_count">
		                          	<?php while($row=mysql_fetch_assoc($res)){ 

										echo "<option value=".$row['keyy'].">".$row['value']."</option>";
									
									}?>
		                        </select>
		                      	<!--</div>-->
		                    </div>
		                  </div>
		                  <div class="clearfix"></div>
		                  <div class="row-from">
		                    <div class="col-from-field p-0">
		                      <p class="mt-2 txt-blue"><b>Time Period :</b></p>
		                    </div>
		                    <div class="col-from-field ">
		                      <!--<div class="selectholder">
		                        <label>Choose Time</label>-->
		                        
								<select id="selectperiod1">
		                          	<?php
				    				foreach($array1 as $key=>$value){
				    					
				    					if($key==$display_period){
				    						echo "<option selected value=$key> $key $dp_period</option>";
				    					}else{
				    						echo "<option value=$key> $key $dp_period</option>";
				    					}
				    				}	
				    				?>
		                        </select>
		                      <!--</div>-->
		                    </div>
		                  </div>
		                  <div class="clearfix"></div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p class="txt-blue mt-1"><b>Price :</b></p>
		                    </div>
		                    <div class="col-from-field mt-1">
		                    <?php $period_text=($period_datas=="STORAGE")?"Month":"Week";?>
		                      <label id="added_box_price" for="" class="price">$<?php echo $added_box_price;?></label>/ <?php echo $period_text;?>
		                    </div>
		                    <div class="col-from-field">
		                      <button id="add_more_boxes785" type="submit" class="btn btn-secondary">Add</button>
		                    </div>
		                  </div>
		                  <div class="row-from">
		                    <div class="col-from-field">
		                      <p>Every 4 Boxes includes : </p>
		                      <ul class="includes">
		                        <li>
		                          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                            <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"></path>
		                          </svg>
		                          1 Nestable Dollies </li>
		                        <li>
		                          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                            <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"></path>
		                          </svg>
		                          4 Labels </li>
		                        <li>
		                          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                            <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"></path>
		                          </svg>
		                          4 Security Zip Ties </li>
		                        <li>
		                          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                            <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"></path>
		                          </svg>
		                          Free Delivery &amp; Pickup </li>
		                      </ul>
		                    </div>
		                  </div>
		                </div>
		                <hr>
		              </div>
		              <div class="row">
		                <div class="col-sm-12">
		                  <div class="row pl-5">
		                    <div class="row-from w">
		                      <div class="col-from-field p-0">
		                        <p>Subtotal : </p>
		                      </div>
		                      <div class="col-from-field p-0">
		                        <label id="subtotal" for="">$<?php echo $subtotal;?></label>
		                      </div>
		                    </div>
		                    <div class="row-from w">
		                      <div class="col-from-field p-0">
		                        <p>Delivery: </p>
		                      </div>
		                      <div class="col-from-field p-0">
		                        <label id="delivery_cost" for=""><?php echo $delivery_cost_text;?></label>
		                      </div>
		                    </div>
		                    <div class="row-from w">
		                      <div class="col-from-field p-0">
		                        <p>Pick Up : </p>
		                      </div>
		                      <div class="col-from-field p-0">
		                        <label id="pickup_cost" for=""><?php echo $pickup_cost_text;?></label>
		                      </div>
		                    </div>
		                    <div class="row-from w">
		                      <div class="col-from-field pb-0">
		                        <p>Sales Tax :</p>
		                      </div>
		                      <div class="col-from-field pb-0">
		                        <label id="sales_tax" for="">$<?php echo $sales_tax;?></label>
		                      </div>
		                    </div>
		                    <div class="row-from w">
		                      <div class="col-from-field p-0">
		                        <p>Total :</p>
		                      </div>
		                      <div class="col-from-field p-0">
		                        <label id="total_price" for="">$<?php echo $total_price;?></label>
		                      </div>
		                    </div>
		                  </div>
		                </div>
		              </div>

		            </div>
		          </div>
		        </div>
		        <!-- button -->
		        <div class="row justify-content-start mb-3 pl-5 pb-5">
		          <div class="bottom-btn">
		            <button id="cancel" type="button" class="btn btn-grey mr-4">Cancel</button>
		            <button type="submit" id="submit_changes" class="btn btn-secondary">Next</button>
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
				jQuery('#show_cost').hide();
				jQuery("#add_box_count").change(function() {
					//alert(1);
					var added_box_count = jQuery('#add_box_count').val();
					
					var display_period = jQuery('#display_period').val();
					
					var default_product_cost = jQuery('#default_product_cost').val();
					
					var added_box_price = (added_box_count*default_product_cost*display_period);

					jQuery('#added_box_price').text('$'+added_box_price);
					jQuery('#added_box_price_field').val(added_box_price);
					//jQuery('#submit_changes').attr('disabled',false);
					//calculation();

				});
				jQuery('#add_more_boxes785').click(function(){

					var added_box_count = jQuery('#add_box_count').val();

					var added_box_price = Number(jQuery('#added_box_price').text());

					jQuery('#added_box_count_field').val(added_box_count);

					jQuery('#added_box_price_field').val(added_box_price);

					//calculation();
					calculate_add_more_boxes();

					jQuery('#show_cost').show();

				});
				jQuery("#selectperiod1").change(function() {
					var selectperiod1 = jQuery('#selectperiod1').val();
					if(selectperiod1=="MM"){
						var selectperiod1 = 1;
					}
					jQuery('#display_period').val(selectperiod1);

					var added_box_count = jQuery('#add_box_count').val();
					
					var display_period = jQuery('#display_period').val();
					
					var default_product_cost = jQuery('#default_product_cost').val();
					
					var added_box_price = (added_box_count*default_product_cost*display_period);

					jQuery('#added_box_price').text('$'+added_box_price);
					jQuery('#added_box_price_field').val(added_box_price);
					//calculation();
					//calculate_add_more_boxes();
				});
				jQuery("#submit_changes").click(function() {

					var add_box_count = jQuery('#add_box_count').val();

					var added_box_price = jQuery('#added_box_price_field').val();

					var selectperiod1 = jQuery('#selectperiod1').val();

					var subtotal = Number(jQuery('#subtotal_field').val());

					var delivery_cost = Number(jQuery('#delivery_cost').text());
					if(isNaN(delivery_cost)){
						delivery_cost=0;
					}
					var pickup_cost = Number(jQuery('#pickup_cost').text());
					if(isNaN(pickup_cost)){
						pickup_cost=0;
					}
					var sales_tax = Number(jQuery('#sales_tax_field').val());

					var total_price = Number(jQuery('#total_price_field').val());

					//var product_id = "<?php //echo $current_order_id;?>";

					var datastring = "ajax_request=add_more_boxes_submit&add_box_count="+add_box_count+"&selectperiod1="+selectperiod1+"&subtotal="+subtotal+"&delivery_cost="+delivery_cost+"&sales_tax="+sales_tax+"&total_price="+total_price+"&added_box_price="+added_box_price;
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    console.log(result);

						    jQuery(location).attr('href', '/rebow/add-more-boxes-pickup-delivery/');

						}
					});

				});
			});
			function calculate_add_more_boxes(){

				var added_box_count = jQuery('#add_box_count').val();

				jQuery('#added_box_count_field').val(added_box_count);
					
				var display_period = jQuery('#display_period').val();
					
				var default_product_cost = jQuery('#default_product_cost').val();

				var added_box_count = jQuery('#add_box_count').val();

				var tax_rates = jQuery('#tax_rates').val();

				var delivery_cost = jQuery('#delivery_cost_field').val();

				var pickup_cost = jQuery('#pickup_cost_field').val();

				var added_box_price = (added_box_count*default_product_cost*display_period);

				var sales_tax = (added_box_price * tax_rates)/100;

				var total_price = added_box_price+sales_tax;

				jQuery('#subtotal').text('$'+added_box_price);

				jQuery('#subtotal_field').val(added_box_price);

				jQuery('#added_box_price').text('$'+added_box_price);

				jQuery('#added_box_price_field').val(added_box_price);

				if(delivery_cost==0){
					jQuery('#delivery_cost').text('FREE');
				}else{
					jQuery('#delivery_cost').text('FREE');
				}
				if(pickup_cost==0){
					jQuery('#pickup_cost').text('FREE');
				}else{
					jQuery('#pickup_cost').text('FREE');
				}

				jQuery('#sales_tax').text('$'+sales_tax);

				jQuery('#sales_tax_field').val(sales_tax);

				jQuery('#total_price').text('$'+total_price);

				jQuery('#total_price_field').val(total_price);
			}

			jQuery("#cancel").click(function() {
				//alert(1);
				jQuery('#cancel-order').modal('show');
			});
			jQuery("#yes").click(function() {

				jQuery(location).attr('href', '/rebow/view-order/');
				
			});
			jQuery("#no").click(function() {

				
				//jQuery(location).attr('href', '#');
				jQuery('#cancel-order').modal('hide');
				
			});
		</script>
	</body>
</html>