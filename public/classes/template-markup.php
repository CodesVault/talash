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


class Template_Markup {

	public static function not_found($message) {
		?>
			<div class="talash-notFound-card">
				<h2 class="talash-title"><?php echo esc_html( $message ); ?></h2>
			</div>
		<?php
	}
	
	public static function author_markup($authors) {
		if ( ! $authors ) {
			$message = __( 'Nothing Found', 'talash' );
			self::not_found($message);
			return;
		}

		foreach ( $authors as $author ) :
		?>
		<li class='author-li'>
			<div class='author-li__inner' data-authorID="<?php echo esc_attr( $author->ID ); ?>">
				<img src="<?php echo esc_url( $author->avatar_url ); ?>">
				<div><?php echo esc_html( $author->display_name ); ?></div>
			</div>
		</li>
		<?php
		endforeach;
	}

	public static function search_result_markup($data) {
		if ( empty( $data ) && $data !== false ) {
			$message = __( 'Nothing Found', 'talash' );
			self::not_found($message);
			return;
		}
		if ( $data === false ) {
			$message = __( 'Data is not valid...', 'talash' );
			self::not_found($message);
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
						<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>">
							<?php echo esc_html( $post_title ); ?>
						</a>
					</h2>

					<div class="talash-post-meta">
						<?php if ( isset( $post->cat_name ) ) : ?>
							<div class="cat-meta"><?php echo esc_html( $post->cat_name ); ?></div>
						<?php endif; ?>

						<?php if ( isset( $post->post_author ) ) : ?>
							<div class="author-meta"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php
		endforeach;
	}

}
