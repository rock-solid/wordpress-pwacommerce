<?php
namespace PWAcommerce;

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit ();
}

require_once( 'vendor/autoload.php' );
require_once( 'core/config.php' );

$pwacommerce_options = new Includes\Options();

// create uploads folder and define constants
if ( !defined( 'PWACOMMERCE_FILES_UPLOADS_DIR' ) && !defined( 'PWACOMMERCE_FILES_UPLOADS_URL' ) ){
    $pwacommerce_uploads = new Includes\Uploads();
    $pwacommerce_uploads->define_uploads_dir();
}

// remove uploaded images and uploads folder
$pwacommerce_uploads = new Includes\Uploads();
$pwacommerce_uploads->remove_uploads_dir();

$pwacommerce_options->delete_settings($pwacommerce_options->options);

?>
