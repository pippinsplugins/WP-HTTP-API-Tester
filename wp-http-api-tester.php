<?php
/*
 * Plugin Name: WP HTTP API Tester
 * Description: Provides an interface for testing remote requests via the WP HTTP API
 * Author: Pippin Williamson
 * Contributors: mordauk
 * Version: 0.1
 */


class WP_HTTP_API_Tester {

	/**
	 * @var WP_HTTP_API_Tester The one true WP_HTTP_API_Tester
	 * @since 1.0
	 */
	private static $instance;

	/**
	 *  Plugin path
	 *
	 * @var string
	 * @since 1.0
	 */
	private $path;

	/**
	 *  Plugin url
	 *
	 * @var string
	 * @since 1.0
	 */
	private $url;


	/**
	 * Main WP_HTTP_API_Tester Instance
	 *
	 * Insures that only one instance of WP_HTTP_API_Tester exists in memory at any one
	 * time.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @return The one true WP_HTTP_API_Tester
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_HTTP_API_Tester ) ) {

			self::$instance = new WP_HTTP_API_Tester;

			if( ! is_admin() ) {
				return;
			}

			self::$instance->setup_vars();
			self::$instance->includes();

		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_vars() {

		$this->path = plugin_dir_path( __FILE__ );
		$this->url  = plugin_dir_url( __FILE__ );

	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		global $edd_options;

		require_once  $this->path . 'includes/admin.php';

	}
}
add_action( 'plugins_loaded', array( 'WP_HTTP_API_Tester', 'instance' ) );