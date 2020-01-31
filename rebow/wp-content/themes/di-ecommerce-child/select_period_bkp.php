<?php /* Template Name: selectperiod*/ ?>

<html lang="en">
	<body>
		<?php 
		require_once('session_handler.php');
		$session_data = get_rebow_session();
		print_r($session_data);
		get_header(); ?>
			
		<div class="container-fluid">
			
			<div class="container">
			    <div class="row ">
			      <div class="col-md-6 mb-3">
			        
			        <?php
			       	//echo "Session_order_values: ".
			       	
			        $data1 = $session_data->order_values;
			        if(isset($session_data->added_box_count)){
			        	$added_box_count=$session_data->added_box_count;
			        }else{
			        	$added_box_count = 0;
			        }
			        //$zip_current = $session_data->zip_current;
			        $array1 = explode("_",$data1);
			        $product_type = $array1[0];
			        //echo "product_type: ".$product_type;
			        $period=strtoupper($array1[1]);
			        
			        $product_id = $array1[2];
			       
			        $breadcrumb =  $array1[0]." ".strtoupper($array1[1]);
			        if($period=='RENTAL'){
			        	$array1 = array(2=>2,3=>2,4=>2);
			       	}else{
			       		$array1 = array(1=>1,2=>1,3=>1);
			       	}

			       	$rental_cost_per_week = get_base_pricing('Rental_cost_per_1_box_per_1_week');

			       	$storage_cost_per_month = get_base_pricing('Monthly_storage_cost_per_box');

			       	$tax_rates = get_tax_rate();
			       // get_rental_price();

			        echo "<p>PRICING / $breadcrumb /  $period PERIOD</p>";
			        echo '<input type="hidden" id="rental_cost_per_week" value='.$rental_cost_per_week .'>';
			        echo '<input type="hidden" id="storage_cost_per_month" value='.$storage_cost_per_month .'>';
			        echo '<input type="hidden" id="tax_rates" value='.$tax_rates .'>';
			        ?>
			      </div>
			    </div>
			    <div class="row justify-content-md-center check-area">
			    	<div class="col-md-6 mb-3">
			    		<div class="system-content text-center">
			    			<label><h6>Select <?php echo $period; ?> Period:</h6></label>
			    			<br/>
			    			<?php echo '<input id="period" type="hidden" value="'.$period.'">'; ?>
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

			    					echo "<option value=$dropdown_values1> $dropdown_values</option>";
			    				}
			    				?>
			    				
			    			</select>
			    			<br/>
			    			<br/>
			    			<button id="next_order_page" type="submit" class="btn btn-secondary">NEXT</button>
			    		</div>
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

		    					<li><span id="new_period"><?php echo $rental_period." ".$period_data;?></span>  : <span id="mainprice"><?php echo $price;?></span></li>
		    					<?php 
		    						if($period=='RENTAL'){

		    							$box_count=0;$period_value=2;
		    						}else{
		    							$box_count=0;$period_value=1;
		    						}
		    					?>
		    					<?php if(empty($added_box_count)){?>
		    						<li id="addedboxesfield" class="hide"><span id="addedboxno"><?php echo "4 Added Boxes "?>  </span>: <span id="addedboxprice"><?php 
		    						if($period=='RENTAL'){
		    							echo $new_addedboxprice=($box_count*$rental_cost_per_week*$period_value);

		    						}else{
		    							echo $new_addedboxprice=($box_count*$storage_cost_per_month*$period_value);
		    						}
		    						?>
		    					<?php }else{?>
		    						<li id="addedboxesfi</span></li>eld"><span id="addedboxno"><?php echo $added_box_count." Added Boxes "?>  </span>: <span id="addedboxprice"><?php 
		    						if($period=='RENTAL'){
		    							echo $new_addedboxprice=($added_box_count*$rental_cost_per_week*$period_value);

		    						}else{
		    							echo $new_addedboxprice=($added_box_count*$storage_cost_per_month*$period_value);
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
		    				<label>Subtotal</label>: <span id="subtotal"><?php echo $price;?></span>
		    				<br/>
		    				<div id="deliverycost"><label id="deliveryinfo">Delivery - Curb</label>: <span id="delivery_cost">Free</span></div>
		    				<br/>
		    				<div id="pickupcost"><label id="pickupinfo">Pickup - Stairs</label>: <span id="pickup_cost"><?php echo $pickup_stairs; ?></span></div>
							<br/>	
		    				<label>Sales Tax</label>:  <span id="sales_tax"><?php echo $sales_tax; ?></span>
							<br/>
							<br/>
		    				<label>Total</label>:  <span id="total_price"><?php echo ($price+$sales_tax+$pickup_stairs); ?></span>
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
		</div>

		<?php get_footer(); ?>
		<script>
			jQuery(document).ready(function() {
				var hostname = location.hostname;
				//jQuery("#addedboxesfield").hide();
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
			       		//var per_box_price=16.25;
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
			       	jQuery('#added_box_count').val(added_box_count);

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
			       	
			       	///sales_tax = 17.6;
			       	
			       	//alert(price1);
			       	jQuery("#addedboxesfield").show();
			       	//jQuery('#addedboxno').text(res1+" Added Boxes");
			       	
			       	//jQuery('#addedboxprice').text(price1);

			       	//var mainprice = jQuery('#mainprice').text();
			       	//alert(mainprice);
			       	//jQuery("#subtotal").text(Number(mainprice)+Number(price1));

			       	//jQuery("#total_price").text(Number(mainprice)+Number(price1)+Number(sales_tax));
			       	var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&added_box_count="+added_box_count+"&rental_cost_per_week="+rental_cost_per_week+"&storage_cost_per_month="+storage_cost_per_month+"&period="+period+"&tax_rates="+tax_rates;
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


						}
					});
					
				});

				jQuery("#next_order_page").click(function() {
					var new_product_id = jQuery('#new_product_id').val();

					var selectedpackage = jQuery("#selectpackage").val();

			       	var selectperiod1 = jQuery("#selectperiod1").val();

			       	var added_box_count = jQuery('#added_box_count').val();

			       	var addedboxprice = Number(jQuery('#addedboxprice').text());

			       	var subtotal = Number(jQuery('#subtotal').text());

			       	var mainprice = Number(jQuery('#mainprice').text());

					var sales_tax = Number(jQuery('#sales_tax').text());

					var total_price = Number(jQuery('#total_price').text());

					var period = jQuery('#period').val();



					//var new_subtotal = jQuery('#new_subtotal').val();

					//var new_total_price = jQuery('#new_total_price').val();

					
			       	//ar res1 = selectedpackage.split("_");

			       	//var package_id = res1.pop();

			       	//jQuery('#new_product_id').val(package_id);
			       	//alert(package_id);
			       	//var selected_package=res1.join("_");

			       	//var new_addedboxprice = jQuery('#new_addedboxprice').val();

			       	
			       	//alert(period);
			       	//var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	//var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());

			       	//var tax_rates = Number(jQuery('#tax_rates').val());

					var datastring = "ajax_request=gotonextpage&product_id="+new_product_id+"&selectperiod1="+selectperiod1+"&added_box_count="+added_box_count+"&addedboxprice="+addedboxprice+"&subtotal="+subtotal+"&sales_tax="+sales_tax+"&period="+period+"&total_price="+total_price+"&selectedpackage="+selectedpackage+"&mainprice="+mainprice;

					jQuery.ajax({
						url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    //alert(result);
						    //console.log(result);
						    //alert("New Package Added");
						    jQuery(location).attr('href', 'http://'+hostname+'/rebow/delivery_pickup');
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

			       	var period = jQuery('#period').val();
			       	//alert(period);
			       	var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());

			       	var tax_rates = Number(jQuery('#tax_rates').val());
			       	//alert(selected_package);
			       	//alert(box_count);
			       	//var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice;
			       	var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&rental_cost_per_week="+rental_cost_per_week+"&storage_cost_per_month="+storage_cost_per_month+"&period="+period+"&added_box_count="+added_box_count+"&tax_rates="+tax_rates;
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
						}
					});
			       	
			    });

			    jQuery("#selectperiod1").change(function() {
			    	var selectedpackage = jQuery("#selectpackage").val();

			       	var selectperiod1 = jQuery("#selectperiod1").val();
			       	alert(selectperiod1);
			       	var period = jQuery("#selectperiod1 option:selected").text();


			       	alert(period);
			       	jQuery('#new_period').text(period);

			       	var res1 = selectedpackage.split("_");

			       	var package_id = res1.pop();

			       	var new_addedboxprice = jQuery('#new_addedboxprice').val();
			       //	alert(package_id);
			       	var selected_package=res1.join("_");

			       	var period = jQuery('#period').val();
			       	//alert(period);
			       	var rental_cost_per_week = Number(jQuery('#rental_cost_per_week').val());
			       	//alert(rental_cost_per_week);
			       	var storage_cost_per_month = Number(jQuery('#storage_cost_per_month').val());

			       	var tax_rates = Number(jQuery('#tax_rates').val());
			       	//alert(selected_package);
			       	//alert(box_count);
			       	//var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice;

			       	var datastring = "ajax_request=show_upadated_package_info&product_id="+package_id+"&product_name="+selected_package+"&selectperiod1="+selectperiod1+"&new_addedboxprice="+new_addedboxprice+"&rental_cost_per_week="+rental_cost_per_week+"&storage_cost_per_month="+storage_cost_per_month+"&period="+period+"&added_box_count="+added_box_count+"&tax_rates="+tax_rates;

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
						}
					});
				});
		    });
		</script>
	</body>
</html>