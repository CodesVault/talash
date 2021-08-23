<?php 
/**
 * WordPress Customizer Class.
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\Admin;

class Talash_Customize {

	public $customizer_dir = TALASH_DIR_PATH . 'admin/customizer/';

	function __construct() {
		add_action( 'customize_register', [ $this, 'customizer_settings' ] );
		require_once( $this->customizer_dir . 'styles.php' );
	}

	/**
	 * callback function for customize_register
     *
     * @param object $wp_customize
	 */
	public function customizer_settings( $wp_customize ) {
		add_action( 'customize_preview_init', [ $this, 'enqueue_live_edit_js' ] );

		// custom design for pages
		$this->create_sections($wp_customize);
	}

	private function create_sections($wp_customize) {
		require_once( $this->customizer_dir . 'sanitize.php' );

		require_once( $this->customizer_dir . 'custom-controls/heading-control.php' );

		require_once( $this->customizer_dir . 'controls/searchify-controls.php' );

		$wp_customize->add_section( 'searchify_section' , array(
			'title'      => __( 'Searchify', 'searchify' ),
			'priority'   => 25
		) );	
		searchify_customizer_controls($wp_customize);
	}

	public function enqueue_live_edit_js() {
		wp_enqueue_script(
			'talash-customizer-js',
			TALASH_URL . 'assets/customizer/js/customizer.js',
			array( 'jquery', 'customize-preview' ),
			TALASH_VERSION . time(),
			true 
		);
	}

}
