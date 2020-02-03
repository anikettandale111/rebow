<?php /* Template Name: my_orders*/ ?>
<?php require_once("user_check_login.php");?>
<?php require_once("db_config.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php 

		session_start();
		session_destroy();
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
		<section>
		  <div class="container">
		    <div class="row">
		      <ul class="account">
		        <li class="selected"><a href="/rebow/my-orders/">My Orders</a></li>
		        <li><a href="/rebow/my-information/">My Information</a></li>
		        <li><a href="/rebow/payment-information/">Payment info</a></li>
		        <li><a href="/rebow/support/">Support</a></li>
		      </ul>
		      <div class="rhs-account mb-5">
		        <div class="row justify-content-left">
		          <div class="col-sm-12 mb-2">
		            <h2><b>ACTIVE ORDERS</b></h2>
		          </div>
		          <?php 
					$query = "SELECT * FROM active_orders where user_id=$user_id";

					$res = mysql_query($query);
					while($row = mysql_fetch_assoc($res)){
						$msg1 = ($row['order_type']=="RENTAL")? "You Rented Rebow boxes ":"You have Rented Rebow Boxes for Storage ";
						$msg2 = ($row['shipping_type']=="Delivery Empty Boxes")? "We will deliver on ".$row['shipping_info'] : "You have Rented Rebow Boxes for Storage";
						?>
			          	<div class="col-sm-12 col-md-4 mb-4">
			            	<div class="text-center grey-bg p-4">
			              		<img class="mb-3" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
			              		<p><b><?php echo $msg1;?></b></p>

			              		<p><b><?php echo $msg2;?></b></p>

			              		<p class="mt-4">Order <a href="#javacript;" class="act-order orders_info" id="<?php echo $row['order_id'];?>">#<?php echo $row['order_id'];?></a></p>
			            	</div>
			          	</div>
			       	<?php }?>
		          <div class="col-sm-12 my-3">
		            <h2><b>ORDER HISTORY</b></h2>
		          </div>
		          <?php 
					$query = "SELECT * FROM orders_history where user_id=$user_id";

					$res = mysql_query($query);
					?>
		          <div class="col-sm-12">
		            <div class="table-responsive">
		              <table class="table">
		                <thead class="thead-dark">
		                  <tr>
		                    <th scope="col"><em>Order #</em></th>
		                    <th scope="col"><em>Date </em></th>
		                    <th scope="col"><em>Order Type</em></th>
		                    <th scope="col"><em>Payment Status</em></th>
		                    <th scope="col"><em>Fulfillment Status</em></th>
		                    <th scop="col"><em>Order Total</em></th>
		                  </tr>
		                  <?php while($row = mysql_fetch_assoc($res)){?>
		                  	<tr>
			                    <td><a href="#javacript;" class='orders_info' id="<?php echo $row['order_id']?>">#<?php echo $row['order_id'];?></a></td>
			                    <td><?php 
			                    	$date=date_create($row['order_date']);
									echo date_format($date,"M d, Y");
									//echo $row['order_date'];?></td>
			                    <td><?php echo ucfirst(strtolower($row['order_type']));?></td>
			                    <td><?php echo $row['payment_status'];?></td>
			                    <td><?php echo $row['fullfillment_status'];?></td>
			                    <td><?php echo '$'.$row['order_total'];?></td>
		                  	</tr>
		                  <?php }?>
		                </thead>
		              </table>
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
				jQuery('.orders_info').click(function(event) {
					
					var current_id = jQuery(this).attr('id');
					//alert(current_id);
					//var period_datas = "<?php echo $row['order_type'];?>";
					//alert(period_datas);
					var datastring = "ajax_request=goto_order_summary&current_id="+current_id;
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);

						    //alert(result);
						    jQuery(location).attr('href', '/rebow/view-order');
						}
					});
					return false;
				});

				
			});
		</script>
	</body>
</html>