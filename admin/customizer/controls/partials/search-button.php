<?php 

function search_button($wp_customize) {
	$wp_customize->add_setting( 'talash_button_heading', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new Talash_Heading_Control( $wp_customize, 'talash_button_heading', 
		array(
			'label'	            => __( 'Button', 'talash' ),
			'settings'	        => 'talash_button_heading',
			'section'  	        => 'talash_section',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'talash-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'talash_button_icon_color', array(
		'default' 			=> '#ffd300',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_button_icon_color', 
		array(
			'label'      => __( 'Button Icon Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_button_icon_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_dropdown_button_icon_color', array(
		'default' 			=> '#000000',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_dropdown_button_icon_color', 
		array(
			'label'      => __( 'Dropdown Button Icon Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_dropdown_button_icon_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_button_background_color', array(
		'default' 			=> '#fff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_button_background_color', 
		array(
			'label'      => __( 'Button background Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_button_background_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_button_hover_background_color', array(
		'default' 			=> '#ffdf00',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_button_hover_background_color', 
		array(
			'label'      => __( 'Button Hover Background Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_button_hover_background_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_dropdown_button_background_color', array(
		'default' 			=> '#f2f2f2',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_dropdown_button_background_color', 
		array(
			'label'      => __( 'Dropdown Button background Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_dropdown_button_background_color',
			'priority'   => 2
		)
	) );
}
