<div class="container-fluid footer-copyright pdt10 pdb10 clearfix">
	<div class="container">	
		<div class="row mrt10">
		
			<div class="col-md-4 cprtlft_ctmzr">
				<?php echo do_shortcode( wp_kses_post( get_theme_mod( 'left_footer_setting', '<p>' . __( 'Site Title, Some rights reserved.', 'di-ecommerce' ) . '</p>' ) ) ); ?>
			</div>
				
			<div class="col-md-4 alignc-spsl cprtcntr_ctmzr">
				<?php echo do_shortcode( wp_kses_post( get_theme_mod( 'center_footer_setting', '<p><a href="#">' . __( 'Terms of Use - Privacy Policy', 'di-ecommerce' ) . '</a></p>' ) ) ); ?>
			</div>
				
			<div class="col-md-4 alignr-spsl cprtright_ctmzr">
				<div class="col-md-6">
				<p class="spsl-fr-topbar-icons iconouter">
				
					
					
					<?php
					// Social link open in new tab or same.
					if( get_theme_mod( 's_link_open', '1' ) == 1 ) {
						$s_link_tab = 'target="_blank"';
					} else {
						$s_link_tab = '';
					}

					if( get_theme_mod( 'display_sicons_top_bar', '1' ) == 1 ) {
						echo "<span class='sicons_ctmzr'>";
						if( get_theme_mod( 'sprofile_link_facebook', 'http://facebook.com' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Facebook', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_facebook', 'http://facebook.com' ) ); ?>"><span class="fa fa-facebook bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_twitter', 'http://twitter.com' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Twitter', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_twitter', 'http://twitter.com' ) ); ?>"><span class="fa fa-twitter bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_youtube', 'http://youtube.com' ) ) {
						?>
							<a title="<?php esc_attr_e( 'YouTube', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_youtube', 'http://youtube.com' ) ); ?>"><span class="fa fa-youtube bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_vk' ) ) {
						?>
							<a title="<?php esc_attr_e( 'VK', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_vk' ) ); ?>"><span class="fa fa-vk bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_okru' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Ok.ru', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_okru' ) ); ?>"><span class="fa fa-odnoklassniki bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_linkedin' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Linkedin', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_linkedin' ) ); ?>"><span class="fa fa-linkedin bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_pinterest' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Pinterest', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_pinterest' ) ); ?>"><span class="fa fa-pinterest-p bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_instagram' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Instagram', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_instagram' ) ); ?>"><span class="fa fa-instagram bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_telegram' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Telegram', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_telegram' ) ); ?>"><span class="fa fa-telegram bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_snapchat' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Snapchat', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_snapchat' ) ); ?>"><span class="fa fa-snapchat bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_flickr' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Flickr', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_flickr' ) ); ?>"><span class="fa fa-flickr bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_reddit' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Reddit', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_reddit' ) ); ?>"><span class="fa fa-reddit bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_tumblr' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Tumblr', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_tumblr' ) ); ?>"><span class="fa fa-tumblr bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_yelp' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Yelp', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_yelp' ) ); ?>"><span class="fa fa-yelp bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_whatsappno' ) ) {
						?>
							<a class="whatsapp-large" title="<?php esc_attr_e( 'WhatsApp', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="https://web.whatsapp.com/send?text=&phone=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>&abid=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>"><span class="fa fa-whatsapp bgtoph-icon-clr"></span></a>

							<a class="whatsapp-small" title="<?php esc_attr_e( 'WhatsApp', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="whatsapp://send?text=&phone=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>&abid=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>"><span class="fa fa-whatsapp bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_skype' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Skype', 'di-ecommerce' ); ?>" <?php echo $s_link_tab; ?> href="skype:<?php echo esc_attr( get_theme_mod( 'sprofile_link_skype' ) ); ?>?add"><span class="fa fa-skype bgtoph-icon-clr"></span></a>
						<?php
						}
						echo "</span>";
					}
					?>

					<?php
					if( get_theme_mod( 'top_bar_seach_icon', '1' ) == 1 ) {
					?>
						<a id="scp-btn-search" title="<?php esc_attr_e( 'Search', 'di-ecommerce' ); ?>" href="javascript:void(0)"><span class="fa fa-search bgtoph-icon-clr"></span></a>
					<?php
					}
					?>
					
				</p>

				<?php
				// Top bar search form container.
				if( get_theme_mod( 'top_bar_seach_icon', '1' ) == 1 ) {
				?>
					<div class="scp-search">
						<button id="scp-btn-search-close" class="scp-btn scp-btn--search-close" aria-label="<?php esc_attr_e( 'Close search form', 'di-ecommerce' ); ?>"><i class="fa fa-close"></i></button>
						<?php get_search_form(); ?>
					</div>
				<?php
				}
				?>

			</div>
			
			</div>
			
		</div>
	</div>
</div>