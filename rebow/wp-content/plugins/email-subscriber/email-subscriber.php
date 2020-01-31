<?php

/*
Plugin Name: Email Subscriber
Plugin URI: http://kentothemes.com
Description: kento email subscribers description here.
Version: 1.1
Author: kentothemes
Author URI: http://kentothemes.com
License URI: http://kentothemes.com/copyright/

*/

/*Active Css/Js File */

if ( !defined( 'ABSPATH' ) ) exit;

require_once( plugin_dir_path( __FILE__ ) . 'theme/body.php');


define('KENTO_EMAIL_SUBSCRIBER_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
function kento_email_subscriber_script()
	{
	wp_enqueue_script('jquery');	
		
	wp_enqueue_style('kento-email-subscriber-style', KENTO_EMAIL_SUBSCRIBER_PLUGIN_PATH.'css/style.css');
	wp_enqueue_style('kento-email-subscriber-animate', KENTO_EMAIL_SUBSCRIBER_PLUGIN_PATH.'css/animate.css');
	
		wp_enqueue_script('kento_email_subscriber_js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'kento_email_subscriber_js', 'kento_email_subscriber_ajax', array( 'kento_email_subscriber_ajaxurl' => admin_url( 'admin-ajax.php')));
	}
add_action('init', 'kento_email_subscriber_script');









register_activation_hook(__FILE__, 'kento_email_subscriber_install');


function kento_email_subscriber_install()
	{
	global $wpdb;
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "kento_email_subscriber"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					name  VARCHAR( 50 ) NOT NULL,
					email  VARCHAR( 50 ) NOT NULL					
					)";
		$wpdb->query($sql);

		}






function kento_email_subscriber_delete_row() {
	
    $email_id = (int)$_POST['email_id'];
	
	global $wpdb;
	$table = $wpdb->prefix."kento_email_subscriber";

	$wpdb->delete( $table, array( 'id' => $email_id ) );
	


	die();
}

add_action('wp_ajax_kento_email_subscriber_delete_row', 'kento_email_subscriber_delete_row');
add_action( 'wp_ajax_nopriv_kento_email_subscriber_delete_row', 'kento_email_subscriber_delete_row');





function kento_email_subscriber_ajax()
	{	
		$subscribe_email = $_POST['subscribe_email'];
		$subscribe_name = $_POST['subscribe_name'];
		

		
	global $wpdb;
	$table = $wpdb->prefix . "kento_email_subscriber";
		
		$result = $wpdb->get_results("SELECT * FROM $table WHERE email='$subscribe_email'", ARRAY_A);
		$total_rows = $wpdb->num_rows;
		
		if($total_rows>0)
			{
				echo "This email already subscribed.";
			}
		else
			{
				$wpdb->query( $wpdb->prepare("INSERT INTO $table 
										( id, name, email )
								VALUES	( %d, %s, %s )",
								array	( '', $subscribe_name, $subscribe_email)
										));
				echo "Thanks for join with us.";
			}
		


		
		
		die();
	}



add_action('wp_ajax_kento_email_subscriber_ajax', 'kento_email_subscriber_ajax');
add_action('wp_ajax_nopriv_kento_email_subscriber_ajax', 'kento_email_subscriber_ajax');




 
function kes_campaign_register() {
 
        $labels = array(
                'name' => _x('ES Campaign', 'post type general name'),
                'singular_name' => _x('Campaign', 'post type singular name'),
                'add_new' => _x('Create ES Campaign', 'wpt'),
                'add_new_item' => __('Add ES Campaign'),
                'edit_item' => __('Edit ES Campaign'),
                'new_item' => __('New ES Campaign'),
                'view_item' => __('View ES Campaigns'),
                'search_items' => __('Search ES Campaigns'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
				
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-email-alt',				
				

          );
 
        register_post_type( 'kes_campaign' , $args );

}


add_action('init', 'kes_campaign_register');




function meta_boxes_kento_email_subscriber()
	{
		$screens = array( 'kes_campaign' );
		foreach ( $screens as $screen )
			{
				add_meta_box('kento_email_subscriber_sectionid',__( 'Email Subscriber Options','kes_campaign' ),'meta_boxes_kento_email_subscriber_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_kento_email_subscriber' );




function meta_boxes_kento_email_subscriber_input( $post ) {

	wp_nonce_field( 'meta_boxes_kento_email_subscriber_input', 'meta_boxes_kento_email_subscriber_input_nonce' );

	
	$kento_email_subscriber_themes = get_post_meta( $post->ID, 'kento_email_subscriber_themes', true );
	$kento_email_subscriber_delay_time = get_post_meta( $post->ID, 'kento_email_subscriber_delay_time', true );
	if(empty($kento_email_subscriber_delay_time))
		{
			$kento_email_subscriber_delay_time = '1000';
		}
	$subscribers_display_op = get_post_meta( $post->ID, 'subscribers_display_op', true );
?>

<form class="warp">  

			<table class="form-table">
            
            
<tr valign="top">
                    <th scope="row">What is this ?</th>
                    <td style="vertical-align:middle;">This is shortcode generator for email subscriber(campaigns) popup box. so you can create unlimited shortcode by creating each custom post <strong>ES Campaign</strong>. By choosing different theme for each different popup box will be amazing experience for visitors.                    


                    </td>
                </tr>
            
            <tr valign="top">
                    <th scope="row"><label ><?php echo __('Shortcode'); ?>: </label></th>
                    <td style="vertical-align:middle;">                     
                                 <input style="background:#92dfe2;" size='60%' onClick="this.select();" name='kento_email_subscriber_shortcode' class='kento_email_subscriber_shortcode' id="kento_email_subscriber_shortcode" type='text' value='<?php echo '[kento_email_subscriber_campaign id="'.get_the_ID().'"]'; ?>' /><br />
                                 

<input style="background:#92dfe2;" size='60%' onClick="this.select();" name='kento_email_subscriber_shortcode' class='kento_email_subscriber_shortcode' id="kento_email_subscriber_shortcode" type='text' value='&lt;?php echo do_shortcode("[kento_email_subscriber_campaign id=<?php echo get_the_ID(); ?>]"); ?&gt;' /><br />                        

       
<span class="subscribers-hint">Please use this shortcode to display email subscriber popup box on your page or php code in theme files.</span>


                    </td>
                </tr>             
            	<tr valign="top">
		<th scope="row"><?php echo __('Themes'); ?>:</th>
		<td style="vertical-align:middle;">
     	<select name="kento_email_subscriber_themes">
        	<option value="one" <?php if($kento_email_subscriber_themes=='one') echo "selected"; ?> >one</option>
            <option value="two" <?php if($kento_email_subscriber_themes=='two') echo "selected"; ?> >two</option>
            <option value="three" <?php if($kento_email_subscriber_themes=='three') echo "selected"; ?> >three</option>
            <option value="four" <?php if($kento_email_subscriber_themes=='four') echo "selected"; ?>>four</option>
            <option value="five" <?php if($kento_email_subscriber_themes=='five') echo "selected"; ?>>five</option>
            <option value="six" <?php if($kento_email_subscriber_themes=='six') echo "selected"; ?>>six</option>                       
        </select>
        <span class="subscribers-hint">Choose different theme for display on different page popup box.</span>
		</td>
	</tr>  

    <tr valign="top">
            <th scope="row"><label for="kento_email_subscriber_delay_time"><?php echo __('Time Delay'); ?>: </label></th>
            <td style="vertical-align:middle;">                     
               <input size='10' name='kento_email_subscriber_delay_time' class='kento_email_subscriber_delay_time' id='kento_email_subscriber_delay_time' type='text' value='<?php if ( isset( $kento_email_subscriber_delay_time ) ) echo $kento_email_subscriber_delay_time; ?>' />millisecond
               <span class="subscribers-hint">Delay time to display popup. 1Second = 1000Milli Second</span>
            </td>
        </tr>
        
    <tr valign="top">
            <th scope="row"><label for="subscribers_display"><?php echo __('Popup for every refresh'); ?>: </label></th>
            <td style="vertical-align:middle;">                     
                <label>
                 <input size='10' name='subscribers_display_op' class='subscribers_display' id='subscribers_display' type='checkbox' value='1' <?php if (  $subscribers_display_op =='1' ) echo 'checked="checked"'; ?>  />
                 <?php if (  $subscribers_display_op =='1' ) echo 'Off'; else echo "On"; ?>
                 </label>
                 <span class="subscribers-hint">Popup will display for every refresh.</span>
                 
            </td>
        </tr>    

			</table>


</form>



<?php



}




function meta_boxes_kento_email_subscriber_save( $post_id ) {

  if ( ! isset( $_POST['meta_boxes_kento_email_subscriber_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_kento_email_subscriber_input_nonce'];

  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_kento_email_subscriber_input' ) )
      return $post_id;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
	  
	  
	$kento_email_subscriber_themes = $_POST['kento_email_subscriber_themes'];	
	update_post_meta( $post_id, 'kento_email_subscriber_themes', $kento_email_subscriber_themes );	
	  
	$kento_email_subscriber_delay_time = $_POST['kento_email_subscriber_delay_time'];	
	update_post_meta( $post_id, 'kento_email_subscriber_delay_time', $kento_email_subscriber_delay_time );
	
	$subscribers_display_op = $_POST['subscribers_display_op'];	
	update_post_meta( $post_id, 'subscribers_display_op', $subscribers_display_op );		  		
}


add_action( 'save_post', 'meta_boxes_kento_email_subscriber_save' );



function kento_email_subscriber_display($atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",

				), $atts);


			$postid = $atts['id'];
			
$kento_email_subscriber_delay_time = get_post_meta( $postid, 'kento_email_subscriber_delay_time', true );
$subscribers_display_op = get_post_meta( $postid, 'subscribers_display_op', true );
$kes_display ="";

$kes_display.= '<div class="kento_email_subscriber">';
$kes_display.= kento_email_subscriber_table_body($postid);

$kes_display.= '</div>';











if($subscribers_display_op=='1')
	{
		$kes_display.='<script>
			jQuery(document).ready(function($) {
			
			setTimeout(function(){
				
				jQuery(".kento_email_subscriber").css("display","block");
				jQuery(".subscribe_main").addClass("animated bounceIn");
				
				}, '.$kento_email_subscriber_delay_time.');
			   
			});
			
			</script>';
	}
else
	{
		if(!isset($_COOKIE['kento_email_subscriber']) )
			{
			$kes_display.='<script>
			jQuery(document).ready(function($) {
			
			setTimeout(function(){
				
				jQuery(".kento_email_subscriber").css("display","block");
				}, '.$kento_email_subscriber_delay_time.');
			   
			});
			
			</script>';
		
				$cookie_nam = "kento_email_subscriber";
		
				?>
				<script>
				document.cookie="<?php echo $cookie_nam ?>=yes";
				</script>
				
				<?php
			}
	}


return $kes_display;

}

add_shortcode('kento_email_subscriber_campaign', 'kento_email_subscriber_display');




add_action('admin_menu', 'kento_email_subscriber_list_init');

	
function kento_email_subscriber_list_settings(){
	include('kento-email-subscribers-list.php');	
}

function kento_email_subscriber_list_init() {

	
	add_submenu_page('edit.php?post_type=kes_campaign', __('Subscriber List','menu-list'), __('Subscriber List','menu-list'), 'manage_options', 'kento_email_subscriber_list_settings', 'kento_email_subscriber_list_settings');
}




?>