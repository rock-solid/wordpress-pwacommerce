<?php
use  PWAcommerce\Frontend\Frontend_Init;

global $woocommerce;

$frontend = new Frontend_Init();

$app_settings = $frontend->load_app_settings();

$site_name =  get_bloginfo( 'name' );

$api_url = get_site_url( null, '/wp-json/pwacommerce/' );

$theme_path = plugins_url() . '/' . PWACOMMERCE_DOMAIN . '/frontend/themes/app/';

$config = [
	'API_CATEGORIES_URL' => $api_url . 'categories/',
	'API_PRODUCTS_URL' => $api_url . 'products/',
	'API_PRODUCT_URL' => $api_url . 'product/',
	'API_REVIEWS_URL' => $api_url . 'reviews/',
	'API_VARIATIONS_URL' => $api_url . 'product-variations/',
	'API_CHECKOUT_URL' => $api_url . 'proceed-checkout/',
	'CURRENCY' => get_woocommerce_currency_symbol(),
	'SHOP_NAME' => $site_name,
];

$config_json = wp_json_encode( $config );

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="theme-color" content="#a333c8">
    <link rel="shortcut icon" href="/favicon.ico">
	<?php if ( $app_settings['icon'] != '' ): ?>
		<link rel="apple-touch-icon" href="<?php echo $app_settings['icon'];?>" />
    <?php endif;?>

	<link rel="manifest" href="<?php echo  $api_url . 'export-manifest/' ?>">

    <title><?php echo esc_html($site_name); ?></title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.12/semantic.min.css">
    <script type="text/javascript" pagespeed_no_defer="">
        window.appticles = {
            config: <?php echo $config_json ?>
        }
    </script>
	<link href="<?php echo $theme_path;?>css/main.ce5e7d76.css" rel="stylesheet">
</head>

<body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root" style="height:100%"></div>
	<script type="text/javascript" src="<?php echo $theme_path;?>js/main.1cc2cde6.js"></script>
</body>

<?php if ($app_settings['service_worker_installed'] === '1'): ?>
	<script>
		if ('serviceWorker' in navigator) {
			navigator.serviceWorker.register('/sw.js');
		}
	</script>
<?php endif; ?>

<?php
	// check if google analytics id was set
	if ($app_settings['analytics_id'] != ''):
?>

	<script type="text/javascript" pagespeed_no_defer="">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $app_settings['analytics_id'];?>']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>

<?php endif;?>

</html>
