<?php
	require_once('session_handler.php');
	$session_data = get_rebow_session();
	//print_r($session_data);

	if(isset($session_data->product)){
		$product= $session_data->product;
		//$product_type = $product.[0];
		$period = $product[1];
	}
	
	if(isset($session_data->product_id)){
		$product_id = $session_data->product_id;
		$product_data = get_package_data($product_id);

		if($product_id!=11){
			$product_name = $product_data['product_name'];
			$box_count = $product_data['box_count'];
			$nestable_dollies_count	 = $product_data['nestable_dollies_count'];
			$labels_count= $product_data['labels_count'];
			$zipties_count= $product_data['zipties_count'];
			$product_range = $product_data['product_range'];
		}else{
			$product_name = $product_data['product_name'];
			$box_count = $session_data->box_count;
			$nestable_dollies_count	 = ($session_data->box_count/4);
			$labels_count= $session_data->box_count;
			$zipties_count= $session_data->box_count;
		}
		

		$product_category = $product_data['product_type'];

		$product_price = ($period_data==0)?get_rental_price_data($product_id):get_storage_price_data($product_id);

		$datas = get_packages_datas($product_category);
	}
	if(isset($session_data->period_data)){
		$period_data = $session_data->period_data;

		$period_datas = ($session_data->period_data==0)?"RENTAL":"STORAGE";

		$breadcrumb1 = $product_category.' '.$period_datas;
		//echo "Product Category: ".
		$breadcrumb2 = $period_datas.' '.'PERIOD';

		$default_product_cost = ($period_data==0) ? get_base_pricing('Rental_cost_per_1_box_per_1_week') : get_base_pricing('Monthly_storage_cost_per_box');

		$array1 = ($period_data==0)?array(2=>"2 Weeks",3=>"3 Weeks",4=>"4 Weeks",5=>"5 Weeks",6=>"6 Weeks") : array("MM"=>"Month to Month",1=>"1 Month",2=>"2 Months",3=>"3 Months",4=>"4 Months",5=>"5 Months",6=>"6 Months",7=>"7 Months",8=>"8 Months");

		//$array1=($period_data==0)?array(2=>2,3=>2,4=>2) : array(1=>1,2=>1,3=>1);

		$product_type =($period_data==0)? "RENTAL" : "STORAGE";

		$dp_period =($period_data==0)? "Weeks" : "Months";

	}
	
	$tax_rates = get_tax_rate();
	
	//print_r($datas);
	

	if(isset($session_data->display_period)){
		$display_period = $session_data->display_period;
	}else if(isset($product_price["rental_period"])){
		$display_period = ($period_data==0)? $product_price["rental_period"]: $product_price["storage_monthly_period"];
	}else{
		$display_period = ($period_data==0)? 2: 1;
	}
	
	if(isset($session_data->product_price)){
		$display_data_price = $session_data->product_price;
		
	}else{
		$display_data_price = ($period_data==0)? $product_price["rental_price"]: $product_price["storage_monthly_price"];
	}

	
	$default_box_count = 4;

	$added_box_no = (isset($session_data->added_box_count)) ? $session_data->added_box_count :  0;
	
	$added_box_price = (isset($session_data->added_box_price)) ? $session_data->added_box_price :  0;

	$box_count_price = $default_product_cost * $display_period * $default_box_count;

	$subtotal_price = $display_data_price+$added_box_price;

	$delivery_cost = (isset($session_data->delivery_cost)) ? $session_data->delivery_cost :  0;

	$pickup_cost = (isset($session_data->pickup_cost)) ? $session_data->pickup_cost :  0;

	$total_price1 =  $subtotal_price+$delivery_cost+$pickup_cost;

	$sales_tax = ($total_price1*$tax_rates)/100;

	$total_price = $total_price1 + $sales_tax;

	$firstName = (isset($session_data->firstName)) ? $session_data->firstName : "";
	
	$lastName = (isset($session_data->lastName)) ? $session_data->lastName : "";

	$email = (isset($session_data->email)) ? $session_data->email : "";

	$companyName = (isset($session_data->companyName)) ? $session_data->companyName : "";

	$phoneNumber = (isset($session_data->phoneNumber)) ? $session_data->phoneNumber : "";

	$SecondaryPhoneNumber = (isset($session_data->SecondaryPhoneNumber)) ? $session_data->SecondaryPhoneNumber : "";

	$selecthearus = (isset($session_data->selecthearus)) ? $session_data->selecthearus : "select";

	$time_slots_array = array('8:30-11:00_am'=>'8:30 - 11:00 am','11:00-1:00_pm'=>'11:00-1:00 pm',
	'1:00-4:00_pm'=>'1:00-4:00 pm');

	$elevator_bulding_array = array('Neither'=>'Neither','Elevator'=>'Elevator','Stairs'=>'Stairs');

	/*Delivery Data*/
	$delivery_address = (isset($session_data->delivery_address)) ? $session_data->delivery_address : "";

	$delivery_date = (isset($session_data->delivery_date)) ? $session_data->delivery_date : "";

	$preferred_delivery_time = (isset($session_data->preferred_delivery_time)) ? $session_data->preferred_delivery_time : "";

	$alternate_delivery_time = (isset($session_data->alternate_delivery_time)) ? $session_data->preferred_delivery_time : "";

	$apt_unit_delivery = (isset($session_data->apt_unit_delivery)) ? $session_data->apt_unit_delivery : "";

	$apartment_level_delivery = (isset($session_data->apartment_level_delivery)) ? $session_data->apartment_level_delivery : "";

	$delivery_address_loc_lat = (isset($session_data->delivery_address_loc_lat)) ? $session_data->delivery_address_loc_lat : "";

	$delivery_address_loc_long = (isset($session_data->delivery_address_loc_long)) ? $session_data->delivery_address_loc_long : "";

	/*Pickup Data*/

	$pickup_address = (isset($session_data->pickup_address)) ? $session_data->pickup_address : "";

	$pickup_date = (isset($session_data->pickup_date)) ? $session_data->pickup_date : "";

	$preferred_pickup_time = (isset($session_data->preferred_pickup_time)) ? $session_data->preferred_pickup_time : "";

	$alternate_pickup_time = (isset($session_data->alternate_pickup_time)) ? $session_data->alternate_pickup_time : "";

	$apt_unit_pickup = (isset($session_data->apt_unit_pickup)) ? $session_data->apt_unit_pickup : "";

	$apartment_level_pickup = (isset($session_data->apartment_level_pickup)) ? $session_data->apartment_level_pickup : "";

	$pickup_address_loc_lat = (isset($session_data->pickup_address_loc_lat)) ? $session_data->pickup_address_loc_lat : "";

	$pickup_address_loc_long = (isset($session_data->pickup_address_loc_long)) ? $session_data->pickup_address_loc_long : "";

	/*Pickup Pakced Boxes for Storage*/

	$pickup_address_packed = (isset($session_data->pickup_address_packed)) ? $session_data->pickup_address_packed : "";

	$pickup_date_packed = (isset($session_data->pickup_date_packed)) ? $session_data->pickup_date_packed : "";

	$preferred_pickup_time_packed = (isset($session_data->preferred_pickup_time_packed)) ? $session_data->preferred_pickup_time_packed : "";

	$alternate_pickup_time_packed = (isset($session_data->alternate_pickup_time_packed)) ? $session_data->alternate_pickup_time_packed : "";

	$apt_unit_pickup_packed = (isset($session_data->apt_unit_pickup_packed)) ? $session_data->apt_unit_pickup_packed : "";

	$apartment_level_packed = (isset($session_data->apartment_level_packed)) ? $session_data->apartment_level_packed : "";
	
	$pickup_address_packed_loc_lat = (isset($session_data->pickup_address_packed_loc_lat)) ? $session_data->pickup_address_packed_loc_lat : "";
	
	$pickup_address_packed_loc_long = (isset($session_data->pickup_address_packed_loc_long)) ? $session_data->pickup_address_packed_loc_long : "";

	/*Deliver Packed Boxes*/

	$selectaddress = (isset($session_data->selectaddress)) ? $session_data->selectaddress : "";

	$delivery_date_packed = (isset($session_data->delivery_date_packed)) ? $session_data->delivery_date_packed : "";

	$preferred_delivery_time_packed = (isset($session_data->preferred_delivery_time_packed)) ? $session_data->preferred_delivery_time_packed : "";

	$alternate_delivery_time_packed = (isset($session_data->alternate_delivery_time_packed)) ? $session_data->alternate_delivery_time_packed : "";

	$delivery_address_packed = (isset($session_data->delivery_address_packed)) ? $session_data->delivery_address_packed : "";

	$apt_unit_delivery_packed = (isset($session_data->apt_unit_delivery_packed)) ? $session_data->apt_unit_delivery_packed : "";

	$apartment_level_packed_delivery = (isset($session_data->apartment_level_packed_delivery)) ? $session_data->apartment_level_packed_delivery : "";

	$delivery_address_packed_loc_lat = (isset($session_data->delivery_address_packed_loc_lat)) ? $session_data->delivery_address_packed_loc_lat : "";
	
	$delivery_address_packed_loc_long = (isset($session_data->delivery_address_packed_loc_long)) ? $session_data->delivery_address_packed_loc_long : "";
	
	if(isset($session_data->current_order_id)){
		$current_order_id = $session_data->current_order_id;
	}
	if(isset($session_data->period_datas)){
		$period_datas = $session_data->period_datas;

	}

	if(isset($session_data->period_data_value)&&!empty($session_data->period_data_value)){
		$period_data_value = $session_data->period_data_value;
		$period_data_span = $period_data_value." ".ucfirst(strtolower($period_datas));
	}else{
		$period_data_value = $display_period . " " .$dp_period;
		$period_data_span = $display_period . " " .$dp_period." ".ucfirst(strtolower($period_datas));
	}

	if($apartment_level_delivery=="Neither" || empty($apartment_level_delivery)){
		$apartment_level_delivery="Curb";
	}

	if($apartment_level_pickup=="Neither" || empty($apartment_level_pickup)){
		$apartment_level_pickup="Curb";
	}

	if($delivery_cost==0 || empty($delivery_cost)){
		$delivery_cost_text = "FREE";
	}

	if($pickup_cost==0 || empty($pickup_cost)){
		$pickup_cost_text = "FREE";
	}

	$payment_type = (isset($session_data->payment_type)) ? $session_data->payment_type : "";

	$First_Name = (isset($session_data->payment_type)) ? $session_data->First_Name : "";

	$Last_Name = (isset($session_data->Last_Name)) ? $session_data->Last_Name : "";

	$Card_Number = (isset($session_data->Card_Number)) ? $session_data->Card_Number : "";

	$Expiry_month = (isset($session_data->Expiry_month)) ? $session_data->Expiry_month : "";

	$Expiry_year = (isset($session_data->Expiry_year)) ? $session_data->Expiry_year : "";

	$billing_address = (isset($session_data->billing_address)) ? $session_data->billing_address : "";

	$city = (isset($session_data->city)) ? $session_data->city : "";

	$state = (isset($session_data->state)) ? $session_data->state : "";

	$zipcode = (isset($session_data->zipcode)) ? $session_data->zipcode : "";

	//$display_price = $display_period . " " .$dp_period. ": ". $display_data_price;
	/*$apt_unit_pickup_packed = (isset($session_data->apt_unit_pickup_packed)) ? $session_data->apt_unit_pickup_packed : "";

	$apartment_level_packed = (isset($session_data->apartment_level_packed)) ? $session_data->apartment_level_packed : "";*/

	$choose_address_array = array('addaddress'=>'Add New Address','Delivery_Address'=>'Delivery Address','Pickup_Address'=>'Pickup Address');

	
?>
<input type="hidden" id="product_id" value="<?php echo $product_id;?>"></input>
<input type="hidden" id="display_period" value="<?php echo $display_period;?>"></input>
<input type="hidden" id="dp_period" value="<?php echo $dp_period;?>"></input>
<input type="hidden" id="product_name_field" value="<?php echo $product_name;?>"></input>
<input type="hidden" id="box_count_field" value="<?php echo $box_count;?>"></input>
<input type="hidden" id="added_box_count_field" value="<?php echo $added_box_no;?>"></input>
<input type="hidden" id="added_box_price_field" value="<?php echo $added_box_price;?>"></input>
<input type="hidden" id="product_price_field" value="<?php echo $display_data_price;?>"></input>
<input type="hidden" id="subtotal_field" value="<?php echo $subtotal_price;?>"></input>
<input type="hidden" id="delivery_cost_field" value="<?php echo $delivery_cost;?>"></input>
<input type="hidden" id="delivery_cost_text_field" value="<?php echo $delivery_cost_text;?>"></input>
<input type="hidden" id="pickup_cost_field" value="<?php echo $pickup_cost;?>"></input>
<input type="hidden" id="pickup_cost_text_field" value="<?php echo $delivery_cost_text;?>"></input>

<input type="hidden" id="sales_tax_field" value="<?php echo $sales_tax;?>"></input>
<input type="hidden" id="total_price_field" value="<?php echo $total_price;?>"></input>
<input type="hidden" id="tax_rates" value="<?php echo $tax_rates;?>"></input>
<input type="hidden" id="default_product_cost" value="<?php echo $default_product_cost;?>
"></input>
<input type="hidden" id="period_data_field" value="<?php echo $period_datas;?>"></input>
<input type="hidden" id="period_data_value" value="<?php echo $period_data_value;?>"></input>
