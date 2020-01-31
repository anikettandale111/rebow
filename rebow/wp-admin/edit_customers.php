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
$user_id = $_REQUEST['user'];
//echo $user_id;
show_customer_details($user_id);

function get_user_details($user_id){
	$query = "select a.user_id as 'user_id',b.user_email as 'email',b.display_name as 'display_name',a.phone_number as 'phone_number',a.delivery_address as 'delivery_address',a.pickup_address as 'pickup_address' FROM customers a JOIN wp_users b ON a.user_id=b.ID where a.user_id=$user_id";

	$res = mysql_query($query);

	$row = mysql_fetch_assoc($res);

	return $row;
}


function show_customer_details($user_id){
	//echo "<table  class='wp-list-table widefat fixed striped posts'>";
	$user_data = get_user_details($user_id);

	$email = $user_data['email'];

	$display_name = $user_data['display_name'];

	$phone_number = $user_data['phone_number'];

	$delivery_address = $user_data['delivery_address'];

	$pickup_address = $user_data['pickup_address'];

?>
<form id="customer_data">
	<div class="form-row">
		<input type="text" id="email_id" value="<?php echo $email;?>"/>
	</div>
	<div class="form-row">
		<input type="text" id="user_name" value="<?php echo $display_name;?>"/>
	</div>
	<div class="form-row">
		<input type="text" id="phone_number" value="<?php echo $phone_number;?>"/>
	</div>	
	<div class="form-row">
		<input type="text" id="delivery_address" value="<?php echo $delivery_address;?>"/>
	</div>
	<button type="button" class="button wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password' ); ?></button>
	<button type="submit">UPDATE</button>
</form>
<?php }
?>

<script>
	jQuery(document).ready(function(){
		//alert(1);
		jQuery('#customer_data').submit(function(){
			//alert("form submit");

			var email_id = jQuery('#email_id').val();

			var user_name = jQuery('#user_name').val();

			var phone_number = jQuery('#phone_number').val();

			var delivery_address = jQuery('#delivery_address').val();

			//jQuery.ajax()

			/*jQuery.ajax({
				url: "test-plugin-api.php",
				method : "POST",
				data : datastring,
				success: function(result){
				    alert(result);
				    alert("Prices Updated");
				}
			});*/


		});
	});

</script>