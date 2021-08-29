<?php
/**
 * Main class for the Backend.
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Admin;

use Talash\Admin\Talash_Customize;


class Talash_Admin {

	static function load_admin() {
		self::load_dependencies();

		new Talash_Customize();
	}

	static function load_dependencies() {
		require_once TALASH_DIR_PATH . 'admin/option-queries/postType.php';
		require_once TALASH_DIR_PATH . 'admin/option-queries/category.php';
		require_once TALASH_DIR_PATH . 'admin/option-queries/author.php';
		require_once TALASH_DIR_PATH . 'admin/search-query.php';
		require_once TALASH_DIR_PATH . 'admin/customizer/customizer.php';
	}

}
