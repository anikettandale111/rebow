<?php /* Template Name: support*/ ?>
<?php require_once("user_check_login.php");?>
<?php require_once("db_config.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php get_header();
		$user_id = wp_get_current_user()->id;
		?>
		<!-- FAQ heading -->
		<section class="faq-header">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col text-center">
						<h1>Welcome <?php echo (wp_get_current_user()->display_name);
						$user_id = wp_get_current_user()->id;?></h1>
					</div>
				</div>
			</div>	
		</section>	

		<!-- Start accoordion -->
		<section>
		  <div class="container">
		    <div class="row">
		      <ul class="account">
		        <li><a href="/rebow/my-orders/">My Orders</a></li>
		        <li><a href="/rebow/my-information/">My Information</a></li>
		        <li><a href="/rebow/payment-information/">Payment info</a></li>
		        <li class="selected"><a href="/rebow/support/">Support</a></li>
		      </ul>
		      <div class="rhs-account mb-5 view-order">
		        <div class="row justify-content-left">
		          <div class="col-sm-12 mb-2">
		            <!-- Start order bredcrumb-->
		            <div class="row">
		              <div class="col-sm-12">
		                <ul class="order-breadcrumb">
		                  <li><a href="">SUPPORT</a></li>
		                </ul>
		              </div>
		            </div>
		          </div>
		        </div>
		        <!-- Order Details -->
		        <div class="row">
		          <div class="blue-bg w mx-3 py-3 pl-4">
		            <div class="row">
		              <div class="col-sm-12 o-summary">
		                <div class="edit float-right pr-3">
		                  
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div id="supportform" class="row support">
		          <div class="col-sm-12 pt-4">
		            <div class="row-form px-2 pb-3  ">
		              <p><strong>Need help ?</strong> Please fill out the form below or you can reach us by email or phone at service@rebowsystem.com or call us at 323 - 277 - 1111</p>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row">
		              <div class="col-sm-12 col-md-8">
		                <div class="grey-bg w p-5">
		                	<form id="support_form">
			                  	<div class="row-from">
				                    <div class="col-from-field p-0">
				                      <input id="name" type="text" placeholder="Your Full Name" required>
				                    </div>
			                  	</div>
			                  	<div class="row-from">
				                    <div class="col-from-field">
				                      <input id="email" type="text" required placeholder="Email" pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$">
				                    </div>
			                  	</div>
			                  	<div class="clearfix"></div>
		                   		<div class="row-from">
		                    		<div class="col-from-field">
		                      			<p>I need help with :</p>
		                      		</div>
		                    	</div>
			                    <div class="col-from-field">
			                      <!--<div class="selectholder">
			                        <label>Choose Time</label>-->
			                        <select id="needhelpwith" required>
										<option value="">Select</option>
										<option value="Order">Order</option>
										<option value="Payment">Payment</option>
										<option value="Price">Price</option>
									</select>
			                      <!--</div>-->
			                    </div>
			                  
			                  	<div class="row-from">
			                    	<div class="col-from-field">
			                      	<textarea id="supportmsg" rows="4" cols="40" placeholder="Message"></textarea>
			                    	</div>
			                  	</div>
			                  	<div class="row-from">
			                    	<div class="col-from-field">
			                      		<button id="submit_support_request"class="btn btn-secondary">Submit</button>
			                    	</div>
			                  	</div>
		                	</form>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div id="supportformmsg" class="row support support-min-h hide">
		          <div class="col-sm-12 pt-4">
		            <div class="row-form px-2 pb-3  ">
		             <label for="" class="ml-0">Thank you for your inquiry. We will be in touch within 24-48 hours. </label>
		             <p>If immediate assistance is required, please call us (323) - 277 - 1111 </p>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>

		      </div>
		    </div>
		  </div>
		</section>
		<?php get_footer();?>
		<script>
			jQuery(document).ready(function() {
				jQuery('#support_form').submit(function(event) {
					event.preventDefault();
					var name = jQuery('#name').val();

					var email = jQuery('#email').val();

					var needhelpwith = jQuery('#needhelpwith').val();

					var supportmsg = jQuery('#supportmsg').val();


					var datastring = "ajax_request=submit_support_request&name="+name+"&email="+email+"&needhelpwith="+needhelpwith+"&supportmsg="+supportmsg;
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    jQuery('#supportform').hide();
						    jQuery('#supportformmsg').show();
						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/delivery_pickup');
						}
					});
					    
					
				});
				
			});
		</script>
	</body>
</html>