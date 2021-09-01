<?php
/**
 * Engine for the frontend data traverse.
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\View;

use Talash\Admin\Author_Query;
use Talash\Admin\Category_Query;
use Talash\Admin\PostType_Query;
use Talash\Admin\Talash_Query;


class Template_Api {

	public static function load_api() {
		add_action( 'wp_ajax_talash_get_post_types', [ __CLASS__, 'talash_get_post_types' ] );
		add_action( 'wp_ajax_nopriv_talash_get_post_types', [ __CLASS__, 'talash_get_post_types' ] );

		add_action( 'wp_ajax_talash_get_categories', [ __CLASS__, 'talash_get_categories' ] );
		add_action( 'wp_ajax_nopriv_talash_get_categories', [ __CLASS__, 'talash_get_categories' ] );

		add_action( 'wp_ajax_talash_get_authors', [ __CLASS__, 'talash_get_authors' ] );
		add_action( 'wp_ajax_nopriv_talash_get_authors', [ __CLASS__, 'talash_get_authors' ] );

		add_action( 'wp_ajax_get_search_results', [ __CLASS__, 'get_search_results' ] );
		add_action( 'wp_ajax_nopriv_get_search_results', [ __CLASS__, 'get_search_results' ] );
	}

	static function talash_get_post_types() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

		$post_type = null;
		$search_data = json_decode( stripslashes( $_POST['talash_data'] ) );
		$search_data = Filter::data_sanitization( $search_data );
		$search_data = Filter::check_validation($search_data);
		
		if ( $search_data ) {
			if ( $search_data->catID !== '' && $search_data->authorID === '' ) {
				$post_type = PostType_Query::get_postTypes_by_cat($search_data);
			} elseif ( $search_data->catID === '' && $search_data->authorID !== '' ) {
				$post_type = PostType_Query::get_postTypes_by_author($search_data);
			} elseif ( $search_data->catID !== '' && $search_data->authorID !== '' ) {
				$post_type = PostType_Query::get_postTypes_by_cat_author($search_data);
			} else {
				$post_type = PostType_Query::talash_get_postTypes();
			}
		}

		Template_Markup::postType_markup($post_type);
		wp_die();
	}

	public static function talash_get_categories() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

		$cats = null;
		$search_data = json_decode( stripslashes( $_POST['talash_data'] ) );
		$search_data = Filter::data_sanitization( $search_data );
		$search_data = Filter::check_validation($search_data);
		
		if ( $search_data ) {
			if ( $search_data->postType !== '' && $search_data->authorID === '' ) {
				$cats = Category_Query::get_cats_by_postTypes($search_data);
			} elseif ( $search_data->postType === '' && $search_data->authorID !== '' ) {
				$cats = Category_Query::get_cats_by_author($search_data);
			} elseif ( $search_data->postType !== '' && $search_data->authorID !== '' ) {
				$cats = Category_Query::get_cats_by_postType_author($search_data);
			} else {
				$cats = Category_Query::talash_get_all_cats();
			}
		}

		Template_Markup::categories_markup($cats);
		wp_die();
	}

	public static function talash_get_authors() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

		$authors = null;
		$search_data = json_decode( stripslashes( $_POST['talash_data'] ) );
		$search_data = Filter::data_sanitization( $search_data );
		$search_data = Filter::check_validation($search_data);
		
		if ( $search_data ) {
			if ( empty( $search_data->postType ) && empty( $search_data->catID ) ) {
				$authors = Author_Query::talash_get_all_author();
			} elseif ( ! empty( $search_data->postType ) && ! empty( $search_data->catID ) ) {
				$authors = Author_Query::get_author_by_pt_cat($search_data);
			} elseif ( empty( $search_data->postType ) && ! empty( $search_data->catID ) ) {
				$authors = Author_Query::get_author_by_cat($search_data->catID);
			} elseif ( ! empty( $search_data->postType ) && empty( $search_data->catID ) ) {
				$authors = Author_Query::get_author_by_pt($search_data->postType);
			}
		}

		Template_Markup::author_markup($authors);
		wp_die();
	}

	public static function get_search_results() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }
		$search_data = json_decode( stripslashes( $_POST['talash_data'] ) );
		$search_data = Filter::data_sanitization( $search_data );
		$data = Filter::check_validation($search_data);
		
		$data = Talash_Query::talash_search_query($data);
		Template_Markup::search_result_markup($data);

		wp_die();
	}

}
