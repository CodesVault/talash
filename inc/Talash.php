<?php
/**
 * The core plugin class
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash;

use Talash\View\Talash_Public;
use Talash\Admin\Talash_Admin;

class Talash_Core {

	public static $instance;

	function __construct() {
		$this->load_dependencies();

		self::$instance = $this;
		$this->init();
	}

	static function spread_happiness() {
		if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
	}

	function init() {
		add_action( 'plugins_loaded', [ $this, 'load_i18n' ] );

		Talash_Admin::load_admin();
		Talash_Public::load_frontend();
	}

	function load_i18n() {
		load_plugin_textdomain( 'talash', false, dirname( plugin_basename( __FILE__ ) . '/languages/' ) );
	}

	function load_dependencies() {
		require_once TALASH_DIR_PATH . 'admin/talash-admin.php';
		require_once TALASH_DIR_PATH . 'public/classes/talash-public.php';
	}

}
