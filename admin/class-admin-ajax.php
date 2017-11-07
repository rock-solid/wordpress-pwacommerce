<?php
namespace PWAcommerce\Admin;

use \PWAcommerce\Includes\Options;


/**
 * Admin_Ajax class for managing Ajax requests from the admin area of the plugin
 */
class Admin_Ajax {

	/**
	 * Update theme settings.
	 */
	public function settings() {

		if ( current_user_can( 'manage_options' ) ) {

			$response = [
				'status' => 0,
				'message' => 'There was an error. Please reload the page and try again.',
			];

			$changed = 0;

			if ( ! empty( $_POST ) ) {
				$pwacommerce_options = new Options();
				if ( isset( $_POST['pwacommerce_settings_analyticsid'] ) &&
				isset( $_POST['pwacommerce_settings_service_worker_installed'] ) &&
				is_numeric( $_POST['pwacommerce_settings_service_worker_installed'] )) {

					// save analytics id
					$new_analytics_id = sanitize_text_field( $_POST['pwacommerce_settings_analyticsid'] );
					if ( $new_analytics_id !== $pwacommerce_options->get_setting( 'analytics_id' ) ) {

						$changed = 1;
						$pwacommerce_options->update_settings( 'analytics_id', $new_analytics_id );
					}

					// save service worker installed
					$new_service_worker_installed = sanitize_text_field( $_POST['pwacommerce_settings_service_worker_installed']);

					if ( $new_service_worker_installed !== $pwacommerce_options->get_setting( 'service_worker_installed' ) ) {

						$changed = 1;
						$pwacommerce_options->update_settings( 'service_worker_installed', $new_service_worker_installed );
					}


					if ( $changed ) {

						$response['status'] = 1;
						$response['message'] = 'Your settings have been successfully modified!';

					} else {

						$response['message'] = 'Your settings have not changed.';
					}
				}

			} // End if().

			echo wp_json_encode( $response );
		} // End if().

		exit();
	}

	/**
	 * Mark the user as being subscribed to the mailing list.
	 */
	public function subscribe() {

		if ( current_user_can( 'manage_options' ) ) {

			$status = 0;

			if ( isset( $_POST ) && is_array( $_POST ) && ! empty( $_POST ) ) {

				if ( isset( $_POST['pwacommerce_subscribed'] ) && false != $_POST['pwacommerce_subscribed'] ) {

					$pwacommerce_options = new Options();
					$subscribed = $pwacommerce_options->get_setting( 'joined_subscriber_list' );

					if ( false == $subscribed ) {

						$status = 1;
					$pwacommerce_options->update_settings( 'joined_subscriber_list', $_POST['pwacommerce_subscribed'] );
					}
				}
			}

			echo $status;

		}

		exit();
	}

}
