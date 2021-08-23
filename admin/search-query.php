<?php
/**
 * The DB queries for search results.
 *
 * @link       https://abmsourav.com/
 *
 * @package    searchify
 * @author     sourav926 
 */
namespace Talash\Admin;


class Searchify_Query {

	private static function searchify_query($query, $args) {
		global $wpdb;
	
		$results = $wpdb->get_results( $wpdb->prepare( $query, $args ) );
		return $results;
	}

	private static function set_search_key($key, $args) {
		global $wpdb;

		$key = $wpdb->esc_like( $key );
		if ( $key ) {
			$key_args = [
				$key . '%',
				'%' . $key . '%',
				'%' . $key,
				$key . '%',
				'%' . $key . '%',
				'%' . $key
			];
			return array_merge($args, $key_args);
		}
		return $args;
	}

	public static function search_by_postType($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'status' => 'publish',
			'start_date' => $searchify_data->dateRangeStart,
			'end_date' => $searchify_data->dateRangeEnd
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);
		$post_type = explode(', ', $searchify_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				WHERE posts.post_status = %s
					AND posts.post_type IN($post_type)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				WHERE posts.post_status = %s
					AND posts.post_type IN($post_type)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		return $data;
	}

	public static function search_by_cat($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, terms.name as cat_name
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN($searchify_data->catID)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, terms.name as cat_name
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN($searchify_data->catID)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		return $data;
	}

	public static function search_by_author($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				WHERE posts.post_status = %s
					AND posts.post_author IN($searchify_data->authorID)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				WHERE posts.post_status = %s
					AND posts.post_author IN($searchify_data->authorID)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		return $data;
	}

	private static function add_cats_in_query_result($data, $searchify_data) {
		global $wpdb;

		$post_id = [];
		foreach ( $data as $post ) {
			array_push( $post_id, $post->ID );
		}
		$post_id = "'" . implode("','", $post_id) . "'";
		$cat_ids = explode(', ', $searchify_data->catID);

		$cats = self::searchify_query(
			"SELECT posts.ID, terms.term_id, terms.name
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			INNER JOIN {$wpdb->prefix}terms terms
				ON term_rel.term_taxonomy_id = terms.term_id
			INNER JOIN {$wpdb->prefix}term_taxonomy term_tax
				ON term_tax.term_id = terms.term_id
			WHERE posts.ID IN($post_id)
				AND	posts.post_status = %s
				AND term_tax.taxonomy != %s
				AND terms.name NOT lIKE '%exclude%'",
			[ 'publish', 'post_tag' ],
			[]
		);
		if ( is_wp_error( $cats ) ) {
			return $data;
		}

		foreach ( $data as $post ) {
			foreach ( $cats as $cat ) {
				if ( $post->ID == $cat->ID && ! isset( $post->cat_name ) ) {
					foreach ( $cat_ids as $id ) {
						if ( $cat->term_id == $id ) {
							$post->cat_name = $cat->name;
						}
					}
				}
			}
		}
		return $data;
	}

	public static function search_by_postType_cat($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);
		$post_type = explode(', ', $searchify_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN ($searchify_data->catID)
					AND posts.post_type IN ($post_type)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN ($searchify_data->catID)
					AND posts.post_type IN ($post_type)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}
		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$data = self::add_cats_in_query_result($data, $searchify_data);
		
		return $data;
	}

	public static function search_by_postType_author($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);
		$post_type = explode(', ', $searchify_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				WHERE posts.post_status = %s
					AND posts.post_type IN ($post_type)
					AND posts.post_author IN ($searchify_data->authorID)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				WHERE posts.post_status = %s
					AND posts.post_type IN ($post_type)
					AND posts.post_author IN ($searchify_data->authorID)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		return $data;
	}

	public static function search_by_cat_author($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN ($searchify_data->catID)
					AND posts.post_author IN ($searchify_data->authorID)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN ($searchify_data->catID)
					AND posts.post_author IN ($searchify_data->authorID)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}
		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$data = self::add_cats_in_query_result($data, $searchify_data);

		return $data;
	}

	public static function search_by_postType_cat_author($searchify_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd,
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);
		$post_type = explode(', ', $searchify_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $searchify_data->searchifySearch ) {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN ($searchify_data->catID)
					AND posts.post_type IN ($post_type)
					AND posts.post_author IN ($searchify_data->authorID)
					AND posts.post_date between %s and %s
					AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
						OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
				ORDER BY posts.post_date DESC",
				$args
			);
		} else {
			$data = self::searchify_query(
				"SELECT DISTINCT posts.ID, posts.post_title, posts.post_author
				FROM {$wpdb->prefix}posts posts
				INNER JOIN {$wpdb->prefix}term_relationships term_rel
					ON term_rel.object_id = posts.ID
				INNER JOIN {$wpdb->prefix}terms terms
					ON terms.term_id = term_rel.term_taxonomy_id
				WHERE posts.post_status = %s
					AND term_rel.term_taxonomy_id IN ($searchify_data->catID)
					AND posts.post_type IN ($post_type)
					AND posts.post_author IN ($searchify_data->authorID)
					AND posts.post_date between %s and %s
				ORDER BY posts.post_date DESC",
				$args
			);
		}
		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$data = self::add_cats_in_query_result($data, $searchify_data);

		return $data;
	}

	public static function search_by_keyword($searchify_data) {
		global $wpdb;

		$args = [
			'publish',
			$searchify_data->dateRangeStart,
			$searchify_data->dateRangeEnd,
		];
		$args = self::set_search_key($searchify_data->searchifySearch, $args);

		$data = self::searchify_query(
			"SELECT posts.ID, posts.post_title
			FROM {$wpdb->prefix}posts posts
			WHERE posts.post_status = %s
				AND posts.post_date between %s and %s
				AND ((posts.post_title LIKE %s OR posts.post_title LIKE %s OR posts.post_title LIKE %s)
					OR (posts.post_content LIKE %s OR posts.post_content LIKE %s OR posts.post_content LIKE %s))
			ORDER BY posts.post_date DESC",
			$args
		);

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		return $data;
	}

	public static function searchify_search_query($searchify_data) {
		$data = '';
		if ( $searchify_data->postType && $searchify_data->catID == '' && $searchify_data->authorID == '' ) {
			// only postTypes
			$data = self::search_by_postType($searchify_data);
		} elseif ( $searchify_data->postType == '' && $searchify_data->catID && $searchify_data->authorID == '' ) {
			// only categories
			$data = self::search_by_cat($searchify_data);
		} elseif ( $searchify_data->postType == '' && $searchify_data->catID == '' && $searchify_data->authorID ) {
			// only authors
			$data = self::search_by_author($searchify_data);
		} elseif ( $searchify_data->postType && $searchify_data->catID && $searchify_data->authorID == '' ) {
			// postTypes, categories
			$data = self::search_by_postType_cat($searchify_data);
		} elseif ( $searchify_data->postType && $searchify_data->catID == '' && $searchify_data->authorID ) {
			// postTypes, authors
			$data = self::search_by_postType_author($searchify_data);
		} elseif ( $searchify_data->postType == '' && $searchify_data->catID && $searchify_data->authorID ) {
			// categories, authors
			$data = self::search_by_cat_author($searchify_data);
		} elseif ( $searchify_data->postType && $searchify_data->catID && $searchify_data->authorID ) {
			// postTypes, categories, authors
			$data = self::search_by_postType_cat_author($searchify_data);
		} elseif ( $searchify_data->searchifySearch && $searchify_data->postType == '' && $searchify_data->catID == '' && $searchify_data->authorID == '' ) {
			// only keyword
			$data = self::search_by_keyword($searchify_data);
		}

		return $data;
	}

}
