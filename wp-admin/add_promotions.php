<?php
/**
 * Edit user administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */
echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" />';
/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
include( ABSPATH . 'wp-admin/admin-header.php' );
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
//$promotion_id = $_REQUEST['promotions'];
//$promotions_data = get_promotions_data($promotion_id);
/*$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");*/
?>
	<form id="promotionForm">
	<table class="form-table">
		<tr class="user-productname-wrap">
			<th><label for="couponcode"><?php _e( 'Coupon Code' ); ?></label></th>
			<td><input id="coupon_code" type="text" value="" required/></td>
		</tr><br/>

	
		<tr class="user-promotiondescription-wrap">
			<th><label for="promotiondescription"><?php _e( 'Promotion Description' ); ?></label></th>
			<td><input id="promotion_description" type="text" value="" required/></td>
		</tr><br/>

		<tr class="user-promotiontype-wrap">
			<th><label for="promotiontype"><?php _e( 'Promotion Type' ); ?></label></th>
			<td>
				<select id="promotion_type" name="promotion_type">
					<option  value="select_promotion_type">Select Promotion Type</option>
					<option  value="Fixed_Amount">Fixed Amount</option>
					<option  value="Percentage_Off">Percentage Off</option>
				</select>
			</td>
		</tr>
		<tr class="user_discount_amount_count-wrap">
			<th><label for="discountamount"><?php _e( 'Discount Amount' ); ?></label></th>
	
			<td><input id="discount_amount" type="text" value="" required /></td>
		</tr>
		<tr class="user-percentage_off_count-wrap">
			<th><label for="percentageoff"><?php _e( 'Percentage Off' ); ?></label></th>
	
			<td><input id="percentage_off" type="text" value="" required/></td></tr>
		</tr>
		<tr class="user-minimum_spend-wrap">
			<th><label for="minimumspend"><?php _e( 'Minimum Spend Amount' ); ?></label></th>
	
		<td><input id="minimum_spend" type="text" value=""/></td></tr>
		<tr class="product_categories-wrap">
			<th><label for="product_categories"><?php _e( 'Product Categories' ); ?></label></th>
			<td>
				<select id="product_categories" multiple>
					<option value="Rental_Packages">Rental Packages</option>
					<option value="Storage_Packages">Storage Packages</option>
					<option value="Residential_Packages">Residential Packages</option>
				</select>
			</td>
		</tr>

		<tr class="start_date-wrap">
			<th><label for="startdate"><?php _e( 'Start Date' ); ?></label></th>
			<td><input class="datepicker" id="promotion_start_date" type="text" value="" required/></td>
		</tr>
	
		<tr class="end_date-wrap">
			<th><label for="promotionenddate"><?php _e( 'End Date' ); ?></label></th>
			<td><input class="datepicker" id="promotion_end_date" type="text" value="" required/></td>
		</tr>
		<tr class="end_date-wrap">
			<th><label for="usage_limit_per_user"><?php _e( 'Usage Limit Per User' ); ?></label></th>
			<td><input id="usage_limit_per_user" type="text" value="" required/></td>
		</tr>
	</table>
	<input id="add_promotions" type="Submit" value="Add Promotions"/>
	</form >
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
		jQuery(document).ready(function(){
			/*jQuery('#promotionForm').validate({ // initialize the plugin
				
		        rules: {
		            coupon_code: {
		                required: true
		                //email: true
		            },
		            promotion_description: {
		                required: true
		                //minlength: 5
		            }
		        },
		        submitHandler: function (form) { // for demo
		            alert('valid form submitted'); // for demo
		            return false; // for demo
		        }
		    });*/

			jQuery('#promotion_type').change(function(){
				var promotion_type =jQuery("#promotion_type").val();
				if(promotion_type=='Fixed_Amount'){
					jQuery("#percentage_off").prop("readonly", true);
					jQuery("#discount_amount").prop("readonly", false);
				}else{
					jQuery("#discount_amount").prop("readonly", true);
					jQuery("#percentage_off").prop("readonly", false);
				}
			});
			
			jQuery( "#promotionForm" ).submit(function() {

				//var promotion_id = jQuery("#promotion_id").val().trim();
				//alert(promotion_id);

				var coupon_code = jQuery("#coupon_code").val().trim();
				//alert(coupon_code);

				var promotion_type = jQuery("#promotion_type").val().trim();

				var promotion_description = jQuery("#promotion_description").val().trim();
				//alert(promotion_type);

				var discount_amount = jQuery("#discount_amount").val().trim();
				//alert(discount_amount);

				var percentage_off = jQuery("#percentage_off").val().trim();
				//alert(percentage_off);

				var minimum_spend =jQuery("#minimum_spend").val();
				//alert(minimum_spend);

				var product_categories = jQuery("#product_categories").val();

				var promotion_start_date = jQuery("#promotion_start_date").val().trim();
				//alert(promotion_start_date);

				var promotion_end_date = jQuery("#promotion_end_date").val().trim();
				//alert(promotion_end_date);

				var usage_limit_per_user = jQuery("#usage_limit_per_user").val().trim();
				//alert(usage_limit_per_user);

				
				var datastring ="ajax_request=add_promotions&coupon_code="+coupon_code+"&promotion_type="+promotion_type+"&discount_amount="+discount_amount+"&percentage_off="+percentage_off+"&minimum_spend="+minimum_spend+"&product_categories="+product_categories+"&promotion_start_date="+promotion_start_date+"&promotion_end_date="+promotion_end_date+"&usage_limit_per_user="+usage_limit_per_user+"&promotion_description="+promotion_description;
				
				alert(datastring);
				console.log(datastring);

				jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    //alert(result);
					    alert("Promotion Added");
					    window.location.href="http://localhost/rebow/wp-admin/admin.php?page=coupons_promos";
					}
				});
			});
			
		});
		$('#promotion_start_date').datepicker({
	    	daysOfWeekDisabled: [0,6]
		});
		$('#promotion_end_date').datepicker({
	    	daysOfWeekDisabled: [0,6]
		});
		</script>
		<script type="text/javascript" href="http://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"/></script>

