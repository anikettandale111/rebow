<?php
/* Template Name: custom_login*/
?>
<html>
    <head>
        <link rel='icon' href="/rebow/wp-content/themes/di-ecommerce-child/assets/images/favicon.ico" />
    </head>
    <body>
        <?php 
        global $user_ID;
        global $wpdb;

        get_header();
        //echo "Referrer URL: ".
        $referer_url = wp_get_referer();
        ?>
        <section class="login">
            <div class="container">
                <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-7 col-md-auto col-lg-5 mb-5">
                    <h1 class="text-center mb-5">Log In</h1> 
                    <?php if(strpos($referer_url,'resetpass')!==FALSE){
                        echo "<p> Your password has been reset. You can log in below :</p>";
                    }?>
                    <div class="login-container grey-bg">
                        <form id="wp_login_form" action="" method="POST">
                            <div class="form-group">
                                <input type="email" name="user-login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">

                            </div>
                            <div class="form-group">
                                <input type="password" name="user-pass" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                <p id="error_block"></p>
                            </div>
                            
                            <button type="submit" id="submitBtn" class="btn btn-secondary my-3 p-10"><b>Log In</b></button>
                            <div class="clearfix"></div>
                            
                            <p>Forgot <a class="log-link" href="/rebow/forgot-password/">Password ?</a></p>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <?php get_footer();?>
        <script>
            jQuery(function(){
                var ajax_url = "<?php echo admin_url('admin-ajax.php');?>";
                var url = "<?php echo wp_get_referer();?>"; 
                //alert(url); 
                jQuery('#submitBtn').on("click",function(event){
                    event.preventDefault();
                    var formData = jQuery('#wp_login_form').serialize();
                    formData += "&action=custom_login&param=login_test&redirect_url="+url;
                    //console.log(formData);
                    
                    jQuery.ajax({
                        url: ajax_url,
                        data: formData,
                        type:"POST",
                        success:function(response){

                            var jsonOBJ = JSON.parse(response);
                            console.log(jsonOBJ);
                            if(jsonOBJ.status==0){
                                jQuery('#error_block').text(jsonOBJ.error);
                                
                            }else{
                                console.log(jsonOBJ.redirect_url);
                                jQuery(location).attr('href',jsonOBJ.redirect_url);
                            }
                        }
                    });
                });

            });
        </script>
    </body>
</html>