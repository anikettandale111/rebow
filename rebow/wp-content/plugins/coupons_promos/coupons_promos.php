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
        add_menu_page( 'Coupons Promos Page', 'Promos', 'manage_options', 'coupons_promos', 'coupons_init' );
}

function coupons_init(){
	echo "<div><h3>Coupons</h3>&nbsp;&nbsp;<a href='/rebow/wp-admin/add_promotions.php' id='add_coupon' >Add Coupon</a></div><br/>";
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
	$sql="select * from promotions";

	$result = mysql_query($sql);

	echo '<table class="wp-list-table widefat fixed striped posts">
	<tr><th scope="col" id="coupon_code" class="manage-column column-coupon_code column-primary">Code</th><th scope="col" id="type" class="manage-column column-type">Coupon type</th><th scope="col" id="amount" class="manage-column column-amount">Coupon amount/Percentage Off</th><th scope="col" id="description" class="manage-column column-description">Description</th><th scope="col" id="usage" class="manage-column column-usage">Usage / Limit</th><th scope="col" id="expiry_date" class="manage-column column-expiry_date">Expiry date</th></tr>';
	while($row = mysql_fetch_array($result)){
		$promotion_id = $row['promotion_id'];

		echo '<form method="post" action="options.php">';
		echo '<tr>';
		echo '<td><h3> '.$row['coupon_code'].'</h3><br/>
		<a href="edit_promotions.php?promotions='.$promotion_id.'">Edit</a>
		</td>';

		echo '<td><h3> '.$row['promotion_type'].'</h3></td>';
		if($row['promotion_type']=='Fixed_Amount'){
			echo '<td ><h3>'.$row['discount_amount'].'</h3></td>';
		}else{
			echo '<td ><h3>'.$row['percentage_off'].'</h3></td>';
		}
		echo '<td ><h3> '.$row['promotion_description'].'</h3></td>';
		
		echo '<td ><h3> '.$row['usage_limit_per_user'].'</h3></td>';
		
		echo '<td ><h3> '.$row['promotion_end_date'].'</h3></td>';

		echo '</tr>';
		echo '</form>';
	}
	echo '</table>';
}
 ?>
	
