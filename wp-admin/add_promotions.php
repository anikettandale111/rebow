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

		$promotion_id = 0;
		$promotion_type = '';
		$promotion_description = '';
		$coupon_code = '';
		$discount_amount = 0;
		$percentage_off = 0;
		$minimum_spend = '';
		$product_categories = '';
		$promotion_start_date = '';
		$promotion_end_date = '';
		$usage_limit_per_user = '';
		$request_from = 'add_promotions';
		$button_name = "Add Promotion";
		$promotion_type_array= array('Fixed_Amount'=>'Fixed Amount','Percentage_Off'=>'Percentage Off');

	if(isset($_GET['promotions'])) {
		$promotion_id = $_GET['promotions'];
		$con = mysql_connect("localhost","root","");
		if (!$con) {
		    die('Could not connect: ' . mysql_error());
		}
		mysql_set_charset('utf8');
		$db = mysql_select_db("rebow");
		$query="select * from promotions where promotion_id=".$promotion_id;
		$res = mysql_query($query,$con);
		$data = mysql_fetch_assoc($res);
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
		$request_from = 'promotions_update';
		$button_name = "Update Promotion";
	}
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
<div class="col-sm-12" style="background:white">
	<center><h3> Promo Code Management (Add, Edit)</h3></center>
		<form class="form-group" id="promotionForm">
			<div class="row">
				<input id="promotion_id" type="hidden" value="<?php echo $promotion_id ?>"/>
				<input id="request_from" type="hidden" value="<?php echo $request_from ?>"/>
				<div class="col-sm-6">
					<label for="couponcode"><?php _e( 'Coupon Code' ); ?></label>
					<input class="form-control" autocomplete="off" id="coupon_code" type="text" value="<?php echo $coupon_code ?>" required/>
					<label for="promotiondescription"><?php _e( 'Promotion Description' ); ?></label>
					<input class="form-control" autocomplete="off" id="promotion_description" type="text" value="<?php echo $promotion_description ?>" required/>
					<label for="promotiondescription">Promotion Type</label>
					<select class="form-control" autocomplete="off" id="promotion_type" name="promotion_type" required>
						<option  value="" >Select Promotion Type</option>
						<?php foreach($promotion_type_array as $key=>$value){
							if($key==$promotion_type){
								echo '<option selected="true" value="'.$key.'">'.$value.'</option>';
							}else{
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
						} ?>
					</select>
					<label for="discountamount"><?php _e( "Discount Amount" ); ?></label>
					<?php
						if($promotion_type=='Fixed_Amount'){
							echo '<input id="discount_amount" class="form-control" min="0" type="number" required value="'.$discount_amount.'" />';
						}else{
							echo '<input id="discount_amount" class="form-control" min="0" type="number" value="'.$discount_amount.'" readonly/>';
						}
					?>
					<label for="percentageoff"><?php _e( 'Percentage Off' ); ?></label>
					<?php
						echo '<label for="percentageoff"><?php _e( "Percentage Off" ); ?></label>';
						if($promotion_type=='Percentage_Off'){
							echo '<input id="percentage_off" class="form-control" min="0" max="100" type="number" required value="'.$percentage_off.'" />';
						}else{
							echo '<input id="percentage_off" class="form-control" min="0" max="100" type="number" value="'.$percentage_off.'" readonly/>';
						}
					?>
					<label for="minimumspend"><?php _e( 'Minimum Spend Amount' ); ?></label>
					<input class="form-control" autocomplete="off" id="minimum_spend" min="0" type="number" value="<?php echo $minimum_spend ?>" />
				</div>
				<div class="col-sm-6">
					<label for="product_categories"><?php _e( 'Product Categories' ); ?></label><br>
<!-- 					<input type="checkbox" id="selectall"/>
					<label><h3>Select All</h3></label> -->
					<?php 
					$product_categories_array =explode(',',$product_categories); ?>
					<input type="checkbox" class="form-control case" name="product_cat" value="Rental_Packages" <?php echo(in_array('Rental_Packages', $product_categories_array)) ? "checked" : "" ?> >
					<label><h3>Rental Packages</h3></label>
					<input type="checkbox" class="form-control case" name="product_cat" value="Storage_Packages" <?php echo(in_array('Storage_Packages', $product_categories_array)) ? "checked" : "" ?> />
					<label><h3>Storage Packages</h3></label>
					<input type="checkbox" class="form-control case" name="product_cat" value="Residential_Packages"<?php echo(in_array('Residential_Packages', $product_categories_array)) ? "checked" : "" ?> />
					<label><h3>Residential Packages</h3></label>
					<input type="hidden" name="product_categories" id="product_categories" value="<?php echo $product_categories?>">
					<br>
					<label for="startdate"><?php _e( 'Start Date' ); ?></label>
					<input id="promotion_start_date" class="form-control" type="date" value="<?php echo $promotion_start_date; ?>" required/>
					<label for="promotionenddate"><?php _e( 'End Date' ); ?></label>
					<input id="promotion_end_date" class="form-control" type="date" value="<?php echo $promotion_end_date; ?>" required/>
					<label for="usage_limit_per_user"><?php _e( 'Usage Limit Per User' ); ?></label>
					<input id="usage_limit_per_user" class="form-control" autocomplete="off" min="0" type="number" value="<?php echo $usage_limit_per_user ?>" required/>
				</div>
			</div>
		<button class="btn btn-success" id="add_promotions" type="button" style="padding: 10px;margin: 20px;"><?php echo $button_name?></button>
	</form >
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
</div>
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
					jQuery("#percentage_off").val('');
					jQuery("#discount_amount").prop("readonly", false);
				}else{
					jQuery("#discount_amount").prop("readonly", true);
					jQuery("#discount_amount").val('');
					jQuery("#percentage_off").prop("readonly", false);
				}
			});
			jQuery('#discount_amount').change(function(){
				var disc_amt = $(this).val();
				var mini_spend = jQuery("#minimum_spend").val();
				if(parseInt(disc_amt) >= parseInt(mini_spend)){
					alert('Discount amount not greater than Minimum Spend Amount');
					$(this).val('0');
					$(this).focus();
				}
			});
			
			$( "#add_promotions" ).click(function() {
				//var promotion_id = jQuery("#promotion_id").val().trim();
				//alert(promotion_id);
				var coupon_code = jQuery("#coupon_code").val().trim();
				//alert(coupon_code);
				if(coupon_code == null || coupon_code == '' || coupon_code.length != 8){
					alert('Please Enter valid Coupon code.');
					jQuery("#coupon_code").focus();
					return false;
				}
				var promotion_description = jQuery("#promotion_description").val().trim();
				//alert(promotion_type);
				if(promotion_description == null || promotion_description == '' ){
					alert('Please Enter Promotion description.');
					jQuery("#promotion_description").focus();
					return false;
				}
				var promotion_type = jQuery("#promotion_type").val().trim();
				if(promotion_type == null || promotion_type == '' ){
					alert('Please Select Promotion type.');
					jQuery("#promotion_type").focus();
					return false;
				}
				if(promotion_type == 'Fixed_Amount'){
					var discount_amount = jQuery("#discount_amount").val().trim();
					//alert(discount_amount);
					if(discount_amount == null || discount_amount == '' || discount_amount <= 0){
						alert('Please Enter Promotion Discount Amount.');
						jQuery("#discount_amount").focus();
						return false;
					}
				}else{
					var percentage_off = jQuery("#percentage_off").val().trim();
					//alert(percentage_off);
					if(percentage_off == null || percentage_off == '' || percentage_off <= 0){
						alert('Please Enter Discount Amount.');
						jQuery("#percentage_off").focus();
						return false;
					}
				}


				var minimum_spend =jQuery("#minimum_spend").val();
				//alert(minimum_spend);
				if(minimum_spend == null || minimum_spend == '' || minimum_spend <= 0){
					alert('Please Enter minium Bill Amount.');
					jQuery("#minimum_spend").focus();
					return false;
				}


				var promotion_start_date = jQuery("#promotion_start_date").val().trim();
				//alert(promotion_start_date);
				if(promotion_start_date == null || promotion_start_date == '' ){
					alert('Promotion Start Date Required.');
					jQuery("#promotion_start_date").focus();
					return false;
				}

				var promotion_end_date = jQuery("#promotion_end_date").val().trim();
				//alert(promotion_end_date);
				if(promotion_end_date == null || promotion_end_date == '' ){
					alert('Promotion End Date Required.');
					jQuery("#promotion_end_date").focus();
					return false;
				}

				var usage_limit_per_user = jQuery("#usage_limit_per_user").val().trim();
				//alert(usage_limit_per_user);
				if(usage_limit_per_user == null || usage_limit_per_user == '' || usage_limit_per_user <= 0){
					alert('Promotion Uses limit Per user .');
					jQuery("#usage_limit_per_user").focus();
					return false;
				}

				if($('#product_categories').val() == null || $('#product_categories').val() == '' ){
					alert('Please select atleast one checkbox.');
					jQuery("#product_categories").focus();
					return false;
				}
				var product_categories = jQuery("#product_categories").val();
				var request_from = jQuery("#request_from").val();
				var promotion_id = jQuery("#promotion_id").val();
				
				var datastring ="ajax_request="+request_from+"&promotion_id="+promotion_id+"&coupon_code="+coupon_code+"&promotion_type="+promotion_type+"&discount_amount="+discount_amount+"&percentage_off="+percentage_off+"&minimum_spend="+minimum_spend+"&product_categories="+product_categories+"&promotion_start_date="+promotion_start_date+"&promotion_end_date="+promotion_end_date+"&usage_limit_per_user="+usage_limit_per_user+"&promotion_description="+promotion_description;
				
				jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    //alert(result);
					    alert("Coupon Saved Successfully.");
					    var site = '<?php echo site_url() ?>';
					    window.location.href= site+"/wp-admin/admin.php?page=coupons_promos";
					}
				});
			});
			
		});
		$('.global_date').datepicker({
			startDate: "today",
			daysOfWeekDisabled: [0,6],
			format: "M dd, yyyy ",
			autoclose:true,
		});
		$(function(){
	// add multiple select / deselect functionality
	$("#selectall").click(function () {
		$('.case').attr('checked', this.checked);
		var val = [];
		$(':checkbox:checked').each(function(i){
			val[i] = $(this).val();
		});
		$('#product_categories').val(val);
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
		$(".case").change(function(){
			if($(".case").length == $(".case:checked").length) {
				$("#selectall").attr("checked", "checked");
			} else {
				$("#selectall").removeAttr("checked");
				$("#selectall").removeAttr("checked");
			}
		        var val = [];
		        $(':checkbox:checked').each(function(i){
		          val[i] = $(this).val();
		        });
		        $('#product_categories').val(val);
			});
		});
		$('#coupon_code').keydown(function(){
			var check_promo =  $(this).val();
			if(check_promo.length == 8){
				jQuery.ajax({
				url: "test-plugin-api.php",
				method : "POST",
				data : {ajax_request:'check_new_promo',newpromo:check_promo},
				datatype:'json',
				success: function(result){
					var obj = jQuery.parseJSON(result);
					if(obj.status == "exits"){
						alert(obj.message);
						$('#coupon_code').val('');
						$('#coupon_code').focus();
					}
				}
				});
			}
		});		
		</script>