<?php /* Template Name: personal_information*/ ?>
<?php 
	require_once('session_values.php');
	require_once('session_create_for_existing_user.php');
	if ( is_user_logged_in() ) {

		$user_status=1;
		$user_id = wp_get_current_user()->id;
		create_session_for_existing_user($user_id);

		echo "<script>window.location.href = '/rebow/checkout/';</script>";
	
	}else{
		$user_status=0;
	}
?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php 
		
		require_once('header2.php');
		//get_header();
		?>
		<!--<div class="container-fluid">-->
			<!-- page heading -->
		<section class="page-header mt-10">
		  <div class="container">
		  	<?php //print_r($session_data);?>
		    <div class="row justify-content-center">
		      <div class="col text-center">
		        <h1>Your Information</h1>
		      </div>
		    </div>
		  </div>
		</section>
		<!-- Start  breadcrumb -->
		<section class="mt-4">
		  <div class="container">
		    <div class="row justify-content-center">
		      <div class="col-sm-12 p-0">
		        <nav class="bc" aria-label="breadcrumb">
		          <ol class="breadcrumb1">
		            <li class="breadcrumb-item"><a href="#">Pricing</a></li>
		            <li class="breadcrumb-item"><a href="#"><?php echo $breadcrumb1;?></a></li>
		            <li class="breadcrumb-item"><a href="#"><?php echo $breadcrumb2;?></a></li>
		            <li class="breadcrumb-item"><a href="#">Delivery &amp; pickup Details</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Your Information</li>
		          </ol>
		        </nav>
		      </div>
		    </div>
		  </div>
		</section>
		<section class="rp">
		  	<div class="container">
		  		<div class="grey-bg p-5">
			    	<div class="row justify-content-start">
			  			<form class="ur-info-form" id="personal_information_form">
			  				<div class="form-row">
			    				<div class="form-group col-md-6">
			    					<input type="hidden" id="user_status" value="<?php echo $user_status;?>">
			      					<input type="text" class="form-control" id="firstName" placeholder="First Name*" pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$" value="<?php echo $firstName;?>" required>
			    				</div>
			    				<div class="form-group col-md-6">
			      					<input type="text" class="form-control" id="lastName" placeholder="Last Name*" pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$" value="<?php echo $lastName;?>" required>
			    				</div>
			  				</div>
						  	<div class="form-group">
						    	<input type="email" class="form-control" id="email" placeholder="Email*" value="<?php echo $email;?>" required>
						  	</div>
						  	<div class="form-group">
						    	<input type="text" class="form-control" id="companyName" placeholder="Company Name" value="<?php echo $companyName;?>">
						  	</div>
						  	<div class="form-row">
						    	<div class="form-group col-md-6">
						      		<input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number*" minlength=10 maxlength="10" pattern="^[0-9]{10}$" value="<?php echo $phoneNumber;?>" required>
						    	</div>
						    	<div class="form-group col-md-6">
						      		<input type="text" class="form-control" id="SecondaryPhoneNumber" placeholder="Secondary Phone Number" maxlength="10" pattern="^[2-9]{2}[0-9]{8}$" value="<?php echo $SecondaryPhoneNumber;?>">
						    	</div>
						  	</div>
			  				<?php $hearus_array = array("select"=>"Select","Google"=>"Google","Yelp"=>"Yelp","Facebook"=>"Facebook","Friend"=>"Friend");?>
							  <div class="form-group col-md-6 p-0">
							      <label for="inputEmail4">How did you hear about us ?</label>
							      <!--<div class="selectholder">
							        <label>Select</label>-->
							        <select id="selecthearus" required>
										<?php 
										foreach($hearus_array as $key=>$value){
											if($key==$selecthearus){
												echo "<option selected value='$key'>$value</option>";
											}else{
												echo "<option value='$key'>$value</option>";
											}
										}
										?>
									</select>
							      <!--</div>-->
							    </div>
			    			<button type="submit" id="submt_personal_info" class="btn btn-secondary">NEXT</button>
			  			</form>
			    	</div>
			    </div>
		  </div>
		</section>
		<div class="clearfix"></div>
		<section class="mt-3">
			<div class="container">
				<div class="package-selection">
			    	<div class="row justify-content-center my-5">
				      	<div class="col-sm-12 col-md-3 text-center">
				        	<h4 class="order-summary">Order Summary </h4>
				      	</div>
				    </div>
			    	<div class="row mr-3">
		    			<div class="col-sm-12 col-md-4 text-center mt-5">
					        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/dollies.png" alt="">
					    </div>
			      		<div class="col-sm-12 col-md-4">
        					<div class="ps">
				    			<label for="">Your Package Selection :</label>
	          					<!--<div class="selectholder md-selectholder">-->
					    			<select id="selectpackage">
					    				<?php
					    				
					    				//print_r($datas);
					    				foreach($datas as $row){
					    					//$product_name1 = $row['product_name'];
					    					$product_box_count = $row['box_count'];
					    					//$row['product_name'];
					    					$id = $row['product_id'];
					    					$val= $id."/".$row['product_name']."/".$product_box_count;
					    					
					    					if($id==$product_id){
					    						echo "<option selected value='$val'>".$row['product_name']."</option>";
					    					}else{
					    						echo "<option value='$val'>".$row['product_name']."</option>";
					    					}
					    				}
					    				
					    				?>
					    				
					    			</select>
				    			<!--</div>-->
							   	<small>
					                <em>Includes<sup>*</sup> :</em>
					            </small>
					            <div class="clearfix"></div>
				                <ul class="includes pt-1 mb-2">
					                <li>
					                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
					                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
					                  </svg>
					                  <span id="nestable_dollies_count"><?php echo $nestable_dollies_count;?> Nestable Dollies
					                  </span>
					                </li>
					                <li>
					                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
					                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
					                  </svg>
					                  <span id="labels_count">
					                  	<?php echo $labels_count;?> Labels
					                  </span> 
					              	</li>
					                <li>
					                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
					                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
					                  </svg>
					                  <span id="zipties_count">
					                  	<?php echo $zipties_count;?> Security Zip Ties
					                  </span>
					              	</li>
					                <?php if($period_data==0){?>
						                <li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  Free Delivery &amp; Pickup 
						             	</li>
						             	<?php }else{?>
						             	<li>
						                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                  </svg>
						                  2 Day Complimentary
						             	</li>
						             	<li>
						             		Packing / Unpacking Window &nbsp;<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" title="" data-toggle="modal" data-target="#exampleModalCenter"/>
						             	</li>
						             	<?php }?>
				              	</ul>
				              	<label>Rental Time Period:</label>
					            <!--<div class="selectholder md-selectholder">
					                <label>I need help with…</label>-->
					               	<select id="selectperiod1">
				    				<?php
				    				foreach($array1 as $key=>$value){
				    					
				    					if($value==trim($period_data_value)){
				    						echo "<option selected value=$key>$value</option>";
				    					}else{
				    						echo "<option value=$key>$value</option>";
				    					}
				    				}
				    				?>
				    				
				    				</select>
					            <!--</div>-->
			    			</div>
			    			<button type="submit" id="add_more_boxes" class="btn btn-secondary">Add more boxes</button>
		    			</div>
		    			
		    			<div class="col-sm-12 col-md-4">
					        <div class="grey-bg px-5 pt-5">
					          	<p class="pkg">PACKAGE:</p>
					          	<ul class="list-group mb-3">
					            	<li class="list-group-item d-flex justify-content-between lh-condensed">
						             	<div class="col-md-8 p-0">
						                  <ul class="pkg-info">
						                    <li><span id="product_name"><?php echo $product_name;?></span> / <span id="box_count"><?php echo $box_count;?> </span> Boxes </li>
						                    <li id="period_data_span"><?php echo $period_data_span;?></li>
						                    <li class="addedboxfield"><span id="addedboxno"><?php echo $added_box_no;?></span> Added Boxes</li>
						                  </ul>
						                </div>
						                <div class="col-md-4 p-0 text-right align-self-end">
						                   <span id="product_price" class="text-muted">$<?php echo $display_data_price?></span>
						                    <div class="clearfix"></div>
						                    <span id="addedboxprice" class="addedboxfield text-muted">$<?php echo $added_box_price;?></span>
						                </div>
					    			</li>
					    			<li class="list-group-item d-flex justify-content-between lh-condensed">
						              <div class="col-md-8 p-0 align-self-end">
						                <p class="my-0">Subtotal</p>
						              </div>
						              <div class="col-md-4 p-0 text-right">
						                <span id="subtotal" class="text-muted">$<?php echo $subtotal_price;?></span>
						              </div>
						            </li>
						            <li class="list-group-item d-flex justify-content-between lh-condensed">
						              <div class="col-md-8 p-0 align-self-end">
						                <p class="my-0">Delivery - <span id="delivery_floor_level"><?php echo $apartment_level_delivery_text;?></span></p>
						                <p class="my-0">Pickup - <span id="pickup_floor_level"><?php echo $apartment_level_pickup_text;?></span></p>
						              </div>
						              <div class="col-md-4 p-0 text-right align-self-end">
						                <span id="delivery_cost" class="text-muted"><?php 
						                if($delivery_cost==0){
						                	echo $delivery_cost_text;
						                }else{
						                	echo "$".$delivery_cost;
						                }
						                ?></span>
						                <div class="clearfix"></div>
						                <span id="pickup_cost" class="text-muted">
					                	<?php 
						                	if($pickup_cost==0){
						                		echo $pickup_cost_text;
							                }else{
							                	echo "$".$pickup_cost;
							                }
					                	?>
						                </span>
						              </div>
						            </li>
						            <li class="list-group-item d-flex justify-content-between lh-condensed">
						              <div class="col-md-8 p-0 align-self-end">
						                <p class="my-0">Sales Tax</p>
						              </div>
						              <div class="col-md-4 p-0 text-right align-self-end">
						                <span id="sales_tax" class="text-muted">$<?php echo $sales_tax;?></span>
						              </div>
						            </li>
						            <li class="list-group-item d-flex justify-content-between">
						              <span>Total</span>
						              <strong id="total_price">$<?php echo $total_price;?></strong>
						            </li>
						        </ul>
				    		</div>		
		    			</div>
		    		</div>
		    	</div>
		    </div>
		</section>
		<div class="clearfix"></div>
	    <section class="my-5">
		  <div class="container">
		    <div class="row justify-content-center">
		      <div class="col-sm-12 col-md-8">
		        <div class="nt-sure text-center">
		          <h5>Not sure what might work ?</h5>
		          <p>Call one of our service representatives at: <a href="tel:3232771111">323 - 277 - 1111</a></p>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>
	    <?php 
	    	$query = "select keyy,value from lookup_table where description='Boxes'";
				$res = mysql_query($query);	
		?>
		<!-- Add more Boxes -->
		<div class="clearfix"></div>
		<section  id="add_more_boxes_area" style="float:left;width:100%" class="hide grey-bg py-5">
		  	<div class="container">
			    <div class="row justify-content-center">
			      <div class="col-sm-12 col-md-4">
			        <h3 class="text-h">Add More Boxes!</h3>
			      </div>
			    </div>
			    <div class="row justify-content-center">
			      	<div class="col-sm-12 col-md-3">
			        	<img class="mt-5" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/more-boxes.png" alt="">
			      	</div>
			    	<div class="col-sm-12 col-md-4 mt-5">
			        	<p>Need more ReBow™ Boxes?<br>You can add them in sets of 4.</p>
				        <div class="row mt-4">
				          	<div class="col-sm-12 col-md-3">
				            	<p class="pt-2">Quantity</p>
				          	</div>
								<div class="col-sm-12 col-md-8">
					            <div class="selectholder">
					                <label>Choose Boxes</label>
		 							<select id="add_box_count">
		 								<?php while($row=mysql_fetch_assoc($res)){ 

		 									echo "<option value=".$row['keyy'].">".$row['value']."</option>";
		 								
		 								}?>
		 							</select>
		 						</div>
		 					</div>
		 					<div class="col-sm-12 col-md-1">
					            <button id="add_more_boxes785" type="submit" class="btn btn-secondary">Add</button>
					        </div>
								<div class="col-sm-12">
					          <span>Price</span>
					          <label id="added_box_price" for="">$<?php echo $box_count_price;?></label>
					        </div>
					        <div class="col-sm-12 mt-3">
					          	<p>Every 4 Boxes includes : </p>
					          	<ul class="includes pt-1 mb-2">
					              	<li>
						                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                  <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                </svg>
					                1 Nestable ReBow<sup>™</sup> Dolly </li>
					              	<li>
						                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                  <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                </svg>
					                4 Labels
					            	</li>
					              	<li>
						                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
						                  <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
						                </svg>
					                4 Security Zip Ties
					            	</li>
					            </ul>
					        </div>
						</div>
					</div>
			    </div>
		   </div>
		</section>
		<div class="clearfix"></div>
		<?php get_footer(); ?>
		<script src="/rebow/wp-content/themes/di-ecommerce-child/assets/js/order_summary_js.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
		<script>
			jQuery(document).ready(function() {
				//jQuery('#my-modal-login').show();
				//alert(1);
				$( "#email" ).blur(function() {
		          //alert('promocode check');
		          var email = $('#email').val();
		          
		            datastring = "ajax_request=check_user_exist&email="+email;
		            
		            jQuery.ajax({
		                url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
		                method : "POST",
		                data : datastring,
		                success: function(result){
		                    //alert(1);
		                    console.log(result);
		                  	var JSONobj = JSON.parse(result);
		                  	console.log(JSONobj);
		                  	if(JSONobj.user_exist_status==1){
		                  		alert('User Already Exist');
		                  	}
		                  
		                }
		              });

		          
		        });
				jQuery("#phoneNumber").on("keypress keyup blur",function (event) {    
	           		jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
		            if ((event.which < 48 || event.which > 57)) {
		                event.preventDefault();
		            }
	        	});

	        	jQuery("#SecondaryPhoneNumber").on("keypress keyup blur",function (event) {    
	           		jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
		            if ((event.which < 48 || event.which > 57)) {
		                event.preventDefault();
		            }
	        	});
				var user_status = jQuery('#user_status').val();

				//alert(user_status);
				//alert()
				if(user_status==1){
					//jQuery('');
					var datastring="ajax_request=user_set_session_for_personal_info";
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    
						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/checkout/');
						}
					});
				}else{
					
					jQuery('#registration_login').modal('show');
				}
				
			});
			jQuery("#new_user").click(function(event) {
				jQuery('#registration_login').modal('hide');
			});
			jQuery("#existing_user").click(function(event) {
				jQuery(location).attr('href','/rebow/login/');
			});
			jQuery("#submt_personal_info1").click(function(event) {
				//alert(1);
				jQuery('form[id="personal_information_form"]').validate({
					//alert('in');
				  rules: {
				    fname: 'required',
				    lname: 'required',
				    companyName: 'required',
				    email: {
				      required: true,
				      email: true,
				    },
				    
				  },
				  messages: {
				    fname: 'This field is required',
				    lname: 'This field is required',
				    companyName: 'This field is required',
				    email: 'Enter a valid email',
				    
				  },
				   submitHandler: function(form) {
					    submit_personal_info_form();
					}
				});
				//alert("Done");

			});
			//function submit_personal_info_form(){
			jQuery("#personal_information_form").submit(function(event) {
				//alert(123);
				event.preventDefault();
				var product_id = jQuery('#product_id').val();

				var display_period = jQuery('#display_period').val();

				var dp_period = jQuery('#dp_period').val();

				var product_name_field = jQuery('#product_name_field').val();

				var box_count_field = Number(jQuery('#box_count_field').val());

				var added_box_count_field = Number(jQuery('#added_box_count_field').val());
				
				var added_box_price_field = Number(jQuery('#added_box_price_field').val());
				
				var product_price_field = Number(jQuery('#product_price_field').val());

				var subtotal_field = Number(jQuery('#subtotal_field').val());

				var delivery_cost_field = Number(jQuery('#delivery_cost_field').val());

				var pickup_cost_field = Number(jQuery('#pickup_cost_field').val());

				var total_price_field = Number(jQuery('#total_price_field').val());

				var sales_tax_field = Number(jQuery('#sales_tax_field').val());

				var tax_rates = Number(jQuery('#tax_rates').val());

				var default_product_cost = Number(jQuery('#default_product_cost').val());

				var firstName = jQuery('#firstName').val();

				var lastName = jQuery('#lastName').val();

				var email = jQuery('#email').val();

				var companyName = jQuery('#companyName').val();

				var phoneNumber = jQuery('#phoneNumber').val();
				//alert(phoneNumber);
				var SecondaryPhoneNumber = jQuery('#SecondaryPhoneNumber').val();
				//alert(SecondaryPhoneNumber);
				var selecthearus = jQuery('#selecthearus').val();
				//alert(selecthearus);
				var datastring = "ajax_request=goto_payments_page&product_id="+product_id+"&display_period="+display_period+"&dp_period="+dp_period+"&product_name="+product_name_field+"&box_count="+box_count_field+"&added_box_count="+added_box_count_field+"&added_box_price="+added_box_price_field+"&product_price="+product_price_field+"&subtotal="+subtotal_field+"&delivery_cost="+delivery_cost_field+"&pickup_cost="+pickup_cost_field+"&total_price="+total_price_field+"&firstName="+firstName+"&lastName="+lastName+"&email="+email+"&companyName="+companyName+"&phoneNumber="+phoneNumber+"&SecondaryPhoneNumber="+SecondaryPhoneNumber+"&selecthearus="+selecthearus+"&sales_tax="+sales_tax_field;
				//alert(datastring);

				jQuery.ajax({
					url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
					method : "POST",
					data : datastring,
					success: function(result){
					    
					    //var JSONobj = JSON.parse(result);
					    console.log(result);

					    //alert(result);
					    jQuery(location).attr('href', '/rebow/checkout/');
					}
				});
			});
		</script>
	</body>
</html>