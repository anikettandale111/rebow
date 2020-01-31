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
//$product_id = $_REQUEST['product'];
//$packages_data = get_packages_data($product_id);
/*$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");*/
	$week_rental = get_base_pricing('Rental_cost_per_1_box_per_1_week');
	$monthly_storage = get_base_pricing('Monthly_storage_cost_per_box');
	//echo '<input id="product_id" type="hidden" value="'.$product_id.'"/>';

	echo '<input id="week_rental_id" type="hidden" value="'.$week_rental.'"/>';

	echo '<input id="monthly_storage_id" type="hidden" value="'.$monthly_storage.'"/>';
?>

<table class="form-table">
	<tr class="productname-wrap">
		<th><label for="productname">Product Name</label></th>
		<td><input id="product_name" type="text" value="" required/></td>
	</tr>
	
	<tr class="producttype-wrap">
		<th><label for="producttype">Product Type</label></th>
		<td>
			<select id="product_type" name="product_type">
				<option selected="true" value="Select Product Type">Select Package Type</option>
				<option value="Residential">Residential</option>
				<option value="Office">Office</option>
				<option value="Student">Student</option>
			</select>
		</td>
	</tr>
	
	<tr class="productrange-wrap">
		<th><label for="productrange">Product Range</label></th>
		<td><input id="product_range" type="text" value="" required/></td>
	</tr>
	
	<tr class="box_count-wrap">
		<th><label for="boxcount">Box Count</label></th>
		<td>
			<select id="box_count" name="box_count">
				<option selected="true" value="8">8</option>
				<option value="12">12</option>
				<option value="16">16</option>
				<option value="20">20</option>
				<option value="24">24</option>
				<option value="28">28</option>
				<option value="32">32</option>
				<option value="36">36</option>
				<option value="40">40</option>
				<option value="44">44</option>
				<option value="48">48</option>
				<option value="52">52</option>
				<option value="56">56</option>
				<option value="60">60</option>
				<option value="64">64</option>
				<option value="68">68</option>
				<option value="72">72</option>
				<option value="76">76</option>
				<option value="80">80</option>
				<option value="84">84</option>
				<option value="88">88</option>
				<option value="92">92</option>
				<option value="96">96</option>
				<option value="100">100</option>
			</select>
		</td>
	</tr>
	
	<tr class="pricngselect-wrap">
		<th><label id="pricing_drp1" for="pricing_drp1"><?php _e( 'Select Period' ); ?></label></th>
	
		<td>
			<select id="pricing_drp" name="pricing_drp">
				<option selected="true" value="Weekly">Weekly</option>
				<option value="Monthly">Monthly</option>
			</select>
		</td>
	</tr>	
	<tr class="nestable_dollies_count-wrap">
		<th><label for="nestabledolliescount">Nestable Dollies Count</label></th>
		<td><input id="nestable_dollies_count" type="text" required value=""/></td>
	</tr>
	
	<tr class="labels_count-wrap">
		<th><label for="labelscount">Labels Count</label></th>
		<td><input id="labels_count" type="text" required value=""/></td>
	</tr>
	
	<tr class="zipties_count-wrap">
		<th><label for="ziptiescount">Zipties Count</label></th>
		<td><input id="zipties_count" type="text" required value=""/></td>
	</tr>
	
	<tr class="price2weeks-wrap">
		<th><label for="price2weeks">Price for first 2 weeks</label></th>
		<td><input id="price2weeks" type="text" required value=""/></td>
	</tr>
	
	<tr class="priceafterweeks-wrap">
		<th><label for="priceafter2weeks">Price After 2 weeks</label></th>
		<td width="50px">
			<label for="selectweek">Select Week: </label>
			<select id="selectweekperiod">
				<option selected="true" value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</td>
		<td><input id="priceafter2weeks" type="text" required value=""/></td>
	</tr>
	
	<tr class="price_for_1month-wrap">
		<th><label for="price_for_1month">Monthly Stoage Cost</label></th>
		<td><input id="price_for_1month" type="text" required value=""/></td>
	</tr>
	<tr class="price_for_after1month-wrap">
			<th><label for="ziptiescount">Price After Month</label></th>
			<td width="50px"><label for="selectmonth">Select Month: </label>
			<select  id="selectmonthperiod">
				<option selected="true" value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select>
		</td>
		<td><input id="price_for_after1month" type="text" required value=""/>
		</td>
	</tr>
	
</table>
<input type="submit" id="add_package" value="Add Package"/>
<script>
		jQuery(document).ready(function(){
			jQuery('.price_for_1month-wrap').hide();
		    jQuery('.price_for_after1month-wrap').hide();

			jQuery("#box_count").change(function() {
		        //alert("Changed");
		       	var box_count =jQuery("#box_count").val();
		       	//alert(box_count);
		       	var week_rental_cost_per_box = jQuery("#week_rental_id").val();

		       	var monthly_storage_cost_per_box = jQuery("#monthly_storage_id").val();
		       	//alert(monthly_storage_cost_per_box);
		       	week_rental_cost = (week_rental_cost_per_box*2*box_count);

		       	monthly_storage_cost = (monthly_storage_cost_per_box*box_count);
		       	jQuery("#price2weeks").val(week_rental_cost);
		       	jQuery("#priceafterweeks").val(week_rental_cost);
		       	jQuery("#price_for_1month").val(monthly_storage_cost);
		       	jQuery("#price_for_after1month").val(monthly_storage_cost);
		       	//alert(box_count);
		       	jQuery("#nestable_dollies_count").val(box_count/4);
		       	jQuery("#labels_count").val(box_count);
		       	jQuery("#zipties_count").val(box_count);
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
		       	

		       	
		    });
		    jQuery("#add_package" ).click(function() {

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
				var pricing_drp =jQuery("#pricing_drp").val();

				var price2weeks = jQuery("#price2weeks").val().trim();
				//alert(price2weeks);
				var priceafter2weeks = jQuery("#priceafter2weeks").val().trim();
				//alert(priceafter2weeks);
				var price_for_1month = jQuery("#price_for_1month").val().trim();

				var price_for_after1month = jQuery("#price_for_after1month").val().trim();

				var week_rental_cost_per_box = jQuery("#week_rental_id").val();

		       	var monthly_storage_cost_per_box = jQuery("#monthly_storage_id").val();
				//alert(price_for_1month);
				if(pricing_drp=='Weekly'){
					var selectweekperiod = jQuery("#selectweekperiod").val().trim();
					var datastring ="ajax_request=add_package&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&price2weeks="+price2weeks+"&priceafter2weeks="+priceafter2weeks+"&selectweekperiod="+selectweekperiod+"&pricing_drp="+pricing_drp+"&week_rental_cost_per_box="+week_rental_cost_per_box+"&monthly_storage_cost_per_box="+monthly_storage_cost_per_box;
				}else{
					var selectmonthperiod = jQuery("#selectmonthperiod").val().trim();
					var datastring ="ajax_request=add_package&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&selectmonthperiod="+selectmonthperiod+"&price_for_after1month="+price_for_after1month+"&price_for_1month="+price_for_1month+"&pricing_drp="+pricing_drp+"&week_rental_cost_per_box="+week_rental_cost_per_box+"&monthly_storage_cost_per_box="+monthly_storage_cost_per_box;
				}
				
				//alert(datastring);
				console.log(datastring);

				/*jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    alert(result);
					    console.log(result);
					    alert("New Package Added");
					}
				});*/
		    });

			
		});
		</script>

