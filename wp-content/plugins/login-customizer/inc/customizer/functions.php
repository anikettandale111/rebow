<?php
/**
 * Functions to customize login page
 */

// Get plugin options array
$options = get_option( 'login_customizer_options' );

/**
 * Change login logo URL
 */
function logincust_login_logo_url() {
	// Return logo link option
	global $options;
	return $options['logincust_logo_link'];
}

// Hook to login_headerurl
if ( ! empty( $options['logincust_logo_link'] ) ) {
	add_filter( 'login_headerurl', 'logincust_login_logo_url', 99 );
}

/**
 * Change login logo title attribute
 */
function logincust_login_logo_url_title() {
	// Get blog title
	$title = get_bloginfo( 'name', 'display' );

	// Return blog title
	return $title;
}

// Hook to login_headertitle
add_filter( 'login_headertitle', 'logincust_login_logo_url_title' );

/**
 * Remove register link
 */
function logincust_no_register_link( $url ) {
	return '';
}

// Hook to register and login_link_separator
if ( ! is_customize_preview() ) {
	if ( ! empty( $options['logincust_field_register_link'] ) && $options['logincust_field_register_link'] === 1 ) {
		add_filter( 'register', 'logincust_no_register_link' );
		add_filter( 'login_link_separator', 'logincust_no_register_link' );
	}
	if ( ! empty( $options['logincust_field_lost_password'] ) && $options['logincust_field_lost_password'] === 1 ) {
		add_filter( 'login_link_separator', 'logincust_no_register_link' );
	}
}
