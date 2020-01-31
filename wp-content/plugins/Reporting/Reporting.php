<?php
/*
Plugin Name: Reporting Plugin
Description: A test plugin to demonstrate Reporting functionality
Author: Yogesh Patil
Version: 0.1
*/
//require_once( '/includes/loader.php' );
//require_once('db_config.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
add_action('admin_menu', 'test_plugin_reporting_menu');

function test_plugin_reporting_menu(){
    add_menu_page( 'Inventory Page', 'Inventory', 'manage_options', 'Inventory', 'test_init_inventory','dashicons-media-spreadsheet' );

}
add_action('admin_menu', 'test_plugin_sales_menu');

function test_plugin_sales_menu(){
    add_menu_page( 'Sales Page', 'Sales', 'manage_options', 'Sales', 'test_init_sales','dashicons-chart-line');
}
function test_init_sales(){
	//echo "<b> sales page </b>";
	echo "<br/>";
	//echo "Sales Data for today: $".
	$sales_data_today = get_sales_data_for_today();
	//echo "<br/>";
	//echo "Sales Data for Weekly: $".
	$sales_data_weekly = get_sales_data_for_weekly();
	//echo "<br/>";
	//echo "Sales Data for Monthly: $".
	$sales_data_monthly = get_sales_data_for_monthly();
	//echo "<br/>";
	//echo "Sales Data for Quarterly: $".
	$sales_data_quarterly = get_sales_data_for_quarterly();
	//echo "<br/>";
	//echo "Sales Data for Yearly: $".
	$sales_data_yearly = get_sales_data_for_yearly();

	echo "<table class='wp-list-table widefat fixed striped posts'>";
	echo "<tr><th>Sales Data Today</th><th>Sales Data Weekly</th><th>Sales Data Monthly</th><th>Sales Data Quarterly</th><th>Sales Data Yearly</th></tr>";
	echo "<tr><td>$".$sales_data_today."</td><td>$".$sales_data_weekly."</td><td>$".$sales_data_monthly."</td><td>$".$sales_data_quarterly."</td><td>$".$sales_data_yearly."</td></tr></table>";

	/*$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1";

	$result = mysql_query($sql);
	echo "<br/>";

	//echo '<p><input type="search" id="search_order"/><button type="submit">Search Orders</button></p>';
	echo "<table class='wp-list-table widefat fixed striped posts'>";
	echo "<tr><th>Order Number</th><th>Customer</th><th>Date</th><th>Status</th><th>Delivery Address</th><th>Pickup Address</th><th># Boxes</th></tr>";

	while($row = mysql_fetch_assoc($result)){

		$order_id = $row['order_id'];

		$parent_order_id = $row['parent_order_id'];

		$product_id = $row['product_id'];

		$order_type = $row['order_type'];

		$display_name = $row['display_name'];

		$order_date = $row['order_date'];

		$total_price = $row['total_price'];

		$order_status = $row['order_status'];

		$boxes_count = ($row['box_count']+$row['added_box_count']);

		if($order_type=='RENTAL'){
			$shipping_type ='Delivery Empty Boxes';
			$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

			$shipping_type='Pickup Empty Boxes';
			$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		}else if($order_type=='STORAGE'){
			
			$shipping_type='Delivery Empty Boxes';
			$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

			$shipping_type='Delivery Packed Boxes';
			$deliver_packed_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

			$shipping_type='Pickup Packed Boxes';
			$pickup_packed_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

			$shipping_type='Pickup Empty Boxes';
			$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);
		}

		echo '<tr>';
		echo "<td><a class='orders_info' id='<?php echo $order_id;?>'> #$order_id</a></td>";
		echo '<td> '.$display_name.'</td>';
		echo '<td>'.$order_date.'</td>';
		echo '<td>'.$order_status.'</td>';
		echo '<td> '.$deliver_empty_boxes_data['address'].'</td>';
		echo '<td> '.$pickup_empty_boxes_data['address'].'</td>';
		echo '<td> '.$boxes_count.'</td>';
		echo '</tr>';
		
	}
	*/
	ob_start();

	include_once plugin_dir_path(__FILE__).'views/table-listings.php';

	$template = ob_get_contents();

	ob_end_clean();

	echo $template;
}
function get_sales_data_for_today(){
	$query = "SELECT sum(total_price) as 'total_pices_Sales' from orders_data WHERE date(created_at) = CURDATE()";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return $row[0];
}
function get_sales_data_for_weekly(){
	$query = "SELECT sum(total_price) as 'total_pices_Sales' from orders_data WHERE YEARWEEK(created_at) = YEARWEEK(CURDATE())";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return round($row[0],2);
}
function get_sales_data_for_monthly(){
	$query = "SELECT sum(total_price) as 'total_pices_Sales' from orders_data WHERE Year(created_at) = Year(CURDATE()) and MONTH(created_at) = MONTH(CURDATE())";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return round($row[0],2);
}
function get_sales_data_for_yearly(){
	$query = "SELECT sum(total_price) as 'total_pices_Sales' from orders_data WHERE Year(created_at) = Year(CURDATE())";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return round($row[0],2);
}
function get_sales_data_for_quarterly(){
	$query = "SELECT sum(total_price) as 'total_pices_Sales' from orders_data WHERE Quarter(created_at) = Quarter(CURDATE())";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return round($row[0],2);
}
//add_action('admin_menu', 'test_plugin_reporting_menu');
//add_action('admin_menu', 'test_plugin_reporting_menu');

function test_init_inventory(){

	echo "<div><h1>Inventory</h1></div><br/>";
	/*Report on # of Boxes Out for Delivery*/
	//echo "boxes_out_for_delivery: ".
	$boxes_out_for_delivery = get_data_boxes_out_for_delivery();
	if(empty($boxes_out_for_delivery)){
		$boxes_out_for_delivery = 0;
	}
	//echo "boxes_out_for_pickup: ".
	$boxes_out_for_pickup = get_data_boxes_out_for_pickup();
	if(empty($boxes_out_for_pickup)){
		$boxes_out_for_pickup = 0;
	}
	//echo "boxes_in_pack_mode: ".
	$boxes_in_pack_mode = get_boxes_in_pack_mode();
	if(empty($boxes_in_pack_mode)){
		$boxes_in_pack_mode = 0;
	}
	//echo "<br/>";
	$total_inventory = $boxes_out_for_delivery+$boxes_out_for_pickup+$boxes_in_pack_mode;

	//= get_total_inventory();

	echo "<table id='example' class='display testexample' width='100%'>";
	echo "<thead><tr><th>Boxes Out for Delivery</th><th>Boxes Out for Pickup</th><th>Boxes in Storage</th><th>Total Inventory</th></tr></thead>";
	echo "<tbody><tr><td>$boxes_out_for_delivery</td><td>$boxes_out_for_pickup</td><td>$boxes_in_pack_mode</td><td>$total_inventory</td></tr></tbody></table>";

}
function get_data_boxes_out_for_delivery(){
	$query ="SELECT SUM(a.box_count+a.added_box_count) AS 'box_count' FROM orders_data a JOIN order_tracking b ON a.order_id = b.order_id WHERE b.order_status ='Delivery Initiated' AND date(b.created_at) = CURDATE()";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return $row[0];
}
function get_data_boxes_out_for_pickup(){
	$query ="SELECT SUM(a.box_count+a.added_box_count) AS 'box_count' FROM orders_data a JOIN order_tracking b ON a.order_id = b.order_id WHERE b.order_status='Pickup Initiated' AND date(b.created_at) = CURDATE()";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return $row[0];
}
function get_boxes_in_pack_mode(){
	$query ="SELECT SUM(a.box_count+a.added_box_count) AS 'box_count' FROM orders_data a JOIN order_tracking b ON a.order_id = b.order_id WHERE b.order_status='In Storage' AND date(b.created_at) = CURDATE()";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return $row[0];
}
function get_total_inventory(){
	$query ="SELECT SUM(a.box_count+a.added_box_count) AS 'box_count' FROM orders_data a JOIN order_shipping b ON a.order_id = b.order_id WHERE b.shipping_type='Pickup Empty Boxes' AND date(b.date) = CURDATE()";

	$res = mysql_query($query);

	$row = mysql_fetch_row($res);

	return $row[0];
}



?>