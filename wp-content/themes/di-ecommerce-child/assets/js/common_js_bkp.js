// JavaScript Document

jQuery(document).ready(function () {
  // body...
  jQuery("ul.price-tabs li").click(function () {
    var priceTab = jQuery(this).index();
    jQuery(".price-pkg").eq(priceTab).show().siblings(".price-pkg").hide();
    jQuery(this).addClass('sel').siblings().removeClass('sel');
  }).eq(0).click();

  jQuery("ul.rt-strg li").click(function () {
    jQuery(this).addClass("act").siblings().removeClass("act");
    var rentalStorage = jQuery(this).index();
    jQuery("aside.rntl-strg").eq(rentalStorage).show().siblings("aside.rntl-strg").hide();

  }).eq(0).click();



  jQuery('.selectholder').each(function () {
    jQuery(this).children().hide();
    var description = jQuery(this).children('label').text();
    //alert(description);
    var selected_value = jQuery(this).children('select').val();
    //console.log(selected_value);
    text = jQuery(this).children('select').find('option:selected').text();
    //alert(text);
    //console.log(text);
    if(selected_value){
      jQuery(this).append('<span class="desc">' + text + '</span>');
    }else{
      jQuery(this).append('<span class="desc">' + description + '</span>');
    }
    
    jQuery(this).append('<span class="pulldown"></span>');
    // set up dropdown element
    jQuery(this).append('<div class="selectdropdown"></div>');
    jQuery(this).children('select').children('option').each(function () {
      if(jQuery(this).attr('value') != '0') {
        //alert(11);
        jQuerydrop = jQuery(this).parent().siblings('.selectdropdown');
        var name1 = jQuery(this).text();
        var name = jQuery(this).attr('value');
        if(selected_value==name){
          jQuerydrop.append('<span class="active" value='+name+'>' + name1 + '</span>');
        }else{
          jQuerydrop.append('<span value='+name+'>' + name1 + '</span>');
        }
      }
    });
    // on click, show dropdown
    jQuery(this).click(function () {
      
      if (jQuery(this).hasClass('activeselectholder')) {
        // roll up roll up
        jQuery(this).children('.selectdropdown').slideUp(200);
        jQuery(this).removeClass('activeselectholder');
        // change span back to selected option text
        if (jQuery(this).children('select').val() != '0') {
          jQuery(this).children('.desc').fadeOut(100, function () {
            //alert(12);

            text = jQuery(this).siblings('select').find('option:selected').text();
            
            value = jQuery(this).siblings("select").val();

            console.log(text);
            //text = jQuery(this).siblings('#month option:selected');
            //alert(value);
            //console.log(text);
            jQuery(this).text(text);
            jQuery(this).fadeIn(100);
          });
        }
      } else {
        // if there are any other open dropdowns, close 'em
        jQuery('.activeselectholder').each(function () {
          jQuery(this).children('.selectdropdown').slideUp(200);
          // change span back to selected option text
          if (jQuery(this).children('select').val() != '0') {
            jQuery(this).children('.desc').fadeOut(100, function () {
              //alert(1);
              jQuery(this).text(jQuery(this).siblings("select").val());
              jQuery(this).fadeIn(100);
            });
          }
          jQuery(this).removeClass('activeselectholder');
        });
        // roll down
        jQuery(this).children('.selectdropdown').slideDown(200);
        jQuery(this).addClass('activeselectholder');
        // change span to show select box title while open
        if (jQuery(this).children('select').val() != '0') {
          jQuery(this).children('.desc').fadeOut(100, function () {
            //alert(2);
            jQuery(this).text(jQuery(this).siblings("select").children("option[value=0]").text());
            jQuery(this).fadeIn(100);
          });
        }
      }
    });
  });
  // select dropdown click action
  jQuery('.selectholder .selectdropdown span').click(function () {
    jQuery(this).siblings().removeClass('active');
    jQuery(this).addClass('active');
    var value = jQuery(this).attr('value');
    //alert(value);
    var value1 = jQuery(this).text();
    //alert(value1);
    jQuery(this).parent().siblings('select').val(value);
    jQuery(this).parent().siblings('.desc').fadeOut(100, function () {
     // alert(4);
      jQuery(this).text(value1);
      jQuery(this).fadeIn(100);
    });
  });
	
// FAq Accordiaon
    jQuery(".acord h4").click(function() {
        jQuery(this).next(".ans").slideDown().siblings(".ans").slideUp();
        jQuery(this).addClass("active").siblings().removeClass("active");
    }).eq(0).click();

  /*jQuery(function() {
   jQuery(".navbar-nav li").click(function() {
      // remove classes from all
      jQuery(".navbar-nav li").removeClass("active");
      // add class to the one we clicked
      jQuery(this).addClass("active");
   });
  });*/
});
