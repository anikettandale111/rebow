<?php
/**
 * Customizer controls for Logo Section
 */

$wp_customize->add_section(
	'logincust_logo_section',
	array(
		'priority' => 10,
		'title' => __( 'Logo', 'login-customizer' ),
		'panel'  => 'logincust_panel',
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_logo_show]',
	array(
		'default' => false,
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize,
		'login_customizer_options[logincust_logo_show]',
		array(
			'label' => __( 'Disable Logo?', 'login-customizer' ),
			'section' => 'logincust_logo_section',
			'priority' => 5,
			'settings' => 'login_customizer_options[logincust_logo_show]',
		)
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_logo]',
	array(
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'login_customizer_options[logincust_logo]',
		array(
			'label' => __( 'Logo', 'login-customizer' ),
			'section' => 'logincust_logo_section',
			'priority' => 10,
			'settings' => 'login_customizer_options[logincust_logo]',
		)
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_logo_width]',
	array(
		'default' => '84px',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_html',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Range_Slider_Control(
		$wp_customize,
		'login_customizer_options[logincust_logo_width]',
		array(
			'label' => __( 'Logo Width', 'login-customizer' ),
			'section' => 'logincust_logo_section',
			'priority' => 15,
			'settings' => 'login_customizer_options[logincust_logo_width]',
			'choices' => array(
				'percent' => true,
			),
			'input_attrs' => array(
				'min'    => 0,
				'max'    => 1000,
				'step'   => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_logo_height]',
	array(
		'default' => '84px',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_html',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Range_Slider_Control(
		$wp_customize,
		'login_customizer_options[logincust_logo_height]',
		array(
			'label' => __( 'Logo Height', 'login-customizer' ),
			'section' => 'logincust_logo_section',
			'priority' => 20,
			'settings' => 'login_customizer_options[logincust_logo_height]',
			'choices' => array(
				'percent' => true,
			),
			'input_attrs' => array(
				'min'    => 0,
				'max'    => 1000,
				'step'   => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_logo_padding]',
	array(
		'default' => '5px',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_html',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Range_Slider_Control(
		$wp_customize,
		'login_customizer_options[logincust_logo_padding]',
		array(
			'label' => __( 'Padding Bottom', 'login-customizer' ),
			'section' => 'logincust_logo_section',
			'priority' => 25,
			'settings' => 'login_customizer_options[logincust_logo_padding]',
			'choices' => array(
				'percent' => true,
			),
			'input_attrs' => array(
				'min'    => 0,
				'max'    => 1000,
				'step'   => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'login_customizer_options[logincust_logo_link]',
	array(
		'default' => 'https://wordpress.org/',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'login_customizer_options[logincust_logo_link]',
	array(
		'label' => __( 'Logo URL', 'login-customizer' ),
		'description' => __( 'The page where your logo will take you.', 'login-customizer' ),
		'section' => 'logincust_logo_section',
		'priority' => 30,
		'settings' => 'login_customizer_options[logincust_logo_link]',
	)
);
