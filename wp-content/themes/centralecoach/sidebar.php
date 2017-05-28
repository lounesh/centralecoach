<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */
?>
<?php if ( WHITELAB_LAYOUT  == 'sidebar-left' && is_active_sidebar( 'whitelab-sidebar-1' ) ) : ?>
	<div id="secondary" class="content-sidebar widget-area vc_col-sm-4 vc_col-md-4 vc_col-lg-4">
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'whitelab-sidebar-1' ); ?>
		</div><!-- #primary-sidebar -->
	</div><!-- #secondary -->
<?php endif; ?>