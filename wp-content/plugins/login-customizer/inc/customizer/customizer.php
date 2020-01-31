<?php
/**
 * Customizer controls for Login Customizer
 */

// Range Slider Control
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/controls/range-slider/range-slider-control.php' );
// Toggle Control
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/controls/toggle/toggle-control.php' );
// Padding/Margin Control
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/controls/padding/padding-control.php' );
// Alpha Color Control
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/controls/alpha/alpha-control.php' );
// Radio Images Control
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/controls/radio-images/radio-images-control.php' );
// Sanitizer Functions
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sanitizers.php' );
// Enqueue CSS & JS for Login page
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/custom-code.php' );
// Functions to change login page
require_once( LOGINCUST_FREE_PATH . 'inc/customizer/functions.php' );

/**
 * Register login customizer settings
 */
function logincust_customize_register( $wp_customize ) {

	// Login Customizer Panel
	$wp_customize->add_panel(
		'logincust_panel',
		array(
			'priority'       => 30,
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Login Customizer', 'login-customizer' ),
			'description'    => __( 'This section allows you to customize the login page of your website. Made with ❤ by <a target="_blank" rel="nofollow" href="http://www.hardeepasrani.com">HardeepAsrani</a> team.', 'login-customizer' ),
		)
	);

	// Section #0: Templates
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-templates.php' );

	// Section #1: Background
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-background.php' );

	// Section #2: Logo
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-logo.php' );

	// Section #3: Form
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-form.php' );

	// Section #5: Fields
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-fields.php' );

	// Section #6: Button
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-button.php' );

	// Section #7: Other
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-other.php' );

	// Section #8: Custom CSS & JS
	require_once( LOGINCUST_FREE_PATH . 'inc/customizer/sections/section-code.php' );

}
add_action( 'customize_register', 'logincust_customize_register' );

/**
 * Enqueue script to Customizer
 */
function logincust_customizer_script() {
	// Enqueue script to Customizer
	wp_enqueue_script( 'logincust_control_js', LOGINCUST_FREE_URL . 'inc/customizer/js/customizer.js', array( 'jquery' ), null, true );

	// Generate the redirect url.
	$options = get_option( 'login_customizer_settings', array() );

	$localize = array(
		'page' => get_permalink( $options['page'] ),
		'url' => LOGINCUST_FREE_URL,
	);

	// Localize Script
	wp_localize_script( 'logincust_control_js', 'logincust_script', $localize );
}
add_action( 'customize_controls_print_scripts', 'logincust_customizer_script' );

/**
 * Enqueeu script to Customizer Preview
 */
function logincust_customizer_preview_script() {
	// Enqueeu script to Customizer Preview
	wp_enqueue_script( 'logincust_control_preview', LOGINCUST_FREE_URL . 'inc/customizer/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), null, true );

	// Generate the redirect url.
	$options = get_option( 'login_customizer_settings', array() );

	$localize = array(
		'page' => get_permalink( $options['page'] ),
	);

	// Localize Script
	wp_localize_script( 'logincust_control_preview', 'logincust_script', $localize );
}
add_action( 'customize_preview_init', 'logincust_customizer_preview_script' );
