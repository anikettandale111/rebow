<?php /* Template Name: Services */ ?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php get_header(); ?>
		<!-- banner-->
		<main class="banner">
		  <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/service-banner.jpg" alt="" title="" class="banner">
		  <div class="container">
		    <div class="row justify-content-center">

		      <div class="baner-overlay bnner-ovly col-md-auto">
		        <div class="banner-intro justify-content-center service-banner">
		          <h1>Rent &amp; store your ReBow™ Boxes </h1>
					<hr>
		          <p class="axiformalight">Whether you’re moving your business, residence or even your dorm<br>
		 			 - we’ve got you covered.</p>
		        </div>
		      </div>
		    </div>
		  </div>
		</main>
		<!--end banner -->
		<!-- Start Rental Service -->
		<section class="rental-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6 rental-service text-center">
						<h2>Rental Service</h2>
						<div class="rental-wrap">
							<p>Rent ReBow™ Boxes &amp; make your move easier!*<br>How it Works&nbsp;<img data-toggle="modal" data-target="#how_it_works" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" title=""/> </p>
							<h3>Starting at $<?php echo get_lowest_price_rental_package();?> / 2 weeks*</h3>
							<button id="get_rental" class="btn btn-secondary mb-3">GET RENTAL</button>
							<div class="clearfix"></div>
							<small><em>*Available in Los Angeles only</em></small>
						</div>
						<?php 
							$data = get_minimum_package_data();
					    	//print_r($data);
					    	$product_type = $data['product_type'];
					    ?>
						<h4 class="axiformabold">Minimum Rental Package Includes* :</h4>
						<ul class="includes">
						<li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                 <?php echo $data['box_count']?> ReBow™ Boxes</li>
		                <li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['nestable_dollies_count']?> Nestable Dollies </li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['labels_count']?> Labels </li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['labels_count']?> Security Zip Ties </li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  Free Delivery &amp; Pickup &nbsp;<img data-toggle="modal" data-target=".bd-example-modal-lg" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt=""></li>
		              </ul>
					</div>
					<div class="col-sm-12 col-md-6">
						<img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/rental-boxes.jpg" alt="" title="" />
					</div>
				</div>
			</div>	  
		</section>
		<!-- Rental Benefits -->
		<section class="rental-benefits">
		<div class="container-fluid">
			<div class="row justify-content-center text-center rnt-bhd">
				<div class="col-12">
					<h3 class="axiformaregular">Rental Benefits</h3>
					<p>Just stack, pack and roll - it’s that <span>conveinent</span></p>
				</div>
			</div>
			<div class="row text-center benefits-fet">
				<div class="col-12 col-sm-2">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/heart-icon.png" alt="" title=""/>
					<p>SIMPLICITY &amp;<br> EASY TO USE</p>
				</div>
				<div class="col-12 col-sm-2">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/secure.png" alt="" title=""/>
					<p>SAFE &amp; SECURE</p>
				</div>
				<div class="col-12 col-sm-2">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/no-heavy-icon.png" alt="" title=""/>
					<p>NO HEAVY<br> LIFTING</p>
				</div>
				<div class="col-12 col-sm-1">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/clock-icon.png" alt="" title=""/>
					<p>MORE EFFICIENT</p>
				</div>
				<div class="col-12 col-sm-2">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cost-icon.png" alt="" title=""/>
					<p>COST EFFECTIVE</p>
				</div>
				<div class="col-12 col-sm-1">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/clean-icon.png" alt="" title=""/>
					<p>CLEAN</p>
				</div>
				<div class="col-12 col-sm-2">
					<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/sustainable-icon.png" alt="" title=""/>
					<p>SUSTAINABLE</p>
				</div>
			</div>
		</div>
			  
		</section>
		<!-- Start storage solution -->
		<section class="rental">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/storage-solution.jpg" alt="" title="" />
					</div>
					<div class="col-sm-12 col-md-6 rental-service text-center">
						<h2>Storage Solutions</h2>
						<div class="rental-wrap">
							<p>Store your ReBow<sup>TM</sup>Boxes!*<br>How it Works&nbsp;<img data-toggle="modal" data-target="#how_it_work"src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" title=""/> </p>
							<h3>Starting at  $<?php echo get_loweset_price_storage_package();?> / month*</h3>
							<button type="submit" id="get_storage" class="btn btn-secondary mb-3">GET STORAGE</button>
							<div class="clearfix"></div>
							<small><em>*Available in our Los Angeles Location only. </em></small><br>
							<small><em>Storage is only available with ReBow<sup>TM</sup> Box Rental</em></small>
						</div>
						<?php $data = get_minimum_package_data();
				    		//print_r($data);
				    		$product_type = $data['product_type'];
				    	?>
						<h4>Minimum Storage Package Includes* :</h4>
						<ul class="includes">
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['box_count']?> ReBow™ Boxes
		              	</li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['nestable_dollies_count']?> Nestable Dollies</li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['labels_count']?> Labels </li>
							<li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  <?php echo $data['zipties_count']?> Security Zip Ties </li>
		                <li>
		                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
		                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
		                  </svg>
		                  FREE Delivery &amp; Pickup <img data-toggle="modal" data-target=".bd-example-modal-lg" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt=""></li>
		                  <li class="complimentary">
			                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
			                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
			                  </svg>
			                   2 day complimentary packing and unpacking &nbsp;<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" title="" data-toggle="modal" data-target="#exampleModalCenter"/>
			                 </li>
		              </ul>
					</div>
				</div>
				<hr>
			</div>	  
		</section>
			 <!-- Start micro Storage -->
			  <section class="micro-strg mt-5">
			  	<div class="container">
					<div class="row">
						<div class="col-sm-12 text-center msh">
							<h3>Micro Storage Benefits</h3>
							<p>Storage that is <span>safe and easy</span></p>
						</div>
					</div>
					<div class="row justify-content-center text-center">
						<div class="col-6 col-sm-2">
							<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/security.png" alt="" title=""/>
							<p>24 HR MONITORED SECURITY</p>
						</div>
						<div class="col-6 col-sm-2">
							<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/eye-icon.png" alt="" title=""/>
							<p>VIDEO SURVELLIANCE</p>
						</div>
						<div class="col-6 col-sm-2">
							<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/govt-icon.png" alt="" title=""/>
							<p>GOVERNMENT APPROVED FACILITY</p>
						</div>
						<div class="col-6 col-sm-2">
							<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/calender-icon.png" alt="" title=""/>
							<p>SCHEDULED STORAGE ACCESS</p>
						</div>
						<div class="col-6 col-sm-2">
							<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/climate-control-icon.png" alt="" title=""/>
							<p>INDOOR CLIMATE CONTROL</p>
						</div>
						<div class="col-6 col-sm-2">
							<img class="mb-4" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/paking-unpaking-icon.png" alt="" title=""/>
							<p>2 DAY PACKING / UNPACKING WINDOW</p>
						</div>
					</div>
				</div>
			  </section>
			  
			  <!-- start our service blue bg -->
			  
			  <section class="os blue-bg py-5 mt-5">
			  	<div class="container-fluid">
					<div class="row justify-content-center">
						<div class="col-sm-12 text-center">
							<h6>Not sure what might work ?</h6>
							<p>Call one of our service representatives at 323-277-1111</p>
						</div>
					</div>  
			    </div>
			  </section>

		<!--conpare to cardboard -->
		<section class="py-6 cardboard">
		  <div class="container">
			  <div class="row text-center">
			  	<div class="col">
					<h3>Compare us to cardboard</h3>  
					<h5 class="mt-5 mb-5">COST FOR 1 BEDROOM (250 - 500 Sq Ft) :</h5>
				</div>
			  </div>
		    <div class="row">
		      <div class="col-sm-12 col-md-5"> <img class="img-fluid top-m" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cardboard.png" alt="" title="">
		        <div class="blue-bg mt-3 text-center py-2">
		          <label>$248.00 </label>
		          <p>WITH AMAZON PRIME</p>
		        </div>
		      </div>
		      <div class="col-sm-12 col-md-1 mt-13">
		        <h4><b>VS</b></h4>
		      </div>
		      <div class="col-sm-12 col-md-6 float-right"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/rebow-boxes.png" alt="" title="">
		        <div class="blue-bg mt-3 text-center py-2">
		          <label><!--<strike>$170.00</strike>--> $144.00 </label>
		          <p>REBOW™ RENTAL FOR 2 WEEKS</p>
		        </div>
		      </div>
		    </div>
			  <div class="row my-5 justify-content-center">
			  	<div class="col-sm-12 col-md-8 text-center headache">
					<p>Oh, this doesn’t include the headache and all the other extra things you’re going to keep in your house afterwards and throw out ;)
					</p>  		
					<button id="" class="get_started btn btn-secondary mt-5">Get Started</button>
				</div>
			  </div>
		  </div>
		</section>
		<?php get_footer(); ?>
		<script>
			//var hostname = location.hostname;
			jQuery( "#get_rental" ).click(function() {
				jQuery(location).attr('href', '/rebow/pricing/');
			});
			jQuery( "#get_storage" ).click(function() {
				jQuery(location).attr('href', '/rebow/pricing/');
			});


		</script>
	</body>
</html>