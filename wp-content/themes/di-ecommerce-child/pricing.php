<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rebow - Pricing</title>
    <link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
    
    <!-- core CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->
    <style>
      input[type="text"]::placeholder {      
        /* Firefox, Chrome, Opera */ 
        text-align: center; 
      } 
    </style>
  </head>
<body>
<?php /* Template Name: Pricing_new */ ?>
<?php //echo "Cooke1: ".$_COOKIE['cookie1'];
    //setcookie("Auction_Item", "Luxury Car", time()+2*24*60*60); 
session_start();
session_destroy();
//require_once('session_values.php');
get_header(); 
//$_SESSION['Auction_Item']= "Auction_Item";
//print_r($_SESSION);
 ?>   
<!-- wp:html -->
<main class="pricing-container">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 text-center py-4">
        <h1>Pricing &amp; Suggested Packages</h1>
      </div>
    </div>
  </div>
</main>
<!--end banner -->
<!-- Start Pricing -->
<section class="my-3">
  <div id="pricing_area" class="container">
    <div class="row justify-content-md-center">
      <ul class="col-md-auto col-auto price-tabs">
        <li>Residential</li>
        <li>Office</li>
        <li>Students</li>
        <li>create your own</li>
      </ul>
      <?php 
        $query = "select * from products where product_type='RESIDENTIAL' and status=1";
        $res = mysql_query($query);
        
      ?>
      <div class="col-12 price-pkg mt-5">
        <div class="row justify-content-md-center">
          <?php while($d = mysql_fetch_assoc($res)){
            
          ?>
          <div class="col-sm-12 col-md-3">
            <aside class="text-center pt-3">
              <h2><?php echo $d['product_name'];?></h2>
              <p class="sq-ft"><?php echo $d['product_range'];?></p>
              <p><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/box icon.svg" alt="" title=""> <?php echo $d['box_count'];?> BOXES</p>
              <hr>
              <small class="includes-text"><em>Includes</em><sup>*</sup> :</small>
              <ul class="includes pl-3 pr-3 pt-1 mb-2">
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['nestable_dollies_count'];?> Nestable Dollies </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['labels_count'];?> Labels </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['zipties_count'];?> Security Zip Ties </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['delivery'];?> 
                </li>
              </ul>
              <div class="clearfix"></div>
              <?php $product_data = $d['product_type']."_Rental_".$d['product_id'];?>
              <a href="javascript;" id="<?php echo $product_data;?>" class="pricing-opt">PRICING OPTIONS</a>
              <div class="clearfix"></div>
              <div class="rental-conatiner blue-bg py-4 mt-3">
                <div class="rental">
                  <h3>RENTAL</h3>
                  <small>Starting at</small>
                  <p><?php echo "$".number_format(get_rental_price($d['product_id'],2,2));?> / 2 Week Rental</p>
                  <?php
                       $product_data = $d['product_type']."_Rental_".$d['product_id'];
                    
                    echo '<button  id="'.$product_data.'" class="order_button btn btn-primary btn-small">Order Rental</button>';
                  ?> 
                </div>
                <div class="storage mt-3">
                  <h3>STORAGE<sup>*</sup> </h3>
                  <small>Starting at </small>
                  <p><?php echo "$".$price= number_format(get_storage_price($d['product_id'],1,1));?> / month</p>
                  <?php
                      $product_data1 = $d['product_type']."_Storage_".$d['product_id'];
                      echo '<button  id="'.$product_data1.'" class="order_button btn btn-primary btn-small">Order Storage</button>';
                    ?> </div>
              </div>
            </aside>
          </div>
          <?php }?>
        </div>
      </div>
      <?php 
        $query1 = "select * from products where product_type='OFFICE'";

        $res1 = mysql_query($query1);

      ?>
      <div class="col-12 price-pkg mt-5">
        <div class="row justify-content-md-center">
          <?php while($d = mysql_fetch_assoc($res1)){

          ?>
          <div class="col-sm-12 col-md-3">
            <aside class="text-center pt-3">
              <h2><?php echo $d['product_name'];?></h2>
              <p class="sq-ft"><?php echo $d['product_range'];?></p>
              <p><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/box icon.svg" alt="" title=""> <?php echo $d['box_count'];?> BOXES</p>
              <hr>
              <small class="includes-text"><em>Includes</em><sup>*</sup> :</small>
              <ul class="includes pl-3 pr-3 pt-1 mb-2">
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['nestable_dollies_count'];?> Nestable Dollies </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['labels_count'];?> Labels </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['zipties_count'];?> Security Zip Ties </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['delivery'];?> 
                </li>
              </ul>
              <div class="clearfix"></div>
              <?php $product_data = $d['product_type']."_Rental_".$d['product_id'];?>
              <a href="javascript;" id="<?php echo $product_data;?>" class="pricing-opt">PRICING OPTIONS</a>
              <div class="clearfix"></div>
              <div class="rental-conatiner blue-bg py-4 mt-3">
                <div class="rental">
                  <h3>RENTAL</h3>
                  <small>Starting at</small>
                  <p><?php echo "$".number_format(get_rental_price($d['product_id'],2,2));?> / 2 Week Rental</p>
                  <?php
                    $product_data = $d['product_type']."_Rental_".$d['product_id']; 
                    echo '<button  id="'.$product_data.'" class="order_button btn btn-primary btn-small">Order Rental</button>';
                  ?> 
                </div>
                <div class="storage mt-3">
                  <h3>STORAGE<sup>*</sup> </h3>
                  <small>Starting at </small>
                  <p><?php echo "$".$price=number_format(get_storage_price($d['product_id'],1,1));?> / month</p>
                  <?php
                      $product_data1 = $d['product_type']."_Storage_".$d['product_id'];
                      echo '<button  id="'.$product_data1.'" class="order_button btn btn-primary btn-small">Order Storage</button>';
                    ?> </div>
              </div>
            </aside>
          </div>
          <?php }?>
        </div>
      </div>
      <?php 
        $query2 = "select * from products where product_type='STUDENTS'";

        $res2 = mysql_query($query2);

      ?>
      <div class="col-12 price-pkg mt-5">
        <div class="row justify-content-md-center">
          <?php while($d = mysql_fetch_assoc($res2)){

          ?>
          <div class="col-sm-12 col-md-3">
            <aside class="text-center pt-3">
              <h2><?php echo $d['product_name'];?></h2>
              <p class="sq-ft"><?php echo $d['product_range'];?></p>
              <p><img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/box icon.svg" alt="" title=""> <?php echo $d['box_count'];?> BOXES</p>
              <hr>
              <small class="includes-text"><em>Includes</em><sup>*</sup> :</small>
              <ul class="includes pl-3 pr-3 pt-1 mb-2">
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['nestable_dollies_count'];?> Nestable Dollies </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['labels_count'];?> Labels </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['zipties_count'];?> Security Zip Ties </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <?php echo $d['delivery'];?> 
                </li>
              </ul>
              <div class="clearfix"></div>
              <?php $product_data = $d['product_type']."_Rental_".$d['product_id'];?>
              <a href="javascript;" id="<?php echo $product_data;?>" class="pricing-opt">PRICING OPTIONS</a>
              <div class="clearfix"></div>
              <div class="rental-conatiner blue-bg py-4 mt-3">
                <div class="rental">
                  <h3>RENTAL</h3>
                  <small>Starting at</small>
                  <p><?php echo "$".number_format(get_rental_price($d['product_id'],2,2));?> / 2 Week Rental</p>
                  <?php
                       $product_data = $d['product_type']."_Rental_".$d['product_id'];
                    
                    echo '<button  id="'.$product_data.'" class="order_button btn btn-primary btn-small">Order Rental</button>';
                  ?> 
                </div>
                <div class="storage mt-3">
                  <h3>STORAGE<sup>*</sup> </h3>
                  <small>Starting at </small>
                  <p><?php echo "$".$price=number_format(get_storage_price($d['product_id'],1,1));?> / month</p>
                  <?php
                      $product_data1 = $d['product_type']."_Storage_".$d['product_id'];
                      echo '<button  id="'.$product_data1.'" class="order_button btn btn-primary btn-small">Order Storage</button>';
                    ?> </div>
              </div>
            </aside>
          </div>
          <?php }?>
        </div>
      </div>
      <?php 
        $query2 = "select * from products where product_type='CustomOrder'";

        $res2 = mysql_query($query2);

        $data = mysql_fetch_assoc($res2);

        $default_product_cost_weekly = get_base_pricing('Rental_cost_per_1_box_per_1_week');

        $default_product_cost_monthly = get_base_pricing('Monthly_storage_cost_per_box');

        $default_box_count = 8;

        $weekly_cost = $default_box_count*$default_product_cost_weekly*2;

        $monthly_cost = $default_box_count*$default_product_cost_monthly*1;
      ?>
      <div class="col-12 price-pkg mt-5">
        <ul class="rt-strg">
          <li>Rental</li>
          <li>Storage</li>
        </ul>
        <aside class="p-5 rntl-strg">
          <div class="row">
            <div class="col-sm-12 col-md-6"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/box-02.jpg" alt="" title=""/> </div>
            <div class="col-sm-12 col-md-6 rental">
              <h3>Starting at $<?php echo $weekly_cost;?> / 2 week rental</h3>
              <div class="row">
                <div class="col">
                  <!--<div class="selectholder">
                    <label>Project Start</label>-->
                    <select name="choosebox" class="custombox" id="rentalbox">
                      <option value="0">Chooes Boxes</option>
                      <option selected value="8">8 Boxes</option>
                      <option value="16">16 Boxes</option>
                      <option value="24">24 Boxes</option>
                      <option value="32">32 Boxes</option>
                    </select>
                  <!--</div>-->
                </div>
                <div class="col">
                  <?php $product_data1 = $data['product_type']."_Rental_".$data['product_id'];?>
                  <button id="<?php echo $product_data1;?>" class="custom_order_button btn btn-secondary btn-small">Order</button>
                </div>
              </div>
              <p><sup>*</sup>Minimum Order Requirement : 8 Boxes</p>
            <small>Every 4 Boxes Comes With* :</small>
              <ul class="includes pr-3 pt-1 mb-2">
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  1 Nestable Dollies </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick01" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  4 Labels </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick2" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  4 Security Zip Ties </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="10" viewBox="0 0 18 13">
                    <path id="tick3" data-name="Shape Copy" d="M5.727,10.284l-4.3-4.075L0,7.567,5.727,13,18,1.358,16.568,0Z" fill="#b2d235"/>
                  </svg>
                  <span>FREE</span> Delivery &amp; Pickup </li>
              </ul>
        <div class="clearfix"></div>
              <?php $product_data = "RESIDENTIAL_Rental_1";?>
              <a href="#javascript;" id="<?php echo $product_data;?>" class="pricing-opt mb-5 underline">PRICING OPTIONS</a>
              <p class="mt-3">*For orders of 100+ bosxes, please <a href="/rebow/contact/">contact us</a></p>
            </div>
          </div>
        </aside>
        <aside class="p-5 rntl-strg">
          <div class="row">
            <div class="col-sm-12 col-md-6"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/box-02.jpg" alt="" title=""/> </div>
            <div class="col-sm-12 col-md-6 rental">
              <h3>Starting at $<?php echo $monthly_cost;?> / month</h3>
              <div class="row">
                <div class="col">
                  <!--<div class="selectholder">
                    <label>Project Start</label>-->
                    <select name="choosebox" class="custombox" id="storagebox">
                      <option value="0">Chooes Boxes</option>
                      <option selected value="8">8 Boxes</option>
                      <option value="16">16 Boxes</option>
                      <option value="24">24 Boxes</option>
                      <option value="32">32 Boxes</option>
                    </select>
                  <!--</div>-->
                </div>
                <div class="col">
                  <?php $product_data1 = $data['product_type']."_Storage_".$data['product_id'];?>
                  <button id="<?php echo $product_data1;?>" class="custom_order_button btn btn-secondary btn-small">Order</button>
                </div>
              </div>
              <p><sup>*</sup>Minimum Order Requirement : 8 Boxes</p>
        <p>We provide 2 day complimentary for you to pack and unpack your items.<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" title="" data-toggle="modal" data-target="#exampleModalCenter"/> </p>
        <div class="clearfix"></div>

              <?php $product_data = "RESIDENTIAL_Storage_1";?>
              <a href="#javascript;" id="<?php echo $product_data;?>" class="pricing-opt mb-5 underline">PRICING OPTIONS</a>
              <p class="mt-3">*For orders of 100+ boxes, please <a href="/rebow/contact/">contact us</a></p>
            </div>
          </div>
        </aside>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-auto py-4"> <small><sup>*</sup>Available in our Los Angeles location only.</small> </div>
    </div>
    <div class="row justify-content-md-center py-3">
      <div class="bg-grey w m-2 py-3">
        <div class="col-auto free-curbside">
          <p><em>FREE</em> Curbside Delivery &amp; Pickup in the Los Angeles Area&nbsp;<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/question-mark.png" alt="" data-toggle="modal" data-target=".bd-example-modal-lg"></p>
        </div>
      </div>
    </div>
    <div class="row justify-content-md-center my-4">
      <div class="col-auto text-center call-one"> <small style="font-size:18px;">Not sure what might work ?</small>
        <p>Call one of our service representatives at: <span>323 - 277 - 1111</span></p>
      </div>
    </div>
  </div>
</section>
<!-- End Pricing --> 
<!-- check email -->
<section class="blue-bg py-5">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-sm-12 text-center pb-3">
        <h3>Check and see if we service your area :</h3>
      </div>
      <div class="clearfix"></div>
      <div class="col-sm-12 col-md-4 col-auto">
        <input type="text" minlength=5 maxlength=5 id="current_address_zip" name="" placeholder="Zipcode of Current Address*">
      </div>
      <div class="col-sm-12 col-md-4 col-auto">
        <input type="text" minlength=5 maxlength=5 name="" id="new_address_zip" placeholder="Zipcode of New Address*">
      </div>
      <div class="col-sm-12 col-md-2  col-auto">
        <button type="button" id="checkzips1" class="btn btn-small">Check</button>
      </div>
    </div>
  </div>
</section>
<!--The Box -->
<section class="my-6 benefits">
  <div class="container">
    <div class="col-sm-12 text-center">
      <h3>The Box</h3>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-12 col-md-4"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/the-box-1.png" alt="" title=""> </div>
      <div class="col-sm-12 col-md-8"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/the-box-2.png" alt="" title=""> </div>
      <div class="col-auto my-3 pt-3"> <button class="btn btn-secondary" id="order_now_pricing">Order Now</button> </div>
    </div>
  </div>
</section>
<!--End The Box --> 
<!--perfect system -->
<section class="my-6 py-6 benefits bg-grey">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-sm-12 col-md-6 text-center mt-7">
        <h3>The<span> perfect system</span> to pack your stuff</h3>
        <p>Reusable Boxes On Wheels (ReBow™), is our stackable move system designed to securely facilitate your move by its ease of use, eliminating heavy lifting, and providing a more efficient way of transportation.</p>
        <div class="clearfix"></div>
        <a  class="get_started_pricing btn btn-secondary mt-5">Get Started</a> </div>
      <div class="col-sm-12 col-md-6 "> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/boxes.png" alt="" title=""> </div>
    </div>
  </div>
</section>
<!--End of perfect system --> 
<!--conpare to cardboard -->
<section class="py-6 cardboard">
  <div class="container">
    <div class="row text-center">
      <div class="col">
        <h3>Compare us to cardboard</h3>  
        <h5 class="mt-5 mb-5">COST FOR 1 BEDROOM (250 - 500 Sq Ft) :</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-5"> <img class="img-fluid top-m" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/cardboard.png" alt="" title="">
        <div class="blue-bg mt-3 text-center py-2">
          <label>$248.00 </label>
          <p>WITH AMAZON PRIME</p>
        </div>
      </div>
      <div class="col-sm-12 col-md-1 mt-13">
        <h4><b>VS</b></h4>
      </div>
      <div class="col-sm-12 col-md-6 float-right"> <img class="img-fluid" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/rebow-boxes.png" alt="" title="">
        <div class="blue-bg mt-3 text-center py-2">
          <label>$144.00 </label>
          <p>REBOW™ RENTAL FOR 2 WEEKS</p>
        </div>
      </div>
      <div class="row my-5 justify-content-center">
        <div class="col-sm-12 col-md-8 text-center headache">
          <p>Oh, this doesn’t include the headache and all the other extra things you’re going to keep in your house afterwards and throw out ;)
          </p>      
          <button id="" class="get_started_pricing btn btn-secondary mt-5">Get Started</button>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Modal for storage -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-5 px-5">
        <h4 class="txt-grey">Delivery & Pickup</h4>
        <p>ReBow will deliver and pickup your boxes on the ground floor unless<br> specified otherwise .</p>
        <p>A delivery fee is charged for your order to be delivered directly to your aparment. If you do not have any special delivery / pickup requirements, please check Neither.</p>
        <div class="table-responsive-sm mx-5 px-5">
          <table class="table">
            <tr>
              <th>Number of Boxes</th>
              <th>Elevator Delivery</th>
              <th>Stairs Delivery</th>
            </tr>
            <tr>
              <td>Up to 50 Boxes</td>
              <td>$25 charge</td>
              <td>$50 charge</td>
            </tr>
            <tr>
              <td>50 to 100 Boxes</td>
              <td>$50 charge</td>
              <td>$100 charge</td>
            </tr>
            <tr>
              <td>Over 100 Boxes</td>
              <td>Call for pricing</td>
              <td>Call for pricing</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php get_footer(); ?>
<div class="modal fade bd-example-modal-lg pricing-Data" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-5 px-5">
        <h4 class="txt-grey">Explore Our Pricing Options Below* :</h4>
          <div class="box-dtls">
            <h5 id="modal_product_box_count"></h5>
            <p><span id="modal_product_name"></span><span id="modal_product_range"></span></p>
          </div>
        <div class="pop-box">
          <div class="table-responsive-sm">
            <table class="table pr-data">
              <tr>
                <th>RENTAL<br>FRAME</th>
                <th>REBOW RENTAL<br> PRICING</th>
              </tr>
              <tr>
                <td>2 Weeks</td>
                <td id="week2_pricing"></td>
              </tr>
              <tr>
                <td>3 Weeks</td>
                <td id="week3_pricing"></td>
              </tr>
              <tr>
                <td>4 Weeks</td>
                <td id="week4_pricing"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="pop-box-2">
          <div class="table-responsive-sm">
            <table class="table pr-data">
              <tr>
                <th>STORAGE TIME<br> FRAME</th>
                <th>REBOW STORAGE<br> PRICING**</th>
              </tr>
              <tr>
                <td>1 Month</td>
                <td id="month1_pricing"></td>
              </tr>
              <tr>
                <td>2 Month</td>
                <td id="month2_pricing"></td>
              </tr>
              <tr>
                <td>3 Month</td>
                <td id="month3_pricing"></td>
              </tr>
            </table>
          </div>
        </div>
        <small>* Pricing is estimated and does not include extras. For longer pricing estimates, please contact us.</small>
        <div class="clearfix"></div>
        <small>**Available in our Los Angeles location only Delivery & Pickup are included in cost. </small>
      </div>
    </div>
  </div>
</div>  
<div id="modal_pricing" class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-5 px-5">
        <h4 class="txt-grey">Explore our Pricing Option Below</h4>
        <div class="rectangle-6-copy">
          <p id="modal_product_box_count" class="white-color"></p>
          <p  class="white-color"><span id="modal_product_name"></span><span id="modal_product_range"></span></p>
        </div>
        <div class="table-responsive-sm mx-5 px-5">
          <table class="table">
            <tr>
              <th>RENTAL FRAME</th>
              <th>REBOW RENTAL PRICING</th>
            </tr>
            <tr>
              <td>2 Weeks</td>
              <td id="week2_pricing"></td>
            </tr>
            <tr>
              <td>2 Weeks</td>
              <td id="week2_pricing"></td>
            </tr>
            <tr>
              <td>2 Weeks</td>
              <td id="week2_pricing"></td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <th>RENTAL FRAME</th>
              <th>REBOW RENTAL PRICING</th>
            </tr>
            <tr>
              <td>2 Weeks</td>
              <td id="week2_pricing"></td>
            </tr>
            <tr>
              <td>2 Weeks</td>
              <td id="week2_pricing"></td>
            </tr>
            <tr>
              <td>2 Weeks</td>
              <td id="week2_pricing"></td>
            </tr>
          
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
<script>
 jQuery(document).ready(function(){
    //alert('ready');
    //var hostname = location.hostname;
    jQuery("#continue").click(function() {

      //jQuery(location).attr('href', '#');
      jQuery('#service_yes').modal('hide');
       jQuery([document.documentElement, document.body]).animate({
            scrollTop: jQuery("#pricing_area").offset().top
      }, 1000);
      
    });
    jQuery( ".get_started_pricing" ).click(function() {
      jQuery([document.documentElement, document.body]).animate({
            scrollTop: jQuery("#pricing_area").offset().top
      }, 1000);
    });

    jQuery( "#order_now_pricing" ).click(function() {
      jQuery([document.documentElement, document.body]).animate({
            scrollTop: jQuery("#pricing_area").offset().top
      }, 1000);
    });
    jQuery( ".order_button" ).click(function() {
        //alert('clicked');
        var variable_name ='order_values';
        var order_values = jQuery(this).attr('id');

        console.log(order_values);
        //alert(order_values);
        variable_value = order_values;

        jsonString="ajax_request=setsessionvalues&variable_name="+variable_name+"&variable_value="+variable_value;
        jQuery.ajax({
            type: "POST",
            url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
            data: jsonString,
            success: function(result) {
              //alert(result);
              jQuery(location).attr('href', '/rebow/orderzip/');
                //window.console.log('Successful');

            }
        });
    });
    jQuery( ".pricing-opt" ).click(function() {
      //alert(1);
      var pricing_id = jQuery(this).attr('id');
      //console.log(pricing_id);
      //alert(pricing_id);
      product_id = pricing_id.split('_')[2];
      //alert(product_id);
      //product_id = pricing_id.split()[2];

      jsonString="ajax_request=get_modal_data&product_id="+product_id;

      jQuery.ajax({
          type: "POST",
          url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
          data: jsonString,
          success: function(result) {
            //alert(result);
            console.log(result);
            var jsonOBJ = JSON.parse(result);
            //alert(jsonOBJ.product_name);
            jQuery('#modal_product_name').text(jsonOBJ.product_name);
            jQuery('#modal_product_box_count').text(jsonOBJ.product_box_count+" Boxes");
            jQuery('#modal_product_name').text(jsonOBJ.product_name);
            if(jsonOBJ.product_range!=""){
              jQuery('#modal_product_range').text(" - "+jsonOBJ.product_range);
            }
            

            jQuery('#week2_pricing').text("$"+jsonOBJ.week2_pricing);
            jQuery('#week3_pricing').text("$"+jsonOBJ.week3_pricing);
            jQuery('#week4_pricing').text("$"+jsonOBJ.week4_pricing);

            jQuery('#month1_pricing').text("$"+jsonOBJ.month1_pricing);
            jQuery('#month2_pricing').text("$"+jsonOBJ.month2_pricing);
            jQuery('#month3_pricing').text("$"+jsonOBJ.month3_pricing);

            jQuery('.pricing-Data').modal('show');
            

          }
      });

    return false;
    });
    jQuery( ".custom_order_button" ).click(function() {
        //alert('clicked');
        var order_values = jQuery(this).attr('id');
        alert(order_values);
        var res = order_values.split("_");
        var product_type = res[0];

        var period_datas = res[1];

        if(period_datas=="Rental"){
            period_data = 0;
            var box_count= jQuery('#rentalbox').val();
        }else{
            period_data = 1;
            var box_count= jQuery('#storagebox').val(); 
        }
        
        alert(box_count);
        var product_id = res[2];

        jsonString="ajax_request=custom_order_session&custom_box_count="+box_count+"&period_data="+period_data+"&product_id="+product_id+"&product_type="+product_type;

        jQuery.ajax({
            type: "POST",
            url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
            data: jsonString,
            success: function(result) {
              //alert(result);
              jQuery(location).attr('href', '/rebow/orderzip/');
                //window.console.log('Successful');

            }
        });

       
    });

  });
  
</script>
</body>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>-->

<!-- /wp:html -->
</html>

