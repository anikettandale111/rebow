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
	$order_tracking_history_data = get_order_tracking_info_histroy($order_id);
	$get_additional_order_details_data = get_additional_order_details($order_id);
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
	<div class="inside" style="background:white">
		<div class="panel-wrap">
			<form action="" method="POST" id="order_edit_form"> 
			<input id="ajax_request" name="ajax_request" type="hidden" value="order_update"/>
			<input id="order_status_old" name="order_status_old" type="hidden" value="<?php echo $order_status;?>"/>
			<div class="col-md-12">
			<center><h3>Order Number <?php echo "#".$order_id ;?> Details</h3></center>
			<h5 style="display:none;background:lightgray;padding:10px;font-size:15px;color:currentColor;" id="resp_message"></h5>
			<button id="edit_order_Details" type="button" class="btn btn-info pull-right" style="padding:5px !important;float: right !important;"> Edit </button>
			<div class="row" style="margin:20px;">
				<div class="col-md-4">
					<center><label><b>General</b></label></center>
					<input id="user_id" name="user_id" type="hidden" value="<?php echo $user_id;?>" />
					<input id="order_id" name="order_id" type="hidden" value="<?php echo $order_id;?>" />
					<input id="order_type" name="order_type" type="hidden" value="<?php echo $order_type;?>" />
					<input id="billing_edited_change" name="billing_edited_change" type="hidden" value="0" />
					<input id="shipping_edited_change" name="shipping_edited_change" type="hidden" value="0" />
					<label><b>Date Created </b></label>
					<input class="form-control in_readonly " value="<?php echo $order_date;?>" >					
					<label><b>Order Status </b></label>
					<select class="form-control in_readonly editable" id="order_status" name="order_status">
						<?php foreach($order_status_data as $key=>$value){	
							$value1 = str_replace(" ", "_", $value);
							if($value==$order_status){
	    						echo "<option selected value=$value1>$value</option>";
	    					}else{
	    						echo "<option value=$value1>$value</option>";
	    					}
						}?>
					</select>
					<label><b>Customer </b></label>
					<input class="form-control in_readonly " value="<?php echo $email;?>" id="email" name="email">
				</div>

				<div class="col-md-4" >
					<center><label><b>Billing</b></label></center>
					<!-- <span id="billing_info_change">Edit</span> -->
					<label><b>Address:</b></label>
					<input class="form-control in_readonly " type="text" name="billing_address_edited_value" id="billing_address_edited_value" value="<?php echo $billing_address;?>">
					<label><b>Email Address:</b></label>
					<input class="form-control in_readonly " id="email_edited_value" type="text" name="email_edited_value" value="<?php echo $email;?>">
					<label><b>Contact Number:</b></label>
					<input class="form-control in_readonly " type="text" id="phone_number_edited_value" name="phone_number_edited_value" value="<?php echo $phone_number;?>" />
				</div>
				<div class="col-md-4">
					<center><label><b>Shipping</b></label></center>
					<?php if($order_type == 'RENTAL'){?>
						<label><b>Delivery Address:</b></label>
						<!-- <span id="delivery_address"><?php echo $deliver_empty_boxes_data['address'];?></span> -->
						<input type="text" class="form-control in_readonly editable" id="delivery_address_edited_value" name="delivery_address_edited_value" value="<?php echo $deliver_empty_boxes_data['address'];?>">
						<label><b>Pickup Address:</b></label>
						<!-- <span id="pickup_address"><?php echo $pickup_empty_boxes_data['address'];?></span> -->
						<input type="text" class="form-control in_readonly editable" id="pickup_address_edited_value" name="pickup_address_edited_value" value="<?php echo $pickup_empty_boxes_data['address'];?>">
					<?php }else{?>
						<label><b>Delivery Empty Box Address:</b></label>
						<!-- <span id="delivery_address"><?php echo $deliver_empty_boxes_data['address'];?></span> -->
						<input type="text" class="form-control in_readonly editable" id="delivery_address_edited_value" name="delivery_address_edited_value" value="<?php echo $deliver_empty_boxes_data['address'];?>">
						<label><b>Pickup Address for Packed Boxes:</b></label>
						<!-- <span id="pickup_address"><?php echo $pickup_packed_boxes_data['address'];?></span> -->
						<input type="text" class="form-control in_readonly editable" id="pickup_packed_address_edited_value" name="pickup_packed_address_edited_value" value="<?php echo $pickup_packed_boxes_data['address'];?>">
						<label><b>Delivery Packed Boxes Address:</b></label>
						<!-- <span id="delivery_packed_address"><?php echo $deliver_packed_boxes_data['address'];?></span> -->
						<input type="text" class="form-control in_readonly editable" id="delivery_packed_address_edited_value" name="delivery_packed_address_edited_value" value="<?php echo $deliver_packed_boxes_data['address'];?>" />
						<label><b>Pickup Empty Box Address:</b></label>
						<!-- <span id="pickup_address"><?php echo $pickup_empty_boxes_data['address'];?></span> -->
						<input type="text" class="form-control in_readonly editable" id="pickup_address_edited_value" name="pickup_address_edited_value" value="<?php echo $pickup_empty_boxes_data['address'];?>" />
					<?php } ?>
				<label><b> Comment/Reason for change </b></label>
				<textarea class="form-control in_readonly editable" id="edit_reason_message" name="edit_reason_message" placeholder="write in 250 words"></textarea>
				</div>
			</div>
			<div class="col-md-12">
			<center><b>Order Product Details</b></center>
			<table class='wp-list-table widefat fixed striped posts' style="margin:20px;">
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
			<?php if(count($get_additional_order_details_data)): ?>
			<center><b>Aditional Order Product Details</b></center>
			<table class='wp-list-table widefat fixed striped posts' style="margin:20px;">
				<tr><th><center>Order Number</center></th><th><center>Product Name</center></th><th><center>Date</center></th><th><center>Box Count</center></th><th><center>Subtotal</center></th><th><center>Total</center></th></tr>
				<?php foreach($get_additional_order_details_data as $val): ?>
					<?php $order_id = $val['order_id']; ?>
				<tr>
					<td><a class='orders_info' href='edit_orders.php?order=<?php echo $order_id;?>' id='<?php echo $order_id;?>'> #<?php echo $order_id;?></a></td>
					<td><?php echo "Additional Box";?></td>
					<td><?php echo $val['created_at'];?></td>
					<td><?php echo $val['added_box_count'];?></td>
					<td><?php echo $val['subtotal'];?></td>
					<td><?php echo $val['total_price'];?></td>
				</tr>
				<?php endforeach ?>
			</table>
			<?php endif ?>

			<?php if(count($order_tracking_history_data)): ?>
			<center><b>Order Tracking Status Histroy</b></center>
			<table class='wp-list-table widefat fixed striped posts' style="margin:20px;">
				<tr><th><center>Order Status</center></th><th><center>Description</center></th><th><center>Date</center></th></tr>
				<?php foreach($order_tracking_history_data as $val): ?>
				<tr>
					<td><?php echo $val['order_status'];?></td>
					<td><?php echo $val['order_status_description'];?></td>
					<td><?php echo $val['created_at'];?></td>
				</tr>
				<?php endforeach ?>
			</table>
			<?php endif ?>
			</div>
		</div>
		<center>
			<button type="button" id="update_order_Details" class="btn btn-success reset_readonly" style="display:none;margin:20px;">UPDATE</button>
			<a href="<?php echo site_url().'/wp-admin/admin.php?page=Orders' ?>" type="button" class="btn btn-info reset_readonly" style="margin:20px;">CANCEL</a>
		</center>
	</form>
	</div>
	
<?php }
?>
</div>
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
	jQuery('.reset_readonly').click(function(){
		jQuery(".editable").attr("readonly", "true");
	});
	jQuery('#edit_order_Details').click(function(){
		jQuery(".editable").removeAttr("readonly");
		jQuery("#update_order_Details").css("display","block");
		jQuery('#shipping_edited_change').val(1);
	});
		jQuery(document).ready(function(){
			jQuery(".in_readonly").attr("readonly", "true");
			jQuery('#billing_info_change').click(function(){
			
			jQuery('#billing_address').hide();
			jQuery('#billing_address_edited').show();

			jQuery('#email').hide();
			jQuery('#email_edited').show();

			jQuery('#phone_number').hide();
			jQuery('#phone_number_edited').show();


		});
		jQuery('#shipping_info_change').click(function(){
			
			jQuery('#delivery_address').hide();
			jQuery('#delivery_address_edited').show();

			jQuery('#pickup_address').hide();
			jQuery('#pickup_address_edited').show();

			jQuery('#shipping_edited_change').val(1);

		});

		jQuery('#update_order_Details').click(function(){

			// var order_id = jQuery('#order_id').val();

			// var user_id = jQuery('#user_id').val();

			// var order_type = jQuery('#order_type').val();

			// var order_status_old = jQuery('#order_status_old').val();

			// var order_status = jQuery('#order_status_select').val();

			// var billing_address_edited_value = jQuery('#billing_address_edited_value').val();

			// var email_edited_value = jQuery('#email_edited_value').val();

			// var delivery_address_edited_value = jQuery('#delivery_address_edited_value').val();

			// var pickup_address_edited_value = jQuery('#pickup_address_edited_value').val();

			// var shipping_edited_change = jQuery('#shipping_edited_change').val();

			// var billing_edited_change = jQuery('#billing_edited_change').val();

			// var datastring ={ajax_request:"order_update",order_status:order_status,billing_address_edited_value:billing_address_edited_value,email_edited_value:email_edited_value,delivery_address_edited_value:delivery_address_edited_value,pickup_address_edited_value:pickup_address_edited_value,order_id:order_id,order_status_old:order_status_old,user_id:user_id,shipping_edited_change:shipping_edited_change,billing_edited_change:billing_edited_change,order_type:order_type};

			// var datastring ="ajax_request=order_update&order_status="+order_status+"&billing_address_edited_value="+billing_address_edited_value+"&email_edited_value="+email_edited_value+"&delivery_address_edited_value="+delivery_address_edited_value+"&pickup_address_edited_value="+pickup_address_edited_value+"&order_id="+order_id+"&order_status_old="+order_status_old+"&user_id="+user_id+"&shipping_edited_change="+shipping_edited_change+"&billing_edited_change="+billing_edited_change+"&order_type="+order_type;
			//alert(datastring);
			
			jQuery.ajax({
				url: "test-plugin-api.php",
				method : "POST",
				data : jQuery('#order_edit_form').serialize(),
				success: function(result){
					jQuery('#resp_message').css('display','block');
				    jQuery('#resp_message').text(result);
				    jQuery('html, body').animate({
					    scrollTop: jQuery("div.panel-wrap").offset().top
					}, 1000)
				    setTimeout(function() {
				    	jQuery('#resp_message').fadeOut('fast');
				    	location.reload();
					}, 3000);
				}
			});
		});
	});
</script>