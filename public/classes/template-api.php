<?php
/**
 * The core plugin class
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
		$search_data = json_decode( sanitize_text_field( stripslashes( $_POST['talash_data'] ) ) );
		$data = null;

		if ( $search_data->catID !== '' && $search_data->authorID === '' ) {
			$data = PostType_Query::get_postTypes_by_cat($search_data);
		} elseif ( $search_data->catID === '' && $search_data->authorID !== '' ) {
			$data = PostType_Query::get_postTypes_by_author($search_data);
		} elseif ( $search_data->catID !== '' && $search_data->authorID !== '' ) {
			$data = PostType_Query::get_postTypes_by_cat_author($search_data);
		} else {
			$data = PostType_Query::talash_get_postTypes();
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
		$search_data = json_decode( sanitize_text_field( stripslashes( $_POST['talash_data'] ) ) );
		$data = null;

		if ( $search_data->postType !== '' && $search_data->authorID === '' ) {
			$data = Category_Query::get_cats_by_postTypes($search_data);
		} elseif ( $search_data->postType === '' && $search_data->authorID !== '' ) {
			$data = Category_Query::get_cats_by_author($search_data);
		} elseif ( $search_data->postType !== '' && $search_data->authorID !== '' ) {
			$data = Category_Query::get_cats_by_postType_author($search_data);
		} else {
			$data = Category_Query::talash_get_all_cats();
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
		$search_data = json_decode( sanitize_text_field( stripslashes( $_POST['talash_data'] ) ) );
		
		if ( empty( $search_data->postType ) && empty( $search_data->catID ) ) {
			$authors = Author_Query::talash_get_all_author();
		} elseif ( ! empty( $search_data->postType ) && ! empty( $search_data->catID ) ) {
			$authors = Author_Query::get_author_by_pt_cat($search_data);
		} elseif ( empty( $search_data->postType ) && ! empty( $search_data->catID ) ) {
			$authors = Author_Query::get_author_by_cat($search_data->catID);
		} elseif ( ! empty( $search_data->postType ) && empty( $search_data->catID ) ) {
			$authors = Author_Query::get_author_by_pt($search_data->postType);
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
			<div class="talash-notFound-card">
				<h2 class="talash-title"><?php _e( 'Nothing Found', 'talash' ); ?></h2>
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
			<div class="talash-card">
				<?php
				if ( has_post_thumbnail( $post->ID ) ) {
					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
					$thumbnail_image_url = $thumbnail[0];
				} else {
					$thumbnail_image_url = TALASH_URL . 'assets/images/talash-placeholder.png';
				}
				?>
				<div class="talash-thumbnail-wrap">
					<img class="talash-thumbnail" src="<?php echo esc_url( $thumbnail_image_url ); ?>" alt="<?php echo esc_attr( $post->post_title ); ?>">
				</div>
				<div class="talash-card__inner">
					<h2 class="talash-title">
						<a href="<?php echo get_the_permalink( $post->ID ); ?>">
							<?php echo esc_html( $post_title ); ?>
						</a>
					</h2>

					<div class="talash-post-meta">
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
		$search_data = json_decode( sanitize_text_field( stripslashes( $_POST['talash_data'] ) ) );
		
		$data = Talash_Query::talash_search_query($search_data);

		// wp_send_json($data, 200);
		self::search_result_markup($data);
		wp_die();
	}

}
