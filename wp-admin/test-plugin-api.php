<?php
$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");

$ajax_request = $_REQUEST['ajax_request'];

//echo "ajax_request: ".
//$ajax_request;
function package_already_exist($product_name,$product_id){
	$query1= "select count(*) as 'count' from products where product_name ='$product_name' and product_id!=$product_id";

	$res = mysql_query($query1);

	$row = mysql_fetch_row($res);

	return $row[0];
}
if($ajax_request=='base_values_update'){
	//echo
	$Moving_dollies_per_box_price = str_replace("$","",$_REQUEST['Moving_dollies_per_box_price']);
	//echo
	$Labels_per_box_price = str_replace("$","",$_REQUEST['Labels_per_box_price']);
	//echo
	$Zipties_per_box_price = str_replace("$","",$_REQUEST['Zipties_per_box_price']);
	//echo
	$Rental_cost_per_1_box_per_1_week_price = str_replace("$","",$_REQUEST['Rental_cost_per_1_box_per_1_week_price']);

	//$Rental_cost_per_1_box_per_1_week_price = $_REQUEST['Rental_cost_per_1_box_per_1_week_price'];
	//echo
	$Monthly_storage_cost_per_box_price = str_replace("$","",$_REQUEST['Monthly_storage_cost_per_box_price']);

	$res_array = array('Moving_dollies_per_box'=>$Moving_dollies_per_box_price,'Labels_per_box'=>$Labels_per_box_price,'Zipties_per_box'=>$Zipties_per_box_price,'Rental_cost_per_1_box_per_1_week'=>$Rental_cost_per_1_box_per_1_week_price,'Monthly_storage_cost_per_box'=>$Monthly_storage_cost_per_box_price);

	foreach($res_array as $key=>$value){
		echo $query="UPDATE base_pricing SET componet_per_box_price=$value where component_name='$key'";
		//die;
		$res = mysql_query($query,$con);
		
		if($res==1){
			echo 'Prices updated successfully';
		}else{
			echo 'Prices updated unsuccessful';
		}
	}
}

if($ajax_request=='packages_update'){

	$product_id = $_REQUEST['product_id'];

	$product_name = $_REQUEST['product_name'];

	$product_type = $_REQUEST['product_type'];

	$product_range = $_REQUEST['product_range'];

	$box_count = $_REQUEST['box_count'];

	$nestable_dollies_count = $_REQUEST['nestable_dollies_count'];

	$labels_count = $_REQUEST['labels_count'];

	$zipties_count = $_REQUEST['zipties_count'];

	$price2weeks = str_replace("$","",$_REQUEST['price2weeks']);

	$priceafter2weeks = str_replace("$","",$_REQUEST['priceafter2weeks']);

	$price_for_1month = str_replace("$","",$_REQUEST['price_for_1month']);

	$res_array1 = array('product_name'=>$product_name,'product_type'=>$product_type,'product_range'=>$product_range,'box_count'=>$box_count,'nestable_dollies_count'=>$nestable_dollies_count,'labels_count'=>$labels_count,'zipties_count'=>$zipties_count);

	//$res_array2 = array('rental_period'=>$price2weeks,'2wa'=>$priceafter2weeks,'1m'=>$price_for_1month);


	foreach($res_array1 as $key=>$value){
		$query="UPDATE products SET $key='$value' where product_id=$product_id";
		//die;
		$res = mysql_query($query,$con);		
		if($res==1){
			$message = 'Packages Updated Successfully';
		}else{
			$message = 'Packages updation unsuccessful';
		}
	}

	$query="UPDATE pricing SET rental_price=$price2weeks,rental_price_per_week=$priceafter2weeks,storage_monthly_price=$price_for_1month,updated_at=NOW() where product_id=$product_id";
		//die;
		$res = mysql_query($query,$con);
		
		if($res==1){
			$message = 'Pricing Updated Successfully';
		}else{
			$message = 'Pricing updation unsuccessful';
		}
		echo $message;
	/*foreach($res_array2 as $key=>$value){

		echo $query="UPDATE pricing SET price=$value where period='$key' and product_id=$product_id";
		//die;
		$res = mysql_query($query,$con);
		
		if($res==1){
			echo 'Pricing Updated Successfully';
		}else{
			echo 'Pricing Updation Unsuccessful';
		}
	}*/
	
	
}

if($ajax_request=='delete_pacakge'){
	$query="UPDATE products SET status=0 where product_id=$_POST[packageid]";
	$res = mysql_query($query,$con);	
	if($res==1){
		echo 'Package Deleted Successfully';
	}else{
		echo 'Sorry, Please try again.';
	}
}
if($ajax_request=='check_new_promo'){
	$query="SELECT count('promotion_id') as 'count' FROM promotions where coupon_code = '".$_POST['newpromo']."' AND coupon_status=1";
	$res = mysql_query($query,$con);	
	$row = mysql_fetch_row($res);
	if($row[0]){
		echo json_encode(array('status'=>'exits','message'=>'Sorry, Promo Code Already Exists.'));
	}else{
		echo json_encode(array('status'=>'not_exits'));
	}
}

if($ajax_request=='add_package'){
	//$product_id = $_REQUEST['product_id'];

	$product_name = $_REQUEST['product_name'];

	$product_type = $_REQUEST['product_type'];

	$product_range = $_REQUEST['product_range'];

	$box_count = $_REQUEST['box_count'];

	$nestable_dollies_count = $_REQUEST['nestable_dollies_count'];


	$labels_count = $_REQUEST['labels_count'];

	$zipties_count = $_REQUEST['zipties_count'];

	$rental_price = str_replace("$","",$_REQUEST['price2weeks']);

	$rental_price_per_week = str_replace("$","",$_REQUEST['priceafter2weeks']);

	$storage_monthly_price = str_replace("$","",$_REQUEST['price_for_1month']);

	//$res_array1 = array('product_name'=>$product_name,'product_type'=>$product_type,'product_range'=>$product_range,'box_count'=>$box_count,'labels_count'=>$labels_count,'zipties_count'=>$zipties_count);

	//$res_array2 = array('2w'=>$price2weeks,'2wa'=>$priceafter2weeks,'1m'=>$price_for_1month);

	$query = "INSERT INTO products(product_name,product_type,product_range,box_count,nestable_dollies_count,labels_count,zipties_count,status)
	VALUES ('$product_name','$product_type','$product_range','$box_count','$nestable_dollies_count','$labels_count','$zipties_count',1)";

	$res = mysql_query($query);
	if($res==1){
		echo 'Package Inserted Successfully';
	}else{
		echo 'Package Insertion Unsuccessful';
	}
	$product_id = mysql_insert_id();
	
	//$id
	
		$query1 = "INSERT INTO pricing(product_id,product_name,product_type,rental_period,rental_price,rental_price_per_week,storage_monthly_period,storage_monthly_price,status,updated_at)
		VALUES ($product_id,'$product_name','$product_type',2,'$rental_price','$rental_price_per_week',1,'$storage_monthly_price',1,NOW())";

		$res1 = mysql_query($query1);
		if($res1==1){
			echo 'Pricing Inserted Successfully';
		}else{
			echo 'Pricing Insertion Unsuccessful';
		}

	
} 

if($ajax_request=='promotions_update'){

	$promotion_id = $_REQUEST['promotion_id'];

	$coupon_code = $_REQUEST['coupon_code'];
	$promotion_description = $_REQUEST['promotion_description'];

	$promotion_type = $_REQUEST['promotion_type'];

	$discount_amount = $_REQUEST['discount_amount'];

	$percentage_off = $_REQUEST['percentage_off'];

	$minimum_spend = $_REQUEST['minimum_spend'];

	$product_categories = $_REQUEST['product_categories'];

	$promotion_start_date = $_REQUEST['promotion_start_date'];

	$promotion_end_date = $_REQUEST['promotion_end_date'];

	$usage_limit_per_user = $_REQUEST['usage_limit_per_user'];

	$query ="UPDATE promotions SET coupon_code='$coupon_code',
				promotion_description='$promotion_description',
				product_categories='$product_categories',
				promotion_type='$promotion_type',
				discount_amount = '$discount_amount',
				percentage_off= '$percentage_off',
				minimum_spend = '$minimum_spend',
				promotion_start_date = '$promotion_start_date',
				promotion_end_date = '$promotion_end_date',
				usage_limit_per_user = '$usage_limit_per_user' WHERE promotion_id=$promotion_id";
	$res = mysql_query($query);
	if($res==1){
		echo 'Promotion Updated Successfully';
	}else{
		echo 'Promotion Updated unsuccessful';
	}
}
if($ajax_request=='add_promotions'){

	//$promotion_id = $_REQUEST['promotion_id'];

	$coupon_code = $_REQUEST['coupon_code'];

	$promotion_description = $_REQUEST['promotion_description'];
	
	$promotion_type = $_REQUEST['promotion_type'];

	$discount_amount = $_REQUEST['discount_amount'];

	$percentage_off = $_REQUEST['percentage_off'];

	$minimum_spend = $_REQUEST['minimum_spend'];

	$product_categories = $_REQUEST['product_categories'];

	$promotion_start_date = $_REQUEST['promotion_start_date'];

	$promotion_end_date = $_REQUEST['promotion_end_date'];

	$usage_limit_per_user = $_REQUEST['usage_limit_per_user'];

	$query ="INSERT INTO promotions (promotion_type,promotion_description,coupon_code,discount_amount,percentage_off,minimum_spend,product_categories,promotion_start_date,promotion_end_date,usage_limit_per_user)
	VALUES ('$promotion_type','$promotion_description','$coupon_code','$discount_amount','$percentage_off','$minimum_spend','$product_categories','$promotion_start_date','$promotion_end_date','$usage_limit_per_user')";
	$res = mysql_query($query);
	if($res==1){
		echo 'Promotion Updated Successfully';
	}else{
		echo 'Promotion Updated unsuccessful';
	}
}
if($ajax_request=='order_update'){
	$message = "Sorry, Nothing for update";
	$order_status = $_POST['order_status'];

	$order_status_old = $_POST['order_status_old'];

	$order_id = $_POST['order_id'];

	$user_id = $_POST['user_id'];
	if(isset($_POST['edit_reason_message']) && !empty($_POST['edit_reason_message'])){
		$edit_reason = $_POST['edit_reason_message'];
	}else{
		$edit_reason = '';
	}

	// echo "User ID: ".$user_id;
	$order_type = $_POST['order_type'];
	$billing_address_edited_value = $_POST['billing_address_edited_value'];
	$shipping_edited_change = $_POST['shipping_edited_change'];
	$billing_edited_change = $_POST['billing_edited_change'];
	if($billing_edited_change==1){
		update_billing_address($billing_address_edited_value,$user_id);
		$message = "Order Details Updated Successfully.";
	}
	$email_edited_value = $_POST['email_edited_value'];
	$delivery_address_edited_value = $_POST['delivery_address_edited_value'];
	$pickup_address_edited_value = $_POST['pickup_address_edited_value'];
	if($shipping_edited_change==1){
		if($order_type=="RENTAL"){
			$delivery_address = $delivery_address_edited_value;
			$pickup_address = $pickup_address_edited_value;
			update_delivery_address($delivery_address,$order_id);
			update_pickup_address($pickup_address,$order_id);
			$message = "Order Details Updated Successfully.";
		}elseif($order_type=="STORAGE"){
			$delivery_address = $delivery_address_edited_value;
			$pickup_address = $pickup_address_edited_value;
			$pickup_packed_address = $_POST['pickup_packed_address_edited_value'];
			$delivery_packed_address = $_POST['delivery_packed_address_edited_value'];
			update_delivery_address($delivery_address,$order_id);
			update_pickup_address($pickup_address,$order_id);
			update_pickup_address_pacaked($pickup_packed_address,$order_id);
			update_delivery_address_packed($delivery_packed_address,$order_id);
			$message = "Order Details Updated Successfully.";
		}
	}

	$order_status  = str_replace("_", " ", $order_status);

	if($order_status==$order_status_old){
		//echo "Order Status not changed or updated";
	}else{
		//echo "update status"; 
		update_other_status_to_inactive($order_id,$user_id);
		insert_into_order_tracking($order_id,$user_id,$order_status,$edit_reason);
		$message = "Order Details Updated Successfully.";
	}
	echo $message;
}
if($ajax_request == 'delete_coupon'){
	$query = "UPDATE promotions SET coupon_status=0 where promotion_id=$_POST[rowid] ";
	$res = mysql_query($query);
	if($res==1){
		echo "Copuon Deleted successfully";
	}else{
		echo "Sorry, Please try again.";
	}
}

function update_delivery_address($delivery_address,$order_id){
	$query = "UPDATE order_shipping SET address='$delivery_address' where order_id=$order_id and shipping_type='Delivery Empty Boxes'";

	$res = mysql_query($query);

	// if($res==1){
	// 	echo "updated successfully";
	// }else{
	// 	echo "something went wrong";
	// }
}
function update_pickup_address($pickup_address,$order_id){
	$query = "UPDATE order_shipping SET address='$pickup_address' where order_id=$order_id and shipping_type='Pickup Empty Boxes'";

	$res = mysql_query($query);

	// if($res==1){
	// 	echo "updated successfully";
	// }else{
	// 	echo "something went wrong";
	// }
}
function update_pickup_address_pacaked($pickup_address,$order_id){
	$query = "UPDATE order_shipping SET address='$pickup_address' where order_id=$order_id and shipping_type='Pickup Packed Boxes'";

	$res = mysql_query($query);

	// if($res==1){
	// 	echo "updated successfully";
	// }else{
	// 	echo "something went wrong";
	// }
}
function update_delivery_address_packed($pickup_address,$order_id){
	$query = "UPDATE order_shipping SET address='$pickup_address' where order_id=$order_id and shipping_type='Delivery Packed Boxes'";

	$res = mysql_query($query);

	// if($res==1){
	// 	echo "updated successfully";
	// }else{
	// 	echo "something went wrong";
	// }
}
function update_billing_address($billing_address_edited_value,$user_id){

	echo $query = "UPDATE payments SET billing_address='$billing_address_edited_value' where 
		user_id=$user_id and active=1";

	$res = mysql_query($query);

	// if($res==1){
	// 	echo "updated successfully";
	// }else{
	// 	echo "Something went wrong";
	// }
}
function update_other_status_to_inactive($order_id,$user_id){
	
	$query = "UPDATE order_tracking SET active=0 where order_id=$order_id and user_id=$user_id";

	$res = mysql_query($query);
	
	// if($res==1){
	// 	echo "updated successfully";
	// }else{
	// 	echo "something went wrong";
	// }
}
function insert_into_order_tracking($order_id,$user_id,$order_status,$edit_reason){
	$query = "INSERT INTO order_tracking(`order_id`,`user_id`,`order_status`,`order_status_description`,`active`,`created_at`,`updated_at`) VALUES ($order_id,$user_id,'$order_status','$edit_reason',1,NOW(),NOW())";

    $res = mysql_query($query);

 //    if($res==1){
	// 	echo "inserted successfully";
	// }else{
	// 	echo "something went wrong";
	// }
}

?>