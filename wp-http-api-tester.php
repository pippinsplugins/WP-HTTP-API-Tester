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
	public static $path;

	/**
	 *  Plugin url
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $url;


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

			add_action( 'wp_ajax_http_api_test', array( self::$instance, 'process_request' ) );

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

		self::$path = plugin_dir_path( __FILE__ );
		self::$url  = plugin_dir_url( __FILE__ );

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

		require_once self::$path . 'includes/admin.php';

	}

	public function process_request() {

		if( empty( $_POST['data'] ) )
			die(-1);

		parse_str( $_POST['data'], $data );

		$url      = sanitize_text_field( $data['request-url'] );
		$method   = 'GET';
		$body     = sanitize_text_field( stripslashes( $data['request-body'] ) );
		$response = array(
			'errors' => array()
		);

		// Make sure valid JSON was provided
		if( ! self::is_json( $body ) ) {
			$response['errors']['invalid_json'] = __( 'The JSON you entered is invalid.', 'wp-http-api-tester' );
		}

		// Make sure valid URL was provided
		if( ! self::is_url( $url ) ) {
			$response['errors']['invalid_url'] = __( 'The URL you entered is invalid.', 'wp-http-api-tester' );
		}

		// The provided data appears valid, attempt a query
		if( empty( $response['errors'] ) ) {

			switch( $method ) {

				case 'POST' :

					$args         = array();
					$args['body'] = (array)json_decode( $body );
					$request      = wp_remote_post( $url, $args );

					if( ! is_wp_error( $request ) ) {

						$response['body']    = wp_remote_retrieve_body( $request );
						$response['headers'] = wp_remote_retrieve_headers( $request );
						$response['code']    = wp_remote_retrieve_response_code( $request );
						$response['message'] = wp_remote_retrieve_response_message( $request );

					} else {
						$response['error'] = $request;
					}

					break;

				case 'GET' :
				default    :

					$args    = (array)json_decode( $body );
					$url     = add_query_arg( $args, $url );
					$request = wp_remote_get( $url );

					if( ! is_wp_error( $request ) ) {

						$response['body']    = wp_remote_retrieve_body( $request );
						$response['headers'] = wp_remote_retrieve_headers( $request );
						$response['code']    = wp_remote_retrieve_response_code( $request );
						$response['message'] = wp_remote_retrieve_response_message( $request );

					} else {
						$response['error'] = $request;
					}

					break;
			}

		}

		// Send our response back
		echo json_encode( $response );
		exit;

	}

	private static function is_json( $string ) {
		json_decode( $string );
		return ( json_last_error() == JSON_ERROR_NONE );
	}

	private static function is_url( $string ) {
		return filter_var( $string, FILTER_VALIDATE_URL ) !== FALSE;
	}
}
add_action( 'plugins_loaded', array( 'WP_HTTP_API_Tester', 'instance' ) );