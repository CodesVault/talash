<?php
/**
 * The core plugin class
 *
 * @link       https://abmsourav.com/
 *
 * @package    searchify
 * @author     sourav926 
 */
namespace Talash\View;

use Talash\Admin\Author_Query;
use Talash\Admin\Category_Query;
use Talash\Admin\PostType_Query;
use Talash\Admin\Searchify_Query;


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
		$searchify_data = json_decode( sanitize_text_field( stripslashes( $_POST['searchify_data'] ) ) );
		$data = null;

		if ( $searchify_data->catID !== '' && $searchify_data->authorID === '' ) {
			$data = PostType_Query::searchify_get_postTypes_by_cat($searchify_data);
		} elseif ( $searchify_data->catID === '' && $searchify_data->authorID !== '' ) {
			$data = PostType_Query::searchify_get_postTypes_by_author($searchify_data);
		} elseif ( $searchify_data->catID !== '' && $searchify_data->authorID !== '' ) {
			$data = PostType_Query::searchify_get_postTypes_by_cat_author($searchify_data);
		} else {
			$data = PostType_Query::searchify_get_postTypes();
		}

		if ( $data === 'error' ) {
			wp_send_json("error", 403);
		} else {
			wp_send_json($data, 200);
		}
		wp_die();
	}

	public static function talash_get_categories() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }
		$searchify_data = json_decode( sanitize_text_field( stripslashes( $_POST['searchify_data'] ) ) );
		$data = null;

		if ( $searchify_data->postType !== '' && $searchify_data->authorID === '' ) {
			$data = Category_Query::searchify_get_cats_by_postTypes($searchify_data);
		} elseif ( $searchify_data->postType === '' && $searchify_data->authorID !== '' ) {
			$data = Category_Query::searchify_get_cats_by_author($searchify_data);
		} elseif ( $searchify_data->postType !== '' && $searchify_data->authorID !== '' ) {
			$data = Category_Query::searchify_get_cats_by_postType_author($searchify_data);
		} else {
			$data = Category_Query::searchify_get_all_cats();
		}

		if ( $data === 'error' ) {
			wp_send_json("error", 403);
		} else {
			wp_send_json($data, 200);
		}

		wp_die();
	}

	public static function talash_get_authors() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

		$authors = null;
		$searchify_data = json_decode( sanitize_text_field( stripslashes( $_POST['searchify_data'] ) ) );
		
		if ( empty( $searchify_data->postType ) && empty( $searchify_data->catID ) ) {
			$authors = Author_Query::searchify_get_all_author();

		} elseif ( ! empty( $searchify_data->postType ) && ! empty( $searchify_data->catID ) ) {
			$authors = Author_Query::searchify_get_author_by_pt_cat($searchify_data);

		} elseif ( empty( $searchify_data->postType ) && ! empty( $searchify_data->catID ) ) {
			$authors = Author_Query::searchify_get_author_by_cat($searchify_data->catID);
		} elseif ( ! empty( $searchify_data->postType ) && empty( $searchify_data->catID ) ) {
			$authors = Author_Query::searchify_get_author_by_pt($searchify_data->postType);
		}

		if ( $authors ) {
			wp_send_json($authors, 200);
		} else {
			wp_send_json($authors, 404);
		}
		wp_die();
	}

	public static function not_found() {
		?>
			<div class="searchify-notFound-card">
				<h2 class="searchify-title"><?php _e( 'Nothing Found', 'searchify' ); ?></h2>
			</div>
		<?php
	}

	public static function search_result_markup($data) {
		if ( empty( $data ) ) {
			self::not_found();
			return;
		}

		foreach ( $data as $post ) :
			$post_title = $post->post_title;
			$title_split = explode( ' ', $post->post_title );
			if ( count( $title_split ) > 10 ) {
				$title_shorten = array_slice( $title_split, 0, 10 );
				$post_title = implode( ' ', $title_shorten ) . '...';
			}
			?>
			<div class="searchify-card">
				<?php
				if ( has_post_thumbnail( $post->ID ) ) {
					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
					$thumbnail_image_url = $thumbnail[0];
				} else {
					$thumbnail_image_url = TALASH_URL . 'assets/images/searchify-placeholder.png';
				}
				?>
				<div class="searchify-thumbnail-wrap">
					<img class="searchify-thumbnail" src="<?php echo esc_url( $thumbnail_image_url ); ?>" alt="<?php echo esc_attr( $post->post_title ); ?>">
				</div>
				<div class="searchify-card__inner">
					<h2 class="searchify-title">
						<a href="<?php echo get_the_permalink( $post->ID ); ?>">
							<?php echo esc_html( $post_title ); ?>
						</a>
					</h2>

					<div class="searchify-post-meta">
						<?php if ( isset( $post->cat_name ) ) : ?>
							<div class="cat-meta"><?php echo esc_html( $post->cat_name ); ?></div>
						<?php endif; ?>

						<?php if ( isset( $post->post_author ) ) : ?>
							<div class="author-meta"><?php echo get_the_author_meta( 'display_name', $post->post_author ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php
		endforeach;
	}

	public static function get_search_results() {
		$security = check_ajax_referer( 'talash_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }
		$searchify_data = json_decode( sanitize_text_field( stripslashes( $_POST['searchify_data'] ) ) );
		
		$data = Searchify_Query::searchify_search_query($searchify_data);

		// wp_send_json($data, 200);
		self::search_result_markup($data);
		wp_die();
	}

}
