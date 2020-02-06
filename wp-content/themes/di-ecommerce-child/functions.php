<?php
/*function wp_67472455() {
   wp_dequeue_style( 'bootstrap' );
}
add_action( 'wp_print_styles', 'wp_67472455', 11);*/
/*wp_register_style( 'JQuery UI', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css' );
wp_enqueue_style('JQuery UI');

wp_register_script( 'jQuery UI', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js', null, null, true );
wp_enqueue_script('jQuery UI');*/

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles',11);
function my_theme_enqueue_styles() {
    //echo "<script>alert(11);</script>";
    /*$parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );*/

    //wp_dequeue_style('bootstrap-css',get_template_directory_uri().'/assets/css/bootstrap.css');
    //wp_dequeue_style('bootstrap');
    //$parent_style = 'bootstrap-parent-style';
    $parent_style="bootstrap-parent-style";
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/css/bootstrap.css' );
    wp_enqueue_style( 'bootstrap-child-style',
        get_stylesheet_directory_uri() . '/assets/css/bootstrap.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    //wp_enqueue_style( "stylesheet1", get_stylesheet_directory_uri() . '/assets/css/fonts.css' );
     //wp_enqueue_style( "stylesheet2", get_stylesheet_directory_uri() . '/assets/css/reset.css' );
    wp_enqueue_style( "stylesheet", get_stylesheet_directory_uri() . '/assets/css/stylesheet.css' );
   
    
}

function wpb_adding_scripts() {
    //echo "<script>alert(12);</script>";
    wp_register_script('custom_script', get_stylesheet_directory_uri().'/assets/js/custom.js', array('jquery'),'1.12.4', false);
 
    wp_enqueue_script('custom_script');

    wp_register_script('bootstrap_script', get_stylesheet_directory_uri().'/assets/js/bootstrap.js', array('jquery'),'4.0.0', false);
 
    wp_enqueue_script('bootstrap_script');

    wp_register_script('common_script', get_stylesheet_directory_uri().'/assets/js/common.js', array('jquery'),'4.0.0', false);
 
    wp_enqueue_script('common_script');
}

  
add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts',12);  

//add_action( 'admin_enqueue_scripts', 'my_theme_enqueue_styles',13);
function admin_enqueue_styles() {
    
    $parent_style="bootstrap-parent-style";
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/css/bootstrap.css' );
    wp_enqueue_style( 'bootstrap-child-style',
        get_stylesheet_directory_uri() . '/assets/css/bootstrap.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    
}
//add_action('admin_enqueue_scripts', 'admin_adding_scripts',14);

function admin_adding_scripts() {
    //echo "<script>alert(12);</script>";

    wp_register_script('bootstrap_script', get_stylesheet_directory_uri().'/assets/js/bootstrap.js', array('jquery'),'4.0.0', false);
 
    wp_enqueue_script('bootstrap_script');

    
}
/*function wpb_adding_scripts1() {
 
    wp_register_script('custom_script1', get_stylesheet_directory_uri().'/assets/js/common.js', array('jquery'),'1.12.4', false);
 
    wp_enqueue_script1('custom_script1');
}*/

//add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts',12 );

//add_action( 'wp_enqueue_scripts1', 'wpb_adding_scripts1',13 );

add_filter( 'wp_mail_content_type', 'set_content_type');
function set_content_type( $content_type ) {
    return 'text/html';
}

        //$product_data = $d['product_type']."_".$d['product_id'

    /*if(isset($_COOKIE["cookie1"])){ 
        echo "Cookie:  " . $_COOKIE["cookie1"]; 
    } else{ 
        echo "No Cookies."; 
    } */

add_action("wp_ajax_custom_login","handle_custom_login");//wp_ajax

add_action("wp_ajax_nopriv_custom_login","handle_custom_login");//wp_ajax

add_action("wp_ajax_lost_password","handle_forgot_pwd");//wp_ajax

add_action("wp_ajax_nopriv_lost_password","handle_forgot_pwd");//wp_ajax

add_action("wp_ajax_password_reset","handle_password_reset");//wp_ajax

add_action("wp_ajax_nopriv_password_reset","handle_password_reset");//wp_ajax

function handle_custom_login(){
    //echo "<script>alert(1);</script>";

    //print_r($_REQUEST);
    //echo "username: ".$_REQUEST['user-login'];
    $refer_url = $_REQUEST['redirect_url'];
    //$refer_url = wp_get_referer();
    if($refer_url==""){
        $redirect_url= site_url();
    }else{
        if(stripos($refer_url,'login')!==FALSE || stripos($refer_url,'logout')!==FALSE || stripos($refer_url,'resetpass')!==FALSE){
        $redirect_url= site_url()."/my-orders/";
        }else if(stripos($refer_url,'personal')!==FALSE){
            $redirect_url= site_url()."/personal-information/";
        }
        else{
            //$redirect_url= $refer_url;

            $redirect_url = site_url()."/my-orders/";
        }
    }
    
    $param = $_REQUEST['param'];
   // echo "userpass: ". $_REQUEST['user-pass'];
    if($param=="login_test"){

        $info=array();
        //$_REQUEST['user-login'];
        //echo "userpass: ".

        //$_REQUEST['user-pass'];
        $info['user_login'] = $_REQUEST['user-login'];
        $info['user_password'] = $_REQUEST['user-pass'];
        //$info['user_login'] = $_REQUEST[''];

        $user_signon = wp_signon($info,false);
        
        if(is_wp_error($user_signon)){
            if(array_key_exists('incorrect_password',$user_signon->errors)){
                $error_msg= "Password is Incorrect";
            }else if(array_key_exists('invalid_email',$user_signon->errors)){
               $error_msg= "Email is Incorrect";
            }

            if(empty($_REQUEST['user-login']) || empty($_REQUEST['user-pass'])){
                $error_msg = "Please enter email ID and Password";
            }
            echo json_encode(array("status"=>0,'error'=>$error_msg));
        }else{
            if($user_signon->id== 1 && $user_signon->user_nicename == "admin"){
                $redirect_url = site_url()."/wp-admin/"; 
            }
            echo json_encode(array("status"=>1,'error'=>$error_msg,'redirect_url'=>$redirect_url,'refer_url'=>$refer_url));
        }
    }
    wp_die();
}
function handle_forgot_pwd(){
    $param = $_REQUEST['param'];
    $user_email = $_REQUEST['user_email'];

    //print_r($_REQUEST);

    if($param=="forgotpwd"){
        //echo "in";
        $user_data = get_user_by('email',$user_email);
        //print_r($user_data);
        if($user_data){
            $key = get_password_reset_key($user_data);
            if ( is_wp_error( $key ) ) {

            }else{
                
            }
            $status=1;
            $url = site_url()."/resetpass/?key=$key&login=$user_email";

            send_forgot_password_mail($user_email,$url);
            echo json_encode(array("status"=>1));
        }else{
            $status=0;
            echo json_encode(array("status"=>0));
        }
        
        //print_r($key);
    }
    wp_die();
}

function handle_password_reset(){

    //print_r($_REQUEST);
    $param = $_REQUEST['param'];
    $user_email = $_REQUEST['user_email'];

    $password1 = $_REQUEST['password1'];
    $password2 = $_REQUEST['password2'];

    if($param=="reset_pass"){
        if($password1==$password2){
            $user_data = get_user_by('email',$user_email);
            $reset_pwd_data = reset_password( $user_data, $password1);
            //print_r($reset_pwd_data);
            send_confirmation_mail($user_email);
            echo json_encode(array("status"=>1));
        }else{
            echo json_encode(array("status"=>0));
        }
    }
    wp_die();
}
add_action('wp_logout',"redirect_to_custom_login_page");
function redirect_to_custom_login_page(){
    wp_redirect(site_url()."/login/");
}

add_action('init',"fn_redirect_wp_admin");
function fn_redirect_wp_admin(){
    global $pagenow;
    if($pagenow=="wp-login.php" && $_REQUEST['action']!="logout"){
        wp_redirect(site_url()."/login/");
        exit();
    }
}
add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : site_url();
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}
function send_confirmation_mail($user_email){
    
    $subject = "Rebow Password Changed";

    $html = "<h3>Your Password was Changed!</h3>
        <p>
        Hi ".$user_email.",

        This email confirms your password reset. You can now log in here.

        If this email was received in error, please contact us immediately.

        If you are still having trouble logging in, or accessing your account. 
        Please call us at 323.277.1111 or email us at info@rebowsystem.com

        </p>" ;
    
        wp_mail($user_email,$subject,$html);
}

function send_forgot_password_mail($user_email,$url){

    $subject = "Rebow Password Reset";
    $html ="<p>
     Hi $user_email,

    <br/>Per your request, please click the link below to reset your ReBow account password ;
    To reset your password, visit the following address: 
    <br/>$url

    <br/>If you have trouble logging in, or accessing your account. 
    Please call us at 323.277.1111 or email us at info@rebowsystem.com

    br/>If this email was received in error, please ignore. </p>";

    wp_mail($user_email,$subject,$html);
}
// hide update notifications
function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes
?>