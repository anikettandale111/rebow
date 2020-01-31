<?php

/*
Plugin Name: Customers Plugin
Description: A test plugin to demonstrate Customers functionality
Author: Yogesh Patil
Version: 0.1
*/
//require_once( '/includes/loader.php');
//require_once('db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
add_action('admin_menu', 'test_plugin_customers_menu');
function test_plugin_customers_menu(){
    add_menu_page( 'Customers Page', 'Customers', 'manage_options', 'Customers', 'test_init_customer' );
}
function test_init_customer(){

    echo "Customer Admin Page";

    show_customers_data();
}
function show_customers_data(){
	
	$query = "select a.user_id as 'user_id',b.user_email as 'email',b.display_name as 'display_name',a.phone_number as 'phone_number' FROM customers a JOIN wp_users b ON a.user_id=b.ID";
	$res = mysql_query($query);
	echo "<table  class='wp-list-table widefat fixed striped posts'>
			<tr><th >Customer Name</th><th >Email ID</th><th >phone_number</th><th></th></tr>";
	while($row=mysql_fetch_assoc($res)){

		$user_id = $row['user_id'];

		$email = $row['email'];

		$display_name = $row['display_name'];

		$phone_number = $row['phone_number'];

		?>
		
		<tr>
			<td><?php echo $display_name;?></td>

			<td><?php echo $email;?></td>

			<td><?php echo $phone_number;?></td>

			<?php echo "<td><a class='user_info_edit' href='user-edit.php?user_id=$user_id'>EDIT</a></td>";?>
		</tr>
		
	<?php }
	echo "</table>";
}
?>