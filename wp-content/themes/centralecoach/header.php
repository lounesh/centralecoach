<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php
global $whitelab_layout_type;

$form_class    = '';
$class         = '';
$search_string = '';
$layout_type   = esc_attr( get_post_meta(get_the_id(), 'layouts', true) );

if ( is_archive() || is_search() || is_404() || is_home() ) {
	$layout_type = 'full';
} elseif (empty($layout_type)) {
	$layout_type = esc_attr( get_theme_mod('directory_layout', 'full') );
}

switch ( $layout_type ) {
	case 'right':
		define('WHITELAB_LAYOUT', 'sidebar-right');
		break;
	case 'full':
		define('WHITELAB_LAYOUT', 'sidebar-no');
		break;
	case 'left':
		define('WHITELAB_LAYOUT', 'sidebar-left');
		break;
}

$whitelab_layout_type = $layout_type;

if ( is_front_page() && !is_home() ) {
	$logo = get_theme_mod('whitelab_header_logo', array());
} else {
	$logo = get_theme_mod('whitelab_header_second_logo', array());
}


if ( is_front_page() || is_page_template('template-split_slider.php') ) {
	$slider_alias = get_theme_mod('whitelab_custom_slider_alias', false);
	$listing_categories = get_terms( array(
		'taxonomy' => 'listing_category',
		'hide_empty' => false,
	));
	$active_categories = get_theme_mod('whitelab_search_categories', array());
	$slider_type = get_theme_mod('whitelab_custom_slider_status', 'revolution');
}

$main_settings = get_option( 'db_main_settings', array() );

?>
<body <?php body_class(); ?>>
<div id="page" class="page-wrapper hfeed site">
	
	<header id="masthead" class="site-header">
		<div class="header-content">
			<div class="header-main">
				<div class="site-title">
					<?php
					if ( ! empty ( $logo ) ) { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url(preg_replace('#^https?://#', '//', $logo)); ?>" alt="<?php esc_html_e("Logo", "whitelab"); ?>"></a>
						<?php
					} else { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a>
						<?php
					}
					?>
				</div>
				<?php if ( isset($main_settings['add_page_id']) && !is_user_logged_in() ) { ?>
					<!-- <a href="<?php echo esc_url(get_permalink(intval($main_settings['add_page_id']))); ?>" class="dt-create-listing dt-button dt-button-invert"><?php esc_html_e('Create a listing', 'whitelab'); ?></a> -->
				<?php } else if ( isset($main_settings['account_page_id']) && is_user_logged_in() ) { ?>
					<a href="<?php echo esc_url(get_permalink(intval($main_settings['account_page_id']))); ?>" class="dt-author-account dt-button dt-button-invert"><?php esc_html_e('My account', 'whitelab'); ?></a>
				<?php } ?>
				<div class="dt-mobile-menu">
					<a href="javascript:void(0)" class="dt-show-mobile-menu wlicon-menu-2"></a>
				</div>
				<?php if ( !is_user_logged_in() ) { ?>
					<div class="dt-login-register">
						<a href="javascript:void(0)" class="dt-sign-in-register"><img src="<?php echo get_template_directory_uri();?>/images/lock.svg" alt=""><?php esc_html_e('Sign in / Register', 'whitelab'); ?></a>
						<div class="dt-login-register-modal db-dialog-animation">
							<div class="dt-register-modal-inner">
								<span class="dr-register-modal-close"><img src="<?php echo get_template_directory_uri();?>/images/x.png" alt=""></span>
								<div class="dt-modal-left-side">
									<?php
									$slides = 1;
									for ($i=0; $i < 6; $i++) { 
										$slide_title = get_theme_mod('whitelab_header_slide_title_'.$i, '');
										$slide_text = get_theme_mod('whitelab_header_slide_text_'.$i, '');
										$slide_image = get_theme_mod('whitelab_header_slide_section_'.$i, '');

										if ( $slide_title == '' && $slide_text == '' ) {
											continue;
										}

										echo '
										<div class="dt-modal-left-item '.($slides==1?'active':'').'" '.($slide_image!=''?'data-bg="'.esc_url(preg_replace('#^https?://#', '//', $slide_image)).'"':'').'><img src="'.esc_url(preg_replace('#^https?://#', '//', $slide_image)).'" alt="" class="hidden">';
											if ( $slide_title ) {
												echo '<span class="dt-modal-title">'.esc_html($slide_title).'</span>';
											}
											if ( $slide_text ) {
												echo '<span class="dt-modal-desc">'.wp_kses( $slide_text, array( 'strong' => array() ) ).'</span>';
											}
										echo '
										</div>';
										
										$slides++;
									} ?>
								</div>
								<div class="dt-modal-right-side">
									<span class="dt-modal-title"><?php esc_html_e('Get discovered', 'whitelab'); ?></span>
									<span class="dt-modal-desc"><?php esc_html_e('It has never been easier to reach clients.', 'whitelab'); ?></span>
									<?php
										$terms_url = get_theme_mod('whitelab_header_terms', '');
										$reg_fields = array();
										if ( function_exists('db_get_registration_fields') ) {
											$reg_fields = db_get_registration_fields( 'modal' );
										}
									?>
									<form method="post" class="dt-register-form">
										<div class="dt-register-message"></div>
										<?php
										if ( !empty( $reg_fields ) ) {
											foreach ($reg_fields as $field_id => $field_settings) {
												?>
												<div class="dt-form-row <?php echo ($field_settings['field_type'] == 'select'?' single-select':''); ?>">
													<span class="dt-form-row-label"><?php echo $field_settings['frontend_title']; ?></span>
													<?php
														echo $field_settings['field_html'];
														if ( $field_settings['field_name'] == 'dtregisterpassword' ) {
															?>
															<span class="dt-show-password"><img src="<?php echo get_template_directory_uri();?>/images/eye.png" alt=""></span>
															<?php
														}
													?>
												</div>
												<?php
											}
										}
										
										$gcaptcha_options = get_option( 'gglcptch_options', array() );
										if ( function_exists( 'gglcptch_init' ) && isset( $gcaptcha_options['public_key'] ) && $gcaptcha_options['public_key'] != '' && isset( $gcaptcha_options['private_key'] ) && $gcaptcha_options['private_key'] != '' ) {
											echo do_shortcode( '[bws_google_captcha]' );
										}
										
										if ( $terms_url != '' ) { ?>
											<div class="dt-form-row">
												<label for="dt-register-agree" class="dt-checkbox">
													<input type="checkbox" id="dt-register-agree" name="dt-register-agree" required><?php esc_html_e('I agree to all statements in', 'whitelab'); ?> <a href="<?php echo esc_url($terms_url); ?>"><?php esc_html_e('terms and conditions', 'whitelab'); ?></a>
												</label>
											</div>
										<?php } ?>
										<input type="submit" class="dt-button dt-button-danger" value="<?php esc_html_e('Register', 'whitelab'); ?>">
										<a href="javascript:void(0)" class="dt-header-show-login"><?php esc_html_e('I\'m already a member', 'whitelab'); ?></a>
									</form>
									<form method="post" class="dt-login-form hidden">
										<div class="dt-login-message"></div>
										<div class="dt-form-row">
											<span class="dt-form-row-label"><?php esc_html_e('Username', 'whitelab'); ?></span>
											<input type="text" class="dt-login-username form-input" name="dt-login-username" placeholder="<?php esc_html_e('Username', 'whitelab'); ?>" required>
										</div>
										<div class="dt-form-row">
											<span class="dt-form-row-label"><?php esc_html_e('Password', 'whitelab'); ?></span>
											<input type="password" class="dt-login-password form-input" name="dt-login-password" placeholder="<?php esc_html_e('Password', 'whitelab'); ?>" required>
										</div>
										<input type="submit" class="dt-button dt-button-danger" value="<?php esc_html_e('Sign in', 'whitelab'); ?>">
										<a href="javascript:void(0)" class="dt-header-show-register"><?php esc_html_e('I\'m not a member', 'whitelab'); ?></a>
									</form>
									<form method="post" class="dt-lost-form hidden">
										<div class="dt-lost-message"></div>
										<div class="dt-form-row">
											<span class="dt-form-row-label"><?php esc_html_e('Username', 'whitelab'); ?></span>
											<input type="text" class="dt-lost-username form-input" name="dt-lost-username" placeholder="<?php esc_html_e('Username', 'whitelab'); ?>" required>
										</div>
										<input type="submit" class="dt-button dt-button-danger" value="<?php esc_html_e('Retrieve my password', 'whitelab'); ?>">
										<a href="javascript:void(0)" class="dt-header-show-login"><?php esc_html_e('I want to login', 'whitelab'); ?></a>
									</form>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="db-dialog-overlay"></div>
					</div>
				<?php } ?>
				<div class="main-header-right-side vc_col-xs-9 vc_col-sm-8 vc_col-md-7">
					<nav id="primary-navigation" class="site-navigation primary-navigation navbar-collapse collapse" role="navigation">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class'     => 'nav-menu',
									'depth'          => 4,
									'walker'         => new Whitelab_Header_Menu_Walker
								)
							);
						?>
					</nav>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</header><!-- #masthead -->
	<?php
		if ( ( is_front_page() && !is_home() && $slider_type != 'none' ) || is_page_template('template-split_slider.php') ) {
			echo '<div class="dt-rs-container">';
				if ( is_page_template('template-split_slider.php') ) {
					$slider_type = 'split';
				}
				if ( $slider_type == 'revolution' ) {
					echo do_shortcode('[rev_slider alias="'.esc_attr($slider_alias).'"]');
				} else if ( $slider_type == 'split' ) {
					echo do_shortcode('[directory_slider background="'.esc_url(get_theme_mod('whitelab_custom_slider_image', '')).'" text="'.esc_attr(get_theme_mod('whitelab_custom_slider_text', 'Whitelab')).'" delay="'.intval(get_theme_mod('whitelab_custom_slider_delay', '1500')).'" text_color="'.esc_attr(get_theme_mod('whitelab_custom_slider_color', '#fbe094')).'"]');
				}
				/*
				if ( isset($main_settings['search_page_id']) ) {
					if ( isset($main_settings['homepage_search_layout']) && $main_settings['homepage_search_layout'] != '' ) {
						$search_layout = json_decode( $main_settings['homepage_search_layout'], true );
						if ( !empty($search_layout) ) {
							$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order DESC');
							$all_fields = array();
							foreach ($field_list as $field_value) {
								$field_settings = json_decode($field_value->field_settings, true);
								$all_fields[$field_settings['field_name']] = $field_settings;
							}
							echo '
							<div class="dt-header-search">
								<div class="dt-header-search-inner">';
								$search_layout = $search_layout['row_0'];
								foreach ($search_layout as $search_field_name) {
									if ( $search_field_name == 'listing_name' ) {
										echo '
										<div class="dt-search-row listing-name">
											<label for="dt-search-listing_name">'.esc_html__('Listing name', 'whitelab').'</label>
											<input type="text" class="dt-search-listing_name" placeholder="'.esc_html__('What is it called', 'whitelab').'" value="'.(isset($_GET['listing_name'])?esc_attr($_GET['listing_name']):'').'">
										</div>';
									} else if ( $search_field_name == 'listing_categories' ) {
										if ( !is_wp_error($listing_categories) && !empty($listing_categories) ) {
											$categoryHierarchy = array();
											$search_categories = $listing_categories;
											if ( function_exists('db_sort_terms_hierarchicaly') ) {
												db_sort_terms_hierarchicaly($search_categories, $categoryHierarchy);
											}
											if ( empty($categoryHierarchy) ) {
												$categoryHierarchy = $listing_categories;
											}
											echo '
											<div class="dt-search-row listing-category">
												<label>'.esc_html__('Categories', 'whitelab').'</label>
												<input type="text" class="dt-custom-select"  placeholder="'.esc_html__('Category', 'whitelab').'" readonly>
												<input type="hidden" class="dt-search-search_category dt-custom-select-value">
												<div class="dt-custom-select-container">
													<div class="dt-custom-select-inner">
														<div class="dt-custom-select-search"><input type="text" placeholder="'.esc_html__('Search', 'whitelab').'"></div>
														<div class="dt-custom-select-items">';
														foreach ($categoryHierarchy as $category_data) {
															echo '<div class="dt-custom-select-item" data-value="'.esc_attr($category_data->term_id).'">'.esc_html($category_data->name).'</div>';
															if ( !empty($category_data->children) && function_exists('db_display_categories') ) {
																echo db_display_categories( $category_data );
															}
														}
														echo '	
														</div>
														<div class="dt-custom-select-scrollbar-wrapper">
															<span class="dt-custom-select-scrollbar"></span>
														</div>
													</div>
												</div>
											</div>';
										}
									} else if ( $search_field_name == 'listing_keyword' ) {
										echo '
										<div class="dt-search-row listing-keyword">
											<label for="dt-search-listing_keyword">'.esc_html__('What are you looking for?', 'whitelab').'</label>
											<input type="text" class="dt-search-listing_keyword" placeholder="'.esc_html__('Keyword', 'whitelab').'" value="'.(isset($_GET['listing_keyword'])?esc_attr($_GET['listing_keyword']):'').'">
										</div>';
									} else if ( isset($all_fields[$search_field_name]) && function_exists( 'db_get_custom_field' ) ) {
										if ( $search_field_name == 'listing_address' ) {
											$all_fields[$search_field_name]['frontend_title'] = esc_html__( 'Location', 'whitelab' );
										}
										echo '<div class="dt-search-row '.str_replace('_', '-', $search_field_name).'">';
											echo db_get_custom_field( $all_fields[$search_field_name], 'dt-search-'.$search_field_name, '', 'homepage' );
										echo '</div>';
									}
								}
								echo '
									<a href="javascript:void(0)" class="dt-header-search-submit dt-button dt-button-danger" data-url="'.esc_url(get_permalink(intval($main_settings['search_page_id']))).'">'.esc_html__('Search', 'whitelab').'</a>
								</div>
							</div>';
						}
					}
				}

				if ( !is_wp_error($listing_categories) && !empty($listing_categories) && isset($main_settings['search_page_id']) ) {
					echo '<div class="dt-header-categories" data-url="'.esc_url(get_permalink(intval($main_settings['search_page_id']))).'">';
					foreach ($listing_categories as $category_data) {
						if ( !in_array($category_data->term_id, $active_categories) ) {
							continue;
						}
						$cat_meta = get_option( "listing_category_".intval($category_data->term_id));
						echo '<div class="dt-header-category-item" data-id="'.intval($category_data->term_id).'">';
							echo (isset($cat_meta['tag-category-icon'])&&$cat_meta['tag-category-icon']!=''?'<span class="dt-header-category-icon '.esc_attr($cat_meta['tag-category-icon']).'"></span>':'');
							echo '<span class="dt-header-category-name">'.esc_html($category_data->name).'</span>';
						echo '</div>';
					}
					echo '</div>';
				}
				*/
			echo '</div><div class="clearfix"></div>';
		}
	?>