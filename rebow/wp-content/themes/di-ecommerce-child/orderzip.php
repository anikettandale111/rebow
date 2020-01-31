<?php /* Template Name: Orderzip */ ?>

<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php 
		//session_start();
		require_once('session_values.php');
		//print_r($session_data);
		get_header(); ?>
		<!-- FAQ heading -->
		<section class="faq-header">
		  <div class="container">
		    <div class="row justify-content-center">
		      <div class="col text-center">
		        <h1>Where are you moving ?</h1>
		      </div>
		    </div>
		  </div>
		</section>

		<!-- Start 	breadcrumb -->
		<section>
		  <div class="container">
		    <div class="row justify-content-center">
		      <div class="col-sm-12 col-md-8">
		        <nav class="bc" aria-label="breadcrumb">
		          <ol class="breadcrumb1">
		            <li class="breadcrumb-item"><a href="/rebow/pricing/">PRICING</a></li>
		            <li class="breadcrumb-item"><a href="#"><?php echo $breadcrumb1;?></a></li>
		            <li class="breadcrumb-item active" aria-current="page">ZIPCODE VALIDATION</li>
		          </ol>
		        </nav>
		      </div>
		    </div>
		  </div>
		</section>
		<?php get_template_part('template-parts/zipcodesubmit')?>
		
		<!-- Start not sure -->
		<section>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-8 mb-5 pb-5">
						<div class="nt-sure text-center">
							<h5>Not sure what might work ?</h5>
							<p>Call one of our service representatives at: <a class="nt-sure" href="tel:3232771111">323 - 277 - 1111</a></p>
						</div>
					</div>
				</div>
			</div>
		</section>	

		<?php get_footer(); ?>
		<script>
			jQuery("#zipcodesubmit").click(function(){
				
				var zip_current = jQuery('input[placeholder="Current Zip Code"]').val();
				console.log('zip_current : '+zip_current);
				var zip_new = jQuery('input[placeholder="New Address Zip Code"]').val();
				console.log('zip_new : '+zip_new);
				var js_data = '<?php echo json_encode($session_data); ?>';

				console.log('js_data : '+js_data);
				jsonString="ajax_request=zipcheck&zip_current="+zip_current+"&zip_new="+zip_new+"&alert=0";
			  	jQuery.ajax({
			        type: "POST",
			        url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
			        data: jsonString,
			        //dataType: "json",
			        success: function(result) {
			            window.console.log('Successful');
			            ///console.log("result: "+result);
			            //console.log(result.msg);
			            console.log("result"+result);
		                var json_obj = JSON.parse(result);
		                //alert(json_obj.alert);
		                if(json_obj.match==1){

		                	 jQuery(location).attr('href', '/rebow/selectperiod/');
		                  //jQuery('#service_yes').modal('show');
		                }else{
		                  jQuery('#service_no').modal('show');

		                }
			        }
			    });
			});
		</script>

	</body>
</html>