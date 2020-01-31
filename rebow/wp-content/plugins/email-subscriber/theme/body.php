<?php

function kento_email_subscriber_table_body($postid)
	{
		
					

			$kento_email_subscriber_themes = get_post_meta( $postid, 'kento_email_subscriber_themes', true );

		
		if($kento_email_subscriber_themes=="one")
			{
			$var ='
				<div class="subscribe_theme_one">
				<span class="kento_email_subscriber_close"></span>
					<div class="subscribe_main">
						<div class="subscribe_form_option">
							<h4 class="subscribe_text">Email</h4>
							<input class="subscribe_email" type="email" placeholder="Type Email Address" name="email" />
							<h4 class="subscribe_text">Name</h4>
							<input class="subscribe_name" type="name" placeholder="Type Your Name" name="name"/>
							<span class="subscribe-status"> </span>
							<span class="subscribe-status-email"> </span>
							<span class="subscribe-status-name"> </span>
							<input type="button" class="subscribe_submit" value="JOIN" />
						</div>
					</div>
				</div>';

				
				}

		elseif($kento_email_subscriber_themes=="two")
			{
		$var ='<div class="subscribe_theme_two">
		<span class="kento_email_subscriber_close"></span>
	<div class="subscribe_main">
		<h4 class="text_style">Name</h4><input class="subscribe_name" type="name" placeholder="Enter Your Full Name" name="name" />				
		<h4 class="text_style">Email</h4><input class="subscribe_email" type="email" placeholder="Enter Your Email Address" name="email"/>
		
				<span class="subscribe-status"> </span>
				<span class="subscribe-status-email"> </span>
				<span class="subscribe-status-name"> </span>
		<input class="subscribe_submit" type="button" value="JOIN"/>
						
	</div>
</div>	';
				}
		elseif($kento_email_subscriber_themes=="three")
			{
		$var ='<div class="subscribe_thme_three">
		<span class="kento_email_subscriber_close"></span>
			<div class="subscribe_main">
				<div class="subscribe_form_option">
					<input class="subscribe_name" type="hidden" placeholder="Type Your Name" name="name" value="no name" />
					<input  class="subscribe_email" type="email" name="email" placeholder="Leaver Your Email For Happiness" /> 
				</div>
				<input class="subscribe_submit" type="button" value="JOIN"/>	
			</div>
			
<div class="" style="margin: 30px auto 0; text-align: center;">
				<span class="subscribe-status"> </span>
				<span class="subscribe-status-email"> </span>
				<span class="subscribe-status-name"> </span>
</div>
			
			
			
		</div>';
				}
				
		elseif($kento_email_subscriber_themes=="four")
			{
		$var ='		<div class="subscribe_theme_four">
		<span class="kento_email_subscriber_close"></span>
		<div class="subscribe_main">
			<input class="subscribe_name" type="hidden" placeholder="Type Your Name" name="name" value="no name"/>			
			<input class="subscribe_email" type="email" placeholder="Enter Your E-mail" name="email"/>
			<input type="button" value="GO" class="subscribe_submit"/>
				<span class="subscribe-status"> </span>
				<span class="subscribe-status-email"> </span>
				<span class="subscribe-status-name"> </span>
			
		</div>
	</div>	';
				}				
				
		elseif($kento_email_subscriber_themes=="five")
			{
		$var ='	<div class="subscribe_theme_five">
		<span class="kento_email_subscriber_close"></span>
		<div class="subscribe_main">
			<div class="subscribe_email_option">
			<input class="subscribe_name" type="hidden" placeholder="Type Your Name" name="name" value="no name"/>
			<input class="subscribe_email" type="email" placeholder="Enter Your E-mail" value="" name="email"/>
			<input type="button" value="GO" class="subscribe_submit"/>
				<span class="subscribe-status"> </span>
				<span class="subscribe-status-email"> </span>
				<span class="subscribe-status-name"> </span>
				
			</div>
		</div>
	</div>';
				}

		elseif($kento_email_subscriber_themes=="six")
			{
		$var ='<div class="subscribe_theme_six">
		<span class="kento_email_subscriber_close"></span>
			<div class="subscribe_main">
				<div class="subscribe_main_another">
					<input class="subscribe_name" type="hidden" placeholder="Type Your Name" name="name" value="no name"/>
					<input class="subscribe_email" type="email" placeholder="Enter Your E-mail" name="email"/>
					<input type="button" class="subscribe_submit" value="SUBMIT"/>
				</div>
				
				<span class="subscribe-status"> </span>
				<span class="subscribe-status-email"> </span>
				<span class="subscribe-status-name"> </span>
				
			</div>
		</div>';
				}
		else
			{ //if themes missing
			$var ='<div class="subscribe_theme_one">
			<span class="kento_email_subscriber_close"></span>
		<div class="subscribe_main">
			<div class="subscribe_form_option">
				<h4 class="subscribe_text">Email</h4>
				<input class="subscribe_email" type="email" placeholder="Type Email Address" name="email" />
				<h4 class="subscribe_text">Name</h4>
				<input class="subscribe_name" type="name" placeholder="Type Your Name" name="name"/>	
				<input type="button" class="subscribe_submit" value="JOIN" />
			</div>
		</div>
	</div>		
			
			';
				}
				
				
		return $var;

	}



?>