<?php /* Template Name: order_confirmation*/ ?>
<html lang="en">
	<head>
		<link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
	</head>
	<body>
		<?php 
		require_once('session_values.php');
		//$order_id = 
		get_header();
		
		?>
		<?php (wp_get_current_user()->display_name);
		$user_id = wp_get_current_user()->id;
		$user_email = wp_get_current_user()->user_email;

		if(empty($user_id)){
			$user_id = $_REQUEST['user_id'];

			$user_email = get_user_email_data($user_id);

		}
		?>
		<?php
			function get_latest_order_data($user_id){
				$query = "SELECT * from orders_data where user_id=$user_id order by created_at desc limit 1";

				$res= mysql_query($query);

				$orders_data = mysql_fetch_assoc($res);
				
				return $orders_data;
			}
			function get_user_email_data($user_id){
				//echo "Query:".
				$query = "select user_email from wp_users where id=$user_id";

				$res = mysql_query($query);

				$row = mysql_fetch_row($res);

				return $row[0];
			}
			$orders_data = get_latest_order_data($user_id);
			$payments_data = get_payments_data_user($user_id);
		?>
		<!-- page heading -->
		<section class="page-header my-5">
		  <div class="container">
		    <div class="row justify-content-center">
		      <div class="col text-center">
		        <h1>Order Confirmation</h1>
		      </div>
		    </div>
		  </div>
		</section>

		<!-- Thanks Order -->
		<section class="grey-text">
		  <div class="container">
		    <div class="row text-center">
		      <div class="col-sm-12 col-md-6 mb-3">
		        <div class="grey-bg p-5">
		          <div class="col-sm-12">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/succes-icon.png" alt="">
		          </div>
		          <div class="col-sm-12 mt-4">
		            <p>You will be receiving a confirmation of your delivery and pickup times within the next 24 - 48 hours to the email address listed below : </p>
		          </div>
		          <div class="col-sm-12 mt-3">
		            <a class="link-email" href="#"><?php echo $user_email;?></a>
		          </div>
		        </div>
		      </div>
		      <div class="col-sm-12 col-md-6 mb-3">
		        <div class="grey-bg p-5">
		          <div class="col-sm-12">
		            <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/email-icon.png" alt="">
		          </div>
		          <div class="col-sm-12 mt-4">
		            <p>You can log in and view or change your order at anytime. An account has been created and emailed to you.</p>
		          </div>
		          <div class="col-sm-12 mt-3">
		            <strong>Please check your email</strong>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>

		<!-- order summary -->
		<section class="grey-text">
		  <div class="container mt-3">
		    <div class="row">
		      <div class="col-sm-12 order-summary">
		        <div class="blue-bg p-5 text-center">
		            <div class="col-sm-12">
		              <h6>ORDER SUMMARY</h6>
		            </div>
		            <div class="col-sm-12 mt-3">
		              <p>Order #<?php echo $current_order_id=$orders_data['order_id'];?></p>
		              <p>Placed on <?php echo get_custom_formatted_date($orders_data['created_at']);?></p>
		          </div>
		        </div>
		      </div>
		    </div>
		    <div class="row">
		      <div class="col-sm-12 col-md-6 text-center py-5">
		        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/dollies.png" alt="">
		      </div>
		      <div class="col-sm-12 col-md-6 py-5 mt-4">
		       <?php 

		       	if($orders_data['order_type']=="RENTAL"){
		       		$shipping_type = 'Delivery Empty Boxes';
					$deliver_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

					$shipping_type = 'Pickup Empty Boxes';
					$pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

					if($orders_data['product_id']==0){

						echo "<li>".$orders_data['added_box_count']." Boxes"."</li>";
						echo "<li>".$order_type." PERIOD : ".$orders_data['order_time_period']."</li>";

					}else{

						//echo "<li>".$orders_data['']." Boxes"."</li>";

						$packages_data = get_package_data($orders_data['product_id']);

						$product_range_text = ($packages_data['product_range']!="")? "(".$packages_data['product_range'].")" : "";
						//echo $product_range_text;
						echo "<li>".$packages_data['product_name']." Package -".$packages_data['box_count']." Boxes ".$product_range_text."</li>";
						echo "<li>".$order_type." PERIOD : ".$orders_data['order_time_period']."</li>";
						/*echo "<ul>Includes";
						echo "<li>".$packages_data['box_count']." ReBow™ Boxes </li>";
						echo "<li>".$packages_data['nestable_dollies_count']." Nestable ReBow™ Dollies</li>";
						echo "<li>".$packages_data['labels_count']." Labels</li>";
						echo "<li>".$packages_data['zipties_count']." Security Zip Ties</li>";
						echo "</ul>";*/
					}
				}else{
					$shipping_type = 'Delivery Empty Boxes';
					$deliver_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);

					$shipping_type = 'Pickup Packed Boxes';
					$pickup_packed_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

					$shipping_type = 'Delivery Packed Boxes';
					$delivery_packed_boxes_data = get_storage_shipping_data($current_order_id,$shipping_type);

					$shipping_type = 'Pickup Empty Boxes';
					$pickup_empty_boxes_data = get_rental_shipping_data($current_order_id,$shipping_type);
					if($orders_data['product_id']==0){

						echo "<li>".$orders_data['added_box_count']." Boxes"."</li>";
						echo "<li>".$order_type." PERIOD : ".$orders_data['order_time_period']."</li>";
						

					}else{
						$packages_data = get_package_data($orders_data['product_id']);
						$product_range_text = ($packages_data['product_range']!="")? "(".$packages_data['product_range'].")" : "";
						echo "<li>".$packages_data['product_name']." Package -".$packages_data['box_count']." Boxes".$product_range_text."</li>";
						
						if($orders_data['added_box_count']!=0){
							echo "<li>".$orders_data['added_box_count']." Added Boxes</li>";
						}
						echo "<li>".$order_type." PERIOD : ".$orders_data['order_time_period']."</li>";
						/*echo "<ul>Includes";
						echo "<li>".$packages_data['box_count']." ReBow™ Boxes </li>";
						echo "<li>".$packages_data['nestable_dollies_count']." Nestable ReBow™ Dollies</li>";
						echo "<li>".$packages_data['labels_count']." Labels</li>";
						echo "<li>".$packages_data['zipties_count']." Security Zip Ties</li>";
						echo "</ul>";*/


					}
				}?>
		      </div>
		    </div>
		  </div>
		</section>

		<!-- DELIVERY & PICK UP DETAILS -->
		<section class="delevery-pick">
		  <div class="container ">
		    <div class="row justify-content-center grey-bg">
		      <div class="col-sm-12 col-md-5 de-pic">
		        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/shopping-delivery.png" alt="">
		        <p>DELIVERY & PICK UP DETAILS</p>
		      </div>
		    </div>
		    <div class="clearfix"></div>
		    <div class="row justify-content-center my-5">
		      <div class="col-sm-12 col-md-5">
		        <div class="row">
		          <div class="col-sm-12 p-0">
		            <p>Delivery Address  : </p>
		          </div>
		          <div class="col-sm-12 p-0">
		            <p><?php echo $deliver_empty_boxes_data['address'];?></p>
		            <p><?php echo $deliver_empty_boxes_data['appartment_info'];?></p>
		          </div>
		        </div>
		        <div class="row my-3">
		          <div class="col-sm-4 p-0">
		            <p>Delivery Date :</p>
		          </div>
		          <div class="col-sm-8 p-0">
		            <p><?php echo get_custom_formatted_date($deliver_empty_boxes_data['date']);?></p>
		          </div>
		        </div>
		        <div class="row">
		          <div class="col-sm-12 p-0">
		            <p>Optional Delivery Times :</p>
		          </div>
		          <div class="col-sm-12 p-0">
		            <ul class="pkg-info">
		              <li><?php echo str_replace("_"," ",$deliver_empty_boxes_data['preferred_time'])." "."PST";?></li>
		              <li><?php echo str_replace("_"," ",$deliver_empty_boxes_data['alternative_time'])." PST";?></li>
		            </ul>
		          </div>
		          <div class="row my-3">
			          <div class="col-sm-12 p-0">
			            <p>Pick Up : <?php echo $deliver_empty_boxes_data['floor_level'];?> </p>
			          </div>
			        </div>
		        </div>
		        <div class="row my-3">
		          <div class="col-sm-12 p-0">
		            <p>*We will confirm these times with<br> you within 24-48 hours after your order</p>
		          </div>
		        </div>
		      </div>
		      <div class="col-sm-12 col-md-5">
		        <div class="row">
		          <div class="col-sm-12 p-0">
		            <p>Pick Up Address  :</p>
		          </div>
		          <div class="col-sm-12 p-0">
		            <p><?php echo $pickup_empty_boxes_data['address'];?><br><?php echo $deliver_empty_boxes_data['appartment_info'];?></p>
		          </div>
		        </div>
		        <div class="row my-3">
		          <div class="col-sm-3 p-0">
		            <p>Pick Up Date :</p>
		          </div>
		          <div class="col-sm-9 p-0">
		            <p><?php echo get_custom_formatted_date($pickup_empty_boxes_data['date']);?></p>
		          </div>
		        </div>
		        <div class="row">
		          <div class="col-sm-12 p-0">
		            <p>Optional Pick Up Times :</p>
		          </div>
		          <div class="col-sm-12 p-0">
		            <ul class="pkg-info">
		              <li><?php echo str_replace("_"," ",$pickup_empty_boxes_data['preferred_time'])." PST";?></li>
		              <li><?php echo str_replace("_"," ",$pickup_empty_boxes_data['alternative_time'])." PST";?></li>
		            </ul>
		          </div>
		        </div>
		        <div class="row my-3">
		          <div class="col-sm-12 p-0">
		            <p>Pick Up : <?php echo $deliver_empty_boxes_data['floor_level'];?> </p>
		          </div>
		        </div>
		        <div class="row my-3">
		          <div class="col-sm-12 p-0">
		            <p>*We will confirm these times with you within<br> 24-48 hours after your order</p>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>
		<section>
		  <div class="container">
		    <div class="row justify-content-center grey-bg">
		      <div class="col-sm-12 col-md-5 de-pic">
		        <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cc-icon.png" alt="">
		        <p class="pl-4">Your card ending in <?php echo substr($payments_data['Card_Number'],-4)?> was charged $<?php echo $orders_data['total_price'];?></p>
		      </div>
		    </div>
		    <div class="clearfix"></div>
		    <div class="row blue-bg py-5 mb-5">
		      <div class="col-sm-12">
		        <div class="text-center customer-feedback">
		          <img class="mb-3" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/feedback.png" alt="">
		          <h5>How was your experience ?</h5>
		          <a href="javascript:;">Let us know!</a>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>
		<script>
			(function (global) { 

		    if(typeof (global) === "undefined") {
		        throw new Error("window is undefined");
		    }

		    var _hash = "!";
		    var noBackPlease = function () {
		        global.location.href += "#";

		        // making sure we have the fruit available for juice (^__^)
		        global.setTimeout(function () {
		            global.location.href += "!";
		        }, 50);
		    };

		    global.onhashchange = function () {
		        if (global.location.hash !== _hash) {
		            global.location.hash = _hash;
		        }
		    };

		    global.onload = function () {            
		        noBackPlease();

		        // disables backspace on page except on input fields and textarea..
		        document.body.onkeydown = function (e) {
		            var elm = e.target.nodeName.toLowerCase();
		            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
		                e.preventDefault();
		            }
		            // stopping event bubbling up the DOM tree..
		            e.stopPropagation();
		        };          
		    }

		})(window);
		</script>
		<?php get_footer();?>

	</body>
</html>