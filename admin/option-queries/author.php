<?php
/**
 * The DB queries for Post Author
 *
 * @link       https://abmsourav.com/
 *
 * @package    searchify
 * @author     sourav926 
 */
namespace Talash\Admin;


class Author_Query {

	private static function talash_query($query, $arr) {
		global $wpdb;
	
		$results = $wpdb->get_results( $wpdb->prepare( $query, $arr ) );
		return $results;
	}

	public static function talash_get_all_author() {	
		global $wpdb;
		$data = [];

		$data = self::talash_query(
			"SELECT DISTINCT users.ID, users.display_name
			FROM {$wpdb->prefix}users users
			INNER JOIN {$wpdb->prefix}posts posts
				ON posts.post_author = users.ID
			WHERE posts.post_status = %s",
			[ 'publish' ]
		);
		if ( is_wp_error( $data ) ) {
			return 'error';
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

	public static function get_author_by_pt($post_type) {
		global $wpdb;
		$data = [];

		$post_types = explode(', ', $post_type);
		$post_types = "'" . implode("','", $post_types) . "'";

		$data = self::talash_query(
			"SELECT DISTINCT users.ID, users.display_name
			FROM {$wpdb->prefix}users users
			INNER JOIN {$wpdb->prefix}posts posts
				ON posts.post_author = users.ID
			WHERE posts.post_status = %s
				AND posts.post_type IN ($post_types)",
			[ 'publish' ]
		);
		if ( is_wp_error( $data ) ) {
			return 'error';
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

	public static function get_author_by_pt_cat($search_data) {
		global $wpdb;
		$data = [];

		$post_types = explode(', ', $search_data->postType);
		$post_types = "'" . implode("','", $post_types) . "'";

		$data = self::talash_query(
			"SELECT DISTINCT users.ID, users.display_name
			FROM {$wpdb->prefix}users users
			INNER JOIN {$wpdb->prefix}posts posts
				ON posts.post_author = users.ID
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			WHERE posts.post_type IN ($post_types)
				AND term_rel.term_taxonomy_id IN ($search_data->catID)
				AND posts.post_status = %s",
			[ 'publish' ]
		);
		if ( is_wp_error( $data ) ) {
			return 'error';
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

	public static function get_author_by_cat($cat_id) {
		global $wpdb;
		$data = [];

		$data = self::talash_query(
			"SELECT DISTINCT users.ID, users.display_name
			FROM {$wpdb->prefix}users users
			INNER JOIN {$wpdb->prefix}posts posts
				ON posts.post_author = users.ID
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			WHERE term_rel.term_taxonomy_id IN ($cat_id)
				AND posts.post_status = %s",
			[ 'publish' ]
		);
		if ( is_wp_error( $data ) ) {
			return 'error';
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

}
