<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, WhiteLab 1.0
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

get_header();
?>
<div id="main-content" class="main-content row">
	<header class="entry-header">
		<h1 class="entry-title">
			<?php
				if ( is_day() ) :
					printf( wp_kses( __( 'Daily Archives: <span>%s</span>', 'whitelab' ), array( 'span' => array() ) ), get_the_date() );

				elseif ( is_month() ) :
					printf( wp_kses( __( 'Monthly Archives: <span>%s</span>', 'whitelab' ), array( 'span' => array() ) ), get_the_date( _x( 'F Y', 'monthly archives date format', 'whitelab' ) ) );

				elseif ( is_year() ) :
					printf( wp_kses( __( 'Yearly Archives: <span>%s</span>', 'whitelab' ), array( 'span' => array() ) ), get_the_date( _x( 'Y', 'yearly archives date format', 'whitelab' ) ) );

				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					esc_html_e( 'Asides', 'whitelab' );

				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					esc_html_e( 'Images', 'whitelab' );

				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					esc_html_e( 'Videos', 'whitelab' );

				elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
					esc_html_e( 'Audio', 'whitelab' );

				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					esc_html_e( 'Quotes', 'whitelab' );

				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					esc_html_e( 'Links', 'whitelab' );

				elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
					esc_html_e( 'Galleries', 'whitelab' );
				else :
					printf( esc_html__( 'Archive: %s', 'whitelab' ), single_cat_title('', false) );

				endif;
			?>
		</h1>
	</header><!-- .archive-header -->
	<section id="primary" class="content-area <?php echo whitelab_get_site_width(); ?>">
		<div id="content" class="site-content clearfix" role="main">

			<?php if ( have_posts() ) : 

					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
		</div><!-- #content -->
		<?php
			// Previous/next page navigation.
			whitelab_paging_nav();
		?>
	</section><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();