<?php /* Template Name: delivery_pickup1*/ ?>

<html lang="en">
	<body>
		<?php 
		require_once('session_handler.php');
		$session_data = get_rebow_session();
		print_r($session_data);

		get_header(); 
		//print_r($_SESSION);
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
		<?php echo '<input id="period" type="hidden" value="'.$period.'">'; ?>
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<h1>Pickup & Dropoff Details</h1>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-8 mb-3">
					<?php echo "<p>PRICING / $breadcrumb1 /  $breadcrumb2/ DELIVERY DETAILS</p>"; ?>
				</div>
			</div>
			<div class="row justify-content-md-center">

				<div id="deliver_boxes" class="col-sm-12 col-md-10 check-area">
					<form id="delivery_box_submit">
						<h5>Delivery of your ReBow™ Boxes :</h5>
						<label>Delivery Date* : </label>
						<input id="delivery_date" type="date" required/>
						<br/>
						<br/>
						<label>Preferred Delivery Time* : </label>
						<select id="preferred_delivery_time">
							<option value="8:30-11:00_am">8:30 - 11:00 am</option>
							<option value="11:00-1:00_pm">11:00 - 1:00 pm</option>
							<option value="1:00-4:00_pm">1:00 - 4:00 pm</option>
						</select>
						<label>Alternate Delivery Time* :  : </label>
						<select id="alternate_delivery_time">
							<option value="8:30-11:00_am">8:30 - 11:00 am</option>
							<option value="11:00-1:00_pm">11:00 - 1:00 pm</option>
							<option value="1:00-4:00_pm">1:00 - 4:00 pm</option>
						</select>
						<br/>
						<label>Delivery Address*: </label> <input id="delivery_address" type="text" required/> <input id="apt_unit_delivery" type="text" required/>
						<br/>
						<p>Do you live in a walk-up or elevator building?* Whats This?</p>
						<br/>
						<select id="apartment_level_delivery" class="apartment_level">
							<option value="Neither">Neither</option>
							<option value="Elevator">Elevator</option>
							<option value="Stairs">Stairs</option>
						</select>
						<br/>

						<button type="submit" id="continue_delivery" class="btn btn-secondary">CONTINUE</button>
					</form>
				</div>
			</div>
			<br/>
			<br/>
			<div class="row justify-content-md-center">
				<div id="pick_up_packed_boxes" class="storage col-sm-12 col-md-10 check-area">
					<form id="pick_up_packed_boxes_submit">
						<h5>Pick up your Packed ReBow™ Boxes For Storage: </h5>
						<label>Pickup Date* : </label>
						<span id="pickup_date_packed"></span>
						<p>*If this date does not work, please adjust your delivery date.</p>
						<label>Preferred Pickup Time* : </label>
						<select id="preferred_pickup_time_packed">
							<option value="8:30-11:00_am">8:30 - 11:00 am</option>
							<option value="11:00-1:00_pm">11:00 - 1:00 pm</option>
							<option value="1:00-4:00_pm">1:00 - 4:00 pm</option>
						</select>
						<label>Alternate Pickup Time* :  : </label>
						<select id="alternate_pickup_time_packed">
							<option value="8:30-11:00_am">8:30 - 11:00 am</option>
							<option value="11:00-1:00_pm">11:00 - 1:00 pm</option>
							<option value="1:00-4:00_pm">1:00 - 4:00 pm</option>
						</select>
						<br/>
						<input id="checkbox1" type="checkbox" name="sameaddress" ><label>Same as Delivery Address</label>
						<br/>
						<label>Pickup Address*: </label> <input id="pickup_address_packed" type="text" required/> <input id="apt_unit_pickup_packed" type="text" required/>
						<p>Do you live in a walk-up or elevator building?* Whats This?</p>
						<select id="apartment_level_packed" class="apartment_level">
							<option value="Neither">Neither</option>
							<option value="Elevator">Elevator</option>
							<option value="Stairs">Stairs</option>
						</select>
						<br/>

						<button type="submit" id="continue_pickup_packed_boxes" class="btn btn-secondary">CONTINUE</button>
					</form>
				</div>
			</div>
			<br/>
			<div class="row justify-content-md-center">
				<div id="delivery_packed_boxes" class="col-sm-12 col-md-10 check-area">
					<form id="delivery_packed_boxes_submit">
						<h5>Delivery of your Stored Items :</h5>
						<label>Please specify where you would like us to delivery your items from storage :</label>
						<br/>
						<select id="selectaddress">
							<option selected value="selectadd">Add New Address</option>
							<option value="Delivery_Address">Delivery Address</option>
							<option value="Pickup_Address">Pickup Address</option>
						</select>
						<br/>
						<div id="delivery_packed_address">
							<label>Delivery Address*: </label> <input id="delivery_address_packed" type="text"/> <input id="apt_unit_delivery_packed" type="text" required/>
							<p>Do you live in a walk-up or elevator building?* Whats This?</p>
							<select id="apartment_level_packed_delivery" class="apartment_level">
								<option value="Neither">Neither</option>
								<option value="Elevator">Elevator</option>
								<option value="Stairs">Stairs</option>
							</select>
						</div>
						<button type="submit" id="continue_delivery_packed_boxes" class="btn btn-secondary">CONTINUE</button>
					</form>
				</div>
			</div>
			<br/>
			<div class="row justify-content-md-center">
				<div id="pick_up_boxes" class="col-sm-12 col-md-10 check-area">
					
						<h5>Pick up your Empty ReBow™ Boxes : </h5>
						<label>Pickup Date* : </label>
						<span id="pickup_date"></span>
						<p>*If this date does not work, please adjust your delivery date.</p>
						<label>Preferred Pickup Time* : </label>
						<select id="preferred_pickup_time">
							<option value="8:30-11:00_am">8:30 - 11:00 am</option>
							<option value="11:00-1:00_pm">11:00 - 1:00 pm</option>
							<option value="1:00-4:00_pm">1:00 - 4:00 pm</option>
						</select>
						<label>Alternate Pickup Time* :  : </label>
						<select id="alternate_pickup_time">
							<option value="8:30-11:00_am">8:30 - 11:00 am</option>
							<option value="11:00-1:00_pm">11:00 - 1:00 pm</option>
							<option value="1:00-4:00_pm">1:00 - 4:00 pm</option>
						</select>
						<br/>
						<input id="checkbox2" type="checkbox" name="sameaddress"><label>Same as Delivery Addrss</label>
						<br/>
						<label>Pickup Address*: </label> <input id="pickup_address" type="text"/> <input id="apt_unit_pickup" type="text" required/>
						<p>Do you live in a walk-up or elevator building?* Whats This?</p>
						<select id="apartment_level_pickup" class="apartment_level">
							<option value="Neither">Neither</option>
							<option value="Elevator">Elevator</option>
							<option value="Stairs">Stairs</option>
						</select>
						<br/>

						<button type="submit" id="continue_pickup" class="btn btn-secondary">NEXT</button>
					
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
		    						$price = get_rental_price($product_id,$rental_period,$duration);
		    					}else{
		    						$rental_period = 1;
		    						$duration = 1;
		    						$period_data= 'Months';
		    						$price = get_storage_price($product_id,$rental_period,$duration);
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
		    						<li id="addedboxesfi</span></li>eld"><span id="addedboxno"><?php echo $session_data->added_box_count." Added Boxes "?>  </span>: <span id="addedboxprice"><?php 
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
		    				<label>Delivery - Curb</label>: <span id="delivery_cost">Free</span>
		    				<br/>
		    				<label>Pickup - Stairs</label>: <span id="pickup_cost"><?php echo $pickup_stairs; ?></span>
							<br/>	
		    				<label>Sales Tax</label>:  <span id="sales_tax"><?php echo $sales_tax; ?></span>
							<br/>
							<br/>
		    				<label>Total</label>:  <span id="total_price"><?php echo ($price+$sales_tax+$new_addedboxprice+$pickup_stairs); ?></span>
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
			jQuery(document).ready(function() {

				var hostname = location.hostname;
				var period  = jQuery('#period').val();

				jQuery("#pick_up_packed_boxes").hide();
				jQuery("#delivery_packed_boxes").hide();
				jQuery("#pick_up_boxes").hide();
				
				jQuery('#checkbox1').change(function() {
			        if(this.checked) {
			        	//alert('in');
			           var  delivery_address = jQuery('#delivery_address').val();
			           //alert(delivery_address);
			           var  apt_unit_delivery = jQuery('#apt_unit_delivery').val();
			           //alert(apt_unit_delivery);
			           jQuery('#pickup_address_packed').val(delivery_address);

			           jQuery('#apt_unit_pickup_packed').val(apt_unit_delivery);

			        }
			             
			    });
			    jQuery('#checkbox2').change(function() {
			        if(this.checked) {
			        	//alert('in');
			           var  delivery_address = jQuery('#delivery_address').val();
			           //alert(delivery_address);
			           var  apt_unit_delivery = jQuery('#apt_unit_delivery').val();
			           //alert(apt_unit_delivery);
			           jQuery('#pickup_address').val(delivery_address);

			           jQuery('#apt_unit_pickup').val(apt_unit_delivery);

			        }
			             
			    });

				jQuery("#pick_up_boxes").hide();

				
				jQuery('#continue_pickup_packed_boxes').click(function(){
					jQuery("#delivery_packed_boxes").show();
					jQuery("#continue_delivery").hide();

				});

				jQuery('#continue_delivery_packed_boxes').click(function(){
					jQuery("#pick_up_boxes").show();
					jQuery("#continue_pickup_packed_boxes").hide();

				});
				jQuery("#add_box_count").change(function() {
			        //alert("Changed");
			       	var add_box_count = jQuery("#add_box_count").val();

			       	var res = add_box_count.split("_");
			       	var res1 = Number(res[0]); 

			       	var period = jQuery('#period').val();

			       	var selectperiod1 = jQuery('#selectperiod1').val();
			       	var res = selectperiod1.split("_");
			       	var res2 = Number(res[0]); 

			       	//var period = jQuery('#period').val();
			       	//alert(period);
			       	var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());
			       	if(period=='RENTAL'){
				       	
				       	var price1 = Number(res1*rental_cost_per_week*res2);
			       	}else{
			       		var per_box_price=16.25;
				       	//var period1=1;
				       	var price1 = Number(res1*storage_cost_per_month*res2);
			       	}
			       	//var per_box_price=3;
			       	//alert(res1);
			       	
			       	//alert(price1);
			       	jQuery('#price1').text(price1);

			       	//alert(box_count);
			       	
			    });
			    jQuery("#add_more_boxes785").click(function() {
					//alert('clicked');
					var add_box_count = jQuery("#add_box_count").val();

					var res = add_box_count.split("_");
			       	var added_box_count = Number(res[0]);
			       	//var per_box_price=3;
			       	//alert(res1);

			       	var selectedpackage = jQuery("#selectpackage").val();

			       	var selectperiod1 = jQuery("#selectperiod1").val();

			       	var res1 = selectedpackage.split("_");

			       	var package_id = res1.pop();

			       	jQuery('#new_product_id').val(package_id);
			       	//alert(package_id);
			       	var selected_package=res1.join("_");

			       	var new_addedboxprice = jQuery('#new_addedboxprice').val();

			       	var res2 = selectperiod1.split("_");
			       	var period1 = Number(res2[0]);
			       	//alert(period1);

			       	var period = jQuery('#period').val();
			       	//alert(period);
			       	var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());

			       	var tax_rates = Number(jQuery('#tax_rates').val());
			       	//alert(storage_cost_per_month);
			       	/*if(period=='RENTAL'){
			       		//var period1 =2;
			       		//per_box_price=3;
			       		var price1 = res1*rental_cost_per_week*period1;
			       	}else{
			       		//var period1 =1;
			       		//per_box_price=16.25;
			       		var price1 = res1*storage_cost_per_month*period1;
			       	}*/
			       	
			       	
			       	jQuery("#addedboxesfield").show();

			       	var apartment_level_delivery = jQuery('#apartment_level_delivery').val();
					//alert(apartment_level_delivery);

					var apartment_level_packed = jQuery('#apartment_level_packed').val();

					//alert(apartment_level_packed);

					var apartment_level_packed_delivery = jQuery('#apartment_level_packed').val();

					var apartment_level_pickup = jQuery('#apartment_level_pickup').val();
			       	
			       	var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&added_box_count="+added_box_count+"&period="+period+"&apartment_level_delivery="+apartment_level_delivery+"&apartment_level_packed="+apartment_level_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&apartment_level_pickup="+apartment_level_pickup;
					jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    //alert(result);
						    console.log(result);
						    //alert("New Package Added");

						    var JSONobj = JSON.parse(result);

						    //var sales_tax = 17.6;
						    jQuery("#product_name").text(JSONobj.product_name+" / "+JSONobj.box_count+" Boxes");

						    jQuery("#nestable_dollies_count").text(JSONobj.nestable_dollies_count+" Nestable Dollies");

						    jQuery("#labels_count").text(JSONobj.labels_count+" Labels");

						    jQuery("#zipties_count").text(JSONobj.zipties_count+" Zipties");

						    jQuery("#mainprice").text(JSONobj.price);

						    jQuery("#subtotal").text(JSONobj.subtotal);

						    jQuery("#sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxno").text(JSONobj.added_box_count+" Added Boxes");


						    jQuery("#total_price").text(JSONobj.total_price);

						    jQuery("#pickup_cost").text(JSONobj.pickup_cost);

						    jQuery("#delivery_cost").text(JSONobj.delivery_cost);


						}
					});
					
				});


				jQuery("#selectpackage").change(function() {
			        //alert("Changed");
			       	var selectedpackage = jQuery("#selectpackage").val();

			       	var selectperiod1 = jQuery("#selectperiod1").val();

			       	var res1 = selectedpackage.split("_");

			       	var package_id = res1.pop();

			       	jQuery('#new_product_id').val(package_id);
			       	//alert(package_id);
			       	var selected_package=res1.join("_");

			       	var new_addedboxprice = jQuery('#new_addedboxprice').val();

			       	var added_box_count_string = jQuery('#addedboxno').text();
			       	//alert(added_box_count_string);

			       	var added_box_count_array =  added_box_count_string.split(" ");

			       	var added_box_count = added_box_count_array[0];

			       	var period = jQuery('#period').val();
			       	//alert(period);
			       	var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());

			       	var tax_rates = Number(jQuery('#tax_rates').val());


			       	var apartment_level_delivery = jQuery('#apartment_level_delivery').val();
					//alert(apartment_level_delivery);

					var apartment_level_packed = jQuery('#apartment_level_packed').val();

					//alert(apartment_level_packed);

					var apartment_level_packed_delivery = jQuery('#apartment_level_packed').val();

					var apartment_level_pickup = jQuery('#apartment_level_pickup').val();
			       	//alert(selected_package);
			       	//alert(box_count);
			       	//var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice;
			       	var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&period="+period+"&added_box_count="+added_box_count+"&apartment_level_delivery="+apartment_level_delivery+"&apartment_level_packed="+apartment_level_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&apartment_level_pickup="+apartment_level_pickup;
			       	//alert(datastring);
			       	jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    //alert(result);
						   	console.log(result);

						   	var JSONobj = JSON.parse(result);

						    //var sales_tax = 17.6;
						    jQuery("#product_name").text(JSONobj.product_name+" / "+JSONobj.box_count+" Boxes");

						    jQuery("#nestable_dollies_count").text(JSONobj.nestable_dollies_count+" Nestable Dollies");

						    jQuery("#labels_count").text(JSONobj.labels_count+" Labels");

						    jQuery("#zipties_count").text(JSONobj.zipties_count+" Zipties");

						    jQuery("#mainprice").text(JSONobj.price);

						    jQuery("#subtotal").text(JSONobj.subtotal);

						    jQuery("#sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxno").text(JSONobj.added_box_count+" Added Boxes");

						    jQuery("#total_price").text(JSONobj.total_price);

						    jQuery("#pickup_cost").text(JSONobj.pickup_cost);

						    jQuery("#delivery_cost").text(JSONobj.delivery_cost);
						}
					});
			       	
			    });
			    jQuery("#selectperiod1").change(function() {
			    	var selectedpackage = jQuery("#selectpackage").val();

			       	var selectperiod1 = jQuery("#selectperiod1").val();
			       	//alert(selectperiod1);
			       	var period = jQuery("#selectperiod1 option:selected").text();


			       	//alert(period);
			       	jQuery('#new_period').text(period);

			       	var res1 = selectedpackage.split("_");

			       	var package_id = res1.pop();

			       	var new_addedboxprice = jQuery('#new_addedboxprice').val();

			       	var added_box_count_string = jQuery('#addedboxno').text();
			       	//alert(added_box_count_string);

			       	var added_box_count_array =  added_box_count_string.split(" ");

			       	var added_box_count = added_box_count_array[0];
			       //	alert(package_id);
			       	var selected_package=res1.join("_");

			       	var period = jQuery('#period').val();
			       	//alert(period);
			       	var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());

			       	var tax_rates = Number(jQuery('#tax_rates').val());


			       	var apartment_level_delivery = jQuery('#apartment_level_delivery').val();
					//alert(apartment_level_delivery);

					var apartment_level_packed = jQuery('#apartment_level_packed').val();

					//alert(apartment_level_packed);

					var apartment_level_packed_delivery = jQuery('#apartment_level_packed').val();

					var apartment_level_pickup = jQuery('#apartment_level_pickup').val();
			       	//alert(selected_package);
			       	//alert(box_count);
			       	//var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice;

			       	var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&period="+period+"&added_box_count="+added_box_count+"&apartment_level_delivery="+apartment_level_delivery+"&apartment_level_packed="+apartment_level_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&apartment_level_pickup="+apartment_level_pickup;

			       	//alert(datastring);
			       	jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    //alert(result);
						   	console.log(result);

						   	var JSONobj = JSON.parse(result);

						    //var sales_tax = 17.6;
						    jQuery("#product_name").text(JSONobj.product_name+" / "+JSONobj.box_count+" Boxes");

						    jQuery("#nestable_dollies_count").text(JSONobj.nestable_dollies_count+" Nestable Dollies");

						    jQuery("#labels_count").text(JSONobj.labels_count+" Labels");

						    jQuery("#zipties_count").text(JSONobj.zipties_count+" Zipties");

						    jQuery("#mainprice").text(JSONobj.price);

						    jQuery("#subtotal").text(JSONobj.subtotal);

						    jQuery("#sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxno").text(JSONobj.added_box_count+" Added Boxes");

						    jQuery("#total_price").text(JSONobj.total_price);

						    jQuery("#pickup_cost").text(JSONobj.pickup_cost);

						    jQuery("#delivery_cost").text(JSONobj.delivery_cost);
						}
					});
				});

			    jQuery("#delivery_box_submit").submit(function(event) {
			    	
			    	event.preventDefault();
					alert('form submitted');
					jQuery('#continue_delivery').hide();
					if(period=='RENTAL'){
						jQuery("#pick_up_boxes").show();
					}else{
						jQuery("#pick_up_packed_boxes").show();
					}
					var delivery_date = jQuery('#delivery_date').val();

					var preferred_delivery_time = jQuery('#preferred_delivery_time').val();

					var alternate_delivery_time = jQuery('#alternate_delivery_time').val();

					var delivery_address = jQuery('#delivery_address').text();

					var apt_unit_delivery = jQuery('#apt_unit_delivery').text();

					//alert(delivery_date);

					var datastring = "ajax_request=delivery_boxes_data&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&period="+period;

					jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    alert(result);
						    var JSONobj = JSON.parse(result);
						    console.log(JSONobj);
						    //alert()
						    if(period=='RENTAL'){
						    	jQuery("#pickup_date").text(JSONobj.pickup_date);
						    }else{
						    	jQuery("#pickup_date_packed").text(JSONobj.pickup_date);
						    }
						    //jQuery("#pickup_date").text(JSONobj.pickup_date);


						    //alert("New Package Added");
						}
					});

				});

				jQuery( "#pick_up_packed_boxes_submit" ).submit(function(event) {

					event.preventDefault();
					//alert('form submitted');
					jQuery('#continue_pickup_packed_boxes').hide();
					if(period=='RENTAL'){
						//jQuery("#pick_up_boxes").show();
					}else{
						jQuery("#delivery_packed_boxes").show();
					}
					var pickup_date_packed = jQuery('#pickup_date_packed').val();
					
				});
				jQuery( "#delivery_packed_boxes_submit" ).submit(function(event) {

					event.preventDefault();
					//alert('form submitted');
					jQuery('#continue_delivery_packed_boxes').hide();
					if(period=='RENTAL'){
						//jQuery("#pick_up_boxes").show();
					}else{
						jQuery("#pick_up_boxes").show();
					}
					var pickup_date_packed = jQuery('#pickup_date_packed').val();
					//alert(pickup_date_packed);

					var preferred_pickup_time_packed = jQuery('#preferred_pickup_time_packed').val();
					//alert(preferred_pickup_time_packed);
					var alternate_pickup_time_packed = jQuery('#alternate_pickup_time_packed').val();

					var pickup_address_packed = jQuery('#pickup_address_packed').text();

					var apt_unit_pickup_packed = jQuery('#apt_unit_pickup_packed').text();

					var apartment_level_packed = jQuery('#apartment_level_packed').text();
					//alert(delivery_date);

					/*var datastring = "ajax_request=delivery_boxes_data&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit="+apt_unit+"&period="+period;

					jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    alert(result);
						    var JSONobj = JSON.parse(result);
						    console.log(JSONobj);
						    
						}
					});*/

				});

				jQuery('.apartment_level').change(function(){

					var selectedpackage = jQuery("#selectpackage").val();

			       	var selectperiod1 = jQuery("#selectperiod1").val();
			       	//alert(selectperiod1);
			       	//var period = jQuery("#selectperiod1 option:selected").text();

			       	var added_box_count_string = jQuery('#addedboxno').text();
			       	//alert(added_box_count_string);

			       	var added_box_count_array =  added_box_count_string.split(" ");

			       	var added_box_count = added_box_count_array[0];
			       	//alert(period);
			       	jQuery('#new_period').text(period);

			       	var res1 = selectedpackage.split("_");

			       	var package_id = res1.pop();

			       	var new_addedboxprice = jQuery('#new_addedboxprice').val();
			       //	alert(package_id);
			       	var selected_package=res1.join("_");

			       	var period = jQuery('#period').val();

					var apartment_level_delivery = jQuery('#apartment_level_delivery').val();
					//alert(apartment_level_delivery);

					var apartment_level_packed = jQuery('#apartment_level_packed').val();

					//alert(apartment_level_packed);

					var apartment_level_packed_delivery = jQuery('#apartment_level_packed').val();

					var apartment_level_pickup = jQuery('#apartment_level_pickup').val();

					var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&period="+period+"&added_box_count="+added_box_count+"&apartment_level_delivery="+apartment_level_delivery+"&apartment_level_packed="+apartment_level_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&apartment_level_pickup="+apartment_level_pickup;
					//alert(datastring);
					jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    //alert(result);
						    console.log(result);
						    //alert("New Package Added");

						    var JSONobj = JSON.parse(result);

						    //var sales_tax = 17.6;
						    jQuery("#product_name").text(JSONobj.product_name+" / "+JSONobj.box_count+" Boxes");

						    jQuery("#nestable_dollies_count").text(JSONobj.nestable_dollies_count+" Nestable Dollies");

						    jQuery("#labels_count").text(JSONobj.labels_count+" Labels");

						    jQuery("#zipties_count").text(JSONobj.zipties_count+" Zipties");

						    jQuery("#mainprice").text(JSONobj.price);

						    jQuery("#subtotal").text(JSONobj.subtotal);

						    jQuery("#sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_sales_tax").text(JSONobj.sales_tax);

						    jQuery("#new_addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxprice").text(JSONobj.new_addedboxprice);

						    jQuery("#addedboxno").text(JSONobj.added_box_count+" Added Boxes");


						    jQuery("#total_price").text(JSONobj.total_price);

						    jQuery("#pickup_cost").text(JSONobj.pickup_cost);

						    jQuery("#delivery_cost").text(JSONobj.delivery_cost);

						}
					});


				});

				jQuery("#continue_pickup").click(function(event) {
					
					var datastring = "";
					var period = jQuery('#period').val(); 

						/*Form 1*/
						var delivery_date = jQuery('#delivery_date').val();

						var preferred_delivery_time = jQuery('#preferred_delivery_time').val();

						var alternate_delivery_time = jQuery('#alternate_delivery_time').val();

						var delivery_address = jQuery('#delivery_address').val();

						var apt_unit_delivery = jQuery('#apt_unit_delivery').val();

						var apartment_level_delivery = jQuery('#apartment_level_delivery').val();

						/*END Form 1*/

						/*Form 4*/

						var pickup_date = jQuery('#pickup_date').text();

						var preferred_pickup_time = jQuery('#preferred_pickup_time').val();

						var alternate_pickup_time = jQuery('#alternate_pickup_time').val();

						var pickup_address = jQuery('#pickup_address').val();

						var apt_unit_pickup = jQuery('#apt_unit_pickup').val();

						var apartment_level_pickup = jQuery('#apartment_level_pickup').val();


						var product_id = jQuery('#new_product_id').val();
						alert("product_id "+product_id);

						var selectedpackage = jQuery("#selectpackage").val();

				       	var selectperiod1 = jQuery("#selectperiod1").val();

				       	var added_box_count = jQuery('#added_box_count').val();

				       	var addedboxprice = Number(jQuery('#addedboxprice').text());

				       	var subtotal = Number(jQuery('#subtotal').text());

				       	var mainprice = Number(jQuery('#mainprice').text());

						var sales_tax = Number(jQuery('#sales_tax').text());

						var total_price = Number(jQuery('#total_price').text());

						var delivery_cost = Number(jQuery('#delivery_cost').text()); 

						var pickup_cost = Number(jQuery('#pickup_cost').text());


					

					if(period=="STORAGE"){

						/*Form 2*/
						var pickup_date_packed = jQuery('#pickup_date_packed').val();

						var preferred_pickup_time_packed = jQuery('#preferred_pickup_time_packed').val();
						
						var alternate_pickup_time_packed = jQuery('#alternate_pickup_time_packed').val();

						var pickup_address_packed = jQuery('#pickup_address_packed').val();

						var apt_unit_pickup_packed = jQuery('#apt_unit_pickup_packed').val();

						var apartment_level_packed = jQuery('#apartment_level_packed').val();

						/*END Form 2*/

						/*Form 3*/
						var selectaddress = jQuery('#selectaddress').val();

						var delivery_address_packed = jQuery('#delivery_address_packed').val();

						var apt_unit_delivery_packed = jQuery('#apt_unit_delivery_packed').val();

						var apartment_level_packed_delivery = jQuery('#apartment_level_packed_delivery').val();

						/*END Form 3*/

						datastring = "ajax_request=goto_payments_page&period="+period+"&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&apartment_level_delivery="+apartment_level_delivery+"&pickup_date="+pickup_date+"&preferred_pickup_time="+preferred_pickup_time+"&alternate_pickup_time="+alternate_pickup_time+"&pickup_address="+pickup_address+"&apt_unit_pickup="+apt_unit_pickup+"&apartment_level_pickup="+apartment_level_pickup+"&pickup_date_packed="+pickup_date_packed+"&preferred_pickup_time_packed="+preferred_pickup_time_packed+"&alternate_pickup_time_packed="+alternate_pickup_time_packed+"&pickup_address_packed="+pickup_address_packed+"&apt_unit_pickup_packed="+apt_unit_pickup_packed+"&apartment_level_packed="+apartment_level_packed+"&selectaddress="+selectaddress+"&delivery_address_packed="+delivery_address_packed+"&apt_unit_delivery_packed="+apt_unit_delivery_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&product_id="+product_id+"&selectedpackage="+selectedpackage+"&selectperiod1="+selectperiod1+"&added_box_count="+added_box_count+"&addedboxprice="+addedboxprice+"&subtotal="+subtotal+"&mainprice="+mainprice+"&sales_tax="+sales_tax+"&total_price="+total_price+"&delivery_cost="+delivery_cost+"&pickup_cost="+pickup_cost;
					}else{
						datastring = "ajax_request=goto_payments_page&period="+period+"&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&apartment_level_delivery="+apartment_level_delivery+"&pickup_date="+pickup_date+"&preferred_pickup_time="+preferred_pickup_time+"&alternate_pickup_time="+alternate_pickup_time+"&pickup_address="+pickup_address+"&apt_unit_pickup="+apt_unit_pickup+"&apartment_level_pickup="+apartment_level_pickup+"&product_id="+product_id+"&selectedpackage="+selectedpackage+"&selectperiod1="+selectperiod1+"&added_box_count="+added_box_count+"&addedboxprice="+addedboxprice+"&subtotal="+subtotal+"&mainprice="+mainprice+"&sales_tax="+sales_tax+"&total_price="+total_price+"&delivery_cost="+delivery_cost+"&pickup_cost="+pickup_cost;
					}
					//var datastring2 = datastring.concat(datastring1);
					
					//var period = jQuery('#period').val();

				    //alert(datastring);
				    //console.log(datastring);
					jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);

						    //alert(result);
						    jQuery(location).attr('href', 'http://'+hostname+'/rebow/personal-information');
						}
					});


				});
			});
		</script>
	</body>
</html>


