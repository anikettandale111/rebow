<?php
include_once('session_values.php');
function create_session_for_order($order_id){

	$orders_data = get_order_data($order_id);

	$product_id = $orders_data['product_id'];

	$order_type = $orders_data['order_type'];
	
	$current_address_zipcode = $orders_data['current_address_zipcode'];

	$new_address_zipcode = $orders_data['new_address_zipcode'];

	$order_time_period = $orders_data['order_time_period'];

	$order_time_period_array = explode(" ",$order_time_period);

	$display_period = $order_time_period_array[0];

	$dp_period = $order_time_period_array[1];

	$storesession=get_rebow_session();

	$storesession->product_id=$product_id;

	$storesession->period_datas=$order_type;

	$period_data = ($order_type=="RENTAL")? 0 : 1;

	$storesession->period_data=$period_data;

	$storesession->zip_current=$current_address_zipcode;

	$storesession->zip_new=$new_address_zipcode;

	$storesession->zip_new=$new_address_zipcode;

	$storesession->display_period=$display_period;

	$storesession->dp_period=$dp_period;
	
	if($product_id!=0){
		$product_data = get_product_data($product_id);

		$storesession->product_name = $product_data['product_name'];

		$storesession->box_count = $product_data['box_count'];

		$storesession->added_box_count = $product_data['added_box_count'];
	}
	
	$storesession->added_box_price = $orders_data['added_box_price'];

	$storesession->product_price = $orders_data['product_price'];

	$storesession->subtotal = $orders_data['subtotal'];

	$storesession->pickup_cost = $orders_data['pickup_cost'];

	$storesession->delivery_cost = $orders_data['delivery_cost'];

	$storesession->total_price = $orders_data['total_price'];

	if($order_type=="RENTAL"){
		$shipping_type = 'Delivery Empty Boxes';
		$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$shipping_type = 'Pickup Empty Boxes';
		$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$storesession->delivery_date = $deliver_empty_boxes_data['date'];

		$storesession->preferred_delivery_time = $deliver_empty_boxes_data['preferred_time'];

		$storesession->alternate_delivery_time = $deliver_empty_boxes_data['alternative_time'];

		$storesession->delivery_address = $deliver_empty_boxes_data['address'];

		$storesession->delivery_address = $deliver_empty_boxes_data['delivery_address'];

		$storesession->apt_unit_delivery = $deliver_empty_boxes_data['apartment_unit_info'];

		$storesession->apartment_level_delivery = $deliver_empty_boxes_data['floor_level'];



		$storesession->pickup_date = $pickup_empty_boxes_data['date'];

		$storesession->preferred_pickup_time = $pickup_empty_boxes_data['preferred_time'];

		$storesession->alternate_pickup_time = $pickup_empty_boxes_data['alternative_time'];

		$storesession->pickup_address = $pickup_empty_boxes_data['address'];

		$storesession->pickup_address = $pickup_empty_boxes_data['delivery_address'];

		$storesession->apt_unit_pickup = $pickup_empty_boxes_data['apartment_unit_info'];

		$storesession->apartment_level_pickup = $pickup_empty_boxes_data['floor_level'];

	}else{
		$shipping_type = 'Delivery Empty Boxes';
		$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		$shipping_type = 'Pickup Packed Boxes';
		$pickup_packed_boxes_data = get_storage_shipping_data($order_id,$shipping_type);

		$shipping_type = 'Delivery Packed Boxes';
		$delivery_packed_boxes_data = get_storage_shipping_data($order_id,$shipping_type);

		$shipping_type = 'Pickup Empty Boxes';
		$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

		//$storesession->delivery_date = $deliver_empty_boxes_data['date'];
	}

	set_rebow_session($storesession);
	//print_r($orders_data);'
	//$storesession = get_rebow_session();
	//return $storesession;

}
function get_order_data($order_id){

	$query = "select * from orders_data where order_id=$order_id";

	$res = mysql_query($query);

	$row = mysql_fetch_assoc($res);

	return $row;
}
/*function get_product_data($product_id){

	$query = "select * from products where product_id=$product_id";

	$res = mysql_query($query);

	$row = mysql_fetch_assoc($res);

	return $row;
}*/
?>