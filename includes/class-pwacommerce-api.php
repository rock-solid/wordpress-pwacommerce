<?php
namespace PWAcommerce\Includes;

use Automattic\WooCommerce\Client;
use \PWAcommerce\Includes\Options;



class PWAcommerce_API
{
	protected function get_client() {

		$pwacommerce_options = new Options();

		return new Client(
			get_site_url(),
			$pwacommerce_options->get_setting('consumer_key'),
			$pwacommerce_options->get_setting('consumer_secret'),
			[
				'wp_api' => true,
				'version' => 'wc/v2',
			]
		);
	}

	public function register_woocommerce_routes() {
		$pwacommerce_options = new Options();

		if ( $pwacommerce_options->get_setting('consumer_key') !== '' &&
		$pwacommerce_options->get_setting('consumer_secret') !== '' ) {

			register_rest_route( 'pwacommerce', '/export-config', [
				'methods' => 'GET',
				'callback' => [ $this, 'export_config' ],
			]);

			register_rest_route( 'pwacommerce', '/categories', [
				'methods' => 'GET',
				'callback' => [ $this, 'view_categories' ]
			]);

			register_rest_route( 'pwacommerce', '/product/(?P<id>\d+)', [
				'methods' => 'GET',
				'callback' => [ $this, 'view_product' ]
			]);

			register_rest_route( 'pwacommerce', '/reviews/(?P<id>\d+)', [
				'methods' => 'GET',
				'callback' => [ $this, 'view_reviews' ]
			]);

			register_rest_route( 'pwacommerce', '/products', [
				'methods' => 'GET',
				'callback' => [ $this, 'view_products' ],
				'args' => [
					'categId' => [
						'required' => false,
						'type' => 'integer',
					],
				],
			]);

			register_rest_route( 'pwacommerce', '/product-variations/(?P<id>\d+)', [
				'methods' => 'GET',
				'callback' => [ $this, 'view_product_variations' ],
			]);

			register_rest_route( 'pwacommerce', '/proceed-checkout', [
				'methods' => 'POST',
				'callback' => [ $this, 'checkout_redirect' ],
			]);
		}
	}

	public function export_config( \WP_REST_Request $request ) {
		$api_url = get_site_url( null, '/wp-json/pwacommerce/' );

		$woocommerce = $this->get_client();

		$currency_settings = $woocommerce->get( 'settings/general/woocommerce_currency');
		$currency = $currency_settings['value'];

		$config = [
			'ENDPOINTS' => [
				'API_CATEGORIES_URL' => $api_url . 'categories/',
				'API_PRODUCTS_URL' => $api_url . 'products/',
				'API_PRODUCT_URL' => $api_url . 'product/',
				'API_REVIEWS_URL' => $api_url . 'reviews/',
				'API_VARIATIONS_URL' => $api_url . 'product-variations/',
				'API_CHECKOUT_URL' => $api_url . 'proceed-checkout/',
			],
			'CURRENCY' => $currency,
		];

		echo wp_json_encode($config);
		exit();
	}

	public function checkout_redirect ( \WP_REST_Request $request ) {


		$products = json_decode($request['items'], true);

		do_action( 'woocommerce_set_cart_cookies', TRUE );
		global $woocommerce;

		foreach( $products as $product ) {

			if  ( isset( $product['id'] ) && isset( $product['quantity'] ) && is_numeric( $product['id']) && is_numeric( $product['quantity'] ) )  {

				if ( isset( $product['variationId']) && is_numeric( $product['variationId'] ) ) {
					$woocommerce->cart->add_to_cart($product['id'], $product['quantity'], $product['variationId'] );
				} else {
					$woocommerce->cart->add_to_cart($product['id'], $product['quantity']);
				}

			}
		}


		wp_redirect($woocommerce->cart->get_checkout_url());
		exit();

	}

	public function view_categories( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();
		return $woocommerce->get( 'products/categories' );

	}

	public function view_reviews( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();
		$id = $request->get_param('id');
		return $woocommerce->get( "products/$id/reviews" );
	}

	public function view_product( \WP_REST_Request $request ){
		$woocommerce = $this->get_client();
		$id = $request->get_param('id');
		return $woocommerce->get( "products/$id" );
	}

	public function view_products( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();

		if ( isset( $request['categId'] ) )  {
			return $woocommerce->get('products', array('category' => $request['categId'] ) );
		}

		$featured = $woocommerce->get('products', array('featured' => true));

		if ( !empty( $featured ) ) {
			return $featured;
		}

		return $woocommerce->get('products', array('per_page' => 10, 'orderby' => 'date'));

	}

	public function view_product_variations( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();
		$id = $request->get_param('id');
		return $woocommerce->get("products/$id/variations", array('per_page' => 100));
	}
}

