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
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top checkout-nav">
  <div class="container">

    <!-- Brand -->
    <a class="navbar-brand" href="/rebow/">
      <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/checkout-Logo.svg" class="navbar-brand-img" alt="...">
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapse -->
    <div class="collapse navbar-collapse no-bg" id="navbarCollapse">

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fe fe-x"></i>
      </button>
      <?php global $wp;
      $url = add_query_arg( $wp->query_vars, home_url() );?>
      <!-- Navigation -->
      <ul class="navbar-nav chk-out ml-auto">
        <?php echo (stripos($url,'period')!==FALSE) ? ' <li class="nav-item text-center act-step">' : ' <li class="nav-item text-center">';?>
          <!--<li class="nav-item text-center act-step">-->
          <a class="nav-link" id="navbarLandings" data-toggle="dropdown" href="/rebow/selectperiod/" aria-haspopup="true" aria-expanded="false">
            <span class="circle c1">1</span>
            <span class="circle c2" style="display:none"><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/tick-icon.png" alt=""></span>
            <br>
            <span class="text">
            <?php 
              if($period_data==0){
                echo "RENTAL";
              }else{
                echo "STORAGE";
              }
              ?> <br>PERIOD</span>
          </a>
        </li>
        <?php echo (stripos($url,'delivery')!==FALSE) ? ' <li class="nav-item text-center act-step">' : ' <li class="nav-item text-center">';?>
            <!--<li class="nav-item text-center">-->
          <a class="nav-link" id="navbarLandings" data-toggle="dropdown" href="/rebow/delivery_pickup/" aria-haspopup="true" aria-expanded="false">
            <span class="circle c1">2</span>
            <span class="circle c2" style="display:none"><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/tick-icon.png" alt=""></span>
            <br>
            <span class="text">DELIVERY <br>&amp; PICK UP</span>
          </a>
        </li>
        <?php echo (stripos($url,'personal')!==FALSE) ? ' <li class="nav-item text-center act-step">' : ' <li class="nav-item text-center">';?>
          <!--<li class="nav-item text-center">-->
          <a class="nav-link" id="navbarLandings" data-toggle="dropdown" href="/rebow/personal-information/" aria-haspopup="true" aria-expanded="false">
            <span class="circle c1">3</span>
            <span class="circle c2" style="display:none"><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/tick-icon.png" alt=""></span>
            <br>
            <span class="text">PERSONAL<br>DETAILS</span>
          </a>
        </li>
          <!--<li class="nav-item text-center">-->
        <?php echo (stripos($url,'checkout')!==FALSE) ? '<li class="nav-item text-center act-step">' : ' <li class="nav-item text-center">';?>
          <a class="nav-link" id="navbarLandings" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
            <span class="circle c1">4</span>
            <span class="circle c2" style="display:none"><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/tick-icon.png" alt=""></span>
            <br>
            <span class="text">COMPLETE<br>CHECKOUT</span>
          </a>
        </li>
      </ul>

      <!-- Button -->
      <div class="ml-auto q-call">
        <p>Questions ? Call Us! </p>
        <p><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/call-icon.png" alt="">&nbsp;323 - 277 - 1111</p>
      </div>
    </div>
  </div>
</nav>
<script>
jQuery(document).ready(function(){
  jQuery( "li.act-step" ).prevAll().addClass("act-done");
  jQuery( "li.act-step" ).prevAll().children().children(".c1").remove();
  jQuery( "li.act-step" ).prevAll().children().children(".c2").show();
  //console.log(c1class);
  jQuery('.act-done').click(function(){
      var url=jQuery(this).children('a').attr('href');
      //alert(url);
      jQuery(location).attr('href', url);
  });
});
</script>
<!-- End Navigation -->
<!-- page heading -->