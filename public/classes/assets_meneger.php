<?php
/**
 * Public assets file
 *
 * @link       https://abmsourav.com/
 *
 * @package    talash
 * @author     sourav926 
 */
namespace Talash\View;

class Assets_Manager {

	public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'public_api' ) );
    }

    public static function styles() {
        wp_enqueue_style( 'talash-daterangepicker-css', TALASH_URL . 'assets/vendors/date-range-picker/daterangepicker.min.css', array(), TALASH_VERSION, 'all'  );
		wp_enqueue_style( 'talash-main-css', TALASH_URL . 'assets/css/talash-main.css', array(), TALASH_VERSION, 'all'  );
    }

	public static function scripts() {
		wp_enqueue_script( 'talash-moment', TALASH_URL . 'assets/vendors/date-range-picker/moment.min.js', array( 'jquery' ), TALASH_VERSION, true  );
		wp_enqueue_script( 'talash-daterangepicker', TALASH_URL . 'assets/vendors/date-range-picker/daterangepicker.js', array( 'jquery' ), TALASH_VERSION, true  );
	
		if ( TALASH_ENV_DEV ) {
			wp_enqueue_script( 'talash-main', TALASH_URL . 'assets/js/talash-main.js', array( 'jquery' ), TALASH_VERSION, true  );
		} else {
			wp_enqueue_script( 'talash-main', TALASH_URL . 'assets/js/talash-main.min.js', array( 'jquery' ), TALASH_VERSION, true  );
		}
    }

	public static function public_api() {
		wp_localize_script( 
			'talash-main',
			'talashPublicApi',
			[
				'ajax_url'	=> admin_url( 'admin-ajax.php' ),
                'nonce'		=> wp_create_nonce( 'talash_public_nonce' ),
			]
		);
	}

}
