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
		if ( ! is_object( $data ) ) return self::$result = false;

		foreach ( $data as $key => $input_data ) {
			if ( $key == 'talashKey' || $key == 'postType' ) {
				self::string_check( $input_data, $key );
				if ( ! self::$result ) return self::$result = false;
			}
			if ( $key == 'catID' || $key == 'authorID' ) {
				self::number_check( $input_data, $key );
				if ( ! self::$result ) return self::$result = false;
			} 
			if ( $key == 'dateRangeStart' || $key == 'dateRangeEnd' ) {
				self::date_check( $input_data, $key );
				if ( ! self::$result ) return self::$result = false;
			}
		}

		if ( empty( self::$result ) ) {
			return false;
		}
		return self::$result;
	}

	private static function string_check($value, $key) {
		if ( ! $value && ! is_string( $value ) ) {
			return self::$result = false;
		} 
		return self::$result[$key] = sanitize_text_field( $value );
	}

	private static function number_check($value, $key) {
		if ( ! $value && ! is_string( $value ) ) {
			return self::$result = false;
		}

		$IDs = sanitize_text_field($value);
		if ( $IDs != '' ) {
			$arr_ids = [];
			$ids = explode(', ', $IDs);
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

	private static function date_check($value, $key) {
		$date = sanitize_text_field( $value );
		if ( ! self::date_validator( $date ) ) return self::$result = false;

		return self::$result[$key] = $value;
	}
}
