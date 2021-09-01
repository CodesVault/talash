<?php
/**
 * The DB queries for Post Types
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Admin;

use Talash\Query\Query_builder;


class PostType_Query {

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

	public static function get_postTypes_by_cat($search_data) {
		$data = [];
		
		$postTypes = Query_builder::select("posts.post_type", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->where("term_rel.term_taxonomy_id")
			->in($search_data->catID)
			->and("posts.post_status = %s")
			->get([ 'publish' ]);

		if ( is_wp_error( $postTypes ) ) {
			return null;
		}
	
		$all_post_types = self::allowed_postTypes('objects');

		for ($i = 0; $i < count($all_post_types); $i++) {
			if ( is_object( $all_post_types[$postTypes[$i]->post_type] ) ) {
				array_push( $data, $all_post_types[$postTypes[$i]->post_type]->name );
			}
		}

		return $data;
	}

	public static function get_postTypes_by_author($search_data) {
		$data = [];
		
		$postTypes = Query_builder::select("posts.post_type", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->where("posts.post_author")
			->in($search_data->authorID)
			->and("posts.post_status = %s")
			->get([ 'publish' ]);
			
		if ( is_wp_error( $postTypes ) ) {
			return null;
		}
		
		$all_post_types = self::allowed_postTypes('objects');
		for ($i = 0; $i < count($all_post_types); $i++) {
			if ( is_object( $all_post_types[$postTypes[$i]->post_type] ) ) {
				array_push( $data, $all_post_types[$postTypes[$i]->post_type]->name );
			}
		}

		return $data;
	}

	public static function get_postTypes_by_cat_author($search_data) {
		$data = [];

		$postTypes = Query_builder::select("posts.post_type", true)
			->from("posts as posts")
			->join("term_relationships as term_rel")
			->on("posts.ID = term_rel.object_id")
			->where("posts.post_author")
			->in($search_data->authorID)
			->and("term_rel.term_taxonomy_id")
			->in($search_data->catID)
			->and("posts.post_status = %s")
			->get([ 'publish' ]);

		if ( is_wp_error( $postTypes ) ) {
			return null;
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
