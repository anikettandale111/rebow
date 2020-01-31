<?php
/**
 * Custom sanitizers for Customizer controls
 */

/**
 * Sanitizer for Options Control
 */
function logincust_sanitize_options( $input, $setting ) {
	// global wp_customize
	global $wp_customize;

	// Get control ID
	$control = $wp_customize->get_control( $setting->id );

	// Check if option exists in choice array
	if ( array_key_exists( $input, $control->choices ) ) {
		// If it does, return the value
		return $input;
	} else {
		// Else, return default value
		return $setting->default;
	}
}

/**
 * Sanitizer for Background Position Control
 */
function logincust_sanitize_position( $input, $setting ) {
	// Check if value is one of the positions
	if ( in_array( $input, array(  'top', 'bottom', 'left', 'right', 'center' ), true ) ) {
		// If it does, return the value
		return $input;
	} else {
		// Else, return default value
		return $setting->default;
	}
}
