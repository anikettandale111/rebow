<?php

/*
Plugin Name: Coupons and Promos
Description: Plugin to add Coupons and Promos.
Author: Yogesh Patil
Version: 0.1
*/
//require_once( '/includes/loader.php' );
//require_once('../db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');

add_action('admin_menu', 'coupons_promos_setup_menu');
function coupons_promos_setup_menu(){
        add_menu_page( 'Coupons Promos Page', 'Promos', 'manage_options', 'coupons_promos', 'coupons_init' ,'dashicons-megaphone');
}

function coupons_init(){
	echo "<div><h3>Coupons Management</h3>&nbsp;&nbsp;<a href='/rebow/wp-admin/add_promotions.php' class='button button-primary' id='add_coupon' >Add Coupon</a></div><br/>";
   show_coupons();
}

function show_coupons(){
	//echo "";
	/*$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");*/
	$sql="SELECT * FROM promotions WHERE coupon_status=1";

	$result = mysql_query($sql);
	$count=1;
	echo '<h5 style="display:none;background:lightgray;padding:10px;font-size:15px;color:currentColor;" id="resp_message"></h5>';
	echo '<table id="example" class="display testexample" width="100%">
	<thead><tr><th >SR.No.</th><th >Code</th><th>Coupon type</th><th>Coupon amount/Percentage Off</th><th>Description</th><th>Usage / Limit</th><th >Expiry date</th><th>Action</th></tr></thead>';
	echo "<tbody>";
	while($row = mysql_fetch_array($result)){
		$promotion_id = $row['promotion_id'];

		echo '<form method="post" action="options.php">';
		echo '<tr id="row_id_'.$promotion_id.'">';
		echo '<td>'.$count++.'</td>';
		echo '<td>'.$row['coupon_code'].'</td>';
		echo '<td> '.ucfirst(str_replace("_"," ",$row['promotion_type'])).'</td>';
		if($row['promotion_type']=='Fixed_Amount'){
			echo '<td >'.$row['discount_amount'].'</td>';
		}else{
			echo '<td >'.$row['percentage_off'].'</td>';
		}
		echo '<td > '.$row['promotion_description'].'</td>';
		
		echo '<td > '.$row['usage_limit_per_user'].'</td>';
		
		echo '<td > '.$row['promotion_end_date'].'</td>';

		echo '<td><a href="add_promotions.php?promotions='.$promotion_id.'" class="button button-primary">Edit</a> <button  onClick="deletecoupon('.$promotion_id.')" class="button button-primary">Delete</button></td>';
		echo '</tr>';
		echo '</form>';
	}
	echo '</tbody>';
	echo '</table>';
}
 ?>
	
