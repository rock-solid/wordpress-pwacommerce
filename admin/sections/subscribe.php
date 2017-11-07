<?php

$pwacommerce_options = new \PWAcommerce\Includes\Options();
$joined_subscriber_list = $pwacommerce_options->get_setting( 'joined_subscriber_list' );

?>

<div class="container pwacommerce_subscribe_container">
	<h2>News & Updates</h2>
	<hr class="separator" />
	<p>Join our subscribers list and you'll be notified when new themes &amp; features are on their way.</p>
	<div class="spacer-10"></div>
	<?php if ( false == $joined_subscriber_list ) : ?>
		<form id="pwacommerce_subscribe_form" name="pwacommerce_subscribe_form" method="post">
			<input name="pwacommerce_subscribe_email" id="pwacommerce_subscribe_email" type="text" placeholder="Your e-mail address" class="small" value="<?php echo get_option( 'admin_email' );?>" />
			<div class="spacer-0"></div>
			<p class="field-message error" id="error_email_container"></p>
			<div class="spacer-0"></div>
			<a class="button button-primary button-large" href="javascript:void(0)" id="pwacommerce_subscribe_send_btn">Subscribe</a>
		</form>
	<?php endif;?>
	<div id="pwacommerce_subscribe_added" class="added" style="display: <?php echo $joined_subscriber_list ? 'block' : 'none'?>;">
		<div class="switcher blue">
			<div class="msg">SUBSCRIBED</div>
			<div class="check"><span class="dashicons dashicons-yes"></span></div>
		</div>
		<div class="spacer-15"></div>
	</div>
</div>
<div class="spacer-15"></div>

<?php if ( false == $joined_subscriber_list ) : ?>
<script type="text/javascript">
	if (window.PWACJSInterface && window.PWACJSInterface != null){
		jQuery(document).ready(function(){
			window.PWACJSInterface.add("UI_subscribe",
			"PWACOMMERCE_SUBSCRIBE",
				{
					'DOMDoc':       window.document,
					'container' :   window.document.getElementById('pwacommerce_subscribe_container'),
					'submitURL' :   '<?php echo PWACOMMERCE_SUBSCRIBE_PATH;?>'
				},
				window
			);
		});
	}
</script>
<?php endif;?>
