<?php
/**
 * Edit user administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

//echo "<link rel='stylesheet' type='text/css' href='bootstrap.css' />";
/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
include( ABSPATH . 'wp-admin/admin-header.php' );

$order_id = $_REQUEST['order'];
//echo $order_id;

show_order_details($order_id);

function show_order_details($order_id){
	$order_data =  get_order_details($order_id);
	//print_r($order_data);
	$user_id = $order_data['user_id'];

	$user_data =get_user_data($user_id);
	//$email = $user_data['email'];

	$customer_data = get_customer_data($user_id);
	$email = $customer_data['email'];
	$phone_number = $customer_data['phone_number'];
	//$email = $customer_data['email'];
	//print_r($user_data);
	$order_date = $order_data['created_at'];
	$order_type = $order_data['order_type'];
	$product_id = $order_data['product_id'];

	$payments_data = get_payments_data_user($user_id);

	$product_data = get_product_data($product_id);

	$billing_address = $payments_data['billing_address'];
	//print_r($payments_data);
	$order_tracking_data = get_order_tracking_info($order_id);
	$order_status = $order_tracking_data['order_status'];
	$order_status_data = get_order_status_data($order_type);
	//print_r($order_status_data);

	if($order_type=='RENTAL'){
		$shipping_type='Delivery Empty Boxes';
		$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$shipping_type='Pickup Empty Boxes';
		$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

	}else if($order_type=='STORAGE'){
		$shipping_type='Delivery Empty Boxes';
		$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$shipping_type='Delivery Packed Boxes';
		$deliver_packed_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$shipping_type='Pickup Packed Boxes';
		$pickup_packed_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$shipping_type='Pickup Empty Boxes';
		$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);
	}
	
	$order_status_array = array('Order_Received'=>'Order Received','Order_Confirmed'=>'Order Confirmed',
		'Order_Completed'=>'Order Completed','Order_Cancelled'=>'Order Cancelled','Order_Refund'=>'Order Refund');
?>
	<div class="inside">
		<div class="panel-wrap">
			<h3>Order <?php echo "#".$order_id ;?> Details</h3>
			<input id="order_status_old" type="hidden" value="<?php echo $order_status;?>"/>
			<div class="row">
				<div class="col-md-4">
					<input id="user_id" type="hidden" value="<?php echo $user_id;?>" />
					<input id="order_id" type="hidden" value="<?php echo $order_id;?>" />
					<input id="order_type" type="hidden" value="<?php echo $order_type;?>" />

					<input id="billing_edited_change" type="hidden" value="0" />
					<input id="shipping_edited_change" type="hidden" value="0" />
					<b>General</b>
					<br/>
					<label>Date Created</label>
					<br/>
					<span><?php echo $order_date;?></span>
					<br/>
					<label>Order Status</label>
					<select id="order_status_select">
						<?php foreach($order_status_data as $key=>$value){	
							$value1 = str_replace(" ", "_", $value);
							if($value==$order_status){
	    						echo "<option selected value=$value1>$value</option>";
	    					}else{
	    						echo "<option value=$value1>$value</option>";
	    					}
						}?>
					</select>
					<br/>
					<label>Customer</label>

					<span><?php echo $email;?></span>
				</div>

				<div class="col-md-4" >
					<b>Billing</b> <span id="billing_info_change">Edit</span>
					<br/>
					<span id="billing_address"><?php echo $billing_address;?></span>
					<div id="billing_address_edited" style="display:none">
						<input type="text" id="billing_address_edited_value" value="<?php echo $billing_address;?>" />
					</div>
					<br/>
					<label>Email Address:</label>

					<span id="email"><?php echo $email;?></span>
					<div id="email_edited" style="display:none">
						<input type="text" readonly id="email_edited_value" value="<?php echo $email;?>" />
					</div>
					<br/>
					<label>Contact Number:</label>

					<span id="phone_number"><?php echo $phone_number;?></span>
					<div id="phone_number_edited" style="display:none">
						<input type="text" readonly id="phone_number_edited_value" value="<?php echo $phone_number;?>" />
					</div>
				</div>
				<div class="col-md-4">
					<b>Shipping</b><span id="shipping_info_change">Edit</span>
					<br/>
					<?php if($order_type=='RENTAL'){?>
						<label><b>Delivery Address:</b></label>
						<span id="delivery_address"><?php echo $deliver_empty_boxes_data['address'];?></span>
						<br/>
						<div id="delivery_address_edited" style="display:none">
							<input type="text" id="delivery_address_edited_value" value="<?php echo $deliver_empty_boxes_data['address'];?>" />
						</div>
						<label><b>Pickup Address:</b></label>
						<span id="pickup_address"><?php echo $pickup_empty_boxes_data['address'];?></span>
						<div id="pickup_address_edited" style="display:none">
							<input type="text" id="pickup_address_edited_value" value="<?php echo $pickup_empty_boxes_data['address'];?>" />
						</div>
					<?php }else{?>
						<label>Delivery Address:</label>
						<span id="delivery_address"><?php echo $deliver_empty_boxes_data['address'];?></span>
						<br/>
						<div id="delivery_address_edited" style="display:none">
							<input type="text" id="delivery_address_edited_value" value="<?php echo $deliver_empty_boxes_data['address'];?>" />
						</div>
						<label>Pickup Address for Packed Boxes:</label>
						<span id="pickup_address"><?php echo $pickup_packed_boxes_data['address'];?></span>
						<div id="pickup_packed_address_edited" style="display:none">
							<input type="text" id="pickup_packed_address_edited_value" value="<?php echo $pickup_empty_boxes_data['address'];?>" />

						<label>Delivery Packed Boxes Address:</label>
						<span id="delivery_packed_address"><?php echo $deliver_packed_boxes_data['address'];?></span>
						<br/>
						<div id="delivery_packed_address_edited" style="display:none">
							<input type="text" id="delivery_packed_address_edited_value" value="<?php echo $deliver_empty_boxes_data['address'];?>" />
						</div>
						<label>Pickup Address:</label>
						<span id="pickup_address"><?php echo $pickup_empty_boxes_data['address'];?></span>
						<div id="pickup_address_edited" style="display:none">
							<input type="text" id="pickup_address_edited_value" value="<?php echo $pickup_empty_boxes_data['address'];?>" />
					<?php } ?>
				</div>

			</div>
			<button id="update_order_Details">UPDATE</button>
		</div>
	</div>
	<br/>
	<table class='wp-list-table widefat fixed striped posts'>
		<tr><th>Product Name</th><th>Box Count</th><th>Subtotal</th><th>Total</th></tr>
		<tr>
			<td><?php echo $product_data['product_name'];?>
			</td>
			<td><?php echo $product_data['box_count'];?>
			</td>
			<td><?php echo $order_data['subtotal'];?>
			</td>
			<td><?php echo $order_data['total_price'];?>
			</td>
		</tr>
	</table>
<?php }
?>

<?php
function get_order_details($order_id){
	$query="select * from orders_data where order_id=$order_id";

	$res = mysql_query($query);

	$row = mysql_fetch_assoc($res);

	return $row;
}
function get_user_data($user_id){
	$query="select * from wp_users where ID=$user_id";

	$res = mysql_query($query);

	$row = mysql_fetch_assoc($res);

	return $row;
}

?>

<script>
	jQuery(document).ready(function(){
		jQuery('#billing_info_change').click(function(){
			
			jQuery('#billing_address').hide();
			jQuery('#billing_address_edited').show();

			jQuery('#email').hide();
			jQuery('#email_edited').show();

			jQuery('#phone_number').hide();
			jQuery('#phone_number_edited').show();

			jQuery('#billing_edited_change').val(1);

		});
		jQuery('#shipping_info_change').click(function(){
			
			jQuery('#delivery_address').hide();
			jQuery('#delivery_address_edited').show();

			jQuery('#pickup_address').hide();
			jQuery('#pickup_address_edited').show();

			jQuery('#shipping_edited_change').val(1);

		});

		jQuery('#update_order_Details').click(function(){

			var order_id = jQuery('#order_id').val();

			var user_id = jQuery('#user_id').val();

			var order_type = jQuery('#order_type').val();

			var order_status_old = jQuery('#order_status_old').val();

			var order_status = jQuery('#order_status_select').val();

			var billing_address_edited_value = jQuery('#billing_address_edited_value').val();

			var email_edited_value = jQuery('#email_edited_value').val();

			var delivery_address_edited_value = jQuery('#delivery_address_edited_value').val();

			var pickup_address_edited_value = jQuery('#pickup_address_edited_value').val();

			var shipping_edited_change = jQuery('#shipping_edited_change').val();

			var billing_edited_change = jQuery('#billing_edited_change').val();

			var datastring ="ajax_request=order_update&order_status="+order_status+"&billing_address_edited_value="+billing_address_edited_value+"&email_edited_value="+email_edited_value+"&delivery_address_edited_value="+delivery_address_edited_value+"&pickup_address_edited_value="+pickup_address_edited_value+"&order_id="+order_id+"&order_status_old="+order_status_old+"&user_id="+user_id+"&shipping_edited_change="+shipping_edited_change+"&billing_edited_change="+billing_edited_change+"&order_type="+order_type;
			//alert(datastring);
			
			jQuery.ajax({
				url: "test-plugin-api.php",
				method : "POST",
				data : datastring,
				success: function(result){
				    console.log(result);
				}
			});
		});
	});
</script>