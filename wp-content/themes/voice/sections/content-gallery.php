<article id="post-<?php the_ID(); ?>" <?php post_class( 'vce-single' ); ?>>

	<header class="entry-header">
		<?php if ( vce_get_post_display( 'show_cat' ) ) : ?>
			<span class="meta-category"><?php echo vce_get_category(); ?></span>
		<?php endif; ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta"><?php echo vce_get_meta_data( 'single' ); ?></div>
	</header>
	<?php if ( $gallery = hybrid_media_grabber( array( 'type' => 'gallery', 'split_media' => true ) ) ): ?>
	 	<div class="meta-media">
			<?php echo $gallery; ?>
		</div>
	<?php endif; ?>

    <?php if ( vce_get_post_display( 'show_headline' ) && has_excerpt() ) : ?>
	    <div class="entry-headline">
	    	<?php the_excerpt(); ?>
	    </div>
    <?php endif; ?>

    <?php get_template_part('sections/ads/above-single'); ?>
    
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '', 'after' => '', 'next_or_number' => 'next' ) ); ?>
	</div>

	<?php if ( vce_get_post_display( 'show_tags' ) ) : ?>
		<footer class="entry-footer">
			<div class="meta-tags">
				<?php the_tags( false, ' ', false ); ?>
			</div>
		</footer>
	<?php endif; ?>

	<?php if ( vce_get_option( 'show_share' ) ) : ?>
	  	<?php get_template_part( 'sections/share-bar' ); ?>
	<?php endif; ?>

	<?php get_template_part('sections/ads/below-single'); ?>

</article>