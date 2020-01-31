/*<?php
	if( class_exists( 'Mega_Menu' ) && max_mega_menu_is_enabled( 'secondary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'secondary' ) );
	} else {
	?>
		<nav id="navbarsecondary" class="navbar navbar-expand-md navbarsecondary">
			<div class="container">
				<div class="navbar-footer">
					<span class="small-menu-label"><?php esc_html_e( 'Menu', 'di-ecommerce' ); ?></span>
					<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapse-navbarprimary">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
						
				<?php
				wp_nav_menu( array(
					'theme_location'    => 'secondary',
					'depth'             =>  3,
					'container'         => 'div',
					'container_id'      => 'collapse-navbarsecondary',
					'container_class'   => 'collapse navbar-collapse',
					'menu_id' 			=> 'secondary-menu',
					'menu_class'        => 'nav navbar-nav secondary-menu',
					'fallback_cb'       => 'di_ecommerce_nav_fallback',
					'walker'            => new Di_eCommerce_Nav_Menu_Walker()
					));
				?>

			</div>
		</nav>
	<?php
	}
	?>*/