<?php

function input_field($wp_customize) {
	$wp_customize->add_setting( 'searchify_input_heading', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new Talash_Heading_Control( $wp_customize, 'searchify_input_heading', 
		array(
			'label'	            => __( 'Input', 'talash' ),
			'settings'	        => 'searchify_input_heading',
			'section'  	        => 'talash_section',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'talash-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'searchify_input_background_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'searchify_input_background_color', 
		array(
			'label'      => __( 'Input background Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'searchify_input_background_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'searchify_dropdown_input_background_color', array(
		'default' 			=> '#f2f2f2',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'searchify_dropdown_input_background_color', 
		array(
			'label'      => __( 'Dropdown Input background Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'searchify_dropdown_input_background_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'searchify_input_color', array(
		'default' 			=> '#545454',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'searchify_input_color', 
		array(
			'label'      => __( 'Input Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'searchify_input_color',
			'priority'   => 2
		) 
	) );
}
