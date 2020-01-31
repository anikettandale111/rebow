<?php
/**
 * Customizer controls for More Cool Stuff Section
 */

$wp_customize->add_section(
	'logincust_more_section', array(
		'priority' => 40,
		'title' => __( 'More Cool Stuff', 'login-customizer' ),
		'panel'  => 'logincust_panel',
	)
);

$wp_customize->add_setting(
	'latte_required_info', array(
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control(
	new Logincust_Cool_Stuff_Control(
		$wp_customize, 'latte_required_info', array(
			'section' => 'logincust_more_section',
		)
	)
);
