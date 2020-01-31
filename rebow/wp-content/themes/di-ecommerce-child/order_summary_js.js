jQuery(document).ready(function() {
	jQuery("#add_box_count").change(function() {
		//alert(1);
		var added_box_count = jQuery('#add_box_count').val();
		
		var display_period = jQuery('#display_period').val();
		
		var default_product_cost = jQuery('#default_product_cost').val();
		
		var added_box_price = (added_box_count*default_product_cost*display_period);

		jQuery('#added_box_price').text(added_box_price);
		jQuery('#added_box_price_field').val(added_box_price);
		//calculation();

	});
	jQuery('#add_more_boxes785').click(function(){
		var added_box_count = jQuery('#add_box_count').val();

		var added_box_price = Number(jQuery('#added_box_price').text());

		jQuery('#added_box_count_field').val(added_box_count);

		jQuery('#added_box_price_field').val(added_box_price);

		calculation();

		jQuery('#addedboxesfield').show();

	});
	jQuery("#selectperiod1").change(function() {
		var selectperiod1 = jQuery('#selectperiod1').val();

		jQuery('#display_period').val(selectperiod1);

		calculation();

	});
	jQuery("#selectpackage").change(function() {
		var selectpackage = jQuery('#selectpackage').val();
		var selectpackage_array = selectpackage.split("/");

		var product_id = selectpackage_array[0];
		var product_name = selectpackage_array[1];
		var box_count = selectpackage_array[2];

		jQuery('#product_id').val(product_id);

		jQuery('#product_name_field').val(product_name);

		jQuery('#box_count_field').val(box_count);

		calculation();

		jQuery('#nestable_dollies_count').val(box_count/4);

		jQuery('#labels_count').val(box_count);

		jQuery('#zipties_count').val(box_count);

	});
	jQuery("#add_more_boxes").click(function() {
		jQuery('#add_more_boxes_area').show();

		jQuery('#add_more_boxes').attr("disabled", true);
	});
	function calculation(){
		alert('function get called');
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


		/*CALCULATION*/
		var product_price = (box_count_field*default_product_cost*display_period);

		var added_box_price = (added_box_count_field*default_product_cost*display_period);
		//alert(added_box_price);
		var subtotal = (product_price+added_box_price);
		//alert(subtotal);
		var total_price = (subtotal+delivery_cost_field+pickup_cost_field);
		//alert(total_price);
		var sales_tax = (total_price*tax_rates)/100;
		//alert(sales_tax);
		total_price = total_price + sales_tax;
		//alert(total_price);
		/*SET DISPLAY VALUES*/

		jQuery('#product_name').text(product_name_field);

		jQuery('#price_text').text(display_period+" "+dp_period+" : "+product_price);

		jQuery('#addedboxprice').text(added_box_price);

		jQuery('#addedboxno').text(added_box_count_field);

		jQuery('#subtotal').text(subtotal);

		jQuery('#sales_tax').text(sales_tax);

		jQuery('#total_price').text(total_price);

		jQuery('#delivery_cost').text(delivery_cost_field);

		jQuery('#pickup_cost').text(pickup_cost_field);

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

		var total_price_field = Number(jQuery('#total_price_field').val());

		var tax_rates = Number(jQuery('#tax_rates').val());

		var default_product_cost = Number(jQuery('#default_product_cost').val());

		var datastring = "ajax_request=gotonextpage&product_id="+product_id+"&display_period="+display_period+"&dp_period="+dp_period+"&product_name="+product_name_field+"&box_count="+box_count_field+"&added_box_count="+added_box_count_field+"&added_box_price="+added_box_price_field+"&product_price="+product_price_field+"&subtotal="+subtotal_field+"&delivery_cost="+delivery_cost_field+"&pickup_cost="+pickup_cost_field+"&total_price="+total_price_field;

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

});