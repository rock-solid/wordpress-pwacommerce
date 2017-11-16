<?php
namespace PWAcommerce\Admin;

use \PWAcommerce\Includes\Options;
use \PWAcommerce\Includes\Uploads;


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
				is_numeric( $_POST['pwacommerce_settings_service_worker_installed'] ) ) {

					// save analytics id
					$new_analytics_id = sanitize_text_field( $_POST['pwacommerce_settings_analyticsid'] );
					if ( $new_analytics_id !== $pwacommerce_options->get_setting( 'analytics_id' ) ) {

						$changed = 1;
						$pwacommerce_options->update_settings( 'analytics_id', $new_analytics_id );
					}

					// save service worker installed
					$new_service_worker_installed = sanitize_text_field( $_POST['pwacommerce_settings_service_worker_installed'] );

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

	public function wookeys() {
		if ( current_user_can( 'manage_options' ) ) {

			$response = [
				'status' => 0,
				'message' => 'There was an error. Please reload the page and try again.',
			];

			$changed = 0;

			if ( ! empty( $_POST ) ) {

				$pwacommerce_options = new Options();

				if ( isset( $_POST['pwacommerce_wookeys_consumerkey'] ) &&
				isset( $_POST['pwacommerce_wookeys_consumersecret'] ) ) {

					// save consumer key
					$new_consumer_key = sanitize_text_field( $_POST['pwacommerce_wookeys_consumerkey'] );
					if ( $new_consumer_key !== $pwacommerce_options->get_setting( 'consumer_key' ) ) {

						$changed = 1;

						$pwacommerce_options->update_settings( 'consumer_key', $new_consumer_key );
					}

					// save consumer secret
					$new_consumer_secret = sanitize_text_field( $_POST['pwacommerce_wookeys_consumersecret']);

					if ( $new_consumer_secret !== $pwacommerce_options->get_setting( 'consumer_secret' ) ) {

						$changed = 1;
						$pwacommerce_options->update_settings( 'consumer_secret', $new_consumer_secret );
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


	/**
	 *
	 * Method used to save the icon
	 *
	 */
	public function editimages()
	{
		if ( current_user_can( 'manage_options' ) ) {

			$pwacommerce_options = new Options();

			$action = null;

			if ( !empty( $_GET ) && isset( $_GET['type'] ) )
				if ( $_GET['type'] == 'upload' || $_GET['type'] == 'delete' )
					$action = $_GET['type'];

			$arr_response = [
				'status' => 0,
				'messages' => [],
			];

			if ( $action == 'upload' ) {

				if ( !empty( $_FILES ) && sizeof( $_FILES ) > 0 ) {

					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					if ( !function_exists( 'wp_handle_upload' ) )
						require_once( ABSPATH . 'wp-admin/includes/file.php' );

					$default_uploads_dir = wp_upload_dir();

					// check if the upload folder is writable
					if ( !is_writable( PWACOMMERCE_FILES_UPLOADS_DIR ) ){

						$arr_response['messages'][] = "Error uploading image, the upload folder ".PWACOMMERCE_FILES_UPLOADS_DIR." is not writable.";

					} elseif ( !is_writable( $default_uploads_dir['path'] ) ) {

						$arr_response['messages'][] = "Error uploading image, the upload folder ".$default_uploads_dir['path']." is not writable.";

					} else {

						$has_uploaded_files = false;

						foreach ( $_FILES as $file => $info ) {

							if ( !empty( $info['name'] ) ) {

								$has_uploaded_files = true;

								$file_type = null;

								if ( $file == 'pwacommerce_editimages_icon' ) {
									$file_type = 'icon';
								}

								if ( $info['error'] >= 1 || $info['size'] <= 0 && array_key_exists( $file_type, Uploads::$allowed_files ) ) {

									$arr_response['status'] = 0;
									$arr_response["messages"][] = "We encountered a problem processing your image. Please choose another image!";

								} elseif ( $info['size'] > 1048576 ) {

									$arr_response['status'] = 0;
									$arr_response["messages"][] = "Do not exceed the 1MB file size limit when uploading your custom image.";

								} else {

									// make unique file name for the image
									$arrFilename = explode( ".", $info['name'] );
									$fileExtension = end( $arrFilename );

									$arrAllowedExtensions = Uploads::$allowed_files[$file_type]['extensions'];

									// check file extension
									if ( !in_array( strtolower( $fileExtension ), $arrAllowedExtensions ) ) {

										$arr_response['messages'][] = "Error saving image, please add a " . implode( ' or ', $arrAllowedExtensions ) . " image for your icon!";

									} else {

										$uniqueFilename = $file_type . '_' . time() . '.' . $fileExtension;

										// upload to the default uploads folder
										$upload_overrides = [ 'test_form' => false ];
										$movefile = wp_handle_upload( $info, $upload_overrides );

										if ( is_array( $movefile ) ) {

											if ( isset( $movefile['error'] ) ) {

												$arr_response['messages'][] = $movefile['error'];

											} else {

												$copied_and_resized = $this->resize_image( $movefile['file'], $uniqueFilename, $error_message );

												if ( $error_message != '' ){
													$arr_response["messages"][] = $error_message;
												}


												if ( $copied_and_resized ) {


													// delete previous image
													$this->remove_image( $file_type );

													// save option
													$pwacommerce_options->update_settings( $file_type, $uniqueFilename );

													// add path in the response
													$arr_response['status'] = 1;
													$arr_response['uploaded_' . $file_type] = PWACOMMERCE_FILES_UPLOADS_URL . $uniqueFilename;
												}

												// remove file from the default uploads folder
												if ( file_exists( $movefile['file'] ) )
													unlink( $movefile['file'] );
											}
										}
									}
								}
							}
						}

						if ( $has_uploaded_files == false ){
							$arr_response['messages'][] = "Please upload an image!";
						}
					}
				}

			} elseif ( $action == 'delete' ){

				// delete icon

					if ( array_key_exists( $_GET['source'], Uploads::$allowed_files ) ) {

						$file_type = $_GET['source'];

						if ( $file_type === 'icon' ) {

							// get the previous file name from the options table
							$this->remove_image( $file_type );

							// save option with an empty value
							$pwacommerce_options->update_settings( $file_type, '' );

							$arr_response['status'] = 1;
						}
					}
				}

			// echo json with response
			echo json_encode( $arr_response );
		}

		exit();
	}


	/**
	 * Resize & copy image using Wordpress methods
	 *
	 */
	protected function resize_image( $file_path, $file_name, &$error_message = '' )
	{

		$copied_and_resized = false;

		$arrMaximumSize = Uploads::$allowed_files['icon'];

		$image = wp_get_image_editor( $file_path );

		if ( !is_wp_error( $image ) ) {

			$image_size = $image->get_size();

			foreach ( Uploads::$manifest_sizes as $manifest_size ) {

				$manifest_image = wp_get_image_editor( $file_path );
				$manifest_image->resize( $manifest_size, $manifest_size, true );
				$manifest_image->save( PWACOMMERCE_FILES_UPLOADS_DIR . $manifest_size . $file_name );
			}

			// if the image exceeds the size limits
			if ( $image_size['width'] > $arrMaximumSize['max_width'] || $image_size['height'] > $arrMaximumSize['max_height'] ) {

				// resize and copy to the plugin uploads folder
				$image->resize( $arrMaximumSize['max_width'], $arrMaximumSize['max_height'] );
				$image->save( PWACOMMERCE_FILES_UPLOADS_DIR . $file_name );

				$copied_and_resized = true;

			} else {

				// copy file without resizing to the plugin uploads folder
				$copied_and_resized = copy( $file_path, PWACOMMERCE_FILES_UPLOADS_DIR . $file_name );
			}

		} else {

			$error_message = "We encountered a problem resizing your image. Please choose another image!";
		}

		return $copied_and_resized;
	}

	/**
	 *
	 * Remove image
	 *
	 */
	protected function remove_image()
	{
		$pwacommerce_options = new Options();


		// get previous image filename
		$previous_file_path = $pwacommerce_options->get_setting( 'icon' );

		// check the file exists and remove it
		if ($previous_file_path != '') {
			$pwacommerce_uploads = new Uploads();

			foreach ( Uploads::$manifest_sizes as $manifest_size ) {
				$pwacommerce_uploads->remove_uploaded_file( $manifest_size . $previous_file_path );
			}

			return $pwacommerce_uploads->remove_uploaded_file( $previous_file_path );
		}

		return false;
	}

}
