<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! function_exists( 'searchify_sanitize_integer' ) ) {
	function searchify_sanitize_integer( $input ) {
		return absint( $input );
	}
}

if ( ! function_exists( 'searchify_sanitize_float' ) ) {
	function searchify_sanitize_float( $input ) {
		return filter_var( $input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	}
}


if ( ! function_exists( 'searchify_sanitize_choices' ) ) {
	function searchify_sanitize_choices( $input, $setting ) {

		// Ensure input is a slug
		$input = sanitize_key( $input );

		// Get list of choices from the control
		// associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it;
		// otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'searchify_sanitize_checkbox' ) ) {
	function searchify_sanitize_checkbox( $input ) {
		if ( $input ) {
			$output = '1';
		} else {
			$output = false;
		}
		return $output;
	}
}

if ( ! function_exists( 'searchify_sanitize_rgba' ) ) {
	function searchify_sanitize_rgba( $color ) {
		if ( empty( $color ) || is_array( $color ) )
			return 'rgba(0,0,0,0)';

		// If string does not start with 'rgba', then treat as hex
		// sanitize the hex color and finally convert hex to rgba
		if ( false === strpos( $color, 'rgba' ) ) {
			return sanitize_hex_color( $color );
		}

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	}
}

if ( ! function_exists( 'searchify_sanitize_select' ) ) {
	function searchify_sanitize_select( $input, $setting ){
			
		//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key($input);

		//get the list of possible select options 
		$choices = $setting->manager->get_control( $setting->id )->choices;
							
		//return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
			
	}
}
