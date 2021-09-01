<?php
/**
 * The DB queries for search results.
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Admin;

use Talash\Query\Query_builder;


class Talash_Query {

	private static function talash_query($query, $args) {
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

	public static function search_by_postType($search_data) {
		$data = [];
		$args = [
			'status' => 'publish',
			'start_date' => $search_data->dateRangeStart,
			'end_date' => $search_data->dateRangeEnd
		];
		$args = self::set_search_key($search_data->talashKey, $args);
		$post_type = explode(', ', $search_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author")
				->from("posts as posts")
				->where("posts.post_status = %s")
					->and("posts.post_type")
						->in($post_type)
					->and("posts.post_date")
						->between("%s and %s")
					->and("((posts.post_title LIKE %s")
						->or("posts.post_title LIKE %s")
						->or("posts.post_title LIKE %s)")
					->or("(posts.post_content LIKE %s")
						->or("posts.post_content LIKE %s")
						->or("posts.post_content LIKE %s))")
				->orderBy("posts.post_date DESC")
				->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author")
				->from("posts as posts")
				->where("posts.post_status = %s")
					->and("posts.post_type")
						->in($post_type)
					->and("posts.post_date")
						->between("%s and %s")
				->orderBy("posts.post_date DESC")
				->get($args);
		}

		if ( is_wp_error( $data ) ) {
			return null;
		}

		return $data;
	}

	public static function search_by_cat($search_data) {
		$data = [];
		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd
		];
		$args = self::set_search_key($search_data->talashKey, $args);

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title")
				->from("posts as posts")
				->join("term_relationships as term_rel")
					->on("term_rel.object_id = posts.ID")
				->join("terms as terms")
					->on("terms.term_id = term_rel.term_taxonomy_id")
				->where("posts.post_status = %s")
					->and("term_rel.term_taxonomy_id")
						->in($search_data->catID)
					->and("posts.post_date")
						->between("%s and %s")
					->and("((posts.post_title LIKE %s")
						->or("posts.post_title LIKE %s")
						->or("posts.post_title LIKE %s)")
					->or("(posts.post_content LIKE %s")
						->or("posts.post_content LIKE %s")
						->or("posts.post_content LIKE %s))")
				->orderBy("posts.post_date DESC")
				->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title")
				->from("posts as posts")
				->join("term_relationships as term_rel")
					->on("term_rel.object_id = posts.ID")
				->join("terms as terms")
					->on("terms.term_id = term_rel.term_taxonomy_id")
				->where("posts.post_status = %s")
					->and("term_rel.term_taxonomy_id")
						->in($search_data->catID)
					->and("posts.post_date")
						->between("%s and %s")
				->orderBy("posts.post_date DESC")
				->get($args);
		}
		if ( is_wp_error( $data ) ) {
			return null;
		}

		$data = self::add_cats_in_query_result($data, $search_data);
		return $data;
	}

	public static function search_by_author($search_data) {
		$data = [];
		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd
		];
		$args = self::set_search_key($search_data->talashKey, $args);

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
				->from("posts as posts")
				->where("posts.post_status = %s")
					->and("posts.post_author")
						->in($search_data->authorID)
					->and("posts.post_date")
						->between("%s and %s")
					->and("((posts.post_title LIKE %s")
						->or("posts.post_title LIKE %s")
						->or("posts.post_title LIKE %s)")
					->or("(posts.post_content LIKE %s")
						->or("posts.post_content LIKE %s")
						->or("posts.post_content LIKE %s))")
					->orderBy("posts.post_date DESC")
					->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author")
				->from("posts as posts")
				->where("posts.post_status = %s")
					->and("posts.post_author")
						->in($search_data->authorID)
					->and("posts.post_date")
						->between("%s and %s")
				->orderBy("posts.post_date DESC")
				->get($args);
		}

		if ( is_wp_error( $data ) ) {
			return null;
		}

		return $data;
	}

	private static function add_cats_in_query_result($data, $search_data) {
		$post_id = [];
		foreach ( $data as $post ) {
			array_push( $post_id, $post->ID );
		}
		$post_id = "'" . implode("','", $post_id) . "'";
		$cat_ids = explode(', ', $search_data->catID);

		$cats = Query_builder::select("posts.ID, terms.term_id, terms.name")
					->from("posts as posts")
					->join("term_relationships term_rel")
						->on("posts.ID = term_rel.object_id")
					->join("terms as terms")
						->on("term_rel.term_taxonomy_id = terms.term_id")
					->join("term_taxonomy as term_tax")
						->on("term_tax.term_id = terms.term_id")
					->where("posts.ID")
						->in($post_id)
						->and("posts.post_status = %s")
						->and("term_tax.taxonomy != %s")
						->and("terms.name NOT lIKE '%exclude%'")
					->get([ 'publish', 'post_tag' ]);

		if ( is_wp_error( $cats ) ) {
			return null;
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

	public static function search_by_postType_cat($search_data) {
		$data = [];
		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd
		];
		$args = self::set_search_key($search_data->talashKey, $args);
		$post_type = explode(', ', $search_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title", true)
						->from("posts as posts")
						->join("term_relationships as term_rel")
							->on("term_rel.object_id = posts.ID")
						->where("posts.post_status = %s")
							->and("term_rel.term_taxonomy_id")
								->in($search_data->catID)
							->and("posts.post_type")
								->in($post_type)
							->and("posts.post_date")
								->between("%s and %s")
							->and("((posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s)")
							->or("(posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s))")
						->orderBy("posts.post_date DESC")
						->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title", true)
						->from("posts as posts")
						->join("term_relationships term_rel")
							->on("posts.ID = term_rel.object_id")
						->join("terms as terms")
							->on("term_rel.term_taxonomy_id = terms.term_id")
						->where("posts.post_status = %s")
							->and("term_rel.term_taxonomy_id")
								->in($search_data->catID)
							->and("posts.post_type")
								->in($post_type)
							->and("posts.post_date")
								->between("%s and %s")
						->orderBy("posts.post_date DESC")
						->get($args);
		}
		if ( is_wp_error( $data ) ) {
			return null;
		}

		$data = self::add_cats_in_query_result($data, $search_data);
		return $data;
	}

	public static function search_by_postType_author($search_data) {
		$data = [];
		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd
		];
		$args = self::set_search_key($search_data->talashKey, $args);
		$post_type = explode(', ', $search_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
						->from("posts posts")
						->where("posts.post_status = %s")
							->and("posts.post_type")
								->in($post_type)
							->and("posts.post_author")
								->in($search_data->authorID)
							->and("posts.post_date")
								->between("%s and %s")
							->and("((posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s)")
							->or("(posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s))")
						->orderBy("posts.post_date DESC")
						->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
						->from("posts posts")
						->where("posts.post_status = %s")
							->and("posts.post_type")
								->in($post_type)
							->and("posts.post_author")
								->in($search_data->authorID)
							->and("posts.post_date")
								->between("%s and %s")
						->get($args);
		}

		if ( is_wp_error( $data ) ) {
			return null;
		}

		return $data;
	}

	public static function search_by_cat_author($search_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd
		];
		$args = self::set_search_key($search_data->talashKey, $args);

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
						->from("posts as posts")
						->join("term_relationships as term_rel")
							->on("term_rel.object_id = posts.ID")
						->join("terms as terms")
							->on("terms.term_id = term_rel.term_taxonomy_id")
						->where("posts.post_status = %s")
							->and("term_rel.term_taxonomy_id")
								->in($search_data->catID)
							->and("posts.post_author")
								->in($search_data->authorID)
							->and("posts.post_date")
								->between("%s and %s")
							->and("((posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s)")
							->or("(posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s))")
						->orderBy("posts.post_date DESC")
						->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
						->from("posts as posts")
						->join("term_relationships as term_rel")
							->on("term_rel.object_id = posts.ID")
						->join("terms as terms")
							->on("terms.term_id = term_rel.term_taxonomy_id")
						->where("posts.post_status = %s")
							->and("term_rel.term_taxonomy_id")
								->in($search_data->catID)
							->and("posts.post_author")
								->in($search_data->authorID)
							->and("posts.post_date")
								->between("%s and %s")
						->orderBy("posts.post_date DESC")
						->get($args);
		}
		if ( is_wp_error( $data ) ) {
			return null;
		}

		$data = self::add_cats_in_query_result($data, $search_data);
		return $data;
	}

	public static function search_by_postType_cat_author($search_data) {
		global $wpdb;

		$data = [];
		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd,
		];
		$args = self::set_search_key($search_data->talashKey, $args);
		$post_type = explode(', ', $search_data->postType);
		$post_type = "'" . implode("','", $post_type) . "'";

		if ( $search_data->talashKey ) {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
						->from("posts as posts")
						->join("term_relationships as term_rel")
							->on("term_rel.object_id = posts.ID")
						->join("terms terms")
							->on("terms.term_id = term_rel.term_taxonomy_id")
						->where("posts.post_status = %s")
							->and("term_rel.term_taxonomy_id")
								->in($search_data->catID)
							->and("posts.post_type")
								->in($post_type)
							->and("posts.post_author")
								->in($search_data->authorID)
							->and("posts.post_date")
								->between("%s and %s")
							->and("((posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s")
								->or("posts.post_title LIKE %s)")
							->or("(posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s")
								->or("posts.post_content LIKE %s))")
						->orderBy("posts.post_date DESC")
						->get($args);
		} else {
			$data = Query_builder::select("posts.ID, posts.post_title, posts.post_author", true)
						->from("posts as posts")
						->join("term_relationships as term_rel")
							->on("term_rel.object_id = posts.ID")
						->join("terms terms")
							->on("terms.term_id = term_rel.term_taxonomy_id")
						->where("posts.post_status = %s")
							->and("term_rel.term_taxonomy_id")
								->in($search_data->catID)
							->and("posts.post_type")
								->in($post_type)
							->and("posts.post_author")
								->in($search_data->authorID)
							->and("posts.post_date")
								->between("%s and %s")
						->orderBy("posts.post_date DESC")
						->get($args);
		}
		if ( is_wp_error( $data ) ) {
			return null;
		}

		$data = self::add_cats_in_query_result($data, $search_data);
		return $data;
	}

	public static function search_by_keyword($search_data) {
		global $wpdb;

		$args = [
			'publish',
			$search_data->dateRangeStart,
			$search_data->dateRangeEnd,
		];
		$args = self::set_search_key($search_data->talashKey, $args);

		$data = Query_builder::select("posts.ID, posts.post_title")
					->from("posts as posts")
					->where("posts.post_status = %s")
						->and("posts.post_date")
							->between("%s and %s")
						->and("((posts.post_title LIKE %s")
							->or("posts.post_title LIKE %s")
							->or("posts.post_title LIKE %s)")
						->or("(posts.post_content LIKE %s")
							->or("posts.post_content LIKE %s")
							->or("posts.post_content LIKE %s))")
					->orderBy("posts.post_date DESC")
					->get($args);

		if ( is_wp_error( $data ) ) {
			return null;
		}

		return $data;
	}

	public static function talash_search_query($search_data) {
		$data = '';

		if ( $search_data->postType && $search_data->catID == '' && $search_data->authorID == '' ) {
			// only postTypes
			$data = self::search_by_postType($search_data);
		} elseif ( $search_data->postType == '' && $search_data->catID && $search_data->authorID == '' ) {
			// only categories
			$data = self::search_by_cat($search_data);
		} elseif ( $search_data->postType == '' && $search_data->catID == '' && $search_data->authorID ) {
			// only authors
			$data = self::search_by_author($search_data);
		} elseif ( $search_data->postType && $search_data->catID && $search_data->authorID == '' ) {
			// postTypes, categories
			$data = self::search_by_postType_cat($search_data);
		} elseif ( $search_data->postType && $search_data->catID == '' && $search_data->authorID ) {
			// postTypes, authors
			$data = self::search_by_postType_author($search_data);
		} elseif ( $search_data->postType == '' && $search_data->catID && $search_data->authorID ) {
			// categories, authors
			$data = self::search_by_cat_author($search_data);
		} elseif ( $search_data->postType && $search_data->catID && $search_data->authorID ) {
			// postTypes, categories, authors
			$data = self::search_by_postType_cat_author($search_data);
		} elseif ( $search_data->talashKey && $search_data->postType == '' && $search_data->catID == '' && $search_data->authorID == '' ) {
			// only keyword
			$data = self::search_by_keyword($search_data);
		}

		return $data;
	}

}
