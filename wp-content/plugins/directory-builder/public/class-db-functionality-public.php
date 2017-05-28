<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    db_func
 * @subpackage db_func/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    db_func
 * @subpackage db_func/public
 * @author     Cohhe <support@cohhe.com>
 */
class db_func_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $db_func    The ID of this plugin.
	 */
	private $db_func;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $db_func       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $db_func, $version ) {

		$this->db_func = $db_func;
		$this->version = $version;
		$this->main_settings = get_option( 'db_main_settings');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in db_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The db_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$main_settings = $this->main_settings;

		if ( file_exists($main_settings['db_theme_path'].'db-custom-style.css') ) {
			wp_enqueue_style( 'db-custom-style', preg_replace('#^https?://#', '//', $main_settings['db_theme_url'].'db-custom-style.css'), array(), '', 'all' );
		}
		 
		wp_enqueue_style( $this->db_func, plugin_dir_url( __FILE__ ) . 'css/db-functionality-public.css', array(), $this->version, 'all' );

		if ( is_single() && get_post_type() == 'listings' ) {
			$custom_img = esc_attr( get_post_meta( get_the_ID(), 'db_listing_custom_img', true ) );
			$img = wp_get_attachment_image_src( ($custom_img==''?get_post_thumbnail_id():$custom_img), 'full' );
			wp_add_inline_style( $this->db_func, '.db-listing-featured-img { background: url('.esc_url($img['0']).'); }' );
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in db_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The db_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$main_settings = $this->main_settings;

		wp_register_script( 'db-google-maps', '//maps.googleapis.com/maps/api/js?key='.$main_settings['google_key'], array( 'jquery' ), '', false );
		wp_register_script( 'richmarkers', plugin_dir_url( __FILE__ ) . 'js/richmarker-compiled.js', array( 'db-google-maps' ), '', false );
		wp_register_script( 'markerclusterer', plugin_dir_url( __FILE__ ) . 'js/markerclusterer.js', array( 'db-google-maps' ), '', false );
		wp_register_script( 'infobubble', plugin_dir_url( __FILE__ ) . 'js/infobubble.js', array(), '', false );

		wp_register_script( 'jquery.dropzone', plugin_dir_url( __FILE__ ) . 'js/dropzone.js', array(), '', false );

		wp_register_script( 'jquery.isotope', plugin_dir_url( __FILE__ ) . 'js/isotope.pkgd.min.js', array( 'jquery' ), '', false );

		wp_enqueue_script( 'db-public-js', plugin_dir_url( __FILE__ ) . 'js/db-functionality-public.js', array( 'jquery', 'db-google-maps' ), $this->version, false );
		wp_localize_script( 'db-public-js', 'db_main', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'plugin_url' => DB_PLUGIN_URI,
			'content_dir' => WP_CONTENT_DIR,
			'default_location' => $main_settings['default_location'],
			'default_location_lat' => $main_settings['default_location_lat'],
			'default_location_lng' => $main_settings['default_location_lng'],
			'template_url' => get_template_directory_uri(),
			'custom_sorting' => db_get_custom_sorting(),
			'custom_sorting_dir' => db_get_custom_sorting_dir(),
			'search_of' => esc_attr__( 'of', 'directory-builder' )
		));
	}

}
