<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

$footer_style = esc_attr( get_theme_mod('whitelab_footer_style', 'default') );
$main_settings = get_option( 'db_main_settings', array() );
?>
		<?php if ( !is_page_template('template-listing_search.php') || ( isset($main_settings['search_position']) && $main_settings['search_position'] == 'bottom' ) || ( isset($_GET['mapontop']) ) ) { ?>
		<div class="site-footer-wrapper <?php echo esc_attr($footer_style); ?>">
			<?php if ( $footer_style == 'default' ) { ?>
				<div class="footer-menu-wrapper">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'menu_class'     => 'footer-menu',
								'depth'          => 1
							)
						);
					?>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
			<div class="footer-bottom-container">
				<div class="footer-bottom-inner">
					<div class="site-footer-container">
						<footer id="colophon" class="site-footer">
							<?php get_sidebar( 'footer' ); ?>
						</footer><!-- #colophon -->
						<div class="clearfix"></div>
					</div>
					<?php if ( $footer_style == 'minimal' ) { ?>
						<div class="footer-menu-wrapper">
							<?php
								$locations = get_nav_menu_locations();
								if ( isset($locations['footer']) && !empty($locations['footer']) ) {
									wp_nav_menu(
										array(
											'theme_location' => 'footer',
											'menu_class'     => 'footer-menu',
											'depth'          => 1
										)
									);
								}
							?>
							<div class="clearfix"></div>
						</div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>