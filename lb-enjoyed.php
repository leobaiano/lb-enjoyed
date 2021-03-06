<?php
/**
 * Plugin Name: LB Enjoyed
 * Plugin URI: https://github.com/leobaiano/lb-enjoyed
 * Description: Let your visitors bookmark your favorites
 * Author: leobaiano
 * Author URI: https://github.com/leobaiano
 * Version: 0.1.0
 * License: GPLv2 or later
 * Text Domain: lb-enjoyed
 * Domain Path: /languages/
 *
 * @package LB Enjoyed
 * @category Core
 * @author Leo Baiano <ljunior2005@gmail.com>
 */

namespace LBEnjoyed;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * LB Enjoyed
 *
 * @author   Leo Baiano <ljunior2005@gmail.com>
 * @since 0.1.0
 */
class LB_Enjoyed {
	/**
	 * Instance of this class.
	 *
	 * @var object $instance
	 */
	protected static $instance = null;

	/**
	 * Text domain.
	 *
	 * @var string $text_domain
	 */
	protected static $text_domain = 'lb-enjoyed';

	/**
	 * Initialize the plugin
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

		// Load styles and script
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles_and_scripts' ) );

		// Load Class
		add_action( 'init', array( $this, 'includes' ) );

		// Hook: Filter the_content for add favorite icon in post content
		add_filter( 'the_content', array('\LBEnjoyed\Favorite', 'hook_insert_favorite_icon_in_post_content' ) );

		// Add post in favorite list via AJAX
		add_action( 'wp_ajax_nopriv_add_post_in_favorite_list', array('\LBEnjoyed\Favorite_API', 'add_post_in_favorite_list' ) );
		add_action( 'wp_ajax_add_post_in_favorite_list', array('\LBEnjoyed\Favorite_API', 'add_post_in_favorite_list' ) );

		// Remove post in favorite list via AJAX
		add_action( 'wp_ajax_nopriv_remove_post_in_favorite_list', array('\LBEnjoyed\Favorite_API', 'remove_post_in_favorite_list' ) );
		add_action( 'wp_ajax_remove_post_in_favorite_list', array('\LBEnjoyed\Favorite_API', 'remove_post_in_favorite_list' ) );

		// Get favorite list via AJAX
		add_action( 'wp_ajax_nopriv_get_favorite_list', array('\LBEnjoyed\Favorite_API', 'get_favorite_list' ) );
		add_action( 'wp_ajax_get_favorite_list', array('\LBEnjoyed\Favorite_API', 'get_favorite_list' ) );

		add_shortcode( 'lb-favorite-list', array( '\LBEnjoyed\Shortcode_Favorite_List', 'show_shortcode_favorite_list' ) );

		// Hook so other developers can extend the plugin
		do_action( 'lb_enjoyed_loaded' );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( self::$text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Load styles and scripts
	 */
	public function load_styles_and_scripts() {
		// Load main CSS
		wp_enqueue_style( self::$text_domain . '_css_main', plugins_url( '/assets/css/main.css', __FILE__ ), array(), null, 'all' );

		// Load Google Icons
		wp_enqueue_style( self::$text_domain . '_google_icons', '//fonts.googleapis.com/icon?family=Material+Icons', array(), null, 'all' );

		// Variables to pass to the javascript file through wp_localize_script
		$variables_for_localize_script = array(
					'ajax_url'	=> admin_url( 'admin-ajax.php' ),
					'home_url'	=> home_url()
				);

		// Load main JS
		wp_enqueue_script( self::$text_domain . '_js_main', plugins_url( '/assets/js/main.js', __FILE__ ), array( 'jquery' ), null, true );
		wp_localize_script( self::$text_domain . '_js_main', 'data', $variables_for_localize_script );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		include_once( 'class/class-favorite.php' );
		include_once( 'class/class-favorite-api.php' );
		include_once( 'class/class-shortcode-favorite-list.php' );
	}

} // end class LB_Enjoyed();
add_action( 'plugins_loaded', array( '\LBEnjoyed\LB_Enjoyed', 'get_instance' ), 0 );

/**
 * Register Widget Favorite List
 */
include_once( 'class/class-widget-favorite-list.php' );
add_action( 'widgets_init', function(){
	register_widget( 'Widget_Favorite_List' );
});
