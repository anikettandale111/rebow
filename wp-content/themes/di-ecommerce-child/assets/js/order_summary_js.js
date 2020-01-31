jQuery(document).ready(function() {
	jQuery(window).on('beforeunload', function(){
		//console.log('leaving_page');
		save_data_in_session();
        //return 'Are you sure you want to leave?';
    });

    function save_data_in_session(){
    	var product_id = jQuery('#product_id').val();

		var display_period = jQuery('#display_period').val();

		var dp_period = jQuery('#dp_period').val();

		var product_name_field = jQuery('#product_name_field').val();

		var box_count_field = Number(jQuery('#box_count_field').val());

		var added_box_count_field = Number(jQuery('#added_box_count_field').val());
		//alert(added_box_count_field);
		var added_box_price_field = Number(jQuery('#added_box_price_field').val());
		//alert(added_box_price_field);
		var product_price_field = Number(jQuery('#product_price_field').val());

		var subtotal_field = Number(jQuery('#subtotal_field').val());

		var delivery_cost_field = Number(jQuery('#delivery_cost_field').val());

		var pickup_cost_field = Number(jQuery('#pickup_cost_field').val());

		var sales_tax_field = Number(jQuery('#sales_tax_field').val());

		var total_price_field = Number(jQuery('#total_price_field').val());

		var tax_rates = Number(jQuery('#tax_rates').val());

		var period_data_field = Number(jQuery('#period_data_field').val());

		var default_product_cost = Number(jQuery('#default_product_cost').val());

		var period_data_value = jQuery('#period_data_value').val();

		var datastring = "ajax_request=gotonextpage&product_id="+product_id+"&display_period="+display_period+"&dp_period="+dp_period+"&product_name="+product_name_field+"&box_count="+box_count_field+"&added_box_count="+added_box_count_field+"&added_box_price="+added_box_price_field+"&product_price="+product_price_field+"&subtotal="+subtotal_field+"&delivery_cost="+delivery_cost_field+"&pickup_cost="+pickup_cost_field+"&total_price="+total_price_field+"&period_data_value="+period_data_value+"&sales_tax="+sales_tax_field;

		jQuery.ajax({
			url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
			method : "POST",
			data : datastring,
			success: function(result){
			    
			    //var JSONobj = JSON.parse(result);
			    console.log(result);

			    //alert(result);
			    //jQuery(location).attr('href', '/rebow/delivery_pickup');
			}
		});
    }
	var added_box_count_field = jQuery('#added_box_count_field').val();
	if(added_box_count_field==0){
		jQuery('.addedboxfield').hide();
	}else{
		jQuery('.addedboxfield').show();
	}
	jQuery("#back_to_order").click(function() {
		//alert('clicked');
	    jQuery([document.documentElement, document.body]).animate({
	        scrollTop: jQuery("#order_summary").offset().top
	    }, 1000);
	});
	var delivery_cost_field = jQuery('#delivery_cost_field').val();
	if(delivery_cost_field==0){
		jQuery('#deliverycost').hide();
	}else{
		jQuery('#deliverycost').show();
	}

	var pickup_cost_field = jQuery('#pickup_cost_field').val();
	if(pickup_cost_field==0){
		jQuery('#pickupcost').hide();
	}else{
		jQuery('#pickupcost').show();
	}
	jQuery("#add_box_count").change(function() {
		//alert(1);
		var added_box_count = jQuery('#add_box_count').val();
		console.log(added_box_count);
		var display_period = jQuery('#display_period').val();
		console.log(display_period);
		var default_product_cost = jQuery('#default_product_cost').val();
		console.log(default_product_cost);
		var added_box_price = (added_box_count*default_product_cost*display_period);
		console.log(added_box_price);

		jQuery('#added_box_price').text("$"+added_box_price);
		jQuery('#added_box_price_field').val(added_box_price);
		//calculation();

	});
	jQuery('#add_more_boxes785').click(function(){

		var added_box_count = jQuery('#add_box_count').val();

		var added_box_price = Number(jQuery('#added_box_price').text());

		jQuery('#added_box_count_field').val(added_box_count);

		jQuery('#added_box_price_field').val(added_box_price);

		calculation();

		jQuery('.addedboxfield').show();

	});
	jQuery('.selectholder .selectdropdown span').click(function () {
		    jQuery(this).siblings().removeClass('active');
		    jQuery(this).addClass('active');
		    var value = jQuery(this).attr('data-value');
		    if(value=="MM"){
				jQuery('#display_period').val(1);
			}else{
				jQuery('#display_period').val(value);
			}
		    var textval = jQuery(this).text();
			jQuery('#period_data_value').val(textval);
		    // jQuery(this).parent().siblings('select').val(value);
		    jQuery(this).parent().siblings('.desc').fadeOut(100, function () {
		      jQuery('#selectperiod1 option').each(function(){
		            jQuery(this).attr('selected', false);
		            if(jQuery(this).val()==value){
		              	jQuery(this).attr('selected', 'selected');
		            }
		        });
		      jQuery(this).text(textval);
		      jQuery(this).fadeIn(100);
		    });
		// var selectperiod1 = jQuery('#selectperiod1').val();
		// var period_text=  jQuery("#selectperiod1 option:selected").text();
		// //alert(selectperiod1);

		// //alert(period_text);

		// if(selectperiod1=="MM"){
		// 	jQuery('#display_period').val(1);
		// }else{
		// 	jQuery('#display_period').val(selectperiod1);
		// }
		// jQuery('#period_data_value').val(period_text);
		calculation();
	});
	jQuery("#selectpackage").change(function() {
		var selectpackage = jQuery('#selectpackage').val();

		alert(selectpackage);
		var selectpackage_array = selectpackage.split("/");

		var product_id = selectpackage_array[0];
		var product_name = selectpackage_array[1];
		var box_count = selectpackage_array[2];

		jQuery('#product_id').val(product_id);

		jQuery('#product_name_field').val(product_name);

		jQuery('#box_count_field').val(box_count);

		//alert(box_count_field);
		//alert(box_count);
		calculation();

		jQuery('#box_count').text(box_count);

		jQuery('#nestable_dollies_count').text((box_count/4)+" Nestable Dollies");

		jQuery('#labels_count').text(box_count+" Labels");

		jQuery('#zipties_count').text(box_count+" Security Zip Ties");

	});
	jQuery("#add_more_boxes").click(function() {

		jQuery('#add_more_boxes_area').show();

		jQuery('#add_more_boxes').attr("disabled", true);

		jQuery([document.documentElement, document.body]).animate({
	        scrollTop: jQuery("#add_more_boxes_area").offset().top
	    }, 1000);
	});
	function calculation(){
		//alert('function get called');
		/*GET VALUES*/
		var display_period = jQuery('#display_period').val();
		
		var dp_period = jQuery('#dp_period').val();

		var product_name_field = jQuery('#product_name_field').val();

		var box_count_field = Number(jQuery('#box_count_field').val());

		var added_box_count_field = Number(jQuery('#added_box_count_field').val());
		//alert(added_box_count_field);
		var added_box_price_field = Number(jQuery('#added_box_price_field').val());
		//alert(added_box_price_field);
		var product_price_field = Number(jQuery('#product_price_field').val());

		var subtotal_field = Number(jQuery('#subtotal_field').val());

		var delivery_cost_field = Number(jQuery('#delivery_cost_field').val());

		var pickup_cost_field = Number(jQuery('#pickup_cost_field').val());

		var total_price_field = Number(jQuery('#total_price_field').val());

		var tax_rates = Number(jQuery('#tax_rates').val());

		var default_product_cost = Number(jQuery('#default_product_cost').val());

		var period_data_field = jQuery('#period_data_field').val();

		//period_data_field.toLowerCase();
		var period_data_value = jQuery('#period_data_value').val();

		/*CALCULATION*/
		var product_price = (box_count_field*default_product_cost*display_period);

		var added_box_price = (added_box_count_field*default_product_cost*display_period);
		//alert(added_box_price);
		console.log(added_box_price);
		var subtotal = (product_price+added_box_price);
		//alert(subtotal);
		console.log(subtotal);
		var total_price = (subtotal+delivery_cost_field+pickup_cost_field);
		console.log(total_price);
		//alert(total_price);
		var sales_tax = Number(((total_price*tax_rates)/100).toFixed(2));
		console.log(sales_tax);
		//alert(sales_tax);
		total_price = total_price + sales_tax;
		console.log(total_price);
		//alert(total_price);
		/*SET DISPLAY VALUES*/
		jQuery('#product_name').text(product_name_field);
		/**/
		jQuery('#period_data_span').text(period_data_value+" "+period_data_field);

		jQuery('#product_price').text("$"+product_price);

		jQuery('#addedboxprice').text("$"+added_box_price);

		jQuery('#addedboxno').text(added_box_count_field);

		jQuery('#subtotal').text("$"+subtotal);

		jQuery('#sales_tax').text("$"+sales_tax);

		jQuery('#total_price').text("$"+total_price);

		if(delivery_cost_field==0){
			jQuery('#delivery_cost').text("FREE");
		}else{
			jQuery('#delivery_cost').text("$"+delivery_cost_field);
		}
		if(pickup_cost_field==0){
			jQuery('#pickup_cost').text("FREE");
		}else{
			jQuery('#pickup_cost').text("$"+pickup_cost_field);
		}
		
		/*SET HIDDEN VALUES*/
		jQuery('#product_price_field').val(product_price);

		jQuery('#added_box_price_field').val(added_box_price);

		jQuery('#subtotal_field').val(subtotal);

		jQuery('#sales_tax_field').val(sales_tax);

		jQuery('#total_price_field').val(total_price);

	}
	jQuery("#next_order_page").click(function(){

		var product_id = jQuery('#product_id').val();

		var display_period = jQuery('#display_period').val();

		var dp_period = jQuery('#dp_period').val();

		var product_name_field = jQuery('#product_name_field').val();

		var box_count_field = Number(jQuery('#box_count_field').val());

		var added_box_count_field = Number(jQuery('#added_box_count_field').val());
		//alert(added_box_count_field);
		var added_box_price_field = Number(jQuery('#added_box_price_field').val());
		//alert(added_box_price_field);
		var product_price_field = Number(jQuery('#product_price_field').val());

		var subtotal_field = Number(jQuery('#subtotal_field').val());

		var delivery_cost_field = Number(jQuery('#delivery_cost_field').val());

		var pickup_cost_field = Number(jQuery('#pickup_cost_field').val());

		var sales_tax_field = Number(jQuery('#sales_tax_field').val());

		var total_price_field = Number(jQuery('#total_price_field').val());

		var tax_rates = Number(jQuery('#tax_rates').val());

		var period_data_field = Number(jQuery('#period_data_field').val());

		var default_product_cost = Number(jQuery('#default_product_cost').val());

		var period_data_value = jQuery('#period_data_value').val();

		var datastring = "ajax_request=gotonextpage&product_id="+product_id+"&display_period="+display_period+"&dp_period="+dp_period+"&product_name="+product_name_field+"&box_count="+box_count_field+"&added_box_count="+added_box_count_field+"&added_box_price="+added_box_price_field+"&product_price="+product_price_field+"&subtotal="+subtotal_field+"&delivery_cost="+delivery_cost_field+"&pickup_cost="+pickup_cost_field+"&total_price="+total_price_field+"&period_data_value="+period_data_value+"&sales_tax="+sales_tax_field;

		jQuery.ajax({
			url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
			method : "POST",
			data : datastring,
			success: function(result){
			    
			    //var JSONobj = JSON.parse(result);
			    console.log(result);

			    //alert(result);
			    jQuery(location).attr('href', '/rebow/delivery_pickup');
			}
		});

	});
	jQuery('.apartment_level').change(function(){

		var apartment_level_delivery = jQuery('#apartment_level_delivery').val();
					
		var apartment_level_packed = jQuery('#apartment_level_packed').val();

		var apartment_level_packed_delivery = jQuery('#apartment_level_packed_delivery').val();

		var apartment_level_pickup = jQuery('#apartment_level_pickup').val();

		var box_count_field = Number(jQuery('#box_count_field').val());

		var added_box_count_field = Number(jQuery('#added_box_count_field').val());

		var box_count = box_count_field+added_box_count_field;
		//alert(box_count);
		var apartment_level_delivery_cost = get_pickup_delivery_cost(apartment_level_delivery,box_count);
		//alert(apartment_level_delivery_cost);
		var apartment_level_packed_cost = get_pickup_delivery_cost(apartment_level_packed,box_count);
		//alert(apartment_level_packed_cost);
		var apartment_level_packed_delivery_cost = get_pickup_delivery_cost(apartment_level_packed_delivery,box_count);
		//alert(apartment_level_packed_delivery_cost);
		var apartment_level_pickup_cost = get_pickup_delivery_cost(apartment_level_pickup,box_count);
		//alert(apartment_level_pickup_cost);
		var delivery_cost = apartment_level_delivery_cost+apartment_level_packed_delivery_cost;
		//alert("delievry cost : "+delivery_cost);
		var pickup_cost = apartment_level_packed_cost+apartment_level_pickup_cost;
		//1alert("pickup cost : "+pickup_cost);
		jQuery('#delivery_cost_field').val(delivery_cost);

		jQuery('#pickup_cost_field').val(pickup_cost);

		calculation();

		var delivery_cost_field = Number(jQuery('#delivery_cost_field').val());
		jQuery('#delivery_floor_level').text(apartment_level_delivery);

		jQuery('#pickup_floor_level').text(apartment_level_pickup);
		//alert("delivery_cost: "+delivery_cost_field);
		/*if(delivery_cost_field==0){
			jQuery('#deliverycost').hide();
		}else{
			jQuery('#deliverycost').show();
		}*/

		var pickup_cost_field = Number(jQuery('#pickup_cost_field').val());
		//alert("pickup_cost: "+pickup_cost_field);
		/*if(pickup_cost_field==0){
			jQuery('#pickupcost').hide();
		}else{
			jQuery('#pickupcost').show();
		}*/

	});
	function get_pickup_delivery_cost(apartment_level,box_count){
		//alert(box_count);
	    if(apartment_level=="Elevator"){
	        if(box_count<50){
	            var delivery_cost = 25;
	        }else if(box_count>49 && box_count<100){
	            delivery_cost = 50;
	        }
	    }else if(apartment_level=="Stairs"){
	        if(box_count<50){
	            delivery_cost = 50;
	        }else if(box_count>49 && box_count<100){
	            delivery_cost = 100;
	        }
	    }else{
	        delivery_cost = 0;
	    }
	    return delivery_cost;
	}

	
});