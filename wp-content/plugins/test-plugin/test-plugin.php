<?php

/*
Plugin Name: Test plugin
Description: A test plugin to demonstrate wordpress functionality
Author: Yogesh Patil
Version: 0.1
*/
//require_once( '/includes/loader.php' );
//require_once('db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
        add_menu_page( 'Test Plugin Page', 'Packages', 'manage_options', 'test-plugin', 'test_init' ,'dashicons-album');
}

function test_init(){

	$url = admin_url()."add_packages.php";
    echo "<div><h1>Packages </h1>&nbsp;&nbsp;<a href='$url' class='button button-primary'>Add New Package</a></div><br/>";
    
	show_products();
}

function get_custom_formatted_date($date1){
	$date=date_create($date1);
	return date_format($date,"M d, Y");
}
function show_products(){
	
	/*$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");*/

	$sql="SELECT * FROM products WHERE status=1 ";

	$result = mysql_query($sql);
	$count =1;
	//echo "<pre>";
	//print_r(mysql_fetch_array($result));
	echo '<h5 style="display:none;background:lightgray;padding:10px;font-size:15px;color:currentColor;" id="resp_message"></h5>';
	echo "<table id='example' class='display testexample' width='100%'><thead>";
	echo "<tr><th >Sr.No.</th><th >Product Name</th><th >Product Type</th><th >Box Count</th><th >Rental Packages</th><th >Storage Packages</th><th>Action</th></tr></thead>";
	echo "<tbody>";

	while($row = mysql_fetch_array($result)){
		//echo "product_id: ".
		$product_id = $row['product_id'];
		$price = get_rental_price($product_id,2,2);
		$storage_price = get_storage_price($product_id,1,1);
		echo '<form method="post" action="options.php">';
		echo '<tr id="row_id_'.$product_id.'">';
		echo '<td>'.$count++.'</td>';
		echo '<td>'.$row['product_name'].'</td>';

		echo '<td>'.$row['product_type'].'</td>';
		echo '<td>'.$row['box_count'].'</td>';
		echo '<td>$'.$price.'/2 week</td>';
		echo '<td>$'.$storage_price.'/ month</td>';
		echo '<td><a href="edit_packages.php?product='.$product_id.'" class="button button-primary">Edit</a> <button  onClick="deletepacakge('.$product_id.')" class="button button-primary">Delete</button></td>';
		echo '</tr>';
		echo '</form>';
	}
	echo "</tbody>";
	echo "</table>";
}
function get_order_status_data($order_type){

	$query = "SELECT order_status from order_status_master Where order_type='$order_type'";

	$res = mysql_query($query);

	while($row = mysql_fetch_assoc($res)){

		$rows[] = $row['order_status'];

	}

	return $rows;
}
function get_tax_rate(){
	$sql="select value from lookup_table where keyy='Tax_Rates'";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}

function get_price($product_id,$period,$calender){
	/*$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");*/
	
	$sql="select price from pricing where product_id=$product_id and period='$period' and calender='$calender'";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}
function get_base_level_pricing_rental($product_id,$rental_period){
	$sql="select (rental_price/2) from pricing where product_id=$product_id and rental_period='$rental_period'";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}
function get_rental_price($product_id,$rental_period,$duration){
	$base_price_per_week = get_base_level_pricing_rental($product_id,$rental_period);

	return $duration * $base_price_per_week;

}
function get_rental_price_data($product_id){
	
	$sql="select * from pricing where product_id=$product_id";

	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);

	return $row;

}
function get_customer_data($user_id){
	$sql="select * from customers where user_id=$user_id";

	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);

	return $row;
}
function get_order_tracking_info($order_id){

	$sql="select * from order_tracking where order_id=$order_id and active=1";

	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);

	return $row;
}
function get_order_tracking_info_histroy($order_id){

	$sql="select * from order_tracking where order_id=$order_id order by tracking_id desc";

	$result = mysql_query($sql);
	// $row = mysql_fetch_assoc($result);
	$result_one = array();
	if($result){
		while($res = mysql_fetch_assoc($result)){
			$result_one[] = $res;
		}
	}
	return $result_one;
}
function get_additional_order_details($order_id){

	$sql="select * from orders_data where parent_order_id=$order_id order by order_id desc";

	$result = mysql_query($sql);
	// $row = mysql_fetch_assoc($result);
	$result_one = array();
	if($result){
		while($res = mysql_fetch_assoc($result)){
			$result_one[] = $res;
		}
	}
	return $result_one;
}

function get_storage_price_data($product_id){
	
	$sql="select * from pricing where product_id=$product_id";

	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);

	return $row;

}

function get_lowest_price_rental_package(){
	$sql="select min(rental_price) from pricing";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}
function get_loweset_price_storage_package(){
	$sql="select min(storage_monthly_price) from pricing";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}
function get_product_data($product_id){
	$query = "SELECT * from products where product_id=$product_id";

	$res = mysql_query($query);
	
	$row = mysql_fetch_assoc($res);

	return $row;
}
function get_minimum_package_data(){
	$product_id = get_product_id();

	$query1="select * from products where product_id=$product_id";

	$res1 = mysql_query($query1);

	$row1 = mysql_fetch_assoc($res1);

	return $row1;
}
function get_product_id(){
	$query="select product_id from pricing where product_type!='' ORDER BY rental_price asc limit 1";
	
	$result = mysql_query($query);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}
function get_storage_price($product_id,$storage_period,$duration){
	
	$sql="select storage_monthly_price from pricing where product_id=$product_id and storage_monthly_period='$storage_period'";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $duration*$row[0];
}
function get_per_week_price($product_id){
	
	$sql="select rental_price_per_week from pricing where product_id=$product_id";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}
function get_expiry_price($product_id,$period,$calender){
	/*$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");*/
	
	$sql="select after_expiry_price from pricing where product_id=$product_id and period='$period' and calender='$calender'";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_row($result);
	//print_r($row);
	//echo $row[0];
	return $row[0];
}

function get_base_pricing($component_name){

	$sql = "select componet_per_box_price from base_pricing where component_name='$component_name'";

	$result = mysql_query($sql);

	$row = mysql_fetch_row($result);

	return $row[0];

}
function get_payments_data($current_order_id){
	$query = "select * from payments where order_id=".$current_order_id;
	$res = mysql_query($query);

	$data = mysql_fetch_assoc($res);

	return $data;
}
function get_payments_data_user($user_id){
	$query = "select * from payments where user_id=$user_id and active=1";

	$res = mysql_query($query);

	$data = mysql_fetch_assoc($res);

	return $data;
}
function get_rental_shipping_data($current_order_id,$shipping_type){
	$query = "select * from order_shipping where order_id=$current_order_id and shipping_type='$shipping_type'";
	$res = mysql_query($query);

	$data = mysql_fetch_assoc($res);

	return $data;
}

function get_storage_shipping_data($current_order_id,$shipping_type){
	$query = "select * from order_shipping where order_id=$current_order_id and shipping_type='$shipping_type'";
	$res = mysql_query($query);

	$data = mysql_fetch_assoc($res);

	return $data;
}
function get_package_data($product_id){
	$sql="select * from products where product_id=$product_id";
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);
	//print_r($row);
	//echo $row[0];
	return $row;
}
function get_packages_datas($product_type){

	$product_type = strtoupper($product_type);
	$sql="select product_id,product_name,product_type,box_count from products where product_type='$product_type'";
	
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($result)){
		$rows[] = array('product_name'=>$row['product_name'],'product_id'=>$row['product_id'],'product_type'=>$row['product_type'],'box_count'=>$row['box_count']);
	}
	return $rows;
}
//$first_obj = new PackagesView();
//$first_obj->create_view();

//create_view();
	function create_view(){
        //echo '<form>';
        get_products_data();
        //echo '</form>';
    }
   function  get_products_data(){
        $con = mysql_connect("localhost","root","");
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        //mysql_query('SET names utf8');
        mysql_set_charset('utf8');
        $db = mysql_select_db("rebow");

        $sql="select * from products";

        $result = mysql_query($sql);

        while($row = mysql_fetch_array($result)){
            $product_id = $row['product_id'];
            //$price = get_price($product_id,'2w');
            //$storage_price = get_price($product_id,'1m');
            echo '<form><tr>';
            echo '<input type="text" value='.$row['product_name'].'>';
            echo '<br/>';
            echo '<input type="text" value='.$row['product_type'].'>';
            echo '<br/>';
            echo '<input type="text" value='.$row['box_count'].'>';
            echo '<br/>';
            echo '<input type="text" value='.$row['box_count'].'>';
            echo '<br/>';
            //echo '<td><h3> $'.$price.'/2 week</h3></td>';
            //echo '<td><h3> $'.$storage_price.'/ month</h3></td>';
            //echo '<td><a href="packages-view.php?product='.$product_id.'&action=edit">Edit Package</a></td>';
            echo '</tr></form>';
        
        }
   }

   function display_data(){
   	 	$string1 =preg_replace("/[A-Z]/", "<span class=\"initial\">$1</span>", $str);
   		display_data_from_db($string1);

   }
   function display_data_from_db($stringnow){
   		$conn = mysql_connect('localhost','root','');

   		$db = mysql_select_db('rebow',$conn);

   		$query = mysql_query("select * from products");

   		$result = mysql_fetch_result($query);

   		while(mysql_fetch_assoc($result)){
   			$package_name = $result['package_name']; 
   			$price = $result['price'];  

   			$base_price = $result['base_price']; 
   			$base_price_month = $result['base_price_month']; 
   			$base_price_week = $result['base_price_week'];

   			$base_price_week1 = $result['base_price_week1'];

   			pass_the_values($package_name,$price,$base_price,$base_price_month,$base_price_week,$base_price_week1);
   		}
   }
   function pass_the_values($package_name,$price,$base_price,$base_price_month,$base_price_week,$base_price_week1){
   	

   }

   add_action('admin_menu', 'test_packages_menu');
 
	function test_packages_menu(){
	        add_menu_page( 'Basic Forumula Page', 'Basic Formula', 'manage_options', 'basic_formula', 'test_init1',
	        	'dashicons-clipboard' );
	}
	function test_init1(){
	    //echo "<h1>Packages </h1>";
	    
		show_basic_values();
	}
	function show_basic_values(){
		echo "<h1>Base Formula</h1>";
		$con = mysql_connect("localhost","root","");
		if (!$con) {
		    die('Could not connect: ' . mysql_error());
		}
		//mysql_query('SET names utf8');
		mysql_set_charset('utf8');
		$db = mysql_select_db("rebow");

		$sql="select * from base_pricing";

		$result = mysql_query($sql);
		//echo "<pre>";
		//print_r(mysql_fetch_array($result));
		echo '<div class="col-sm-12">';
		echo '<div class="row">';
		echo '<div class="col-sm-6" style="background:white">';
		echo '<center><h3>Base Formula</h3></center>';
		while($row = mysql_fetch_array($result)){
			$cname = str_replace("_"," ",$row['component_name']);			
			echo '<label >'.$cname.'</label>';
			$con_price = $row['component_name']."_price";
			echo '<input type="text" class="form-control" contenteditable="true" id='.$con_price.' value="$'.$row['componet_per_box_price'].'"';			
		}
		echo '</div>';
		echo '<button class="btn btn-success float-right" style="padding: 10px;margin: 20px;" id="base_values_update" type="Submit" />UPDATE</button>';
		echo '</div>';
		echo '</div>';
		//echo '<script>';
		echo '<script>
		jQuery(document).ready(function(){

			jQuery( "#base_values_update" ).click(function() {
				var Moving_dollies_per_box_price = jQuery("#Moving_dollies_per_box_price").val().trim();
				//alert(Moving_dollies_per_box_price);

				var Labels_per_box_price = jQuery("#Labels_per_box_price").val().trim();
				//alert(Labels_per_box_price);

				var Zipties_per_box_price = jQuery("#Zipties_per_box_price").val().trim();
				//alert(Zipties_per_box_price);

				var Rental_cost_per_1_box_per_1_week_price = jQuery("#Rental_cost_per_1_box_per_1_week_price").val().trim();
				//alert(Rental_cost_per_1_box_per_1_week_price);

				var Monthly_storage_cost_per_box_price = jQuery("#Monthly_storage_cost_per_box_price").val().trim();
				//alert(Monthly_storage_cost_per_box_price);
				
				var datastring ="ajax_request=base_values_update&Moving_dollies_per_box_price="+Moving_dollies_per_box_price+"&Labels_per_box_price="+Labels_per_box_price+"&Zipties_per_box_price="+Zipties_per_box_price+"&Rental_cost_per_1_box_per_1_week_price="+Rental_cost_per_1_box_per_1_week_price+"&Monthly_storage_cost_per_box_price="+Monthly_storage_cost_per_box_price;
				
				//alert(datastring);
				console.log(datastring);

				jQuery.ajax({
					url: "test-plugin-api.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    alert("Data Upadted Successfully.");
					    location.reload();
					}
				});
			});
		});
		</script>';

	}
 ?>	
