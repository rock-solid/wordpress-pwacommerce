<?php
$pwacommerce_options = new \PWAcommerce\Includes\Options();

$analytics_id = $pwacommerce_options->get_setting( 'analytics_id' );
$service_worker_installed = $pwacommerce_options->get_setting( 'service_worker_installed' );
?>


<script type="text/javascript">
	if (window.PWACJSInterface && window.PWACJSInterface != null){
		jQuery(document).ready(function(){

			PWACJSInterface.localpath = "<?php echo plugins_url() . '/' . PWACOMMERCE_DOMAIN . '/'; ?>";

			PWACJSInterface.init();
		});
	}
</script>

<div id="pwacommerce-admin">
	<div class="wrap">
		<div class="left-side">
			<div class="title_section">
				<h1 class="wp-heading-inline">PWAcommerce</h1>
			</div>
			<hr class="separator" />
			<form name="pwacommerce_settings_form" id="pwacommerce_settings_form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=pwacommerce_settings" method="post">
				<label class="textinput">Google Analytics ID:</label>
				<input
					type="text"
					name="pwacommerce_settings_analyticsid"
					id="pwacommerce_settings_analyticsid"
					value="<?php echo esc_attr($analytics_id); ?>"
					placeholder="UA-xxxxxx-01"
				>
				</input> <br/>
				<p class="field-message error" id="error_analyticsid_container"></p>
				<div class="spacer-10"></div>
				<input type="hidden" name="pwacommerce_settings_service_worker_installed" id="pwacommerce_settings_service_worker_installed" value="<?php echo esc_attr($service_worker_installed);?>" />
				<input type="checkbox" name="pwacommerce_settings_service_worker_installed_check" id="pwacommerce_settings_service_worker_installed_check" value="0" <?php if ($service_worker_installed == 1) echo "checked" ;?> />
				<label for ="pwacommerce_settings_service_worker_installed_check">Service Worker Installed</label>
				<div class="spacer-30"></div>
				<a href="javascript:void(0)" id="pwacommerce_settings_send_btn" class="button button-primary button-large">Save</a>
			</form>
		</div>
		<div class="right-side">
			<?php include_once( PWACOMMERCE_PLUGIN_PATH . 'admin/sections/subscribe.php' ); ?>
			<div class="spacer-0"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	if (window.PWACJSInterface && window.PWACJSInterface != null){
		jQuery(document).ready(function(){

			window.PWACJSInterface.add("UI_settings","PWACOMMERCE_SETTINGS",{'DOMDoc':window.document}, window);
		});
	}
</script>


