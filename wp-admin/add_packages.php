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
$week_rental = get_base_pricing('Rental_cost_per_1_box_per_1_week');
$monthly_storage = get_base_pricing('Monthly_storage_cost_per_box');

echo '<input id="week_rental_id" type="hidden" value="'.$week_rental.'"/>';

echo '<input id="monthly_storage_id" type="hidden" value="'.$monthly_storage.'"/>';

?>
<div class="col-sm-12" style="background:white">
	<center><h3>Add New Package</h3></center>
		<form class="form-group" id="promotionForm">
			<div class="row">
				<div class="col-sm-6">
					<label for="productname">Product Name (15 letters Only)</label>
					<input class="form-control" id="product_name" type="text" value=""/>
					<label for="producttype">Product Type</label>
					<select class="form-control" id="product_type" name="product_type">
						<option selected value="">Select Package Type</option>
						<option value="RESIDENTIAL">Residential</option>
						<option value="OFFICE">Office</option>
						<option value="STUDENT">Student</option>
					</select>
					<label for="productrange">Product Range</label>
					<input class="form-control" id="product_range" type="text" value=""/>
					<label for="boxcount">Box Count</label>
					<select class="form-control" id="box_count" name="box_count">
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
					<label for="nestabledolliescount">Nestable Dollies Count</label>
					<input class="form-control" id="nestable_dollies_count" type="text" readonly value="2"/>
				</div>
				<div class="col-sm-6">
					<label for="labelscount">Labels Count</label>
					<input class="form-control" id="labels_count" type="text" readonly value="8"/>
					<label for="ziptiescount">Zipties Count</label>
					<input class="form-control" id="zipties_count" type="text" readonly value="8"/>
					<label for="price2weeks">Price for first 2 weeks</label>
					<input class="form-control" id="price2weeks" type="text" value=""/>
					<label for="priceafter2weeks">Price After 2 weeks</label>
					<input class="form-control" id="priceafter2weeks" type="text" value=""/>		
					<label for="price_for_1month">Monthly Stoage Cost</label>
					<input class="form-control" id="price_for_1month" type="text" value=""/>
				</div>
			</div>
		<button class="btn btn-success" id="add_package" type="button" style="padding: 10px;margin: 20px;">Add Package</button>
	</form>
</div>
<script>
		jQuery(document).ready(function(){
			
			jQuery("#box_count").change(function() {
		        //alert("Changed");
		       	var box_count =jQuery("#box_count").val();
		       	//alert(box_count);
		       	jQuery("#nestable_dollies_count").val(box_count/4);
		       	jQuery("#labels_count").val(box_count);
		       	jQuery("#zipties_count").val(box_count);

		       	var week_rental_cost_per_box = jQuery("#week_rental_id").val();

		       	var monthly_storage_cost_per_box = jQuery("#monthly_storage_id").val();
		       	//alert(monthly_storage_cost_per_box);
		       	week_rental_cost = (week_rental_cost_per_box*2*box_count);

		       	per_week_cost = week_rental_cost/2;

		       	monthly_storage_cost = (monthly_storage_cost_per_box*box_count);

		       	jQuery("#price2weeks").val(week_rental_cost);
		       	jQuery("#priceafter2weeks").val(per_week_cost);
		       	jQuery("#price_for_1month").val(monthly_storage_cost);
		    });
		    
		    jQuery("#add_package" ).click(function() {

		    	var product_name = jQuery("#product_name").val().trim();
				//alert(product_name);
				if(product_name == null || product_name == '' || product_name.length >= 15){
					alert('Please Enter valid Product Name.');
					jQuery("#product_name").focus();
					return false;
				}

				var product_type = jQuery("#product_type").val().trim();
				//alert(product_type);
				if(product_type == null || product_type == '' ){
					alert('Please Enter Product Type.');
					jQuery("#product_type").focus();
					return false;
				}

				var product_range = jQuery("#product_range").val().trim();
				//alert(product_range);
				if(product_range == null || product_range == '' ){
					alert('Please Enter Product Range.');
					jQuery("#product_range").focus();
					return false;
				}

				var box_count =jQuery("#box_count").val();
				//alert(box_count);
				if(box_count == null || box_count == '' ){
					alert('Please Enter Box Count.');
					jQuery("#box_count").focus();
					return false;
				}

				var nestable_dollies_count = jQuery("#nestable_dollies_count").val().trim();

				var labels_count = jQuery("#labels_count").val().trim();
				//alert(labels_count);
				if(labels_count == null || labels_count == '' ){
					alert('Please Enter Labels Count.');
					jQuery("#nestable_dollies_count").focus();
					return false;
				}

				var zipties_count = jQuery("#zipties_count").val().trim();
				//alert(zipties_count);
				if(zipties_count == null || zipties_count == '' ){
					alert('Please Enter Zipties Count.');
					jQuery("#zipties_count").focus();
					return false;
				}

				var price2weeks = jQuery("#price2weeks").val().trim();
				//alert(price2weeks);
				if(price2weeks == null || price2weeks == '' ){
					alert('Please Enter Price Two Weeks.');
					jQuery("#price2weeks").focus();
					return false;
				}

				var priceafter2weeks = jQuery("#priceafter2weeks").val().trim();
				//alert(priceafter2weeks);
				if(priceafter2weeks == null || priceafter2weeks == '' ){
					alert('Please Enter Price After Two Weeks.');
					jQuery("#priceafter2weeks").focus();
					return false;
				}

				var price_for_1month = jQuery("#price_for_1month").val().trim();
				//alert(price_for_1month);
				if(price_for_1month == null || price_for_1month == '' ){
					alert('Please Enter Price for One MOnth.');
					jQuery("#price_for_1month").focus();
					return false;
				}
				
				var datastring ="ajax_request=add_package&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&price2weeks="+price2weeks+"&priceafter2weeks="+priceafter2weeks+"&price_for_1month="+price_for_1month;
				
				//alert(datastring);
				console.log(datastring);

				jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    alert(result);
					    var site = '<?php echo site_url() ?>';
					    window.location.href= site+"/wp-admin/admin.php?page=test-plugin";
					}
				});
		    });

			
		});
		</script>

