<?php /* Template Name: payment_information1*/ ?>
<?php require_once("user_check_login.php");?>
<?php require_once("db_config.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php get_header();
		$user_id = wp_get_current_user()->id;?>
		<?php 
			function get_payments_data1($user_id){
				$query = "SELECT * FROM payments where user_id=$user_id and active=1";
				$res = mysql_query($query);
				$row = mysql_fetch_assoc($res);
				return $row;
			}
			$months_array = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');

			//$years_array = array();
			$cur_year = date('Y');
			for($i=0;$i<=20;$i++){
				$years_array[$cur_year+$i] = $cur_year+$i;

			}
			//print_r($months_array);
			//print_r($years_array);	
			?>
			<?php $payments_data = get_payments_data1($user_id);?>
		<!-- FAQ heading -->
		<section class="faq-header">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col text-center">
						<h1>Welcome <?php echo $display_name;?></h1>
					</div>
				</div>
			</div>	
		</section>

		<section>
		  	<div class="container">
			    <div class="row">
				    <ul class="account">
				        <li ><a href="/rebow/my-orders/">My Orders</a></li>
				        <li><a href="/rebow/my-information/">My Information</a></li>
				        <li class="selected"><a href="/rebow/payment-information/">Payment info</a></li>
				        <li><a href="/rebow/support/">Support</a></li>
				    </ul>
			      	<div class="rhs-account mb-5 view-order">
				        <div class="row justify-content-left">
				          <div class="col-sm-12 mb-2">
				            <!-- Start order bredcrumb-->
				            <div class="row">	
				              <div class="col-sm-12">
				                <ul class="order-breadcrumb">
				                  <li><a href="">PAYMENT INFO</a></li>
				                </ul>
				              </div>
				            </div>
				          </div>
				        </div>
				        <!-- Order Details -->
				        <div class="row">
				          <div class="blue-bg w mx-3 py-2 pl-4">
				            <div class="row">
				              <div class="col-sm-12 o-summary">
				                <div class="edit float-right pr-3">
				                  <em><a href="#javascript;" data-toggle="modal" data-target="#myModal2">ADD NEW PAYMENT</a></em>
				                </div>
				              </div>
				            </div>
				          </div>
				        </div>
				        <div class="row">
				          <div class="col-sm-12 col-md-5">
				            <div class="grey-bg pay-inf">
				              <div class="row">
				                <div class="col-sm-3">
				                  <img class="m-c" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/mastercard-black.png" alt="">
				                </div>
				                <div class="col-sm-9">
				                  <div class="crd-hld">
				                    <label for=""><?php echo $payments_data['First_Name']." ".$payments_data['Last_Name'];?></label><br/>
				                    <label for="">Ending in <?php echo substr($payments_data['Card_Number'],-4);?></label>
				                    <label for=""><strong>Ex</strong> : <?php echo $payments_data['Expiry_month']."/".$payments_data['Expiry_year'];?></label>
				                  </div>
				                  <div class="blng-adr">
				                    <strong>Billing Address :</strong>
				                    <label for=""><?php echo $payments_data['billing_address'];?></label>
				                    <label for="">Austin, TX 78749</label>
				                  </div>
				                  <ul class="edit-removed">
				                    <li><a href="#javascript;" data-toggle="modal" data-target="#myModal1">Edit</a></li>
				                    <li><a id="remove_payments" href="javascript:;">Remove</a></li>
				                  </ul>
				                </div>
				              </div>
				            </div>
				          </div>
				        </div>
				      </div>
			    	
			   </div>
			</div>
		</section>

		<!-- Modal -->
		<div id="myModal1" class="modal fade" role="dialog1">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        
		        <h4 class="modal-title">Update Payment Info</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>
		      <div class="modal-body">
		      	<form id="FormUpdate">
		      		<div class="form-group">
				       	<label>Card Number*</label>
				       	<input id="card_number" type="text" data-stripe="number" value="<?php echo "*******".substr($payments_data['Card_Number'],-4)?>"/>
				       	<br/>
				    </div>
				    <div class="form-group">
				       	<label>CCV*</label>
						<input id="ccv" type="text" value="***"/>
						<br/>
					</div>
					<div class="form-group">
						<label>Expiration Date*</label>
						<br/>
						<select id="month">
							<?php foreach($months_array as $key=>$value){
								if($key==$payments_data['Expiry_month']){
									echo "<option selected value=$key>$value</option>";
								}else{
									echo "<option value=$key>$value</option>";
								}
						 	}?>	
						</select>
						<select id="Year">
							<?php foreach($years_array as $key=>$value){
								if($key==$payments_data['Expiry_year']){
									echo "<option selected value=$key>$value</option>";
								}else{
									echo "<option value=$key>$value</option>";
								}
						 	}?>	
							
						</select>
					</div>
					<br/>
					<div class="form-group">
						<label>Billing Zip*</label><br/>
						<input type="text" id="billingzip" value="<?php echo $payments_data['zipcode'];?>" required>
					</div>
					<div class="modal-footer justify-content-md-center">
				    	<button id="update_payment_info" type="submit" class="btn btn-secondary">SUBMIT</button>
				    </div>
				</form>
		      </div>
		      
		    </div>

		  </div>
		</div>
		<div id="myModal2" class="modal fade" role="dialog2">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        
		        <h4 class="modal-title">Add New Payment:</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>
		      <div class="modal-body">
		      	<label>Payment Type: *</label><br/>
		      	<select id="payment_type">
					<option value="">Select</option>
					<option value="Mastercard">Mastercard</option>
					<option value="Visa">Visa</option>
					<option value="American_Express">American Express</option>
				</select>
				<br/>
				<label>First Name: *</label>
				<input id="firstName" type="text"/>
				<br/>
				<label>Last Name: *</label>
				<input id="lasttName" type="text"/>
				<br/>
		       	<label>Card Number*</label>
		       	<input id="select_card_number" type="text" value=""/>
		       	<br/>
		       	<label>CCV*</label>
				<input id="select_ccv" type="text" value=""/>
				<br/>
				<label>Expiration Date*</label>
				<br/>
				<select id="selectmonth">
					<option selected value="">Select</option>
					<?php foreach($months_array as $key=>$value){
						
						echo "<option value=$key>$value</option>";
						
				 	}?>	
				</select>
				<select id="selectYear">
					<option selected value="">Select</option>
					<?php foreach($years_array as $key=>$value){
					
						echo "<option value=$key>$value</option>";
						
				 	}?>	
					
				</select>
				<br/>
				<label>Billing Address*</label><br/>
				<select id="BillingAddress">
					<option selected value="">Select</option>
					<option value="addnewbilling">Add New Billing Address</option>
					<option value="<?php $payments_data['billing_address'];?>"><?php echo $payments_data['billing_address'];?> </option>
				</select>
				<br/>
				<div id="add_new_billing_address" class="hide">
					<label>Add Billing Address*</label><br/>
					<input id="new_billing_address" type="text" placeholder="Add Biillng Address"></input>
				</div>
		      </div>
		      <div class="modal-footer justify-content-md-center">
		        <button id="add_payment_info" type="submit" class="btn btn-secondary">SUBMIT</button>
		      </div>
		    </div>

		  </div>
		</div>
			<!-- Stripe JavaScript library -->
			<script src="https://js.stripe.com/v3/"></script>
		
			<!-- jQuery is used only for this example; it isn't required to use Stripe -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

		<?php get_footer();?>	
		<script>
			var stripe = Stripe('pk_test_jtWtIVtWDtzfftY59MQaNGJQ00ZZy89Axo');
			
			jQuery(document).ready(function() {
				jQuery('#update_payment_info').click(function() {
					alert('clicked');

					var card_number = jQuery('#card_number').val();

					var month = jQuery('#month').val();

					var Year = jQuery('#Year').val();

					var billingzip = jQuery('#billingzip').val();

					var datastring  = "ajax_request=update_payment_info&card_number="+card_number+"&month="+month+"&Year="+Year+"&billingzip="+billingzip;

					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    refreshPage();

						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});
				});
				jQuery('#remove_payments').click(function() {
					var datastring  = "ajax_request=remove_payment_info";
					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    refreshPage();

						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});
				});

				jQuery('#add_payment_info').click(function() {

					var payment_type = jQuery('#payment_type').val();

					var firstName = jQuery('#firstName').val();

					var lasttName = jQuery('#lasttName').val();

					var select_card_number = jQuery('#select_card_number').val();

					var selectmonth = jQuery('#selectmonth').val();

					var selectYear = jQuery('#selectYear').val();

					var BillingAddress = jQuery('#BillingAddress').val();

					var new_billing_address = jQuery('#new_billing_address').val();

					if(BillingAddress=="addnewbilling"){
						BillingAddress = jQuery('#new_billing_address').val();
					}

					var datastring  = "ajax_request=add_payment_info&payment_type="+payment_type+"&firstName="+firstName+"&lasttName="+lasttName+"&select_card_number="+select_card_number+"&selectmonth="+selectmonth+"&selectYear="+selectYear+"&BillingAddress="+BillingAddress;

					jQuery.ajax({
						url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
						method : "POST",
						data : datastring,
						success: function(result){
						    
						    //var JSONobj = JSON.parse(result);
						    console.log(result);
						    //refreshPage();

						    //alert(result);
						    //jQuery(location).attr('href', '/rebow/order-confirmation');
						}
					});
				});
				jQuery('#BillingAddress').change(function(){
					var BillingAddress = jQuery('#BillingAddress').val();
					if(BillingAddress=="addnewbilling"){
						jQuery('#add_new_billing_address').show();
					}
				});
				function refreshPage(){
				    window.location.reload();
				}
			});

		</script>
	</body>
</html>