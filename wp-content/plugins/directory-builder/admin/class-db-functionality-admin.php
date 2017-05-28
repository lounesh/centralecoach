<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    db_func
 * @subpackage db_func/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    db_func
 * @subpackage db_func/admin
 * @author     Cohhe <support@cohhe.com>
 */
class db_func_Admin {

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

	private $db_pages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $db_func       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $db_func, $version ) {

		$this->db_func = $db_func;
		$this->version = $version;
		$this->db_pages = array(
			'toplevel_page_directory-builder-dashboard',
			'directory_page_directory-builder-fields',
			'directory_page_directory-builder-packages',
			'directory_page_directory-builder-claims',
			'directory_page_directory-builder-subscriptions',
			'directory_page_directory-builder-ads',
			'directory_page_directory-builder-registration',
			'directory_page_directory-builder-themes',
			'directory_page_directory-builder-settings',
			'directory_page_directory-builder-templates',
			'directory_page_directory-builder-import'
		);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
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


		if ( in_array($hook, $this->db_pages) ) {
			wp_enqueue_style( 'db-grid', plugin_dir_url( __FILE__ ) . 'css/grid.css', array(), $this->version, 'all' );
		}

		$extra_allowed = array(
			'edit.php',
			'edit-tags.php',
			'post.php',
			'post-new.php',
			'term.php'
		);

		if ( in_array($hook, $this->db_pages) || in_array($hook, $extra_allowed) ) {
			wp_enqueue_style( $this->db_func, plugin_dir_url( __FILE__ ) . 'css/db-functionality-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

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

		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_enqueue_style( 'wp-color-picker' );
		}

		$media_allowed = array(
			'edit-tags.php',
			'tags.php',
			'directory_page_directory-builder-packages',
			'directory_page_directory-builder-settings',
			'post.php',
			'post-new.php',
			'term.php'
		);

		if ( in_array($hook, $media_allowed) ) {
			wp_enqueue_media();
		}

		if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'directory_page_directory-builder-settings' ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		if ( in_array( $hook, $media_allowed ) || in_array( $hook, $this->db_pages ) || $hook == 'post.php' || $hook == 'post-new.php' || $hook = 'term.php' ) {
			wp_enqueue_script( $this->db_func, plugin_dir_url( __FILE__ ) . 'js/db-functionality-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

}
