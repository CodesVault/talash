<?php
/**
 * The DB queries for Category taxonomies
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Admin;

use Talash\Query\Query_builder;


class Category_Query {

	public static function talash_get_all_cats() {
		$cats = Query_builder::select("terms.term_id, terms.name", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->join("terms as terms")
			->on("term_rel.term_taxonomy_id = terms.term_id")
			->join("term_taxonomy as term_tax")
			->on("term_tax.term_id = terms.term_id")
			->where("posts.post_status = %s")
			->and("term_tax.taxonomy != %s")
			->and("terms.name NOT lIKE '%exclude%'")
			->get([ 'publish', 'post_tag' ]);

		if ( is_wp_error( $cats ) ) {
			return null;
		}

		return $cats;
	}

	public static function get_cats_by_postTypes($search_data) {
		$post_types = explode(', ', $search_data->postType);
		$post_types = "'" . implode("','", $post_types) . "'";
		
		$cats = Query_builder::select("terms.term_id, terms.name", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->join("terms as terms")
			->on("term_rel.term_taxonomy_id = terms.term_id")
			->join("term_taxonomy as term_tax")
			->on("term_tax.term_id = terms.term_id")
			->where("posts.post_type")
			->in($post_types)
			->and("posts.post_status = %s")
			->and("term_tax.taxonomy != %s")
			->and("terms.name NOT lIKE '%exclude%'")
			->get([ 'publish', 'post_tag' ]);

		if ( is_wp_error( $cats ) ) {
			return null;
		}

		return $cats;
	}

	public static function get_cats_by_author($search_data) {
		$author_id = $search_data->authorID;

		$cats = Query_builder::select("terms.term_id, terms.name", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->join("terms as terms")
			->on("term_rel.term_taxonomy_id = terms.term_id")
			->join("term_taxonomy as term_tax")
			->on("term_tax.term_id = terms.term_id")
			->where("posts.post_author")
			->in($author_id)
			->and("posts.post_status = %s")
			->and("term_tax.taxonomy != %s")
			->and("terms.name NOT lIKE '%exclude%'")
			->get([ 'publish', 'post_tag' ]);

		if ( is_wp_error( $cats ) ) {
			return null;
		}

		return $cats;
	}

	public static function get_cats_by_postType_author($search_data) {
		$post_types = explode(', ', $search_data->postType);
		$post_types = "'" . implode("','", $post_types) . "'";
		$author_id = $search_data->authorID;

		$cats = Query_builder::select("terms.term_id, terms.name", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->join("terms as terms")
			->on("term_rel.term_taxonomy_id = terms.term_id")
			->join("term_taxonomy as term_tax")
			->on("term_tax.term_id = terms.term_id")
			->where("posts.post_author")
			->in($author_id)
			->and("posts.post_type")
			->in($post_types)
			->and("posts.post_status = %s")
			->and("term_tax.taxonomy != %s")
			->and("terms.name NOT lIKE '%exclude%'")
			->get([ 'publish', 'post_tag' ]);

		if ( is_wp_error( $cats ) ) {
			return null;
		}

		return $cats;
	}

}
