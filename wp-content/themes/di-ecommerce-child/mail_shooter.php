<?php

require_once("../../../wp-load.php");
include_once('db_config.php');

get_all_rental_delivery_orders();
//get_all_storage_delivery_orders();

//get_all_storage_pickup_orders();

//get_all_rental_pickup_orders();



/*if(){

}*/

function get_all_rental_delivery_orders(){

	$query = "SELECT a.order_id AS 'order_id',a.product_id AS 'product_id',a.order_time_period AS 'order_time_period',a.product_price AS 'product_price',
	b.preferred_time AS 'delivery_time',date(a.created_at) AS 'order_date', a.order_type AS 'ORDER_TYPE',date(b.date) AS 'date',(u.user_email) AS 'email',
	b.shipping_type AS 'Shipping Type',b.address AS 'delivery_address',(b.DATE) AS 'delivery_date',(b.floor_level) AS 'delivery_floor_level',a.added_box_count AS 'added_box_count',a.added_box_price AS 'added_box_price'

	FROM ORDERS_DATA a JOIN order_shipping b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id=u.ID WHERE b.order_type ='RENTAL' AND date(b.DATE)= (CURDATE()) AND shipping_type='Delivery Empty Boxes'";


	$res = mysql_query($query);

	while($row = mysql_fetch_assoc($res)){ 
 		
		$order_id = $row['order_id'];

		$order_date = $row['order_date'];

		$order_time_period = $row['order_time_period'];

		$product_price = $row['product_price'];

		
		$product_id = $row['product_id'];
		if($product_id!=0){
			$product_data = get_product_data($product_id);

			$product_name =  $product_data['product_name'];

			$product_box_count = $product_data['box_count'];

			$product_range = $product_data['product_range'];
		}else{
			$product_box_count = $row['added_box_count'];

			$order_time_period = $row['order_time_period'];
		}
		

		

 		$ORDER_TYPE = $row['ORDER_TYPE'];

 		$email = $row['email'];

 		$shipping_type = $row['shipping_type'];


 		$delivery_time = $row['delivery_time'];

 		$delivery_address = $row['delivery_address'];

 		$delivery_date = $row['delivery_date'];

 		$delivery_floor_level = $row['delivery_floor_level'];

 		$pickup_data = get_rental_pickup_details($order_id);

 		$pickup_date = $pickup_data['date'];

 		$pickup_address = $pickup_data['address'];

 		$pickup_times = $pickup_data['preferred_time'];

 		$pickup_floor_level = $pickup_data['floor_level'];

 		send_rental_delivery_mail($order_id,$delivery_time,$email,$shipping_type,$order_type,$delivery_address,$delivery_date,$delivery_floor_level,$pickup_date,$pickup_address,$pickup_times,$pickup_floor_level,$order_time_period,$product_price,$product_name,$product_box_count,$product_range,$order_date);
		
	}

}
function get_rental_pickup_details($order_id){
	$query = "SELECT * from order_shipping where order_id=$order_id and shipping_type='Pickup Empty Boxes'";

	$res = mysql_query($query);
	
	$row = mysql_fetch_assoc($res);

	return $row;
}

function get_product_data(){
	$query = "SELECT * from products where order_id=$product_id";

	$res = mysql_query($query);
	
	$row = mysql_fetch_assoc($res);

	return $row;
}
function send_rental_delivery_mail($order_id,$delivery_time,$email,$shipping_type,$order_type,$delivery_address,$delivery_date,$delivery_floor_level,$pickup_date,$pickup_address,$pickup_times,$pickup_floor_level,$order_time_period,$product_price,$product_name,$product_box_count,$product_range,$order_date){

	$subject ="Rebow order Arriving Tomorrow";
    
        //$filepath = "template-parts/mail/mail-subscribe.php";
    $body = file_get_contents("template-parts/mail/rental_delivery_reminder.php");

    $array_rental = array('order_id'=>$order_id,'order_date'=>$order_date,'product_name'=>$product_name,'product_box_count'=>$product_box_count,'product_range'=>$product_range,'order_time_period'=>$order_time_period,'delivery_address'=>$delivery_address,'delivery_date'=>$delivery_date,'optional_delivery_times'=>$delivery_time,'floor_level_delivery'=>$delivery_floor_level,'pickup_adderess'=>$pickup_address,'pickup_date'=>$pickup_date,'optional_pickup_times'=>$pickup_times,'floor_level_pickup'=>$pickup_floor_level);

    foreach($array_rental as $key=>$value){
        $body = str_replace($key,$value,$body);
    }

    $res_mail = wp_mail($email, $subject, $body);

}
?>