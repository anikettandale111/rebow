<?php
/*
Plugin Name: List Table Plugin
Description: A test plugin to demonstrate List table plugin functionality
Author: Yogesh Patil
Version: 0.1
*/
add_action('admin_menu', 'test_plugin_list_table_menu');

function test_plugin_list_table_menu(){
    add_menu_page( 'Table List', 'Table List', 'manage_options', 'Table List', 'test_init_list_table' );

}
function test_init_list_table(){
	ob_start();

	include_once plugin_dir_path(__FILE__).'views/table-listings.php';

	$template = ob_get_contents();


	ob_end_clean();

	echo $template;
}
?>

