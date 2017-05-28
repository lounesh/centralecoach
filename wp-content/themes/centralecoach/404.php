<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content row page_404">
	<div id="primary" class="content-area vc_col-sm-12 vc_col-md-12 vc_col-lg-12">
		<div id="content" class="site-content clearfix" role="main">

			<header class="page-header vc_col-sm-6 vc_col-md-6 vc_col-lg-6">
				<h1 class="page-title animated bounceIn"><?php esc_html_e( '404', 'whitelab' ); ?></h1>
			</header>

			<div class="page-content vc_col-sm-6 vc_col-md-6 vc_col-lg-6">
				<p class="animated bounceIn"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'whitelab' ); ?></p>

				<?php get_search_form(); ?>
			</div><!-- .page-content -->

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
