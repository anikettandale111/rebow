<?php
/**
 * Edit user administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
include( ABSPATH . 'wp-admin/admin-header.php' );
$product_id = $_REQUEST['product'];
$packages_data = get_packages_data($product_id);


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

	$price_for_first2weeks = get_rental_price($product_id,2,2);
	$price_for_after2weeks = get_per_week_price($product_id);
	$price_for_1month = get_storage_price($product_id,1,1);
	
	$array_boxe_increments= array(8=>8,12=>12,16=>16,20=>20,24=>24,28=>28,32=>32,36=>36,40=>40,44=>44,48=>48,52=>52,56=>56,60=>60,64=>64,68=>68,72=>72,76=>76,80=>80,84=>84,88=>88,92=>92,96=>96,100=>100);
	
	?>
<div class="col-sm-12" style="background:white">
	<center><h3>Edit Package</h3></center>
	<form class="form-group" id="promotionForm">
			<div class="row">
				<input id="product_id" type="hidden" value="<?php echo $product_id ?>"/>
				<div class="col-sm-6">
					<label for="productname">Product Name (15 letters Only)</label>
					<input class="form-control" id="product_name" type="text" value="<?php echo $product_name; ?>"/>
					<label for="producttype">Product Type</label>
					<select class="form-control" id="product_type" name="product_type">
						<option selected value="">Select Package Type</option>
						<option value="RESIDENTIAL" <?php echo ($product_type =="RESIDENTIAL")? 'selected': '' ?> >Residential</option>
						<option value="OFFICE" <?php echo ($product_type =="OFFICE")? 'selected': '' ?> >Office</option>
						<option value="STUDENTS" <?php echo ($product_type =="STUDENTS")? 'selected': '' ?> >Student</option>
					</select>
					<label for="productrange">Product Range</label>
					<input class="form-control" id="product_range" type="text" value="<?php echo $product_range; ?>"/>
					<label for="boxcount">Box Count</label>
					<select class="form-control" id="box_count" name="box_count">
						<option value="">Select Box Count </option>
						<?php
							foreach($array_boxe_increments as $key=>$value){
								if($key == $box_count){
									echo '<option selected="true" value="'.$value.'">'.$value.'</option>';
								}else{
									echo '<option value="'.$value.'">'.$value.'</option>';
								}
							}
						?>
					</select>
					<label for="nestabledolliescount">Nestable Dollies Count</label>
					<input class="form-control" id="nestable_dollies_count" type="text" readonly value="<?php echo $nestable_dollies_count ?>"/>
				</div>
				<div class="col-sm-6">
					<label for="labelscount">Labels Count</label>
					<input class="form-control" id="labels_count" type="text" readonly value="<?php echo $labels_count ?>"/>
					<label for="ziptiescount">Zipties Count</label>
					<input class="form-control" id="zipties_count" type="text" readonly value="<?php echo $zipties_count ?>"/>
					<label for="price2weeks">Price for first 2 weeks</label>
					<input class="form-control" id="price2weeks" type="text" value="<?php echo $price_for_first2weeks; ?>"/>
					<label for="priceafter2weeks">Price After 2 weeks</label>
					<input class="form-control" id="priceafter2weeks" type="text" value="<?php echo $price_for_after2weeks; ?>"/>		
					<label for="price_for_1month">Monthly Stoage Cost</label>
					<input class="form-control" id="price_for_1month" type="text" value="<?php echo $price_for_1month; ?>"/>
				</div>
			</div>
		<button class="btn btn-success" id="update_packages" type="button" style="padding: 10px;margin: 20px;">Update Package</button>
	</form>
</div>
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
				if(product_name == null || product_name == '' || product_name.length >= 15){
					alert('Please Enter Product Name.');
					jQuery("#product_name").focus();
					return false;
				}

				var product_type = jQuery("#product_type").val().trim();
				//alert(product_type);
				if(product_type == null || product_type == '' ){
					alert('Please Enter valid Product Type.');
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
				
				var datastring ="ajax_request=packages_update&product_id="+product_id+"&product_name="+product_name+"&product_type="+product_type+"&product_range="+product_range+"&box_count="+box_count+"&nestable_dollies_count="+nestable_dollies_count+"&labels_count="+labels_count+"&zipties_count="+zipties_count+"&price2weeks="+price2weeks+"&priceafter2weeks="+priceafter2weeks+"&price_for_1month="+price_for_1month;
				
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

