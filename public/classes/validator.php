<?php
/**
 * Form data validation.
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\View;

class Validator {

	private static $result = [];

	public static function check_validation($data) {
		if ( ! is_object( $data ) ) return false;

		foreach ( $data as $key => $input_data ) {
			if ( $input_data === null || ! is_string( $input_data ) ) {
				return false;
			}

			if ( $key == 'talashKey' || $key == 'postType' ) {
				self::string_check( $input_data, $key );
				if ( ! self::$result ) return false;
			}
			if ( $key == 'catID' || $key == 'authorID' ) {
				self::number_check( $input_data, $key );
				if ( ! self::$result ) return false;
			} 
			if ( $key == 'dateRangeStart' || $key == 'dateRangeEnd' ) {
				self::date_check( $input_data, $key );
				if ( ! self::$result ) return false;
			}
		}

		if ( empty( self::$result ) ) {
			return false;
		}
		return (object)self::$result;
	}

	private static function string_check($string, $key) {
		if ( $string != '' ) {
			if ( $key == 'postType' ) {
				$string_arr = [];
				$strings = explode( ', ', $string );
	
				foreach ( $strings as $str ) {
					if ( ! is_string($str) ) return self::$result = false;
					array_push( $string_arr, $str );
				}
				return self::$result[$key] = implode( ', ', $string_arr );
			} else return self::$result[$key] = $string;
		} else self::$result[$key] = '';
	}

	private static function number_check($number, $key) {
		if ( $number != '' ) {
			$arr_ids = [];
			$ids = explode(', ', $number);
			foreach ( $ids as $id ) {
				if ( ! intval($id) ) return self::$result = false;
				array_push($arr_ids, intval($id));
			}
			return self::$result[$key] = implode( ', ', $arr_ids );
		} else self::$result[$key] = '';
	}

	private static function date_validator($date) {
		$format = 'Y-m-d H:i:s';

		$d = \DateTime::createFromFormat($format, $date);
    	return $d && $d->format($format) == $date;
	}

	private static function date_check($date, $key) {
		if ( ! self::date_validator( $date ) ) {
			return self::$result = false;
		}

		return self::$result[$key] = $date;
	}

	public static function data_sanitization($data, $options) {
		$args = [];
		foreach ( $options as $option ) {
			$args[$option] = FILTER_SANITIZE_STRING;
		}
		return (object)filter_var_array( $data,  $args);
	}
}
