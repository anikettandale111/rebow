<?php /* Template Name: payment_information1*/ ?>
<?php require_once("user_check_login.php");?>
<?php 
 require_once("stripe_config.php");
 require_once 'stripe-php/init.php';
require_once("db_config.php");
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
 $intent = \Stripe\SetupIntent::create();
?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php get_header();
		$user_id = wp_get_current_user()->id;
		$display_name = wp_get_current_user()->display_name;
		?>
		<?php 
			function get_payments_data1($user_id){
				$query = "SELECT * FROM payments where user_id=$user_id and active=1";
				$res = mysql_query($query);
				$res1= array();
				while($row = mysql_fetch_assoc($res)){
					$res1[] = $row;
				}
				return $res1;
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
				          <?php 
				          //print_r($payments_data);
				          foreach($payments_data  as $payment){?>
				          <div class="col-sm-12 col-md-5">
				            <div class="grey-bg pay-inf" id="pament_method_<?php echo $payment['payment_id']; ?>">
				              <div class="row">
				                <div class="col-sm-3">
				                  <img class="m-c" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/mastercard-black.png" alt="">
				                </div>
				                <div class="col-sm-9">
				                  <div class="crd-hld">
				                    <label for=""><?php echo $payment['First_Name']." ".$payment['Last_Name'];?></label><br/>
				                    <label for="">Ending in <?php echo substr($payment['Card_Number'],-4);?></label>
				                    <label for=""><strong>Ex</strong> : <?php echo $payment['Expiry_month']."/".$payment['Expiry_year'];?></label>
				                  </div>
				                  <div class="blng-adr">
				                    <strong>Billing Address :</strong>
				                    <label for=""><?php echo $payment['billing_address'];?></label>
				                    <label for=""></label>
				                  </div>
				                  <ul class="edit-removed">
				                    <li><a href="#javascript;" data-toggle="modal" data-target="#myModal1">EDIT</a></li>
				                    <?php if(count($payments_data)!=1):?>
				                    <li><a id="remove_payments" onclick="delete_payment_method(<?php echo $payment['payment_id']; ?>)" href="javascript:;">REMOVE</a></li>
				                    <?php endif ?>
				                  </ul>
				                </div>
				              </div>
				            </div>
				          </div>
				      	<?php }?>
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
		      	<form class="checkout-form form" id="update_payment_form">
				   <div class="form-row">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">Card Number:</label>
	                    </div>
	                    <div class="form-group col-md-4 mb-0">
	                      <label for="inputEmail4">CCV:</label>
	                    </div>
	                </div>
	                <div class="form-row">
	                    <div class="form-group col-md-6">
	                      	
	                      	<span id="card-number" class="form-control">
		                        <!-- Stripe Card Element -->
		                    </span>
	                    </div>
	                    <div class="form-group col-md-4">
	                      	
	                      	<span id="card-cvc" class="form-control">
		                        <!-- Stripe CVC Element -->
		                    </span>
	                    </div>
	                </div>
	                <div class="form-row">
	                  	<div class="form-group col-md-12 mb-0">
	                    	<label for="inputEmail4">Expiration Date :</label>
	                  	</div>
	                </div>
	                <div class="form-row">
	                  	<div class="form-group col-md-4">
	                    	<span id="card-exp" class="form-control">
	                      	<!-- Stripe Card Expiry Element -->
	                    	</span>
	                  	</div>
	                </div>
				  <button type="button" id="update_payment_method" onclick="update_payment_info()" class="submit_order_new btn btn-secondary">Submit</button>
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
		      	<form class="checkout-form form" id="add_new_payment_form">
                <?php //if($user_status!=1){?>
                <div id="new_user_checkout">
                  
                  
                  	<div class="form-row">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputAddress">Payment Type :</label>
	                    </div>
                  	</div>
                  	<div class="form-row">
                    	<div class="form-group col-md-5">
                      		<div class="selectholder">
	                      		<label>Payment Type</label>
	                     		<select id="payment_type" required>
									<option value="">Select</option>
									<option value="Mastercard">Mastercard</option>
									<option value="Visa">Visa</option>
									<option value="American_Express">American Express</option>
									
								</select>
                      		</div>
                    	</div>
                  	</div>
                  	<div class="form-row">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">First Name:</label>
	                    </div>
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">Last Name:</label>
	                    </div>
	                </div>
                  	<div class="form-row">
	                    <div class="form-group col-md-6">
	                      	<input type="text" class="form-control" id="firstName" value="<?php echo $firstName;?>" placeholder="First Name" required>
	                    </div>
	                    <div class="form-group col-md-6">
	                      	<input type="text" class="form-control" id="lastName" required value="<?php echo $lastName;?>" placeholder="Last Name">
	                    </div>
	                </div>
	                <div class="form-row">
	                    <div class="form-group col-md-6 mb-0">
	                      <label for="inputEmail4">Card Number:</label>
	                    </div>
	                    <div class="form-group col-md-4 mb-0">
	                      <label for="inputEmail4">CCV:</label>
	                    </div>
	                </div>
	                <div class="form-row">
	                    <div class="form-group col-md-6">
	                      	
	                      	<span id="card-number" class="form-control">
		                        <!-- Stripe Card Element -->
		                    </span>
	                    </div>
	                    <div class="form-group col-md-4">
	                      	
	                      	<span id="card-cvc" class="form-control">
		                        <!-- Stripe CVC Element -->
		                    </span>
	                    </div>
	                </div>
	                <div class="form-row">
	                  	<div class="form-group col-md-12 mb-0">
	                    	<label for="inputEmail4">Expiration Date :</label>
	                  	</div>
	                </div>
	                <div class="form-row">
	                  	<div class="form-group col-md-4">
	                    	<span id="card-exp" class="form-control">
	                      	<!-- Stripe Card Expiry Element -->
	                    	</span>
	                  	</div>
	                </div>
	                  <!--<div class="form-row">
	                    <div class="form-group col-md-8">
	                      <div id="card-element"></div>
	                    </div>
	                  </div>-->
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-12 mb-0">
                    <label for="inputEmail4">Billing Address :</label>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <div class="location-pin">
                      <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/location-pin.png" alt="">
                    </div>
                    <input class="addrs" type="text" placeholder="Address*" name="billingaddress" id="billingaddress" value="<?php //echo $billing_address;?>" required>
                  </div>
                </div>
               
                <button type="button" id="add_new_payment_method" data-secret="<?= $intent->client_secret ?>" onclick="add_payment_info()" class="submit_order_new btn btn-secondary">Submit</button>
              </form>
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
	        // cardButton.addEventListener('click', function(ev) {
	        var elements = stripe.elements();
	        // Set up Stripe.js and Elements to use in checkout form
	        var cardButton = document.getElementById('add_new_payment_method');
          
          	var clientSecret = cardButton.dataset.secret;

          	// Try to match bootstrap 4 styling
	        var style = {
	              base: {
	                  'lineHeight': '1.35',
	                  'fontSize': '1.11rem',
	                  'color': 'green',
	                  'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
	              }
	        };

          	// Card number
	        var card = elements.create('cardNumber', {
	            'placeholder': 'Card Number*',
	            'style': style
	         });
          	card.mount('#card-number');

	        // CVC
	        var cvc = elements.create('cardCvc', {
	            'placeholder': 'CVC*',
	            'style': style
	        });
	        cvc.mount('#card-cvc');

	        // Card expiry
	        var exp = elements.create('cardExpiry', {
	            'placeholder': 'MM/YY',
	            'style': style
	        });
	        exp.mount('#card-exp');

	        //var clientSecret = cardButton.dataset.secret;
			
			jQuery(document).ready(function() {
				jQuery('#update_payment_info').click(function() {
					//alert('clicked');
					.//var card_number = jQuery('#card_number').val();

					//var month = jQuery('#month').val();

					//var Year = jQuery('#Year').val();

					//var billingzip = jQuery('#billingzip').val();

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
			function add_payment_info(){

				if(jQuery('#payment_type').val()==''){
		            setTimeout(function(){
		              jQuery('#payment_type').focus();
		            },1000);
		            return false;
		        }
	          	if(jQuery('#billingaddress').val()==''){
		            setTimeout(function(){
		              jQuery('#billingaddress').focus();
		            },1000);
		            return false;
		        }
          
		        if(jQuery('#firstName').val()==''){
		            setTimeout(function(){
		              jQuery('#firstName').focus();
		            },1000);
		            return false;
		        }

		        if(jQuery('#lastName').val()==''){
		            setTimeout(function(){
		              jQuery('#lastName').focus();
		            },1000);
		            return false;
		        }

		        var firstName = jQuery('#firstName').val();
		        
		        var billingaddress = jQuery('#billingaddress').val();

		        //var zipcode = jQuery('input[name="postal"]').val();

		        stripe.confirmCardSetup(
                clientSecret,
                {
                  payment_method: {
                    card: card,
                    billing_details: {
                    	name: firstName,
                    	address: {
                    		line1: billingaddress,
                    		//postal_code: zipcode
                    	}
                    }
                  }
                }
              	).then(function(result) {
	                if (result.error) {
	                  
	                  console.log(result);
	                  //alert("unsuccessful");
	                } else {
	                  
	                  //var user_status = jQuery('#user_status').val();
	                  	var payment_type = jQuery('#payment_type').val();
	                  	var firstName = jQuery('#firstName').val();
	                  	var lastName = jQuery('#lastName').val();
	                  	var billingaddress = jQuery('#billingaddress').val();

	                    var data = JSON.stringify(result);
	                    
	                    var datastring = "ajax_request=add_new_payment_method&firstName="+firstName+"&lastName="+lastName+"&billingaddress="+billingaddress+"&payment_type="+payment_type+"&result="+data;
	                    
	                    jQuery.ajax({
	                      	url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
	                      	method : "POST",
	                      	data : datastring,
	                      	success: function(result){
	                          	console.log(result);
	                          	window.location.reload();
	                      	}
	                    });
	                  
	                }
	            });
			}
			function update_payment_info(){
				
				if(jQuery('#payment_type').val()==''){
		            setTimeout(function(){
		              jQuery('#payment_type').focus();
		            },1000);
		            return false;
		        }
	          	if(jQuery('#billingaddress').val()==''){
		            setTimeout(function(){
		              jQuery('#billingaddress').focus();
		            },1000);
		            return false;
		        }
          
		        if(jQuery('#firstName').val()==''){
		            setTimeout(function(){
		              jQuery('#firstName').focus();
		            },1000);
		            return false;
		        }

		        if(jQuery('#lastName').val()==''){
		            setTimeout(function(){
		              jQuery('#lastName').focus();
		            },1000);
		            return false;
		        }

		        var firstName = jQuery('#firstName').val();
		        
		        var billingaddress = jQuery('#billingaddress').val();

		        //var zipcode = jQuery('input[name="postal"]').val();

		        stripe.confirmCardSetup(
                clientSecret,
                {
                  payment_method: {
                    card: card,
                    billing_details: {
                    	name: firstName,
                    	address: {
                    		line1: billingaddress,
                    		//postal_code: zipcode
                    	}
                    }
                  }
                }
              	).then(function(result) {
	                if (result.error) {
	                  
	                  console.log(result);
	                  //alert("unsuccessful");
	                } else {
	                  
	                  //var user_status = jQuery('#user_status').val();
	                  	var payment_type = jQuery('#payment_type').val();
	                  	var firstName = jQuery('#firstName').val();
	                  	var lastName = jQuery('#lastName').val();
	                  	var billingaddress = jQuery('#billingaddress').val();

	                    var data = JSON.stringify(result);
	                    
	                    var datastring = "ajax_request=add_new_payment_method&firstName="+firstName+"&lastName="+lastName+"&billingaddress="+billingaddress+"&payment_type="+payment_type+"&result="+data;
	                    
	                    jQuery.ajax({
	                      	url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
	                      	method : "POST",
	                      	data : datastring,
	                      	success: function(result){
	                          	console.log(result);
	                          	window.location.reload();
	                      	}
	                    });
	                  
	                }
	            });
			}
			function delete_payment_method(rowid){
				if(confirm('Are you sure to delete this ?')){
	                jQuery.ajax({
                      	url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
                      	method : "POST",
                      	data : {ajax_request:'remove_payment_method',rowid:rowid,},
                      	success: function(result){
                          	alert(result);
                          	//$('#pament_method_'+rowid).remove();
                          	window.location.reload();
                      	}
                    });
				}
			}
		</script>
	</body>
</html>