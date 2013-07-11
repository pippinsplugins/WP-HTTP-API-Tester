<?php

class WP_HTTP_API_Tester_Admin {

	public function __construct() {
		add_management_page(
			__( 'HTTP API Tester', 'wp-http-api-tester' ),
			__( 'HTTP API Tester', 'wp-http-api-tester' ),
			'manage_options',
			'wp-http-api-tester',
			array(
				$this,
				'admin_page'
			)
		);
	}

	public function admin_page() {
		?>
		<div class="wrap">
			<?php screen_icon( 'tools' ); ?>
			<h2><?php _e( 'HTTP API Tester', 'wp-http-api-tester' ); ?></h2>
			<form id="wp-http-api-tester-form" method="post">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="request-url"><?php _e( 'URL', 'wp-http-api-tester' ); ?></label>
						</th>
						<td>
							<input type="text" id="request-url" name="request-url" class="regular-text" value="" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="request-body"><?php _e( 'Body', 'wp-http-api-tester' ); ?></label>
						</th>
						<td>
							<textarea id="request-body" name="request-body" class="large-textarea" cols="50" rows="10"></textarea>
							<div class="description"><?php _e( 'Paste the data you wish to send in the remote request. It must be JSON.', 'wp-http-api-tester' ); ?></div>
						</td>
					</tr>
				</table>
				<?php submit_button( __( 'Send Request', 'wp-http-api-tester' ) ); ?>
			</form>
			<h4><?php _e( 'Response Data', 'wp-http-api-tester' ); ?></h4>
			<div id="wp-http-api-tester-response-wrapper">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Code', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-code"></div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Response Body', 'wp-http-api-tester' ); ?></th>
						<td>
							<div id="response-body"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php
	}

}
new WP_HTTP_API_Tester_Admin;