<?php
/**
 * Customizer controls for Background Section
 */

$wp_customize->add_section(
	'logincust_templates',
	array(
		'priority' => 0,
		'title' => __( 'Templates', 'login-customizer' ),
		'panel'  => 'logincust_panel',
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_templates_control]',
	array(
		'default' => 'original',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'logincust_sanitize_options',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Radio_Images_Control(
		$wp_customize,
		'login_customizer_options[logincust_templates_control]',
		array(
			'label' => __( 'Templates', 'login-customizer' ),
			'section' => 'logincust_templates',
			'priority' => 5,
			'settings' => 'login_customizer_options[logincust_templates_control]',
			'choices' => array(
				'original' => LOGINCUST_FREE_URL . 'assets/templates/original.png',
				'dark' => LOGINCUST_FREE_URL . 'assets/templates/dark.png',
				'material' => LOGINCUST_FREE_URL . 'assets/templates/material.png',
			),
		)
	)
);
