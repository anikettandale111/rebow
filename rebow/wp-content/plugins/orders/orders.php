<?php

/*
Plugin Name: Orders Plugin
Description: A test plugin to demonstrate orders functionality
Author: Yogesh Patil
Version: 0.1
*/
//require_once( '/includes/loader.php' );
//require_once('db_config.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
add_action('admin_menu', 'test_plugin_orders_menu');

function test_plugin_orders_menu(){
       
    $menu = add_menu_page( 'Orders Page', 'Order', 'manage_options', 'Orders', 'test_init_order' );

    add_action( 'admin_print_styles-'. $menu, 'bootstrap_css');

}
function bootstrap_css(){
	wp_enqueue_style( 'bootsrap_css', 'boostrap.css');
}
function test_init_order(){

    echo "<div><h1>Orders </h1></div><br/>";
    
	show_orders();
}

function show_orders(){

	$sql="SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1;";

	$result = mysql_query($sql);
	//echo '<p><input type="search" id="search_order"/><button type="submit">Search Orders</button></p>';
	echo "<table class='wp-list-table widefat fixed striped posts'>";
	echo "<tr><th>Order ID</th><th>User Name</th><th>Date</th><th>Status</th><th>Total</th></tr>";
	
	while($row = mysql_fetch_assoc($result)){

		$order_id = $row['order_id'];

		$parent_order_id = $row['parent_order_id'];

		$product_id = $row['product_id'];

		$order_type = $row['order_type'];

		$display_name = $row['display_name'];

		$order_date = $row['order_date'];

		$total_price = $row['total_price'];

		$order_status = $row['order_status'];

		echo '<tr>';
		echo "<td><a class='orders_info' href='edit_orders.php?order=$order_id' id='<?php echo $order_id;?>'> #$order_id</a></td>";
		echo '<td> '.$display_name.'</td>';
		echo '<td>'.$order_date.'</td>';
		echo '<td>'.$order_status.'</td>';
		echo '<td> $'.$total_price.'</td>';
		echo '</tr>';

	}
}



?>	

