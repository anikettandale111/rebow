
jQuery(document).ready(function($) {
	jQuery('#user_login').attr('placeholder', 'Email');
	jQuery('#user_pass').attr('placeholder', 'Password');
	//alert('loaded');
	var hostname = location.hostname;
	//alert(hostname);

	jQuery( "#logo_img" ).click(function() {
      jQuery(location).attr('href', '/rebow/');
    });

    jQuery( "#got_it" ).click(function() {
      //jQuery(location).attr('href', '#');
     	jQuery('#exampleModalCenter').modal('hide');

    });
	//var hostname = location.hostname;
  	jQuery( "#order_now" ).click(function() {
      jQuery(location).attr('href', 'http://'+hostname+'/rebow/pricing/');
    });
    jQuery( ".get_started" ).click(function() {
      //alert('clicked');
      jQuery(location).attr('href', 'http://'+hostname+'/rebow/pricing/');
    });
    jQuery("#subscribeok").click(function() {

		//jQuery(location).attr('href', '#');
		jQuery('#ModalSubscribe').modal('hide');
		
	});
	jQuery("#forgotok").click(function() {

		//jQuery(location).attr('href', '#');
		jQuery('#Modalforgot').modal('hide');
		
	});
	jQuery("#subscribeok1").click(function() {

		//jQuery(location).attr('href', '#');
		jQuery('#ModalSubscribe1').modal('hide');
		
	});
	jQuery("#subscribeok2").click(function() {

		//jQuery(location).attr('href', '#');
		jQuery('#ModalSubscribe2').modal('hide');
		
	});
	jQuery("#contact").click(function() {
      
      jQuery(location).attr('href', '/rebow/contact/');

    });
    jQuery("#continue").click(function() {

      //jQuery(location).attr('href', '#');
      jQuery('#service_yes').modal('hide');
      
    });
    jQuery("#cancel").click(function() {
      
      //jQuery(location).attr('href', '#');
      jQuery('#service_no').modal('hide');

      
    });
    jQuery("#checkzips1").click(function(){
      //alert("Checking");
      var zip_current = jQuery('input[placeholder="Zipcode of Current Address*"]').val();
      console.log('zip_current : '+zip_current);
      var zip_new = jQuery('input[placeholder="Zipcode of New Address*"]').val();
      console.log('zip_new : '+zip_new);

        jsonString="ajax_request=zipcheck2&zip_current="+zip_current+"&zip_new="+zip_new+"&alert=1";
          jQuery.ajax({
              type: "POST",
              url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
              data: jsonString,
              //dataType: "html",
              success: function(result) {
            jQuery('input[placeholder="Zipcode of Current Address*"]').val('');

            jQuery('input[placeholder="Zipcode of New Address*"]').val('');
                window.console.log('Successful');
                console.log("result"+result);
                var json_obj = JSON.parse(result);
                //alert(json_obj.alert);
                if(json_obj.match==1){

                  jQuery('#service_yes').modal('show');
                }else{
                  jQuery('#service_no').modal('show');

                }
              }
          });
    });
	jQuery("#subscribebutton").click(function(){
		var email_id = jQuery('#subscribe_email').val();
		console.log('Email: '+email_id);
		//alert(email_id);
		var Emailcheck = isEmail(email_id);
		console.log(Emailcheck);
		//console.log('Submitted');
		if(email_id==""){
			//alert("Email Validated");
			//alert("Please Enter Email ID");
			jQuery('#ModalSubscribe1').modal('show');
		}else if(Emailcheck==true){
			//alert("Email Validated");
			jsonString="ajax_request=subscribemail&email_id="+email_id;
		  	jQuery.ajax({
		        type: "POST",
		        url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
		        data: jsonString,
		        success: function(result) {
		        	//alert(result);
		        	jQuery('input[type="email"]').val('');
		        	//alert('Successfully Subscribed');
		        	jQuery('#ModalSubscribe').modal('show');
		            //window.console.log('Successful');

		        }
		    });
			//alert("You have Subscribed successfully");
			//jQuery('.bd-example-modal-lg2').show();	
		}else {
			//alert("Please enter correct email ID");
			jQuery('#ModalSubscribe2').modal('show');
		}
	  	//alert("You have Subscribed successfully");


	});
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	jQuery("#checkzips").click(function(){
		//alert("Checking");
		var zip_current = jQuery('input[placeholder="Zipcode of Current Address*"]').val();
		console.log('zip_current : '+zip_current);
		var zip_new = jQuery('input[placeholder="Zipcode of New Address*"]').val();
		console.log('zip_new : '+zip_new);

			jsonString="ajax_request=zipcheck&zip_current="+zip_current+"&zip_new="+zip_new+"&alert=1";
		  	jQuery.ajax({
		        type: "POST",
		        url: "/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
		        data: jsonString,
		        //dataType: "html",
		        success: function(result) {
					jQuery('input[placeholder="Zipcode of Current Address*"]').val('');

					jQuery('input[placeholder="Zipcode of New Address*"]').val('');
		            window.console.log('Successful');
		            console.log("result"+result);
		            var json_obj = JSON.parse(result);
		            //alert(json_obj.alert);
		            if(json_obj.alert==1){

			            $.confirm({
			            	title: 'Service',
			            	content: json_obj.msg
			            });
		        	}
		        }
		    });
	});
	
	jQuery("#contactForm").submit(function(e) {

	    e.preventDefault(); // avoid to execute the actual submit of the form.

	    var form = $(this);
	    var url = form.attr('action');

    	var fullName = jQuery('#FullName').val();
		console.log('fullName : '+fullName);
		var email = jQuery('#InputEmail').val();
		console.log('email : '+email);
		var phonenumber = jQuery('#phonenumber').val();
		console.log('phonenumber : '+phonenumber);
		var plength = phonenumber.length;
		var needhelp = jQuery('#needhelp').val();
		console.log('needhelp : '+needhelp);
		var message = jQuery('#message').val();
		console.log('message : '+message);
		//alert(message);
		var sendAjax= true;
		var Emailcheck = isEmail(email);
		console.log(Emailcheck);
		if(fullName==""){
			//alert("Please enter Full Name");
			var sendAjax= false;
		}else if(email==""|| Emailcheck==false){
			alert("Please Enter proper Email ID");
			var sendAjax= false;
		}
		if(phonenumber!=""){
			if(plength<10){
				//alert("Please Enter proper Phone Number");
				var sendAjax= false;
			}
		}
		
		//alert(sendAjax);
		jsonString="ajax_request=contact_submit&fullName="+fullName+"&email="+email+"&phonenumber="+phonenumber+"&needhelp="+needhelp+"&message="+message;
		//alert(jsonString);
		if(sendAjax==true){
		  	jQuery.ajax({
		        type: "POST",
		        url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
		        data: jsonString,
		        //dataType: "html",
		        success: function(result) {
		            console.log('Successful');
		            //alert('Successful');

		            jQuery('#CNFORM').hide();
					jQuery('#contactmsg').show();
		            ///console.log("result : "+result);
		            //console.log('Successful1');
		            //console.log("result1"+result.);
		            
		        }
		    });
		}
	});



	jQuery("#contact_submit1").click(function(){
		//alert("contact_submit");
		var fullName = jQuery('#FullName').val();
		console.log('fullName : '+fullName);
		var email = jQuery('#InputEmail').val();
		console.log('email : '+email);
		var phonenumber = jQuery('#phonenumber').val();
		console.log('phonenumber : '+phonenumber);
		var needhelp = jQuery('#needhelp').val();
		console.log('needhelp : '+needhelp);
		var message = jQuery('#message').val();
		console.log('message : '+message);
		//alert(message);
		var sendAjax= true;
		var Emailcheck = isEmail(email);
		console.log(Emailcheck);
		if(fullName==""){
			alert("Please enter Full Name");
			var sendAjax= false;
		}else if(email==""|| Emailcheck==false){
			alert("Please Enter proper Email ID");
			var sendAjax= false;
		}else if(phonenumber==""){
			alert("Please enter Phone Number");
			var sendAjax= false;
		}
		//alert(sendAjax);
		jsonString="ajax_request=contact_submit&fullName="+fullName+"&email="+email+"&phonenumber="+phonenumber+"&needhelp="+needhelp+"&message="+message;
		//alert(jsonString);
		if(sendAjax==true){
		  	jQuery.ajax({
		        type: "POST",
		        url: "http://"+hostname+"/rebow/wp-content/themes/di-ecommerce-child/api-php.php",
		        data: jsonString,
		        //dataType: "html",
		        success: function(result) {
		            console.log('Successful');
		            console.log("result : "+result);
		            //console.log('Successful1');
		            //console.log("result1"+result.);
		            
		        }
		    });
		}
	});
});
