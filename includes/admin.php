<?php

class WP_HTTP_API_Tester_Admin {

	public function __construct() {

		global $wp_http_api_tester;

		// Register our admin page
		$wp_http_api_tester = add_management_page(
			__( 'HTTP API Tester', 'wp-http-api-tester' ),
			__( 'HTTP API Tester', 'wp-http-api-tester' ),
			'manage_options',
			'wp-http-api-tester',
			array(
				$this,
				'admin_page'
			)
		);

		// Load our scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	public function admin_page() {
		?>
		<style>
		pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
		.string { color: green; }
		.number { color: darkorange; }
		.boolean { color: blue; }
		.null { color: magenta; }
		.key { color: red; }
		</style>
		<div class="wrap">
			<?php screen_icon( 'tools' ); ?>
			<h2><?php _e( 'HTTP API Tester', 'wp-http-api-tester' ); ?></h2>
			<form id="wp-http-api-tester-form" method="post">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="request-method"><?php _e( 'Method', 'wp-http-api-tester' ); ?></label>
						</th>
						<td>
							<select id="request-method" name="request-method">
								<option value="GET">GET</option>
								<option value="POST">POST</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="request-url"><?php _e( 'URL', 'wp-http-api-tester' ); ?></label>
						</th>
						<td>
							<input type="text" id="request-url" name="request-url" class="regular-text" value="http://api.hostip.info/get_json.php" />
							<div class="description"><?php _e( 'The URL you want to send the request to.', 'wp-http-api-tester' ); ?></div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="request-body"><?php _e( 'Body', 'wp-http-api-tester' ); ?></label>
						</th>
						<td>
							<textarea id="request-body" name="request-body" class="large-textarea" cols="50" rows="10">{ "ip":"72.209.183.96"}</textarea>
							<div class="description"><?php _e( 'Paste the data you wish to send in the remote request. It must be JSON.', 'wp-http-api-tester' ); ?></div>
						</td>
					</tr>
				</table>
				<?php wp_nonce_field( 'wp-http-api-nonce', 'wp-http-api-nonce' ); ?>
				<?php submit_button( __( 'Send Request', 'wp-http-api-tester' ) ); ?>
				<img src="<?php echo admin_url( 'images/loading.gif' ); ?>" id="wp-http-test-loader" style="display:none"/>
			</form>
			<div id="wp-http-api-tester-response-wrapper" style="display:none">
				<h4><?php _e( 'Response Data', 'wp-http-api-tester' ); ?></h4>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Code', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-code"></div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Message', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-message"></div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Headers', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-headers"></div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Body', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-body"></div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Errors', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-errors"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php
	}

	public function scripts( $hook ) {

		global $pagenow, $wp_http_api_tester;

		if( $hook != $wp_http_api_tester )
			return;

		wp_enqueue_script( 'wp-http-api-tester', WP_HTTP_API_Tester::$url . 'assets/ajax.js', array( 'jquery' ) );
	}

}
new WP_HTTP_API_Tester_Admin;