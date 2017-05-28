<?php
/**
 * The Footer Sidebar
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */
?>

<div id="supplementary">
	<div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
		<?php if ( is_active_sidebar( 'whitelab-sidebar-3' ) ) { ?>
			<div class="footer-column-1"><?php dynamic_sidebar( 'whitelab-sidebar-3' ); ?></div>
		<?php } ?>
		<?php if ( is_active_sidebar( 'whitelab-sidebar-4' ) ) { ?>
			<div class="footer-column-2"><?php dynamic_sidebar( 'whitelab-sidebar-4' ); ?></div>
		<?php } ?>
		<?php if ( is_active_sidebar( 'whitelab-sidebar-5' ) ) { ?>
			<div class="footer-column-3"><?php dynamic_sidebar( 'whitelab-sidebar-5' ); ?></div>
		<?php } ?>
	</div><!-- #footer-sidebar -->
</div><!-- #supplementary -->
