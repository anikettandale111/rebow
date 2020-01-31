<?php /* Template Name: personal_information*/ ?>

<html lang="en">
	<body>
		<?php 
		require_once('session_handler.php');
		$session_data = get_rebow_session();
		print_r($session_data);

		get_header(); 
		$data1 =$session_data->order_values;
		$array_data = explode("_",$data1);
		$breadcrumb1 =  $array_data[0]." ".strtoupper($array_data[1]);

		$breadcrumb2 =  $array_data[1]." PERIOD";
		$period=strtoupper($array_data[1]);
		$product_id = $session_data->product_id;
		//$product_type = $_SESSION['product_type'];
		$product_type = $array_data[0];

		//$breadcrumb =  $array1[0]." ".strtoupper($array1[1]);
        if($period=='RENTAL'){
        	$array1 = array(2=>2,3=>2,4=>2);
       	}else{
       		$array1 = array(1=>1,2=>1,3=>1);
       	}

       	$tax_rates = get_tax_rate(); 

       	$rental_cost_per_week = get_base_pricing('Rental_cost_per_1_box_per_1_week');

       	$storage_cost_per_month = get_base_pricing('Monthly_storage_cost_per_box');

       	echo '<input type="hidden" id="rental_cost_per_week" value='.$rental_cost_per_week .'>';
		echo '<input type="hidden" id="storage_cost_per_month" value='.$storage_cost_per_month .'>';
		echo '<input type="hidden" id="tax_rates" value='.$tax_rates .'>';
		//$product_type = $_SESSION['product_type'];
		?>
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<h1>Your Information</h1>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-8 mb-3">
					<?php echo "<p>PRICING / $breadcrumb1 /  $breadcrumb2/ DELIVERY & PICK UP DETAILS / YOUR INFORMATION</p>"; ?>
				</div>
			</div>
			<div class="row justify-content-md-center ">
				<div class="col-sm-12 col-md-10 check-area" style="padding:20px">
					<input type="text" name="firstName" id="firstName" required placeholder="First Name*"/> 
					<input type="text" name="lastName" id="lastName" required  placeholder="Last Name*"/>
					<br/>
					<input type="text" name="email" id="email" required  placeholder="Email*"/>
					<br/>
					<input type="text" name="companyName" id="companyName" required  placeholder="Company Name"/>
					<br/>
					<input type="number" name="phoneNumber" id="phoneNumber*" required  placeholder="Phone Number*"/>
					<input type="number" name="SecondaryPhoneNumber" id="SecondaryPhoneNumber*" required  placeholder="Secondary Phone Number"/>
					<br/>
					<label>How did you hear about us ?</label>
					<br/>
					<select id="selecthearus">
						<option value="select">Select</option>
						<option value="Google">Google</option>
						<option value="Yelp">Yelp</option>
						<option value="Facebook">Facebook</option>
						<option value="Friend">Friend</option>
					</select>
					<br/>
					<br/>
					<button id="submt_personal_info" type="submit" class="btn btn-secondary">NEXT</button>
				</div>
			</div>
			<div class="row justify-content-md-center">
			    	 <h6>Order Summary</h6>
			    </div>

			    <div class="row justify-content-md-center">
			    	
		    			<div class="col-sm-12 col-md-4 text-center system-img">
			        		<img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cube_box1.jpg" alt="" title="">
			      		</div>
			      		<div class="col-sm-12 col-md-4 text-center">
			    			<label>Your Package Selection:</label>
			    			<br/>
			    			<select id="selectpackage">
			    				<?php
			    				
			    				$datas = get_packages_datas($product_type);
			    				//print_r($datas);
			    				foreach($datas as $row){
			    					$product_name = $row['product_name'];
			    					$product_ids = $row['product_id'];
			    					$product_name1 = str_replace(" ","_",$product_name)."_".$product_ids;

			    					//$dropdown_values = $key." Weeks";
			    					//$dropdown_values1 = str_replace(" ","_",$dropdown_values);
			    					if($product_ids==$product_id){
			    						echo "<option selected value=$product_name1> $product_name</option>";
			    					}else{
			    						echo "<option value=$product_name1> $product_name</option>";
			    					}
			    				}
			    				$product_data_new = get_package_data($product_id);
			    				?>
			    				
			    			</select>
			    			<br/>
			    			<small class="includes-text">Includes<sup>*</sup> :</small>
			                <ul class="includes pl-3 pr-3 pt-1 mb-2">
			                  <li>
			                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
			                      <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
			                    </svg>
			                    <span id="nestable_dollies_count"><?php echo $product_data_new['nestable_dollies_count'];?> Nestable Dollies
			                    </span>
			                  </li>
			                  <li> 
			                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
			                      <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
			                    </svg>
			                    <span id="labels_count"><?php echo $product_data_new['labels_count'];?> Labels </span>
			                  </li>
			                  <li>
			                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
			                      <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
			                    </svg>
			                    <span id="zipties_count"><?php echo $product_data_new['zipties_count'];?> Security Zip Ties</span>
			                  </li>
			                </ul>
			                <br/>
			                <label><h6>Select <?php echo $period; ?> Period:</h6></label>
			    			<br/>
			    			<?php echo '<input id="period" type="hidden" value="'.$period.'">'; 
			    				$selected_period =$session_data->selected_period;?>
			    			<select id="selectperiod1"> 
			    				<?php
			    				foreach($array1 as $key=>$value){
			    					if($period=='RENTAL'){
			    						$price = get_rental_price($product_id,$value,$key);
			    						$dropdown_values = $key." Weeks";
			    					}else{
			    						$price = get_storage_price($product_id,$value,$key);
			    						$dropdown_values = $key." Months";
			    					}

			    					$dropdown_values1 = str_replace(" ","_",$dropdown_values);
			    					if($dropdown_values1==$selected_period){
			    						echo "<option selected value=$dropdown_values1> $dropdown_values</option>";
			    					}else{
			    						echo "<option value=$dropdown_values1> $dropdown_values</option>";
			    					}
			    					
			    				}
			    				?>
			    				
			    			</select>
			    			<br/>
			                
			    			<br/>
			    			<br/>

			    			<button type="submit" disabled="true" id="add_more_boxes" class="btn btn-secondary">Add more boxes</button>
		    			</div>
		    			<br/>
		    			<br/>
		    			<div class="col-sm-12 col-md-4 text-center check-area">
		    				<h5>Package</h5>
		    				<?php 
			    				//print_r($product_data_new);
		    					//echo $data1;
		    					if($period=='RENTAL'){
		    						$rental_period = 2;
		    						$duration = 2;
		    						$period_data= 'Weeks';
		    						$price = $session_data->mainprice;
		    						//get_rental_price($product_id,$rental_period,$duration);
		    					}else{
		    						$rental_period = 1;
		    						$duration = 1;
		    						$period_data= 'Months';
		    						$price = $session_data->mainprice;
		    						//get_storage_price($product_id,$rental_period,$duration);
		    					}
			    				//$price = get_rental_price($product_id,$rental_period,$duration);
			    				//$sales_tax = 
			    				$pickup_stairs = 0;
			    			?>
		    				<ul>
		    					<li id="product_name"><?php echo $product_data_new['product_name'];?> / <?php echo $product_data_new['box_count'];?> Boxes</li>

		    					<li><span id="new_period"><?php echo $period_data = str_replace("_", " ", $session_data->selected_period);?></span>  : <span id="mainprice"><?php echo $price=$session_data->mainprice;?></span></li>
		    					<?php 
		    						if($period=='RENTAL'){

		    							$box_count=0;$period_value=2;
		    						}else{
		    							$box_count=0;$period_value=1;
		    						}
		    					?>
		    					<?php $price=$session_data->mainprice;?>
		    					<?php if(empty($session_data->added_box_count)){?>
		    						<li id="addedboxesfield" class="hide"><span id="addedboxno"><?php echo "4 Added Boxes "?>  </span>: <span id="addedboxprice"><?php 
		    						if($period=='RENTAL'){
		    							echo $new_addedboxprice=($box_count*$rental_cost_per_week*$period_value);

		    						}else{
		    							echo $new_addedboxprice=($box_count*$storage_cost_per_month*$period_value);
		    						}
		    						?>
		    					<?php }else{?>
		    						<li id="addedboxesfield"></span></li><span id="addedboxno"><?php echo $session_data->added_box_count." Added Boxes "?>  </span>: <span id="addedboxprice"><?php 
		    						if($period=='RENTAL'){
		    							echo $new_addedboxprice=($session_data->added_box_count*$rental_cost_per_week*$period_value);

		    						}else{
		    							echo $new_addedboxprice=($session_data->added_box_count*$storage_cost_per_month*$period_value);
		    						}
		    					 }?></span></li>
		    					<?php
		    					echo '<input id="new_product_id" type="hidden" value='.$product_id.'> </input>';
		    					echo '<input id="added_box_count" type="hidden" value='.$added_box_count.'> </input>';
		    					
		    						echo '<input type="hidden" id="new_addedboxprice" value='.$new_addedboxprice.'></input>';
		    					
		    					echo '<input type="hidden" id="new_price" value='.$new_price.'></input>';
		    					$new_subtotal=$price+$new_addedboxprice;
		    					$sales_tax = ($new_subtotal*$tax_rates)/100;
		    					$new_total_price=$price+$new_addedboxprice;
		    					echo '<input type="hidden" id="new_subtotal" value='.$new_subtotal.'></input>';

		    					echo '<input type="hidden" id="new_sales_tax" value='.$sales_tax.'></input>';
		    					echo '<input type="hidden" id="new_total_price" value='.$new_total_price.'></input>';

		    					?>
		    				</ul>
		    				<hr/>

		    				<label>Subtotal</label>: <span id="subtotal"><?php echo $new_subtotal;?></span>
		    				<br/>
		    				<label>Delivery - Curb</label>: <span id="delivery_cost"><?php echo $delivery_cost=$session_data->delivery_cost; ?></span>
		    				<br/>
		    				<label>Pickup - Stairs</label>: <span id="pickup_cost"><?php echo $pickup_cost=$session_data->pickup_cost; ?></span>
							<br/>	
		    				<label>Sales Tax</label>:  <span id="sales_tax"><?php echo $sales_tax; ?></span>
							<br/>
							<br/>
		    				<label>Total</label>:  <span id="total_price"><?php echo ($price+$sales_tax+$new_addedboxprice+$pickup_cost+$delivery_cost); ?></span>
		    			</div>
			    </div>
			    <br/>
			    <br/>
			    <div class="row justify-content-md-center">
			    	<h5><b>Not sure what might work ?</b></h5>
			    	<br/>
 					<p>Call one of our service representatives at:  323 - 277 - 1111</p>
			    </div>
			    <br/>
			    <br/>
			    <?php 
			    	$query = "select keyy,value from lookup_table where description='Boxes'";
 					$res = mysql_query($query);	
 				?>
 					
			    <div class="row justify-content-md-center">
			    	<h4>Add More Boxes!</h4>
			    	<br/>
 					<div class="row justify-content-md-center">
 						<div class="col-md-6">
 							<img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cube_box1.jpg" alt="" title="">
 						</div>
 						<div class="col-md-6">
 							<p>Need more ReBow™ Boxes?</p>
 							<p>You can add them in sets of 4.</p>
 							<label>Quantity :</label>
 							<select id="add_box_count">
 								<?php while($row=mysql_fetch_assoc($res)){ 

 									echo "<option value=".$row['keyy'].">".$row['value']."</option>";
 								
 								}?>
 							</select>
 							<button id="add_more_boxes785" type="submit"  class="btn btn-secondary">ADD</button>
 							<br/>
 							<?php 
 							if($period=='RENTAL'){
 								$box_count=0;$period_value=2;
 								$add_box_price = ($box_count*$rental_cost_per_week*$period_value);
 							}else{
 								$box_count=0;;$period_value=1;
 								$add_box_price = ($box_count*$storage_cost_per_month*$period_value);
 							}
 							?>
 							<label>Price : </label>
 							<span id="price1">$<?php echo $add_box_price;?></span>
 							<p>Every 4 Boxes includes : 
						      1 Nestable ReBow™ Dolly
						      4 Labels
						      4 Security Zip Ties
						 	</p>
 						</div>
 					</div>
			    </div>
		</div>
		<?php get_footer(); ?>
		<script>
			var $form = $("form"),
			  $successMsg = $(".alert");
			$.validator.addMethod("letters", function(value, element) {
			  return this.optional(element) || value == value.match(/^[a-zA-Z\s]*$/);
			});
			$form.validate({
			  rules: {
			    name: {
			      required: true,
			      minlength: 3,
			      letters: true
			    },
			    email: {
			      required: true,
			      email: true
			    }
			  },
			  messages: {
			    name: "Please specify your name (only letters and spaces are allowed)",
			    email: "Please specify a valid email address"
			  },
			  submitHandler: function() {
			    $successMsg.show();
			  }
			});
		</script>
	</body>
</html>