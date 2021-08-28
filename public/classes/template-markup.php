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
				<h2 class="talash-title"><?php echo $message; ?></h2>
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

}
