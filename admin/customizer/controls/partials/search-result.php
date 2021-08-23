<?php

function search_result($wp_customize) {
	$wp_customize->add_setting( 'talash_result_heading', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new Talash_Heading_Control( $wp_customize, 'talash_result_heading', 
		array(
			'label'	            => __( 'Search Result', 'talash' ),
			'settings'	        => 'talash_result_heading',
			'section'  	        => 'talash_section',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'searchify-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'talash_result_search_by_color', array(
		'default' 			=> '#9e9e9e',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_result_search_by_color', 
		array(
			'label'      => __( 'Search by Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_result_search_by_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_result_title_color', array(
		'default' 			=> '#5e5e5e',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_result_title_color', 
		array(
			'label'      => __( 'Title Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_result_title_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_result_title_hover_color', array(
		'default' 			=> '#9e9e9e',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_result_title_hover_color', 
		array(
			'label'      => __( 'Title Hover Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_result_title_hover_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_result_author_color', array(
		'default' 			=> '#9e9e9e',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_result_author_color', 
		array(
			'label'      => __( 'Author Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_result_author_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_result_cat_bg_color', array(
		'default' 			=> '#eeeeee',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_result_cat_bg_color', 
		array(
			'label'      => __( 'Category Background Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_result_cat_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'talash_result_cat_color', array(
		'default' 			=> '#9e9e9e',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'talash_result_cat_color', 
		array(
			'label'      => __( 'Category Color', 'talash' ),
			'section'    => 'talash_section',
			'settings'   => 'talash_result_cat_color',
			'priority'   => 2
		) 
	) );
}
