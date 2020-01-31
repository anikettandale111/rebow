<?php
/* Template Name: forgot_password*/
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
        <section class="login">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-sm-12 col-md-7 col-md-auto mb-3">
                <h1 class="text-center mb-5">Forgot Password ? </h1>
              </div>
            </div>
            <div class="row justify-content-md-center mb-7">
              <div class="col-md-6 grey-bg p-5 mb-5 fg-psw">
                <p class="text-center pb-3">Please enter the email you used when placing your order & we will send you password reset instructions :</p>
                <div class="form-container">
                  <form id="forgot-password-form" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                      <p id="error_block"></p>
                    </div>
                    
                    <button id="forgot-password" type="submit" class="btn btn-secondary my-3"><b>Submit</b></button>
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
        <div id="Modalforgot" class="modal fade bd-example-modal-lg4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content text-center">
              <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-center pb-5 px-5">
                <p id="msg" class="txt-grey">Email has been sent to your registered Email ID.</p>

                <button id="forgotok" type="submit" class="btn btn-secondary">OK</button>
              </div>
              
            </div>
          </div>
        </div>
        <?php get_footer();?>
        <script>
            jQuery(function(){
                var ajax_url = "<?php echo admin_url('admin-ajax.php');?>";
                  
                jQuery('#forgot-password').on("click",function(event){
                    event.preventDefault();
                    //var formData = jQuery('#forgot-password-form').serialize();
                    var user_email = jQuery('#exampleInputEmail1').val();
                    var formData= "&action=lost_password&param=forgotpwd&user_email="+user_email;
                    //console.log(formData);
                    
                    jQuery.ajax({
                        url: ajax_url,
                        data: formData,
                        type:"POST",
                        success:function(response){
                            console.log(response);
                            var jsonOBJ = JSON.parse(response);
                            if(jsonOBJ.status==0){
                              jQuery('#error_block').text("Invalid Email. Please try again.");
                              //jQuery('#error-block').show();
                            }else{
                                jQuery('#Modalforgot').modal('show');
                            }
                        }
                    });
                });

            });
        </script>
  </body>
</html>