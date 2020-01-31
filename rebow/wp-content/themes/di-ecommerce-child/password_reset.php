<?php
/* Template Name: password_reset*/
?>
<html>
    <head>
      <link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
    </head>
    <body>
        <?php 
        global $user_ID;
        global $wpdb;

        get_header();?>
        
        <?php 
          if(empty($_REQUEST['key'])){
            //$_REQUEST['key'];


          }else{

            $rp_key =  wp_unslash($_REQUEST['key']);

            $rp_login =  wp_unslash($_REQUEST['login']);

            $user = check_password_reset_key( $rp_key, $rp_login );
            //print_r($user);

            if ( ! $user || is_wp_error( $user ) ) {
              if ( $user && $user->get_error_code() === 'expired_key' ) {
                 echo "The key has been expired.";
                //wp_redirect( site_url( 'wp-login.php?action=lostpassword&error=expiredkey' ) );
              } else {
                echo $user->get_error_code();
                //wp_redirect( site_url( 'wp-login.php?action=lostpassword&error=invalidkey' ) );
              }
              exit;
            }

            //check_password_reset_key();
          }
        ?>
        <?php if($user->id){?>
        <section class="login">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-sm-12 col-md-7 col-md-auto mb-3">
                <h1 class="text-center mb-5">Password Reset </h1>
              </div>
            </div>

            <div class="row justify-content-md-center mb-7">
              <div class="col-md-auto grey-bg p-5 mb-5 fg-psw">
                <p class="text-center pb-3">Please enter a new password below. Password must<br/> contain one capital letter and one numeric character :</p>
                <div class="form-container">
                  <form id="password_reset_form" method="POST">
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" placeholder="New Password" pattern="^(.*[0-9].*[A-Z].*)|(.*[A-Z].*[0-9].*)$">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirm Password" pattern="^(.*[0-9].*[A-Z].*)|(.*[A-Z].*[0-9].*)$">
                      <p id="errors"></p>
                    </div>
                    <p id="errors"></p>
                    <button id="reset-pass" type="submit" class="btn btn-secondary my-3">Submit</button>
                    <div class="clearfix"></div>
                    </form>
                </div>
              </div>
              <div class="col-md-auto text-center">
                <p>If you are still experiencing problems accessing your account please reach out to us at :<br/> <a class="link" href="mailto:info@rebowsystem.com"> info@rebowsystem.com</a> or call us at : <strong>323 - 277 - 1111</strong></p>
              </div>
            </div>
          </div>
        </section>
        <?php }?>
        <?php get_footer();?>
        <script>
            jQuery(function(){
                var ajax_url = "<?php echo admin_url('admin-ajax.php');?>";
                  
                jQuery('#password_reset_form').submit(function(event){
                    //alert(123);
                    event.preventDefault();
                    //var password = jQuery('#forgot-password-form').serialize();
                    var password1 = jQuery('#exampleInputPassword1').val();
                    var password2 = jQuery('#exampleInputPassword2').val();
                    var user_email = "<?php echo $_REQUEST['login'];?>";
                    var formData = "action=password_reset&param=reset_pass&password1="+password1+"&password2="+password2+"&user_email="+user_email;
                    //console.log(formData);
                    
                    jQuery.ajax({
                        url: ajax_url,
                        data: formData,
                        type:"POST",
                        success:function(response){
                            console.log(response);
                            var jsonobj = JSON.parse(response);
                            if(jsonobj.status==1){
                              alert('Your password has been changed');
                              jQuery(location).attr('href','/rebow/login/');
                            }else{
                              jQuery('#errors').text("Passwords not Matching.");
                            }
                        }
                    });
                });

            });
        </script>
  </body>
</html>