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
$product_id = $_REQUEST['product'];
$packages_data = get_packages_data($product_id);
/*$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");*/

function get_packages_data($product_id){
	$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	//mysql_query('SET names utf8');
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");
	$query="select * from products where product_id=".$product_id;

	$res = mysql_query($query,$con);

	$data = mysql_fetch_assoc($res);
	//echo "<pre>";
	//print_r($data);

	//echo "product_name".
	$product_id = $data['product_id'];
	$product_name = $data['product_name'];
	$product_type = $data['product_type'];
	$product_range = $data['product_range'];
	$box_count = $data['box_count'];
	$nestable_dollies_count = $data['nestable_dollies_count'];
	$labels_count = $data['labels_count'];
	$zipties_count = $data['zipties_count'];
	//$zipties_count = $data['zipties_count'];

	$price_for_first2weeks = get_price($product_id,'2','Week');
	$price_for_3weeks = get_price($product_id,'3','Week');
	$price_for_4weeks = get_price($product_id,'4','Week');

	$price_for_after2weeks = get_expiry_price($product_id,'2','Week');
	$price_for_after3weeks = get_expiry_price($product_id,'3','Week');
	$price_for_after4weeks = get_expiry_price($product_id,'4','Week');

	$price_for_1month = get_price($product_id,'1','Month');
	$price_for_2months = get_price($product_id,'2','Month');
	$price_for_3months = get_price($product_id,'3','Month');
	$price_for_4months = get_price($product_id,'4','Month');

	$price_for_after1month = get_expiry_price($product_id,'1','Month');
	$price_for_after2months = get_expiry_price($product_id,'2','Month');
	$price_for_after3months = get_expiry_price($product_id,'3','Month');
	$price_for_after4months = get_expiry_price($product_id,'4','Month');

	$pricing_dropdown_array = array('Weekly'=>'Weekly','Monthly'=>'Monthly');
	$array_boxe_increments= array(8=>8,12=>12,16=>16,20=>20,24=>24,28=>28,32=>32,36=>36,40=>40,44=>44,48=>48,52=>52,56=>56,60=>60,64=>64,68=>68,72=>72,76=>76,80=>80,84=>84,88=>88,92=>92,96=>96,100=>100);
	$week_rental = get_base_pricing('Rental_cost_per_1_box_per_1_week');
	$monthly_storage = get_base_pricing('Monthly_storage_cost_per_box');
	echo '<input id="product_id" type="hidden" value="'.$product_id.'"/>';

	echo '<input id="week_rental_id" type="hidden" value="'.$week_rental.'"/>';

	echo '<input id="monthly_storage_id" type="hidden" value="'.$monthly_storage.'"/>';
	?>
	<table class="form-table">
		<tr class="user-productname-wrap">
			<th><label for="productname"><?php _e( 'Product Name' ); ?></label></th>
	<?php

	echo '<td><input id="product_name" type="text" value="'.$product_name.'"/></td></tr><br/>';

	?>
	<tr class="user-producttype-wrap">
			<th><label for="producttype"><?php _e( 'Product Type' ); ?></label></th>
	<?php
	echo '<td><input id="product_type" type="text" value="'.$product_type.'"/></td></tr><br/>';
	?>
	<tr class="user-productrange-wrap">
			<th><label for="productrange"><?php _e( 'Product Range' ); ?></label></th>
	<?php
	echo '<td><input id="product_range" type="text" value="'.$product_range.'"/></td></tr><br/>';
	?>
	<tr class="user-box_count-wrap">
			<th><label for="boxcount"><?php _e( 'Box Count' ); ?></label></th>
	<?php
	echo '<td><select id="box_count" name="box_count">';
	//echo '<td><selct id="box_count" value="'.$box_count.'"/></td></tr>';
	foreach($array_boxe_increments as $key=>$value){
		if($key==$box_count){
			echo '<option selected="true" value="'.$value.'">'.$value.'</option>';
		}else{
			echo '<option value="'.$value.'">'.$value.'</option>';
		}
	}

	echo '</td></select></tr>';
	?>
	<tr class="user-pricngselect-wrap">
			<th><label id="pricing_drp1" for="pricing_drp1"><?php _e( 'Select Period' ); ?></label></th>
	<?php
	echo '<td><select id="pricing_drp" name="pricing_drp">';
	//echo '<td><selct id="box_count" value="'.$box_count.'"/></td></tr>';
	foreach($pricing_dropdown_array as $key=>$value){
		if($key=='Weekly_Price'){
			echo '<option selected="true" value="'.$key.'">'.$value.'</option>';
		}else{
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}

	echo '</td></select></tr>';
	?>
	<tr class="user-nestable_dollies_count-wrap">
		<th><label for="nestabledolliescount"><?php _e( 'Nestable Dollies Count' ); ?></label></th>
	<?php
		echo '<td><input id="nestable_dollies_count" type="text" value="'.$nestable_dollies_count.'" readonly/></td></tr>';
	?>
	<tr class="user-nestable_dollies_count-wrap">
		<th><label for="nestable_dollies_count"><?php _e( 'Labels Count' ); ?></label></th>
	<?php
		echo '<td><input id="labels_count" type="text" value="'.$labels_count.'" readonly/></td></tr>';
	?>
	<tr class="user-zipties_count-wrap">
		<th><label for="ziptiescount"><?php _e( 'Zipties Count' ); ?></label></th>
	<?php
		echo '<td><input id="zipties_count" type="text" value="'.$zipties_count.'" readonly/></td></tr>';
	?>
	<?php 
	
	echo "<tr class='price2weeks-wrap'>
			<th><label for='price2weeks'>Price For First 2 Weeks</label></th>
			<td><input id='price2weeks' type='text' value=$price_for_first2weeks></td></tr>";
	?>
	<?php
	echo '<tr class="priceafterweeks-wrap">
			<th><label for="priceafterweeks">Price After Weeks</label></th>';

	echo '<td width="50px">
			<label for="selectweek">Select Week: </label>
			<select id="selectweekperiod">
				<option selected="true" value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</td>';
	echo '<td><input id="priceafterweeks" type="text" value="'.$price_for_after2weeks.'"/></td></tr>';
	?>	
	<?php
	echo '<tr class="price_for_1month-wrap">
			<th><label for="ziptiescount">Monthly Storage Cost</label></th>';

		echo '<td><input id="price_for_1month" type="text" value="'.$price_for_1month.'"/></td></tr>';
		

		echo '<tr class="price_for_after1month-wrap">
			<th><label for="ziptiescount">Price After Month</label></th>';
		echo '<td width="50px"><label for="selectmonth">Select Month: </label>
			<select  id="selectmonthperiod">
				<option selected="true" value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select>
		</td>';
		echo '<td><input id="price_for_after1month" type="text" value="'.$price_for_after1month.'"/></td></tr>';

		echo '</table><input id="update_packages" type="Submit" value="Update Packages"/>';
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
?>
	<script>
		jQuery(document).ready(function(){
			jQuery('.price_for_1month-wrap').hide();
		        	jQuery('.price_for_after1month-wrap').hide();
			jQuery("#box_count").change(function() {
		        //alert("Changed");
		       	var box_count =jQuery("#box_count").val();

		       	//var price_for_2_weeks = (box_count*2*3);

		       	//var price_for_1month = (box_count*);

		       	var week_rental_cost_per_box = jQuery("#week_rental_id").val();

		       	var monthly_storage_cost_per_box = jQuery("#monthly_storage_id").val();
		       	//alert(monthly_storage_cost_per_box);
		       	week_rental_cost = (week_rental_cost_per_box*2*box_count);

		       	monthly_storage_cost = (monthly_storage_cost_per_box*box_count);
		       	jQuery("#price2weeks").val(week_rental_cost);
		       	jQuery("#priceafterweeks").val(week_rental_cost);
		       	jQuery("#price_for_1month").val(monthly_storage_cost);
		       	//alert(box_count);
		       	jQuery("#nestable_dollies_count").val(box_count/4);
		       	jQuery("#labels_count").val(box_count);
		       	jQuery("#zipties_count").val(box_count);
		       	//jQuery("#price2weeks").val(price_for_2_weeks);
		    });
		    jQuery("#pricing_drp").change(function() {
		        //alert("Changed");
		        var pricing_drp =jQuery("#pricing_drp").val();
		        if(pricing_drp=='Weekly'){
		        	jQuery('.price_for_1month-wrap').hide();
		        	jQuery('.price_for_after1month-wrap').hide();

		        	jQuery('.price2weeks-wrap').show();
		        	jQuery('.priceafterweeks-wrap').show();
		        }else if(pricing_drp=='Monthly'){
		        	jQuery('.price2weeks-wrap').hide();
		        	jQuery('.priceafterweeks-wrap').hide();

		        	jQuery('.price_for_1month-wrap').show();
		        	jQuery('.price_for_after1month-wrap').show();
		        }
		       	//var box_count =jQuery("#box_count").val();
		       	//var box_count =jQuery("#box_count").val();
		       	

		       	
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

				var price2weeks = jQuery("#price2weeks").val();
				//alert(price2weeks);

				var priceafter2weeks = jQuery("#priceafterweeks").val();
				//alert(priceafter2weeks);

				var price_for_1month = jQuery("#price_for_1month").val();

				var price_for_after1month = jQuery("#price_for_after1month").val();

				var week_rental_cost_per_box = jQuery("#week_rental_id").val();

		       	var monthly_storage_cost_per_box = jQuery("#monthly_storage_id").val();

		       	var pricing_drp =jQuery("#pricing_drp").val();
				//alert(price_for_1month);
				if(pricing_drp=='Weekly'){
					var selectweekperiod = jQuery("#selectweekperiod").val();
					var datastring ="ajax_request=packages_update&product_id="+product_id+"&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&price2weeks="+price2weeks+"&priceafter2weeks="+priceafter2weeks+"&pricing_drp="+pricing_drp+"&selectweekperiod="+selectweekperiod;
				}else{
					var selectmonthperiod = jQuery("#selectmonthperiod").val();
					var datastring ="ajax_request=packages_update&product_id="+product_id+"&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&price_for_after1month="+price2weeks+"&price_for_1month="+price_for_1month+"&selectmonthperiod="+selectmonthperiod;
				}
				
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
		</script>

