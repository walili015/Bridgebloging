<!-- Show this box once the theme is updated -->
<?php 
		$protocol = isset( $_SERVER['https'] ) ? 'https://' : 'http://';
		$vce_ajax_url = admin_url( 'admin-ajax.php', $protocol );
?>
<script>
	(function($) {
		$(document).ready(function() {
				$("body").on('click', '#vce_update_box_hide',function(e){
	    			e.preventDefault();
	    			$(this).parent().remove();
	    			$.post('<?php echo $vce_ajax_url; ?>', {action: 'vce_update_version'}, function(response) {});
    			});

         /*-----------------------------------------------------------------------------------*/
        /* Open popup on post share links
        /*-----------------------------------------------------------------------------------*/
        $('body').on('click', '.mks-twitter-share-button', function(e) {
            e.preventDefault();
            var data = $(this).attr('data-url');
            vce_social_share(data);
        });

        function vce_social_share(data) {
            window.open(data, "Share", 'height=500,width=760,top=' + ($(window).height() / 2 - 250) + ', left=' + ($(window).width() / 2 - 380) + 'resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0');
        }

		});
	})(jQuery);

</script>

<div id="welcome-panel" class="welcome-panel vce-welcome-panel">
	<a href="#" class="welcome-panel-close" id="vce_update_box_hide">Dismiss</a>
	<div class="welcome-panel-content">

		<h2>Congratulations, your website just got better!</h2>
		<p class="about-description">Voice has been successfully updated to version <?php echo THEME_VERSION; ?></a></p>

		<div class="welcome-panel-column-container">

				<div class="welcome-panel-column">
				<h3>What's new?</h3>
				<p>We do our best to keep our themes up-to-date. Take a few moments to see what's added in the latest version.</p>
				<a href="http://demo.mekshq.com/voice/documentation/#changelog" target="_blank" class="button button-primary button-hero">View change log</a>
				</div>

				<div class="welcome-panel-column">
				<h3>We listen to your feedback</h3>
				<p>If you have ideas which might help us make Voice even better, we would love to hear from you!</p>
				<a href="http://mekshq.com/contact" target="_blank" class="button button-primary button-hero">Get in touch</a>
				</div>

				<?php 
				$tweet_text = "I'm very happy using Voice! Check out this great #WordPress theme by @meksHQ";
				$tweet_url = "http://mekshq.com/demo/voice";
				?>

				<div class="welcome-panel-column">
				<h3>Happy with Voice?</h3>
				<p>Why not share the feeling with the world? We would really appreciate it. </p>
				<a href="javascript:void(0);" data-url="http://twitter.com/intent/tweet?url=<?php echo $tweet_url; ?>&amp;text=<?php echo urlencode($tweet_text); ?>" class="mks-twitter-share-button button button-primary button-hero">Tweet about it!</a>
				</div>



		</div>

	</div>

</div>