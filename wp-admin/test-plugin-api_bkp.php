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

	$pricing_drp =  $_REQUEST['pricing_drp'];


	echo $count = package_already_exist($product_name,$product_id);
	if($count==1){
		echo 'Package Already Exist';
	}else{
		if($pricing_drp=='Weekly'){
			$selectweekperiod = str_replace("$","",$_REQUEST['selectweekperiod']);

			$price2weeks = str_replace("$","",$_REQUEST['price2weeks']);

			$priceafter2weeks = str_replace("$","",$_REQUEST['priceafter2weeks']);
			$selectperiod1 = 'After '.$selectweekperiod.' Week';
			$res_array2 = array('2 Week'=>$price2weeks,$selectperiod1=>$priceafter2weeks);

		}else{
			$selectmonthperiod = str_replace("$","",$_REQUEST['selectmonthperiod']); 

			$price_for_1month = str_replace("$","",$_REQUEST['price_for_1month']);

			$price_for_after1month = str_replace("$","",$_REQUEST['price_for_after1month']);

			$selectperiod1 ='After '.$selectmonthperiod.' Month';

			$res_array2 = array('1 Month'=>$price_for_1month,$selectperiod1=>$price_for_after1month);
		}
		$res_array1 = array('product_name'=>$product_name,'product_type'=>$product_type,'product_range'=>$product_range,'box_count'=>$box_count,'nestable_dollies_count'=>$nestable_dollies_count,'labels_count'=>$labels_count,'zipties_count'=>$zipties_count);

		foreach($res_array1 as $key=>$value){
			echo $query="UPDATE products SET $key='$value' where product_id=$product_id";
			//die;
			$res = mysql_query($query,$con);
			
			if($res==1){
				//echo 'Packages Updated Successfully';
			}else{
				//echo 'Packages updation unsuccessful';
			}
		}

		foreach($res_array2 as $key=>$value){
			if(strpos($key,'After')!==FALSE){
				

				//echo "Key= ".$key;
				$array_week1 = explode(" ",$key);
				//$period = $array_week[0];
				$period = $array_week1[1];
				$month = $array_week1[2];

				$query="UPDATE pricing SET after_expiry_price=$value where period='$period' and calender= '$month' and product_id=$product_id";
				//die;
				$res = mysql_query($query,$con);
				
				if($res==1){
					//echo 'Pricing Updated Successfully';
				}else{
					//echo 'Pricing Updation Unsuccessful';
				}
			}else{
				//echo "Key= ".$key;
				$array_week = explode(" ",$key);
				$period = $array_week[0];
				$month = $array_week[1];

				$query="UPDATE pricing SET price=$value where period='$period' and calender= '$month' and product_id=$product_id";
				//die;
				$res = mysql_query($query,$con);
				
				if($res==1){
					//echo 'Pricing Updated Successfully';
				}else{
					//echo 'Pricing Updation Unsuccessful';
				}
			}
			
		}
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

	$pricing_drp = $_REQUEST['pricing_drp'];

	if($pricing_drp=='Weekly'){
		$price2weeks = str_replace("$","",$_REQUEST['price2weeks']);

		$priceafter2weeks = str_replace("$","",$_REQUEST['priceafter2weeks']);
		$selectweekperiod = str_replace("$","",$_REQUEST['selectweekperiod']);
		$week_rental_cost_per_box = $_REQUEST['week_rental_cost_per_box'];

		$price3weeks = $box_count*3*$week_rental_cost_per_box;
		$price4weeks = $box_count*4*$week_rental_cost_per_box;
	}else{


		$price_for_1month = str_replace("$","",$_REQUEST['price_for_1month']);
		$price_for_after1month = str_replace("$","",$_REQUEST['price_for_after1month']);

		$selectmonthperiod = str_replace("$","",$_REQUEST['selectmonthperiod']);
		$monthly_storage_cost_per_box = $_REQUEST['monthly_storage_cost_per_box'];

		$price_for_2month = $box_count*2*$monthly_storage_cost_per_box;
		$price_for_3month = $box_count*3*$monthly_storage_cost_per_box;
	}

	
	//$res_array1 = array('product_name'=>$product_name,'product_type'=>$product_type,'product_range'=>$product_range,'box_count'=>$box_count,'labels_count'=>$labels_count,'zipties_count'=>$zipties_count);

	//$res_array2 = array('2w'=>$price2weeks,'2wa'=>$priceafter2weeks,'1m'=>$price_for_1month);

	//$res_array3= array(array('2 Month',$price2weeks,);

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
	foreach($res_array2 as $key=>$value){
		$query1 = "INSERT INTO pricing(product_id,product_name,product_type,period,price)
		VALUES ($product_id,'$product_name','$product_type','$key','$value')";

		$res1 = mysql_query($query1);
		if($res1==1){
			echo 'Pricing Inserted Successfully';
		}else{
			echo 'Pricing Insertion Unsuccessful';
		}

	}
} 

if($ajax_request=='promotions_update'){

	$promotion_id = $_REQUEST['promotion_id'];

	$coupon_code = $_REQUEST['coupon_code'];

	$promotion_type = $_REQUEST['promotion_type'];

	$discount_amount = $_REQUEST['discount_amount'];

	$percentage_off = $_REQUEST['percentage_off'];

	$minimum_spend = $_REQUEST['minimum_spend'];

	$product_categories = $_REQUEST['product_categories'];

	$promotion_start_date = $_REQUEST['promotion_start_date'];

	$promotion_end_date = $_REQUEST['promotion_end_date'];

	$usage_limit_per_user = $_REQUEST['usage_limit_per_user'];

	$query ="UPDATE promotions SET coupon_code='$coupon_code',
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
?>