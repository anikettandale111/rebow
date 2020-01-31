<?php /* Template Name: my_information*/ ?>

<?php require_once("db_config.php");?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php get_header();
			$user_id = wp_get_current_user()->id;

			$user_email= wp_get_current_user()->user_email;
			$display_name= wp_get_current_user()->display_name;
			//print_r(wp_get_current_user());
		?>
		<?php
				
			function fetch_all_customer_details($user_id){
				$query = "SELECT CONCAT(b.first_name,' ',b.last_name) as 'Name','********' as 'Password',b.company_name as 'company_name',b.phone_number as 'phone_number',b.SecondaryPhoneNumber as 'SecondaryPhoneNumber',b.pickup_address as 'pickup_address',b.delivery_address as 'delivery_address' from customers b where b.user_id=$user_id";

				$res = mysql_query($query);

				$row = mysql_fetch_assoc($res);

				return $row;
			}
		?>
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

		<!-- Start accoordion -->
		<section>
		  <div class="container">
		    <div class="row">
		      <ul class="account">
		        <li><a href="/rebow/my-orders/">My Orders</a></li>
		        <li class="selected"><a href="/rebow/my-information/">My Information</a></li>
		        <li><a href="/rebow/payment-information/">Payment info</a></li>
		        <li><a href="/rebow/support/">Support</a></li>
		      </ul>
		      <div class="rhs-account mb-5 view-order">
		        <div class="row justify-content-left">
		          <div class="col-sm-12 mb-2">
		            <!-- Start order bredcrumb-->
		            <div class="row">
		              <div class="col-sm-12">
		                <ul class="order-breadcrumb">
		                  <li><a href="">MY INFORMATION</a></li>
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
		                  <em><a class="white-color">Edit</a></em>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		        <?php

					$user_data = fetch_all_customer_details($user_id);
				?>
		        <div class="row my-info">
		          <div class="col-sm-12 pt-4">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Name :</b></p>
		              </div>
		              <div class="col-from-field">
		                <label for=""><?php echo $display_name;?></label>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Email :</b></p>
		              </div>
		              <div class="col-from-field">
		                <label for=""><?php echo $user_email;?></label>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Password :</b></p>
		              </div>
		              <div class="col-from-field">
		                <label for="">******</label>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Company Name :</b></p>
		              </div>
		              <div class="col-from-field">
		                <label for=""><?php echo $user_data['company_name'];?></label>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Phone Number :</b></p>
		              </div>
		              <div class="col-from-field">
		                <label for=""><?php echo $user_data['phone_number'];?></label>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Secondary Phone Number :</b></p>
		              </div>
		              <div class="col-from-field">
		                <label for=""><?php echo $user_data['SecondaryPhoneNumber'];?></label>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Delivery Address :</b></p>
		              </div>
		              <div class="col-from-field">
		                <address>
		                  <?php echo $user_data['delivery_address'];?><br/>
		                </address>
		              </div>
		            </div>
		          </div>
		          <div class="col-sm-12">
		            <div class="row-form px-3">
		              <div class="col-from-field">
		                <p><b>Pick Up Address :</b></p>
		              </div>
		              <div class="col-from-field">
		                <address>
		                  <?php echo $user_data['pickup_address'];?>
		                </address>
		              </div>
		            </div>
		          </div>

		        </div>
		        
		      </div>
		    </div>

		      </div>
		    </div>
		  </div>
		</section>
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
		<?php get_footer();?>
	</body>
</html>