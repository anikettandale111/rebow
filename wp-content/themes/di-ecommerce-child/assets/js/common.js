// JavaScript Document

jQuery(document).ready(function ($) {
  // body...
  //$('.selectpicker').selectpicker();
  jQuery('.testexample').DataTable();
  $("ul.price-tabs li").click(function () {
    var priceTab = $(this).index();
    $(".price-pkg").eq(priceTab).show().siblings(".price-pkg").hide();
    $(this).addClass('sel').siblings().removeClass('sel');
  }).eq(0).click();

  $("ul.rt-strg li").click(function () {
    $(this).addClass("act").siblings().removeClass("act");
    var rentalStorage = $(this).index();
    $("aside.rntl-strg").eq(rentalStorage).show().siblings("aside.rntl-strg").hide();

  }).eq(0).click();

  $('.selectholder').each(function () {
    $(this).children().hide();
    var description = $(this).children('label').text();
    $(this).append('<span class="desc">' + description + '</span>');
    $(this).append('<span class="pulldown"></span>');
    // set up dropdown element
    $(this).append('<div class="selectdropdown"></div>');
    $(this).children('select').children('option').each(function () {
      if ($(this).attr('value') != '0') {
        $drop = $(this).parent().siblings('.selectdropdown');
        var name = $(this).attr('data-content');
        var value = $(this).val();
        $drop.append('<span data-value='+value+'>' + name + '</span>');
      }
    });
    // on click, show dropdown
    $(this).click(function () {
      if ($(this).hasClass('activeselectholder')) {
        // roll up roll up
        $(this).children('.selectdropdown').slideUp(200);
        $(this).removeClass('activeselectholder');
        // change span back to selected option text
        if ($(this).children('select').val() != '0') {
          $(this).children('.desc').fadeOut(100, function () {
            // $(this).text($(this).siblings("select").val());
            $(this).attr('selected', 'selected');
            $(this).fadeIn(100);
          });
        }
      } else {
        // if there are any other open dropdowns, close 'em
        $('.activeselectholder').each(function () {
          $(this).children('.selectdropdown').slideUp(200);
          // change span back to selected option text
          if ($(this).children('select').val() != '0') {
            $(this).children('.desc').fadeOut(100, function () {
              // $(this).text($(this).siblings("select").val());
            $(this).attr('selected', 'selected');
              $(this).fadeIn(100);
            });
          }
          $(this).removeClass('activeselectholder');
        });
        // roll down
        $(this).children('.selectdropdown').slideDown(200);
        $(this).addClass('activeselectholder');
        // change span to show select box title while open
        if ($(this).children('select').val() != '0') {
          $(this).children('.desc').fadeOut(100, function () {
            $(this).text($(this).siblings("select").children("option[value=0]").text());
            $(this).fadeIn(100);
          });
        }
      }
    });
  });
  // select dropdown click action
  // $('.selectholder .selectdropdown span').click(function () {
  //   $(this).siblings().removeClass('active');
  //   $(this).addClass('active');
  //   var value = $(this).attr('data-value');
  //   var textval = $(this).text();
  //   // $(this).parent().siblings('select').val(value);
  //   $(this).parent().siblings('.desc').fadeOut(100, function () {
  //     $('#selectperiod1 option').each(function(){
  //           $(this).attr('selected', false);
  //           if($(this).val()==value){
  //             $(this).attr('selected', 'selected');
  //           }
  //       });
  //     $(this).text(textval);
  //     $(this).fadeIn(100);
  //   });
  // });
	
// FAq Accordiaon
    $(".acord h4").click(function() {
        $(this).next(".ans").slideDown().siblings(".ans").slideUp();
        $(this).addClass("active").siblings().removeClass("active");
    });

    // date piker
});

  function deletecoupon(rowid){
    if(confirm('Are you sure to delete this coupon ?')){
      jQuery.post( "../wp-admin/test-plugin-api.php", { ajax_request: 'delete_coupon',rowid: rowid })
        .done(function( data ) {
            jQuery('#resp_message').css('display','block');
            jQuery('#resp_message').text(data);
        setTimeout(function() {
            jQuery('#resp_message').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
        jQuery('#row_id_'+rowid).remove();
      });
    }
  }
    function deletepacakge(packageid){
    if(confirm('Are you sure to delete this pacakge ?')){
      jQuery.post( "../wp-admin/test-plugin-api.php", { ajax_request: 'delete_pacakge',packageid: packageid })
        .done(function( data ) {
            jQuery('#resp_message').css('display','block');
            jQuery('#resp_message').text(data);
        setTimeout(function() {
            jQuery('#resp_message').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
        jQuery('#row_id_'+packageid).remove();
      });
    }
  }