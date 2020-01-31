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
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
$promotion_id = $_REQUEST['promotions'];
$promotions_data = get_promotions_data($promotion_id);
/*$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");*/

function get_promotions_data($promotion_id){
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
	$product_categories = $data['product_categories'];
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

	<form id="promotion_update">
	<table class="form-table">
		<tr class="user-productname-wrap">
			<th><label for="couponcode"><?php _e( 'Coupon Code' ); ?></label></th>
	<?php

	echo '<td><input id="coupon_code" type="text" required value="'.$coupon_code.'"/></td></tr><br/>';

	?>
	<tr class="user-promotiondescription-wrap">
			<th><label for="promotiondescription"><?php _e( 'Promotion Description' ); ?></label></th>
	<?php
	echo '<td><input id="promotion_description" type="text" required value="'.$promotion_description.'"/></td></tr><br/>';
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
	<tr class="user_discount_amount_count-wrap">
		<th><label for="discountamount"><?php _e( 'Discount Amount' ); ?></label></th>
	<?php
		if($promotion_type=='Fixed_Amount'){
			echo '<td><input id="discount_amount" type="text" required value="'.$discount_amount.'" /></td></tr>';
		}else{
			echo '<td><input id="discount_amount" type="text" value="'.$discount_amount.'" readonly/></td></tr>';
		}
	?>
	<tr class="user-percentage_off_count-wrap">
		<th><label for="percentageoff"><?php _e( 'Percentage Off' ); ?></label></th>
	<?php
		if($promotion_type=='Percentage_Off'){
			echo '<td><input id="percentage_off" type="text" required value="'.$percentage_off.'" /></td></tr>';
		}else{
			echo '<td><input id="percentage_off" type="text" value="'.$percentage_off.'" readonly/></td></tr>';
		}
	?>
	<tr class="user-minimum_spend-wrap">
		<th><label for="minimumspend"><?php _e( 'Minimum Spend Amount' ); ?></label></th>
	<?php
		echo '<td><input id="minimum_spend" type="text" required value="'.$minimum_spend.'"/></td></tr>';
	?>
	<tr class="product_categories-wrap">
			<th><label for="product_categories"><?php _e( 'Product Categories' ); ?></label></th>
	<?php
		$product_categories_array2 = array('Rental_Packages','Storage_Packages','Residential_Packages');
		echo '<td><select id="product_categories" multiple>';
		$product_categories_array =explode(',',$product_categories);
		foreach($product_categories_array2 as $value){

			$value1 = str_replace("_", " ", $value);
			if(in_array($value, $product_categories_array)){
				echo '<option selected="true" value="$value">'.$value1.'</option>';
			}else{
				echo '<option value="$value">'.$value1.'</option>';
			}
		}
		echo '</select></td></tr>';
	?>	
	<tr class="start_date-wrap">
			<th><label for="startdate"><?php _e( 'Start Date' ); ?></label></th>
	<?php
		echo '<td><input id="promotion_start_date" type="date" value="'.$promotion_start_date.'"/></td></tr>';
	?>	
	<tr class="end_date-wrap">
			<th><label for="promotionenddate"><?php _e( 'End Date' ); ?></label></th>
	<?php
		echo '<td><input id="promotion_end_date" required type="date" value="'.$promotion_end_date.'"/></td></tr>';
	?>
	<tr class="end_date-wrap">
			<th><label for="usage_limit_per_user"><?php _e( 'Usage Limit Per User' ); ?></label></th>
	<?php	
		echo '<td><input id="usage_limit_per_user" required type="text" value="'.$usage_limit_per_user.'"/></td></tr>';
		echo '</table>';
		echo '<input id="update_promotions" type="Submit" value="Update Promotions"/></form>';


	 }
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
?>
<script>
		jQuery(document).ready(function(){
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
			jQuery( "#promotion_update" ).submit(function() {

				var promotion_id = jQuery("#promotion_id").val().trim();
				//alert(promotion_id);

				var coupon_code = jQuery("#coupon_code").val().trim();
				//alert(coupon_code);

				var promotion_type = jQuery("#promotion_type").val().trim();
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

				
				var datastring ="ajax_request=promotions_update&promotion_id="+promotion_id+"&coupon_code="+coupon_code+"&promotion_type="+promotion_type+"&discount_amount="+discount_amount+"&percentage_off="+percentage_off+"&minimum_spend="+minimum_spend+"&product_categories="+product_categories+"&promotion_start_date="+promotion_start_date+"&promotion_end_date="+promotion_end_date+"&usage_limit_per_user="+usage_limit_per_user;
				
				alert(datastring);
				console.log(datastring);

				jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    
					    alert("Promotions Updated");

					    window.location="http://localhost/rebow/wp-admin/admin.php?page=coupons_promos";
					}
				});
			});
		});
		</script>

