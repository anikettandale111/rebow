<?php /* Template Name: about_us */ ?>

<?php 
	
	require_once('session_create_for_order.php');
	if(!is_user_logged_in()){
		//echo "in";
		if(isset($_REQUEST['order_id'])){
			echo "order_id: ".$order_id = $_REQUEST['order_id'];

			create_session_for_order($order_id);
			header('Location: '.'http://192.168.1.191/rebow/personal-information/');
		}
	}
	
?>
<html lang="en">
	<body>
		<head>
			<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
		</head>
		<?php
		//require_once('session_values.php');
		get_header(); ?>
		<!-- Musthead Banner-->
	  	<section>
		    <div class="container">
		      <div class="row">
		        <div class="col-sm-12 text-center about-heading">
		          <h3>About Us</h3>
		        </div>
		      </div>
		      <div class="row">
		        <div class="col-sm-12 col-md-6">
		          <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/ReBow-table-silo.png" alt="">
		        </div>
		        <div class="col-sm-12 col-md-6 about-info mb-5">
		          <h2>An easy, eco-friendly, <br>efficient moving system</h2>
		          <p>ReBow™ was born for the customers and for the environment. With the rising cost of card board and the damage to our earth, ReBow™ sets out to solve the frutstrations for both. </p>
		          <p>The concept was developed by Eric Ortiz after 20+ years in the moving business.  Currently based in the Southern California, ReBow™ is a friendly, family oriented business commited to excellence and helping customers move and store their stuff safely, securely while being kind to the environment.
		          </p>
		        </div>
		      </div>
		    </div>
	  	</section>
		<!--End musthead banner --> 
		<!-- how its work -->
		<section class="blue-bg py-5 pt-6">
		  <div class="container">
		    <div class="row justify-content-md-center">
		      <h3>How It Works</h3>
		      <div class="col-12 mt-5">
		        <div class="work-steps">
		          <div class="w-steps">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/order-computer.svg" alt="" title="">
		          </div>
		          <p><b>1. ORDER</b></p>
		          <p class="ws-d">Place your order online.</p>
		        </div>
		        <div class="work-steps">
		          <div class="w-steps">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/boxes-icon.svg">
		          </div>
		          <p><b>2. WE DELIVER</b></p>
		          <p class="ws-d">We dropoff your<br/> ReBow™ Boxes.</p>
		        </div>
		        <div class="work-steps">
		          <div class="w-steps">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/assign-box-icon.png">
		          </div>
		          <p><b>3. YOU PACK</b></p>
		          <p class="ws-d">You pack and move<br /> your stuff.</p>
		        </div>
		        <div class="work-steps">
		          <div class="w-steps">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery-time-icon.png">
		          </div>
		          <p><b>4. WE PICKUP</b></p>
		          <p class="ws-d">We pickup your empty ReBow™ Boxes or put them in storage.</p>
		        </div>
		        <div class="work-steps">
		          <div class="w-steps">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/warehouse-godown.png">
		          </div>
		          <p><b>5. STORAGE DELIVERY</b></p>
		          <p class="ws-d">We will deliver your storage to<br /> you and pickup empty boxes<br/> on request.</p>
		        </div>
		      </div>
		    </div>
		    <div class="row justify-content-center">
		      <div class="col-ml-auto mt-5">
		        <button class="get_started btn btn-primary"><b>Get Started</b></button>
		      </div>
		    </div>
		  </div>
		</section>

		<!--compare to cardboard -->
		<section class="py-6 cardboard">
		  <div class="container">
		    <div class="row">
		      <div class="col-sm-12 com-h">
		        <h2>Compare us to cardboard</h2>
		        <h3>COST FOR 1 BEDROOM (250 - 500 Sq Ft) :</h3>
		      </div>
		    </div>
		    <div class="row">
		      <div class="col-sm-12 col-md-5"> <img class="img-fluid top-m" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cardboard.png" alt="" title="">
		        <div class="blue-bg mt-3 text-center py-2">
		          <label>$248.00 </label>
		          <p>WITH AMAZON PRIME</p>
		        </div>
		      </div>
		      <div class="col-sm-12 col-md-1 mt15">
		        <h4><b>VS</b></h4>
		      </div>
		      <div class="col-sm-12 col-md-6 float-right"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/rebow-boxes.png" alt="" title="">
		        <div class="blue-bg mt-3 text-center py-2">
		          <label>$144.00 </label>
		          <p>REBOW™ RENTAL FOR 2 WEEKS</p>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>
		<!-- Start Get started -->
		<section>
		  <div class="container">
		    <div class="row justify-content-md-center">
		      <div class="col-sm-12 col-md-7 text-center my-4">
		        <p>Oh, this doesn’t include the headache and all the other extra things you’re going to keep in your house afterwards and throw out ;)</p>
		        <button type="" class="get_started btn btn-secondary mt-4">Get Started</button>
		      </div>
		    </div>
		  </div>
		</section>


		<?php get_footer();?>

	</body>
</html>