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
		</div>
		<?php
	}

}
new WP_HTTP_API_Tester_Admin;