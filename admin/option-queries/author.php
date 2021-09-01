<?php
/**
 * The DB queries for Post Author
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Admin;

use Talash\Query\Query_builder;


class Author_Query {

	public static function talash_get_all_author() {
		$data = Query_builder::select("users.ID, users.display_name", true)
			->from("users as users")
			->join("posts as posts")
			->on("posts.post_author = users.ID")
			->where("posts.post_status = %s")
			->get([ 'publish' ]);

		if ( empty( $data ) || is_wp_error( $data ) ) {
			return null;
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

	public static function get_author_by_pt($post_type) {
		$post_types = explode(', ', $post_type);
		$post_types = "'" . implode("','", $post_types) . "'";

		$data = Query_builder::select("users.ID, users.display_name", true)
			->from("users as users")
			->join("posts as posts")
			->on("posts.post_author = users.ID")
			->where("posts.post_status = %s")
			->and("posts.post_type")
			->in($post_types)
			->get([ 'publish' ]);

		if ( empty( $data ) || is_wp_error( $data ) ) {
			return null;
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

	public static function get_author_by_pt_cat($search_data) {
		$post_types = explode(', ', $search_data->postType);
		$post_types = "'" . implode("','", $post_types) . "'";

		$data = Query_builder::select("users.ID, users.display_name", true)
			->from("users as users")
			->join("posts as posts")
			->on("posts.post_author = users.ID")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->where("posts.post_type")
			->in($post_types)
			->and("term_rel.term_taxonomy_id")
			->in($search_data->catID)
			->and("posts.post_status = %s")
			->get([ 'publish' ]);

		if ( empty( $data ) || is_wp_error( $data ) ) {
			return null;
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

	public static function get_author_by_cat($cat_id) {
		$data = Query_builder::select("users.ID, users.display_name", true)
			->from("users as users")
			->join("posts as posts")
			->on("posts.post_author = users.ID")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->where("term_rel.term_taxonomy_id")
			->in($cat_id)
			->and("posts.post_status = %s")
			->get([ 'publish' ]);

		if ( empty( $data ) || is_wp_error( $data ) ) {
			return null;
		}

		foreach ( $data as $key => $author ) {
			$avater = get_avatar_data( $author->ID, [ 'size' => 40 ] );
			$data[$key]->avatar_url = $avater['url'];
		}

		return $data;
	}

}
