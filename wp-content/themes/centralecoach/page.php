<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

get_header();

?>
<div id="main" class="site-main container">
	<div id="main-content" class="main-content row">
		<?php
			// Page title and breadcrumbs.
			if ( !is_front_page() || is_archive() ) {
				echo '<header class="entry-header">';
				the_title( '<h1 class="entry-title">', '</h1>' );
				echo '</header><!-- .entry-header -->';
			}
		?>
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