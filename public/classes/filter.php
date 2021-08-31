<?php
/**
 * Form data validation, sanitization.
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\View;

use Talash\Facade\Facade;

class Filter extends Facade {
	private static $self;
    
    protected static function getInstance()
    {
        if (static::$self === null) {
            static::$self = new Filter;
        }

        return static::$self;
    }

	private $result = [];

	protected function check_validation($data) {
		if ( ! is_object( $data ) ) return false;

		foreach ( $data as $key => $input_data ) {
			if ( $input_data === null || ! is_string( $input_data ) ) {
				return false;
			}

			if ( $key == 'talashKey' || $key == 'postType' ) {
				$this->string_check( $input_data, $key );
				if ( ! $this->result ) return false;
			}
			if ( $key == 'catID' || $key == 'authorID' ) {
				$this->number_check( $input_data, $key );
				if ( ! $this->result ) return false;
			} 
			if ( $key == 'dateRangeStart' || $key == 'dateRangeEnd' ) {
				$this->date_check( $input_data, $key );
				if ( ! $this->result ) return false;
			}
		}

		if ( empty( $this->result ) ) {
			return false;
		}
		return (object)$this->result;
	}

	private function string_check($string, $key) {
		if ( $string != '' ) {
			if ( $key == 'postType' ) {
				$string_arr = [];
				$strings = explode( ', ', $string );
	
				foreach ( $strings as $str ) {
					if ( ! is_string($str) ) return $this->result = false;
					array_push( $string_arr, $str );
				}
				return $this->result[$key] = implode( ', ', $string_arr );
			} else return $this->result[$key] = $string;
		} else $this->result[$key] = '';
	}

	private function number_check($number, $key) {
		if ( $number != '' ) {
			$arr_ids = [];
			$ids = explode(', ', $number);
			foreach ( $ids as $id ) {
				if ( ! intval($id) ) return $this->result = false;
				array_push($arr_ids, intval($id));
			}
			return $this->result[$key] = implode( ', ', $arr_ids );
		} else $this->result[$key] = '';
	}

	private function date_validator($date) {
		$format = 'Y-m-j H:i:s';

		$d = \DateTime::createFromFormat($format, $date);
    	return $d && $d->format($format) == $date;
	}

	private function date_check($date, $key) {
		if ( ! $this->date_validator( $date ) ) {
			return $this->result = false;
		}

		return $this->result[$key] = $date;
	}

	protected function data_sanitization($data, $options) {
		$args = [];
		foreach ( $options as $option ) {
			$args[$option] = FILTER_SANITIZE_STRING;
		}
		return (object)filter_var_array( $data,  $args);
	}
}
