<?php /* Template Name: contactus*/ ?>
<?php require_once("db_config.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php get_header(); ?>
		<!-- FAQ heading -->
		<section class="faq-header bdr-top">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col text-center">
						<h1>Contact</h1>
					</div>
				</div>
			</div>	
		</section>	
		<section class="mt-5 con-details">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6 mt-5 ">
						<h3><b>Contact Details</b></h3>
						<div class="row mb-4 mt-3">
							<div class="col-sm-1 mt-3">
					            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/busket-icon.png" alt="">      
					        </div>
							<div class="col-sm-11">
								<address>
									141 W Avenue 34<br>
									Los Angeles, CA 90031
								</address>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-sm-1">
					            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/call-blue-icon.png" alt="">     
					        </div>
							<div class="col-sm-11">
								<p>323 - 277 - 1111</p>
							</div>
						</div>
						<div class="row mb-5">
							<div class="col-sm-1 mt-1">
					            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/email-blue-icon.png" alt="">     
					        </div>
							<div class="col-sm-11">
								<a class="email-link" href="mailto:info@rebowsystem.com">info@rebowsystem.com</a>
							</div>
						</div>
						<div class="qa">
							<div class="col-12 p-0">
								<p>QUICK ANSWERS :</p>
								<p>Check out our <a href="/rebow/faq/"><u>FAQ page</u></a></p>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 fw">
						<div id="CNFORM" class="grey-bg p-5">
							<h3>How can we help ?</h3>
							<small>Please fill in the form below and we will be in touch :</small>
							<form id="contactForm" class="mt-5">
							  	<div class="form-group">
									<input required type="text" class="form-control" id="FullName" aria-describedby="emailHelp" pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$" placeholder="Your Full Name*">
							  	</div>
							  	<div class="form-group">
									<input required type="email"  class="form-control" id="InputEmail" placeholder="Email*" pattern="/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/">
							  	</div>
								<div class="form-group">
									<input type="text" class="form-control" id="phonenumber"  placeholder="Phone Number" minlength=10 pattern="^[0-9]{10}$">
							  	</div>
							  	<div class="form-group">
								  	<div class="selectholder">
									<label>I need help with…</label>
									<select name="needhelp" id="needhelp" required>
									  	<option value="">Select</option>
						                <option value="Order">Order</option>
						                <option value="Price">Price</option>
						                <option value="Delivery">Delivery</option>
									</select>
								  	</div>
								</div>
								<div class="form-group">
									<textarea  id="message" cols="40" rows="5" placeholder="Message"></textarea>
							  	</div>
								
							  	<button id="contact_submit" type="submit" class="btn btn-secondary"><b>Submit</b></button>
							</form>
						</div>
						
						<div id="contactmsg" class="hide grey-bg p-5" style="height:500px;">
							<h5>Thank you for your inquiry! </h5>
							
							<br/>
							
							<h5>We will be in touch.</h5>
							
						</div>
					</div>	
				</div>
			</div>	
		</section>
		<?php get_footer(); ?>
		<script>
			jQuery(document).ready(function() {
				jQuery("#phonenumber").on("keypress keyup blur",function (event) {    
	           		jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
		            if ((event.which < 48 || event.which > 57)) {
		                event.preventDefault();
		            }
	        	});
	        });		
	    </script>
	</body>
</html>