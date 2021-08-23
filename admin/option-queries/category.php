<?php
/**
 * The DB queries for Category taxonomies
 *
 * @link       https://abmsourav.com/
 *
 * @package    searchify
 * @author     sourav926 
 */
namespace Talash\Admin;


class Category_Query {

	private static function talash_query($query, $arr) {
		global $wpdb;
	
		$results = $wpdb->get_results( $wpdb->prepare( $query, $arr ) );
		return $results;
	}

	public static function talash_get_all_cats() {
		global $wpdb;

		$cats = self::talash_query(
			"SELECT DISTINCT terms.term_id, terms.name
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			INNER JOIN {$wpdb->prefix}terms terms
				ON term_rel.term_taxonomy_id = terms.term_id
			INNER JOIN {$wpdb->prefix}term_taxonomy term_tax
				ON term_tax.term_id = terms.term_id
			WHERE posts.post_status = %s
				AND term_tax.taxonomy != %s
				AND terms.name NOT lIKE '%exclude%'",
			[ 'publish', 'post_tag' ]
		);

		return $cats;
	}

	public static function get_cats_by_postTypes($searchify_data) {
		global $wpdb;
		$post_types = explode(', ', $searchify_data->postType);
		$post_types = "'" . implode("','", $post_types) . "'";
		
		$cats = self::talash_query(
			"SELECT DISTINCT terms.term_id, terms.name
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			INNER JOIN {$wpdb->prefix}terms terms
				ON term_rel.term_taxonomy_id = terms.term_id
			INNER JOIN {$wpdb->prefix}term_taxonomy term_tax
				ON term_tax.term_id = terms.term_id
			WHERE posts.post_type IN($post_types)
				AND	posts.post_status = %s
				AND term_tax.taxonomy != %s
				AND terms.name NOT lIKE '%exclude%'",
			[ 'publish', 'post_tag' ]
		);
		if ( is_wp_error( $cats ) ) {
			return 'error';
		}

		return $cats;
	}

	public static function get_cats_by_author($searchify_data) {
		global $wpdb;
		$author_id = $searchify_data->authorID;

		$cats = self::talash_query(
			"SELECT DISTINCT terms.term_id, terms.name
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			INNER JOIN {$wpdb->prefix}terms terms
				ON term_rel.term_taxonomy_id = terms.term_id
			INNER JOIN {$wpdb->prefix}term_taxonomy term_tax
				ON term_tax.term_id = terms.term_id
			WHERE posts.post_author IN($author_id)
				AND	posts.post_status = %s
				AND term_tax.taxonomy != %s
				AND terms.name NOT lIKE '%exclude%'",
			[ 'publish', 'post_tag' ]
		);
		if ( is_wp_error( $cats ) ) {
			return 'error';
		}

		return $cats;
	}

	public static function get_cats_by_postType_author($searchify_data) {
		global $wpdb;
		$post_types = explode(', ', $searchify_data->postType);
		$post_types = "'" . implode("','", $post_types) . "'";
		$author_id = $searchify_data->authorID;

		$cats = self::talash_query(
			"SELECT DISTINCT terms.term_id, terms.name
			FROM {$wpdb->prefix}posts posts
			INNER JOIN {$wpdb->prefix}term_relationships term_rel
				ON posts.ID = term_rel.object_id
			INNER JOIN {$wpdb->prefix}terms terms
				ON term_rel.term_taxonomy_id = terms.term_id
			INNER JOIN {$wpdb->prefix}term_taxonomy term_tax
				ON term_tax.term_id = terms.term_id
			WHERE posts.post_author IN($author_id)
				AND posts.post_type IN($post_types)
				AND	posts.post_status = %s
				AND term_tax.taxonomy != %s
				AND terms.name NOT lIKE '%exclude%'",
			[ 'publish', 'post_tag' ]
		);
		if ( is_wp_error( $cats ) ) {
			return 'error';
		}

		return $cats;
	}

}
