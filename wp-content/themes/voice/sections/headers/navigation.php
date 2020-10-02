<nav id="site-navigation" class="main-navigation" role="navigation">
	<?php 
		if(has_nav_menu('vce_main_navigation_menu')) {
				$nav_args = array(
					'theme_location' => 'vce_main_navigation_menu',
					'menu' => 'vce_main_navigation_menu',
					'menu_class' => 'nav-menu',
					'menu_id' => 'vce_main_navigation_menu',
					'container' => false,
					'walker' => new Voice_Menu_Walker
				); 
				wp_nav_menu( $nav_args );
		} else { ?>
			<ul id="vce_header_nav" class="nav-menu"><li>
				<a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Click here to add navigation menu', THEME_SLUG); ?></a>
			</li></ul>
			
		<?php }
	?>
</nav>