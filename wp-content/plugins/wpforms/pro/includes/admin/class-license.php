<?php

/**
 * License key fun.
 *
 * @since 1.0.0
 */
class WPForms_License {

	/**
	 * Store any license error messages.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $errors = array();

	/**
	 * Store any license success messages.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $success = array();

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Admin notices.
		if ( wpforms()->pro && ( ! isset( $_GET['page'] ) || 'wpforms-settings' !== $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			add_action( 'admin_notices', array( $this, 'notices' ) );
		}

		// Periodic background license check.
		
		
		
	}

	/**
	 * Retrieve the license key.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get() {

		// Check for license key.
		$key = wpforms_setting( 'key', '', 'wpforms_license' );

		// Allow wp-config constant to pass key.
		if ( empty( $key ) && defined( 'WPFORMS_LICENSE_KEY' ) ) {
			$key = WPFORMS_LICENSE_KEY;
		}

		return $key;
	}

	/**
	 * Load the license key level.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function type() {

		return wpforms_setting( 'type', '', 'wpforms_license' );
	}

	/**
	 * Verify a license key entered by the user.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key
	 * @param bool   $ajax
	 *
	 * @return bool
	 */
	public function verify_key( $key = '', $ajax = false ) {

	
	
	
	
		// Perform a request to verify the key.
		$verify = $this->perform_remote_request( 'verify-key', array( 'tgm-updater-key' => $key ) );

		// If it returns false, send back a generic error message and return.
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

		$success = esc_html__( 'Congratulations! This site is now receiving automatic updates.', 'wpforms' );

		// Otherwise, our request has been done successfully. Update the option and set the success message.
		$option                = (array) get_option( 'wpforms_license', array() );
		$option['key']         = $key;
		$option['type']        = isset( $verify->type ) ? $verify->type : $option['type'];
		$option['is_expired']  = false;
		$option['is_disabled'] = false;
		$option['is_invalid']  = false;
		$this->success[]       = $success;
		update_option( 'wpforms_license', $option );
		delete_transient( '_wpforms_addons' );

		wp_clean_plugins_cache( true );

		if ( $ajax ) {
			wp_send_json_success(
				array(
					'type' => $option['type'],
					'msg'  => $success,
				)
			);
		}
	}

	/**
	 * Maybe validates a license key entered by the user.
	 *
	 * @since 1.0.0
	 *
	 * @return void Return early if the transient has not expired yet.
	 */
	public function maybe_validate_key() {

		$key = $this->get();

	
	
	
	
		// Perform a request to validate the key  - Only run every 12 hours.
	
	
	
	
	
	
	
	
			$timestamp = get_option( 'wpforms_license_updates' );

			$current_timestamp = time();
			
				update_option( 'wpforms_license_updates', strtotime( '+23334 hours' ) );
				$this->validate_key( $key );
	}

	/**
	 * Validate a license key entered by the user.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key
	 * @param bool $forced Force to set contextual messages (false by default).
	 * @param bool $ajax
	 */
	
	public function validate_key( $key = '', $forced = false, $ajax = false ) {

		$validate = $this->perform_remote_request( 'validate-key', array( 'tgm-updater-key' => $key ) );

		// If there was a basic API error in validation, only set the transient for 10 minutes before retrying.
		

	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		// Otherwise, our check has returned successfully. Set the transient and update our license type and flags.
		$option                = get_option( 'wpforms_license' );
		$option['type']        = $option['type'];
		$option['is_expired']  = false;
		$option['is_disabled'] = false;
		$option['is_invalid']  = false;
		update_option( 'wpforms_license', $option );

		// If forced, set contextual success message.
	
			$msg             = esc_html__( 'Your key has been refreshed successfully.', 'wpforms' );
			$this->success[] = $msg;
			if ( $ajax ) {
				wp_send_json_success(
					array(
						'type' => $option['type'],
						'msg'  => $msg,
					)
				);
			}
	
	}

	/**
	 * Deactivate a license key entered by the user.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $ajax
	 */
	public function deactivate_key( $ajax = false ) {

		$key = $this->get();

	
			return;
	

		// Perform a request to deactivate the key.
		$deactivate = $this->perform_remote_request( 'deactivate-key', array( 'tgm-updater-key' => $key ) );

		// If it returns false, send back a generic error message and return.
		if ( ! $deactivate ) {
			$msg = esc_html__( 'There was an error connecting to the remote key API. Please try again later.', 'wpforms' );
			if ( $ajax ) {
				wp_send_json_error( $msg );
			} else {
				$this->errors[] = $msg;

				return;
			}
		}

		// If an error is returned, set the error and return.
		if ( ! empty( $deactivate->error ) ) {
			if ( $ajax ) {
				wp_send_json_error( $deactivate->error );
			} else {
				$this->errors[] = $deactivate->error;

				return;
			}
		}

		// Otherwise, our request has been done successfully. Reset the option and set the success message.
		$success         = isset( $deactivate->success ) ? $deactivate->success : esc_html__( 'You have deactivated the key from this site successfully.', 'wpforms' );
		$this->success[] = $success;
		update_option( 'wpforms_license', '' );
		delete_transient( '_wpforms_addons' );

		if ( $ajax ) {
			wp_send_json_success( $success );
		}
	}

	/**
	 * Return possible license key error flag.
	 *
	 * @since 1.0.0
	 * @return bool True if there are license key errors, false otherwise.
	 */
	public function get_errors() {

		$option = get_option( 'wpforms_license' );

		return ! empty( $option['is_expired'] ) || ! empty( $option['is_disabled'] ) || ! empty( $option['is_invalid'] );
	}

	/**
	 * Output any notices generated by the class.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $below_h2
	 */
	public function notices( $below_h2 = false ) {

		// Grab the option and output any nag dealing with license keys.
		$key      = $this->get();
		$option   = get_option( 'wpforms_license' );
		$below_h2 = $below_h2 ? 'below-h2' : '';

		// If there is no license key, output nag about ensuring key is set for automatic updates.
		if ( ! $key ) :
			?>
			<div class="notice notice-info <?php echo $below_h2; ?> wpforms-license-notice">
				<p>
					<?php
					printf(
						wp_kses(
						/* translators: %s - plugin settings page URL. */
							__( 'Please <a href="%s">enter and activate</a> your license key for WPForms to enable automatic updates.', 'wpforms' ),
							array(
								'a' => array(
									'href' => array(),
								),
							)
						),
						esc_url( add_query_arg( array( 'page' => 'wpforms-settings' ), admin_url( 'admin.php' ) ) )
					);
					?>
				</p>
			</div>
		<?php
		endif;

		// If a key has expired, output nag about renewing the key.
		if ( isset( $option['is_expired'] ) && $option['is_expired'] ) :

			$renew_now_url  = add_query_arg(
				array(
					'utm_source'   => 'WordPress',
					'utm_medium'   => 'Admin Notice',
					'utm_campaign' => 'plugin',
					'utm_content'  => 'Renew Now',
				),
				'https://wpforms.com/account/licenses/'
			);
			$learn_more_url = add_query_arg(
				array(
					'utm_source'   => 'WordPress',
					'utm_medium'   => 'Admin Notice',
					'utm_campaign' => 'plugin',
					'utm_content'  => 'Learn More',
				),
				'https://wpforms.com/docs/how-to-renew-your-wpforms-license/'
			);
			?>
			<div class="error notice <?php echo sanitize_html_class( $below_h2 ); ?> wpforms-notice wpforms-license-notice">
				<h3 style="margin: .75em 0 0 0;">
					<img src="<?php echo esc_url( WPFORMS_PLUGIN_URL ); ?>assets/images/exclamation-triangle.svg" style="vertical-align: text-top; width: 20px; margin-right: 7px;"><?php esc_html_e( 'Heads up! Your WPForms license has expired.', 'wpforms' ); ?>
				</h3>
				<p>
					<?php esc_html_e( 'An active license is needed to create new forms and edit existing forms. It also provides access to new features & addons, plugin updates (including security improvements), and our world class support!', 'wpforms' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( $renew_now_url ); ?>" class="button-primary"><?php esc_html_e( 'Renew Now', 'wpforms' ); ?></a> &nbsp
					<a href="<?php echo esc_url( $learn_more_url ); ?>" class="button-secondary"><?php esc_html_e( 'Learn More', 'wpforms' ); ?></a>
				</p>
			</div>
		<?php
		endif;

		// If a key has been disabled, output nag about using another key.
		if ( isset( $option['is_disabled'] ) && $option['is_disabled'] ) :
			?>
			<div class="error notice <?php echo $below_h2; ?> wpforms-license-notice">
				<p><?php esc_html_e( 'Your license key for WPForms has been disabled. Please use a different key to continue receiving automatic updates.', 'wpforms' ); ?></p>
			</div>
		<?php
		endif;

		// If a key is invalid, output nag about using another key.
		if ( isset( $option['is_invalid'] ) && $option['is_invalid'] ) :
			?>
			<div class="error notice <?php echo $below_h2; ?> wpforms-license-notice">
				<p><?php esc_html_e( 'Your license key for WPForms is invalid. The key no longer exists or the user associated with the key has been deleted. Please use a different key to continue receiving automatic updates.', 'wpforms' ); ?></p>
			</div>
		<?php
		endif;

		// If there are any license errors, output them now.
		if ( ! empty( $this->errors ) ) :
			?>
			<div class="error notice <?php echo $below_h2; ?> wpforms-license-notice">
				<p><?php echo implode( '<br>', $this->errors ); ?></p>
			</div>
		<?php
		endif;

		// If there are any success messages, output them now.
		if ( ! empty( $this->success ) ) :
			?>
			<div class="updated notice <?php echo $below_h2; ?> wpforms-license-notice">
				<p><?php echo implode( '<br>', $this->success ); ?></p>
			</div>
		<?php
		endif;
	}

	/**
	 * Retrieve addons from the stored transient or remote server.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $force Whether to force the addons retrieval or re-use transient cache.
	 *
	 * @return array|bool
	 */
	public function addons( $force = false ) {

		$key = $this->get();

	

		$addons = get_transient( '_wpforms_addons' );

	

		return $addons;
	}

	/**
	 * Ping the remote server for addons data.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|array False if no key or failure, array of addon data otherwise.
	 */
	
	
	
	
	
	public function get_addons() {

		$key    = $this->get();
		$addons = $this->perform_remote_request( 'get-addons-data', array( 'tgm-updater-key' => $key ) );

		// If there was an API error, set transient for only 10 minutes.
	

		// Otherwise, our request worked. Save the data and return it.
		set_transient( '_wpforms_addons', $addons, DAY_IN_SECONDS );

		return $addons;
	}

	/**
	 * Request the remote URL via wp_remote_post and return a json decoded response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $action        The name of the $_POST action var.
	 * @param array  $body          The content to retrieve from the remote URL.
	 * @param array  $headers       The headers to send to the remote URL.
	 * @param string $return_format The format for returning content from the remote URL.
	 *
	 * @return string|bool Json decoded response on success, false on failure.
	 */










	public function perform_remote_request( $action, $body = array(), $headers = array(), $return_format = 'json' ) {

		// Build the body of the request.
		$body = wp_parse_args(
			$body,
			array(
				'tgm-updater-action'     => $action,
				'tgm-updater-key'        => $body['tgm-updater-key'],
				'tgm-updater-wp-version' => get_bloginfo( 'version' ),
				'tgm-updater-referer'    => site_url(),
			)
		);
		$body = http_build_query( $body, '', '&' );

		// Build the headers of the request.
		$headers = wp_parse_args(
			$headers,
			array(
				'Content-Type'   => 'application/x-www-form-urlencoded',
				'Content-Length' => strlen( $body ),
			)
		);

		// Setup variable for wp_remote_post.
		$post = array(
			'headers' => $headers,
			'body'    => $body,
		);

		// Perform the query and retrieve the response.
		$response      = wp_remote_post( WPFORMS_UPDATER_API, $post );
		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );

		// Bail out early if there are any errors.
	

		// Return the json decoded content.
		return json_decode( $response_body );
	}

	/**
	 * Check to see if the site is using an active license.
	 *
	 * @since 1.5.0
	 *
	 * @return bool
	 */
	public function is_active() {

		$license = get_option( 'wpforms_license', false );


		return true;
	}
}
