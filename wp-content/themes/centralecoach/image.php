<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header();
?>

	<section id="primary" class="content-area image-attachment">
		<div id="content" class="site-content" role="main">

	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
	?>
			<article id="post-<?php esc_attr( the_ID() ); ?>" <?php esc_html( post_class() ); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-meta">

						<span class="entry-date"><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>

						<span class="full-size-link"><a href="<?php echo esc_url( wp_get_attachment_url() ); ?>"><?php echo intval($metadata['width']); ?> &times; <?php echo intval($metadata['height']); ?></a></span>

						<span class="parent-post-link"><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" rel="gallery"><?php echo esc_html( get_the_title( $post->post_parent ) ); ?></a></span>
						<?php edit_post_link( esc_html__( 'Edit', 'whitelab' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->

				<div class="entry-content">
					<div class="entry-attachment">
						<div class="attachment">
							<img src="<?php echo esc_url(wp_get_attachment_url()); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
						</div><!-- .attachment -->

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div><!-- .entry-caption -->
						<?php endif; ?>
					</div><!-- .entry-attachment -->

					<div id="entry-content-wrapper">
						<?php the_content(); ?>
					</div>
					<?php
						whitelab_paging_nav();
					?>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->

			<?php comments_template(); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_footer();
