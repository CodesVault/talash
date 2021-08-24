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


class Talash_Public {

	static function load_frontend() {
		self::load_dependencies();

		Assets_Manager::init();
		Template_Api::load_api();

		add_shortcode( 'talash-search', [ __CLASS__, 'shortcode_markup' ] );
	}

	static function load_dependencies() {
		require_once TALASH_DIR_PATH . 'public/classes/assets_meneger.php';
		require_once TALASH_DIR_PATH . 'public/classes/validation.php';
		require_once TALASH_DIR_PATH . 'public/classes/template-api.php';
	}

	static function shortcode_markup() {
		ob_start();
			require_once TALASH_DIR_PATH . 'public/template.php';
		return ob_get_clean();
	}

}
