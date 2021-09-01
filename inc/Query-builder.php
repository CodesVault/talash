<?php
/**
 * Query Builder main class.
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Query;


class Query_builder {

	private static $self;
	private static $db;
	private static $query_string;
    
    private static function getInstance() {
        if (static::$self === null) {
            static::$self = new Query_builder;
        }

        return static::$self;
    }

	private static function connect() {
		global $wpdb;
		return $wpdb;
	}

	private function query($query, $args = []) {
		$db = static::$db;
		return $db->get_results( $db->prepare( $query, $args ) );
	}

	/**
	 * SELECT statement of mySql query.
	 * 
	 * @param string $column
	 * @param bool $distinct
	 * 
	 * @return object|Exception
	 */
	public static function select($column = '*', $distinct = false) {
		if ( ! $column ) throw new \Exception('Not a valid query.');
		
		static::getInstance();
		static::$db = static::connect();
		if ( $distinct ) {
			static::$query_string = "SELECT DISTINCT {$column}";
			return static::$self;
		}
		static::$query_string = "SELECT {$column}";
		return static::$self;
	}

	public function from($table_name) {
		$table = static::$db->prefix . $table_name;
		$query = static::$query_string;
		static::$query_string = "{$query} FROM {$table}";
		return static::$self;
	}

	public function where($where) {
		$query = static::$query_string;
		static::$query_string = "{$query} WHERE {$where}";
		return $this;
	}

	public function and($condition) {
		$query = static::$query_string;
		static::$query_string = "{$query} AND {$condition}";
		return $this;
	}

	public function in($in) {
		$query = static::$query_string;
		static::$query_string = "{$query} IN({$in})";
		return $this;
	}

	public function or($condition) {
		$query = static::$query_string;
		static::$query_string = "{$query} OR {$condition}";
		return $this;
	}

	public function groupBy($condition) {
		$query = static::$query_string;
		static::$query_string = "{$query} GROUP BY {$condition}";
		return $this;
	}

	public function orderBy($condition) {
		$query = static::$query_string;
		static::$query_string = "{$query} ORDER BY {$condition}";
		return $this;
	}

	public function limit($limit) {
		$query = static::$query_string;
		static::$query_string = "{$query} LIMIT {$limit}";
		return $this;
	}

	public function offset($offset) {
		$query = static::$query_string;
		static::$query_string = "{$query} OFFSET {$offset}";
		return $this;
	}

	public function join($table_name) {
		$query = static::$query_string;
		$prefix = static::$db->prefix;
		static::$query_string = "{$query} JOIN {$prefix}{$table_name}";
		return $this;
	}

	public function on($condition) {
		$query = static::$query_string;
		static::$query_string = "{$query} ON {$condition}";
		return $this;
	}

	public function get($args = []) {
		if ( ! static::$query_string ) throw new \Exception('Not a valid query.');

		// return static::$query_string;
		return $this->query(static::$query_string, $args);
	}
}
