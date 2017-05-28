<?php

/*
* Template Name: Blank page template
*/

get_header();

?>
<div id="main" class="site-main container">
	<div id="main-content" class="main-content row">
		<div id="primary" class="content-area <?php echo esc_attr( WHITELAB_LAYOUT ); ?> clearfix <?php echo (WHITELAB_LAYOUT=='sidebar-right'||WHITELAB_LAYOUT=='sidebar-left'?'wl-main-container':''); ?>">
			<div id="content" class="site-content <?php echo esc_attr( whitelab_get_site_width() ); ?>" role="main">

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						// Include the page content template.
						get_template_part( 'content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endwhile;
				?>

			</div><!-- #content -->
			<?php if ( WHITELAB_LAYOUT == 'sidebar-right' || WHITELAB_LAYOUT == 'sidebar-left' ) { ?>
				<div class="wl-col-3 wl-sidebar-container">
					<div class="sidebar-inner">
					<?php
						generated_dynamic_sidebar();
					?>
					</div>
				</div>
			<?php } ?>
		</div><!-- #primary -->
	</div><!-- #main-content -->
</div><!-- #main -->

<?php
get_footer();