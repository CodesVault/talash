<?php
/**
 * The DB queries for Post Types
 *
 * @link       https://abmsourav.com/
 *
 * @package    searchify
 * @author     sourav926 
 */
namespace Talash\Admin;


class PostType_Query {

	private static function talash_query($query, $arr) {
		global $wpdb;
	
		$results = $wpdb->get_results( $wpdb->prepare( $query, $arr ) );
		return $results;
	}

	private static function allowed_postTypes($type = 'names') {
		$args = [
			'public' => true,
			'exclude_from_search' => false
		];
		$post_types = get_post_types( $args, $type );
		unset( $post_types['attachment'] );

		return $post_types;
	}

	public static function talash_get_postTypes() {
		$data = [];

		$post_types = self::allowed_postTypes();

		foreach ( $post_types as $post_type ) {
			array_push( $data, $post_type );
		}

		return $data;
	}

	public static function get_postTypes_by_cat($searchify_data) {
		global $wpdb;
		$data = [];
		
		$postTypes = self::talash_query(
			"SELECT DISTINCT posts.post_type
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			WHERE term_rel.term_taxonomy_id = %s
				AND	posts.post_status = %s",
			[ $searchify_data->catID, 'publish' ]
		);
		if ( is_wp_error( $postTypes ) ) {
			return 'error';
		}
		
		$args = [
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true
		];
		$all_post_types = self::allowed_postTypes('objects');

		for ($i = 0; $i < count($all_post_types); $i++) {
			if ( is_object( $all_post_types[$postTypes[$i]->post_type] ) ) {
				array_push( $data, $all_post_types[$postTypes[$i]->post_type]->name );
			}
		}

		return $data;
	}

	public static function get_postTypes_by_author($searchify_data) {
		global $wpdb;
		$data = [];
		
		$postTypes = self::talash_query(
			"SELECT DISTINCT posts.post_type
			FROM {$wpdb->prefix}posts posts
			WHERE posts.post_author = %s
				AND	posts.post_status = %s",
			[ $searchify_data->authorID, 'publish' ]
		);
		if ( is_wp_error( $postTypes ) ) {
			return 'error';
		}
		
		$all_post_types = self::allowed_postTypes('objects');

		for ($i = 0; $i < count($all_post_types); $i++) {
			if ( is_object( $all_post_types[$postTypes[$i]->post_type] ) ) {
				array_push( $data, $all_post_types[$postTypes[$i]->post_type]->name );
			}
		}

		return $data;
	}

	public static function get_postTypes_by_cat_author($searchify_data) {
		global $wpdb;
		$data = [];

		$postTypes = self::talash_query(
			"SELECT DISTINCT posts.post_type
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			WHERE posts.post_author = %s
				AND term_rel.term_taxonomy_id = %s
				AND	posts.post_status = %s",
			[ $searchify_data->authorID, $searchify_data->catID, 'publish' ]
		);
		if ( is_wp_error( $postTypes ) ) {
			return 'error';
		}
		
		$all_post_types = self::allowed_postTypes('objects');

		for ($i = 0; $i < count($all_post_types); $i++) {
			if ( is_object( $all_post_types[$postTypes[$i]->post_type] ) ) {
				array_push( $data, $all_post_types[$postTypes[$i]->post_type]->name );
			}
		}

		return $data;
	}

}
