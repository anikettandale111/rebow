<?php

session_start();
//ini_set();
//session_destroy();

class rebow_session{
			
	public $order_values;
	
	public $zip_current;

	public $zip_new;

	public $zip_status;

	public $product_id;
	
	public $display_period;

	public $dp_period;

	public $product_name;


	public $box_count;

	public $selected_package;

	public $added_box_count;

	public $added_box_price;

	public $product_price;

	public $subtotal;

	public $sales_tax;

	public $period;

	public $total_price;

	public $mainprice;

	public $delivery_cost;

	public $pickup_cost;

	public $pickup_cost_text;

	public $delivery_cost_text;


	public $delivery_date;

	public $preferred_delivery_time;

	public $alternate_delivery_time;

	public $delivery_address;

	public $apt_unit_delivery;

	public $apartment_level_delivery;

	public $delivery_address_loc_lat;

	public $delivery_address_loc_long;


	public $pickup_date;

	public $preferred_pickup_time;

	public $alternate_pickup_time;

	public $pickup_address;

	public $apt_unit_pickup;

	public $apartment_level_pickup;

	public $pickup_address_loc_lat;

	public $pickup_address_loc_long;



	public $pickup_date_packed;

	public $preferred_pickup_time_packed;

	public $alternate_pickup_time_packed;

	public $pickup_address_packed;	

	public $apt_unit_pickup_packed;
	
	public $apartment_level_packed;

	public $pickup_address_packed_loc_lat;
	
	public $pickup_address_packed_loc_long;


	public $selectaddress;

	public $delivery_date_packed;

	public $preferred_delivery_time_packed;

	public $alternate_delivery_time_packed;

	public $delivery_address_packed;

	public $apt_unit_delivery_packed;

	public $apartment_level_packed_delivery;
	
	public $delivery_address_packed_loc_lat;

	public $delivery_address_packed_loc_long;
	

	public $firstName;

	public $lastName;

	public $email;

	public $companyName;

	public $phoneNumber;

	public $SecondaryPhoneNumber;

	public $selecthearus;


	public $payment_type;

	public $First_Name;

	public $Last_Name;

	public $Card_Number;

	public $Expiry_month;

	public $Expiry_year;

	public $billing_address;

	public $city;

	public $state;

	public $zipcode;



	public $current_order_id;

	public $period_datas;

	public $start_date;
	
	public $end_date;

	public $period_data_value;

	public $apartment_level_delivery_text;
	public $apartment_level_pickup_text;

}

function set_rebow_session($storesession){
	//$storesession = class rebow_session();
	$serialobj = serialize($storesession);
    $_SESSION['STORE_SESSION'] = $serialobj;
}
function get_rebow_session(){
	//$session_get = $_SESSION['rebow_session'];
	$myobj = $_SESSION['STORE_SESSION'];
	$sessionOBJ = unserialize($myobj);
	return $sessionOBJ;

}

?>