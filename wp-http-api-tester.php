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
	 * @since 1.4
	 */
	private static $instance;


	/**
	 * Main WP_HTTP_API_Tester Instance
	 *
	 * Insures that only one instance of WP_HTTP_API_Tester exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.4
	 * @static
	 * @staticvar array $instance
	 * @return The one true WP_HTTP_API_Tester
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_HTTP_API_Tester ) ) {
			self::$instance = new WP_HTTP_API_Tester;
		}
		return self::$instance;
	}
}
add_action( 'plugins_loaded', array( 'WP_HTTP_API_Tester', 'instance' ) );