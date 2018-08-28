<?php
$pwacommerce_options = new \PWAcommerce\Includes\Options();

$analytics_id = $pwacommerce_options->get_setting( 'analytics_id' );
$service_worker_installed = $pwacommerce_options->get_setting( 'service_worker_installed' );
$consumer_key = $pwacommerce_options->get_setting( 'consumer_key' );
$consumer_secret = $pwacommerce_options->get_setting( 'consumer_secret' );

$icon_path = $pwacommerce_options->get_setting( 'icon' );

if ( $icon_path != "" ) {

	if ( !file_exists( PWACOMMERCE_FILES_UPLOADS_DIR . $icon_path ) )
		$icon_path = '';
	else
		$icon_path = PWACOMMERCE_FILES_UPLOADS_URL . $icon_path;
}
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
				<h1 class="wp-heading-inline">PWACommerce</h1>
				<p>Mobile plugin that helps you transform your WooCommerce shop into a Progressive Web Application.</p>
			</div>
			<hr class="separator" />
			<div class="theme-switcher">
				<div class="active">
					<img  src="<?php echo plugins_url() . '/' . PWACOMMERCE_DOMAIN . "/admin/images/default-theme.png"; ?>" />
					<h2 class="theme-name">Default Theme</h2>
				</div>
			</div>
			<div class="spacer-10"></div>
			<h2>General Settings</h2>
			<hr class="separator" />
			<form name="pwacommerce_settings_form" id="pwacommerce_settings_form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=pwacommerce_settings" method="post">
				<label class="textinput">Google Analytics ID:</label>
				<input
					type="text"
					name="pwacommerce_settings_analyticsid"
					id="pwacommerce_settings_analyticsid"
					value="<?php echo esc_attr($analytics_id); ?>"
					placeholder="UA-xxxxxx-01"
				/>
				<br/>
				<p class="field-message error" id="error_analyticsid_container"></p>
				<div class="spacer-10"></div>
				<input type="hidden" name="pwacommerce_settings_service_worker_installed" id="pwacommerce_settings_service_worker_installed" value="<?php echo esc_attr($service_worker_installed);?>" />
				<input type="checkbox" name="pwacommerce_settings_service_worker_installed_check" id="pwacommerce_settings_service_worker_installed_check" value="0" <?php if ($service_worker_installed == 1) echo "checked" ;?> />
				<label for ="pwacommerce_settings_service_worker_installed_check">Service Worker Installed</label>
				<div class="spacer-30"></div>
				<a href="javascript:void(0)" id="pwacommerce_settings_send_btn" class="button button-primary button-large">Save</a>
			</form>
			<div class="spacer-10"></div>
			<h2>WooCommerce Keys</h2>
			<hr class="separator" />
			<form name="pwacommerce_wookeys_form" id="pwacommerce_wookeys_form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=pwacommerce_wookeys" method="post">
				<p class="field-message error" id="error_consumerkey_container"></p>
				<div class="spacer-10"></div>
				<label class="textinput">Consumer Key:</label>
				<input
					type="text"
					name="pwacommerce_wookeys_consumerkey"
					id="pwacommerce_wookeys_consumerkey"
					value="<?php echo $consumer_key == '' ? esc_attr($consumer_key) : "*******************************************" ?>"
					placeholder="ck_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
				/>
				<br/>
				<p class="field-message error" id="error_consumersecret_container"></p>
				<div class="spacer-10"></div>
				<label class="textinput">Consumer Secret:</label>
				<input
					type="text"
					name="pwacommerce_wookeys_consumersecret"
					id="pwacommerce_wookeys_consumersecret"
					value="<?php echo $consumer_secret == '' ? esc_attr($consumer_secret) : "*******************************************" ?>"
					placeholder="cs_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
				/>
				<br/>
				<p class="field-message error" id="error_consumersecret_container"></p>
				<div class="spacer-10"></div>
				<a href="javascript:void(0)" id="pwacommerce_wookeys_send_btn" class="button button-primary button-large">Save</a>
			</form>
			<h2>Add to Homescreen Icon</h2>
			<hr class="separator" />
			<p>
				Add an icon(<strong>jpg, jpeg, png, gif</strong>) so that customers will be prompted to add your app to their homescreen.<br/><br/>
				After the icon is added, copy the 'sw.js' file which is located in the 'pwacommerce' plugin directory to the root of your domain '/' using FTP and make sure to enable the <strong>Service Worker Installed</strong> checkbox from the <strong>General Settings</strong> section.
			</p>
			<form name="pwacommerce_editimages_form" id="pwacommerce_editimages_form" action="<?php echo admin_url('admin-ajax.php'); ?>?action=pwacommerce_editimages&type=upload" method="post" enctype="multipart/form-data">

				<!-- upload icon field -->
				<div class="pwacommerce_editimages_uploadicon" style="display: <?php echo $icon_path == '' ? 'block' : 'none';?>;">

					<div class="custom-upload">

						<input type="file" id="pwacommerce_editimages_icon" name="pwacommerce_editimages_icon" />
						<div class="fake-file">
							<input type="text" id="fakefileicon" disabled="disabled" />
							<a href="#" class="button button-secondary">Browse</a>
						</div>

						<a href="javascript:void(0)" id="pwacommerce_editimages_icon_removenew" class="remove" style="display: none;">
							<img  src="<?php echo plugins_url() . '/' . PWACOMMERCE_DOMAIN . "/admin/images/btn_close_msg.png"; ?>" />
						</a>
					</div>
					<!-- cancel upload icon button -->
					<div class="pwacommerce_editimages_changeicon_cancel cancel-link" style="display: none;">
						<a href="javascript:void(0);" class="cancel">cancel</a>
					</div>
					<p class="field-message error" id="error_icon_container"></p>

				</div>

				<!-- icon image -->
				<div class="pwacommerce_editimages_iconcontainer display-icon" style="display: <?php echo $icon_path != '' ? 'block' : 'none';?>;;">

					<img src="<?php echo $icon_path;?>" id="pwacommerce_editimages_currenticon" />

					<!-- edit/delete icon links -->
					<a href="javascript:void(0);" class="pwacommerce_editimages_changeicon button button-secondary change">Change</a>
					<a href="#" class="pwacommerce_editimages_deleteicon remove ">remove</a>
				</div>

				<div class="spacer-20"></div>
				<a href="javascript:void(0);" id="pwacommerce_editimages_send_btn" class="button button-primary button-large">Save</a>
			</form>

			<div class="spacer-10"></div>
			<div class="title_section">
				<h1 class="wp-heading-inline">PWACommerce PRO</h1>
			</div>
			<hr class="separator" />
			<div align="center">
			<h2>Order WooCommerce Progressive Web App PRO Now!</h2>
			<p>&#9989; 3 Domain Licenses &#9989; Unlimited Web Push Notifications &#9989; 12 Months Priority Support & Product Updates</p>
			<table> <tbody> <tr> <td><a href="http://pwacommerce.com/downloads/progressive-web-app-for-woocommerce-pro/"><img class="aligncenter" src="http://d3oqwjghculspf.cloudfront.net/github/pwa-theme-woocommerce/rLAB49Z.gif" alt="demo"></a></td> <td><a href="http://pwacommerce.com/downloads/progressive-web-app-for-woocommerce-pro/"><img class="aligncenter" src="http://d3oqwjghculspf.cloudfront.net/github/pwa-theme-woocommerce/GdyeKjo.gif" alt="demo"></a></td> <td><a href="http://pwacommerce.com/downloads/progressive-web-app-for-woocommerce-pro/"><img class="aligncenter" src="http://d3oqwjghculspf.cloudfront.net/github/pwa-theme-woocommerce/3AUek71.gif" alt="demo"></a></td> </tr> </tbody> </table>

			<ul>
				<li><strong>&#9758; WEB PUSH NOTIFICATIONS &#9756;</strong> <br/> <p>Remind or re-engage your mobile users even after they leave your app. Web push notifications can help you increase engagement by 4X and those users spend twice as much time on the app.</p></li>
				<li><strong>&#9758; IMPROVED CONVERSIONS &#9756;</strong> <br/> <p>Alibaba.com is the world’s largest online business-to-business (B2B) trading platform, serving 200+ countries and regions. After upgrading their site to a Progressive Web App (PWA), they saw a 76 percent increase in total conversions across browsers.</p></li>
				<li><strong>&#9758; OFFLINE MODE &#9756;</strong> <br/> <p>53% of users will abandon a site if it takes longer than 3 seconds to load! The mobile app theme responds quickly to user interactions with silky smooth animations and no janky scrolling</p></li>
			</ul>

			<a href="http://pwacommerce.com/downloads/progressive-web-app-for-woocommerce-pro/" id="pwacommerce_settings_send_btn" class="button button-primary button-large">Order PRO Now</a>
			</div>
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
			window.PWACJSInterface.add("UI_editimages","PWACOMMERCE_EDIT_IMAGES",{'DOMDoc':window.document}, window);
			window.PWACJSInterface.add("UI_wookeys","PWACOMMERCE_WOOKEYS",{'DOMDoc':window.document}, window);
		});
	}
</script>


