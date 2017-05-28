<?php
/**
 * WhiteLab 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see whitelab_content_width()
 *
 * @since WhiteLab 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

if ( !defined('WHITELAB_CUSTOM_SELECT') ) {
	define('WHITELAB_CUSTOM_SELECT', true);
}

if ( !defined('WHITELAB_CUSTOM_ADD_LISTING') ) {
	define('WHITELAB_CUSTOM_ADD_LISTING', true);
}

if ( !defined('WHITELAB_CUSTOM_STARS') ) {
	define('WHITELAB_CUSTOM_STARS', true);
}

define('WHITELAB_HOME_TITLE', 'Homepage');
define('WHITELAB_DEVELOPER_NAME_DISPLAY', 'Cohhe themes');
define('WHITELAB_DEVELOPER_URL', esc_url('https://cohhe.com'));

/**
 * WhiteLab 1.0 only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'whitelab_setup' ) ) {
	/**
	 * WhiteLab 1.0 setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since WhiteLab 1.0
	 */
	function whitelab_setup() {

		/**
		* Required: include TGM.
		*/
		require_once( get_template_directory() . '/functions/tgm-activation/class-tgm-plugin-activation.php' );

		/**
		* Sidebar generator
		*/
		require_once(get_template_directory() . '/functions/admin/metaboxes/layouts.php');
		require_once(get_template_directory() . '/functions/admin/sidebars/multiple_sidebars.php');

		/*
		 * Make WhiteLab 1.0 available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on WhiteLab 1.0, use a find and
		 * replace to change 'directory' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'whitelab', get_template_directory() . '/languages' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );
		add_image_size( 'whitelab-small-thumbnail', 70, 70, true );
		add_image_size( 'whitelab-full-width', 1110, 831, true );
		add_image_size( 'whitelab-thumbnail', 490, 318, true );
		add_image_size( 'whitelab-thumbnail-large', 650, 411, true );
		add_image_size( 'whitelab-medium-thumbnail', 350, 234, true );
		add_image_size( 'whitelab-related-thumbnail', 255, 170, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => esc_html__( 'Top primary menu', 'whitelab' ),
			'footer'    => esc_html__( 'Footer menu', 'whitelab' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'whitelab_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		add_theme_support( 'title-tag' );
	}
}
add_action( 'after_setup_theme', 'whitelab_setup' );

// Admin CSS
function whitelab_admin_css( $hook ) {
	wp_enqueue_style( 'whitelab-admin-css', get_template_directory_uri() . '/css/wp-admin.css' );
}
add_action('admin_head','whitelab_admin_css');

function whitelab_signin_func() {
	if ( !is_user_logged_in() ) {
		$wl_user = ( isset( $_POST['wl_user'] ) ? esc_attr( $_POST['wl_user'] ) : '' );
		$wl_pass = ( isset( $_POST['wl_pass'] ) ? esc_attr( $_POST['wl_pass'] ) : '' );

		$creds = array(
			'user_login' => $wl_user,
			'user_password' => $wl_pass,
			'remember' => false
		);

		$wl_user_login = wp_signon( $creds, false );

		if ( !is_wp_error( $wl_user_login ) ) {
			$user_validation = get_user_meta( $wl_user_login->data->ID, 'db_validation', true );

			if ( $user_validation !== false && $user_validation != '' ) {
				if ( $user_validation !== 'validated' ) {
					wp_logout();
					$wl_user_login = new WP_Error( 'pending_validation', __( "Your account is pending validation!", "whitelab" ) );
				}
			}
		}

		if ( !is_wp_error( $wl_user_login ) ) {
			$main_settings = get_option( 'db_main_settings', array() );
			$response_arr = array( 'response' => 'success', 'message' => esc_html__('Welcome back, ', 'whitelab') . $wl_user_login->data->display_name );

			if ( isset($main_settings['account_page_id']) && $main_settings['account_page_id'] != '' ) {
				$response_arr['account'] = get_permalink(intval($main_settings['account_page_id']));
			}

			echo json_encode( $response_arr );
		} else {
			echo json_encode( array( 'response' => 'failed', 'message' => $wl_user_login->get_error_message() ) );
		}
	} else {
		echo json_encode( array( 'response' => 'failed', 'message' => esc_html__('You\' re already logged in!', 'whitelab') ) );
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_whitelab_signin', 'whitelab_signin_func' );

function whitelab_register_func() {
	$wl_data = ( isset( $_POST['wl_data'] ) ? json_decode( stripslashes( $_POST['wl_data'] ), true ) : array() );

	if ( isset( $wl_data['db_captcha'] ) ) {
		$gcaptcha_options = get_option( 'gglcptch_options', array() );

		$gcaptcha_response = wp_remote_get( add_query_arg( array( 'secret' => $gcaptcha_options['private_key'], 'response' => $wl_data['db_captcha'], 'remoteip' => filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP ) ), 'https://www.google.com/recaptcha/api/siteverify' ) );
		$gcaptcha_body = json_decode( $gcaptcha_response['body'], true );

		if ( !$gcaptcha_body['success'] ) {
			echo json_encode( array( 'response' => 'failed', 'message' => esc_html__('You failed the captcha test!', 'whitelab') ) );
			die(0);
		}
	}

	if ( $wl_data['db_registerpassword'] == $wl_data['db_registerpasswordconfirm'] ) {
		$wl_user_register = wp_create_user( $wl_data['db_registerusername'], $wl_data['db_registerpassword'], $wl_data['db_registeremail'] );

		if ( !is_wp_error( $wl_user_register ) ) {
			wp_update_user( array( 'ID' => $wl_user_register, 'role' => 'db_listing_author' ) ); // Change user role to listing author

			$replicated_fields = $wl_data;
			unset($replicated_fields['db_registerusername']);
			unset($replicated_fields['db_registeremail']);
			unset($replicated_fields['db_registerpassword']);
			unset($replicated_fields['db_registerpasswordconfirm']);
			if ( !empty($replicated_fields) ) {
				foreach ( $replicated_fields as $field_key => $field_value ) {
					if ( strpos($field_key, '[]') !== false ) {
						$field_key = str_replace('[]', '', $field_key);
					}
					update_user_meta( $wl_user_register, $field_key, $field_value );
				}
			}

			// wp_signon( array( 'user_login' => $wl_data['db_registerusername'], 'user_password' => $wl_data['db_registerpassword'], 'remember' => false ), false ); // Log the new user in

			$user_validation_code = wp_generate_password( 12, false );
			update_user_meta( $wl_user_register, 'db_validation', $user_validation_code );

			$main_settings = get_option( 'db_main_settings', array() );
			if ( function_exists( 'db_send_notification_email' ) ) {
				db_send_notification_email( $wl_user_register, 'new_user_confirm', array( 'username' => $wl_data['db_registerusername'], 'url_confirm' => add_query_arg( array( 'user' => $wl_user_register, 'validation' => $user_validation_code ), get_permalink( $main_settings['account_page_id'] ) ), 'source' => __('header modal dialog', 'whitelab') ) );
			}
			
			echo json_encode( array( 'response' => 'success', 'message' => esc_html__('You are successfully registered and will shortly receive a confirmation email!', 'whitelab') ) );
		} else {
			echo json_encode( array( 'response' => 'failed', 'message' => $wl_user_register->get_error_message() ) );
		}
	} else {
		echo json_encode( array( 'response' => 'failed', 'message' => esc_html__('Your password did not match!', 'whitelab') ) );
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_whitelab_register', 'whitelab_register_func' );

function whitelab_lost_password_func() {
	$errors = new WP_Error();
	$wl_user = ( isset( $_POST['wl_user'] ) ? esc_attr( $_POST['wl_user'] ) : array() );

	if ( empty( $wl_user ) ) {
		$errors->add('empty_username', wp_kses( __('<strong>ERROR</strong>: Enter a username or email address.', 'whitelab'), array( 'strong' => array() ) ));
	} elseif ( strpos( $wl_user, '@' ) ) {
		$user_data = get_user_by( 'email', trim( wp_unslash( $wl_user ) ) );
		if ( empty( $user_data ) )
			$errors->add('invalid_email', wp_kses( __('<strong>ERROR</strong>: There is no user registered with that email address.', 'whitelab'), array( 'strong' => array() ) ));
	} else {
		$login = trim($wl_user);
		$user_data = get_user_by('login', $login);
	}

	do_action( 'lostpassword_post', $errors );

	if ( $errors->get_error_code() ) {
		echo json_encode( array( 'response' => 'failed', 'message' => $errors->get_error_message() ) );
		die(0);
	}

	if ( !$user_data ) {
		$errors->add('invalidcombo', wp_kses( __('<strong>ERROR</strong>: Invalid username or email.', 'whitelab'), array( 'strong' => array() ) ));
		echo json_encode( array( 'response' => 'failed', 'message' => $errors->get_error_message() ) );
		die(0);
	}

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
	$key = get_password_reset_key( $user_data );

	if ( is_wp_error( $key ) ) {
		echo json_encode( array( 'response' => 'failed', 'message' => $key ) );
		die(0);
	}

	$main_settings = get_option( 'db_main_settings', array() );
	$message = esc_html__('Someone has requested a password reset for the following account:', 'whitelab') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(esc_html__('Username: %s', 'whitelab'), $user_login) . "\r\n\r\n";
	$message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.', 'whitelab') . "\r\n\r\n";
	$message .= esc_html__('To reset your password, visit the following address:', 'whitelab') . "\r\n\r\n";
	$message .= '<' . add_query_arg( array( 'key' => $key, 'login' => rawurlencode($user_login) ), get_permalink( $main_settings['account_page_id'] ) ) . ">\r\n";

	if ( is_multisite() ) {
		$blogname = get_network()->site_name;
	} else {
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	}

	$title = sprintf( esc_html__('[%s] Password Reset', 'whitelab'), $blogname );

	$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

	if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
		echo json_encode( array( 'response' => 'failed', 'message' => esc_html__('The email could not be sent, possible reason might be that your host may have disabled the mail() function.', 'whitelab') ) );
	} else {
		echo json_encode( array( 'response' => 'success', 'message' => esc_html__('A password reset link is sent to your email!', 'whitelab') ) );
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_whitelab_lost_password', 'whitelab_lost_password_func' );

function whitelab_get_site_width() {
	$whitelab_site_width = '';

	if ( WHITELAB_LAYOUT != 'sidebar-no' ) {
		$whitelab_site_width = 'wl-col-9';
	}

	return esc_attr($whitelab_site_width);
}

function whitelab_get_search_listing_data() {
	global $db_search_listing_data;

	return $db_search_listing_data;
}

/**
 * Adjust content_width value for image attachment template.
 *
 * @since WhiteLab 1.0
 *
 * @return void
 */
function whitelab_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'whitelab_content_width' );

/**
 * Register three WhiteLab 1.0 widget areas.
 *
 * @since WhiteLab 1.0
 *
 * @return void
 */
function whitelab_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 1', 'whitelab' ),
		'id'            => 'whitelab-sidebar-3',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'whitelab' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 2', 'whitelab' ),
		'id'            => 'whitelab-sidebar-4',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'whitelab' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 3', 'whitelab' ),
		'id'            => 'whitelab-sidebar-5',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'whitelab' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'whitelab_widgets_init' );

/**
 * Register Lato Google font for WhiteLab 1.0.
 *
 * @since WhiteLab 1.0
 *
 * @return string
 */
function whitelab_font_url() {
	$font_url = add_query_arg( 'family', urlencode( 'Roboto:400,100,300' ), "//fonts.googleapis.com/css" );

	return esc_url_raw( $font_url );
}

function whitelab_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'whitelab_excerpt_length', 999 );

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since WhiteLab 1.0
 *
 * @return void
 */
function whitelab_scripts() {
	// Add Google fonts
	wp_enqueue_style( 'whitelab-googleFonts', whitelab_get_default_fonts(), array(), '' );
	wp_enqueue_style( 'whitelab-fonts', whitelab_get_google_fonts_url(), array(), '' );

	// Load our main stylesheet.
	wp_enqueue_style( 'whitelab-style', get_stylesheet_uri(), array() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_home() || is_search() || is_archive() ) {
		wp_enqueue_script( 'jquery.isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ), '', false );
	}

	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'whitelab-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '', true );
	wp_localize_script( 'whitelab-script', 'my_ajax', array(
		'ajaxurl'   => admin_url( 'admin-ajax.php' ),
		'map_style' => whitelab_google_map_styles(),
		'current' => get_current_user_id()
	));

	// Add html5
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// Custom fonts
	wp_enqueue_style( 'gfonts', get_template_directory_uri() . '/css/gfonts.css', array(), filemtime(get_template_directory() . '/css/gfonts.css') );

	// Load custom font styles
	wp_add_inline_style( 'whitelab-style', whitelab_get_customizer_fonts() );
	wp_add_inline_style( 'whitelab-style', whitelab_prepare_customizations() );

	if ( !is_customize_preview() && current_user_can( 'manage_options' ) ) {
		wp_enqueue_script( 'custom-modernizer', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '', true );
		wp_enqueue_script( 'interact', get_template_directory_uri() . '/js/interact-1.2.4.min.js', array(), '', true );
		wp_enqueue_script( 'classie', get_template_directory_uri() . '/js/classie.js', array(), '', true );
		wp_enqueue_script( 'main-customizer', get_template_directory_uri() . '/js/customizer-main.js', array('custom-modernizer'), '', true );
		wp_enqueue_script( 'colpick-js', get_template_directory_uri() . '/js/colpick.js', array( 'jquery' ), '', false );
		wp_enqueue_style( 'colpick-css', get_template_directory_uri() . '/css/colpick.css', array() );
	}
	wp_enqueue_script( 'jquery.cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), '', true );

	if ( basename(get_page_template()) == 'template-listing_search.php' && !isset($_GET['s']) ) {
		wp_add_inline_script( 'whitelab-script', whitelab_get_search_map_script() );
		wp_add_inline_style( 'whitelab-style', whitelab_get_search_map_style() );
		remove_action('wp_head', '_admin_bar_bump_cb');
	}

	$autoplay = get_theme_mod('whitelab_header_autoplay', '0');
	if ( $autoplay != '0' ) {
		wp_add_inline_script( 'whitelab-script', whitelab_get_header_autoplay( $autoplay ) );
	}

	if ( get_post_type() == 'listings' ) {
		$terms = wp_get_post_terms( get_the_ID(), 'listing_category' );
		$categories = '';
		$first_cat_id = '';
		$category_ids = array();
		if ( !empty($terms) ) {
			$loop = 0;
			foreach ( $terms as $term_value ) {
				$categories .= esc_html($term_value->name).' ';
				$category_ids[] = intval($term_value->term_id);
				if ( $loop == 0 ) {
					$first_cat_id = intval($term_value->term_id);
				}
				$loop++;
			}
		}
		$listing_lat = esc_html( get_post_meta( get_the_ID(), 'listing_address_lat', true) );
		$listing_lng = esc_html( get_post_meta( get_the_ID(), 'listing_address_lng', true) );
		$listing_category = get_option( "listing_category_".$first_cat_id);

		wp_add_inline_script( 'whitelab-script', whitelab_get_single_listing_map( $listing_lat, $listing_lng, $listing_category ) );	
	}

	if ( is_single() && get_post_type() == 'post' ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		wp_add_inline_style( 'whitelab-style', whitelab_get_image_css( '.db-single-image', esc_url($img['0']) ) );
		wp_enqueue_script( 'pinterest', '//assets.pinterest.com/js/pinit.js', array(), false, true);
	} else if ( ( is_archive() || is_search() || is_404() || is_home() ) && have_posts() ) {
		foreach (whitelab_get_current_posts() as $post_value) {
			$img = wp_get_attachment_image_src(get_post_thumbnail_id( $post_value->ID ), 'db_single_listing');
			wp_add_inline_style( 'whitelab-style', whitelab_get_image_css( '.dt-blog-item-image.id-'.intval($post_value->ID), esc_url($img['0']) ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'whitelab_scripts' );

function whitelab_get_search_map_style() {
	return '
	html { margin-top: 0 !important; overflow: hidden; }
	body.admin-bar { margin-top: 32px; }';
}

function whitelab_get_current_posts() {
	global $wp_query;

	if ( !empty($wp_query->posts) ) {
		return $wp_query->posts;
	} else {
		return array();
	}
}

function whitelab_get_image_css( $element_class, $image_url ) {
	return esc_html( $element_class ) . ' { background: url('.esc_url($image_url).'); }';
}

function whitelab_customizer_style() {
	wp_enqueue_style( 'whitelab-customizer-css', get_template_directory_uri() . '/css/whitelab-customizer.css', array() );
}
add_action( 'customize_controls_enqueue_scripts', 'whitelab_customizer_style' );

function whitelab_get_default_fonts() {
	$fonts_url = '';
	 
	$poppins = _x( 'on', 'Poppins font: on or off', 'whitelab' );
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'whitelab' );
	 
	if ( 'off' !== $poppins || 'off' !== $open_sans ) {
		$font_families = array();
		 
		if ( 'off' !== $poppins ) {
			$font_families[] = 'Poppins:300,400,600,700';
		}
		 
		if ( 'off' !== $open_sans ) {
			$font_families[] = 'Open Sans:300,400,600,700';
		}
		 
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		 
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}
	 
	return esc_url_raw( $fonts_url );
}

// Admin Javascript
add_action( 'admin_enqueue_scripts', 'whitelab_admin_scripts' );
function whitelab_admin_scripts() {
	wp_register_script('whitelab-master', get_template_directory_uri() . '/inc/js/admin-master.js', array('jquery'));
	wp_enqueue_script('whitelab-master');
}

function whitelab_customizer_scripts() {
	wp_enqueue_script( 'customizer-helper', get_template_directory_uri() . '/js/customizer.js', array('jquery'), '', true );
	wp_localize_script( 'customizer-helper', 'my_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));
}
add_action( 'customize_controls_enqueue_scripts', 'whitelab_customizer_scripts' );

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since WhiteLab 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function whitelab_body_classes( $classes ) {
	global $post;
	$directory_layout = '';

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_active_sidebar( 'whitelab-sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	$classes[] = 'directory-theme';

	if ( defined('DIRECTORY_LAYOUT') ) {
		$classes[] = esc_attr( DIRECTORY_LAYOUT );
	}

	$gcaptcha_options = get_option( 'gglcptch_options', array() );
	if ( function_exists( 'gglcptch_init' ) && isset( $gcaptcha_options['public_key'] ) && $gcaptcha_options['public_key'] != '' && isset( $gcaptcha_options['private_key'] ) && $gcaptcha_options['private_key'] != '' ) {
		$classes[] = 'gglcptch';
	}

	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) {
		$classes[] = 'ie';
		if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
		$classes[] = 'ie'.$browser_version[1];
	} else $classes[] = 'unknown';
	if($is_iphone) $classes[] = 'iphone';
	if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
			 $classes[] = 'osx';
	   } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
			 $classes[] = 'linux';
	   } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
			 $classes[] = 'windows';
	   }

	return $classes;
}
add_filter( 'body_class', 'whitelab_body_classes' );

function whitelab_post_classes( $classes ) {
	if ( !is_page() ) {
		if ( !is_single() ) {
			$classes[] = 'not-single-post';
		} else {
			$classes[] = 'single-post';
		}
	}

	return $classes;
}
add_filter( 'post_class', 'whitelab_post_classes' );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Whitelab_Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Whitelab_Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Whitelab_Header_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes         = empty ( $item->classes ) ? array () : (array) $item->classes;
		$has_description = '';

		$class_names = join(
			' '
		,   apply_filters(
				'nav_menu_css_class'
			,   array_filter( $classes ), $item
			)
		);

		// insert description for top level elements only
		// you may change this
		$description = ( ! empty ( $item->description ) )
			? '<small>' . esc_attr( $item->description ) . '</small>' : '';

		$has_description = ( ! empty ( $item->description ) )
			? 'has-description ' : '';

		! empty ( $class_names )
			and $class_names = ' class="' . $has_description . esc_attr( $class_names ) . ' depth-' . intval($depth) . '"';

		$output .= "<li id='menu-item-".intval($item->ID)."' $class_names>";

		$attributes  = '';

		if ( !isset($item->target) ) {
			$item->target = '';
		}

		if ( !isset($item->attr_title) ) {
			$item->attr_title = '';
		}

		if ( !isset($item->xfn) ) {
			$item->xfn = '';
		}

		if ( !isset($item->url) ) {
			$item->url = '';
		}

		if ( !isset($item->title) ) {
			$item->title = '';
		}

		if ( !isset($item->ID) ) {
			$item->ID = '';
		}

		if ( !isset($args->link_before) ) {
			$args = new stdClass();
			$args->link_before = '';
		}

		if ( !isset($args->before) ) {
			$args->before = '';
		}

		if ( !isset($args->link_after) ) {
			$args->link_after = '';
		}

		if ( !isset($args->after) ) {
			$args->after = '';
		}

		! empty( $item->attr_title )
			and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
		! empty( $item->target )
			and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
		! empty( $item->xfn )
			and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
		! empty( $item->url )
			and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		$title = apply_filters( 'the_title', esc_html($item->title), intval($item->ID) );

		$item_output = $args->before
			. "<a $attributes>"
			. $args->link_before
			. '<span>' . $title . '</span>'
			. $description
			. '</a> '
			. $args->link_after
			. $args->after;

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
		,   $item_output
		,   $item
		,   $depth
		,   $args
		);
	}
}

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function whitelab_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> esc_html__('Easy Testimonials', 'whitelab'), // The plugin name
			'slug'     				=> 'easy-testimonials', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> esc_html__('Functionality for Directory theme', 'whitelab'), // The plugin name
			'slug'     				=> 'functionality-for-directory-theme', // The plugin slug (typically the folder name)
			'source'     			=> get_template_directory() . '/functions/tgm-activation/plugins/functionality-for-directory-theme.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.3.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> esc_html__('MailPoet Newsletters', 'whitelab'), // The plugin name
			'slug'     				=> 'wysija-newsletters', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.7.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> esc_html__('Directory builder', 'whitelab'), // The plugin name
			'slug'     				=> 'directory-builder', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.4.9', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> esc_html__('Slider Revolution', 'whitelab'), // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/functions/tgm-activation/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.3.1.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> esc_html__('WPBakery Visual Composer', 'whitelab'), // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/functions/tgm-activation/plugins/js_composer.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> esc_html__('Google Captcha (reCAPTCHA) by BestWebSoft', 'whitelab'), // The plugin name
			'slug'     				=> 'google-captcha', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.27', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'whitelab',              	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug' 	    => 'themes.php', 				// Default parent menu slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> esc_html__( 'Install Required Plugins', 'whitelab' ),
			'menu_title'                       			=> esc_html__( 'Install Plugins', 'whitelab' ),
			'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'whitelab' ), // %1$s = plugin name
			'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'whitelab' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'whitelab' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'whitelab' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'whitelab' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'whitelab' ),
			'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'whitelab' ),
			'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'whitelab' ),
			'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'whitelab' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'whitelab_register_required_plugins' );

function whitelab_admin_rating_notice() {
	$user = wp_get_current_user();
	?>
	<div class="directory-rating-notice">
		<span class="directory-notice-left">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo-square.png" alt="">
		</span>
		<div class="directory-notice-center">
			<p><?php printf( esc_html__('Hi there, %s, we noticed that you\'ve been using WhiteLab for a while now.', 'whitelab'), $user->data->display_name ); ?></p>
			<p><?php esc_html_e('We spent many hours developing this theme for you and we would appriciate if you supported us by rating it!', 'whitelab'); ?></p>
		</div>
		<div class="directory-notice-right">
			<a href="https://themeforest.net/downloads" class="button button-primary button-large directory-rating-rate"><?php esc_html_e('Rate at ThemeForest', 'whitelab'); ?></a>
			<a href="javascript:void(0)" class="button button-large preview directory-rating-dismiss"><?php esc_html_e('No, thanks', 'whitelab'); ?></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php
}
$wl_rating_notice = esc_html( get_option('whitelab_rating_notice') );
if ( $wl_rating_notice && $wl_rating_notice != 'hide' && time() - $wl_rating_notice > 432000 ) {
	add_action( 'admin_notices', 'whitelab_admin_rating_notice' );
}

function whitelab_dismiss_rating_notice() {
	update_option('whitelab_rating_notice', 'hide');

	die(0);
}
add_action( 'wp_ajax_nopriv_directory_dismiss_notice', 'whitelab_dismiss_rating_notice' );
add_action( 'wp_ajax_directory_dismiss_notice', 'whitelab_dismiss_rating_notice' );

function whitelab_theme_activated() {
	if ( !get_option('whitelab_rating_notice') ) {
		update_option('whitelab_rating_notice', time());
	}
}
add_action('after_switch_theme', 'whitelab_theme_activated');

if ( ! function_exists( 'db_comment' ) ) {
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own ac_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 */
	function db_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php esc_html_e( 'Pingback:', 'whitelab' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'whitelab' ), '<span class="edit-link button blue">', '</span>' ); ?></p>
		<?php
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php esc_attr( comment_ID() ); ?>">
			<div id="comment-<?php esc_attr( comment_ID() ); ?>" class="comment">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 54 ); ?>
				</div><!-- .comment-author .vcard -->
				<div class="comment-content">
					<div class="comment-head">
						<span class="comment-author"><?php echo get_comment_author_link(); ?></span>
						<span class="comment-date"><?php echo comment_date(get_option('date_format').' '.get_option('time_format')); ?></span>
						<div class="reply-edit-container">
							<span class="reply">
								<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'whitelab' ), 'depth' => intval($depth), 'max_depth' => intval($args['max_depth']) ) ) ); ?>
							</span><!-- end of reply -->
							<?php edit_comment_link( esc_html__( 'Edit', 'whitelab' ), '<span class="edit-link button blue">', '</span>' ); ?>
						</div>
						<?php if ( intval($comment->comment_approved) == '0' ) : ?>
							<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'whitelab' ); ?></em>
						<?php endif; ?>
					</div>
					<?php comment_text(); ?>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div><!-- end of comment -->

		<?php
				break;
		endswitch;
	}
}

function whitelab_get_font_settings() {
	return array(
		'primary' =>
			array(
				'class' => '.db-single-listing-main > p:not(:first-child), body.single .entry-content #entry-content-wrapper > p:not(:first-child), .review-content > p, .comment-content p',
				'size' => '14',
				'lineheight' => '25',
				'fontfamily' => 'Open+Sans',
				'fontweight' => '400',
				'title' => esc_html__('Primary font', 'whitelab'),
				'description' => esc_html__('This is your sites primary font', 'whitelab')
			),
		'primary_intro' =>
			array(
				'class' => '.db-single-listing-main p:first-child',
				'size' => '27',
				'lineheight' => '39',
				'fontfamily' => 'Open+Sans',
				'fontweight' => '300',
				'title' => esc_html__('Single listing/post intro font', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'headingone' =>
			array(
				'class' => '#page h1:not(.entry-title):not(.db-single-title):not(.single-listing-title)',
				'size' => '28',
				'lineheight' => '39',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Heading H1', 'whitelab'),
				'description' => esc_html__('All heading H1 fonts', 'whitelab')
			),
		'headingtwo' =>
			array(
				'class' => '#pagez h2',
				'size' => '22',
				'lineheight' => '28',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Heading H2', 'whitelab'),
				'description' => esc_html__('All heading H2 fonts', 'whitelab')
			),
		'headingthree' =>
			array(
				'class' => '#page h3',
				'size' => '18',
				'lineheight' => '25',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Heading H3', 'whitelab'),
				'description' => esc_html__('All heading H3 fonts', 'whitelab')
			),
		'headingfour' =>
			array(
				'class' => '#page h4',
				'size' => '17',
				'lineheight' => '20',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Heading H4', 'whitelab'),
				'description' => esc_html__('All heading H4 fonts', 'whitelab')
			),
		'headingfive' =>
			array(
				'class' => '#page h5',
				'size' => '16',
				'lineheight' => '19',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Heading H5', 'whitelab'),
				'description' => esc_html__('All heading H5 fonts', 'whitelab')
			),
		'headingsix' =>
			array(
				'class' => '#page h6',
				'size' => '15',
				'lineheight' => '16',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Heading H6', 'whitelab'),
				'description' => esc_html__('All heading H6 fonts', 'whitelab')
			),
		'links' =>
			array(
				'class' => '#entry-content-wrapper a, .comment-content a, .entry-summary a',
				'size' => '14',
				'lineheight' => '25',
				'fontfamily' => 'Open+Sans',
				'fontweight' => '400',
				'title' => esc_html__('Normal links', 'whitelab'),
				'description' => esc_html__('This is your sites links font', 'whitelab')
			),
		'single_widget' =>
			array(
				'class' => '.db-single-listing-side-wrapper .db-listing-side-title',
				'size' => '18',
				'lineheight' => '25',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Single listing side title', 'whitelab'),
				'description' => esc_html__('Your sites single listing side title font', 'whitelab')
			),
		'widgetlink' =>
			array(
				'class' => '#page .widget:not(.widget_calendar) a, .site-footer-container .widget:not(.widget_calendar) a',
				'size' => '14',
				'lineheight' => '25',
				'fontfamily' => 'Open+Sans',
				'fontweight' => '400',
				'title' => esc_html__('Widget link font', 'whitelab'),
				'description' => esc_html__('This is your sites widgets link font', 'whitelab')
			),
		'pagetitle' =>
			array(
				'class' => '#page .entry-title',
				'size' => '28',
				'lineheight' => '46',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Open post/page title font', 'whitelab'),
				'description' => esc_html__('Your sites open post/page title font', 'whitelab')
			),
		'single_page_title' =>
			array(
				'class' => '#page h1.db-single-title, #page h1.single-listing-title',
				'size' => '28',
				'lineheight' => '46',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('Open listing/post title font', 'whitelab'),
				'description' => esc_html__('Your sites open listing/post title font', 'whitelab')
			),
		'wl_module_title' =>
			array(
				'class' => '.dt-module-title .dt-module-front-title',
				'size' => '28',
				'lineheight' => '30',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('WhiteLab module title', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_module_bg_title' =>
			array(
				'class' => '.dt-module-title .dt-module-background-title',
				'size' => '150',
				'lineheight' => '150',
				'fontfamily' => 'Poppins',
				'fontweight' => '600',
				'title' => esc_html__('WhiteLab module background title', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_f_listing_title' =>
			array(
				'class' => '.dt-featured-listings-title',
				'size' => '18',
				'lineheight' => '30',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('WhiteLab featured listing title', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_f_listing_text' =>
			array(
				'class' => '.dt-featured-listings-description',
				'size' => '13',
				'lineheight' => '19',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('WhiteLab featured listing text', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_city_title' =>
			array(
				'class' => '.dt-popular-cities .dt-popular-city-item',
				'size' => '26',
				'lineheight' => '30',
				'fontfamily' => 'Poppins',
				'fontweight' => '600',
				'title' => esc_html__('WhiteLab city title', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_quote_text' =>
			array(
				'class' => '.dt-quotes-items .dt-quote-item',
				'size' => '20',
				'lineheight' => '33',
				'fontfamily' => 'Open+Sans',
				'fontweight' => '400',
				'title' => esc_html__('WhiteLab quote text', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_news_title' =>
			array(
				'class' => '.dt-blog-item-title',
				'size' => '18',
				'lineheight' => '30',
				'fontfamily' => 'Poppins',
				'fontweight' => '400',
				'title' => esc_html__('WhiteLab news text', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			),
		'wl_news_date' =>
			array(
				'class' => '.dt-blog-item-date',
				'size' => '14',
				'lineheight' => '30',
				'fontfamily' => 'Open+Sans',
				'fontweight' => '400',
				'title' => esc_html__('WhiteLab news date', 'whitelab'),
				'description' => esc_html__('', 'whitelab')
			)
	);
};

add_action( 'wp_ajax_nopriv_reload_gfonts_file', 'whitelab_reload_gfonts' );
add_action( 'wp_ajax_reload_gfonts_file', 'whitelab_reload_gfonts' );
function whitelab_reload_gfonts() {
	if ( isset( $_POST['font_family'] ) ? $font_family = sanitize_text_field( str_replace('\\', '', $_POST['font_family'] ) ) : $font_family = '' );

	$fonts = array_unique( json_decode($font_family) );
	$weights = '100,300,400,700';
	$result = '';

	foreach ($fonts as $font_value) {
		$result[] .= $font_value.':'.$weights;
	}

	whitelab_save_settings( esc_html( implode( '|', $result) ) );

	echo esc_html__('Fonts regenerated', 'whitelab');

	die(1);
}

add_action( 'wp_ajax_nopriv_reset_customizer_fonts', 'whitelab_reset_customizer_fonts' );
add_action( 'wp_ajax_reset_customizer_fonts', 'whitelab_reset_customizer_fonts' );
function whitelab_reset_customizer_fonts() {
	$customizer = get_option('theme_mods_whitelab', array());
	$font_settings = whitelab_get_font_settings();

	foreach ($font_settings as $font_key => $font_value) {
		if ( isset($customizer['whitelab_'.esc_html($font_key).'_fontsize']) ) {
			unset($customizer['whitelab_'.esc_html($font_key).'_fontsize']);
		}
		if ( isset($customizer['whitelab_'.esc_html($font_key).'_lineheight']) ) {
			unset($customizer['whitelab_'.esc_html($font_key).'_lineheight']);
		}
		if ( isset($customizer['whitelab_'.esc_html($font_key).'_fontfamily']) ) {
			unset($customizer['whitelab_'.esc_html($font_key).'_fontfamily']);
		}
		if ( isset($customizer['whitelab_'.esc_html($font_key).'_fontweight']) ) {
			unset($customizer['whitelab_'.esc_html($font_key).'_fontweight']);
		}
	}

	update_option('theme_mods_whitelab', $customizer);

	die(1);
}

function whitelab_get_google_fonts_url() {
	$fonts = whitelab_get_google_fonts();
	$font_url = '';
	
	$font_url = add_query_arg( 'family', urlencode( $fonts.'&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );

	return esc_url_raw( $font_url );
}

function whitelab_get_google_fonts() {
	$font_settings = whitelab_get_font_settings();
	$fonts = $weights = array();
	$result = '';

	foreach ($font_settings as $font_key => $font_value) {
		$fonts[] = get_theme_mod('whitelab_'.intval($font_key).'_fontfamily', esc_html($font_value['fontfamily']));
		$weights[] = get_theme_mod('whitelab_'.intval($font_key).'_fontweight', esc_html($font_value['fontweight']));

	}

	$fonts = array_unique($fonts);
	$weights = implode( ',', array_unique( $weights ) );

	foreach ($fonts as $font_value) {
		$result[] .= $font_value.':'.$weights;
	}

	return implode( '|', $result);
}

function whitelab_get_customizer_fonts() {
	$customizer_css = '';
	$font_array = whitelab_get_font_settings();

	foreach ($font_array as $font_key => $font_value) {
		$font_classes = sanitize_text_field( $font_value['class'] );
		$font_size = intval( get_theme_mod('whitelab_'.esc_attr($font_key). '_fontsize', '') );
		$line_height = intval( get_theme_mod('whitelab_'.esc_attr($font_key).'_lineheight', '') );
		$font_family = esc_html( get_theme_mod('whitelab_'.esc_attr($font_key).'_fontfamily', '') );
		$font_weight = esc_html( get_theme_mod('whitelab_'.esc_attr($font_key).'_fontweight', '') );

		if ( $font_size || $line_height || $font_family || $font_weight ) {
			$customizer_css .= $font_classes.'{';

			if ( $font_size ) {
				$customizer_css .= 'font-size: '.$font_size.'px;';
			}

			if ( $line_height ) {
				$customizer_css .= 'line-height: '.$line_height.'px;';
			}

			if ( $font_family ) {
				$customizer_css .= 'font-family: "'.str_replace('+', ' ', $font_family).'";';
			}

			if ( $font_weight ) {
				$customizer_css .= 'font-weight: '.$font_weight.';';
			}
			
			$customizer_css .= '}';
		}
	}

	return $customizer_css;
}

add_action( 'wp_ajax_nopriv_update_whitelab_customizer', 'whitelab_update_customizer' );
add_action( 'wp_ajax_update_whitelab_customizer', 'whitelab_update_customizer' );
function whitelab_update_customizer() {
	if ( isset( $_POST['path'] ) ? $path = sanitize_text_field( rtrim($_POST['path'], '.') ) : $path = '' );
	if ( isset( $_POST['element'] ) ? $element = sanitize_text_field( rtrim($_POST['element'], '.') ) : $element = '' );
	if ( isset( $_POST['parent'] ) ? $parent = sanitize_text_field( rtrim($_POST['parent'], '.') ) : $parent = '' );
	if ( isset( $_POST['type'] ) ? $type = sanitize_text_field( $_POST['type'] ) : $type = '' );
	if ( isset( $_POST['color'] ) ? $color = sanitize_text_field( $_POST['color'] ) : $color = '' );
	if ( isset( $_POST['tag'] ) ? $tag = sanitize_text_field( $_POST['tag'] ) : $tag = '' );
	if ( $type == 'area' ) {
		$color_type = 'background-color:';
	} elseif ( $type == 'text' ) {
		$color_type = 'color:';
	}
	if ( $tag == 'body' ) {
		$path = 'html body';
	}

	if ( $parent == '.undefined' ) {
		$parent = '';
	}

	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		$customizer = get_option( 'directory_customizer', '' );
		if ( $customizer == '' ) {
			$customizations = array($path => esc_html( '{'.$color_type.$color.';}' ) );
			if ( strpos($path,'like-thumb-liked') !== false ) {
				$customizations['.like-thumb-liked #My-account'] = esc_html( '{fill:'.$color.';}' );
			}
			update_option( 'directory_customizer', $customizations);
		} else {
			$customizer[$path] = esc_html( '{'.$color_type.$color.';}' );
			if ( strpos($path,'like-thumb-liked') !== false ) {
				$customizer['.like-thumb-liked #My-account'] = esc_html( '{fill:'.$color.';}' );
			} else if ( strpos($path,'dt-blog-item-category') !== false ) {
				$customizer['.dt-blog-item-category:before'] = esc_html( '{border-color:'.$color.';}' );
			} else if ( strpos($path,'db-single-listing-category') !== false ) {
				$customizer['.db-single-listing-category:before'] = esc_html( '{border-color:'.$color.';}' );
			}

			update_option( 'directory_customizer', $customizer);
		}
	}

	echo whitelab_prepare_customizations();

	die(1);
}

function whitelab_prepare_customizations() {
	$css_array = get_option( 'directory_customizer', array() );
	$custom_css = '.test123 {color:red}';

	if ( !empty($css_array) ) {
		foreach ($css_array as $class => $color) {
			$custom_css .= str_replace('\\', '', $class.$color);
		}
	}

	$main_settings = get_option( 'db_main_settings', array() );
	if ( ( isset($main_settings['search_position']) && $main_settings['search_position'] == 'bottom' ) || ( isset($_GET['mapontop']) ) ) {
		$custom_css .= 'html { overflow: auto !important; } body #dt-main-listing-search { height: auto !important; }';
	}

	return sanitize_text_field( $custom_css );
}

add_action( 'wp_ajax_nopriv_delete_directory_customizer', 'whitelab_delete_customizer' );
add_action( 'wp_ajax_delete_directory_customizer', 'whitelab_delete_customizer' );
function whitelab_delete_customizer() {
	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		delete_option( 'directory_customizer' );
	}

	die(1);
}

function whitelab_google_map_styles() {
	return '[{
		"featureType":"all",
		"elementType":"all",
		"stylers":[
			{"color":"#c0e8e8"}
		]
	},{
		"featureType":"administrative",
		"elementType":"labels",
		"stylers":[
			{"color":"#4f4735"},
			{"visibility":"simplified"}
		]
	},{
		"featureType":"landscape",
		"elementType":"all",
		"stylers":[
			{"color":"#e9e7e3"}
		]
	},{
		"featureType":"poi",
		"elementType":"labels",
		"stylers":[
			{"color":"#fa0000"},
			{"visibility":"off"}
		]
	},{
		"featureType":"road",
		"elementType":"labels.text.fill",
		"stylers":[
			{"color":"#73716d"},
			{"visibility":"on"}
		]
	},{
		"featureType":"road.highway",
		"elementType":"all",
		"stylers":[
			{"color":"#ffffff"},
			{"weight":"0.50"}
		]
	},{
		"featureType":"road.highway",
		"elementType":"labels.icon",
		"stylers":[
			{"visibility":"off"}
		]
	},{
		"featureType":"road.highway",
		"elementType":"labels.text.fill",
		"stylers":[
			{"color":"#73716d"}
		]
	},{
		"featureType":"water",
		"elementType":"geometry.fill",
		"stylers":[
			{"color":"#7dcdcd"}
		]
	}]';
}

function whitelab_get_search_map_script() {
	$default_lat = ( isset( $_GET['db_lat'] ) ? esc_js( $_GET['db_lat'] ) : 'db_main.default_location_lat' );
	$default_lng = ( isset( $_GET['db_lng'] ) ? esc_js( $_GET['db_lng'] ) : 'db_main.default_location_lng' );

	return '
	jQuery(document).ready(function($) {
		if ( jQuery("#db-main-search-map").length ) {
			if ( jQuery("body").hasClass("page-template-template-listing_search") ) {
				jQuery("#db-main-search-map").height(jQuery("#dt-main-listing-search").outerHeight());
			}
			var mapCanvas = document.getElementById("db-main-search-map");
			var location = new google.maps.LatLng('.$default_lat.', '.$default_lng.');
			var mapOptions = {
				center: location,
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: false,
				navigationControl: false,
				mapTypeControl: false,
				scaleControl: false,
				disableDefaultUI: false,
				styles: ' . whitelab_google_map_styles() . '
			}
			$search_map = new google.maps.Map(mapCanvas, mapOptions);
		}
	});';
}

function whitelab_get_header_autoplay( $autoplay ) {
	return '
	jQuery(document).ready(function($) {
		var $header_slider;
		jQuery(document).on("click", ".dt-sign-in-register", function() {
			clearInterval($header_slider);
			$header_slider = setInterval(function() {
				if ( jQuery(".dt-login-register-modal").hasClass("db-animate-dialog") ) {
					if ( jQuery(".dt-modal-left-page.active").next().length ) {
						jQuery(".dt-modal-left-page.active").next().click();
					} else {
						jQuery(".dt-modal-left-page").first().click();
					}
				} else {
					clearInterval($header_slider);
				}
			},' . intval( $autoplay ) . ');
		});
	});';
}

function whitelab_get_single_listing_map( $listing_lat, $listing_lng, $listing_category ) {
	return '
	jQuery(document).ready(function($) {
		if ( jQuery("#db-single-listing-map").length ) {
			var mapCanvas = document.getElementById("db-single-listing-map");
			var location = new google.maps.LatLng(db_main.default_location_lat, db_main.default_location_lng);
			var marker_location = new google.maps.LatLng(' . esc_attr( $listing_lat ) . ',' . esc_attr( $listing_lng ) . ');
			var mapOptions = {
				center: marker_location,
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: false,
				navigationControl: false,
				mapTypeControl: false,
				scaleControl: false,
				disableDefaultUI: false,
				styles: ' . whitelab_google_map_styles() . '
			}
			var listing_map = new google.maps.Map(mapCanvas, mapOptions);
			var marker = new RichMarker({
				position: marker_location,
				map: listing_map,
				draggable: false,
				shadow: "none",
				content: "<div class=\"db-map-marker ' . (isset($listing_category['tag-category-icon'])?esc_attr($listing_category['tag-category-icon']):'') . '\"></div>"
			});

			jQuery(document).on("click", ".db-expand-map", function() {
				jQuery(this).parent().addClass("active");
				setTimeout(function() {
					google.maps.event.trigger(listing_map,"resize");
					listing_map.setCenter(marker_location);
				}, 10);
			});

			jQuery(document).on("click", ".db-single-map-close", function() {
				jQuery(this).parent().parent().removeClass("active");
				setTimeout(function() {
					google.maps.event.trigger(listing_map,"resize");
					listing_map.setCenter(marker_location);
				}, 10);
			});
		}
	});';
}

function whitelab_vcSetAsTheme() {
	vc_set_as_theme( true );
}
add_action( 'vc_before_init', 'whitelab_vcSetAsTheme' );

add_action('after_setup_theme', 'whitelab_remove_admin_bar');
function whitelab_remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}