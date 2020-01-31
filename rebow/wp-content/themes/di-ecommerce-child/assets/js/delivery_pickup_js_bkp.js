jQuery('#delivery_date').change(function() {
	    //var date = $(this).val();
	    var delivery_date = jQuery('#delivery_date').val();

		var display_period = jQuery('#display_period').val();

		var period_data_field = jQuery('#period_data_field').val();
		//alert(delivery_date);
		if(period_data_field=="RENTAL"){
			var days_to_add = (display_period*7);
		}else{
			var days_to_add = 2;
		}
		var someDate = new Date(delivery_date);
		someDate.setDate(someDate.getDate() + days_to_add); //number  of days to add, e.x. 15 days
		var next_pickup_date = someDate.toISOString().substr(0,10);

		if(period_data_field=="RENTAL"){
			//jQuery("#pick_up_boxes").show();
			jQuery("#pickup_date").text(next_pickup_date);
		}else{
			//jQuery("#pick_up_packed_boxes").show();
			jQuery("#pickup_date_packed").text(next_pickup_date);
		}

	});
	jQuery("#delivery_box_submit").submit(function(event) {
		event.preventDefault();
		//alert('form submitted');
		jQuery('#continue_delivery').hide();
		var delivery_date = jQuery('#delivery_date').val();

		var display_period = jQuery('#display_period').val();

		var period_data_field = jQuery('#period_data_field').val();
		//alert(delivery_date);
		
		if(period_data_field=="RENTAL"){
			jQuery("#pick_up_boxes").show();
			jQuery("#pickup_date").text(next_pickup_date);
		}else{
			jQuery("#pick_up_packed_boxes").show();
			jQuery("#pickup_date_packed").text(next_pickup_date);
		}

	});

	jQuery("#delivery_box_submit").submit(function(event) {
		event.preventDefault();
		//alert('form submitted');
		jQuery('#continue_delivery').hide();
		var delivery_date = jQuery('#delivery_date').val();

		var display_period = jQuery('#display_period').val();

		var period_data_field = jQuery('#period_data_field').val();
		//alert(delivery_date);
		
		if(period_data_field=="RENTAL"){
			jQuery("#pick_up_boxes").show();
			
		}else{
			jQuery("#pick_up_packed_boxes").show();
			
		}

	});
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

    jQuery( "#pick_up_packed_boxes_submit" ).submit(function(event) {

		event.preventDefault();
		//alert('form submitted');
		jQuery('#continue_pickup_packed_boxes').hide();
		
		var display_period = jQuery('#display_period').val();

		var period_data_field = jQuery('#period_data_field').val();
		if(period_data_field=="RENTAL"){
			jQuery("#pick_up_boxes").show();
			
		}else{
			jQuery("#delivery_packed_boxes").show();
			
		}
	});

	jQuery( "#delivery_packed_boxes_submit" ).submit(function(event) {

		event.preventDefault();
		//alert('form submitted');
		jQuery('#continue_delivery_packed_boxes').hide();
		
		var display_period = jQuery('#display_period').val();

		var period_data_field = jQuery('#period_data_field').val();
		if(period_data_field=="RENTAL"){
			//jQuery("#pick_up_boxes").show();
			
		}else{
			jQuery("#pick_up_boxes").show();
			
		}
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


		var product_id = jQuery('#product_id').val();

		var display_period = jQuery('#display_period').val();

		var dp_period = jQuery('#dp_period').val();

		var product_name_field = jQuery('#product_name_field').val();

		var box_count_field = Number(jQuery('#box_count_field').val());

		var added_box_count_field = Number(jQuery('#added_box_count_field').val());
		
		var added_box_price_field = Number(jQuery('#added_box_price_field').val());
		
		var product_price_field = Number(jQuery('#product_price_field').val());

		var subtotal_field = Number(jQuery('#subtotal_field').val());

		var delivery_cost_field = Number(jQuery('#delivery_cost_field').val());

		var pickup_cost_field = Number(jQuery('#pickup_cost_field').val());

		var total_price_field = Number(jQuery('#total_price_field').val());


			
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

			datastring = "ajax_request=goto_personal_info_page&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&apartment_level_delivery="+apartment_level_delivery+"&pickup_date="+pickup_date+"&preferred_pickup_time="+preferred_pickup_time+"&alternate_pickup_time="+alternate_pickup_time+"&pickup_address="+pickup_address+"&apt_unit_pickup="+apt_unit_pickup+"&apartment_level_pickup="+apartment_level_pickup+"&pickup_date_packed="+pickup_date_packed+"&preferred_pickup_time_packed="+preferred_pickup_time_packed+"&alternate_pickup_time_packed="+alternate_pickup_time_packed+"&pickup_address_packed="+pickup_address_packed+"&apt_unit_pickup_packed="+apt_unit_pickup_packed+"&apartment_level_packed="+apartment_level_packed+"&selectaddress="+selectaddress+"&delivery_address_packed="+delivery_address_packed+"&apt_unit_delivery_packed="+apt_unit_delivery_packed+"&apartment_level_packed_delivery="+apartment_level_packed_delivery+"&product_id="+product_id+"&display_period="+display_period+"&dp_period="+dp_period+"&product_name="+product_name_field+"&box_count="+box_count_field+"&added_box_count="+added_box_count_field+"&added_box_price="+added_box_price_field+"&product_price="+product_price_field+"&subtotal="+subtotal_field+"&delivery_cost="+delivery_cost_field+"&pickup_cost="+pickup_cost_field+"&total_price="+total_price_field;
		}else{
			datastring = "ajax_request=goto_personal_info_page&delivery_date="+delivery_date+"&preferred_delivery_time="+preferred_delivery_time+"&alternate_delivery_time="+alternate_delivery_time+"&delivery_address="+delivery_address+"&apt_unit_delivery="+apt_unit_delivery+"&apartment_level_delivery="+apartment_level_delivery+"&pickup_date="+pickup_date+"&preferred_pickup_time="+preferred_pickup_time+"&alternate_pickup_time="+alternate_pickup_time+"&pickup_address="+pickup_address+"&apt_unit_pickup="+apt_unit_pickup+"&apartment_level_pickup="+apartment_level_pickup+"&product_id="+product_id+"&display_period="+display_period+"&dp_period="+dp_period+"&product_name="+product_name_field+"&box_count="+box_count_field+"&added_box_count="+added_box_count_field+"&added_box_price="+added_box_price_field+"&product_price="+product_price_field+"&subtotal="+subtotal_field+"&delivery_cost="+delivery_cost_field+"&pickup_cost="+pickup_cost_field+"&total_price="+total_price_field;
		}
		//var datastring2 = datastring.concat(datastring1);
		
		//var period = jQuery('#period').val();

	    //alert(datastring);
	    //console.log(datastring);
		jQuery.ajax({
			url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
			method : "POST",
			data : datastring,
			success: function(result){
			    
			    //var JSONobj = JSON.parse(result);
			    console.log(result);

			    //alert(result);
			    jQuery(location).attr('href', '/rebow/personal-information');
			}
		});


	});