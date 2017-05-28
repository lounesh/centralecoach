<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */
?>

<article id="post-<?php esc_attr( the_ID() ); ?>" <?php esc_html( post_class() ); ?>>
	<h1 class="hidden"></h1>
	<div class="entry-content">
		<div id="entry-content-wrapper" class="clearfix">
			<?php
				the_content();
			?>
		</div>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'whitelab' ) . '</span>',
				'after'       => '<div class="clearfix"></div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->