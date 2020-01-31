<?php
/**
 * Edit user administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
include( ABSPATH . 'wp-admin/admin-header.php' );
$promotion_id = $_REQUEST['promotions'];
$promotions_data = get_promotions_data($promotion_id);
$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");

function get_packages_data($promotion_id){
	$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	//mysql_query('SET names utf8');
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");
	$query="select * from promotions where promotion_id=".$promotion_id;

	$res = mysql_query($query,$con);

	$data = mysql_fetch_assoc($res);
	//echo "<pre>";
	//print_r($data);

	//echo "product_name".
	$promotion_id = $data['promotion_id'];
	$promotion_type = $data['promotion_type'];
	$promotion_description = $data['promotion_description'];
	$coupon_code = $data['coupon_code'];

	$discount_amount = $data['discount_amount'];
	$percentage_off = $data['percentage_off'];
	$minimum_spend = $data['minimum_spend'];
	$promotion_start_date = $data['promotion_start_date'];
	$promotion_end_date = $data['promotion_end_date'];

	$usage_limit_per_user = $data['usage_limit_per_user'];

	//$zipties_count = $data['zipties_count'];

	/*$price_for_first2weeks = get_price($product_id,'2w');
	$price_for_after2weeks = get_price($product_id,'2wa');
	$price_for_1month = get_price($product_id,'1m');*/
	$promotion_type_array= array('Fixed_Amount'=>'Fixed Amount','Percentage_Off'=>'Percentage Off');
	
	echo '<input id="promotion_id" type="hidden" value="'.$promotion_id.'"/>';
	?>
	<table class="form-table">
		<tr class="user-productname-wrap">
			<th><label for="couponcode"><?php _e( 'Coupon Code' ); ?></label></th>
	<?php

	echo '<td><input id="coupon_code" type="text" value="'.$coupon_code.'"/></td></tr><br/>';

	?>
	<tr class="user-promotiondescription-wrap">
			<th><label for="promotiondescription"><?php _e( 'Promotion Description' ); ?></label></th>
	<?php
	echo '<td><input id="promotion_description" type="text" value="'.$promotion_description.'"/></td></tr><br/>';
	?>
	<tr class="user-promotiontype-wrap">
			<th><label for="promotiontype"><?php _e( 'Promotion Type' ); ?></label></th>
	<?php
	echo '<td><select id="promotion_type" name="promotion_type">';
	//echo '<td><selct id="box_count" value="'.$box_count.'"/></td></tr>';
	foreach($promotion_type_array as $key=>$value){
		if($key==$promotion_type){
			echo '<option selected="true" value="'.$key.'">'.$value.'</option>';
		}else{
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}

	echo '</td></select></tr>';
	?>
	
	?>
	<tr class="user_discount_amount_count-wrap">
		<th><label for="discountamount"><?php _e( 'Discount Amount' ); ?></label></th>
	<?php
		if($promotion_type=='Fixed_Amount'){
			echo '<td><input id="discount_amount" type="text" value="'.$discount_amount.'" /></td></tr>';
		}else{
			echo '<td><input id="discount_amount" type="text" value="'.$discount_amount.'" readonly/></td></tr>';
		}
	?>
	<tr class="user-percentage_off_count-wrap">
		<th><label for="percentageoff"><?php _e( 'Percentage Off' ); ?></label></th>
	<?php
		if($promotion_type=='Fixed_Amount'){
			echo '<td><input id="percentage_off" type="text" value="'.$percentage_off.'" /></td></tr>';
		}else{
			echo '<td><input id="percentage_off" type="text" value="'.$percentage_off.'" readonly/></td></tr>';
		}
	?>
	<tr class="user-minimum_spend-wrap">
		<th><label for="minimumspend"><?php _e( 'Minimum Spend Amount' ); ?></label></th>
	<?php
		echo '<td><input id="minimum_spend" type="text" value="'.$minimum_spend.'"/></td></tr>';
	?>
	<tr class="product_categories-wrap">
			<th><label for="product_categories"><?php _e( 'Product Categories' ); ?></label></th>
	<?php
		echo '<td><input id="product_categories" type="text" value="$'.$price_for_first2weeks.'"/></td></tr>';
	?>	
	<tr class="start_date-wrap">
			<th><label for="startdate"><?php _e( 'Start Date' ); ?></label></th>
	<?php
		echo '<td><input id="start_date" type="text" value="$'.$promotion_start_date.'"/></td></tr>';
	?>	
	<tr class="end_date-wrap">
			<th><label for="promotionenddate"><?php _e( 'End Date' ); ?></label></th>
	<?php
		echo '<td><input id="promotion_end_date" type="text" value="$'.$promotion_end_date.'"/></td></tr>';
	?>
	<tr class="end_date-wrap">
			<th><label for="usage_limit_per_user"><?php _e( 'Usage Limit Per User' ); ?></label></th>
	<?php	
		echo '<td><input id="usage_limit_per_user" type="text" value="$'.$usage_limit_per_user.'"/></td></tr>';
		echo '</table>';
	?>
<?php }
/*function get_price($product_id,$period){
	$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	//mysql_query('SET names utf8');
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");
	
	$sql="select price from pricing where product_id=$product_id and period='$period'";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	//return $row[0];
}*/
//include( ABSPATH . 'wp-admin/admin-footer.php' );

echo '<script>
		jQuery(document).ready(function(){
			jQuery("#box_count").change(function() {
		        //alert("Changed");
		       	var box_count =jQuery("#box_count").val();
		       	//alert(box_count);
		       	jQuery("#nestable_dollies_count").val(box_count/4);
		       	jQuery("#labels_count").val(box_count);
		       	jQuery("#zipties_count").val(box_count);
		    });
		    
			jQuery( "#update_packages" ).click(function() {
				var product_id = jQuery("#product_id").val().trim();
				//alert(product_id);

				var product_name = jQuery("#product_name").val().trim();
				//alert(product_name);

				var product_type = jQuery("#product_type").val().trim();
				//alert(product_type);

				var product_range = jQuery("#product_range").val().trim();
				//alert(product_range);

				var box_count =jQuery("#box_count").val();
				//alert(box_count);

				var nestable_dollies_count = jQuery("#nestable_dollies_count").val().trim();

				var labels_count = jQuery("#labels_count").val().trim();
				//alert(labels_count);

				var zipties_count = jQuery("#zipties_count").val().trim();
				//alert(zipties_count);

				var price2weeks = jQuery("#price2weeks").val().trim();
				//alert(price2weeks);

				var priceafter2weeks = jQuery("#priceafter2weeks").val().trim();
				//alert(priceafter2weeks);

				var price_for_1month = jQuery("#price_for_1month").val().trim();
				//alert(price_for_1month);
				
				var datastring ="ajax_request=packages_update&product_id="+product_id+"&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&price2weeks="+price2weeks+"&priceafter2weeks="+priceafter2weeks+"&price_for_1month="+price_for_1month;
				
				alert(datastring);
				console.log(datastring);

				jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    alert(result);
					    alert("Prices Updated");
					}
				});
			});
		});
		</script>';
?>
