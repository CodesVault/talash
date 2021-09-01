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
use Talash\Query\Query_builder;

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
		require_once TALASH_DIR_PATH . 'inc/Query-builder.php';
		require_once TALASH_DIR_PATH . 'admin/talash-admin.php';
		require_once TALASH_DIR_PATH . 'public/classes/talash-public.php';

		$result = Query_builder::select("posts.post_title, posts.post_status", true)
					->from("posts as posts")	// table prefix added automatically. 
					->join("term_relationships as term_rel")
					->on("posts.ID = term_rel.object_id")
					->where("term_rel.term_taxonomy_id = %s")
					->or("term_rel.term_taxonomy_id = %s")
					->and("posts.post_status = %s")
					->orderBy("post_title desc")
					->get([3, 6, 'publish']);
					// ::groupBy("post_title")

		// print_r($result);
	}

}
