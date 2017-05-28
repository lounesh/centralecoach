<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

get_header();

?>

<div id="main-content" class="main-content row">
	<?php if ( is_single() && !is_home() ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		echo '
		<div class="db-single-image'.(!isset($img['0'])?' no-image':'').'">
			<div class="db-single-overlay"></div>
		</div>';
	} ?>
	<div id="primary" class="content-area <?php echo esc_attr( WHITELAB_LAYOUT ); ?> clearfix <?php echo (WHITELAB_LAYOUT=='sidebar-right'||WHITELAB_LAYOUT=='sidebar-left'?'wl-main-container':''); ?>">
		<div id="content" class="site-content <?php echo esc_attr( whitelab_get_site_width() ); ?>" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */

					get_template_part( 'content', get_post_format() ? get_post_format() : get_post_type() );

					?><div class="clearfix"></div><?php

					// More posts like this
					if ( function_exists('whitelab_the_related_posts') ) { whitelab_the_related_posts(); }

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

<?php
get_footer();