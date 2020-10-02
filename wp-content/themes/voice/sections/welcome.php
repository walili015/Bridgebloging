<!-- This is a welcome message that displays on theme activation -->
<?php 
		$protocol = isset( $_SERVER['https'] ) ? 'https://' : 'http://';
		$vce_ajax_url = admin_url( 'admin-ajax.php', $protocol );
?>
<script>
	(function($) {
		$(document).ready(function() {
				$("body").on('click', '#vce_welcome_box_hide',function(e){
	    			e.preventDefault();
	    			$(this).parent().fadeOut(300).remove();
	    			$.post('<?php echo $vce_ajax_url; ?>', {action: 'vce_hide_welcome'}, function(response) {});
    			});
		});
	})(jQuery);

</script> 

<div id="welcome-panel" class="welcome-panel vce-welcome-panel">
	<a href="#" class="welcome-panel-close" id="vce_welcome_box_hide">Dismiss</a>
	<div class="welcome-panel-content">
	
		<h2>Thank you for choosing <?php echo THEME_NAME; ?>!</h2>
		<p class="about-description">We really appreciate your trust and support.</p>
		
		<div class="welcome-panel-column-container">

			<div class="welcome-panel-column">
				<h3>1. Get Started</h3>
				<p>We suggest that you first install our recommended plugins which will enhance the theme functionality and provide you with the best experience.</p>
				<a class="button button-primary button-hero" href="<?php echo esc_url(admin_url('themes.php?page=install-required-plugins')); ?>">Install plugins</a>
			</div>

			<div class="welcome-panel-column">
				<h3>2. Import Demo</h3>
				<p>
					If you want your website to look very similar to our demo, you can use our one-click demo importer and start tweaking from that point.
				</p>
				<?php 
					$demo_import_tab = 22; 
					if( vce_is_woocommerce_active() ){ $demo_import_tab++; }
					if( vce_is_bbpress_active() ){ $demo_import_tab++; }

				?>
				<a class="button button-primary button-hero" href="<?php echo esc_url(admin_url('admin.php?page=vce_options&tab='.$demo_import_tab)); ?>">Import demo</a>
				
			</div>

			<div class="welcome-panel-column welcome-panel-last">
				<h3>3. Explore Features</h3>
				<p>We provide you with a full documentation to make sure you can easily setup and fully customize the theme to your liking.</p>
				<a class="button button-primary button-hero" href="http://demo.mekshq.com/voice/documentation" target="_blank">Learn more</a> <span class="vce-customize-welcome">or <a href="<?php echo esc_url(admin_url('admin.php?page=vce_options')); ?>">start customizing</a> now</span>.
			</div>

		</div>

	</div>

</div>