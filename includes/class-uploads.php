<?php

namespace PWAcommerce\Includes;

use \PWAcommerce\Includes\Options;

/**
 * Overall Uploads Management class
 *
 * Instantiates all the uploads and offers a number of utility methods to work with the options
 *
 */
class Uploads
{


	public static $allowed_files = [
		'icon' => [
			'max_width' => 256,
			'max_height' => 256,
			'extensions' => [ 'jpg', 'jpeg', 'png','gif' ]
		],
	];


	public static $manifest_sizes = [ 48, 96, 144, 196, 512 ];

	protected static $htaccess_template = 'frontend/sections/htaccess-template.txt';

	/**
	 *
	 * Define constants with the uploads dir paths
	 *
	 */
	public function define_uploads_dir()
	{
		$wp_uploads_dir = wp_upload_dir();

		$pwacommerce_uploads_dir = $wp_uploads_dir['basedir'] . '/' . PWACOMMERCE_DOMAIN . '/';

		define( 'PWACOMMERCE_FILES_UPLOADS_DIR', $pwacommerce_uploads_dir);
		define( 'PWACOMMERCE_FILES_UPLOADS_URL', $wp_uploads_dir['baseurl'] . '/' . PWACOMMERCE_DOMAIN . '/' );

		add_action( 'admin_notices', [ $this, 'display_admin_notices' ] );
	}


	/**
	 *
	 * Display uploads folder specific admin notices.
	 *
	 */
	public function display_admin_notices()
	{
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		// if the directory doesn't exist, display notice
		if ( !file_exists( PWACOMMERCE_FILES_UPLOADS_DIR ) ) {
			echo '<div class="error"><p><b>Warning!</b> The ' . PWACOMMERCE_PLUGIN_NAME . ' uploads folder does not exist: ' . PWACOMMERCE_FILES_UPLOADS_DIR . '</p></div>';
			return;
		}

		if ( !is_writable( PWACOMMERCE_FILES_UPLOADS_DIR ) ) {
			echo '<div class="error"><p><b>Warning!</b> The ' . PWACOMMERCE_PLUGIN_NAME . ' uploads folder is not writable: ' . PWACOMMERCE_FILES_UPLOADS_DIR . '</p></div>';
			return;
		}
	}


	/**
	 *
	 * Create uploads folder
	 *
	 */
	public function create_uploads_dir()
	{

		$wp_uploads_dir = wp_upload_dir();

		$pwacommerce_uploads_dir = $wp_uploads_dir['basedir'] . '/' . PWACOMMERCE_DOMAIN . '/';

		// check if the uploads folder exists and is writable
		if ( file_exists( $wp_uploads_dir['basedir'] ) && is_dir( $wp_uploads_dir['basedir'] ) && is_writable( $wp_uploads_dir['basedir'] ) ) {

			// if the directory doesn't exist, create it
			if ( !file_exists( $pwacommerce_uploads_dir ) ) {

				mkdir( $pwacommerce_uploads_dir, 0777 );

				// add .htaccess file in the uploads folder
				$this->set_htaccess_file();
			}
		}
	}


	/**
	 *
	 * Clean up the uploads dir when the plugin is uninstalled
	 *
	 */
	public function remove_uploads_dir()
	{
		$pwacommerce_options = new Options();

		$image_path = $pwacommerce_options->get_setting( 'icon' );

		foreach ( self::$manifest_sizes as $manifest_size ) {
			$this->remove_uploaded_file( $manifest_size . $image_path );
		}

		$this->remove_uploaded_file( $image_path );

		// remove htaccess file
		$this->remove_htaccess_file();

		// delete folder
		rmdir( PWACOMMERCE_FILES_UPLOADS_DIR );
	}


	/**
	 * Check if a file path exists in the uploads folder and returns its url.
	 *
	 * @param $file_path
	 * @return string
	 */
	public function get_file_url( $file_path )
	{

		if ( file_exists( PWACOMMERCE_FILES_UPLOADS_DIR . $file_path ) ) {
			return PWACOMMERCE_FILES_UPLOADS_URL . $file_path;
		}

		return '';
	}

	/**
	 * Delete an uploaded file
	 *
	 * @param $file_path
	 * @return bool
	 *
	 */
	public function remove_uploaded_file( $file_path )
	{

		// check the file exists and remove it
		if ( $file_path != '' ) {
			if ( file_exists( PWACOMMERCE_FILES_UPLOADS_DIR . $file_path ) )
				return unlink( PWACOMMERCE_FILES_UPLOADS_DIR . $file_path );
		}
	}

	/**
	 *
	 * Create a .htaccess file with rules for compressing and caching static files for the plugin's upload folder
	 * (css, images)
	 *
	 * @return bool
	 *
	 */
	protected function set_htaccess_file()
	{
		$file_path = PWACOMMERCE_FILES_UPLOADS_DIR . '.htaccess';

		if ( !file_exists( $file_path ) ){

			if ( is_writable( PWACOMMERCE_FILES_UPLOADS_DIR ) ){

				$template_path = PWACOMMERCE_PLUGIN_PATH . self::$htaccess_template;

				if ( file_exists( $template_path ) ){

					$fp = @fopen( $file_path, "w" );
					fwrite( $fp, file_get_contents( $template_path ) );
					fclose( $fp );

					return true;
				}
			}
		}

		return false;
	}

	/**
	 *
	 * Remote .htaccess file with rules for compressing and caching static files for the plugin's upload folder
	 * (css, images)
	 *
	 * @return bool
	 *
	 */
	protected function remove_htaccess_file()
	{

		$file_path = PWACOMMERCE_FILES_UPLOADS_DIR . '.htaccess';

		if ( file_exists( $file_path ) ){
			unlink( $file_path );
		}
	}
}

