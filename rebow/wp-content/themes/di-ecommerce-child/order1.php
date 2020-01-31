<?php /* Template Name: Order1 */ ?>

<html lang="en">
	<body>
		<?php get_header(); ?>
		<div class="container-fluid">
			<div class="container">
				<div class="row justify-content-center">
					<h4>Where are you moving ?</h4>
				</div>

				
				<div class="container">
				    <div class="row ">
				      <div class="col-md-6 mb-3">
				        
				        <p>PRICING / RESIDENTIAL RENTAL / ZIPCODE VALIDATION</p>
				      </div>
				    </div>
					<?php get_template_part('template-parts/zipcodecheck')?>
			</div>
		</div>

		<?php get_footer(); ?>

	</body>
</html>