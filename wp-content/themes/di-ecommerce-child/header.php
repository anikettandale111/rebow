<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.css" >
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.js"></script>
<head>
	
	<?php do_action( 'di_ecommerce_the_head' ); ?>

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php
if( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<!-- Loader icon -->
<?php
if( get_theme_mod( 'loading_icon', '0' ) == 1 ) {
?>
	<div class="load-icon"></div>
<?php
}
?>
<?php 
//echo $_SERVER['DOCUMENT_ROOT'];
require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');
/*$con = mysql_connect("localhost","root","");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

//mysql_query('SET names utf8');
mysql_set_charset('utf8');
$db = mysql_select_db("rebow");*/
$cur_date=date('Y-m-d');
$q= mysql_query("SELECT * from promotions where promotion_start_date < '$cur_date' and promotion_end_date > '$cur_date'");
$res =mysql_fetch_assoc($q);
if(!empty($res)){
	$prom_text = $res['promotion_description'];
}else{
	
}

echo "<header class='masthead text-center'>
      <p>$prom_text</p>
 </header>";
 ?>
<!-- Loader icon Ends -->
<?php get_template_part( 'template-parts/header', 'menu' ); ?>

<?php get_template_part( 'template-parts/header', 'main' ); ?>

<?php //get_template_part( 'template-parts/header', 'sidebar-cart' ); ?>

<?php //get_template_part( 'template-parts/header', 'slider' ); ?>

<?php //get_template_part( 'template-parts/header', 'headerimg' ); ?>

<!--<div id="maincontainer" class="container-fluid mrt20 mrb20 clearfix maincontainer">  start header div 1, will end in footer -->
	<!--<div class="container">  start header div 2, will end in footer -->
		<!--<div class="row">  start header div 3, will end in footer -->
		