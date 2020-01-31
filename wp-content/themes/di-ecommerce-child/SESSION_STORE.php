<?php 
session_start();
//ini_set();
//session_destroy();

class STORE_SESSION{
			
	public $order_values;
	
	public $zip_current;

	public $zip_new;

	public $zip_status;

	public $new_addedboxprice;

	public $new_price;

	public $new_subtotal;

	public $new_total_price;

	function set_order_values($order_values){
		$this->order_values=$order_values;
	}

	function set_zip_current($zip_current){
		$this->zip_current=$zip_current;
	}

	function set_zip_new($zip_new){
		$this->zip_new=$zip_new;
	}

	function set_zip_status($zip_status){
		$this->zip_status=$zip_status;
	}
	function set_new_addedboxprice($new_addedboxprice){
		$this->new_addedboxprice=$new_addedboxprice;
	}

	function set_new_price($new_price){
		$this->new_price=$new_price;
	}

	function set_new_subtotal($new_subtotal){
		$this->new_subtotal=$new_subtotal;
	}

	function set_new_total_price($new_total_price){
		$this->new_total_price=$new_total_price;
	}



}

function get_values(){
	$STORE_SESSION1 = new STORE_SESSION();


	return $STORE_SESSION1;
}



?>