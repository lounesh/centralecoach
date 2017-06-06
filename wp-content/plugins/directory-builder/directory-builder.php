<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cohhe.com/
 * @since             1.0
 * @package           db_func
 *
 * @wordbress-plugin
 * Plugin Name:       Directory builder
 * Plugin URI:        https://cohhe.com/
 * Description:       Directory builder provides listing functionality for your theme.
 * Version:           1.4.9
 * Author:            Cohhe
 * Author URI:        https://cohhe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       directory-builder
 * Domain Path:       /languages
 */

define( 'DB_CURRENT_VERSION', '1.4.9');

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-db-functionality-activator.php
 */
function db_activate_db_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-db-functionality-activator.php';
	db_func_Activator::db_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-db-functionality-deactivator.php
 */
function db_deactivate_db_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-db-functionality-deactivator.php';
	db_func_Deactivator::db_deactivate();
}

register_activation_hook( __FILE__, 'db_activate_db_func' );
register_deactivation_hook( __FILE__, 'db_deactivate_db_func' );

function db_is_current_version() {
	$curr_version = get_option( 'db_plugin_version' );
	return version_compare($curr_version, DB_CURRENT_VERSION, '=') ? true : false;
}

function db_check_actual_version() {
	if ( is_user_logged_in() && current_user_can('manage_options') && !db_is_current_version() ) db_activate_db_func();
}
add_action( 'admin_init', 'db_check_actual_version' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
define('DB_PLUGIN', plugin_dir_path( __FILE__ ));
define('DB_PLUGIN_URI', plugin_dir_url( __FILE__ ));
define('DB_PLUGIN_DASH_PAGE', 'directory-builder-dashboard');
define('DB_PLUGIN_FIELD_PAGE', 'directory-builder-fields');
define('DB_PLUGIN_SETTING_PAGE', 'directory-builder-settings');
define('DB_PLUGIN_PACKAGE_PAGE', 'directory-builder-packages');
define('DB_PLUGIN_THEME_PAGE', 'directory-builder-themes');
define('DB_PLUGIN_CLAIMS_PAGE', 'directory-builder-claims');
define('DB_PLUGIN_SUB_PAGE', 'directory-builder-subscriptions');
define('DB_PLUGIN_AD_PAGE', 'directory-builder-ads');
define('DB_PLUGIN_REG_PAGE', 'directory-builder-registration');
define('DB_PLUGIN_EMAIL_PAGE', 'directory-builder-templates');
define('DB_PLUGIN_IMPORT_PAGE', 'directory-builder-import');

define('DB_PLUGIN_DASH_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_DASH_PAGE);
define('DB_PLUGIN_FIELD_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_FIELD_PAGE);
define('DB_PLUGIN_SETTING_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_SETTING_PAGE);
define('DB_PLUGIN_PACKAGE_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_PACKAGE_PAGE);
define('DB_PLUGIN_THEME_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_THEME_PAGE);
define('DB_PLUGIN_CLAIMS_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_CLAIMS_PAGE);
define('DB_PLUGIN_SUB_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_SUB_PAGE);
define('DB_PLUGIN_AD_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_AD_PAGE);
define('DB_PLUGIN_REG_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_REG_PAGE);
define('DB_PLUGIN_EMAIL_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_EMAIL_PAGE);
define('DB_PLUGIN_IMPORT_PAGE_URL', get_admin_url() . 'admin.php?page=' . DB_PLUGIN_IMPORT_PAGE);

require plugin_dir_path( __FILE__ ) . 'includes/class-db-functionality.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_db_func() {

	$plugin = new db_func();
	$plugin->db_run();

}
run_db_func();

function db_register_manager_menu_page() {
	add_menu_page(
		__( 'Directory', 'directory-builder' ),
		__( 'Directory', 'directory-builder' ),
		'manage_options',
		DB_PLUGIN_DASH_PAGE,
		'',
		'dashicons-location',
		26
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Dashboard', 'directory-builder'),
		__('Dashboard', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_DASH_PAGE,
		'db_main_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Custom fields', 'directory-builder'),
		__('Custom fields', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_FIELD_PAGE,
		'db_field_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Packages', 'directory-builder'),
		__('Packages', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_PACKAGE_PAGE,
		'db_package_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Listing claims', 'directory-builder'),
		__('Listing claims', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_CLAIMS_PAGE,
		'db_claims_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Subscriptions', 'directory-builder'),
		__('Subscriptions', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_SUB_PAGE,
		'db_subscriptions_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Advertisements', 'directory-builder'),
		__('Advertisements', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_AD_PAGE,
		'db_ads_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Registration', 'directory-builder'),
		__('Registration', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_REG_PAGE,
		'db_reg_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Email templates', 'directory-builder'),
		__('Email templates', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_EMAIL_PAGE,
		'db_email_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Import', 'directory-builder'),
		__('Import', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_IMPORT_PAGE,
		'db_import_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Themes', 'directory-builder'),
		__('Themes', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_THEME_PAGE,
		'db_theme_html'
	);

	add_submenu_page(
		DB_PLUGIN_DASH_PAGE,
		__('Settings', 'directory-builder'),
		__('Settings', 'directory-builder'),
		'manage_options',
		DB_PLUGIN_SETTING_PAGE,
		'db_settings_html'
	);

}
add_action( 'admin_menu', 'db_register_manager_menu_page' );

add_action( 'init', 'vh_create_post_type' );
function vh_create_post_type() {
	$main_settings = get_option( 'db_main_settings', array());

	register_post_type( 'listings',
		array(
		'labels' => array(
			'name' => __( 'Listings', "directory-builder" ),
			'singular_name' => __( 'Listing', "directory-builder" ),
			'add_new' => 'Add New Listing',
			'add_new_item' => 'Add New Listing',
			'edit_item' => 'Edit Listing',
			'new_item' => 'New Listing',
			'view_item' => 'View listing',
		),
		'taxonomies' => array('listing_category'),
		'rewrite' => array('slug'=>$main_settings['directory_slug'],'with_front'=>false),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'revisions',
			'thumbnail',
			'comments',
			'excerpt'
			),
		'menu_icon' => 'dashicons-location',
		'menu_position' => '25'
		)
	);

	register_taxonomy( 'listing_category',
		array (
			0 => 'listings',
		),
		array( 
			'hierarchical' => true, 
			'label' => 'Listing categories',
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => $main_settings['category_slug'], 'with_front'=>false),
			'singular_label' => 'Listing category'
		) 
	);

	add_image_size( 'db_single_listing', 550 );
}

function db_available_icons() {
	$available_icons = array();

	if ( file_exists( dirname( __FILE__ ) . '/font/config.json' ) ) {
		$font_configuration = json_decode( file_get_contents( dirname( __FILE__ ) . '/font/config.json' ), true );

		if ( !empty( $font_configuration['glyphs'] ) ) {
			foreach ( $font_configuration['glyphs'] as $font_data ) {
				$available_icons[] = $font_configuration['css_prefix_text'] . $font_data['css'];
			}
		}
	}

	$available_icons[] = 'wl-health';
	$available_icons[] = 'wl-catering';
	$available_icons[] = 'wl-beauty';
	$available_icons[] = 'wl-finances';
	$available_icons[] = 'wl-plants';

	return $available_icons;
}


add_action ( 'listing_category_add_form_fields', 'db_add_category_fields');
function db_add_category_fields( $tag ) {
	$cat_meta = array();
	?>
	<div class="form-field term-default-image-wrap">
		<label for="tag-default-image">Default listing image</label>
		<div class="db-image-container">
			<?php echo (isset($cat_meta['tag-default-image'])&&$cat_meta['tag-default-image']!=''?'<img src="'.$cat_meta['tag-default-image'].'" alt="">':''); ?>
		</div>
		<input type="hidden" class="upload-field-value" name="tag-default-image" value="<?php echo (isset($cat_meta['tag-default-image'])&&$cat_meta['tag-default-image']!=''?$cat_meta['tag-default-image']:''); ?>">
		<input type="button" id="tag-default-image" class="db-image-upload" value="Upload image">
		<input type="button" class="db-image-delete" value="Delete image" <?php echo (!isset($cat_meta['tag-default-image'])||$cat_meta['tag-default-image']==''?'style="display: none;"':''); ?>>
		<p>Choose a default "No image".</p>
	</div>
	<div class="form-field term-category-icon-wrap">
		<label for="tag-category-icon">Category icon</label>
		<?php echo __('Icon selected: ', 'directory-builder').'<i class="db-active-category-icon "></i>'; ?>
		<div class="clearfix"></div>
		<input type="hidden" name="tag-category-icon" value="<?php echo (isset($cat_meta['tag-category-icon'])&&$cat_meta['tag-category-icon']!=''?$cat_meta['tag-category-icon']:''); ?>">
		<input type="button" id="db-choose-category-icon" value="Choose icon">
		<div class="db-category-icon-dialog main-card">
			<div class="db-category-icon-dialog-inner">
				<span class="db-category-icon-dialog-close dbicon-cancel"></span>
				<?php
					$icons = db_available_icons();
					foreach ($icons as $icon_value) {
						echo '<i class="db-category-icon-select '.$icon_value.'" data-id="'.$icon_value.'"></i>';
					}
				?>
			</div>
		</div>
		<p>Choose category icon.</p>
	</div>
	<div class="form-field term-category-icon-wrap">
		<label for="tag-category-color">Category color</label>
		<input type="text" id="db-choose-category-color" name="tag-category-color" value="<?php echo (isset($cat_meta['tag-category-color'])&&$cat_meta['tag-category-color']!=''?$cat_meta['tag-category-color']:''); ?>">
	</div>
	<?php
}

add_action ( 'listing_category_edit_form_fields', 'db_edit_category_fields');
function db_edit_category_fields( $tag ) {
	$t_id = $tag->term_id;
	$cat_meta = get_option( "listing_category_$t_id");
	?>
	<tr class="form-field term-default-image-wrap">
		<th scope="row"><label for="description">Default listing image</label></th>
		<td>
			<div class="db-image-container">
				<?php echo (isset($cat_meta['tag-default-image'])&&$cat_meta['tag-default-image']!=''?'<img src="'.$cat_meta['tag-default-image'].'" alt="">':''); ?>
			</div>
			<input type="hidden" class="upload-field-value" name="tag-default-image" value="<?php echo (isset($cat_meta['tag-default-image'])&&$cat_meta['tag-default-image']!=''?$cat_meta['tag-default-image']:''); ?>">
			<input type="button" id="tag-default-image" class="db-image-upload" value="Upload image">
			<input type="button" class="db-image-delete" value="Delete image" <?php echo (!isset($cat_meta['tag-default-image'])||$cat_meta['tag-default-image']==''?'style="display: none;"':''); ?>>
			<p class="description">Choose a default "No image".</p>
		</td>
	</tr>
	<tr class="form-field term-category-icon-wrap">
		<th scope="row"><label for="description">Category icon</label></th>
		<td>
			<?php echo __('Icon selected: ', 'directory-builder').'<i class="db-active-category-icon '.(isset($cat_meta['tag-category-icon'])?$cat_meta['tag-category-icon']:'').'"></i>'; ?>
			<div class="clearfix"></div>
			<input type="hidden" name="tag-category-icon" value="<?php echo (isset($cat_meta['tag-category-icon'])&&$cat_meta['tag-category-icon']!=''?$cat_meta['tag-category-icon']:''); ?>">
			<input type="button" id="db-choose-category-icon" value="Choose icon">
			<div class="category-icon-modal-container">
				<div class="db-category-icon-dialog main-card">
					<div class="db-category-icon-dialog-inner">
						<span class="db-category-icon-dialog-close dbicon-cancel"></span>
						<?php
							$icons = db_available_icons();
							foreach ($icons as $icon_value) {
								echo '<i class="db-category-icon-select '.$icon_value.'" data-id="'.$icon_value.'"></i>';
							}
						?>
					</div>
				</div>
			</div>
			<p>Choose category icon.</p>
		</td>
	</tr>
	<tr class="form-field term-category-icon-wrap">
		<th scope="row"><label for="description">Category color</label></th>
		<td>
			<input type="text" id="db-choose-category-color" name="tag-category-color" value="<?php echo (isset($cat_meta['tag-category-color'])&&$cat_meta['tag-category-color']!=''?$cat_meta['tag-category-color']:''); ?>">
		</td>
	</tr>
	<?php
}

add_action ( 'edited_listing_category', 'db_save_category_fields');
add_action ( 'create_listing_category', 'db_save_category_fields');
function db_save_category_fields( $term_id ) {
	$saved_options = 0;
	$t_id = $term_id;
	$cat_meta = get_option( "listing_category_$t_id");
	if ( isset( $_POST['tag-default-image'] ) ) {
		$cat_meta['tag-default-image'] = esc_url($_POST['tag-default-image']);
		$saved_options++;
	}

	if ( isset( $_POST['tag-category-icon'] ) ) {
		$cat_meta['tag-category-icon'] = sanitize_key($_POST['tag-category-icon']);
		$saved_options++;
	}

	if ( isset( $_POST['tag-category-color'] ) ) {
		$cat_meta['tag-category-color'] = sanitize_text_field($_POST['tag-category-color']);
		$saved_options++;
	}
	
	if ( $saved_options > 0 ) {
		update_option( "listing_category_$t_id", $cat_meta );
	}
}

function db_main_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<div class="db-box-title">
				<h3 class="db-main-title">Custom templates</h3>
			</div>
			<p>There are 3 destinations for templates, the default one in the plugin, inside your theme and custom ones saved in your WordPress <b>wp-content/db-plugin-themes</b> directory. The default theme inside the plugin is always the newest one and gets updated along with the plugin updates. The theme inside a theme directory is updated eather by you or your theme author. The custom themes uploaded via a zip file is updated and maintained by the custom theme author.</p>
			<br>
			<p>A valid custom theme counts as a <b>.zip</b> file containing <b>theme_data.json</b>, if you want to create a custom theme we suggest you to copy the default theme that's located in the plugin folder(<b>directory-builder/template</b>) and rename it into an unique name. From there you can start editing the template files by adding or removing information. Next step would be to edit the themes <b>theme_data.json</b> file that contains information about your custom theme like version, author and description. The last and final step is to archive your new template folder into a <b>.zip</b> file.</p>
		</div>
		<div class="db-main-content main-card db-m-t-20">
			<div class="db-box-title">
				<h3 class="db-main-title">Available shortcodes</h3>
			</div>
			<div class="db-row">
				<div class="db-row-group clearfix">
					<span class="db-row-label col-sm-2"><b>[directory_listings]</b></span>
					<div class="col-sm-10">
						This shortcode is going to show listing search with a map, you can control search settings at the Dashboard > Directory > Settings
					</div>
				</div>
			</div>
			<div class="db-row">
				<div class="db-row-group clearfix">
					<span class="db-row-label col-sm-2"><b>[directory_add_listing]</b></span>
					<div class="col-sm-10">
						This shortcode is going to add the add listing form so your users can add their listings to your page!
					</div>
				</div>
			</div>
			<div class="db-row">
				<div class="db-row-group clearfix">
					<span class="db-row-label col-sm-2"><b>[directory_account]</b></span>
					<div class="col-sm-10">
						This shortcode is going to show all of the user listings with the ability to edit and/or delete them.
					</div>
				</div>
			</div>
			<div class="db-row">
				<div class="db-row-group clearfix">
					<span class="db-row-label col-sm-2"><b>[directory_login]</b></span>
					<div class="col-sm-10">
						This shortcode is going to show the login form so your users can login to your page.
					</div>
				</div>
			</div>
			<div class="db-row">
				<div class="db-row-group clearfix">
					<span class="db-row-label col-sm-2"><b>[directory_register]</b></span>
					<div class="col-sm-10">
						This shortcode is going to show the register form so your users can register and start adding their listings!
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
}

function db_field_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<?php if ( !isset($_GET['field_type']) && !isset($_GET['field_id']) ) { ?>
				<a href="javascript:void(0)" class="db-add-new-field db-button db-primary-button">Add new</a>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="width: 5%;">Order</th>
							<th style="width: 65%;">Name</th>
							<th style="width: 15%;">Type</th>
							<th style="width: 15%;">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						global $wpdb;
						$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields ORDER BY field_order, ID ASC');
						if ( !empty($field_list) ) {
							foreach ($field_list as $field_value) {
								$field_settings = json_decode($field_value->field_settings, true);
								$is_child = (isset($field_settings['child'])&&$field_settings['child']=='true'?'db-child-field':'');
								$disabled_settings = (isset($field_settings['disabled'])?explode(',', $field_settings['disabled']):array());

								echo '
								<tr class="'.$is_child.'">
									<td class="db-field-order">'.($is_child==''?$field_settings['display_order']:'').'</td>
									<td class="db-field-name">'.$field_settings['admin_title'].'</td>
									<td class="db-custom-field-type">'.$field_settings['field_type'].'</td>
									<td class="db-field-actions">';
										if ( !in_array('edit', $disabled_settings) ) {
											echo '<a href="'.DB_PLUGIN_FIELD_PAGE_URL.'&field_id='.$field_value->ID.'" class="db-edit-field">Edit</a>';
										}
										echo ' ';
										if ( !in_array('delete', $disabled_settings) ) {
											echo '<a href="javascript:void(0)" class="db-delete-field" data-id="'.$field_value->ID.'">Delete</a>';
										}
									echo '
									</td>
								</tr>';
							}
						}
						?>
					</tbody>
				</table>
				<div class="db-custom-field-dialog main-card" style="display: none;">
					<div class="db-field-row clearfix">
						<label class="field-label">Field type</label>
						<select class="db-field-type">
							<option value="text">Text</option>
							<option value="number">Number</option>
							<option value="textarea">Textarea</option>
							<option value="checkbox">Checkbox</option>
							<option value="radio">Radio</option>
							<option value="select">Select</option>
							<option value="multi-select">Multi select</option>
							<option value="url">URL</option>
							<option value="file-upload">File upload</option>
							<option value="date">Date</option>
							<option value="time">Time</option>
							<option value="email">Email</option>
							<option value="html">HTML</option>
							<option value="hoursofoperation">Hours of operation</option>
						</select>
					</div>
					<a href="javascript:void(0)" class="db-proceed-field db-button db-primary-button">Proceed</a>
				</div>
				<div class="db-dialog-overlay" style="display: none;"></div>
			<?php } else if ( isset($_GET['field_type']) || isset($_GET['field_id']) ) {
				$field_settings = array();
				$disabled_settings = array();
				$is_child = false;
				if ( isset($_GET['field_id']) ) {
					global $wpdb;
					$field_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE ID="'.intval($_GET['field_id']).'"');
					$field_settings = json_decode($field_data['0']->field_settings, true);
					$disabled_settings = (isset($field_settings['disabled'])?explode(',', $field_settings['disabled']):array());
					$is_child = (isset($field_settings['child'])&&$field_settings['child']=='true'?true:false);
				}
				$field_type = (isset($_GET['field_type'])?sanitize_text_field($_GET['field_type']):$field_settings['field_type']);
				?>
				<div class="db-custom-field">
					<div class="db-box-title">
						<h3 class="db-main-title">Custom field</h3>
					</div>
					<?php if ( !in_array('delete', $disabled_settings) ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['field_name'])&&$field_settings['field_name']!=''?'active':''); ?> clearfix">
							<label class="field-label">Field name <span class="db-required">*</span></label>
							<div class="db-field-input">
								<input type="text" class="db-create-field-name" data-required="true" value="<?php echo(isset($field_settings['field_name'])?$field_settings['field_name']:''); ?>">
								<span class="field-description">Unique name only from letters a-z</span>
								<span class="db-field-required">This field is required</span>
							</div>
						</div>
					<?php } ?>
					<div class="db-field-row <?php echo(isset($field_settings['admin_title'])&&$field_settings['admin_title']!=''?'active':''); ?> clearfix">
						<label class="field-label">Admin title</label>
						<div class="db-field-input">
							<input type="text" class="db-create-admin-title" value="<?php echo(isset($field_settings['admin_title'])?$field_settings['admin_title']:''); ?>">
							<span class="field-description">This is the name how you'll see it at the back-end field list</span>
						</div>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['frontend_title'])&&$field_settings['frontend_title']!=''?'active':''); ?> clearfix">
						<label class="field-label">Frontend title <span class="db-required">*</span></label>
						<div class="db-field-input">
							<input type="text" class="db-create-frontend-title" data-required="true" value="<?php echo(isset($field_settings['frontend_title'])?$field_settings['frontend_title']:''); ?>">
							<span class="field-description">How this field is going to be shown to other users</span>
							<span class="db-field-required">This field is required</span>
						</div>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['frontend_description'])&&$field_settings['frontend_description']!=''?'active':''); ?> clearfix">
						<label class="field-label">Frontend description</label>
						<div class="db-field-input">
							<input type="text" class="db-create-frontend-description" value="<?php echo(isset($field_settings['frontend_description'])?$field_settings['frontend_description']:''); ?>">
							<span class="field-description">The description which is going to be shown to users</span>
						</div>
					</div>
					<?php if ( ( isset($_GET['field_type']) && sanitize_key($_GET['field_type']) != 'hoursofoperation' ) || ( !isset($_GET['field_type']) && sanitize_key($field_settings['field_type']) != 'hoursofoperation' ) ) { ?>
					<div class="db-field-row <?php echo(isset($field_settings['default_value'])&&$field_settings['default_value']!=''?'active':''); ?> clearfix">
						<label class="field-label">Default value</label>
						<div class="db-field-input">
							<input type="text" class="db-create-default-value" value="<?php echo(isset($field_settings['default_value'])?$field_settings['default_value']:''); ?>">
							<span class="field-description"><?php echo ($field_type!='url'?'If this field has a default value, enter it here':'Link text for frontend'); ?></span>
						</div>
					</div>
					<?php } ?>
					<div class="db-field-row <?php echo(isset($field_settings['display_order'])&&$field_settings['display_order']!=''?'active':''); ?> clearfix">
						<label class="field-label">Display order</label>
						<div class="db-field-input">
							<input type="number" class="db-create-display-order" value="<?php echo(isset($field_settings['display_order'])?$field_settings['display_order']:''); ?>" <?php echo(in_array('display_order', $disabled_settings)?'disabled':''); ?>>
							<span class="field-description">The order in which it's goint to be shown to users</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Active?</label>
						<div class="db-field-input">
							<select class="db-create-field-active" <?php echo(in_array('field_active', $disabled_settings)?'disabled':''); ?>>
								<option value="yes" <?php echo(isset($field_settings['field_active'])&&$field_settings['field_active']=='yes'?'selected':''); ?>>Yes</option>
								<option value="no" <?php echo(isset($field_settings['field_active'])&&$field_settings['field_active']=='no'?'selected':''); ?>>No</option>
							</select>
							<span class="field-description">Do you want to show this field to users?</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">For admins?</label>
						<div class="db-field-input">
							<select class="db-create-for-admins">
								<option value="no" <?php echo(isset($field_settings['for_admins'])&&$field_settings['for_admins']=='no'?'selected':''); ?>>No</option>
								<option value="yes" <?php echo(isset($field_settings['for_admins'])&&$field_settings['for_admins']=='yes'?'selected':''); ?>>Yes</option>
							</select>
							<span class="field-description">Only admins will be able to edit it</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Required?</label>
						<div class="db-field-input">
							<select class="db-create-required">
								<option value="yes" <?php echo(isset($field_settings['required'])&&$field_settings['required']=='yes'?'selected':''); ?>>Yes</option>
								<option value="no" <?php echo(isset($field_settings['required'])&&$field_settings['required']=='no'?'selected':''); ?>>No</option>
							</select>
							<span class="field-description">Is it required to fill this field in?</span>
						</div>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['required_message'])&&$field_settings['required_message']!=''?'active':''); ?> clearfix">
						<label class="field-label">Required message</label>
						<div class="db-field-input">
							<input type="text" class="db-create-required-message" value="<?php echo(isset($field_settings['required_message'])?$field_settings['required_message']:''); ?>">
							<span class="field-description">Message to be shown to users if they do not fill this field in.</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Show on list pages?</label>
						<div class="db-field-input">
							<select class="db-create-on-listing">
								<option value="no" <?php echo(isset($field_settings['on_listing'])&&$field_settings['on_listing']=='no'?'selected':''); ?>>No</option>
								<option value="yes" <?php echo(isset($field_settings['on_listing'])&&$field_settings['on_listing']=='yes'?'selected':''); ?>>Yes</option>
							</select>
							<span class="field-description">Do you want to show this field on pages that display listings in lists (for example search)?</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Show on details page?</label>
						<div class="db-field-input">
							<select class="db-create-on-detail">
								<option value="no" <?php echo(isset($field_settings['on_detail'])&&$field_settings['on_detail']=='no'?'selected':''); ?>>No</option>
								<option value="yes" <?php echo(isset($field_settings['on_detail'])&&$field_settings['on_detail']=='yes'?'selected':''); ?>>Yes</option>
							</select>
							<span class="field-description">Do you want to show this field on single listing page?</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Show on contact section?</label>
						<div class="db-field-input">
							<select class="db-create-on-contact">
								<option value="no" <?php echo(isset($field_settings['on_contact'])&&$field_settings['on_contact']=='no'?'selected':''); ?>>No</option>
								<option value="yes" <?php echo(isset($field_settings['on_contact'])&&$field_settings['on_contact']=='yes'?'selected':''); ?>>Yes</option>
							</select>
							<span class="field-description">Do you want to show this field on the contact section at the single listing pages?</span>
						</div>
					</div>
					<?php
					$sorting_types = array( 'text', 'number', 'textarea', 'checkbox', 'radio', 'select', 'multi-select', 'url', 'date', 'time', 'email' );
					if ( in_array($field_type, $sorting_types) ) { ?>
						<div class="db-field-row focused active clearfix">
							<label class="field-label">Show in sorting options?</label>
							<div class="db-field-input">
								<select class="db-create-on-sorting">
									<option value="no" <?php echo(isset($field_settings['on_sorting'])&&$field_settings['on_sorting']=='no'?'selected':''); ?>>No</option>
									<option value="yes" <?php echo(isset($field_settings['on_sorting'])&&$field_settings['on_sorting']=='yes'?'selected':''); ?>>Yes</option>
								</select>
								<span class="field-description">Do you want to show this field in sorting options at the search page?</span>
							</div>
						</div>
					<?php } ?>
					<div class="db-field-row active clearfix">
						<label class="field-label">Apply to categories</label>
						<div class="db-field-input">
							<select class="db-create-apply_categories" multiple>
							<?php
							$categories = get_terms( array(
								'taxonomy' => 'listing_category',
								'hide_empty' => false
							));
							if ( !empty($categories) ) {
								$categoryHierarchy = array();
								db_sort_terms_hierarchicaly($categories, $categoryHierarchy);

								foreach ($categoryHierarchy as $category_value) {
									$is_checked = (in_array($category_value->term_id, $field_settings['apply_categories'])?'selected':'');
									echo '<option value="'.$category_value->term_id.'" '.$is_checked.'>'.$category_value->name.'</option>';

									if ( !empty($category_value->children) ) {
										echo db_display_backend_categories( $category_value, $field_settings['apply_categories'] );
									}
								}
							}
							?>
							</select>
							<span class="field-description shown">If this field is only available to certain categories, then select those categories. If none of the categories are selected, then this field will be shown for all categories.</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Custom field icon</label>
						<div class="db-field-input">
							<div class="db-field-input">
								<?php echo __('Icon selected: ', 'directory-builder').'<i class="db-active-category-icon '.(isset($field_settings['field_icon'])&&$field_settings['field_icon']!=''?$field_settings['field_icon']:'').'"></i>'; ?>
								<div class="clearfix"></div>
								<input type="hidden" class="db-create-field-icon" value="<?php echo (isset($field_settings['field_icon'])&&$field_settings['field_icon']!=''?$field_settings['field_icon']:''); ?>">
								<input type="button" id="db-choose-category-icon" value="<?php esc_html_e('Choose icon', 'directory-builder'); ?>">
								<input type="button" id="db-delete-field-icon" value="<?php esc_html_e('Delete icon', 'directory-builder'); ?>" class="<?php echo (isset($field_settings['field_icon'])&&$field_settings['field_icon']!=''?'db-button-visible':''); ?>">
								<div class="db-category-icon-dialog main-card">
									<div class="db-category-icon-dialog-inner">
										<span class="db-category-icon-dialog-close dbicon-cancel"></span>
										<?php
											$icons = db_available_icons();
											$icons[] = 'wl-location';
											$icons[] = 'wl-phone';
											$icons[] = 'wl-link';
											foreach ($icons as $icon_value) {
												echo '<i class="db-category-icon-select '.$icon_value.'" data-id="'.$icon_value.'"></i>';
											}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if ( isset( $field_settings['disabled'] ) ) { ?>
						<input type="hidden" class="db-create-disabled" value="<?php echo $field_settings['disabled']; ?>">
					<?php } ?>
					<?php if ( in_array('delete', $disabled_settings) ) { ?>
						<input type="hidden" class="db-create-field-name" data-required="true" value="<?php echo(isset($field_settings['field_name'])?$field_settings['field_name']:''); ?>">
					<?php } ?>
					<?php if ( $field_type == 'text' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['validation_pattern'])&&$field_settings['validation_pattern']!=''?'active':''); ?> clearfix">
							<label class="field-label">Validation pattern</label>
							<div class="db-field-input">
								<input type="text" class="db-create-validation-pattern" value="<?php echo(isset($field_settings['validation_pattern'])?$field_settings['validation_pattern']:''); ?>">
								<span class="field-description">Validation pattern for HTML5 validation</span>
								<span class="field-description">Example: <strong>[A-Za-z]{3}</strong> - Any 3 letters from a to z</span>
							</div>
						</div>
						<div class="db-field-row <?php echo(isset($field_settings['validation_pattern_message'])&&$field_settings['validation_pattern_message']!=''?'active':''); ?> clearfix">
							<label class="field-label">Validation pattern message</label>
							<div class="db-field-input">
								<input type="text" class="db-create-validation-pattern-message" value="<?php echo(isset($field_settings['validation_pattern_message'])?$field_settings['validation_pattern_message']:''); ?>">
								<span class="field-description">Validation pattern message for HTML5 validation</span>
							</div>
						</div>
					<?php } else if ( $field_type == 'radio' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['radio_options'])&&$field_settings['radio_options']!=''?'active':''); ?> clearfix">
							<label class="field-label">Radio button values</label>
							<div class="db-field-input">
								<input type="text" class="db-create-radio-options" value="<?php echo(isset($field_settings['radio_options'])?$field_settings['radio_options']:''); ?>">
								<span class="field-description">Provide radio button values separated with comma:</span>
								<span class="field-description">No WiFi,WiFi included,Nagotiable</span>
							</div>
						</div>
					<?php } else if ( $field_type == 'select' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['select_options'])&&$field_settings['select_options']!=''?'active':''); ?> clearfix">
							<label class="field-label">Select values</label>
							<div class="db-field-input">
								<textarea class="db-create-select-options"><?php echo(isset($field_settings['select_options'])?$field_settings['select_options']:''); ?></textarea>
								<span class="field-description">Provide select option values, field name:field value, each value in a new line like so:</span>
								<span class="field-description">no-wifi:No WiFi<br>wifi-included:WiFi included</span>
							</div>
						</div>
					<?php } else if ( $field_type == 'file-upload' ) {
						$all_selected_types = (isset($field_settings['allowed_types'])?$field_settings['allowed_types']:array()); ?>
						<div class="db-field-row active clearfix">
							<label class="field-label">Allowed file types</label>
							<div class="db-field-input">
								<select class="db-create-allowed-types" multiple>
									<option value="*" selected="selected">All types</option>
									<optgroup label="Image formats">
											<option value="jpg" <?php echo(in_array('jpg',$all_selected_types)?'selected':''); ?>>.jpg</option>
											<option value="jpe" <?php echo(in_array('jpe',$all_selected_types)?'selected':''); ?>>.jpe</option>
											<option value="jpeg" <?php echo(in_array('jpeg',$all_selected_types)?'selected':''); ?>>.jpeg</option>
											<option value="gif" <?php echo(in_array('gif',$all_selected_types)?'selected':''); ?>>.gif</option>
											<option value="png" <?php echo(in_array('png',$all_selected_types)?'selected':''); ?>>.png</option>
											<option value="bmp" <?php echo(in_array('bmp',$all_selected_types)?'selected':''); ?>>.bmp</option>
											<option value="ico" <?php echo(in_array('ico',$all_selected_types)?'selected':''); ?>>.ico</option>
										</optgroup>
									<optgroup label="Video formats">
											<option value="asf" <?php echo(in_array('asf',$all_selected_types)?'selected':''); ?>>.asf</option>
											<option value="avi" <?php echo(in_array('avi',$all_selected_types)?'selected':''); ?>>.avi</option>
											<option value="flv" <?php echo(in_array('flv',$all_selected_types)?'selected':''); ?>>.flv</option>
											<option value="mkv" <?php echo(in_array('mkv',$all_selected_types)?'selected':''); ?>>.mkv</option>
											<option value="mp4" <?php echo(in_array('mp4',$all_selected_types)?'selected':''); ?>>.mp4</option>
											<option value="mpeg" <?php echo(in_array('mpeg',$all_selected_types)?'selected':''); ?>>.mpeg</option>
											<option value="mpg" <?php echo(in_array('mpg',$all_selected_types)?'selected':''); ?>>.mpg</option>
											<option value="wmv" <?php echo(in_array('wmv',$all_selected_types)?'selected':''); ?>>.wmv</option>
											<option value="3gp" <?php echo(in_array('3gp',$all_selected_types)?'selected':''); ?>>.3gp</option>
										</optgroup>
									<optgroup label="Audio formats">
											<option value="ogg" <?php echo(in_array('ogg',$all_selected_types)?'selected':''); ?>>.ogg</option>
											<option value="mp3" <?php echo(in_array('mp3',$all_selected_types)?'selected':''); ?>>.mp3</option>
											<option value="wav" <?php echo(in_array('wav',$all_selected_types)?'selected':''); ?>>.wav</option>
											<option value="wma" <?php echo(in_array('wma',$all_selected_types)?'selected':''); ?>>.wma</option>
										</optgroup>
									<optgroup label="Text formats">
											<option value="css" <?php echo(in_array('css',$all_selected_types)?'selected':''); ?>>.css</option>
											<option value="csv" <?php echo(in_array('csv',$all_selected_types)?'selected':''); ?>>.csv</option>
											<option value="htm" <?php echo(in_array('htm',$all_selected_types)?'selected':''); ?>>.htm</option>
											<option value="html" <?php echo(in_array('html',$all_selected_types)?'selected':''); ?>>.html</option>
											<option value="txt" <?php echo(in_array('txt',$all_selected_types)?'selected':''); ?>>.txt</option>
											<option value="rtx" <?php echo(in_array('rtx',$all_selected_types)?'selected':''); ?>>.rtx</option>
											<option value="vtt" <?php echo(in_array('vtt',$all_selected_types)?'selected':''); ?>>.vtt</option>
										</optgroup>
									<optgroup label="Application formats">
											<option value="doc" <?php echo(in_array('doc',$all_selected_types)?'selected':''); ?>>.doc</option>
											<option value="docx" <?php echo(in_array('docx',$all_selected_types)?'selected':''); ?>>.docx</option>
											<option value="exe" <?php echo(in_array('exe',$all_selected_types)?'selected':''); ?>>.exe</option>
											<option value="js" <?php echo(in_array('js',$all_selected_types)?'selected':''); ?>>.js</option>
											<option value="odt" <?php echo(in_array('odt',$all_selected_types)?'selected':''); ?>>.odt</option>
											<option value="pdf" <?php echo(in_array('pdf',$all_selected_types)?'selected':''); ?>>.pdf</option>
											<option value="pot" <?php echo(in_array('pot',$all_selected_types)?'selected':''); ?>>.pot</option>
											<option value="ppt" <?php echo(in_array('ppt',$all_selected_types)?'selected':''); ?>>.ppt</option>
											<option value="pptx" <?php echo(in_array('pptx',$all_selected_types)?'selected':''); ?>>.pptx</option>
											<option value="psd" <?php echo(in_array('psd',$all_selected_types)?'selected':''); ?>>.psd</option>
											<option value="rar" <?php echo(in_array('rar',$all_selected_types)?'selected':''); ?>>.rar</option>
											<option value="rtf" <?php echo(in_array('rtf',$all_selected_types)?'selected':''); ?>>.rtf</option>
											<option value="swf" <?php echo(in_array('swf',$all_selected_types)?'selected':''); ?>>.swf</option>
											<option value="tar" <?php echo(in_array('tar',$all_selected_types)?'selected':''); ?>>.tar</option>
											<option value="xls" <?php echo(in_array('xls',$all_selected_types)?'selected':''); ?>>.xls</option>
											<option value="xlsx" <?php echo(in_array('xlsx',$all_selected_types)?'selected':''); ?>>.xlsx</option>
											<option value="zip" <?php echo(in_array('zip',$all_selected_types)?'selected':''); ?>>.zip</option>
										</optgroup>
								</select>
							</div>
						</div>
					<?php } else if ( $field_type == 'date' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['date_format'])&&$field_settings['date_format']!=''?'active':'active'); ?> clearfix">
							<label class="field-label">Date format</label>
							<div class="db-field-input">
								<input type="text" class="db-create-date-format" value="<?php echo(isset($field_settings['date_format'])?$field_settings['date_format']:'mm/dd/yy'); ?>">
								<span class="field-description">Provide date format for the datepicker</span>
							</div>
						</div>
					<?php } else if ( $field_type == 'multi-select' ) { ?>
						<div class="db-field-row focused active clearfix">
							<label class="field-label">Multiselect type</label>
							<div class="db-field-input">
								<select class="db-create-multiselect-type">
									<option value="select" <?php echo(isset($field_settings['multiselect_type'])&&$field_settings['multiselect_type']=='select'?'selected':''); ?>>Select</option>
									<option value="checkbox" <?php echo(isset($field_settings['multiselect_type'])&&$field_settings['multiselect_type']=='checkbox'?'selected':''); ?>>Checkbox</option>
								</select>
								<span class="field-description">What type of multiselect field is this?</span>
							</div>
						</div>
						<div class="db-field-row <?php echo (isset($field_settings['select_options'])&&$field_settings['select_options']!=''?'active':'') . (isset($field_settings['field_name']) && $field_settings['field_name'] == 'amenities'?' amenities':''); ?> clearfix">
							<label class="field-label">Multiselect values</label>
							<div class="db-field-input">
								<textarea class="db-create-select-options"><?php echo(isset($field_settings['select_options'])?$field_settings['select_options']:''); ?></textarea>
								<?php if ( isset($field_settings['field_name']) && $field_settings['field_name'] == 'amenities' ) { ?>
									<span class="field-description">Provide amenities values, field name:field value:media image id, each value in a new line like so:</span>
									<span class="field-description">wheelchair:Wheelchair access<br />kids-corder:Kids corner:11</span><br />
									<span class="field-description">Read more about amenities <a href="http://documentation.cohhe.com/whitelab/knowledgebase/amenities-field/" target="_blank">here</a></span>
								<?php } else { ?>
									<span class="field-description">Provide select option values, field name:field value, each value in a new line like so:</span>
									<span class="field-description">no-wifi:No WiFi<br>wifi-included:WiFi included</span>
									<?php } ?>
							</div>
						</div>
					<?php } else if ( $field_type == 'checkbox' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['checkbox_true'])&&$field_settings['checkbox_true']!=''?'active':''); ?> clearfix">
							<label class="field-label">Checked checkbox value</label>
							<div class="db-field-input">
								<input type="text" class="db-create-checkbox-true" value="<?php echo(isset($field_settings['checkbox_true'])?$field_settings['checkbox_true']:''); ?>">
								<span class="field-description">When checkbox is shown as checked, this value will be shown.</span>
							</div>
						</div>
						<div class="db-field-row <?php echo(isset($field_settings['checkbox_false'])&&$field_settings['checkbox_false']!=''?'active':''); ?> clearfix">
							<label class="field-label">Un-checked checkbox value</label>
							<div class="db-field-input">
								<input type="text" class="db-create-checkbox-false" value="<?php echo(isset($field_settings['checkbox_false'])?$field_settings['checkbox_false']:''); ?>">
								<span class="field-description">When checkbox is shown as un-checked, this value will be shown.</span>
							</div>
						</div>
					<?php } ?>
					<input type="hidden" class="db-create-field-type" value="<?php echo $field_type; ?>">
					<?php if ( !isset($_GET['field_id']) ) { ?>
						<a href="javascript:void(0)" class="db-save-field db-button db-primary-button" data-save="insert">Create field</a>
					<?php } else {
						if ( $is_child ) {
							?><input type="hidden" class="db-create-child" value="true"><?php
						} ?>
						<a href="javascript:void(0)" class="db-save-field db-button db-primary-button" data-save="update" data-id="<?php echo esc_attr($_GET['field_id']); ?>">Save field</a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
}

function db_reg_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<?php if ( !isset($_GET['field_type']) && !isset($_GET['field_id']) ) { ?>
				<a href="javascript:void(0)" class="db-add-new-field db-button db-primary-button">Add new</a>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="width: 5%;">Order</th>
							<th style="width: 65%;">Name</th>
							<th style="width: 15%;">Type</th>
							<th style="width: 15%;">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						global $wpdb;
						$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_registration ORDER BY field_order, ID ASC');
						if ( !empty($field_list) ) {
							foreach ($field_list as $field_value) {
								$field_settings = json_decode($field_value->field_settings, true);
								$is_child = (isset($field_settings['child'])&&$field_settings['child']=='true'?'db-child-field':'');
								$disabled_settings = (isset($field_settings['disabled'])?explode(',', $field_settings['disabled']):array());

								echo '
								<tr>
									<td class="db-field-order">'.$field_settings['display_order'].'</td>
									<td class="db-field-name">'.$field_settings['frontend_title'].'</td>
									<td class="db-custom-field-type">'.$field_settings['field_type'].'</td>
									<td class="db-field-actions">';
										if ( !in_array('edit', $disabled_settings) ) {
											echo '<a href="'.DB_PLUGIN_REG_PAGE_URL.'&field_id='.$field_value->ID.'" class="db-edit-field">Edit</a>';
										}
										echo ' ';
										if ( !in_array('delete', $disabled_settings) ) {
											echo '<a href="javascript:void(0)" class="db-delete-reg-field" data-id="'.$field_value->ID.'">Delete</a>';
										}
									echo '
									</td>
								</tr>';
							}
						}
						?>
					</tbody>
				</table>
				<div class="db-custom-field-dialog main-card" style="display: none;">
					<div class="db-field-row clearfix">
						<label class="field-label">Field type</label>
						<select class="db-field-type">
							<option value="text">Text</option>
							<option value="textarea">Textarea</option>
							<option value="checkbox">Checkbox</option>
							<option value="radio">Radio</option>
							<option value="select">Select</option>
						</select>
					</div>
					<a href="javascript:void(0)" class="db-proceed-field db-button db-primary-button">Proceed</a>
				</div>
				<div class="db-dialog-overlay" style="display: none;"></div>
			<?php } else if ( isset($_GET['field_type']) || isset($_GET['field_id']) ) {
				$field_settings = array();
				$disabled_settings = array();
				$is_child = false;
				global $wpdb;

				if ( isset($_GET['field_id']) ) {
					$field_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_registration WHERE ID="'.intval($_GET['field_id']).'"');
					$field_settings = json_decode($field_data['0']->field_settings, true);
					$disabled_settings = (isset($field_settings['disabled'])?explode(',', $field_settings['disabled']):array());
					$is_child = (isset($field_settings['child'])&&$field_settings['child']=='true'?true:false);
				}
				$field_type = (isset($_GET['field_type'])?sanitize_text_field($_GET['field_type']):$field_settings['field_type']);

				if ( isset($_GET['field_type']) ) {
					$order_val = $wpdb->get_var('SELECT MAX(field_order) FROM '.$wpdb->prefix.'directory_registration');

					if ( $order_val !== null ) {
						$new_field_order = intval($order_val) + 1;
					} else {
						$new_field_order = '1';
					}
				}

				?>
				<div class="db-custom-field">
					<div class="db-box-title">
						<h3 class="db-main-title">Custom registration field</h3>
					</div>
					<?php if ( !in_array('delete', $disabled_settings) ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['field_name'])&&$field_settings['field_name']!=''?'active':''); ?> clearfix">
							<label class="field-label">Field name <span class="db-required">*</span></label>
							<div class="db-field-input">
								<input type="text" class="db-create-field-name" data-required="true" value="<?php echo(isset($field_settings['field_name'])?$field_settings['field_name']:''); ?>">
								<span class="field-description">Unique name only from letters a-z</span>
								<span class="db-field-required">This field is required</span>
							</div>
						</div>
					<?php } ?>
					<div class="db-field-row <?php echo(isset($field_settings['frontend_title'])&&$field_settings['frontend_title']!=''?'active':''); ?> clearfix">
						<label class="field-label">Frontend title <span class="db-required">*</span></label>
						<div class="db-field-input">
							<input type="text" class="db-create-frontend-title" data-required="true" value="<?php echo(isset($field_settings['frontend_title'])?$field_settings['frontend_title']:''); ?>">
							<span class="field-description">How this field is going to be shown to other users</span>
							<span class="db-field-required">This field is required</span>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Display order</label>
						<div class="db-field-input">
							<input type="number" class="db-create-display-order" value="<?php echo(isset($field_settings['display_order'])?$field_settings['display_order']:$new_field_order); ?>" <?php echo(in_array('display_order', $disabled_settings)?'disabled':''); ?>>
							<span class="field-description">The order in which it's goint to be shown to users</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Active?</label>
						<div class="db-field-input">
							<select class="db-create-field-active" <?php echo(in_array('field_active', $disabled_settings)?'disabled':''); ?>>
								<option value="yes" <?php echo(isset($field_settings['field_active'])&&$field_settings['field_active']=='yes'?'selected':''); ?>>Yes</option>
								<option value="no" <?php echo(isset($field_settings['field_active'])&&$field_settings['field_active']=='no'?'selected':''); ?>>No</option>
							</select>
							<span class="field-description">Do you want to show this field to users?</span>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Where to show this field?</label>
						<div class="db-field-input">
							<?php
							if ( isset($field_settings['field_for']) && !is_array($field_settings['field_for']) ) {
								$field_settings['field_for'] = json_decode( $field_settings['field_for'], true );
							}
							?>
							<select class="db-create-field-for" multiple>
								<option value="shortcode" <?php echo (isset($field_settings['field_for'])&&!empty($field_settings['field_for'])&&in_array('shortcode', $field_settings['field_for'])?'selected':''); ?>>At registration shortcode</option>
								<option value="modal" <?php echo (isset($field_settings['field_for'])&&!empty($field_settings['field_for'])&&in_array('modal', $field_settings['field_for'])?'selected':''); ?>>At header modal dialog</option>
								<option value="add_listing" <?php echo (isset($field_settings['field_for'])&&!empty($field_settings['field_for'])&&in_array('add_listing', $field_settings['field_for'])?'selected':''); ?>>At add listing page</option>
							</select>
						</div>
					</div>
					<div class="db-field-row focused active clearfix">
						<label class="field-label">Required?</label>
						<div class="db-field-input">
							<select class="db-create-required">
								<option value="yes" <?php echo(isset($field_settings['required'])&&$field_settings['required']=='yes'?'selected':''); ?>>Yes</option>
								<option value="no" <?php echo(isset($field_settings['required'])&&$field_settings['required']=='no'?'selected':''); ?>>No</option>
							</select>
							<span class="field-description">Is it required to fill this field in?</span>
						</div>
					</div>
					<?php if ( isset( $field_settings['disabled'] ) ) { ?>
						<input type="hidden" class="db-create-disabled" value="<?php echo $field_settings['disabled']; ?>">
					<?php } ?>
					<?php if ( in_array('delete', $disabled_settings) ) { ?>
						<input type="hidden" class="db-create-field-name" data-required="true" value="<?php echo(isset($field_settings['field_name'])?$field_settings['field_name']:''); ?>">
					<?php } ?>
					<?php if ( $field_type == 'radio' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['radio_options'])&&$field_settings['radio_options']!=''?'active':''); ?> clearfix">
							<label class="field-label">Radio button values</label>
							<div class="db-field-input">
								<input type="text" class="db-create-radio-options" value="<?php echo(isset($field_settings['radio_options'])?$field_settings['radio_options']:''); ?>">
								<span class="field-description">Provide radio button values separated with comma:</span>
								<span class="field-description">No WiFi,WiFi included,Nagotiable</span>
							</div>
						</div>
					<?php } else if ( $field_type == 'select' ) { ?>
						<div class="db-field-row <?php echo(isset($field_settings['select_options'])&&$field_settings['select_options']!=''?'active':''); ?> clearfix">
							<label class="field-label">Select values</label>
							<div class="db-field-input">
								<textarea class="db-create-select-options"><?php echo(isset($field_settings['select_options'])?$field_settings['select_options']:''); ?></textarea>
								<span class="field-description">Provide select option values, field name:field value, each value in a new line like so:</span>
								<span class="field-description">no-wifi:No WiFi<br>wifi-included:WiFi included</span>
							</div>
						</div>
					<?php } ?>
					<input type="hidden" class="db-create-field-type" value="<?php echo (isset($field_settings['field_type'])?$field_settings['field_type']:$field_type); ?>">
					<?php if ( !isset($_GET['field_id']) ) { ?>
						<a href="javascript:void(0)" class="db-save-reg-field db-button db-primary-button" data-save="insert">Create field</a>
					<?php } else {
						if ( $is_child ) {
							?><input type="hidden" class="db-create-child" value="true"><?php
						} ?>
						<a href="javascript:void(0)" class="db-save-reg-field db-button db-primary-button" data-save="update" data-id="<?php echo esc_attr($_GET['field_id']); ?>">Save field</a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
}

function db_send_notification_email( $user_id, $template, $attributes = array() ) {
	$output = '';
	$user_data = get_userdata( $user_id );
	$main_temaplates = get_option( 'db_main_templates', array() );
	$user_message = $admin_message = '';
	$blog_name = get_bloginfo('name');

	if ( $template == 'new_user_confirm' ) {
		$subject = '['.$blog_name.'] - ' . esc_html__( 'User registration confirmation', 'directory-builder' );

		$user_message = nl2br( $main_temaplates['new_user_confirm'] );
		if ( !empty($attributes) ) {
			foreach ($attributes as $att_key => $att_value) {
				if ( strpos($att_key, 'url_') === 0 ) {
					$user_message = str_replace('{'.$att_key.'}', '<a href="'.$att_value.'">'.$att_value.'</a>', $user_message);
				} else {
					$user_message = str_replace('{'.$att_key.'}', $att_value, $user_message);
				}
			}
		}
	} else if ( $template == 'new_user' ) {
		$subject = '['.$blog_name.'] - ' . esc_html__( 'User registration', 'directory-builder' );

		$user_message = nl2br( $main_temaplates['new_user'] );
		if ( !empty($attributes) ) {
			foreach ($attributes as $att_key => $att_value) {
				if ( strpos($att_key, 'url_') === 0 ) {
					$user_message = str_replace('{'.$att_key.'}', '<a href="'.$att_value.'">'.$att_value.'</a>', $user_message);
				} else {
					$user_message = str_replace('{'.$att_key.'}', $att_value, $user_message);
				}
			}
		}

		$admin_message = sprintf( __( 'A new user, %s, just confirmed email address and completed registration process!', 'directory-builder' ), '<strong>' . $attributes['username'] . '</strong>' );
	} else if ( $template == 'new_claim' ) {
		$subject = '['.$blog_name.'] - ' . esc_html__( 'Listing claimed', 'directory-builder' );

		$user_message = nl2br( $main_temaplates['new_claim'] );
		if ( !empty($attributes) ) {
			foreach ($attributes as $att_key => $att_value) {
				if ( strpos($att_key, 'url_') === 0 ) {
					$user_message = str_replace('{'.$att_key.'}', '<a href="'.$att_value.'">'.$att_value.'</a>', $user_message);
				} else {
					$user_message = str_replace('{'.$att_key.'}', $att_value, $user_message);
				}
			}
		}

		$admin_message = sprintf( __( 'The user %s just claimed a listing %s<br>Listing can be found here: %s', 'directory-builder' ), '<strong>' . $attributes['username'] . '</strong>', $attributes['listing_title'], '<a href="'.$attributes['listing'].'">'.$attributes['listing'].'</a>' );
	} else if ( $template == 'new_payment' ) {
		$subject = '['.$blog_name.'] - ' . esc_html__( 'Payment received', 'directory-builder' );

		$user_message = nl2br( $main_temaplates['new_payment'] );
		if ( !empty($attributes) ) {
			foreach ($attributes as $att_key => $att_value) {
				if ( strpos($att_key, 'url_') === 0 ) {
					$user_message = str_replace('{'.$att_key.'}', '<a href="'.$att_value.'">'.$att_value.'</a>', $user_message);
				} else {
					$user_message = str_replace('{'.$att_key.'}', $att_value, $user_message);
				}
			}
		}

		$admin_message = sprintf( __( 'A payment of %s was just received for %s', 'directory-builder' ), $attributes['price'], '<a href="'.$attributes['url_listing'].'">'.$attributes['url_listing'].'</a>' );
	} else if ( $template == 'new_listing' ) {
		$subject = '['.$blog_name.'] - ' . esc_html__( 'Listing added', 'directory-builder' );

		$user_message = nl2br( $main_temaplates['new_listing'] );
		if ( !empty($attributes) ) {
			foreach ($attributes as $att_key => $att_value) {
				if ( strpos($att_key, 'url_') === 0 ) {
					$user_message = str_replace('{'.$att_key.'}', '<a href="'.$att_value.'">'.$att_value.'</a>', $user_message);
				} else {
					$user_message = str_replace('{'.$att_key.'}', $att_value, $user_message);
				}
			}
		}

		$admin_message = sprintf( __( 'A new listing was just added by %s<br>Listing can be viewed at: %s', 'directory-builder' ), '<strong>' . $attributes['username'] . '</strong>', '<a href="'.$attributes['url_listing'].'">'.$attributes['url_listing'].'</a>' );
	}

	if ( $user_message != '' ) {
		add_filter( 'wp_mail_content_type','db_set_content_type' );
		add_filter( 'wp_mail_from_name', 'db_custom_wp_mail_from_name' );
		add_filter( 'wp_mail_from', 'db_custom_wp_mail_from' );
		$notice_user_email = wp_mail( $user_data->data->user_email, $subject, $user_message );
		remove_filter( 'wp_mail_from', 'db_custom_wp_mail_from' );
		if ( $admin_message != '' ) {
			$notice_admin_email = wp_mail( get_bloginfo('admin_email'), $subject, $admin_message );
		}
		remove_filter( 'wp_mail_content_type','db_set_content_type' );
		remove_filter( 'wp_mail_from_name', 'db_custom_wp_mail_from_name' );

		// Possible to debug is emails were sent
		// $notification_list = get_option( 'db_notification_emails', array() );
		// $notification_list[] = 'USER - email to ' . $user_data->data->user_email . ', with template: ' . $template . ', status: ' . ($notice_user_email?'success':'failed');
		// $notification_list[] = 'ADMIN - email to ' . get_bloginfo('admin_email') . ', with template: ' . $template . ', status: ' . ($notice_admin_email?'success':'failed');
		// update_option( 'db_notification_emails', $notification_list );
	}
}

function db_email_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}

	$main_templates = get_option( 'db_main_templates', array() );
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content">
			<div class="db-box-wrapper">
				<div class="db-box-left">
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">New user confirmation email template</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<div class="col-sm-12">
										<textarea class="db-template-new_user_confirm"><?php echo ( isset($main_templates['new_user_confirm']) ? $main_templates['new_user_confirm'] : '' ); ?></textarea>
										<span class="field-description">You can use the following code pieces:</span>
										<ul>
											<li><strong>{username}</strong> - Replaced with the username</li>
											<li><strong>{url_confirm}</strong> - Replaced with the user confirmation URL</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">New listing template</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<div class="col-sm-12">
										<textarea class="db-template-new_listing"><?php echo ( isset($main_templates['new_listing']) ? $main_templates['new_listing'] : '' ); ?></textarea>
										<span class="field-description">If no text is provided, then the email is not sent to user and site admin</span>
										<span class="field-description"><strong>Note that if new listing status is set to pending approval, then <em>{url_listing}</em> will return a 404 page, so do not include it in the email template!</strong></span><br />
										<span class="field-description">You can use the following code pieces:</span>
										<ul>
											<li><strong>{username}</strong> - Replaced with the username</li>
											<li><strong>{url_dashboard}</strong> - Replaced with the user dashboard URL</li>
											<li><strong>{url_listing}</strong> - Replaced with the URL of listing</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Payment email template</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<div class="col-sm-12">
										<textarea class="db-template-new_payment"><?php echo ( isset($main_templates['new_payment']) ? $main_templates['new_payment'] : '' ); ?></textarea>
										<span class="field-description">If no text is provided, then the email is not sent to user and site admin</span>
										<span class="field-description">You can use the following code pieces:</span>
										<ul>
											<li><strong>{username}</strong> - Replaced with the username</li>
											<li><strong>{price}</strong> - Replaced with the payment price</li>
											<li><strong>{listing_title}</strong> - Replaced with the title of the listing</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="db-box-right">
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">New user email template</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<div class="col-sm-12">
										<textarea class="db-template-new_user"><?php echo ( isset($main_templates['new_user']) ? $main_templates['new_user'] : '' ); ?></textarea>
										<span class="field-description">If no text is provided, then the email is not sent to user and site admin</span>
										<span class="field-description">You can use the following code pieces:</span>
										<ul>
											<li><strong>{username}</strong> - Replaced with the username</li>
											<li><strong>{url_dashboard}</strong> - Replaced with the user dashboard URL</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Listing claim template</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<div class="col-sm-12">
										<textarea class="db-template-new_claim"><?php echo ( isset($main_templates['new_claim']) ? $main_templates['new_claim'] : '' ); ?></textarea>
										<span class="field-description">If no text is provided, then the email is not sent to user and site admin</span>
										<span class="field-description">You can use the following code pieces:</span>
										<ul>
											<li><strong>{username}</strong> - Replaced with the username</li>
											<li><strong>{url_dashboard}</strong> - Replaced with the user dashboard URL</li>
											<li><strong>{listing_title}</strong> - Replaced with the title of the listing</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			// Display debug email information
			// $notification_list = get_option( 'db_notification_emails', array() );
			// echo '<div class="clearfix"></div>';
			// echo '<pre>'; var_dump($notification_list); echo '</pre>';
			?>
			<div class="db-row-group col-md-12 clearfix">
				<a href="javascript:void(0)" class="db-save-templates db-button db-primary-button">Save changes</a>
			</div>

		</div>
	</div>
	<?php
}

function db_import_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}

	$import_error = false;
	if ( isset($_FILES['db_import']) && $_FILES['db_import']['error'] == UPLOAD_ERR_OK && is_uploaded_file( $_FILES['db_import']['tmp_name'] ) ) {
		$file_extension = pathinfo($_FILES['db_import']['name'], PATHINFO_EXTENSION);
		
		if ( $file_extension != 'csv' ) {
			$import_error = esc_html__( 'Only .csv file extensions are available for importing process!', 'directory-builder' );
		} else if ( $_FILES['db_import']['size'] == 0 ) {
			$import_error = esc_html__( 'Uploaded file is empty!', 'directory-builder' );
		} else {
			$import_file = fopen( $_FILES['db_import']['tmp_name'], 'r' ) or die ( 'File opening failed' );
			$loop = 1;
			$import_log = array();
			while ( $import_data = fgetcsv( $import_file ) ) { // Loop through every csv line
				$required_fields = array( '0', '1', '2', '3' ); // Required fields to insert post

				$valid_line = true;
				$extra_listing_fields = $import_data;
				foreach ($required_fields as $req_value) { // Check if all required fields are present
					if ( !isset( $import_data[$req_value] ) || $import_data[$req_value] == '' ) {
						$valid_line = false;
					}
					unset($extra_listing_fields[$req_value]);
				}

				if ( $valid_line ) { // Add new listing 
					$new_listing_values = array(
						'post_title' => $import_data['0'],
						'post_excerpt' => $import_data['1'],
						'post_content' => $import_data['2'],
						'post_status' => $import_data['3'],
						'post_type' => 'listings'
					);
					
					$created_listing_id = wp_insert_post( $new_listing_values );
					if ( !is_wp_error( $created_listing_id ) ) {
						if ( !empty( $extra_listing_fields ) ) { // Check if there are any extra fields to add to the post meta
							$order_info = array();
							foreach ( $extra_listing_fields as $extra_value ) {
								$parsed_extra = explode('::', $extra_value);
								
								if ( isset($parsed_extra['0']) && isset($parsed_extra['1']) ) { // Check if both values are present for extra listing fields
									if ( strpos($parsed_extra['0'], 'order_') === 0 ) { // Order related information
										$order_info[str_replace('order_', '', $parsed_extra['0'])] = $parsed_extra['1'];
									} else if ( strpos($parsed_extra['0'], 'post_') === 0 ) { // Listing related information
										if ( $parsed_extra['0'] == 'post_cat' ) {
											$listing_categories = explode( '^', $parsed_extra['1'] );
											if ( !empty($listing_categories) ) {
												$new_cat_values = array();
												foreach ($listing_categories as $cat_value) {
													$new_cat_values[] = intval($cat_value);
												}
												wp_set_object_terms( $created_listing_id, $new_cat_values, 'listing_category' );
											}
										} else if ( $parsed_extra['0'] == 'post_image' ) {
											set_post_thumbnail( $created_listing_id, $parsed_extra['1'] );
										}
									} else { // Main listing data
										if ( strpos($parsed_extra['1'], '^') !== false ) {
											$parsed_extra['1'] = str_replace('^', ',', $parsed_extra['1']);
										}
										update_post_meta( $created_listing_id, $parsed_extra['0'], $parsed_extra['1'] );
									}
									
								}
							}

							if ( !empty( $order_info ) ) {
								update_post_meta( $created_listing_id, 'db_order_info', $order_info );
							}
						}

						$import_log[] = array(
							'status' => 'success',
							'id' => $created_listing_id
							);
					} else {
						$import_log[] = array(
							'status' => 'failed',
							'message' => sprintf( __( 'Failed to import line %s from import file, encountered an error: %s', 'directory-builder' ), $loop, $created_listing_id->get_error_message() )
							);
					}
				} else {
					$import_log[] = array(
							'status' => 'failed',
							'message' => sprintf( __( 'All requested fields were not set! Failed to import line %s from import file!', 'directory-builder' ), $loop )
							);
				}

				$loop++;
			}
			fclose($import_file);
		}
	}
	
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content">
			<div class="db-box-wrapper">
				<div class="db-box-container col-md-12">
					<div class="db-box main-card">
						<div class="db-box-title">
							<h3 class="db-main-title">Import new listings</h3>
						</div>
						<div class="db-row">
							<div class="db-row-group db-import-main clearfix">
								<?php
								if ( $import_error !== false ) {
									echo '<p class="db-error">' . $import_error . '</p>';
								}
								?>
								<form method="POST" enctype="multipart/form-data">
									<input type="file" name="db_import" accept=".csv">
									<input type="submit" value="<?php esc_html_e('Upload and import', 'directory-builder'); ?>">
								</form>
								<p><?php esc_html_e('Import accepts .csv files, read more about the import process at our', 'directory-builder'); ?> <a href="http://documentation.cohhe.com/whitelab/knowledgebase/import-process/" target="_blank">import documentation</a>.</p>
								<?php if ( isset($import_log) && !empty( $import_log ) ) { ?>
								<table class="table table-striped table-hover db-imported-listings">
									<thead>
										<tr>
											<th style="width: 15%;">Listing name</th>
											<th style="width: 10%;">Status</th>
											<th style="width: 75%;">Message</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach ( $import_log as $log_data ) {
											echo '
											<tr>
												<td>'.($log_data['status']=='success'?'<a href="'.get_permalink($log_data['id']).'" target="_blank">'.get_the_title($log_data['id']).'</a>':'-').'</td>
												<td>'.($log_data['status']=='success'?'<span class="db-success">'.$log_data['status'].'</span>':'<span class="db-error">'.$log_data['status'].'</span>').'</td>
												<td>'.(($log_data['status']=='success'?'<a href="'.get_admin_url().'post.php?post='.$log_data['id'].'&action=edit" target="_blank">'.__('Edit', 'directory-builder').'</a>':$log_data['message'])).'</td>
											</tr>';
										}
									?>
									</tbody>
								</table>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function db_save_field() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$field_settings = ( isset($_POST['field_settings']) ? sanitize_text_field($_POST['field_settings']) : '' );
	$save_type = ( isset($_POST['save_type']) ? sanitize_key($_POST['save_type']) : '' );
	$field_id = ( isset($_POST['field_id']) ? intval($_POST['field_id']) : '' );
	
	$field_decoded_settings = json_decode(stripslashes($field_settings), true);
	if ( isset($field_decoded_settings) ) {
		$field_order = $field_decoded_settings['display_order'];
		$field_active = $field_decoded_settings['field_active'];

		if ( $save_type == 'insert' ) {
			$save_query = $wpdb->query('INSERT INTO '.$wpdb->prefix.'directory_fields (`field_order`, `field_active`, `field_settings`) VALUES ("'.$field_order.'", "'.$field_active.'", "'.$field_settings.'")');
		} else {
			$save_query = $wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'", field_active="'.$field_active.'", field_settings="'.$field_settings.'" WHERE ID="'.$field_id.'"');
			if ( $field_decoded_settings['field_name'] == 'listing_address' ) {
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_city\"%"');
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_neighborhood\"%"');
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_zip\"%"');
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_state\"%"');
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_country\"%"');
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_address_lat\"%"');
				$wpdb->query('UPDATE '.$wpdb->prefix.'directory_fields SET field_order="'.$field_order.'" WHERE field_settings LIKE "%\"field_name\":\"listing_address_lng\"%"');
			}
		}

		if ( $save_query === false ) {
			echo '{"save_response": "failed"}';
		} else {
			echo '{"save_response": "'.$wpdb->insert_id.'", "redirect": "'.DB_PLUGIN_FIELD_PAGE_URL.'"}';
		}
	}

	die(0);
}
add_action( 'wp_ajax_db_save_field', 'db_save_field' );

function db_save_reg_field() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$field_settings = ( isset($_POST['field_settings']) ? sanitize_text_field($_POST['field_settings']) : '' );
	$save_type = ( isset($_POST['save_type']) ? sanitize_key($_POST['save_type']) : '' );
	$field_id = ( isset($_POST['field_id']) ? intval($_POST['field_id']) : '' );
	
	$field_decoded_settings = json_decode(stripslashes($field_settings), true);
	if ( isset($field_decoded_settings) ) {
		$field_order = $field_decoded_settings['display_order'];
		$field_active = $field_decoded_settings['field_active'];

		if ( $field_order == '' ) {
			$order_val = $wpdb->get_var('SELECT MAX(field_order) FROM '.$wpdb->prefix.'directory_registration');

			if ( $order_val !== null ) {
				$field_order = intval($order_val) + 1;
			} else {
				$field_order = '1';
			}

			$field_decoded_settings['display_order'] = $field_order;
			$field_settings = addslashes( json_encode( $field_decoded_settings ) );
		}

		if ( $save_type == 'insert' ) {
			$save_query = $wpdb->query('INSERT INTO '.$wpdb->prefix.'directory_registration (`field_order`, `field_active`, `field_settings`) VALUES ("'.$field_order.'", "'.$field_active.'", "'.$field_settings.'")');
		} else {
			$save_query = $wpdb->query('UPDATE '.$wpdb->prefix.'directory_registration SET field_order="'.$field_order.'", field_active="'.$field_active.'", field_settings="'.$field_settings.'" WHERE ID="'.$field_id.'"');
		}

		if ( $save_query === false ) {
			echo '{"save_response": "failed"}';
		} else {
			echo '{"save_response": "'.$wpdb->insert_id.'", "redirect": "'.DB_PLUGIN_REG_PAGE_URL.'"}';
		}
	}

	die(0);
}
add_action( 'wp_ajax_db_save_reg_field', 'db_save_reg_field' );

function db_save_package() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$package_settings = ( isset($_POST['package_settings']) ? sanitize_text_field($_POST['package_settings']) : '' );
	$save_type = ( isset($_POST['save_type']) ? sanitize_key($_POST['save_type']) : '' );
	$package_id = ( isset($_POST['package_id']) ? intval($_POST['package_id']) : '' );
	
	$package_decoded_settings = json_decode(stripslashes($package_settings), true);
	if ( isset($package_decoded_settings) ) {
		if ( $save_type == 'insert' ) {
			$save_query = $wpdb->query('INSERT INTO '.$wpdb->prefix.'directory_packages (`package_name`, `package_settings`) VALUES ("'.$package_decoded_settings['fee_label'].'", "'.$package_settings.'")');
		} else {
			$save_query = $wpdb->query('UPDATE '.$wpdb->prefix.'directory_packages SET package_name="'.$package_decoded_settings['fee_label'].'", package_settings="'.$package_settings.'" WHERE ID="'.$package_id.'"');
		}

		if ( $save_query === false ) {
			echo '{"save_response": "failed"}';
		} else {
			echo '{"save_response": "'.$wpdb->insert_id.'", "redirect": "'.DB_PLUGIN_PACKAGE_PAGE_URL.'"}';
		}
	}

	die(0);
}
add_action( 'wp_ajax_db_save_package', 'db_save_package' );

function db_delete_field() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$field_id = ( isset($_POST['field_id']) ? intval($_POST['field_id']) : '' );

	if ( $wpdb->query('DELETE FROM '.$wpdb->prefix.'directory_fields WHERE ID="'.$field_id.'"') === false ) {
		echo '{"save_response": "failed"}';
	} else {
		echo '{"save_response": "'.$wpdb->insert_id.'"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_delete_field', 'db_delete_field' );

function db_delete_reg_field() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$field_id = ( isset($_POST['field_id']) ? intval($_POST['field_id']) : '' );

	if ( $wpdb->query('DELETE FROM '.$wpdb->prefix.'directory_registration WHERE ID="'.$field_id.'"') === false ) {
		echo '{"save_response": "failed"}';
	} else {
		echo '{"save_response": "'.$wpdb->insert_id.'"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_delete_reg_field', 'db_delete_reg_field' );

add_action( 'load-post.php', 'db_metabox_setup' );
add_action( 'load-post-new.php', 'db_metabox_setup' );
function db_metabox_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'db_add_metabox' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'db_save_field_metabox', 10, 2 );
}

function db_save_field_metabox( $post_id, $post ) {
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['db_listing_field_nonce'] ) || !wp_verify_nonce( $_POST['db_listing_field_nonce'], basename( __FILE__ ) ) || $post->post_type == 'revision' )
	return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	return $post_id;

	$meta_values = array(
		'listing_gallery_img',
		'db_listing_custom_img'
	);

	global $wpdb;
	$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order DESC');
	if ( !empty($field_list) ) {
		foreach ($field_list as $field_value) {
			$field_settings = json_decode($field_value->field_settings, true);
			$meta_values[] = $field_settings['field_name'];
		}
	}

	foreach ($meta_values as $a_meta_value) {
		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value   = ( isset( $_POST[$a_meta_value] ) ? ( !is_array( $_POST[$a_meta_value] ) ? sanitize_text_field( $_POST[$a_meta_value] ) : db_sanitize_array( $_POST[$a_meta_value] ) ) : '' );
		
		/* Get the meta key. */
		$meta_key   = sanitize_key($a_meta_value);

		/* Get the meta value of the custom field key. */
		$meta_value   = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' != $new_meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}

	// Update paid category
	$sanitized_categories = array();
	$unsanitized_categories = $_POST['tax_input']['listing_category'];
	if ( is_array($unsanitized_categories) && !empty($unsanitized_categories) ) {
		foreach ($unsanitized_categories as $cat_value) {
			$sanitized_categories[] = intval($cat_value);
		}
	}
	$order_options = get_post_meta( $post_id, 'db_order_info', true );
	$order_options['category'] = implode(',', $sanitized_categories);
	update_post_meta( $post_id, 'db_order_info', $order_options );
}

function db_sanitize_array( $data ) {
	if ( !empty($data) ) {
		foreach ($data as $field_key => $field_value) {
			$data[$field_key] = sanitize_text_field( $field_value );
		}
	}

	return $data;
}

function db_add_metabox() {

	add_meta_box(
		'directory_listing_fields',                                      // Unique ID
		esc_html__( 'Advanced listing fields', 'directory-builder' ),    // Title
		'db_field_metabox_function',                                     // Callback function
		'listings',                                                      // Admin page (or post type)
		'advanced',                                                      // Context
		'high'                                                           // Priority
	);

	add_meta_box(
		'directory_listing_orders',                                      // Unique ID
		esc_html__( 'Order details', 'directory-builder' ),       // Title
		'db_order_metabox_function',                                     // Callback function
		'listings',                                                      // Admin page (or post type)
		'side',                                                          // Context
		'high'                                                           // Priority
	);

	add_meta_box(
		'directory_listing_payments',                                    // Unique ID
		esc_html__( 'Payment history', 'directory-builder' ),              // Title
		'db_payment_metabox_function',                                   // Callback function
		'listings',                                                      // Admin page (or post type)
		'side',                                                          // Context
		'high'                                                           // Priority
	);

	add_meta_box(
		'directory_listing_notes',                                    // Unique ID
		esc_html__( 'Gateway notes', 'directory-builder' ),              // Title
		'db_notes_metabox_function',                                   // Callback function
		'listings',                                                      // Admin page (or post type)
		'side',                                                          // Context
		'high'                                                           // Priority
	);

	add_meta_box(
		'directory_listing_image',                                       // Unique ID
		esc_html__( 'Open listing image', 'directory-builder' ),         // Title
		'db_listing_img_metabox_function',                               // Callback function
		'listings',                                                      // Admin page (or post type)
		'side',                                                          // Context
		'low'                                                            // Priority
	);

}

function db_field_metabox_function( $object, $box ) { ?>

	<?php
		wp_nonce_field( basename( __FILE__ ), 'db_listing_field_nonce' );
		$listing_images = esc_attr( get_post_meta( $object->ID, 'listing_gallery_img', true ) );
		$main_settings = get_option( 'db_main_settings');

		$listing_address = (get_post_meta( $object->ID, 'listing_address', true )?get_post_meta( $object->ID, 'listing_address', true ):$main_settings['default_location']);
		$listing_address_lat = (get_post_meta( $object->ID, 'listing_address_lat', true )?get_post_meta( $object->ID, 'listing_address_lat', true ):$main_settings['default_location_lat']);
		$listing_address_lng = (get_post_meta( $object->ID, 'listing_address_lng', true )?get_post_meta( $object->ID, 'listing_address_lng', true ):$main_settings['default_location_lng']);
	?>

	<style type="text/css">
		.db-field-row-label, .db-field-row-description, .db-radio-label, .db-checkbox-label { display: block; }
		.db-field-row { margin-bottom: 1em; }
		.db-field-row input:not([type="radio"]):not([type="checkbox"]):not([type="button"]), .db-field-row select, .db-field-row textarea { display: block; width: 100%; }
	</style>

	<?php
	global $wpdb;
	$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order ASC');
	if ( !empty($field_list) ) {
		foreach ($field_list as $field_value) {
			$field_settings = json_decode($field_value->field_settings, true);

			$default_value = get_post_meta( $object->ID, $field_settings['field_name'], true );

			if ( $field_settings['field_name'] == 'listing_address' && $default_value == '' ) {
				$default_value = $listing_address;
			} else if ( $field_settings['field_name'] == 'listing_address_lat' && $default_value == '' ) {
				$default_value = $listing_address_lat;
			} else if ( $field_settings['field_name'] == 'listing_address_lng' && $default_value == '' ) {
				$default_value = $listing_address_lng;
			}

			echo db_get_custom_field( $field_settings, '', $default_value );

			if ( $field_settings['field_name'] == 'listing_address_lng' ) { ?>
				<a href="javascript:void(0)" class="db-set-address button button-primary button-large">Set address</a>
				<br /><br />
				<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $main_settings['google_key']; ?>" type="text/javascript"></script>
				<script type="text/javascript">
					jQuery(window).load(function() {
						var $geocoder;
						var $map;
						var $first_marker;
						function db_start_geolocation() {
							$geocoder = new google.maps.Geocoder()
							var address = <?php echo (isset($listing_address)&&$listing_address!=''?'"'.$listing_address.'";':'"'.$default_location.'";'); ?>
							$geocoder.geocode( { "address": address}, function(results, status) {

								if (status == google.maps.GeocoderStatus.OK) {
									db_initialize(results[0].geometry.location);
									jQuery('#listing_address_lat').val(results[0].geometry.location.lat());
									jQuery('#listing_address_lng').val(results[0].geometry.location.lng());
								} 
							});
						}
						
						function db_initialize(location) {
							var mapCanvas = document.getElementById("db-listing-map");
							var myLatlng = location;
							var mapOptions = {
								center: location,
								zoom: 13,
								mapTypeId: google.maps.MapTypeId.ROADMAP,
								scrollwheel: false,
								navigationControl: false,
								mapTypeControl: false,
								scaleControl: false,
								disableDefaultUI: false
							}
							$map = new google.maps.Map(mapCanvas, mapOptions);

							$first_marker = new google.maps.Marker({
								position: myLatlng,
								map: $map,
								draggable: true
							});
							db_add_dragend_event( $first_marker );
						}

						function db_add_dragend_event( marker_obj ) {
							google.maps.event.addListener(marker_obj, 'dragend', function (event) {
								jQuery('#listing_address_lat').val(this.getPosition().lat());
								jQuery('#listing_address_lng').val(this.getPosition().lng());
								jQuery('.db-set-address').addClass('dragged').click();
							});
						}
						<?php if ( $listing_address_lat != '' && $listing_address_lng != '' ) { ?>
							db_initialize( new google.maps.LatLng(jQuery('#listing_address_lat').val(), jQuery('#listing_address_lng').val()) );
						<?php } else { ?>
							db_start_geolocation();
						<?php } ?>
						jQuery(document).on('click', '.db-set-address', function() {
							var google_json_address;
							if ( !jQuery(this).hasClass('dragged') ) {
								google_json_address = encodeURIComponent( jQuery('#listing_address').val() );
							} else {
								google_json_address = encodeURIComponent( jQuery('#listing_address_lat').val()+','+jQuery('#listing_address_lng').val() );
							}
							jQuery.get('https://maps.googleapis.com/maps/api/geocode/json?address='+google_json_address+'&key=<?php echo $main_settings['google_key']; ?>&language=en', function( data ) {
								if ( data.status == 'OK' ) {
									$first_marker.setMap(null);
									var marker = new google.maps.Marker({ position: data.results['0'].geometry.location, map: $map, draggable: true });
									$first_marker = marker;
									db_add_dragend_event( $first_marker );

									jQuery('#listing_city, #listing_zip, #listing_neighborhood, #listing_state').val('');
									jQuery.each(data.results['0'].address_components, function( index, address_comp ) {
										if( ( address_comp.types[0] == "locality" && address_comp.types[1] == "political" ) || address_comp.types[0] == "postal_town" ) {
											jQuery('#listing_city').val( address_comp.long_name );
										}

										if( address_comp.types[0] == "country" && address_comp.types[1] == "political" ) {
											if ( jQuery('[name="listing_country"] option[value="'+address_comp.long_name+'"]').length ) {
												jQuery('[name="listing_country"]').val( address_comp.long_name );
											} else {
												jQuery('[name="listing_country"]').append('<option value="'+address_comp.long_name+'">'+address_comp.long_name+'</option>').val( address_comp.long_name );
											}
										}

										if( address_comp.types[0] == "postal_code" ) {
											jQuery('#listing_zip').val( address_comp.long_name );
										}

										if ( ( address_comp.types[0] == "administrative_area_level_1" && address_comp.types[1] == "political" ) || address_comp.types[0] == "neighborhood" && address_comp.types[1] == "political" ) {
											jQuery('#listing_neighborhood').val( address_comp.long_name );
										}

										if ( address_comp.types[0] == "administrative_area_level_2" && address_comp.types[1] == "political" ) {
											jQuery('#listing_state').val( address_comp.long_name );
										}
									});

									jQuery('#listing_address').val( data.results['0'].formatted_address );

									jQuery('#listing_address_lat').val(data.results['0'].geometry.location.lat);
									jQuery('#listing_address_lng').val(data.results['0'].geometry.location.lng);

									$map.setCenter(data.results['0'].geometry.location);
									jQuery('.db-set-address').removeClass('dragged');
								} else {
									if ( data.status == 'OVER_QUERY_LIMIT' ) {
										alert('You\'re over your API query limit!');
									} else if ( data.status == 'REQUEST_DENIED' ) {
										alert('Seems like your address request was denied by Google!');
									} else {
										alert('Your address couldn\'t be found');
									}
								}
							});
						});
					});
				</script>
				<div id="db-listing-map" style="width: 100%; height: 300px;"></div>
				<br />
				<?php
			}
		}
	}
	?>

	<p>
		<label for="listing_address"><?php _e( "Listing images ", 'directory-builder' ); ?></label>
		<br />
		<div class="db-listing-uploaded-images clearfix">
			<div class="column clearfix ui-sortable db-gallery">
			<?php
				if ( $listing_images != '' ) {
					$listing_images_parsed = explode('|', $listing_images);
					foreach ($listing_images_parsed as $image_value) {
						if ( $image_value == '' ) {
							continue;
						}
						$gallery_image = wp_get_attachment_image_src($image_value);
						// echo '<div class="db-uploaded-img-row"><span class="db-uploaded-img-delete dbicon-cancel"></span><img src="'.$gallery_image['0'].'"></div>';
						echo '
						<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" data-id="'.$image_value.'">
							<div class="portlet-header ui-sortable-handle ui-widget-header ui-corner-all">
								<span class="db-uploaded-img-delete dbicon-cancel"></span>
								<img src="'.$gallery_image['0'].'">
							</div>
						</div>';
					}
				}
			?>
			</div>
		</div>
		<input type="hidden" name="listing_gallery_img" id="listing_gallery_img" value="<?php echo $listing_images; ?>" />
		<a href="javascript:void(0)" class="db-upload-listing-images button button-primary button-large">Upload images</a>
	</p>

	<?php
}

function db_order_metabox_function( $object, $box ) { ?>
	<?php
		$main_settings = get_option( 'db_main_settings', array());
		$order_data = get_post_meta( $object->ID, 'db_order_info', true );
		$listing_expiration_date = '';
		if ( $order_data != '' ) {
			$all_categories = explode(',', $order_data['category']);
			$category_names = array();
			foreach ($all_categories as $category_id) {
				if ( $category_id != 0 ) {
					$category = get_term($category_id, 'listing_category');
					$category_names[] = $category->name;
				}
			}
			
			$featured_listings = get_option('db_sticky_listings', array());
			$listing_sticky = (in_array($object->ID, $featured_listings)?'Yes':'No');

			global $wpdb;
			$package_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages ORDER BY ID ASC');
			if ( !empty($package_list) ) {
				$field_settings = json_decode($package_list['0']->package_settings, true);
			}

			if ( isset($order_data['listing_expires']) && !is_numeric($order_data['listing_expires']) && isset($order_data['completed_on']) && $field_settings['listing_run_type'] == 'days' ) {
				$order_data['listing_expires'] = date( get_option('date_format'), strtotime('+'.$field_settings['listing_run_days'].' days', $order_data['completed_on']));
			} else if ( !isset($order_data['listing_expires']) ) {
				$order_data['listing_expires'] = 'Unknown';
			}
		} else {
			$order_data = array(
					'listing_package' => __('No information', 'directory-builder'),
					'listing_package_name' => __('No information', 'directory-builder'),
					'paid_amount' => __('No information', 'directory-builder'),
					'payment_history' => array(),
					'payment_status' => __('No information', 'directory-builder'),
					'category' => __('No information', 'directory-builder'),
					'listing_expires' => __('No information', 'directory-builder'),
					'listing_sticky' => __('No information', 'directory-builder')
				);

			$category = array();
			$category['name'] = 'No information';
			$category = (object)$category;
			$package_list = array();
			$listing_sticky = __('No information', 'directory-builder');
			$category_names = array( __('No information', 'directory-builder') );
			$field_settings = array();
		}

		if ( isset($field_settings['listing_run_type']) && $field_settings['listing_run_type'] == 'forever' ) {
			$listing_expiration = '<a href="javascript:void(0)" class="db-expiration-select">'.__('Never', 'directory-builder').'</a>';
		} else if ( isset($field_settings['listing_run_type']) && $field_settings['listing_run_type'] == 'days' && $order_data['listing_expires'] != 'Unknown' ) {
			$listing_expiration = '<a href="javascript:void(0)" class="db-expiration-select">'.date( get_option('date_format'), $order_data['listing_expires']).'</a>';
			$listing_expiration_date = date( 'Y-m-d', $order_data['listing_expires']);
		} else {
			$listing_expiration = '<a href="javascript:void(0)" class="db-expiration-select">'.__('Unknown', 'directory-builder').'</a>';
		}

		$listing_billing = get_post_meta( $object->ID, 'db_billing_info', true );
	?>

	<div class="db-order-wrapper">
		<div class="db-order-row">
			<span class="db-order-label">Listing author:</span>
			<span class="db-order-value"><a href="<?php echo admin_url('user-edit.php?user_id='.$object->post_author); ?>"><?php echo get_the_author_meta('nicename', $object->post_author); ?></a></span>
		</div>
		<div class="db-order-row">
			<span class="db-order-label">Listing status:</span>
			<span class="db-order-value">
				<?php echo (isset($order_data['payment_status'])?'<a href="javascript:void(0)" class="db-status-select" data-id="">'.$order_data['payment_status'].'</a>':'<a href="javascript:void(0)" class="db-status-select" data-id="">'.__('Set status', 'directory-builder').'</a>'); ?>
				<div class="db-listing-status-container" style="display: none;">
					<select class="db-listing-status">
						<option value="Processing" <?php echo (isset($order_data['payment_status'])&&$order_data['payment_status']=='Processing'?'selected':'') ?>>Processing</option>
						<option value="Completed" <?php echo (isset($order_data['payment_status'])&&$order_data['payment_status']=='Completed'?'selected':'') ?>>Completed</option>
						<option value="Pending" <?php echo (isset($order_data['payment_status'])&&$order_data['payment_status']=='Pending'?'selected':'') ?>>Pending</option>
						<option value="Refunded" <?php echo (isset($order_data['payment_status'])&&$order_data['payment_status']=='Refunded'?'selected':'') ?>>Refunded</option>
					</select>
					<a href="javascript:void(0)" class="db-listing-status-save" data-id="<?php echo $object->ID; ?>"><?php _e('Change', 'directory-builder'); ?></a>
				</div>
			</span>
		</div>
		<div class="db-order-row">
			<span class="db-order-label">Listing package:</span>
			<span class="db-order-value"><?php echo (isset($order_data['listing_package_name'])?'<a href="javascript:void(0)" class="db-order-select" data-id="'.$order_data['listing_package'].'">'.$order_data['listing_package_name'].'</a>':'<a href="javascript:void(0)" class="db-order-select" data-id="0">'.__('Add package', 'directory-builder').'</a>'); ?>
				<div class="db-order-package-container" style="display: none;">
					<select class="db-order-package">
					<?php
						if ( !empty($package_list) ) {
							foreach ($package_list as $package_value) {
								echo '<option value="'.$package_value->ID.'"'.($order_data['listing_package_name']==$package_value->package_name?' selected':'').'>'.$package_value->package_name.'</option>';
							}
						}
					?>
					</select>
					<a href="javascript:void(0)" class="db-order-package-save" data-id="<?php echo $object->ID; ?>"><?php _e('Change', 'directory-builder'); ?></a>
				</div>
			</span>
		</div>
		<div class="db-order-row">
			<span class="db-order-label">Listing cost:</span>
			<span class="db-order-value"><?php echo (isset($order_data['paid_amount'])?$order_data['paid_amount']:''); ?></span>
		</div>
		<div class="db-order-row">
			<span class="db-order-label">Listing expiration:</span>
			<span class="db-order-value"><?php echo $listing_expiration; ?>
				<div class="db-expiration-dialog" style="display: none;">
					<input type="date" class="db-listing-expiration-date" value="<?php echo $listing_expiration_date; ?>">
					<a href="javascript:void(0)" class="db-expiration-save" data-id="<?php echo $object->ID; ?>"><?php _e('Change', 'directory-builder'); ?></a>
				</div>
			</span>

		</div>
		<div class="db-order-row">
			<span class="db-order-label">Listing featured:</span>
			<span class="db-order-value">
				<a href="javascript:void(0)" class="db-featured-listing"><?php echo $listing_sticky; ?></a>
				<div class="db-featured-dialog" style="display: none;">
					<select class="db-featured-status">
						<option value="Yes" <?php echo (in_array($object->ID, $featured_listings)?'selected':''); ?>>Yes</option>
						<option value="No" <?php echo (!in_array($object->ID, $featured_listings)?'selected':''); ?>>No</option>
					</select>
					<a href="javascript:void(0)" class="db-featured-save" data-id="<?php echo $object->ID; ?>"><?php _e('Change', 'directory-builder'); ?></a>
				</div>
			</span>
		</div>
		<div class="db-order-row">
			<span class="db-order-label">Paid category:</span>
			<span class="db-order-value"><?php echo implode(', ', $category_names); ?></span>
		</div>
	</div>
	
	<?php
}

function db_process_history_row( $payment_value, $main_settings, $listing_billing = array(), $order_data = array(), $loop_order = 0 ) {
	$payment_data = explode('===', $payment_value);

	$output = '
	<div class="clearfix"></div>
	<div class="db-order-history-row">
		<span class="db-order-value-left'.(in_array( $payment_data['2'], array( 'Completed', 'Refunded' ) )?' invoiced':'').'">
			' . date( get_option('date_format'), strtotime($payment_data['0']) );
			if ( in_array( $payment_data['2'], array( 'Completed', 'Refunded' ) ) ) {
				$output .= '<a href="' . add_query_arg( array( 'dbgetinvoice' => get_the_ID(), 'r' => $loop_order ), get_admin_url() ) . '" title="' . esc_html__( 'Payment invoice', 'directory-builder' ) . '" target="_blank">' . esc_html__( 'View invoice', 'directory-builder' ) . '</a>';
			}
		$output .= '
		</span>
		<div class="db-payment-dialog">
			<div class="db-payment-dialog-row">
				' . __('Payment:', 'directory-builder').' <strong>'.date( get_option('date_format').' '.get_option('time_format'), strtotime($payment_data['0']) ).'</strong>
			</div>
			<div class="db-payment-dialog-row">
				' . __('Status:', 'directory-builder').' <strong>'.$payment_data['2'].'</strong>
			</div>
			<div class="db-payment-dialog-row">
				' . __('Gateway:', 'directory-builder').' <strong>'.(isset($payment_data['3'])&&$payment_data['3']!=''?$payment_data['3']:'-').'</strong>
			</div>';
			if ( isset($payment_data['4']) ) {
				$output .= '
				<div class="db-payment-dialog-row">
					' . __('Refunded by:', 'directory-builder').' <strong>'.get_the_author_meta('nicename', $payment_data['4']).'</strong>
				</div>';
			}
			$output .= '
			<div class="db-payment-dialog-row">
				' . __('Item:', 'directory-builder').' <strong>'.$order_data['listing_package_name'].'</strong>
			</div>
			<div class="db-payment-dialog-row">
				' . __('Total:', 'directory-builder').' <strong>'.(is_numeric($payment_data['1'])?$main_settings['default_currency_symbol'].round($payment_data['1'], 2):$payment_data['1']).'</strong>
			</div>';
			if ( !empty($listing_billing) ) {
				$output .= '<h3>'.__('Billing information', 'directory-builder').'</h3>';
				foreach ($listing_billing as $billing_key => $billing_value) {
					switch ( $billing_key ) {
						case 'x_full_name': $billing_label = __('Full name', 'directory-builder'); break;
						case 'x_company': $billing_label = __('Company', 'directory-builder'); break;
						case 'x_phone': $billing_label = __('Phone', 'directory-builder'); break;
						case 'x_email': $billing_label = __('Email', 'directory-builder'); break;
						case 'x_country': $billing_label = __('Country', 'directory-builder'); break;
						case 'x_address': $billing_label = __('Address', 'directory-builder'); break;
						case 'x_city': $billing_label = __('City', 'directory-builder'); break;
						case 'x_state': $billing_label = __('State', 'directory-builder'); break;
						case 'x_zip': $billing_label = __('ZIP', 'directory-builder'); break;
						case 'auth-code': $billing_label = __('Card Auth Code', 'directory-builder'); break;
						case 'trans-id': $billing_label = __('Transaction ID', 'directory-builder'); break;
						case 'subscription': $billing_label = __('Subscription ID', 'directory-builder'); break;

						default: $billing_label = '';;
					}
					if ( $billing_label != '' ) {
						$output .= '
						<div class="db-payment-dialog-row">
							' . $billing_label.': <strong>'.($billing_value!=''?$billing_value:'-').'</strong>
						</div>';
					} 
				}
			}
		$output .= '
		</div>
		<span class="db-order-value-center">' . (is_numeric($payment_data['1'])?$main_settings['default_currency_symbol'].round($payment_data['1'], 2):$payment_data['1']) . '</span>
		<span class="db-order-value-right ' . strtolower($payment_data['2']) . '">' . $payment_data['2'] . '</span>
		<div class="clearfix"></div>
	</div>';

	return $output;
}

function db_manual_refund_func() {
	$listing_id = ( isset($_POST['listing_id']) ? intval( $_POST['listing_id'] ) : '' );
	$ref_amount = ( isset($_POST['ref_amount']) ? esc_attr( $_POST['ref_amount'] ) : '' );
	$ref_reason = ( isset($_POST['ref_reason']) ? esc_attr( $_POST['ref_reason'] ) : '' );
	$ref_gateway = ( isset($_POST['ref_gateway']) ? esc_attr( $_POST['ref_gateway'] ) : '' );
	$ref_symbol = ( isset($_POST['ref_symbol']) ? esc_attr( $_POST['ref_symbol'] ) : '' );

	$refunds = get_post_meta( $listing_id, 'db_refunds', true );
	$refunds[time()] = array( 'amount' => $ref_amount, 'reason' => $ref_reason );
	update_post_meta( $listing_id, 'db_refunds', $refunds );

	$order_info = get_post_meta( $listing_id, 'db_order_info', true);
	$old_history = $order_info['payment_history'];
	$new_history = date('D, d M Y H:i:s', time()).'==='.$ref_amount.'===Refunded===' . $ref_gateway.'==='.get_current_user_id();
	$old_history[] = $new_history;
	$order_info['payment_history'] = $old_history;
	update_post_meta( $listing_id, 'db_order_info', $order_info );

	$refund_ipn = sprintf( __('Payment of %s refunded! %s', 'directory-builder'), $ref_symbol.$ref_amount, ($ref_reason!=''?esc_html__('Reason', 'directory-builder').': '.$ref_reason:'') );

	db_update_ipn_notes( $listing_id, $refund_ipn );

	$main_settings = get_option( 'db_main_settings', array());
	$history_html = db_process_history_row( $new_history, $main_settings );

	echo json_encode( array( 'note' => '<div class="db-note-item" data-time="'.date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), time() ).'">' . $refund_ipn . '</div>', 'history' => $history_html ) );

	die(0);
}
add_action( 'wp_ajax_db_manual_refund', 'db_manual_refund_func' );
add_action( 'wp_ajax_nopriv_db_manual_refund', 'db_manual_refund_func' );

function db_notes_metabox_function( $object ) {
	$listing_notes = get_post_meta( $object->ID, 'db_notes', true );
	?>
	<div class="db-payment-wrapper">
		<?php
		if ( empty($listing_notes) ) {
			echo '<div class="db-note-item empty">' . esc_html__('No notes yet!', 'directory-builder') . '</div>';
		} else {
			$listing_notes = array_reverse( $listing_notes, true );
			$date_format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
			foreach ( $listing_notes as $timestamp => $note ) {
				echo '<div class="db-note-item" data-time="' . date( $date_format, $timestamp ) . '">' . $note . '</div>';
			}
		}
		?>
	</div>
	
	<?php
}

function db_payment_metabox_function( $object ) {
	$listing_order_info = get_post_meta( $object->ID, 'db_order_info', true );
	$main_settings = get_option( 'db_main_settings', array());

	?>
	<div class="db-payment-history-wrapper">
		<?php
		if ( isset($listing_order_info['payment_history']) && !empty($listing_order_info['payment_history']) ) {
			$listing_billing = get_post_meta( $object->ID, 'db_billing_info', true );

			$loop = 0;
			foreach ($listing_order_info['payment_history'] as $payment_value) {
				$payment_data = explode('===', $payment_value);

				if ( $payment_data['2'] == 'Completed' ) {
					$last_gateway = $payment_data['3'];
				}

				echo db_process_history_row( $payment_value, $main_settings, $listing_billing, $listing_order_info, $loop );

				$loop++;
			}
		} else {
			echo '<p>' . esc_html__('No payment history yet!', 'directory-builder') . '</p>';
		}
		?>
	</div>
	<?php if ( isset($last_gateway)  ) {
		$payment_gateway = explode('.', $last_gateway); ?>
		<div class="db-order-row">
			<span class="db-order-value">
				<a href="javascript:void(0)" class="button button-primary button-large db-show-refund"><?php esc_html_e('Refund', 'directory-builder'); ?></a>
				<div class="db-refund-wrapper hidden">
					<form action="post" class="db-manual-refund">
						<div class="db-refund-items">
							<div class="db-refund-item">
								<?php
									esc_html_e('Total refund', 'directory-builder');
									$refunds = get_post_meta( $object->ID, 'db_refunds', true );
									$total_refund = '0.00';
									if ( !empty( $refunds ) ) {
										$total_refund = '';
										foreach ( $refunds as $refund_data ) {
											$total_refund += $refund_data['amount'];
										}
									}
								?>: <span class="db-error">-<?php echo $main_settings['default_currency_symbol'].round($total_refund, 2); ?></span>
							</div>
							<div class="db-refund-item">
								<?php esc_html_e('Refund amount', 'directory-builder'); ?>:<br />
								<input type="number" class="db-refund-amount">
							</div>
							<div class="db-refund-item">
								<?php esc_html_e('Refund reason (optional)', 'directory-builder'); ?>:<br />
								<input type="text" class="db-refund-reason">
							</div>
						</div>

						<a href="javascript:void(0)" class="db-refund-manually button button-primary button-large" data-id="<?php echo $object->ID; ?>" data-gateway="<?php echo $last_gateway; ?>" data-symbol="<?php echo $main_settings['default_currency_symbol']; ?>" data-tooltip="<?php esc_html_e('You will have to manually refund this amount through your payment gateway after using this button.', 'directory-builder'); ?>" data-normal="<?php printf( __('Refund %s%d manually', 'directory-builder'), $main_settings['default_currency_symbol'], '0' ); ?>" data-process="<?php esc_html_e('Processing', 'directory-builder'); ?>" data-refund="<?php esc_html_e('Refunded', 'directory-builder'); ?>" disabled="disabled"></a><br />
						<a href="<?php echo (strtolower($last_gateway)=='paypal'?'https://developer.paypal.com/docs/classic/admin/refunds/#refunding-within-180-days-of-payment':'javascript:void(0)'); ?>" class="db-refund-auto <?php echo strtolower($payment_gateway['0']); ?> button button-primary button-large <?php echo (strtolower($payment_gateway['0'])=='authorize'&&(!isset($listing_billing['card'])||$listing_billing['card_expiration'])?'hidden':''); ?> <?php echo (strtolower($payment_gateway['0'])=='manual'?'hidden':''); ?>" data-normal="<?php printf( __('Refund %s%d via %s', 'directory-builder'), $main_settings['default_currency_symbol'], '0', $last_gateway ); ?>" data-process="<?php esc_html_e('Processing', 'directory-builder'); ?>" data-symbol="<?php echo $main_settings['default_currency_symbol']; ?>" data-refund="<?php esc_html_e('Refunded', 'directory-builder'); ?>" data-id="<?php echo $object->ID; ?>" <?php echo (strtolower($last_gateway)=='paypal'?'target="_blank"':''); ?> disabled="disabled"></a>
						<span class="db-refund-error db-error"></span>
					</form>
				</div>
			</span>
		</div>
	<?php }
}

function db_listing_img_metabox_function( $object, $box ) {
	$listing_custom_image = esc_attr( get_post_meta( $object->ID, 'db_listing_custom_img', true ) );
	?>
	<div class="db-custom-img-wrapper">
		<div class="db-custom-img-item empty <?php echo ($listing_custom_image==''?'active':''); ?>">
			<a href="javascript:void(0)" class="db-set-custom-image">Set custom image</a>
			<p>If custom image is not set, then the featured image is going to be used!</p>
		</div>
		<div class="db-custom-img-item set <?php echo ($listing_custom_image!=''?'active':''); ?>">
			<img src="<?php echo wp_get_attachment_url($listing_custom_image); ?>" alt="" style="max-width: 100%;">
			<a href="javascript:void(0)" class="db-remove-custom-image">Remove custom image</a>
		</div>
		<input type="hidden" name="db_listing_custom_img" id="db_listing_custom_img" value="<?php echo $listing_custom_image; ?>" />
	</div>
	
	<?php
}

function db_get_custom_field( $field_settings, $custom_class = '', $def_value = '', $field_placement = '' ) {
	if ( empty($field_settings) ) {
		return;
	}
	$output = '';

	$field_name = $field_settings['field_name'];
	$field_title = $field_settings['frontend_title'];
	$field_description = $field_settings['frontend_description'];
	$field_default = (isset($field_settings['default_value'])?$field_settings['default_value']:'');

	if ( $def_value != '' ) { 
		$field_default = $def_value;
	}

	$field_required = ($field_settings['required']=='yes'?' required':'');
	$field_required_message = $field_settings['required_message'];

	$field_only_for = '';
	if ( isset($field_settings['apply_categories']) && !empty($field_settings['apply_categories']) ) {
		$field_only_for = 'data-for="'.implode(',', $field_settings['apply_categories']).'"';
		$field_required .= ' field-hidden db-cat-for';
	}

	if ( isset($field_settings['for_admins']) && $field_settings['for_admins'] == 'yes' && !current_user_can('manage_options') ) {
		return '';
	}

	switch ( $field_settings['field_type'] ) {
		case 'text':
			$field_validation_pattern = (isset($field_settings['validation_pattern'])&&$field_settings['validation_pattern']!=''?' pattern="'.$field_settings['validation_pattern'].'"':'');
			$field_validation_pattern_message = (isset($field_settings['validation_pattern_message'])&&$field_settings['validation_pattern_message']!=''?' title="'.$field_settings['validation_pattern_message'].'"':'');

			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="text" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'" value="'.$field_default.'"'.$field_validation_pattern.$field_validation_pattern_message.' autocomplete="off">';
				if ( $field_name == 'listing_address' && !is_admin() ) {
					$output .= '<span class="db-autolocate-me"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 15 15" version="1.1"> <g id="Welcome" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="All-listings" transform="translate(-964.000000, -626.000000)" fill-rule="nonzero" fill="#9B9B9B"> <g id="Group-4-Copy" transform="translate(731.000000, 611.000000)"> <g id="target-with-circle" transform="translate(233.000000, 15.000000)"> <g id="Capa_1"> <path d="M7.48790875,4.76543726 C5.98346008,4.76543726 4.76543726,5.98346008 4.76543726,7.48790875 C4.76543726,8.99235741 5.98346008,10.2103802 7.48790875,10.2103802 C8.99235741,10.2103802 10.2103802,8.99235741 10.2103802,7.48790875 C10.2103802,5.98346008 8.99235741,4.76543726 7.48790875,4.76543726 Z M13.5730894,6.80652091 C13.2604848,3.96798479 11.0072338,1.71473384 8.16869772,1.40272814 L8.16869772,0 L6.80714829,0 L6.80714829,1.40272814 C3.96858365,1.71473384 1.71536122,3.96798479 1.40210076,6.80652091 L0,6.80652091 L0,8.1693251 L1.40272814,8.1693251 C1.71596008,11.0078612 3.96921103,13.2611122 6.80774715,13.5731179 L6.80774715,14.975846 L8.16929658,14.975846 L8.16929658,13.5731179 C11.0078327,13.2611122 13.2610837,11.0078897 13.5736882,8.1693251 L14.975789,8.1693251 L14.975789,6.80652091 C14.975846,6.80652091 13.5730894,6.80652091 13.5730894,6.80652091 Z M7.48790875,12.253346 C4.85341255,12.253346 2.72247148,10.1224049 2.72247148,7.48790875 C2.72247148,4.85341255 4.85341255,2.72247148 7.48790875,2.72247148 C10.1224049,2.72247148 12.253346,4.85341255 12.253346,7.48790875 C12.253346,10.1224049 10.1224049,12.253346 7.48790875,12.253346 Z" id="Shape"/> </g> </g> </g> </g> </g> </svg></span>';
				}
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'number':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="number" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'" value="'.$field_default.'">';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'textarea':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<textarea id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'">'.$field_default.'</textarea>';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'checkbox':
			$output .= '
			<div class="db-field-row'.$field_required.' checkbox-label" '.$field_only_for.'>';
			global $post;
				if ( has_shortcode( $post->post_content, 'directory_add_listing' ) ) {
					$is_checked = ($field_default==$field_settings['checkbox_true']||$field_default=='true'?true:false);
				} else {
					$is_checked = ($field_default=='true'?true:false);
				}
				$output .= '<input type="checkbox" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" value="true"'.($is_checked?' checked':'').'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label'.($is_checked?' active':'').'" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<div class="clearfix"></div>';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'radio':
			$radio_options = $field_settings['radio_options'];
			$radio_values = explode(',', $radio_options);

			$output .= '
			<div class="db-field-row'.$field_required.' default-label radio" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label">'.$field_title.'</label>';
				}
				if ( !empty($radio_values) ) {
					foreach ($radio_values as $radio_value) {
						$is_checked = (isset($field_default['0'])&&$field_default['0']==$radio_value?' checked':'');
						$output .= '<label class="db-radio-label"><input type="radio" name="'.$field_name.'[]" class="'.$custom_class.'" value="'.$radio_value.'"'.$is_checked.'>'.$radio_value.'</label>';
					}
				}
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'select':
			$select_options = $field_settings['select_options'];
			$select_values = explode(',', $select_options);

				if ( !defined('WHITELAB_CUSTOM_SELECT') || is_admin() ) {
					$output .= '<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
					if ( $field_title != '' ) {
						$output .= '<label class="db-field-row-label">'.$field_title.'</label>';
					}
					if ( !empty($select_values) ) {
						$output .= '<select class="'.$custom_class.'" name="'.$field_name.'">';
						if ( !in_array($field_default, $select_values) ) {
							$select_values[] = $field_default;
						}
						foreach ($select_values as $select_value) {
							$select_data = explode(':', $select_value);
							$is_selected = ($select_data['0']==$field_default?' selected':'');
							$output .= '<option value="'.$select_data['0'].'"'.$is_selected.'>'.(isset($select_data['1'])?$select_data['1']:$select_data['0']).'</option>';
						}
						$output .= '</select>';
					}
					if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
						$output .= '<div class="db-field-meta">';
							if ( $field_description != '' ) {
								$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
							}
							if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
								$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
							}
						$output .= '</div>';
					}
				} else {
					$output .= '
					<div class="db-field-row'.$field_required.' custom-select" '.$field_only_for.'>';
					if ( $field_title != '' && $field_placement == 'homepage' ) {
						$output .= '<label class="db-field-row-label">'.$field_title.'</label>';
					}

					$active_values = (isset($_GET[$field_name])?explode(',', sanitize_text_field($_GET[$field_name])):array( $field_default ));
					$active_value_shown = $active_value_hidden = '';
					if ( !empty($active_values) ) {
						$active_value_shown = implode(', ', $active_values);
						$active_value_hidden = implode(',', $active_values);
					}

					$output .= '
					<input type="text" class="dt-custom-select" placeholder="'.$field_title.'" value="'.$active_value_shown.'" readonly>
					<input type="hidden" class="'.$custom_class.'" name="'.$field_name.'" id="dt-search-search_category" value="'.$active_value_hidden.'">
					<div class="dt-custom-select-container">';
						$output .= '
						<div class="dt-custom-select-inner">
							<div class="dt-custom-select-search"><input type="text" placeholder="'.__('Search', 'directory-builder').'"></div>
							<div class="dt-custom-select-items">';
								if ( !empty($select_values) ) {
									foreach ($select_values as $select_value) {
										$select_data = explode( ':', $select_value );
										$selected_values = explode( ',', $field_default );
										$is_selected = (in_array($select_data['0'], $selected_values)?' active':'');
										$output .= '<div class="dt-custom-select-item'.$is_selected.'" data-value="'.$select_data['0'].'">'.(isset($select_data['1'])?$select_data['1']:$select_data['0']).'</div>';
									}
								}
							$output .= '
							</div>
							<div class="dt-custom-select-scrollbar-wrapper">
								<span class="dt-custom-select-scrollbar"></span>
							</div>
						</div>';
					$output .= '
					</div>';
					if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
						$output .= '<div class="db-field-meta">';
							if ( $field_description != '' ) {
								$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
							}
							if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
								$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
							}
						$output .= '</div>';
					}
				}
			$output .= '
			</div>';
			break;

		case 'multi-select':
			$select_options = $field_settings['select_options'];
			$select_values = preg_split("/\\r\\n|\\r|\\n/", $select_options);

			if ( !defined('WHITELAB_CUSTOM_SELECT') || is_admin() ) {
				$output .= '<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label">'.$field_title.'</label>';
				}
				if ( !empty($select_values) ) {
					$output .= '<select class="'.$custom_class.'" name="'.$field_name.'[]" multiple>';
					foreach ($select_values as $select_value) {
						$select_data = explode(':', $select_value);
						if ( is_array($field_default) ) {
							$selected_values = $field_default;
						} else {
							$selected_values = explode( ',', $field_default );
						}

						$is_selected = (in_array($select_data['0'], $selected_values)?' selected':'');
						$output .= '<option value="'.$select_data['0'].'"'.$is_selected.'>'.(isset($select_data['1'])?$select_data['1']:$select_data['0']).'</option>';
					}
					$output .= '</select>';
				}
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			} else {
				$output .= '
				<div class="db-field-row'.$field_required.' custom-select" '.$field_only_for.'>';
				$active_values = (isset($_GET[$field_name])?explode(',', sanitize_text_field($_GET[$field_name])):(is_array($field_default)?$field_default:explode(',', $field_default)));
				$active_value_shown = $active_value_hidden = '';
				if ( !empty($active_values) ) {
					// $active_value_shown = implode(', ', $active_values);
					$active_value_hidden = implode(',', $active_values);

					$all_select_data = explode( '||', str_replace("\n", '||', $field_settings['select_options']) );
					$all_select_options = array();
					foreach ($all_select_data as $select_value) {
						$select_value_exploded = explode(':', $select_value);
						$all_select_options[$select_value_exploded['0']] = $select_value_exploded['1'];
					}

					$active_shown_values = array();
					if ( $active_values['0'] != '' ) {
						foreach ($active_values as $active_value) {
							$active_shown_values[] = $all_select_options[$active_value];
						}
					}

					$active_value_shown = implode( ', ', $active_shown_values );
				}

				if ( $field_title != '' && $field_placement == 'homepage' ) {
					$output .= '<label class="db-field-row-label">'.$field_title.'</label>';
				}

				$output .= '
				<input type="text" class="dt-custom-select" placeholder="'.$field_title.'" value="'.$active_value_shown.'" readonly>
				<input type="hidden" class="'.$custom_class.'" name="'.$field_name.'" id="dt-search-search_category" value="'.$active_value_hidden.'">
				<div class="dt-custom-select-container">';
					$output .= '
					<div class="dt-custom-select-inner">
						<div class="dt-custom-select-search"><input type="text" placeholder="'.__('Search', 'directory-builder').'"></div>
						<div class="dt-custom-select-items">';
							if ( !empty($select_values) ) {
								foreach ($select_values as $select_value) {
									$select_data = explode( ':', $select_value );
									$selected_values = (is_array($field_default)?$field_default:explode( ',', $field_default ));
									$is_selected = (in_array($select_data['0'], $selected_values)?' active':'');
									$output .= '<div class="dt-custom-select-item'.$is_selected.'" data-value="'.$select_data['0'].'">'.(isset($select_data['1'])?$select_data['1']:$select_data['0']).'</div>';
								}
							}
						$output .= '
						</div>
						<div class="dt-custom-select-scrollbar-wrapper">
							<span class="dt-custom-select-scrollbar"></span>
						</div>
					</div>';
				$output .= '
				</div>';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			}
			$output .= '
			</div>';
			break;

		case 'file-upload':
			$allowed_types = (!empty($field_settings['allowed_types'])&&$field_settings['allowed_types']['0']!='*'?' accept="'.implode(',', $field_settings['allowed_types']).'"':'');

			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="button" id="'.$field_name.'" class="db-upload-file" value="Upload file">
				<input type="hidden" name="'.$field_name.'" class="'.$custom_class.'" value="'.$field_default.'">'.$field_default;
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'date':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="date" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'" value="'.$field_default.'">';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'time':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="time" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'" value="'.$field_default.'">';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'email':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="email" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'" value="'.$field_default.'">';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'url':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<input type="url" id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'" placeholder="'.$field_title.'" value="'.$field_default.'">';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'html':
			$output .= '
			<div class="db-field-row'.$field_required.'" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<textarea id="'.$field_name.'" name="'.$field_name.'" class="'.$custom_class.'">'.$field_default.'</textarea>';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;

		case 'hoursofoperation':
			$hop_values = explode('|', $field_default);
			$output .= '
			<div class="db-field-row db-hop-times-row'.$field_required.' clearfix" '.$field_only_for.'>';
				if ( $field_title != '' ) {
					$output .= '<label class="db-field-row-label" for="'.$field_name.'">'.$field_title.'</label>';
				}
				$output .= '<label class="db-radio-label'.(isset($hop_values['0'])&&$hop_values['0']=='always'?' active': '').'"><input type="radio" name="hop-type[]" class="'.$field_name.'_type" class="'.$custom_class.'" value="always"'.(isset($hop_values['0'])&&$hop_values['0']=='always'?' checked': '').'>'.__('Always open', 'directory-builder').'</label>';
				$output .= '<label class="db-radio-label'.(isset($hop_values['0'])&&$hop_values['0']=='custom'?' active': '').'"><input type="radio" name="hop-type[]" class="'.$field_name.'_type" class="'.$custom_class.'" value="custom"'.(isset($hop_values['0'])&&$hop_values['0']=='custom'?' checked': '').'>'.__('Open in specific hours', 'directory-builder').'</label>';
				if ( isset($hop_values['0']) && $hop_values['0'] == 'custom' ) {
					$show_button = 'style="display: inline-none;"';
				} else {
					$show_button = 'style="display: none;"';
				}
				$output .= '
				<div class="db-custom-hop-times">
					<div class="db-hop-time-container" '.(!isset($hop_values['1'])?'style="display: none;"':'').'>
						<input type="hidden" name="'.$field_name.'" value="'.$field_default.'">';
						if ( isset($hop_values['1']) && $hop_values['1'] != '' ) {
							unset($hop_values['0']);
							foreach ($hop_values as $hop_key => $hop_value) {
								if ( $hop_value != '' ) {
									$hop_data = explode('==', $hop_value);
									$hop_days = str_replace('--', ' - ', $hop_data['0']);
									$hop_times = str_replace('-', ' - ', $hop_data['1']);
									
									$output .= '
									<div class="db-hop-day-row">
										<span class="db-hop-day-names">'.$hop_days.'</span>
										<span class="db-hop-day-times">'.$hop_times.'</span>
										<span class="db-hop-remove dbicon-cancel"></span>
									</div>';
								}
							}
						}
					$output .= '	
					</div>
					<a href="javascript:void(0)" class="db-add-new-hop button button-primary button-large" '.$show_button.'>'.__('Add hours', 'directory-builder').'</a>
					<div class="db-hop-dialog main-card" style="display: none;">
						<div class="db-hop-dialog-inner">
							<div class="db-hop-left">
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="mon">'.__('Mon', 'directory-builder').'</label>
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="tue">'.__('Tue', 'directory-builder').'</label>
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="wed">'.__('Wed', 'directory-builder').'</label>
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="thu">'.__('Thu', 'directory-builder').'</label>
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="fri">'.__('Fri', 'directory-builder').'</label>
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="sat">'.__('Sat', 'directory-builder').'</label>
								<label class="db-checkbox-label"><input type="checkbox" name="custom-hop-day[]" class="'.$custom_class.'" value="sun">'.__('Sun', 'directory-builder').'</label>
							</div>
							<div class="db-hop-right">
								<div class="db-hop-row clearfix">
									'.__('From:', 'directory-builder').' <input type="text" class="db-hop-from">
								</div>
								<div class="db-hop-row clearfix">
									'.__('Till:', 'directory-builder').' <input type="text" class="db-hop-till">
								</div>
								<a href="javascript:void(0)" class="db-hop-add-time button button-primary button-large">'.__('Add', 'directory-builder').'</a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>';
				if ( $field_description != '' || ( $field_settings['required'] == 'yes' && $field_required_message != '' ) ) {
					$output .= '<div class="db-field-meta">';
						if ( $field_description != '' ) {
							$output .= '<span class="db-field-row-description">'.$field_description.'</span>';
						}
						if ( $field_settings['required'] == 'yes' && $field_required_message != '' && !is_admin() ) {
							$output .= '<span class="db-field-row-required">'.$field_required_message.'</span>';
						}
					$output .= '</div>';
				}
			$output .= '
			</div>';
			break;
		
		default:
			$output = '';
			break;
	}

	return $output;
}

function db_search_shortcode() {
	$main_settings = get_option( 'db_main_settings');
	$search_position = $main_settings['search_position'];

	if ( isset($_GET['mapontop']) ) {
		$search_position = 'bottom';
	}
	$search_fields = $main_settings['search_fields'];
	$search_layout = $main_settings['search_layout'];
	$search_layout = json_decode($search_layout, true);

	wp_enqueue_script( 'jquery-ui-slider' );
	wp_enqueue_script( 'jquery.mo' );
	wp_enqueue_script( 'jquery.isotope' );
	wp_enqueue_script( 'db-google-maps' );
	wp_enqueue_script( 'richmarkers' );
	wp_enqueue_script( 'markerclusterer' );
	wp_enqueue_script( 'infobubble' );

	$output = '
	<div class="db-main-wrapper">';
		$output .= '<div class="db-search-side-one '.$search_position.'">';
			$output .= '<div id="db-main-search-map" style="width: 100%;height: 500px;"></div>';
		$output .= '</div>';
		$output .= '
		<div class="db-search-side-two '.$search_position.'">';
		$output .= '
			<div class="db-search-controls">
				<div class="db-main-search">';
					if ( in_array('listing_name', $search_fields) && !isset($search_layout) ) {
						$output .= '<input type="text" class="db-search-listing_name" placeholder="'.__('Listing name', 'directory-builder').'" value="'.(isset($_GET['listing_name'])?sanitize_text_field($_GET['listing_name']):'').'">';
					}
					$output .= '
					<div class="clearfix"></div>';
					global $wpdb;
					$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order DESC');
					if ( !empty($field_list) ) {
						$output .= '<div class="db-search-custom-fields clearfix">';
						
						if ( !isset($search_layout) ) {
							foreach ($field_list as $field_value) {
								$field_settings = json_decode($field_value->field_settings, true);
								if ( in_array($field_settings['field_name'], $search_fields) ) {
									$field_value = (isset($_GET[$field_settings['field_name']])?sanitize_text_field($_GET[$field_settings['field_name']]):'');

									if ( $field_settings['field_name'] == 'listing_address' && $main_settings['search_radius_status'] == 'yes' ) {
										$output .= '<div class="db-address-row">';
									}

									$output .= db_get_custom_field( $field_settings, 'db-search-'.$field_settings['field_name'], $field_value );

									if ( $field_settings['field_name'] == 'listing_address' && $main_settings['search_radius_status'] == 'yes' ) {
										$output .= '
										<div class="db-field-row db-slider-field-wrapper">
											<label class="db-field-row-label" for="listing_search_radius">'.__('Search radius', 'directory-builder').' ('.($main_settings['search_radius_value']=='km'?__('Kilometers', 'directory-builder'):__('Miles', 'directory-builder')).')</label>
											<div class="db-slider-field" data-value=" '.($main_settings['search_radius_value']=='km'?__('km', 'directory-builder'):__('miles', 'directory-builder')).'">
												<span class="db-slider-left"></span>
												<input type="text" id="listing_search_radius" class="db-search-listing_search_radius" value="'.(isset($_GET['listing_search_radius'])?intval($_GET['listing_search_radius']):'100').'">
											</div>
										</div>';
										$output .= '</div>';
									}
								}
							}
						} else {
							$all_fields = array();
							foreach ($field_list as $field_value) {
								$field_settings = json_decode($field_value->field_settings, true);
								if ( in_array($field_settings['field_name'], $search_fields) ) {
									$all_fields[$field_settings['field_name']] = $field_settings;
								}
							}

							if ( !empty($search_layout) ) {
								foreach ($search_layout as $field_row) {
									$output .= '<div class="db-search-row clearfix">';
										foreach ($field_row as $field_name) {
											$field_value = (isset($_GET[$field_name])?sanitize_text_field($_GET[$field_name]):'');

											if ( $field_name == 'search_radius' && $main_settings['search_radius_status'] != 'yes' ) {
												continue;
											}

											$output .= db_get_search_field( $field_name, $field_value, $all_fields );
										}
									$output .= '</div>';
								}
							}
						}
						if ( isset($_GET['mapontop']) ) {
							$output .= '<input type="hidden" id="db-search-mapontop" value="true">';
						}
						$output .= '</div>';
					}

					$onload_click = $clickable_category = '';
					$get_variables = $_GET;
					unset($get_variables['page_id']);

					if ( !isset($_GET['search_category']) && !empty($get_variables) ) {
						$onload_click = ' onload';
					} else if ( isset($_GET['search_category']) ) {
						$clickable_category = sanitize_text_field($_GET['search_category']);
					}

					$output .= '
					<div class="clearfix"></div>
					<a href="javascript:void(0)" class="db-find-listings onload" data-page="1" data-max="'.$main_settings['per_page'].'" data-total="">'.__('Search', 'directory-builder').'</a>
				</div>';
				$custom_sorting = db_get_listing_custom_fields( '', 'on_sorting' );
				if ( !defined('WHITELAB_CUSTOM_SELECT') ) {
					$output .= __('Sort by:', 'directory-builder').'
					<select class="db-search-sort">
						<option value="name">Name</option>
						<option value="date">Date</option>
						<option value="rating">Rating</option>';
						foreach ($custom_sorting as $field_name => $field_data) {
							$output .= '<option value="'.$field_name.'">'.$field_data['title'].'</option>';
						}
					$output .= '
					</select>';
				} else {
					$output .= '
					<div class="db-search-sort-container">
						<span class="db-found-count" data-found="0" data-total-found="0"> '.__('results', 'directory-builder').'</span>
						<div class="dt-sort-row single-select">
							<input type="text" class="dt-custom-select"  placeholder="'.__('Sort', 'directory-builder').'" readonly>
							<input type="hidden" class="dt-custom-select-value" id="db-search-sort">
							<div class="dt-custom-select-container">
								<div class="dt-custom-select-inner">
									<div class="dt-custom-select-items">
										<div class="dt-custom-select-item" data-value="name">Name</div>
										<div class="dt-custom-select-item" data-value="date">Date</div>
										<div class="dt-custom-select-item" data-value="rating">Rating</div>';
										foreach ($custom_sorting as $field_name => $field_data) {
											$output .= '<div class="dt-custom-select-item" data-value="'.$field_name.'">'.$field_data['title'].'</div>';
										}
									$output .= '
									</div>
									<div class="dt-custom-select-scrollbar-wrapper">
										<span class="dt-custom-select-scrollbar"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>';
				}
				$output .= '
				<div class="clearfix"></div>
			</div>
			<a href="javascript:void(0)" class="db-show-more-fields db-invisible">'.esc_html__('Show more', 'directory-builder').'</a>
			<div class="db-main-search-listings loading" data-scroll="0"></div>
		</div>';
	$output .= '
		<div class="clearfix"></div>
	</div>';

	return $output;
}
add_shortcode('directory_listings','db_search_shortcode');

function db_get_search_field( $field_name, $field_value, $all_fields, $add_names = false ) {
	$output = '';
	$main_settings = get_option( 'db_main_settings');

	if ( $field_name == 'listing_name' ) {
		$output .= '
		<div class="db-field-row">
			<label class="db-field-row-label" for="listing_address">'.__('Listing name', 'directory-builder').'</label>
			<input type="text" class="db-search-listing_name"'.($add_names?' name="listing_name"':'').' placeholder="'.__('Listing name', 'directory-builder').'" value="'.(isset($_GET['listing_name'])?sanitize_text_field($_GET['listing_name']):'').'">
		</div>';
	} else if ( $field_name == 'search_radius' && $main_settings['search_radius_status'] == 'yes' ) {
		$output .= '
		<div class="db-field-row db-slider-field-wrapper">
			<label class="db-field-row-label" for="listing_search_radius">'.__('Search radius', 'directory-builder').' ('.($main_settings['search_radius_value']=='km'?__('Kilometers', 'directory-builder'):__('Miles', 'directory-builder')).')</label>
			<div class="db-slider-field" data-value=" '.($main_settings['search_radius_value']=='km'?__('km', 'directory-builder'):__('miles', 'directory-builder')).'">
				<span class="db-slider-left"></span>
				<input type="text" id="listing_search_radius" class="db-search-listing_search_radius"'.($add_names?' name="listing_search_radius"':'').' data-default="'.$main_settings['search_radius_distance'].'" value="'.(isset($_GET['listing_search_radius'])?intval($_GET['listing_search_radius']):$main_settings['search_radius_distance']).'">
			</div>
		</div>';
	} else if ( $field_name == 'listing_categories' ) {
		$term_settings = array(
			'taxonomy' => 'listing_category',
			'hide_empty' => $main_settings['hide_empty_categories'],
			'order' => $main_settings['category_list_sort'],
			'orderby' => $main_settings['category_list_order']
		);
		$terms = get_terms( $term_settings );

		if ( !is_wp_error($terms) ) {
			if ( !defined('WHITELAB_CUSTOM_SELECT') ) {
				$output .= '<div class="db-search-categories"><ul>';
				foreach ($terms as $category_value) {
					if ( $category_value->parent == 0 ) {
						$category_count = ($main_settings['category_post_count']===true?'<span class="db-category-count">('.$category_value->count.')</span>':'');
						$onload = (isset($clickable_category)&&$clickable_category==$category_value->term_id?'onload':'');
						$output .= '<li>
								<a href="javascript:void(0)" class="'.$onload.'" data-term-id="'.$category_value->term_id.'">'.$category_value->name.'</a>'.$category_count;
								if ( $main_settings['only_parent_categories'] === false ) {
									$term_settings['child_of'] = $category_value->term_id;
									$child_terms = get_terms( $term_settings );
									if ( !empty($child_terms) ) {
										$output .= '<ul>';
										foreach ($child_terms as $child_value) {
											$onload = ($clickable_category&&$clickable_category==$child_value->term_id?'onload':'');
											$category_count = ($main_settings['category_post_count']===true?'<span class="db-category-count">('.$child_value->count.')</span>':'');
											$output .= '<li><a href="javascript:void(0)" class="'.$onload.'" data-term-id="'.$child_value->term_id.'">'.$child_value->name.'</a>'.$category_count.'</li>';
										}
										$output .= '</ul>';
									}
								}
							$output .= '    
							</li>';
					}
					
				}
				$output .= '</ul></div>';
			} else {
				$active_categories = (isset($_GET['search_category'])?explode(',', sanitize_text_field($_GET['search_category'])):array());
				$active_placeholder = '';
				if ( empty($active_categories) ) {
					$active_placeholder = '';
				} else {
					foreach ($terms as $cat_data) {
						if ( in_array($cat_data->term_id, $active_categories) ) {
							$active_placeholder .= $cat_data->name.', ';
						}
					}
					$active_placeholder = substr($active_placeholder, 0, -2);
				}
				$output .= '
				<div class="db-field-row db-search-categories custom-select">
					<input type="text" class="dt-custom-select" placeholder="'.esc_html__( 'Category', 'directory-builder' ).'" value="'.$active_placeholder.'" readonly>
					<input type="hidden" class="dt-custom-select-value" id="db-search-search_category"'.($add_names?' name="search_category"':'').' value="'.implode(',', $active_categories).'">
					<div class="dt-custom-select-container">';
						$output .= '
						<div class="dt-custom-select-inner">
							<div class="dt-custom-select-search"><input type="text" placeholder="Search"></div>
							<div class="dt-custom-select-items">';
								$categoryHierarchy = array();
								db_sort_terms_hierarchicaly($terms, $categoryHierarchy);
								foreach ($categoryHierarchy as $category_data) {
									$output .= '
									<div class="dt-custom-select-item '.(in_array($category_data->term_id, $active_categories)?'active':'').'" data-value="'.$category_data->term_id.'">'.$category_data->name.'</div>';
									if ( !empty($category_data->children) ) {
										$output .= db_display_categories( $category_data, $active_categories );
									}
								}
							$output .= '
							</div>
							<div class="dt-custom-select-scrollbar-wrapper">
								<span class="dt-custom-select-scrollbar"></span>
							</div>
						</div>';
					$output .= '
					</div>
				</div>';
			}
		}
	} else if ( $field_name == 'listing_keyword' ) {
		$output .= '
		<div class="db-field-row">
			<label class="db-field-row-label" for="listing_keyword">'.__('Keyword', 'directory-builder').'</label>
			<input type="text" class="db-search-listing_keyword"'.($add_names?' name="listing_keyword"':'').' placeholder="'.__('Keyword', 'directory-builder').'" value="'.(isset($_GET['listing_keyword'])?sanitize_text_field($_GET['listing_keyword']):'').'">
		</div>';
	} else {
		$output .= db_get_custom_field( $all_fields[$field_name], 'db-search-'.$field_name, $field_value );
	}

	return $output;
}

function db_check_listing_status() {
	global $post;

	if ( isset($post) && get_post_type( $post->ID ) == 'listings' && get_post_status( $post->ID ) == 'publish' ) {
		$order_data = get_post_meta( $post->ID, 'db_order_info', true );

		if ( isset($order_data['listing_expires']) && is_numeric($order_data['listing_expires']) && time() > $order_data['listing_expires'] ) {
			global $wpdb;
			$package_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.intval($order_data['listing_package']).'"');
			$new_status = 'draft';
			if ( !empty($package_data) ) {
				$package_settings = json_decode( $package_data['0']->package_settings, true );
				$new_status = $package_settings['listing_status'];
			}

			wp_update_post( array( 'ID' => $post->ID, 'post_status' => $new_status ) );

			global $wp_query;
			$wp_query->set_404();
			status_header(404);
		}
	}
}
add_action( 'wp', 'db_check_listing_status', 10 );

function db_search_for_listings() {
	$output = '';
	$search_terms = ( isset($_POST['search_terms']) ? json_decode(stripslashes(sanitize_text_field($_POST['search_terms'])), true) : '' );
	$db_full_url = ( isset($_POST['db_full_url']) ? esc_url($_POST['db_full_url']) : '' );
	$db_parsed_url = parse_url( $db_full_url );
	$db_url_base = $db_parsed_url['scheme'].'://'.$db_parsed_url['host'].$db_parsed_url['path'];
	$db_page = ( isset($_POST['db_page']) ? intval( $_POST['db_page'] ) : 1 );

	if ( !isset($search_terms['listing_address']) || ( isset($search_terms['listing_address']) && $search_terms['listing_address'] == '' ) ) {
		unset($search_terms['listing_search_radius']);
	}

	if ( !isset($search_terms['amenities']) && strpos($db_full_url, 'amenities=') !== false ) { // Add amenities to the search parameters
		$url_parts = parse_url( $_POST['db_full_url'] );
		parse_str($url_parts['query'], $url_query);
		$search_terms['amenities'] = $url_query['amenities'];
	}

	if ( get_option('permalink_structure') ) {
		$db_new_url = $db_url_base.'?'.http_build_query($search_terms);
	} else {
		$url_params = explode('&', $db_parsed_url['query']);
		foreach ( $url_params as $url_value ) {
			$get_part = explode('=', $url_value);
			if ( $get_part['0'] == 'page_id' ) {
				$search_terms['page_id'] = $get_part['1'];
			}
		}

		$db_new_url = $db_url_base.'?'.http_build_query($search_terms);
		unset($search_terms['page_id']);
	}
	unset($search_terms['mapontop']);

	$all_listings = array();
	$all_markers = array();

	if ( !empty($search_terms) ) {
		global $wpdb;
		$main_settings = get_option( 'db_main_settings');
		
		$search_where = '';
		if ( isset($search_terms['listing_name']) && !isset($search_terms['search_category']) ) {
			$search_where .= ' && lower(post_title) LIKE "%'.$search_terms['listing_name'].'%"';
			unset($search_terms['listing_name']);
		}
		$search_listings = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE post_type="listings" && post_status="publish"'.$search_where);
		$search_distance = (isset($search_terms['listing_search_radius'])?$search_terms['listing_search_radius']:$main_settings['search_radius_distance']);
		unset($search_terms['listing_search_radius']);

		$map_new_center = false;
		if ( !empty($search_listings) ) {
			$field_list = db_get_active_fields();

			if ( isset($search_terms['listing_address']) && $search_terms['listing_address'] != '' ) {
				$search_address_data = db_get_coordinates( $search_terms['listing_address'] );

				$map_new_center = true;
			}

			$listings_matched = 0;
			$loops = 0;
			$end_of_loop = false;
			foreach ($search_listings as $listing_value) {
				if ( in_array($listing_value->ID, $current_listings) ) {
					continue;
				}

				$listing_order_info = get_post_meta($listing_value->ID, 'db_order_info', true);
				if ( isset($listing_order_info['listing_expires']) && is_numeric($listing_order_info['listing_expires']) && $listing_order_info['listing_expires'] < time() ) {
					wp_update_post( array( 'ID' => $listing_value->ID, 'post_status' => 'pending' ) );
					continue;
				}

				$custom_field_data = db_get_listing_custom_values($field_list, $listing_value->ID);
				$listing_value = array_merge((array)$listing_value, $custom_field_data);
				$show_listing = true;
				$listing_visible = false;

				if ( isset($search_terms['listing_address']) && $search_terms['listing_address'] != '' ) {
					if ( $search_address_data['status'] && $search_address_data['type'] == 'fields' ) {
						if ( $search_address_data['field_type'] == 'country' && strpos($listing_value['listing_country'], $search_address_data['value']) !== false ) {
							$listing_visible = true;
						} else if ( $search_address_data['field_type'] == 'locality' && strpos($listing_value['listing_city'], $search_address_data['value']) !== false ) {
							$listing_visible = true;
						} else {
							$listing_visible = false;
						}
					} else {
						$db_search_distance = db_calculateDistanceFromLatLong($listing_value['listing_address_lat'], $listing_value['listing_address_lng'], $search_address_data['lat'], $search_address_data['lng'], $main_settings['search_radius_value']);

						if ( $main_settings['search_radius_status'] != 'yes' ) {
							$search_distance = '200';
						}
						if ( intval($db_search_distance) > intval($search_distance) ) {
							$listing_visible = false;
						} else {
							$listing_visible = true;
						}
					}

					if ( $listing_visible ) {
						$dist_show_listing = true;
					} else {
						$dist_show_listing = false;
					}
				}

				if ( !empty($search_terms) ) {
					$matched_settings = 0;

					foreach ($search_terms as $search_key => $search_value) {

						if ( isset($search_terms['listing_address']) && $search_terms['listing_address'] != '' && $search_key == 'listing_address' && $dist_show_listing ) {
							$matched_settings++;
							continue;
						}

						if ( $search_key == 'search_category' ) {
							$searched_categories = explode(',', $search_terms['search_category']);
							$has_category = false;
							foreach ($searched_categories as $cat_id) {
								if ( has_term($cat_id, 'listing_category', $listing_value['ID']) ) {
									$has_category = true;
									$matched_settings++;
									break;
								} else {
									$cat_child = get_term_children($cat_id, 'listing_category');
									if ( !empty($cat_child) ) {
										foreach ($cat_child as $child_id) {
											if ( has_term($child_id, 'listing_category', $listing_value['ID']) ) {
												$has_category = true;
												$matched_settings++;
												break;
											}
										}
									}
								}
							}
							if ( !$has_category ) {
								$show_listing = false;
							}
						} else if ( $search_key == 'listing_name' ) {
							if ( strpos(strtolower($listing_value['post_title']), strtolower($search_value)) !== false ) {
								$show_listing = true;
								$matched_settings++;
							}
						} else if ( $search_key == 'listing_country' ) {
							$searched_countries = explode(',', $search_value);
							foreach ($searched_countries as $country_value) {
								if ( strtolower($country_value) == strtolower($listing_value[$search_key]) ) {
									$show_listing = true;
									$matched_settings++;
									break;
								} else {
									$show_listing = false;
								}
							}
						} else if ( $search_key == 'amenities' ) {
							$amenities_values = (is_array($listing_value[$search_key])?$listing_value[$search_key]:explode(',', $listing_value[$search_key]));
							$searched_amenities = explode( ',', $search_value );

							if ( !empty($searched_amenities) ) {
								foreach ($searched_amenities as $amenity_value) {
									if ( in_array($amenity_value, $amenities_values) ) {
										$show_listing = true;
										$matched_settings++;
										break;
									} else {
										$show_listing = false;
									}
								}
							}
						} else if ( $search_key == 'listing_keyword' ) {
							if ( strpos(strtolower( $listing_value['post_title'] ), strtolower($search_value)) !== false ) {
								$show_listing = true;
								$matched_settings++;
							} else if ( strpos(strtolower( $listing_value['post_excerpt'] ), strtolower($search_value)) !== false ) {
								$show_listing = true;
								$matched_settings++;
							} else {
								$category_found = false;
								$listing_categories = wp_get_object_terms($listing_value['ID'], 'listing_category');
								if ( !empty( $listing_categories ) ) {
									foreach ($listing_categories as $category_data) {
										if ( strpos( strtolower($category_data->name), strtolower($search_value) ) !== false ) {
											$show_listing = $category_found = true;
											$matched_settings++;
											break;
										}
										
									}
								}

								if ( !$category_found ) {
									$do_not_check = array(
										'listing_address',
										'listing_city',
										'listing_neighborhood',
										'listing_zip',
										'listing_state',
										'listing_country',
										'listing_address_lat',
										'listing_address_lng'
									);

									$searchable_keyword_fields = $custom_field_data;
									foreach ($do_not_check as $unset_value) { // Unset fields that are not searchable
										unset($searchable_keyword_fields[$unset_value]);
									}

									if ( !empty($searchable_keyword_fields) ) {
										foreach ($searchable_keyword_fields as $field_name => $field_value) { // Loop through searchable keyword fields
											if ( !is_array( $field_value ) ) {
												if ( strpos( strtolower($field_value), strtolower($search_value) ) !== false ) {
													$show_listing = true;
													$matched_settings++;
													break;
												}
											} else {
												$field_data = db_get_custom_field_data( $field_name );

												if ( isset( $field_data['select_options'] ) ) {
													$select_values = preg_split("/\\r\\n|\\r|\\n/", $field_data['select_options']);

													if ( !empty($field_value) && !empty($select_values) ) {
														foreach ($field_value as $listing_select_value) {
															foreach ($select_values as $select_value) {
																if ( strpos($select_value.':', $listing_select_value.':') === 0 && strpos( strtolower($select_value), strtolower($search_value) ) !== false ) {
																	$show_listing = true;
																	$matched_settings++;
																	break 3;
																} else {
																	$show_listing = false;
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						} else {
							if ( is_array($listing_value[$search_key]) ) {
								$multiselect_val = false;
								$searched_values = explode(',', $search_value);
								if ( !empty($searched_values) ) {
									foreach ($searched_values as $searched_value) {
										if ( in_array($searched_value, $listing_value[$search_key]) ) {
											$multiselect_val = true;
											break;
										}
									}

									if ( $multiselect_val ) {
										$matched_settings++;
									} else {
										$show_listing = false;
										break;
									}
								}
							} else {
								if ( strtolower($listing_value[$search_key]) != strtolower($search_value) ) {
									$show_listing = false;
									break;
								} else {
									$matched_settings++;
								}		
							}
						}
					}
				}

				if ( $show_listing && $matched_settings == count($search_terms) ) {
					$loops++;

					if ( $loops == count($search_listings) ) {
						$end_of_loop = true;
					}

					global $db_search_listing_data;
					$db_search_listing_data = $listing_value;

					$listings_matched++;

					if ( $listings_matched > ( ( $db_page - 1 ) * $main_settings['per_page'] ) && $listings_matched < (($main_settings['per_page']*$db_page)+1) ) {
						$all_listings[$listing_value['ID']] = db_load_template( 'search-listing-item.php', true, false, $main_settings );
						if ( function_exists('whitelab_get_image_css') ) {
							$listing_category = get_the_terms($db_search_listing_data['ID'], 'listing_category');
							$img = wp_get_attachment_image_src( get_post_thumbnail_id( $db_search_listing_data['ID'] ), 'db_single_listing' );
							$extra_css = '<style type="text/css">';
								if ( isset($img['0']) ) {
									$extra_css .= '.dt-featured-item-image.id-'.$listing_value['ID'].' { background: url('.preg_replace('#^https?://#', '//', $img['0']).') }';
								}
								$listing_category = get_the_terms($db_search_listing_data['ID'], 'listing_category');
								if ( isset($listing_category['0']) ) {
									$cat_meta = get_option( "listing_category_".$listing_category['0']->term_id);
									$tag_color = (isset($cat_meta['tag-category-color'])?$cat_meta['tag-category-color']:'#555');
									$extra_css .= '.dt-featured-listings-category.'.$listing_category['0']->slug.' { color: '.$tag_color.' }';
									$extra_css .= '.dt-featured-listings-category.'.$listing_category['0']->slug.':before { border-color: '.$tag_color.' }';
								}
							$extra_css .= '</style>';
							$all_listings[$listing_value['ID']] .= $extra_css;
						}

						$categories = wp_get_object_terms($listing_value['ID'], 'listing_category');
						$cat_meta = get_option( "listing_category_".$categories['0']->term_id);

						$custom_icon = '';
						if ( isset($cat_meta['tag-category-icon']) ) {
							$custom_icon = $cat_meta['tag-category-icon'];
						}

						$all_markers[] = array($listing_value['listing_address_lat'], $listing_value['listing_address_lng'], $custom_icon, $listing_value['ID']);
					}
				}
			}
		}
	}

	$search_data = array('listing_html' => $all_listings, 'marker_data' => $all_markers, 'new_url' => $db_new_url, 'map_changed' => false, 'total' => $listings_matched );

	if ( isset( $search_address_data['status'] ) && !$search_address_data['status'] ) {
		$search_data['gmsg'] = $search_address_data['message'];
	}

	if ( empty( $all_markers ) && $map_new_center ) {
		$search_data['map_lat'] = $search_address_data['lat'];
		$search_data['map_lng'] = $search_address_data['lng'];
		$search_data['map_changed'] = true;
	}

	echo json_encode( $search_data );

	die(0);
}
add_action( 'wp_ajax_db_search_listings', 'db_search_for_listings' );
add_action( 'wp_ajax_nopriv_db_search_listings', 'db_search_for_listings' );

function db_get_custom_sorting() {
	$custom_sorting = db_get_listing_custom_fields( '', 'on_sorting' );
	$sort_ints = array( 'number', 'date', 'time', 'phone' );
	$sorting_arr = array( 'name' => '[data-name]', 'date' => '[data-date] parseInt', 'rating' => '[data-rating] parseInt', 'featured' => '[data-featured] parseInt' );

	if ( !empty($custom_sorting) ) {
		foreach ($custom_sorting as $sorting_key => $sorting_value) {
			$sorting_arr[$sorting_key] = '[data-'.$sorting_key.']'.(in_array($sorting_value['type'], $sort_ints)?' parseInt':'');
		}
	}

	return json_encode( $sorting_arr );
}

function db_get_custom_sorting_dir() {
	$custom_sorting = db_get_listing_custom_fields( '', 'on_sorting' );
	$sort_ints = array( 'number', 'date', 'time', 'phone' );
	$sorting_dir_arr = array( 'name' => true, 'date' => false, 'rating' => false, 'featured' => true );

	if ( !empty($custom_sorting) ) {
		foreach ($custom_sorting as $sorting_key => $sorting_value) {
			$sorting_dir_arr[$sorting_key] = (in_array($sorting_value['type'], $sort_ints)?false:true);
		}
	}

	return json_encode( $sorting_dir_arr );
}

function db_get_coordinates( $address ) {
	$address = str_replace(" ", "+", $address);
	$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
	$response = wp_remote_get($url);
	$json = json_decode($response['body'],TRUE);

	if ( $json['status'] == 'OK' ) {
		if ( ( $json['results'][0]['types']['0'] == 'country' || $json['results'][0]['types']['0'] == 'locality' ) && $json['results'][0]['types']['1'] == 'political' ) {
			return array( 'status' => true, 'type' => 'fields', 'field_type' => $json['results'][0]['types']['0'], 'value' => $json['results'][0]['address_components']['0']['long_name'], 'lat' => $json['results'][0]['geometry']['location']['lat'], 'lng' => $json['results'][0]['geometry']['location']['lng'] );
		} else {
			return array( 'status' => true, 'type' => 'coordinates', 'lat' => $json['results'][0]['geometry']['location']['lat'], 'lng' => $json['results'][0]['geometry']['location']['lng'] );
		}
	} else {
		if ( $json['status'] == 'OVER_QUERY_LIMIT' ) {
			$message = esc_html__('You\'re over your API query limit!', 'directory-builder');
		} else if ( $json['status'] == 'REQUEST_DENIED' ) {
			$message = esc_html__('Seems like your address request was denied by Google!', 'directory-builder');
		} else {
			$message = esc_html__('Something went wrong while contacting Google!', 'directory-builder');
		}
		return array( 'status' => false, 'message' => $message );
	}
}

function db_calculate_distance($lat1, $lon1, $lat2, $lon2, $unit) {
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;

	if ($unit == 'km') {
		return ($miles * 1.609344);
	} else if ($unit == 'N') {
		return ($miles * 0.8684);
	} else {
		return $miles;
	}
}

function db_getDistanceRadius( $uom = 'km' ) {
	//	Use Haversine formula to calculate the great circle distance between two points identified by longitude and latitude
	switch ( strtolower( $uom ) ):
		case 'km':
			$earthMeanRadius = 6371.009; // km
			break;
		case 'm':
		case 'meters':
			$earthMeanRadius = 6371.009 * 1000; // km
			break;
		case 'miles':
			$earthMeanRadius = 3958.761; // miles
			break;
		case 'yards':
		case 'yds':
			$earthMeanRadius = 3958.761 * 1760; // yards
			break;
		case 'feet':
		case 'ft':
			$earthMeanRadius = 3958.761 * 1760 * 3; // feet
			break;
		case 'nm':
			$earthMeanRadius = 3440.069; //  miles
			break;
		default:
			$earthMeanRadius = 3958.761; // miles
			break;
	endswitch;

	return $earthMeanRadius;
}

function db_calculateDistanceFromLatLong( $loc1_lat, $loc1_lng, $loc2_lat, $loc2_lng, $uom = 'km' ) {
	//	Use Haversine formula to calculate the great circle distance between two points identified by longitude and latitude

	$earthMeanRadius = db_getDistanceRadius( $uom );

	$deltaLatitude  = deg2rad( (float) $loc2_lat - (float) $loc1_lat );
	$deltaLongitude = deg2rad( (float) $loc2_lng - (float) $loc1_lng );
	$a              = sin( $deltaLatitude / 2 ) * sin( $deltaLatitude / 2 ) +
					  cos( deg2rad( (float) $loc1_lat ) ) * cos( deg2rad( (float) $loc2_lat ) ) *
					  sin( $deltaLongitude / 2 ) * sin( $deltaLongitude / 2 );
	$c              = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ) );
	$distance       = $earthMeanRadius * $c;

	return $distance;

}

function db_get_active_fields() {
	$meta_values = array(
		'listing_address',
		'listing_address_lat',
		'listing_address_lng'
	);

	global $wpdb;
	$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order DESC');
	if ( !empty($field_list) ) {
		foreach ($field_list as $field_value) {
			$field_settings = json_decode($field_value->field_settings, true);
			$meta_values[] = $field_settings['field_name'];
		}
	}

	return $meta_values;
}

function db_get_listing_custom_values( $field_list, $post_id ) {
	$field_data = array();
	if ( !empty($field_list) ) {
		foreach ($field_list as $field_name) {
			$custom_field_value = get_post_meta( $post_id, $field_name, true );
			$field_data[$field_name] = ( !is_array( $custom_field_value ) ? sanitize_text_field( $custom_field_value ) : db_sanitize_array( $custom_field_value ) );
			if ( $field_name == 'listing_address' && $field_data[$field_name] == '' ) {
				$field_data[$field_name] = 'London';
			}
			if ( $field_name == 'listing_address_lat' && $field_data[$field_name] == '' ) {
				$field_data[$field_name] = '51.5073509';
			}
			if ( $field_name == 'listing_address_lng' && $field_data[$field_name] == '' ) {
				$field_data[$field_name] = '-0.12775829999998223';
			}
		}
	}
	
	return $field_data;
}

function db_get_custom_field_data( $field_name ) {
	global $wpdb;

	$actual_field = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" && field_settings LIKE "%\"field_name\":\"'.$field_name.'\"%"');
	if ( !empty($actual_field) ) {
		return json_decode( $actual_field['0']->field_settings, true );;
	} else {
		return false;
	}
}

function db_get_active_details_fields() {
	$meta_values = array();

	global $wpdb;
	$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order DESC');
	if ( !empty($field_list) ) {
		foreach ($field_list as $field_value) {
			$field_settings = json_decode($field_value->field_settings, true);

			if ( $field_settings['on_listing'] == 'yes' ) {
				$meta_values[$field_settings['field_name']] = $field_settings['frontend_title'];
			}
		}
	}

	return $meta_values;
}

function db_settings_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	$main_settings = get_option( 'db_main_settings');
	?>

	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content">
			<div class="db-box-wrapper">
				<div class="db-box-left">
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">General settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Per page limit at search</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-per_page" placeholder="Per page limit at search" value="<?php echo $main_settings['per_page']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Include listing contact form on listing page?</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['contact_form_status']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-contact_form_status" <?php echo ($main_settings['contact_form_status']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Contact form only for registered users?</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['contact_form_registered']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-contact_form_registered" <?php echo ($main_settings['contact_form_registered']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Maximum contact form submissions per day</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-contact_form_max" placeholder="0" value="<?php echo $main_settings['contact_form_max']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Include ratings for listings?</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['listing_ratings']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-listing_ratings" <?php echo ($main_settings['listing_ratings']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">New listing status</span>
									<div class="col-sm-9">
										<select class="db-settings-new_post_status">
											<option value="pending" <?php echo ($main_settings['new_post_status']=='pending'?'selected':''); ?>>Listing is pending approval</option>
											<option value="publish" <?php echo ($main_settings['new_post_status']=='publish'?'selected':''); ?>>Listing is published</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Listing status after plugin uninstall</span>
									<div class="col-sm-9">
										<select class="db-settings-after_uninstall">
											<option value="nothing" <?php echo ($main_settings['after_uninstall']=='nothing'?'selected':''); ?>>Do not change</option>
											<option value="draft" <?php echo ($main_settings['after_uninstall']=='draft'?'selected':''); ?>>Draft</option>
											<option value="trash" <?php echo ($main_settings['after_uninstall']=='trash'?'selected':''); ?>>Trash</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Listing no image</span>
									<div class="col-sm-9">
										<input type="button" value="Upload image" class="db-image-upload">
										<input type="button" class="db-image-delete" value="Delete image" <?php echo ($main_settings['default_listing_image']==''?'style="display: none;"':''); ?>>
										<div class="db-image-container">
											<?php echo ($main_settings['default_listing_image']!=''?'<img src="'.$main_settings['default_listing_image'].'" alt="">':''); ?>
										</div>
										<input type="hidden" class="db-settings-default_listing_image" value="<?php echo $main_settings['default_listing_image']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Register on "Add listing" page</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['add_listing_register']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-add_listing_register" <?php echo ($main_settings['add_listing_register']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<?php $all_pages = get_pages(); ?>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Login page</span>
									<div class="col-sm-9">
										<select class="db-settings-login_page_id">
										<?php
											foreach ($all_pages as $page_key => $page_value) {
												$is_selected = ($main_settings['login_page_id']==$page_value->ID?' selected':'');
												echo '<option value="'.$page_value->ID.'"'.$is_selected.'>'.$page_value->post_title.'</option>';
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Listing search page</span>
									<div class="col-sm-9">
										<select class="db-settings-search_page_id">
										<?php
											foreach ($all_pages as $page_key => $page_value) {
												$is_selected = ($main_settings['search_page_id']==$page_value->ID?' selected':'');
												echo '<option value="'.$page_value->ID.'"'.$is_selected.'>'.$page_value->post_title.'</option>';
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Add listing page</span>
									<div class="col-sm-9">
										<select class="db-settings-add_page_id">
										<?php
											foreach ($all_pages as $page_key => $page_value) {
												$is_selected = ($main_settings['add_page_id']==$page_value->ID?' selected':'');
												echo '<option value="'.$page_value->ID.'"'.$is_selected.'>'.$page_value->post_title.'</option>';
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Listing author account page</span>
									<div class="col-sm-9">
										<select class="db-settings-account_page_id">
										<?php
											foreach ($all_pages as $page_key => $page_value) {
												$is_selected = ($main_settings['account_page_id']==$page_value->ID?' selected':'');
												echo '<option value="'.$page_value->ID.'"'.$is_selected.'>'.$page_value->post_title.'</option>';
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Default location</span>
									<div class="col-sm-9">
										<input type="text" class="db-settings-default_location" value="<?php echo $main_settings['default_location']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Google API key</span>
									<div class="col-sm-9">
										<input type="text" class="db-settings-google_key" value="<?php echo $main_settings['google_key']; ?>">
										<span>This key is needed for the google maps, without it google maps can't work.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Permalink settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Directory listing slug</span>
									<div class="col-sm-9">
										<input type="text" class="db-settings-directory_slug" placeholder="Directory listing slug" value="<?php echo $main_settings['directory_slug']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Directory category slug</span>
									<div class="col-sm-9">
										<input type="text" class="db-settings-category_slug" placeholder="Directory category slug" value="<?php echo $main_settings['category_slug']; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Image settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Allow images?</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['allow_images']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-allow_images" <?php echo ($main_settings['allow_images']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Min image file size (KB)</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-image_min_size" placeholder="0" value="<?php echo $main_settings['image_min_size']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Max image file size (KB)</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-image_max_size" placeholder="0" value="<?php echo $main_settings['image_max_size']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Min image width (px)</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-image_min_width" placeholder="0" value="<?php echo $main_settings['image_min_width']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Max image width (px)</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-image_max_width" placeholder="0" value="<?php echo $main_settings['image_max_width']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Min image height (px)</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-image_min_height" placeholder="0" value="<?php echo $main_settings['image_min_height']; ?>">
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Max image height (px)</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-image_max_height" placeholder="0" value="<?php echo $main_settings['image_max_height']; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">User settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Users are allowed to</span>
									<div class="col-sm-9">
										<select class="db-settings-users_are_allowed" multiple>
											<option value="edit" <?php echo (in_array('edit', $main_settings['users_are_allowed'])?'selected':''); ?>>Edit listings</option>
											<option value="delete" <?php echo (in_array('delete', $main_settings['users_are_allowed'])?'selected':''); ?>>Delete listings</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Claim settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Claim amount</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-claim_amount" placeholder="0" value="<?php echo $main_settings['claim_amount']; ?>">
										<span>Number of listing one user can claim</span>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Claims require purchase</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['claims_require_purchase']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-claims_require_purchase" <?php echo ($main_settings['claims_require_purchase']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Claim processing</span>
									<div class="col-sm-9">
										<select class="db-settings-claims_processing">
											<option value="auto" <?php echo ($main_settings['claims_processing']=='auto'?'selected':''); ?>>Automatically accept claim requests</option>
											<option value="manual" <?php echo ($main_settings['claims_processing']=='manual'?'selected':''); ?>>Manually accept claim requests</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Invoice PDF settings</h3>
							</div>
							<div class="db-row-group invoice-logo clearfix">
								<span class="db-row-label col-sm-3">Invoice logo</span>
								<div class="col-sm-9">
									<input type="button" value="Upload image" class="db-image-upload">
									<input type="button" class="db-image-delete" value="Delete image" <?php echo ($main_settings['invoice_logo']==''?'style="display: none;"':''); ?>>
									<div class="db-image-container">
										<?php echo ($main_settings['invoice_logo']!=''?'<img src="'.$main_settings['invoice_logo'].'" alt="">':''); ?>
									</div>
									<input type="hidden" class="db-settings-invoice_logo" value="<?php echo $main_settings['invoice_logo']; ?>">
								</div>
							</div>
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Invoice business details</span>
								<div class="col-sm-9">
									<textarea class="db-settings-invoice_business"><?php echo $main_settings['invoice_business']; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="db-box-right">
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Terms and conditions</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Display terms and conditions</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['terms_and_conditions_status']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-terms_and_conditions_status" <?php echo ($main_settings['terms_and_conditions_status']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Terms and conditions</span>
									<div class="col-sm-9">
										<textarea class="db-settings-terms_and_conditions"><?php echo $main_settings['terms_and_conditions']; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Search settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Search form display</span>
									<div class="col-sm-9">
										<select class="db-settings-search_position">
											<option value="left" <?php echo ($main_settings['search_position']=='left'?'selected':''); ?>>Left side</option>
											<option value="right" <?php echo ($main_settings['search_position']=='right'?'selected':''); ?>>Right side</option>
											<option value="bottom" <?php echo ($main_settings['search_position']=='bottom'?'selected':''); ?>>Below map</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Include fields in search</span>
									<div class="col-sm-9">
										<select class="db-settings-search_fields" multiple>
											<option value="listing_name" <?php echo (in_array('listing_name', $main_settings['search_fields'])?'selected':''); ?>>Listing name</option>
											<option value="search_radius" <?php echo (in_array('search_radius', $main_settings['search_fields'])?'selected':''); ?>>Search radius</option>
											<option value="listing_categories" <?php echo (in_array('listing_categories', $main_settings['search_fields'])?'selected':''); ?>>Listing categories</option>
											<option value="listing_keyword" <?php echo (in_array('listing_keyword', $main_settings['search_fields'])?'selected':''); ?>>Keyword</option>
											<?php
												global $wpdb;
												$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order DESC');
												$field_data_list = array(
													'listing_name' => 'Listing name',
													'search_radius' => 'Search radius',
													'listing_categories' => 'Listing categories',
													'listing_keyword' => 'Keyword'
												);
												if ( !empty($field_list) ) {
													foreach ($field_list as $field_value) {
														$field_settings = json_decode($field_value->field_settings, true);
														if ( $field_settings['field_type'] != 'fileupload' && $field_settings['field_type'] != 'html' && $field_settings['field_type'] != 'checkbox' && $field_settings['field_type'] != 'radio' && $field_settings['field_type'] != 'hoursofoperation' ) {
															$is_selected = (in_array($field_settings['field_name'], $main_settings['search_fields'])?'selected':'');
															echo '<option value="'.$field_settings['field_name'].'" '.$is_selected.'>'.$field_settings['frontend_title'].'</option>';
															$field_data_list[$field_settings['field_name']] = $field_settings['frontend_title'];
														}
													}
												}
											?>
										</select>
										<a href="javascript:void(0)" class="db-change-layout db-button db-primary-button" data-source="searchpage">Change field layout</a>
									</div>
								</div>
								<div class="db-search-field-layout-dialog searchpage" style="display: none;">
									<a href="javascript:void(0);" class="db-add-new-column db-button db-primary-button">Add row</a>
									<a href="javascript:void(0);" class="db-confirm-layout db-button db-primary-button" data-source="searchpage">Confirm layout</a>
									<input type="hidden" class="db-settings-search_layout" value='<?php echo $main_settings['search_layout']; ?>'>
									<?php
									$search_layout = json_decode($main_settings['search_layout'], true);
									if ( isset($search_layout) && !empty($search_layout) ) {
										foreach ($search_layout as $row_value) {
											echo '<div class="column clearfix">';
											foreach ($row_value as $row_item) {
												echo '<div class="portlet" data-id="'.$row_item.'"><div class="portlet-header">'.$field_data_list[$row_item].'</div></div>';
											}
											echo '</div>';
										}
									} else { ?>
										<div class="column clearfix"></div>
									<?php } ?>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Limit search radius</span>
									<div class="col-sm-9">
										<select class="db-settings-search_radius_status">
											<option value="no" <?php echo ($main_settings['search_radius_status']=='no'?'selected':''); ?>>No</option>
											<option value="yes" <?php echo ($main_settings['search_radius_status']=='yes'?'selected':''); ?>>Yes</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row db-search-radius-options">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Search radius measurement</span>
									<div class="col-sm-9">
										<select class="db-settings-search_radius_value">
											<option value="km" <?php echo ($main_settings['search_radius_value']=='km'?'selected':''); ?>>Kilometers</option>
											<option value="mil" <?php echo ($main_settings['search_radius_value']=='mil'?'selected':''); ?>>Miles</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row db-search-radius-options">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Search radius distance</span>
									<div class="col-sm-9">
										<input type="number" class="db-settings-search_radius_distance" value="<?php echo $main_settings['search_radius_distance']; ?>">
										<span>If search has "Listing address" field added, then while searching by address only listing in a given radius around the search address will be returned.</span>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Homepage search fields</span>
									<div class="col-sm-9">
										<select class="db-settings-homepage_search_fields" multiple>
											<option value="listing_name" <?php echo (in_array('listing_name', $main_settings['homepage_search_fields'])?'selected':''); ?>>Listing name</option>
											<option value="listing_categories" <?php echo (in_array('listing_categories', $main_settings['homepage_search_fields'])?'selected':''); ?>>Listing categories</option>
											<option value="listing_keyword" <?php echo (in_array('listing_keyword', $main_settings['homepage_search_fields'])?'selected':''); ?>>Keyword</option>
											<?php
												if ( !empty($field_list) ) {
													foreach ($field_list as $field_value) {
														$field_settings = json_decode($field_value->field_settings, true);
														if ( $field_settings['field_type'] != 'fileupload' && $field_settings['field_type'] != 'html' && $field_settings['field_type'] != 'checkbox' && $field_settings['field_type'] != 'radio' && $field_settings['field_type'] != 'hoursofoperation' ) {
															$is_selected = (in_array($field_settings['field_name'], $main_settings['homepage_search_fields'])?'selected':'');
															echo '<option value="'.$field_settings['field_name'].'" '.$is_selected.'>'.$field_settings['frontend_title'].'</option>';
															$field_data_list[$field_settings['field_name']] = $field_settings['frontend_title'];
														}
													}
												}
											?>
										</select>
										<a href="javascript:void(0)" class="db-change-layout db-button db-primary-button" data-source="homepage">Change field layout</a>
									</div>
								</div>
								<div class="db-search-field-layout-dialog homepage" style="display: none;">
									<a href="javascript:void(0);" class="db-confirm-layout db-button db-primary-button" data-source="homepage">Confirm layout</a>
									<input type="hidden" class="db-settings-homepage_search_layout" value='<?php echo $main_settings['homepage_search_layout']; ?>'>
									<?php
									$homepage_search_layout = json_decode($main_settings['homepage_search_layout'], true);
									if ( isset($homepage_search_layout) && !empty($homepage_search_layout) ) {
										foreach ($homepage_search_layout as $row_value) {
											echo '<div class="column clearfix">';
											foreach ($row_value as $row_item) {
												echo '<div class="portlet" data-id="'.$row_item.'"><div class="portlet-header">'.$field_data_list[$row_item].'</div></div>';
											}
											echo '</div>';
										}
									} else { ?>
										<div class="column clearfix"></div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
						<div class="db-box main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">Listing/category settings</h3>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Order category list by</span>
									<div class="col-sm-9">
										<select class="db-settings-category_list_order">
											<option value="name" <?php echo ($main_settings['category_list_order']=='name'?'selected':''); ?>>Name</option>
											<option value="slug" <?php echo ($main_settings['category_list_order']=='slug'?'selected':''); ?>>Slug</option>
											<option value="count" <?php echo ($main_settings['category_list_order']=='count'?'selected':''); ?>>Count of listings</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Sort category list</span>
									<div class="col-sm-9">
										<select class="db-settings-category_list_sort">
											<option value="asc" <?php echo ($main_settings['category_list_sort']=='asc'?'selected':''); ?>>Ascending</option>
											<option value="desc" <?php echo ($main_settings['category_list_sort']=='desc'?'selected':''); ?>>Descending</option>
										</select>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Show category post count?</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['category_post_count']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-category_post_count" <?php echo ($main_settings['category_post_count']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Hide empty categories</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['hide_empty_categories']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-hide_empty_categories" <?php echo ($main_settings['hide_empty_categories']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
							<div class="db-row">
								<div class="db-row-group clearfix">
									<span class="db-row-label col-sm-3">Show only parent categories in category list?</span>
									<div class="col-sm-9">
										<div class="db-checkbox <?php echo ($main_settings['only_parent_categories']=='true'?'active':''); ?>">
											<input type="checkbox" class="db-settings-only_parent_categories" <?php echo ($main_settings['only_parent_categories']=='true'?'checked':''); ?>>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="db-box-container col-md-12">
					<div class="db-box main-card">
						<div class="db-box-title">
							<h3 class="db-main-title">Listing packages</h3>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Paypal currency</span>
								<div class="col-sm-9">
									<select class="db-settings-default_currency">
										<?php
											$currencies = array(
												'AUD' => 'Australian Dollar',
												'BRL' => 'Brazilian Real',
												'CAD' => 'Canadian Dollar',
												'CZK' => 'Czech Koruna',
												'DKK' => 'Danish Krone',
												'EUR' => 'Euro',
												'HKD' => 'Hong Kong Dollar',
												'HUF' => 'Hungarian Forint',
												'ILS' => 'Israeli New Sheqel',
												'JPY' => 'Japanese Yen',
												'MYR' => 'Malaysian Ringgit',
												'MXN' => 'Mexican Peso',
												'NOK' => 'Norwegian Krone',
												'NZD' => 'New Zealand Dollar',
												'PHP' => 'Philippine Peso',
												'PLN' => 'Polish Zloty',
												'GBP' => 'Pound Sterling',
												'RUB' => 'Russian Ruble',
												'SGD' => 'Singapore Dollar',
												'SEK' => 'Swedish Krona',
												'CHF' => 'Swiss Franc',
												'TWD' => 'Taiwan New Dollar',
												'THB' => 'Thai Baht',
												'USD' => 'U.S. Dollar',
												);

											foreach ($currencies as $currency_key => $currency_value) {
												$is_selected = ($main_settings['default_currency']==$currency_key?' selected':'');
												echo '<option value="'.$currency_key.'"'.$is_selected.'>'.$currency_value.'</option>';
											}
										?>
									</select>
									<span class="db-field-required">This field is required</span>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Currency symbol <span class="db-required">*</span></span>
								<div class="col-sm-9">
									<input type="text" class="db-settings-default_currency_symbol" placeholder="Default currency symbol" data-required="true" value="<?php echo $main_settings['default_currency_symbol']; ?>">
									<span class="db-field-required">This field is required</span>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Payment method</span>
								<div class="col-sm-9">
									<select class="db-settings-payment_method" multiple>
										<option value="paypal" <?php echo (in_array('paypal', $main_settings['payment_method'])?'selected':''); ?>>Paypal</option>
										<option value="authorize.net" <?php echo (in_array('authorize.net', $main_settings['payment_method'])?'selected':''); ?>>Authorize.Net</option>
									</select>
									<span class="auth-msg db-error hidden">Currency for Authorize.net payment gateway should be specified at account settings.</span>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Active?</span>
								<div class="col-sm-9">
									<select class="db-settings-payment_active">
										<option value="yes" <?php echo ($main_settings['payment_active']=='yes'?'selected':''); ?>>Yes</option>
										<option value="no" <?php echo ($main_settings['payment_active']=='no'?'selected':''); ?>>No</option>
									</select>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Mode</span>
								<div class="col-sm-9">
									<select class="db-settings-payment_mode">
										<option value="live" <?php echo ($main_settings['payment_mode']=='live'?'selected':''); ?>>Live</option>
										<option value="sandbox" <?php echo ($main_settings['payment_mode']=='sandbox'?'selected':''); ?>>Test mode (sandbox)</option>
									</select>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Merchant ID <span class="db-required">*</span></span>
								<div class="col-sm-9">
									<input type="text" class="db-settings-paypal_merchant_id" placeholder="Merchant ID" data-required="true" value="<?php echo $main_settings['paypal_merchant_id']; ?>">
									<span>Your PayPal email where the money is sent to.</p>
									<span class="db-field-required">This field is required</span>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Cancel URL</span>
								<div class="col-sm-9">
									<input type="text" class="db-settings-paypal_cancel_url" placeholder="Cancel URL" value="<?php echo $main_settings['paypal_cancel_url']; ?>">
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Return URL</span>
								<div class="col-sm-9">
									<input type="text" class="db-settings-paypal_return_url" placeholder="Return URL" value="<?php echo $main_settings['paypal_return_url']; ?>">
									<span>Also known as thank you page.</p>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Order success page</span>
								<div class="col-sm-9">
									<select class="db-settings-order_success_url">
										<?php
											$all_pages = get_pages();
											if ( !empty($all_pages) ) {
												foreach ($all_pages as $page_data) {
													echo '<option value="' . $page_data->ID . '"'.(isset($main_settings['order_success_url'])&&$main_settings['order_success_url']==$page_data->ID?' selected':'').'>' . $page_data->post_title . '</option>';
												}
											}
										?>
									</select>
									<span>This page will be used for free listings, otherwise "Return URL" option will be used!</p>
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Authorize.net login ID</span>
								<div class="col-sm-9">
									<input type="text" class="db-settings-authorize_id" placeholder="Authorize.net login ID" value="<?php echo $main_settings['authorize_id']; ?>">
								</div>
							</div>
						</div>
						<div class="db-row">
							<div class="db-row-group clearfix">
								<span class="db-row-label col-sm-3">Authorize.net key</span>
								<div class="col-sm-9">
									<input type="text" class="db-settings-authorize_key" placeholder="Authorize.net key" value="<?php echo $main_settings['authorize_key']; ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="db-row-group col-md-12 clearfix">
				<input type="hidden" class="db-settings-db_theme_id" value="<?php echo $main_settings['db_theme_id']; ?>">
				<input type="hidden" class="db-settings-db_theme_path" value="<?php echo $main_settings['db_theme_path']; ?>">
				<input type="hidden" class="db-settings-db_theme_url" value="<?php echo $main_settings['db_theme_url']; ?>">
				<a href="javascript:void(0)" class="db-save-settings db-button db-primary-button">Save changes</a>
			</div>
		</div>
	</div>
	<?php
}

function db_load_template( $template_name, $load = false, $require_once = true, $theme_settings ) {
	if ( $template_name == '' ) {
		return;
	}

	if ( isset($theme_settings['db_theme_path']) && file_exists( $theme_settings['db_theme_path'].$template_name ) ) {
		$located = $theme_settings['db_theme_path'].$template_name;
	} else if ( file_exists( plugin_dir_path( __FILE__ ).'/template/'.$template_name ) ) {
		$located = plugin_dir_path( __FILE__ ).'/template/'.$template_name;
	}

	if ( $load && '' != $located ) {
		ob_start();
		load_template( $located, $require_once );
		$located = ob_get_clean();
	}

	return $located;
}

function db_get_categories( $post_id, $separator = ', ' ) {
	$categories = wp_get_object_terms($post_id, 'listing_category');
	$all_categories = array();
	if ( !empty($categories) ) {
		foreach ($categories as $category_value) {
			$all_categories[] = '<span class="db-search-listing-category">'.$category_value->name.'</span>';
		}
	}

	echo implode($separator, $all_categories);
}

function db_get_listing_custom_field_data( $listing_array, $custom_class = '', $echo = true ) {
	$active_fields = db_get_listing_custom_fields( $listing_array['ID'], 'on_listing' );

	if ( !empty($active_fields) ) {
		foreach ($active_fields as $field_data) {
			if ( !empty($field_data['value']) ) {
				$field_value = (is_array($field_data['value'])?implode(', ', $field_data['value']):$field_data['value']);
			
				if ( $field_data['icon'] == '' ) {
					$field_title = '<span class="db-field-title">'.$field_data['title'].': </span>';
				} else {
					$field_title = '<span class="db-field-icon '.$field_data['icon'].'" title="'.$field_data['title'].'"></span>';
				}

				// Echo or return?
				if ( $echo === true ) {
					echo '<div class="'.$custom_class.'">'.$field_title.'<span class="db-field-value">'.$field_value.'</span></div>';
				} else if ( $echo === false ) {
					return '<div class="'.$custom_class.'">'.$field_title.'<span class="db-field-value">'.$field_value.'</span></div>';
				}
			}
		}
	}
}

function db_save_settings() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$db_settings = ( isset($_POST['db_settings']) ? sanitize_text_field($_POST['db_settings']) : '' );
	
	$db_settings_decoded = json_decode(stripslashes($db_settings), true);

	if ( isset($db_settings_decoded['default_location']) && $db_settings_decoded['default_location'] != '' ) {
		$response = wp_remote_get( "http://maps.google.com/maps/api/geocode/json?sensor=false&address=".str_replace(" ", "+", $db_settings_decoded['default_location']) );
		$json = json_decode( $response['body'], true );
		$db_settings_decoded['default_location_lat'] = $json['results'][0]['geometry']['location']['lat'];
		$db_settings_decoded['default_location_lng'] = $json['results'][0]['geometry']['location']['lng'];
	}
	
	if ( !empty($db_settings_decoded) ) {
		update_option( 'db_main_settings', $db_settings_decoded );
		echo '{"save_response": "0"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_save_settings', 'db_save_settings' );

function db_save_templates() {
	if ( !current_user_can('manage_options') ) die(0);

	$db_templates = ( isset($_POST['db_templates']) ? json_decode( stripslashes( sanitize_text_field($_POST['db_templates']) ), true ) : '' );
	
	if ( update_option( 'db_main_templates', $db_templates ) ) {
		echo '{"save_response": "0"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_save_templates', 'db_save_templates' );

function db_package_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<?php if ( !isset($_GET['package_type']) && !isset($_GET['package_id']) ) { ?>
				<a href="<?php echo DB_PLUGIN_PACKAGE_PAGE_URL; ?>&package_type=new" class="db-add-new-package db-button db-primary-button">Add new</a>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						global $wpdb;
						$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages ORDER BY ID ASC');
						if ( !empty($field_list) ) {
							foreach ($field_list as $field_value) {
								$field_settings = json_decode($field_value->package_settings, true);
								echo '
								<tr>
									<td style="width: 5%;">'.$field_value->ID.'</td>
									<td style="width: 80%;">'.$field_settings['fee_label'].'</td>
									<td style="width: 15%;">
										<a href="'.DB_PLUGIN_PACKAGE_PAGE_URL.'&package_id='.$field_value->ID.'" class="db-edit-package">Edit</a>
										<a href="javascript:void(0)" class="db-delete-package" data-id="'.$field_value->ID.'">Delete</a>
									</td>
								</tr>';
							}
						}
						?>
					</tbody>
				</table>
			<?php } else if ( isset($_GET['package_type']) || isset($_GET['package_id']) ) {
				$field_settings = array();
				if ( isset($_GET['package_id']) ) {
					global $wpdb;
					$field_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.intval($_GET['package_id']).'"');
					$field_settings = json_decode($field_data['0']->package_settings, true);
				}
				?>
				<div class="db-custom-field">
					<div class="db-box-title">
						<h3 class="db-main-title">Custom package</h3>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['fee_label'])&&$field_settings['fee_label']!=''?'active':''); ?> clearfix">
						<label class="field-label">Fee label</label>
						<div class="db-field-input">
							<input type="text" class="db-create-fee_label" value="<?php echo(isset($field_settings['fee_label'])?$field_settings['fee_label']:''); ?>">
						</div>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['fee_amount'])&&$field_settings['fee_amount']!=''?'active':''); ?> clearfix">
						<label class="field-label">Fee amount</label>
						<div class="db-field-input">
							<input type="number" class="db-create-fee_amount" value="<?php echo(isset($field_settings['fee_amount'])?$field_settings['fee_amount']:''); ?>">
							<span>One time payment set to have a fee of <strong>0</strong> will be considered as free package.</span>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Payment type</label>
						<div class="db-field-input">
							<select class="db-create-payment_type">
								<option value="onetime" <?php echo(isset($field_settings['payment_type'])&&$field_settings['payment_type']=='onetime'?'selected':''); ?>>One time payment</option>
								<option value="recurring" <?php echo(isset($field_settings['payment_type'])&&$field_settings['payment_type']=='recurring'?'selected':''); ?>>Recurring payment</option>
							</select>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Run listing for</label>
						<div class="db-field-input">
							<select class="db-create-listing_run_type">
								<option value="days" <?php echo(isset($field_settings['listing_run_type'])&&$field_settings['listing_run_type']=='days'?'selected':''); ?>>Set amount of days</option>
								<option value="forever" <?php echo(isset($field_settings['listing_run_type'])&&$field_settings['listing_run_type']=='forever'?'selected':''); ?>>Forever</option>
							</select>
						</div>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['listing_run_days'])&&$field_settings['listing_run_days']!=''?'active':(!isset($field_settings['listing_run_days'])?'active':'')); ?> clearfix">
						<label class="field-label">Run listing for (days)</label>
						<div class="db-field-input">
							<input type="number" class="db-create-listing_run_days" value="<?php echo(isset($field_settings['listing_run_days'])?$field_settings['listing_run_days']:'20'); ?>">
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Enable trial period</label>
						<div class="db-field-input">
							<div class="db-checkbox <?php echo (isset($field_settings['trial_period'])&&$field_settings['trial_period']=='true'?'active':''); ?>">
								<input type="checkbox" class="db-create-trial_period" <?php echo (isset($field_settings['trial_period'])&&$field_settings['trial_period']=='true'?'checked':''); ?>>
							</div>
						</div>
					</div>
					<div class="db-field-row active db-trial-row clearfix">
						<label class="field-label">Trial period lasts for</label>
						<div class="db-field-input interval">
							<input type="number" class="db-create-trial_interval" value="<?php echo(isset($field_settings['trial_interval'])?$field_settings['trial_interval']:''); ?>">
						</div>
						<div class="db-field-input cycle">
							<select class="db-create-trial_cycle">
								<option value="days" <?php echo(isset($field_settings['trial_cycle'])&&$field_settings['trial_cycle']=='days'?'selected':''); ?>>Days</option>
								<option value="weeks" <?php echo(isset($field_settings['trial_cycle'])&&$field_settings['trial_cycle']=='weeks'?'selected':''); ?>>Weeks</option>
								<option value="months" <?php echo(isset($field_settings['trial_cycle'])&&$field_settings['trial_cycle']=='months'?'selected':''); ?>>Months</option>
								<option value="years" <?php echo(isset($field_settings['trial_cycle'])&&$field_settings['trial_cycle']=='years'?'selected':''); ?>>Years</option>
							</select>
						</div>
						<div class="clearfix"></div>
						<span class="db-trial-text">
							For Authorize.net the trial period is going to be the 1st payment cycle.<br>
							For example, if your payment is set to be once a month, then trial period is going to be the 1st month.
						</span>
					</div>
					<div class="db-field-row active db-sub-row clearfix">
						<label class="field-label">Subscription payment intervals</label>
						<div class="db-field-input interval">
							<input type="number" class="db-create-payment_interval" value="<?php echo(isset($field_settings['payment_interval'])?$field_settings['payment_interval']:''); ?>">
						</div>
						<div class="db-field-input cycle">
							<select class="db-create-payment_cycle">
								<option value="days" <?php echo(isset($field_settings['payment_cycle'])&&$field_settings['payment_cycle']=='days'?'selected':''); ?>>Days</option>
								<option value="weeks" <?php echo(isset($field_settings['payment_cycle'])&&$field_settings['payment_cycle']=='weeks'?'selected':''); ?>>Weeks</option>
								<option value="months" <?php echo(isset($field_settings['payment_cycle'])&&$field_settings['payment_cycle']=='months'?'selected':''); ?>>Months</option>
								<option value="years" <?php echo(isset($field_settings['payment_cycle'])&&$field_settings['payment_cycle']=='years'?'selected':''); ?>>Years</option>
							</select>
						</div>
						<div class="clearfix"></div>
						<span>For example, if set to 1 months, then a payment will be needed each month.</span>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['image_amount'])&&$field_settings['image_amount']!=''?'active':''); ?> clearfix">
						<label class="field-label">Images allowed</label>
						<div class="db-field-input">
							<input type="number" class="db-create-image_amount" value="<?php echo(isset($field_settings['image_amount'])?$field_settings['image_amount']:''); ?>">
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Package listings sticky (featured)?</label>
						<div class="db-field-input">
							<div class="db-checkbox <?php echo (isset($field_settings['listing_sticky'])&&$field_settings['listing_sticky']=='true'?'active':''); ?>">
								<input type="checkbox" class="db-create-listing_sticky" <?php echo (isset($field_settings['listing_sticky'])&&$field_settings['listing_sticky']=='true'?'checked':''); ?>>
							</div>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Apply to categories</label>
						<div class="db-field-input">
							<select class="db-create-apply_categories" multiple>
							<?php
							$categories = get_terms( array(
								'taxonomy' => 'listing_category',
								'hide_empty' => false
							));
							if ( !empty($categories) ) {
								$categoryHierarchy = array();
								db_sort_terms_hierarchicaly($categories, $categoryHierarchy);

								foreach ($categoryHierarchy as $category_value) {
									$is_checked = (in_array($category_value->term_id, $field_settings['apply_categories'])?'selected':'');
									echo '<option value="'.$category_value->term_id.'" '.$is_checked.'>'.$category_value->name.'</option>';

									if ( !empty($category_value->children) ) {
										echo db_display_backend_categories( $category_value, $field_settings['apply_categories'] );
									}
								}
							}
							?>
							</select>
						</div>
					</div>
					<div class="db-field-row <?php echo(isset($field_settings['fee_description'])&&$field_settings['fee_description']!=''?'active':''); ?> clearfix">
						<label class="field-label">Fee description</label>
						<div class="db-field-input">
							<textarea class="db-create-fee_description"><?php echo(isset($field_settings['fee_description'])?$field_settings['fee_description']:''); ?></textarea>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Listing status after it expires</label>
						<div class="db-field-input">
							<select class="db-create-listing_status">
								<option value="draft" <?php echo(isset($field_settings['listing_status'])&&$field_settings['listing_status']=='draft'?'selected':''); ?>>Draft</option>
								<option value="trash" <?php echo(isset($field_settings['listing_status'])&&$field_settings['listing_status']=='trash'?'selected':''); ?>>Trash</option>
							</select>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Popular package?</label>
						<div class="db-field-input">
							<div class="db-checkbox <?php echo (isset($field_settings['listing_popular'])&&$field_settings['listing_popular']=='true'?'active':''); ?>">
								<input type="checkbox" class="db-create-listing_popular" <?php echo (isset($field_settings['listing_popular'])&&$field_settings['listing_popular']=='true'?'checked':''); ?>>
							</div>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Package image</label>
						<div class="db-field-input">
							<input type="button" value="Upload image" class="db-image-upload">
							<input type="button" class="db-image-delete" value="Delete image" <?php echo (!isset($field_settings['package_img'])||$field_settings['package_img']==''?'style="display: none;"':''); ?>s>
							<div class="db-image-container">
								<?php echo (isset($field_settings['package_img'])&&$field_settings['package_img']!=''?'<img src="'.$field_settings['package_img'].'" alt="">':''); ?>
							</div>
							<input type="hidden" class="db-create-package_img" value="<?php echo (isset($field_settings['package_img'])&&$field_settings['package_img']!=''?$field_settings['package_img']:''); ?>">
						</div>
					</div>

					<?php if ( !isset($_GET['package_id']) ) { ?>
						<a href="javascript:void(0)" class="db-save-package db-button db-primary-button" data-save="insert">Create package</a>
					<?php } else { ?>
						<a href="javascript:void(0)" class="db-save-package db-button db-primary-button" data-save="update" data-id="<?php echo esc_attr($_GET['package_id']); ?>">Save package</a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
}

function db_display_backend_categories( $cat_data, $active_categories = array() ) {
	$output = '';
	foreach ($cat_data->children as $child_value) {
		$parents = get_category_parents($child_value->term_id);
		$parents_exploded = explode('/', $parents);
		$depth = count($parents_exploded)-2;
		$depth_str = '';
		for ($i=0; $i < $depth; $i++) { 
			$depth_str .= '-';
		}

		$is_checked = (in_array($child_value->term_id, $active_categories)?'selected':'');
		$output .= '<option value="'.$child_value->term_id.'" '.$is_checked.'>'.$child_value->name.'</option>';
		
		if ( !empty( $child_value->children ) ) {
			$output .= db_display_backend_categories( $child_value );
		}
	}

	return $output;
}

function db_claims_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<div class="db-box-title">
				<h3 class="db-main-title"><?php esc_html_e('Listing claims', 'directory-builder'); ?></h3>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Claimed by</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					global $wpdb;
					$claims_list = $wpdb->get_results('SELECT post_id, meta_value FROM '.$wpdb->prefix.'postmeta WHERE meta_key="db_claim_info" ORDER BY post_id ASC');
					if ( !empty($claims_list) ) {
						$date_format = get_option( 'date_format' );
						foreach ($claims_list as $claims_value) {
							$author = explode(':', $claims_value->meta_value);
							if ( get_post_type( $claims_value->post_id ) == 'listings' && $author['0'] != '0' && strpos($claims_value->meta_value, 'author') === false ) {
								$meta_parsed = explode(':', $claims_value->meta_value);
								echo '
								<tr>
									<td style="width: 5%;">'.$claims_value->post_id.'</td>
									<td style="width: 30%;"><a href="'.get_permalink($claims_value->post_id).'" target="_blank">'.get_the_title($claims_value->post_id).'</a></td>
									<td style="width: 35%;"><a href="'.admin_url('user-edit.php?user_id='.$author['0']).'">'.get_the_author_meta('nicename', $author['0']).'</a></td>
									<td style="width: 15%;">' . ( is_numeric( $meta_parsed['1'] ) ? date( $date_format, $meta_parsed['1'] ) : esc_html__('Not approved', 'directory-builder') ) . '</td>
									<td style="width: 15%;">';
										if ( strpos($claims_value->meta_value, 'waiting') === false ) {
											esc_html_e('Claimed', 'directory-builder');
											echo ' <a href="javascript:void(0)" class="db-cancel-claim" data-id="'.$claims_value->post_id.'">'.esc_html__('Remove', 'directory-builder').'</a>';
										} else {
											echo '
											<a href="javascript:void(0)" class="db-approve-claim" data-id="'.$claims_value->post_id.'">'.esc_html__('Approve', 'directory-builder').'</a>
											<a href="javascript:void(0)" class="db-cancel-claim" data-id="'.$claims_value->post_id.'">'.esc_html__('Cancel', 'directory-builder').'</a>';
										}
									echo '
									</td>
								</tr>';
							}
						}
					} else {
						echo '
						<tr>
							<td colspan="4" class="center">'.esc_html__('None of the listings is claimed!', 'directory-builder').'</td>
						</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
}

function db_subscriptions_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<div class="db-box-title">
				<h3 class="db-main-title"><?php esc_html_e('Package subscriptions', 'directory-builder'); ?></h3>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="10%">Status</th>
						<th width="20%">Listing</th>
						<th width="15%">Cycle</th>
						<th width="15%">Starting date</th>
						<th width="15%">Next payment</th>
						<th width="15%">Payment gateway</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					global $wpdb;
					$sub_list = $wpdb->get_results('SELECT post_id, meta_value FROM '.$wpdb->prefix.'postmeta WHERE meta_key LIKE "db_subscription" ORDER BY meta_id ASC');
					if ( !empty($sub_list) ) {
						$date_format = get_option( 'date_format' );
						foreach ($sub_list as $sub_data) {
							$listing_id = $sub_data->post_id;
							$subscription_data = unserialize( $sub_data->meta_value );

							if ( $subscription_data['payment_interval'] == 1 ) {
								$payment_cycle = sprintf( __( 'Once a %s', 'directory-builder' ), rtrim( $subscription_data['payment_cycle'], 's' ) );
							} else {
								$payment_cycle = sprintf( __( 'Every %d %s', 'directory-builder' ), $subscription_data['payment_interval'], $subscription_data['payment_cycle'] );
							}

							$gateway = strtolower( $subscription_data['geteway'] );

							echo '
							<tr>
								<td>' . ucfirst( $subscription_data['status'] ) . '</td>
								<td><a href="' . get_permalink( $listing_id ) . '" target="_blank">' . get_the_title( $listing_id ) . '</a></td>
								<td>' . $payment_cycle . '</td>
								<td>' . date( $date_format, $subscription_data['starting'] ) . '</td>
								<td>' . ($subscription_data['status'] == 'active' ? date( $date_format, $subscription_data['next_payment'] ) : '-' ) . '</td>
								<td>' . $subscription_data['geteway'] . '</td>
								<td>';
									if ( $subscription_data['status'] == 'active' ) {
										echo '
										<a href="'.get_admin_url().'post.php?post='.$listing_id.'&action=edit">' . esc_html__('Edit', 'directory-builder') . '</a>
										<a href="javascript:void(0)" class="db-cancel-subscription" data-gateway="'.$gateway.'" data-id="'.$listing_id.'">' . esc_html__('Cancel', 'directory-builder') . '</a>
										'.($gateway=='paypal'?'<span class="db-cancel-paypal hidden">'.esc_html__('You can cancel this subscription via your PayPal account.', 'directory-builder').'</span>':'');
									}
								echo '
								</td>
							</tr>';
						}
					} else {
						echo '
						<tr>
							<td colspan="7" class="center">'.esc_html__('There\'s no subscriptions!', 'directory-builder').'</td>
						</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
}

function db_ads_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}

	$active_packages = array();
	if ( isset($_POST['ad_packages']) ) {
		$active_packages = $_POST['ad_packages'];
	}

	if ( isset($_GET['action']) && $_GET['action'] == 'new' && isset($_POST['ad_label']) ) { // Add new ad
		global $wpdb;
		$insert_result = $wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'directory_ads ( title, content, placement, packages, status ) VALUES ( "'.esc_attr($_POST['ad_label']).'", "'.urlencode($_POST['ad_html']).'", "'.esc_attr($_POST['ad_place']).'", "'.addslashes( json_encode($active_packages) ).'", "'.(!isset($_POST['ad_status'])?'false':'true').'" )' );

		if ( $insert_result ) {
			$query_status = true;
			$query_result = 'Your new advertisement was added successfully!';
			$new_url = add_query_arg('id', $wpdb->insert_id, DB_PLUGIN_AD_PAGE_URL);
			$extra_func = '<script type=\'text/javascript\'>var new_url = \''.$new_url.'\'; history.pushState({page: new_url}, \'\', new_url);</script>';
			$new_id = $wpdb->insert_id;
		} else {
			$query_status = false;
			$query_result = 'Something went wrong while adding your advertisement!';;
		}
	} else if ( isset($_GET['id']) && isset($_POST['ad_label']) ) { // Edit existing ad
		global $wpdb;
		$update_result = $wpdb->query( 'UPDATE ' . $wpdb->prefix . 'directory_ads SET title="'.esc_attr($_POST['ad_label']).'", content="'.urlencode($_POST['ad_html']).'", placement="'.esc_attr($_POST['ad_place']).'", packages="'.addslashes( json_encode($active_packages) ).'", status="'.(!isset($_POST['ad_status'])?'false':'true').'" WHERE ID="'.intval($_GET['id']).'"' );

		if ( $update_result ) {
			$query_status = true;
			$query_result = 'Your advertisement was saved successfully!';
		} else {
			$query_status = false;
			$query_result = 'Something went wrong while saving your advertisement!';;
		}
	} else if ( isset($_GET['action']) && $_GET['action'] == 'delete' ) { // Delete ad
		global $wpdb;
		$delete_result = $wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'directory_ads WHERE ID="'.intval($_GET['id']).'"' );

		if ( $delete_result ) {
			$query_status = true;
			$query_result = 'Your advertisement was deleted successfully!';
		} else {
			$query_status = false;
			$query_result = 'Something went wrong while deleting your advertisement!';;
		}
	}

	?>
	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card">
			<div class="db-box-title">
				<h3 class="db-main-title"><?php esc_html_e('Listing advertisements', 'directory-builder'); ?></h3>
			</div>
			<?php
			if ( isset($query_result) ) {
				?>
				<span class="db-ad-notice <?php echo ($query_status?'success':'failed'); ?>"><?php echo $query_result; ?></span>
				<?php
			}
			if ( isset($extra_func) ) {
				echo $extra_func;
			}
			if ( ( isset($_GET['action']) && $_GET['action'] == 'delete' ) || !isset($_GET['action']) && !isset($_GET['id']) ) { ?>
				<a href="<?php echo add_query_arg('action', 'new', DB_PLUGIN_AD_PAGE_URL); ?>" class="db-add-new-ad db-button db-primary-button">Add new</a>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="70%">Title</th>
							<th width="10%">Views</th>
							<th width="10%">Status</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						global $wpdb;
						$all_ads = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'directory_ads' );

						if ( !empty( $all_ads ) ) {
							foreach ( $all_ads as $ad_data ) {
								?>
								<tr>
									<td><?php echo $ad_data->title; ?></td>
									<td><?php echo $ad_data->views; ?></td>
									<td><?php echo ($ad_data->status=='true'?'Active':'Inactive'); ?></td>
									<td>
										<a href="<?php echo add_query_arg('id', $ad_data->ID, DB_PLUGIN_AD_PAGE_URL); ?>">Edit</a>
										<a href="<?php echo add_query_arg(array( 'action' => 'delete', 'id' => $ad_data->ID ), DB_PLUGIN_AD_PAGE_URL); ?>">Delete</a>
									</td>
								</tr>
								<?php
							}
						} else { ?>
							<tr>
								<td colspan="4" class="aligncenter">There's no advertisements added!</td>
							</tr>
						<?php
						}
						?>
						
					</tbody>
				</table>
			<?php } else {
				if ( isset($_GET['id']) || isset($new_id) ) {
					global $wpdb;
					if ( !isset($_GET['id']) ) {
						$_GET['id'] = $new_id;
					}
					$current_ad = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'directory_ads WHERE ID="'.intval($_GET['id']).'"' );
				}?>
				<form method="post">
					<div class="db-field-row clearfix">
						<label class="field-label">Advertisement title</label>
						<div class="db-field-input">
							<input type="text" name="ad_label" value="<?php echo (!empty($current_ad)?$current_ad['0']->title:''); ?>" required>
						</div>
					</div>
					<div class="db-field-row clearfix">
						<div class="db-field-input">
							<?php wp_editor( (!empty($current_ad)?stripslashes( urldecode($current_ad['0']->content) ):''), 'ad_html', array( 'textarea_name' => 'ad_html', 'editor_height' => '300', 'wpautop' => false ) ); ?>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Advertisement placement</label>
						<div class="db-field-input">
							<select name="ad_place">
								<option value="content" <?php echo(!empty($current_ad)&&$current_ad['0']->placement=='content'?'selected':''); ?>>Below content</option>
								<option value="sidebar" <?php echo(!empty($current_ad)&&$current_ad['0']->placement=='sidebar'?'selected':''); ?>>At sidebar</option>
							</select>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Advertisement packages</label>
						<div class="db-field-input">
							<?php
							global $wpdb;
							$all_packages = $wpdb->get_results( 'SELECT ID, package_name FROM ' . $wpdb->prefix . 'directory_packages' );
							if ( !empty($all_packages) ) {
								$active_packages = ( !empty($current_ad) ? json_decode( $current_ad['0']->packages ) : array() );
								echo '<select name="ad_packages[]" multiple>';
								foreach ($all_packages as $package_data) {
									echo '<option value="'.$package_data->ID.'" '.(in_array($package_data->ID, $active_packages)?'selected':'').'>'.$package_data->package_name.'</option>';
								}
								echo '</select>';
								echo '<span>Show this ad only for the selected packages</span>';
							}
							?>
						</div>
					</div>
					<div class="db-field-row active clearfix">
						<label class="field-label">Is this ad active?</label>
						<div class="db-field-input">
							<div class="db-checkbox <?php echo (!empty($current_ad)&&$current_ad['0']->status=='true'?'active':''); ?>">
								<input type="checkbox" name="ad_status" <?php echo (!empty($current_ad)&&$current_ad['0']->status=='true'?'checked':''); ?>>
							</div>
						</div>
					</div>
					<input type="submit" class="db-button db-primary-button" value="Save">
				</form>
			<?php } ?>
		</div>
	</div>
	<?php
}

function db_get_active_ads( $listing_id ) {
	global $wpdb;
	
	$listing_data = get_post_meta( $listing_id, 'db_order_info', true );

	if ( isset($listing_data['listing_package']) ) {
		$all_ads = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'directory_ads WHERE status="true" && packages LIKE "%\"'.intval($listing_data['listing_package']).'\"%"' );
	} else {
		$all_ads = array();
	}

	return $all_ads;
}

function db_cancel_claim_func() {
	if ( !current_user_can('manage_options') ) die(0);

	$claim_post = ( isset($_POST['claim_post']) ? intval($_POST['claim_post']) : '' );

	if ( delete_post_meta( $claim_post, 'db_claim_info' ) ) {
		wp_update_post( array( 'ID' => $claim_post, 'post_author' => get_current_user_id() ) );

		echo '{"save_response": "'.$claim_post.'"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_cancel_claim', 'db_cancel_claim_func' );

function db_approve_claim_func() {
	if ( !current_user_can('manage_options') ) die(0);

	$claim_post = ( isset($_POST['claim_post']) ? intval($_POST['claim_post']) : '' );
	$claim_info = get_post_meta( $claim_post, 'db_claim_info', true );
	$author = explode(':', $claim_info);

	if ( wp_update_post( array( 'ID' => $claim_post, 'post_author' => $author['0'] ) ) ) {
		update_post_meta( $claim_post, 'db_claim_info', $author['0'] . ':' . time() );

		if ( function_exists( 'db_send_notification_email' ) ) {
			$main_settings = get_option( 'db_main_settings', array());
			$current_user = get_userdata( $author['0'] );
			db_send_notification_email( $author['0'], 'new_claim', array( 'username' => $current_user->data->user_login, 'url_dashboard' => get_permalink( $main_settings['account_page_id'] ), 'listing_title' => get_the_title($claim_post), 'listing' => get_permalink($claim_post) ) );
		}

		echo '{"save_response": "'.$claim_post.'", "message": "'.esc_html__('Claimed', 'directory-builder').'"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_approve_claim', 'db_approve_claim_func' );

function db_delete_package() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$package_id = ( isset($_POST['package_id']) ? intval($_POST['package_id']) : '' );

	if ( $wpdb->query('DELETE FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.$package_id.'"') === false ) {
		echo '{"save_response": "failed"}';
	} else {
		echo '{"save_response": "'.$wpdb->insert_id.'"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_delete_package', 'db_delete_package' );

function db_single_listing_template( $template ) {
	global $post;

	if ( $post->post_type == "listings" ) {
		$main_settings = get_option( 'db_main_settings');

		return db_load_template( 'single-listings.php', false, false, $main_settings );
	}

	return $template;
}
add_filter('single_template', 'db_single_listing_template');

function db_listing_rating_template( $comment_template ) {
	 global $post;
	 if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
		return;
	 }
	 if ( $post->post_type == 'listings' ) {
		$main_settings = get_option( 'db_main_settings');

		return db_load_template( 'single-listing-ratings.php', false, false, $main_settings );
	 }
}
add_filter( "comments_template", "db_listing_rating_template" );

function db_insert_review( $comment_id, $comment_object ) {
	if ( !isset($_POST['listing_rating']) || !isset($_POST['review-title']) ) {
		return;
	}

	$rating_value = (isset($_POST['listing_rating'])?intval($_POST['listing_rating']):1);
	$rating_title = (isset($_POST['review-title'])?sanitize_text_field($_POST['review-title']):'');

	add_comment_meta( $comment_id, 'listing_review_rating', $rating_value);
	add_comment_meta( $comment_id, 'listing_review_title', $rating_title);
	$post_id = $comment_object->comment_post_ID;

	if ( $comment_object->user_id == '0' ) {
		$user_id = $comment_object->user_id;
	} else {
		$user_id = 'anon-'.rand(100000,999999);
	}

	$listing_ratings = get_post_meta( $post_id, 'listing_ratings', true);
	if ( $listing_ratings == '' ) {
		update_post_meta( $post_id, 'listing_ratings', array( $user_id => $rating_value ) );
	} else {
		$listing_ratings[$user_id] = $rating_value;
		update_post_meta( $post_id, 'listing_ratings', $listing_ratings );
	}
}
add_action( 'wp_insert_comment', 'db_insert_review', 10, 2 );

function db_disable_comment_url($fields) { 
	unset($fields['url']);
	return $fields;
}
add_filter('comment_form_default_fields','db_disable_comment_url');

function db_review( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$rating_value = get_comment_meta( $comment->comment_ID, 'listing_review_rating', true );
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'directory-builder' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'directory-builder' ), '<span class="edit-link button blue">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	
	<li <?php comment_class(); ?> id="li-review-<?php comment_ID(); ?>">
		<div id="review-<?php comment_ID(); ?>" class="review">
			<div class="review-meta">
				<div class="review-author vcard shadows">
					<?php
						$avatar_size = 70;
						echo get_avatar( $comment, $avatar_size );                          
					?>
				</div><!-- .review-author .vcard -->
			</div>

			<div class="review-content">
				<?php echo '<h4>' . get_comment_author_link() . '</h4>' ?>
				<?php if ( $comment->comment_approved == '0' ) { ?>
					<em class="review-awaiting-moderation"><?php _e( 'Your review is awaiting moderation.', 'directory-builder' ); ?></em>
				<?php } ?>
				<?php echo '<span class="db-listing-rating">'.__('Rating:', 'directory-builder').' '.$rating_value.db_get_rating_stars( $rating_value ).'</span>'; ?>
				<?php edit_comment_link( __( 'Edit', 'directory-builder' ), '<span class="edit-link button blue">', '</span>' ); ?>
				<?php comment_text(); ?>
				<div class="reply-edit-container">
					
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div><!-- end of review -->

	<?php
			break;
	endswitch;
}

function db_get_rating_stars( $rating ) {
	$output = '';

	if ( !defined('WHITELAB_CUSTOM_STARS') ) {
		for ( $i=1; $i <= $rating; $i++ ) { 
			$output .= '<i class="dbicon-star"></i>';
		}
		
		if ( $rating != 5 ) {
			for ( $i=1; $i <= 5-$rating; $i++ ) { 
				$output .= '<i class="dbicon-star-empty"></i>';
			}
		}
	} else {
		$rating_star = '
		<svg width="16px" height="15px" viewBox="0 0 16 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<g id="Single-listing" transform="translate(-380.000000, -2797.000000)" stroke="#909FA5" fill="#FFFFFF">
					<g id="Listing" transform="translate(-1.000000, 172.000000)">
						<g id="Coments" transform="translate(151.000000, 2089.000000)">
							<g id="Comment-form" transform="translate(30.000000, 474.000000)">
								<g id="stars" transform="translate(120.000000, 63.000000)">
									<g id="star" transform="translate(81.000000, 0.000000)">
										<g  >
											<path d="M0.321780893,6.17123188 L2.50574108,8.42145652 L2.1280167,11.6264746 L2.12589942,11.6556304 C2.11037263,12.0718188 2.22649417,12.421029 2.46132506,12.6649674 C2.79557443,13.0122935 3.34150567,13.0825688 3.88292002,12.8381594 L6.78224162,11.2581413 L9.65700266,12.8257246 L9.68137501,12.8381594 C9.89954989,12.9364601 10.1142901,12.9864348 10.3202788,12.9864348 C10.6253566,12.9864348 10.903239,12.8720725 11.1027347,12.6649674 C11.3375656,12.421029 11.4537342,12.0718188 11.4382074,11.6556304 L11.0580834,8.42145652 L13.2126839,6.20533333 L13.2420436,6.17123188 C13.5430751,5.77477899 13.6379767,5.31996739 13.5024702,4.9238913 C13.3667755,4.52781522 13.0133764,4.22678986 12.5327047,4.09848551 L9.29649891,3.57613043 L7.88544334,0.734076087 L7.86417635,0.696771739 C7.58582341,0.27040942 7.17751597,0.0257173913 6.74384811,0.0257173913 C6.32693036,0.0257173913 5.93866659,0.243985507 5.65005656,0.639684783 L3.98116223,3.57537681 L1.0584093,4.06692754 L1.01827491,4.07601812 C0.541132045,4.21237681 0.191355884,4.51980797 0.0585312811,4.91969928 C-0.0743403731,5.31940217 0.0214551963,5.77576812 0.321780893,6.17123188 L0.321780893,6.17123188 Z M0.754978244,5.15186232 C0.809698405,4.98780797 0.967836376,4.85898551 1.2017733,4.78819203 L4.44682468,4.24228623 L6.25522483,1.05686232 C6.55028083,0.665684783 6.96362272,0.675481884 7.23863505,1.08187319 L8.80740512,4.24157971 L12.3604515,4.81296739 C12.5950471,4.87933333 12.7537027,5.00278623 12.8084228,5.16217754 C12.8626254,5.32053261 12.8134102,5.51449638 12.6705167,5.70992029 L10.2882371,8.15985507 L10.7051078,11.6968442 C10.7103775,11.8992391 10.6640324,12.0613623 10.5742123,12.1546703 C10.456444,12.2771341 10.2406687,12.2814203 9.99506316,12.1733225 L6.78200636,10.4211014 L3.56871431,12.1733225 C3.32263827,12.2812319 3.10691003,12.276663 2.98980042,12.1551413 C2.89974506,12.0614094 2.85339995,11.8992391 2.8586226,11.6968913 L3.27554035,8.15990217 L0.893731257,5.7102029 C0.749708547,5.51313043 0.700493338,5.31577536 0.754978244,5.15186232 L0.754978244,5.15186232 Z"  ></path>
										</g>
									</g>
								</g>
							</g>
						</g>
					</g>
				</g>
			</g>
		</svg>';

		$rating_star_filled = '
		<svg width="16px" height="15px" viewBox="0 0 16 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<g id="Single-listing" transform="translate(-380.000000, -2797.000000)" stroke="#247ba0" fill="#FFFFFF">
					<g id="Listing" transform="translate(-1.000000, 172.000000)">
						<g id="Coments" transform="translate(151.000000, 2089.000000)">
							<g id="Comment-form" transform="translate(30.000000, 474.000000)">
								<g id="stars" transform="translate(120.000000, 63.000000)">
									<g id="star" transform="translate(81.000000, 0.000000)">
										<g  >
											<path d="M0.321780893,6.17123188 L2.50574108,8.42145652 L2.1280167,11.6264746 L2.12589942,11.6556304 C2.11037263,12.0718188 2.22649417,12.421029 2.46132506,12.6649674 C2.79557443,13.0122935 3.34150567,13.0825688 3.88292002,12.8381594 L6.78224162,11.2581413 L9.65700266,12.8257246 L9.68137501,12.8381594 C9.89954989,12.9364601 10.1142901,12.9864348 10.3202788,12.9864348 C10.6253566,12.9864348 10.903239,12.8720725 11.1027347,12.6649674 C11.3375656,12.421029 11.4537342,12.0718188 11.4382074,11.6556304 L11.0580834,8.42145652 L13.2126839,6.20533333 L13.2420436,6.17123188 C13.5430751,5.77477899 13.6379767,5.31996739 13.5024702,4.9238913 C13.3667755,4.52781522 13.0133764,4.22678986 12.5327047,4.09848551 L9.29649891,3.57613043 L7.88544334,0.734076087 L7.86417635,0.696771739 C7.58582341,0.27040942 7.17751597,0.0257173913 6.74384811,0.0257173913 C6.32693036,0.0257173913 5.93866659,0.243985507 5.65005656,0.639684783 L3.98116223,3.57537681 L1.0584093,4.06692754 L1.01827491,4.07601812 C0.541132045,4.21237681 0.191355884,4.51980797 0.0585312811,4.91969928 C-0.0743403731,5.31940217 0.0214551963,5.77576812 0.321780893,6.17123188 L0.321780893,6.17123188 Z M0.754978244,5.15186232 C0.809698405,4.98780797 0.967836376,4.85898551 1.2017733,4.78819203 L4.44682468,4.24228623 L6.25522483,1.05686232 C6.55028083,0.665684783 6.96362272,0.675481884 7.23863505,1.08187319 L8.80740512,4.24157971 L12.3604515,4.81296739 C12.5950471,4.87933333 12.7537027,5.00278623 12.8084228,5.16217754 C12.8626254,5.32053261 12.8134102,5.51449638 12.6705167,5.70992029 L10.2882371,8.15985507 L10.7051078,11.6968442 C10.7103775,11.8992391 10.6640324,12.0613623 10.5742123,12.1546703 C10.456444,12.2771341 10.2406687,12.2814203 9.99506316,12.1733225 L6.78200636,10.4211014 L3.56871431,12.1733225 C3.32263827,12.2812319 3.10691003,12.276663 2.98980042,12.1551413 C2.89974506,12.0614094 2.85339995,11.8992391 2.8586226,11.6968913 L3.27554035,8.15990217 L0.893731257,5.7102029 C0.749708547,5.51313043 0.700493338,5.31577536 0.754978244,5.15186232 L0.754978244,5.15186232 Z"  ></path>
										</g>
									</g>
								</g>
							</g>
						</g>
					</g>
				</g>
			</g>
		</svg>';

		for ( $i=1; $i <= $rating; $i++ ) { 
			$output .= $rating_star_filled;
		}
		
		if ( $rating != 5 ) {
			for ( $i=1; $i <= 5-$rating; $i++ ) { 
				$output .= $rating_star;
			}
		}
	}
	
	return $output;
}

function db_set_content_type() {
	return "text/html";
}

function db_send_contact_email() {
	$output = '';
	$db_author_email = ( isset($_POST['db_author']) ? sanitize_text_field($_POST['db_author']) : '' );
	$db_message = ( isset($_POST['db_message']) ? sanitize_text_field($_POST['db_message']) : '' );
	$db_name = ( isset($_POST['db_name']) ? sanitize_text_field($_POST['db_name']) : '' );
	$db_email = ( isset($_POST['db_email']) ? sanitize_text_field($_POST['db_email']) : '' );

	$subject = esc_html__( 'Contacting regarding your listing', 'directory-builder' );
	$message = esc_html__( 'Name:', 'directory-builder' ) . ' ' . $db_name . '<br />';
	$message .= esc_html__( 'Email:', 'directory-builder' ) . ' ' . $db_email . '<br />';
	$message .= esc_html__( 'Message:', 'directory-builder' ) . '<br />' . $db_message;

	add_filter( 'wp_mail_content_type','db_set_content_type' );
	add_filter( 'wp_mail_from_name', 'db_custom_wp_mail_from_name' );
	$maintenance_email = wp_mail( $db_author_email, $subject, $message );
	remove_filter( 'wp_mail_content_type','db_set_content_type' );
	remove_filter( 'wp_mail_from_name', 'db_custom_wp_mail_from_name' );
	
	if ( $maintenance_email ) {
		echo 'Your email was sent successfully!';
	} else {
		echo 'Something went wrong!';
	}

	die(0);
}
add_action( 'wp_ajax_db_send_contact_email', 'db_send_contact_email' );
add_action( 'wp_ajax_nopriv_db_send_contact_email', 'db_send_contact_email' );

add_action('init', 'db_check_form_actions');
function db_check_form_actions() {
	if( isset($_POST['login_user_email']) && $_POST['login_user_email'] != '' && isset($_POST['login_user_password']) && $_POST['login_user_password'] != '' ) {
		$db_user_login = esc_attr($_POST['login_user_email']);
		$user_password = esc_attr($_POST['login_user_password']);

		$user_creds = array(
			'user_login'    => $db_user_login,
			'user_password' => $user_password,
			'remember'      => true
		);

		global $db_user_login;
		$db_user_login = wp_signon( $user_creds );

		if ( !is_wp_error( $db_user_login ) ) {
			$user_validation = get_user_meta( $db_user_login->data->ID, 'db_validation', true );

			if ( $user_validation !== false && $user_validation != '' ) {
				if ( $user_validation !== 'validated' ) {
					wp_logout();
					$db_user_login = new WP_Error( 'pending_validation', __( "Your account is pending validation!", "directory-builder" ) );
				}
			}
		}

		if ( !is_wp_error( $db_user_login ) ) {
			if ( !isset($_GET['db-claim']) ) {
				$main_settings = get_option( 'db_main_settings', array() );
				wp_redirect( get_permalink( $main_settings['account_page_id'] ) );
			} else {
				header("Refresh:0");
			}
			exit;
		}
	}

	if ( isset($_POST['db-register-action']) ) {
		global $db_user_register;

		$user_name = esc_attr($_POST['db_registerusername']);
		$user_email = sanitize_email($_POST['db_registeremail']);
		$user_password = esc_attr($_POST['db_registerpassword']);
		$user_password_confirm = esc_attr($_POST['db_registerpasswordconfirm']);

		$valid_request = true;
		if ( isset( $_POST['g-recaptcha-response'] ) ) {
			$gcaptcha_options = get_option( 'gglcptch_options', array() );

			$gcaptcha_response = wp_remote_get( add_query_arg( array( 'secret' => $gcaptcha_options['private_key'], 'response' => $_POST['g-recaptcha-response'], 'remoteip' => filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP ) ), 'https://www.google.com/recaptcha/api/siteverify' ) );
			$gcaptcha_body = json_decode( $gcaptcha_response['body'], true );

			if ( !$gcaptcha_body['success'] ) {
				$db_user_register = new WP_Error( 'invalid', esc_html__('You failed the captcha test!', 'directory-builder') );
				$valid_request = false;
			}
		}
		
		if ( $valid_request ) {
			$db_user_register = wp_create_user( $user_name, $user_password, $user_email );
			if ( !is_wp_error( $db_user_register ) ) {
				wp_update_user( array( 'ID' => $db_user_register, 'role' => 'db_listing_author' ) );

				$replicated_fields = $_POST;
				unset($replicated_fields['db_registerusername']);
				unset($replicated_fields['db_registeremail']);
				unset($replicated_fields['db_registerpassword']);
				unset($replicated_fields['db_registerpasswordconfirm']);
				unset($replicated_fields['db-register']);
				if ( !empty($replicated_fields) ) {
					foreach ( $replicated_fields as $field_key => $field_value ) {
						update_user_meta( $db_user_register, $field_key, $field_value );
					}
				}

				$user_validation_code = wp_generate_password( 12, false );
				update_user_meta( $db_user_register, 'db_validation', $user_validation_code );

				$main_settings = get_option( 'db_main_settings', array() );
				if ( function_exists( 'db_send_notification_email' ) ) {
					db_send_notification_email( $db_user_register, 'new_user_confirm', array( 'username' => $user_name, 'url_confirm' => add_query_arg( array( 'user' => $db_user_register, 'validation' => $user_validation_code ), get_permalink( $main_settings['account_page_id'] ) ), 'source' => __('registration shortcode','directory-builder') ) );
				}

				// wp_signon( array( 'user_login' => $user_name, 'user_password' => $user_password, 'remember' => false ), false ); // Log the new user in

				if ( isset($_GET['db-claim']) ) {
					header("Refresh:0");
					exit;
				}
			}
		}
	}

	if ( isset($_POST['db-account-pass']) && isset($_POST['db-account-pass2']) && isset($_GET['key']) && isset($_GET['login']) ) {
		$key = esc_attr( $_GET['key'] );
		$login = esc_attr( $_GET['login'] );
		$pass1 = esc_attr( $_POST['db-account-pass'] );
		$pass2 = esc_attr( $_POST['db-account-pass2'] );
		global $db_lost_password;

		$key_check = check_password_reset_key( $key, $login );
			
		if ( is_wp_error( $key_check ) ) {
			$db_lost_password = '<p>' . esc_html__( 'We\'re sorry but there has been an error', 'directory-builder' ) . ': <strong>' . $key_check->get_error_message() . '</strong></p>';
		} else {
			if ( $pass1 != $pass2 ) {
				$db_lost_password = '<p>' . esc_html__( 'Your passwords didn\'t match!', 'directory-builder' ) . '</p>';
			} else {
				wp_update_user( array( 'ID' => $key_check->data->ID, 'user_pass' => $pass1 ) ); // Change user password
				wp_signon( array( 'user_login' => $key_check->data->user_login, 'user_password' => $pass1, 'remember' => false ), false ); // Log the new user in

				global $wpdb;
				$wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'ID' => $key_check->data->ID ) );

				$main_settings = get_option( 'db_main_settings', array() );
				wp_redirect( get_permalink( $main_settings['account_page_id'] ) );
				exit;
			}
		}
	}
}

function db_check_authorize_card( $card_data ) {
	require 'vendor/autoload.php';
	require 'auth_autoload.php';
}

function db_checkout_html( $package_data = array(), $claim_listing = false ) {
	$main_settings = get_option( 'db_main_settings');

	if ( is_string( $main_settings['payment_method'] ) ) {
		$main_settings['payment_method'] = str_split( $main_settings['payment_method'] );
	}

	$output = '
	<div class="db-main-checkout-wrapper db-dialog-animation"><div class="db-main-checkout" data-return="'.$main_settings['paypal_return_url'].'" data-success="'.get_permalink($main_settings['order_success_url']).'">
		<h1 class="db-checkout-title">'.__('Checkout', 'directory-builder').'<span class="db-checkout-close"><img src="'.DB_PLUGIN_URI.'/public/images/x.png" alt=""></span></h1>
		<p class="db-checkout-desc">'.__('Choose a payment option bellow and fill out the information', 'directory-builder').'</p>
		<div class="db-checkout-select">';
			if ( in_array('authorize.net', $main_settings['payment_method']) ) {
				$output .= '
				<div class="db-checkout-item active" data-type="credit-card">
					<img src="'.DB_PLUGIN_URI.'/public/images/credit-card.png" alt="">
					<span>'.__('Credit card', 'directory-builder').'</span>
				</div>';
			}
			if ( in_array('paypal', $main_settings['payment_method']) ) {
				$output .= '
				<div class="db-checkout-item '.(count($main_settings['payment_method'])==1?'active':'').'" data-type="paypal">
					<img src="'.DB_PLUGIN_URI.'/public/images/paypal.png" alt="">
					<span>'.__('PayPal', 'directory-builder').'</span>
				</div>';
			}
		$output .= '</div>';

		$billing_fields = '
		<div class="db-checkout-left">
			<h3>'.__('1. Billing information', 'directory-builder').'</h3>
			<div class="db-checkout-row">
				<span class="db-checkout-label">'.__('Full name *', 'directory-builder').'</span>
				<input type="text" class="db-checkout-field" name="x_full_name" placeholder="'.__('Full name *', 'directory-builder').'" required>
			</div>
			<div class="db-checkout-split two">
				<div class="db-checkout-row">
					<span class="db-checkout-label">'.__('Company name', 'directory-builder').'</span>
					<input type="text" class="db-checkout-field" name="x_company" placeholder="'.__('Company name', 'directory-builder').'">
				</div>
				<div class="db-checkout-row">
					<span class="db-checkout-label">'.__('Phone *', 'directory-builder').'</span>
					<input type="phone" class="db-checkout-field" name="x_phone" placeholder="'.__('Phone *', 'directory-builder').'" required>
				</div>
				<div class="db-checkout-row">
					<span class="db-checkout-label">'.__('Email *', 'directory-builder').'</span>
					<input type="email" class="db-checkout-field" name="x_email" placeholder="'.__('Email *', 'directory-builder').'" required>
				</div>
				<div class="db-checkout-row">
					<span class="db-checkout-label">'.__('Country *', 'directory-builder').'</span>
					<input type="text" class="db-checkout-field" name="x_country" placeholder="'.__('Country *', 'directory-builder').'" required>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="db-checkout-row">
				<span class="db-checkout-label">'.__('Address 1 *', 'directory-builder').'</span>
				<input type="text" class="db-checkout-field" name="x_address" placeholder="'.__('Address 1 *', 'directory-builder').'" required>
			</div>
			<div class="db-checkout-split two">
				<div class="db-checkout-row">
					<span class="db-checkout-label">'.__('City *', 'directory-builder').'</span>
					<input type="text" class="db-checkout-field" name="x_city" placeholder="'.__('City *', 'directory-builder').'" required>
				</div>
				<div class="db-checkout-row">
					<span class="db-checkout-label">'.__('State / County *', 'directory-builder').'</span>
					<input type="text" class="db-checkout-field" name="x_state" placeholder="'.__('State / County *', 'directory-builder').'" required>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="db-checkout-row">
				<span class="db-checkout-label">'.__('Postcode / ZIP *', 'directory-builder').'</span>
				<input type="text" class="db-checkout-field" name="x_zip" placeholder="'.__('Postcode / ZIP *', 'directory-builder').'" required>
			</div>';
			if ( $claim_listing ) {
				$billing_fields .= '<input type="hidden" name="db-claim-listing" value="true">';
			}
		$billing_fields .= '
		</div>';

		if ( in_array('authorize.net', $main_settings['payment_method']) ) {
			$output .= '
			<div class="db-checkout-option credit-card">
				<form id="authorize_form" method="post">
					'.$billing_fields.'
					<div class="db-checkout-right">
						<h3>'.__('2. Credit card info', 'directory-builder').'</h3>
						<div class="db-checkout-row">
							<span class="db-checkout-label">'.__('Name on card *', 'directory-builder').'</span>
							<input type="text" class="db-checkout-field" name="name_on_card" placeholder="'.__('Name on card *', 'directory-builder').'" required>
						</div>
						<div class="db-checkout-row">
							<span class="db-checkout-label">'.__('Card number *', 'directory-builder').'</span>
							<input type="text" class="db-checkout-field" name="x_card_num" placeholder="'.__('Card number *', 'directory-builder').'" required>
						</div>
						<div class="db-checkout-split three">
							<div class="db-checkout-row">
								<span class="db-checkout-label">'.__('CVV code *', 'directory-builder').'</span>
								<input type="text" class="db-checkout-field" name="x_cvv" placeholder="'.__('CVV code *', 'directory-builder').'" required>
							</div>
							<div class="db-checkout-row">
								<span class="db-checkout-label">'.__('Month *', 'directory-builder').'</span>
								<input type="text" class="db-checkout-field" name="x_month" placeholder="'.__('Month *', 'directory-builder').'" required>
							</div>
							<div class="db-checkout-row">
								<span class="db-checkout-label">'.__('Year *', 'directory-builder').'</span>
								<input type="text" class="db-checkout-field" name="x_year" placeholder="'.__('Year *', 'directory-builder').'" required>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="db-checkout-proceed">
							<input type="hidden" name="db-checkout" value="true">
							<input type="hidden" name="db-listing-id" value="'.get_the_ID().'">
							<input type="hidden" name="db-package-fee" value="">';
							if ( $main_settings['terms_and_conditions_status'] ) {
								$output .= '
								<div class="dt-form-row">
									<label for="db-agree-to-terms" class="dt-checkbox">
										<input type="checkbox" id="db-agree-to-terms" name="db-agree-to-terms" required="">'.esc_html__('I agree to all statements in', 'directory-builder').' <a href="javascript:void(0)" class="db-show-checkout-terms">'.esc_html__('terms and conditions', 'directory-builder').'</a>
										<div class="db-checkout-terms hidden">'.nl2br($main_settings['terms_and_conditions']).'</div>
									</label>
								</div>';
							}
							$output .= '
							<input type="submit" class="btn btn-primary" type="button" value="' . __('Pay with credit card', 'directory-builder') . '">
						</div>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>';
		}
		if ( in_array('paypal', $main_settings['payment_method']) ) {
			$output .= '
			<div class="db-checkout-option paypal" '.(count($main_settings['payment_method'])>1?'style="display: none;"':'').'>';
				if ( $main_settings['payment_mode'] == 'sandbox' ) {
					$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				} else {
					$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
				}
				$new_listing_id = 0;
				$output .=
				'<form id="paypal-gateway" action="' . $paypal_url . '" method="post">
					'.$billing_fields.'
					<div class="db-checkout-right">
						<h3>'.__('2. PayPal', 'directory-builder').'</h3>
						<div class="db-checkout-proceed">
							<input type="hidden" name="db-checkout" value="true">
							<input type="hidden" name="db-listing-id" value="'.get_the_ID().'">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="business" value="' . $main_settings['paypal_merchant_id'] . '">
							<input type="hidden" name="item_name" value="'.(isset($package_data['fee_label'])?$package_data['fee_label']:'').'">
							<input type="hidden" name="amount" value="'.(isset($package_data['fee_amount'])?$package_data['fee_amount']:'').'">
							<input type="hidden" name="no_shipping" value="1">
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="currency_code" value="' . $main_settings['default_currency'] . '">
							<input type="hidden" name="return" value="' . $main_settings['paypal_return_url'] . '">
							<input type="hidden" name="notify_url" value="' . get_permalink( $main_settings['add_page_id'] ) . '">
							<input type="hidden" name="custom" value="' . $new_listing_id . '">
							<input type="hidden" name="src" value="1">
							<input type="hidden" name="a3" value="'.(isset($package_data['fee_amount'])?$package_data['fee_amount']:'').'">
							<input type="hidden" name="p3" value="1">
							<input type="hidden" name="t3" value="M">';

							if ( $main_settings['terms_and_conditions_status'] ) {
								$output .= '
								<div class="dt-form-row">
									<label for="db-agree-to-terms" class="dt-checkbox">
										<input type="checkbox" id="db-agree-to-terms" name="db-agree-to-terms" required="">'.esc_html__('I agree to all statements in', 'directory-builder').' <a href="javascript:void(0)" class="db-show-checkout-terms">'.esc_html__('terms and conditions', 'directory-builder').'</a>
										<div class="db-checkout-terms hidden">'.nl2br($main_settings['terms_and_conditions']).'</div>
									</label>
								</div>';
							}
							$output .= '
							<input type="submit" class="btn btn-primary" type="button" value="' . __('Proceed to PayPal', 'directory-builder') . '">
						</div>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>';
		}
	$output .= '</div></div><div class="db-dialog-overlay"></div>';

	return $output;
}

function db_add_listing_shortcode( $db_edit_listing = false ) {
	$main_settings = get_option( 'db_main_settings');
	$listing_categories = wp_dropdown_categories( array(
				'taxonomy'      => 'listing_category',
				'hide_empty'    => 0,
				'orderby'       => 'name',
				'order'         => 'ASC',
				'name'          => 'listing_category',
				'echo'          => '0'
			) );
	global $wpdb;
	$register_message = $output = '';

	if ( isset($_GET['edit-listing']) ) {
		if ( is_user_logged_in() ) {
			$pre_listing_info = get_post( intval($_GET['edit-listing']) );

			if ( isset($pre_listing_info->post_author) && intval($pre_listing_info->post_author) === get_current_user_id() ) {
				$db_edit_listing = true;
			}
		}
	}

	if ( !$db_edit_listing ) {
		// Paypal IPN payment verification
		$post_input       = file_get_contents('php://input');
		$post_input_array = explode('&', $post_input);

		if ( $main_settings['payment_active'] == 'yes' && !empty($post_input) && $post_input_array[0] != 'wp_customize=on' && strpos($post_input_array['0'], 'listing_title') === false && strpos($post_input_array['0'], 'login_user_email') === false ) {
			include('paypal_ipn.php');
		}

		if ( $main_settings['payment_active'] == 'yes' && in_array('authorize.net', $main_settings['payment_method']) && !empty($_REQUEST['x_response_code']) ) {
			require_once('authorize_relay.php');
		}
	}

	$package_data = array();
	if ( isset($_POST['listing_title']) && !$db_edit_listing ) {
		global $db_user_login;
		$ready_to_post = false;

		if ( is_user_logged_in() ) {
			$logged_in_user = get_current_user_id();
			$ready_to_post = true;
		} else if ( $db_user_login ) {
			if ( is_wp_error( $db_user_login ) ) {
				$register_message = '<p>'.$db_user_login->get_error_message().'</p>';
			} else {
				$logged_in_user = $db_user_login->data->ID;
				$ready_to_post = true;
			}
		} else if ( isset($_POST['register_user_email']) && sanitize_email($_POST['register_user_email']) != '' ) {
			$user_email = sanitize_email($_POST['register_user_email']);
			$db_user_login = explode('@', $user_email);

			$register_errors = register_new_user($db_user_login['0'], $user_email);

			if ( !is_wp_error($register_errors) ) {
				$logged_in_user = $register_errors;
				$ready_to_post = true;
			} else {
				$register_message = '<p>'.$register_errors->get_error_message().'</p>';
			}
		}

		$listing_values = array(
			'post_author' => $logged_in_user,
			'post_content' => sanitize_text_field($_POST['listing_content']),
			'post_title' => sanitize_text_field($_POST['listing_title']),
			'post_excerpt' => sanitize_text_field($_POST['listing_excerpt']),
			'post_status' => $main_settings['new_post_status'],
			'post_type' => 'listings',
			'comment_status' => 'open',
			'post_parent' => 0,
			'menu_order' => 0,
		);

		if ( $ready_to_post ) {
			$new_listing_id = wp_insert_post($listing_values);

			if ( $new_listing_id ) {
				$all_listing_values = $_POST;
				unset($all_listing_values['listing_title']);
				unset($all_listing_values['listing_content']);
				unset($all_listing_values['listing_excerpt']);
				unset($all_listing_values['listing_category']);
				unset($all_listing_values['listing_featured_img']);

				if ( isset($all_listing_values['listing_featured_img']) && esc_url($all_listing_values['listing_featured_img']) != '' ) {
					// DB_Generate_Featured_Image( content_url().'/directory-uploads/'.$all_listing_values['listing_featured_img'], $new_listing_id );
				}  

				// Add all custom data to the post
				foreach ($all_listing_values as $listing_value_key => $listing_key_value) {
					add_post_meta( $new_listing_id, sanitize_text_field($listing_value_key), ( !is_array( $listing_key_value ) ? sanitize_text_field( $listing_key_value ) : db_sanitize_array( $listing_key_value ) ), true );
				}

				// Add category to the listing
				wp_set_object_terms( $new_listing_id, intval($_POST['listing_category']), 'listing_category' );

				// Package payment
				$package_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.intval($_POST['listing_package']).'"');
				if ( !empty($package_data) ) {
					$package_data = json_decode($package_data['0']->package_settings, true);
					if ( isset($package_data['listing_sticky']) && $package_data['listing_sticky'] === true ) {
						$sticky_listings = get_option('db_sticky_listings');
						if ( !isset($sticky_listings) || $sticky_listings == '' ) {
							$sticky_listings = array();
						}
						$sticky_listings[] = $new_listing_id;
						update_option('db_sticky_listings', $sticky_listings);
					}

					if ( $package_data['listing_run_type'] == 'forever' ) {
						$run_listing = __('Forever','directory-builder');
					} else {
						$run_listing = $package_data['listing_run_days'].' '.__('days','directory-builder');
					}

					// Add order info
					$order_data = array(
						'listing_package' => intval($_POST['listing_package']),
						'listing_package_name' => sanitize_text_field($package_data['fee_label']),
						'paid_amount' => $main_settings['default_currency_symbol'].$package_data['fee_amount'],
						'payment_history' => array(),
						'payment_status' => 'Processing',
						'category' => sanitize_text_field($_POST['listing_category']),
						'listing_run_type' => $package_data['listing_run_type'],
						'listing_run_days' => $package_data['listing_run_days'],
						'listing_sticky' => $package_data['listing_sticky'],
						'listing_expires' => 'Unknown'
					);
					add_post_meta( $new_listing_id, 'db_order_info', $order_data, true );
				} else {
					$output = '
					<div class="db-main-wrapper">
						<p>'.__('Your listing was successfully added, but your package couldn\'t be found!', 'directory-builder').'</p>
					</div>';
				}

				if ( $main_settings['db_theme_id'] == 'default' ) {
					$output .= db_checkout_html( $package_data );
				}

				// $payment_url = add_query_arg('db-payment', 'true', );
				$output .= '
				<script type="text/javascript">
				jQuery(document).ready(function($) {
					history.pushState({page: "'.get_permalink().'"}, "", "'.get_permalink().'");
				});
				</script>';

				return $output;
			} else {
				return '<div class="db-main-wrapper"><p>'.__('There was an issue while adding your listing!', 'directory-builder').'</p></div>';
			}
		}
	} else if ( isset($_POST['listing_title']) && $db_edit_listing ) {
		$db_listing = array(
			'ID'           => intval($_GET['edit-listing']),
			'post_title'  => esc_attr($_POST['listing_title']),
			'post_content' => esc_attr($_POST['listing_content']),
			'post_excerpt' => esc_attr($_POST['listing_excerpt'])
		);
		wp_update_post( $db_listing );

		$fields_to_save = $_POST;

		if ( isset($fields_to_save['listing_featured_img']) && $fields_to_save['listing_featured_img'] != '' ) {
			set_post_thumbnail( esc_attr($_GET['edit-listing']), $fields_to_save['listing_featured_img'] );
		}

		unset($fields_to_save['listing_title']);
		unset($fields_to_save['listing_content']);
		unset($fields_to_save['listing_excerpt']);
		unset($fields_to_save['listing_featured_img']);

		foreach ($fields_to_save as $field_key => $field_value) {
			update_post_meta( esc_attr($_GET['edit-listing']), sanitize_key($field_key), (!is_array($field_value)?sanitize_text_field($field_value):$field_value));
		}

		$success_message = __('Listing updated successfully!', 'directory-builder');
	}

	if ( $db_edit_listing ) {
		$listing_information = get_post( intval($_GET['edit-listing']) );
		$listing_address = get_post_meta( intval($_GET['edit-listing']) , 'listing_address', true);
		$listing_address_lat = get_post_meta( intval($_GET['edit-listing']) , 'listing_address_lat', true);
		$listing_address_lng = get_post_meta( intval($_GET['edit-listing']) , 'listing_address_lng', true);
	}

	$output = '<div class="db-main-wrapper">';
		if ( isset($success_message) ) {
			$output .= '<div class="db-info-message success"><p>'.$success_message.'</p></div>';
		}

		if ( !$db_edit_listing && $main_settings['db_theme_id'] != 'default' ) {
			$output .= db_checkout_html( $package_data );
		}

		$output .= '
		<form method="post" id="db-add-listing-form">';
			$output .= '
			<div class="db-field-row required">
				<label for="listing_title">'.__('Listing title', 'directory-builder').'</label>
				<input type="text" name="listing_title" id="listing_title" placeholder="'.__('Listing title', 'directory-builder').'" value="'.(isset($listing_information->post_title)?$listing_information->post_title:(isset($_POST['listing_title'])?sanitize_text_field($_POST['listing_title']):'')).'">
				<div class="db-field-meta">
					<span class="db-field-row-required">'.__('This field is required!', 'directory-builder').'</span>
				</div>
			</div>
			<div class="db-field-row listing_excerpt">
				<label for="listing_excerpt">'.__('Listing short description', 'directory-builder').'</label>
				<textarea name="listing_excerpt" placeholder="'.__('Listing short description', 'directory-builder').'" id="listing_excerpt">'.(isset($listing_information->post_excerpt)?$listing_information->post_excerpt:(isset($_POST['listing_excerpt'])?sanitize_text_field($_POST['listing_excerpt']):'')).'</textarea>
			</div>
			<div class="db-field-row listing_content">
				<label for="listing_content">'.__('Listing long description', 'directory-builder').'</label>
				<textarea name="listing_content" placeholder="'.__('Listing long description', 'directory-builder').'" id="listing_content">'.(isset($listing_information->post_content)?$listing_information->post_content:(isset($_POST['listing_content'])?sanitize_text_field($_POST['listing_content']):'')).'</textarea>';
				if ( $main_settings['allow_images'] ) {
					$output .= '<div class="db-field-meta"><span class="db-field-row-description">'.sprintf( __('To display gallery images in your listing, please put %s into the content, at the place where you want your gallery shown.', 'directory-builder'), '<strong>[directory_gallery]</strong>' ).'</span></div>';
				}
			$output .= '
			</div>';

			if ( !$db_edit_listing ) {
				if ( !defined('WHITELAB_CUSTOM_SELECT') ) {
					$output .= '
					<div class="db-field-row required">
						<label for="listing_address_lng">'.__('Listing category', 'directory-builder').'</label>
						'.$listing_categories.'
					</div>';
				} else {
					$term_settings = array(
						'taxonomy' => 'listing_category',
						'hide_empty' => false,
						'order' => 'asc',
						'orderby' => 'name'
					);

					$terms = get_terms( $term_settings );
					$categoryHierarchy = array();
					db_sort_terms_hierarchicaly($terms, $categoryHierarchy);

					$output .= '
					<div class="db-field-row required listing_category single-select">
						<input type="text" class="dt-custom-select"  placeholder="'.__('Category', 'directory-builder').'" readonly>
						<input type="hidden" class="dt-custom-select-value" id="listing_category" name="listing_category">
						<div class="dt-custom-select-container">
							<div class="dt-custom-select-inner">
								<div class="dt-custom-select-items">';
									if ( !empty($categoryHierarchy) ) {
										foreach ($categoryHierarchy as $cat_data) {
											$output .= '<div class="dt-custom-select-item" data-value="'.$cat_data->term_id.'">'.$cat_data->name.'</div>';
											if ( !empty($cat_data->children) ) {
												$output .= db_display_categories( $cat_data );
											}
										}
									}
								$output .= '
								</div>
								<div class="dt-custom-select-scrollbar-wrapper">
									<span class="dt-custom-select-scrollbar"></span>
								</div>
							</div>
						</div>
						<div class="db-field-meta">
							<span class="db-field-row-required">'.esc_html__('This field is required!', 'directory-builder').'</span>
						</div>
					</div>';
				}
			} else {
				$listing_featured_image = get_post_thumbnail_id(intval($_GET['edit-listing']));
				$listing_gallery_images = get_post_meta( intval($_GET['edit-listing']), 'listing_gallery_img', true );
			}
			
			$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_fields WHERE field_active="yes" ORDER BY field_order ASC');
			if ( !empty($field_list) ) {
				$default_location = $main_settings['default_location'];
				$default_location_lat = $main_settings['default_location_lat'];
				$default_location_lng = $main_settings['default_location_lng'];

				foreach ($field_list as $field_value) {
					$field_settings = json_decode($field_value->field_settings, true);

					$listing_field_default = '';
					if ( $db_edit_listing ) {
						$listing_field_default = get_post_meta( intval($_GET['edit-listing']), sanitize_text_field($field_settings['field_name']), true );
					}

					if ( $field_settings['field_name'] == 'listing_address' ) {
						$listing_field_default = $default_location;
					} else if ( $field_settings['field_name'] == 'listing_address_lat' ) {
						$listing_field_default = $default_location_lat;
					} else if ( $field_settings['field_name'] == 'listing_address_lng' ) {
						$listing_field_default = $default_location_lng;
					}

					if ( isset($_POST[$field_settings['field_name']]) ) {
						$listing_field_default = sanitize_text_field($_POST[$field_settings['field_name']]);
					}

					if ( $field_settings['field_name'] == 'listing_address' ) {
						$output .= '<div class="db-field-custom-row clearfix">';
					}

					if ( $field_settings['field_name'] == 'listing_address_lat' ) {
						$output .= '<div id="db-listing-map" style="width: calc(66.66% - 10px); height: 300px;"></div>';
						$output .= '<div class="db-map-row">';
					}

					$output .= db_get_custom_field( $field_settings, '', $listing_field_default, true );

					if ( $field_settings['field_name'] == 'listing_country' ) {
						$output .= '</div>';
					}

					if ( $field_settings['field_name'] == 'listing_address_lng' ) {
						$output .= '<a href="javascript:void(0)" class="db-set-address dt-button dt-button-invert">'.__('Set address on map', 'directory-builder').'</a>';
						$output .= '</div>';

						wp_enqueue_script( 'jquery.dropzone' );

						$output .= '<div class="db-field-upload-row-wrapper clearfix">';

						$output .= "
							<script type='text/javascript'>
							jQuery(document).ready(function($) {
								if ( jQuery('.dropzone-featured').length ) {
									jQuery('div.dropzone-featured').dropzone({
										url: db_main.ajaxurl,
										maxFiles: 1,
										acceptedFiles: '.jpg,.jpeg,.gif,.png',
										addRemoveLinks: true,
										dictRemoveFile: 'Remove image',
										thumbnailWidth: 150,
										thumbnailHeight: 150,
										init: function() {
											this.on('sending', function(file, xhr, formData) {
												formData.append('action', 'db_upload_images');
											});";

											if ( $db_edit_listing && isset($listing_featured_image) && $listing_featured_image != '' ) {
												$featured_image_url = wp_get_attachment_url($listing_featured_image);
												$featured_image_size = filesize(get_attached_file($listing_featured_image));

												$output .= "
												var mockFile = { 
													name: '".basename($featured_image_url)."', 
													size: '".$featured_image_size."', 
													type: 'image/jpeg', 
													status: Dropzone.ADDED, 
													url: '".$featured_image_url."' 
												};
												this.emit('addedfile', mockFile);
												this.emit('thumbnail', mockFile, '".$featured_image_url."');
												this.files.push(mockFile);";
											}
										$output .= "
										},
										success: function(file, response) {
											var parsed_response = jQuery.parseJSON(response);
											var current_image = jQuery(jQuery(this)['0'].files['0'].previewElement);
											if ( parsed_response.save_status == 'true' ) {
												current_image.addClass('dz-success').removeClass('dz-error');
												jQuery('[name=\"listing_featured_img\"]').val(parsed_response.attachment_id);
												current_image.attr('data-id', parsed_response.attachment_id);
											} else if ( parsed_response.save_status == 'false' ) {
												current_image.removeClass('dz-success').addClass('dz-error');
												current_image.find('.dz-error-message span').html(parsed_response.save_msg);
												current_image.attr('data-id', '0');
											}

										},
										removedfile: function(removed) {
											jQuery('[name=\"listing_featured_img\"]').val('');
											jQuery(removed.previewElement).remove();
										}
									});
								}

								if ( jQuery('.dropzone-gallery').length ) {
									jQuery('div.dropzone-gallery').dropzone({
										url: db_main.ajaxurl,
										maxFiles: 5,
										acceptedFiles: '.jpg,.jpeg,.gif,.png',
										addRemoveLinks: true,
										dictRemoveFile: 'Remove image',
										thumbnailWidth: 150,
										thumbnailHeight: 150,
										init: function() {
											this.on('sending', function(file, xhr, formData) {
												formData.append('action', 'db_upload_images');
											});";

											if ( $db_edit_listing && isset($listing_gallery_images) && $listing_gallery_images != '' ) {
												$featured_gallery_images = explode( '|', $listing_gallery_images );
												if ( !empty($featured_gallery_images) ) {
													$gallery_loops = 1;
													foreach ($featured_gallery_images as $gallery_image_id) {
														if ( $gallery_image_id == '' ) {
															continue;
														}

														$featured_gallery_image_url = wp_get_attachment_url($gallery_image_id);
														$featured_image_size = filesize(get_attached_file($gallery_image_id));

														$output .= "
														var mockFile".$gallery_loops." = { 
															name: '".basename($featured_gallery_image_url)."', 
															size: '".$featured_image_size."', 
															type: 'image/jpeg', 
															status: Dropzone.ADDED, 
															url: '".$featured_gallery_image_url."' 
														};
														this.emit('addedfile', mockFile".$gallery_loops.");
														this.emit('thumbnail', mockFile".$gallery_loops.", '".$featured_gallery_image_url."');
														this.emit('complete', mockFile".$gallery_loops.");
														this.files.push(mockFile".$gallery_loops.");";

														$gallery_loops++;
													}

													$output .= "
													var gallery_images = jQuery('[name=\"listing_gallery_img\"]').val().split('|');
													jQuery.each(gallery_images, function(gindex, gval) {
														var current_preview = jQuery(jQuery('[name=\"listing_gallery_img\"]').parent().find('.dz-preview').get(gindex));
														current_preview.attr('data-id', gval);
														current_preview.addClass('dz-success');
													});";
												}
											}
										$output .= "
										},
										success: function(file, response) {
											var parsed_response = jQuery.parseJSON(response);
											var image_count = jQuery('[name=\"listing_gallery_img\"]').val().split('|').length-1;
											console.log(image_count);
											var current_image = jQuery(jQuery(this)['0'].files[image_count].previewElement);

											if ( parsed_response.save_status == 'true' ) {
												current_image.addClass('dz-success').removeClass('dz-error');
												jQuery('[name=\"listing_gallery_img\"]').val(jQuery('[name=\"listing_gallery_img\"]').val()+parsed_response.attachment_id+'|');
												current_image.attr('data-id', parsed_response.attachment_id);
											} else if ( parsed_response.save_status == 'false' ) {
												current_image.removeClass('dz-success').addClass('dz-error');
												current_image.find('.dz-error-message span').html(parsed_response.save_msg);
												current_image.attr('data-id', '0');
											}
										},
										removedfile: function(removed) {
											var removed_image = jQuery(removed.previewElement);
											var current_images = jQuery('[name=\"listing_gallery_img\"]').val();
											if ( current_images.indexOf( removed_image.attr('data-id') + '|' ) >= 0 ) {
												jQuery('[name=\"listing_gallery_img\"]').val( current_images.replace( removed_image.attr('data-id') + '|', '' ) );
											}
											jQuery(removed.previewElement).remove();
										}
									});
								}
							});
							</script>";
							$output .= '<div class="db-field-upload-row">';
								$output .= '<h3>'.__('Featured image', 'directory-builder').'</h3>';
								$output .= '
								<div class="db-field-upload-container dropzone-upload dropzone-featured">
									<span class="db-upload-placeholder">'.__('Drag an image here or <a>browse</a> for the image to upload.', 'directory-builder').'</span>
									<div class="clearfix"></div>
									<input type="hidden" name="listing_featured_img" value="'.(isset($listing_featured_image)?$listing_featured_image:'').'">
								</div>
								<span class="db-file-upload-hint">'.__('JPG, GIF or PNG. Featured images are 1000x1000 pixels.', 'directory-builder').'</span>';
							$output .= '</div>';
							if ( $main_settings['allow_images'] ) {
								$output .= '<div class="db-field-upload-row">';
									$output .= '<h3>'.__('Gallery images', 'directory-builder').'</h3>';
									$output .= '
									<div class="db-field-upload-container dropzone-upload dropzone-gallery">
										<span class="db-upload-placeholder">'.__('Drag an image here or <a>browse</a> for the image to upload.', 'directory-builder').'</span>
										<div class="clearfix"></div>
										<input type="hidden" name="listing_gallery_img" value="'.(isset($listing_gallery_images)&&$listing_gallery_images!=''?(substr($listing_gallery_images, -1)!='|'?$listing_gallery_images.'|':$listing_gallery_images):'').'">
									</div>
									<span class="db-file-upload-hint">'.__('JPG, GIF or PNG. Featured images are 1000x1000 pixels.', 'directory-builder').'</span>';
								$output .= '</div>';
							}
							$output .= '<div class="clearfix"></div>';
						$output .= '</div>';
					}
				}
			}

			if ( !$db_edit_listing && !is_user_logged_in() ) {
				$register_setting = $main_settings['add_listing_register'];

				$login_required = (!$register_setting?' required':'');

				global $db_user_login;
				if ( !$register_setting && $db_user_login ) {
					if ( is_wp_error( $db_user_login ) ) {
						$register_message = '<p>'.$db_user_login->get_error_message().'</p>';
					}
				}

				$output .= '
				<div class="db-register-wrapper">'
					.$register_message.'
					<div class="db-register-login">';
						if ( !$register_setting ) {
							$output .= '
							<div class="db-field-row db-login-username">'
								. __('Already have an account? Go ahead and sign in now!', 'directory-builder').'
								<label class="db-field-row-label" for="register_user_email">'.__('Your username', 'directory-builder').'</label>
								<input type="text" name="login_user_email" placeholder="'.__('Your username', 'directory-builder').'"'.$login_required.'>
							</div>
							<div class="db-field-row">
								<label class="db-field-row-label" for="login_user_password">'.__('Your password', 'directory-builder').'</label>
								<input type="password" name="login_user_password" placeholder="'.__('Your password', 'directory-builder').'"'.$login_required.'>
								<input type="submit" name="db-sign-in" value="'.__('Sign in', 'directory-builder').'">
							</div>';
						}
					if ( $register_setting ) {
						$login_url = get_permalink($main_settings['login_page_id']);

						$reg_fields = array();
						if ( function_exists('db_get_registration_fields') ) {
							$reg_fields = db_get_registration_fields( 'add_listing' );
						}
						
						$output .= '
						<div class="db-field-row db-register-email">'.
							__('Already have an account? Go ahead and', 'directory-builder').' <a href="'.$login_url.'">'.__('sign in', 'directory-builder').'</a> '.__('now!', 'directory-builder').' '.
							__('Or you can simply register with your details below!', 'directory-builder');
							if ( !empty( $reg_fields ) ) {
								foreach ($reg_fields as $field_id => $field_settings) {
									$output .= '<div class="db-field-row'.($field_settings['field_type']=='select'?' single-select':'').'"><label class="db-field-row-label" for="'.$field_settings['field_name'].'">'.$field_settings['frontend_title'].'</label>';
									$output .= $field_settings['field_html'];
									$output .= '</div>';
								}
							}
						$output .= '
						</div>';
					}
				$output .= '
					</div>
				</div>';
			}

			$gcaptcha_options = get_option( 'gglcptch_options', array() );
			if ( function_exists( 'gglcptch_init' ) && isset( $gcaptcha_options['public_key'] ) && $gcaptcha_options['public_key'] != '' && isset( $gcaptcha_options['private_key'] ) && $gcaptcha_options['private_key'] != '' ) {
				$output .= '<div class="db-field-row"><h3>'.__('Are you human?', 'directory-builder').'</h3>' . do_shortcode( '[bws_google_captcha]' ) . '</div>';
			}

			if ( $main_settings['payment_active'] == 'yes' && !$db_edit_listing ) {
				$package_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages ORDER BY ID ASC');
				if ( !empty($package_list) ) {
					$output .= '<div class="db-field-row"><h3>'.__('Listing package', 'directory-builder').'</h3>';
					$output .= '<ul class="db-payment-packages">';

					$output .= '<li data-for="" style="display: none;width: 100%;">
							<p>Please select a category to see the available plans for it!</p>
						</li>';

					foreach ($package_list as $package_value) {
						$package_settings = json_decode($package_value->package_settings, true);
						$output .= '
						<li data-for="'.implode(',', isset($package_settings['apply_categories'])?$package_settings['apply_categories']:array()).'" class="'.($package_settings['listing_popular']?'popular':'').'" style="display: none;">
							<div class="db-package-inner">
								<label for="db-package-'.$package_value->ID.'"><input type="radio" id="db-package-'.$package_value->ID.'" name="listing_package" value="'.$package_value->ID.'"> '.$package_value->package_name.'</label>';
								if ( $package_settings['fee_description'] != '' ) {
									if ( $package_settings['listing_run_type'] == 'forever' ) {
										$run_listing = __('forever','directory-builder');
									} else {
										$run_listing = $package_settings['listing_run_days'].' '.__('days','directory-builder');
									}
									$active_ad_packages = db_get_ad_packages();
									if ( !defined('WHITELAB_CUSTOM_ADD_LISTING') ) {
										$output .= '<div class="db-fee-description">
											<span class="db-fee-status-description">'.$package_settings['fee_description'].'</span>
											<span class="db-fee-status-name">'.__('Package price','directory-builder').': '.$main_settings['default_currency_symbol'].$package_settings['fee_amount'].'</span>
											<span class="db-fee-status-name">'.__('Run listing for','directory-builder').': '.$run_listing.'</span>
											<span class="db-fee-status-name">'.__('Images allowed','directory-builder').': '.$package_settings['image_amount'].'</span>
											<span class="db-fee-status-name">'.__('Listing featured?','directory-builder').': '.$package_settings['listing_sticky'].'</span>';
											if ( in_array($package_value->ID, $active_ad_packages) ) {
												$output .= '<span class="db-fee-status-name">'.__('Includes advertisements','directory-builder').'</span>';
											}
										$output .= '
										</div>';
									} else {
										$output .= '
										<div class="db-fee-description">';
											if ( isset($package_settings['package_img']) && $package_settings['package_img'] != '' ) {
												$output .= '<img src="'.preg_replace('#^https?://#', '//', $package_settings['package_img']).'" class="db-fee-image">';
											}
											$output .= '
											<span class="db-fee-value">'.($package_settings['fee_amount']!='0'?$main_settings['default_currency_symbol'].$package_settings['fee_amount']:__('Free', 'directory-builder')).'</span>
											<span class="db-fee-description">'.$package_settings['fee_description'].'</span>';
											$output .= '<div class="db-package-desc">';
											if ( !isset($package_settings['payment_type']) || $package_settings['payment_type'] == 'onetime' ) {
												$output .= '<span class="db-fee-pay">'.__('One Time Payment','directory-builder').'</span>';
												$output .= '<span class="db-fee-run-for">'.__('Run listing for','directory-builder').' '.$run_listing.'</span>';
											} else if ( isset($package_settings['payment_type']) || $package_settings['payment_type'] == 'recurring' ) {
												if ( $package_settings['payment_interval'] == 1 ) {
													$payment_cycle = sprintf( __( 'Recurring payment once a %s', 'directory-builder' ), rtrim( $package_settings['payment_cycle'], 's' ) );
												} else {
													$payment_cycle = sprintf( __( 'Recurring payment every %d %s', 'directory-builder' ), $package_settings['payment_interval'], $package_settings['payment_cycle'] );
												}

												$output .= '<span class="db-fee-pay">'.$payment_cycle.'</span>';
											}
											$output .= '
											<span class="db-fee-images">'.$package_settings['image_amount'].' '.__('Images allowed','directory-builder').'</span>';
											if ( $package_settings['listing_sticky'] === true ) {
												$output .= '<span class="db-fee-sticky">'.__('Featured listing','directory-builder').'</span>';
											}
											if ( in_array($package_value->ID, $active_ad_packages) ) {
												$output .= '<span class="db-package-extra">'.__('Includes advertisements','directory-builder').'</span>';
											}
											$output .= '</div>';
										$output .= '
											<a href="javascript:void(0)" class="db-choose-package" data-id="'.$package_value->ID.'">'.__('Choose', 'directory-builder').'</a>
										</div>';
									}
								}
						$output .= '
							</div>   
						</li>';
					}
					$output .= '</ul><input type="hidden" name="db-active-package" value=""><div class="clearfix"></div></div>';
				} else {
					$output .= '<ul class="db-payment-packages">';

					$output .= '<li data-for="" style="width: 100%;">
							<p><strong>Please add some packages in the directory builder settings.</strong></p>
						</li>
						</ul>';
				}
			} elseif (($main_settings['payment_active'] == 'no' && !$db_edit_listing) || ($main_settings['payment_active'] == NULL && !$db_edit_listing)) {
				$output .= '<ul class="db-payment-packages">';

					$output .= '<li data-for="" style="width: 100%;">
							<p><strong>Payments are turned off in the settings, can\'t add listing. Please turn on payments in the directory builder settings.</strong></p>
						</li>
						</ul>';
			}

			if ( $main_settings['terms_and_conditions_status'] && !$db_edit_listing && $main_settings['db_theme_id'] != 'db_theme' ) {
				$output .= '<div class="db-field-row terms-and-conditions required">
					<label>'.__('Terms and conditions', 'directory-builder').'</label>
					<div class="db-terms-and-conditions">'.$main_settings['terms_and_conditions'].'</div>
					<label for="listing_terms_and_conditions"><input type="checkbox" id="listing_terms_and_conditions">'.__('I accept terms and conditions!', 'directory-builder').'</label>
				</div>';
			}

		$output .= '
			<input type="submit" value="'.(!$db_edit_listing?__('Add listing', 'directory-builder'):__('Save listing', 'directory-builder')).'" '.($db_edit_listing?'style="display: block;" class="db-edit-listing"':'').'>
		</form>';

	$output .= '</div>';

	return $output;
}
add_shortcode('directory_add_listing','db_add_listing_shortcode');

function db_get_ad_packages() {
	global $wpdb;
	$all_packages = $wpdb->get_results( 'SELECT packages FROM ' . $wpdb->prefix . 'directory_ads WHERE status="true"' );
	if ( !empty($all_packages) ) {
		$ad_packages = array();
		foreach ($all_packages as $package_value) {
			$current_ad_packages = json_decode( $package_value->packages, true );

			if ( !empty($current_ad_packages) ) {
				foreach ($current_ad_packages as $package_id) {
					$ad_packages[] = $package_id;
				}
			}
		}

		$all_packages = array_unique($ad_packages);
	}

	return $all_packages;
}

function db_sort_terms_hierarchicaly(Array &$cats, Array &$into, $parentId = 0) {
	foreach ($cats as $i => $cat) {
		if ($cat->parent == $parentId) {
			$into[$cat->term_id] = $cat;
			unset($cats[$i]);
		}
	}

	foreach ($into as $topCat) {
		$topCat->children = array();
		db_sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
	}
}

function db_display_categories( $cat_data, $active_categories = array() ) {
	$output = '';
	foreach ($cat_data->children as $child_value) {
		$parents = get_category_parents($child_value->term_id);
		$parents_exploded = explode('/', $parents);
		$depth = count($parents_exploded)-2;
		$depth_str = '';
		for ($i=0; $i < $depth; $i++) { 
			$depth_str .= '-';
		}

		$output .= '<div class="dt-custom-select-item child '.(in_array($child_value->term_id, $active_categories)?'active':'').'" data-value="'.$child_value->term_id.'" data-depth="'.$depth_str.' ">'.$child_value->name.'</div>';

		if ( !empty( $child_value->children ) ) {
			$output .= db_display_categories( $child_value );
		}
	}

	return $output;
}

function db_inspect_scripts() {
	global $wp_scripts;

	if ( !empty($wp_scripts->registered) ) {
		foreach ($wp_scripts->registered as $script_key => $script_value) {
			if ( strpos($script_value->src, 'maps.googleapis.com/maps') !== false && $script_key != 'db-google-maps' ) {
				wp_dequeue_script( $script_key );
			}
			
		}
	}
}
add_action( 'wp_print_scripts', 'db_inspect_scripts' );

function db_add_listing_columns( $columns_ ) {
	$columns = array();

	foreach ( $columns_ as $k => $v ) {
		$columns[ $k ] = $v;
		if ( $k == 'cb' ) {
			$columns['payment_status'] = __( 'Status', 'directory-builder' );
		} else if ( $k == 'title' ) {
			$columns['listing_address'] = __( 'Address', 'directory-builder' );
			$columns['listing_author'] = __( 'Author', 'directory-builder' );
		}
	}

	return $columns;
}
add_action( 'manage_listings_posts_columns', 'db_add_listing_columns' );

function db_add_listing_payment_column( $column_name, $listing_id ) {
	if ( $column_name == 'payment_status' ) {
		$listing_data = get_post_meta( $listing_id, 'db_order_info', true );
		$status_class = 'dbicon-info';
		$payment_status = (isset($listing_data['payment_status'])?$listing_data['payment_status']:'');
		
		if ( $payment_status == 'Pending' ) {
			$status_class = 'dbicon-cancel-circled2';
		} else if ( $payment_status == 'Completed' ) {
			$status_class = 'dbicon-ok-circled2';
		} else if ( $payment_status == 'Refunded' ) {
			$status_class = 'dbicon-cancel-circled2';
		}
		
		echo '<span class="db-listing-status '.$status_class.' '.strtolower($payment_status).'"></span><div class="row-actions"><span class="db-listing-payment-status">'.($payment_status?$payment_status:__('Processing', 'directory-builder')).'</span></div>';
	} else if ( $column_name == 'listing_author' ) {
		$post_data = get_post($listing_id);
		echo '<a href="'.admin_url('user-edit.php?user_id='.$post_data->post_author).'">'.get_the_author_meta('nicename', $post_data->post_author).'</a>';
	} else if ( $column_name == 'listing_address' ) {
		echo get_post_meta( $listing_id, 'listing_address', true );
	}
}
add_action( 'manage_listings_posts_custom_column', 'db_add_listing_payment_column', 10, 2 );

function db_change_package_func() {
	if ( !current_user_can('manage_options') ) die(0);

	$listing_id = ( isset($_POST['listing_id']) ? intval($_POST['listing_id']) : '' );
	$package_id = ( isset($_POST['package_id']) ? intval($_POST['package_id']) : '' );
	$package_name = ( isset($_POST['package_name']) ? sanitize_text_field($_POST['package_name']) : '' );

	if ( isset($package_id) && $package_id != '' ) {
		global $wpdb;
		$selected_package = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'directory_packages WHERE ID="'.$package_id.'"' );

		if ( !empty($selected_package) ) {
			$package_settings = json_decode( $selected_package['0']->package_settings, true );
			$listing_info = get_post_meta( $listing_id, 'db_order_info', true );
			$main_settings = get_option( 'db_main_settings');

			$listing_info['listing_package'] = $package_id;
			$listing_info['listing_package_name'] = $package_name;
			$listing_info['paid_amount'] = $main_settings['default_currency_symbol'].$package_settings['fee_amount'];

			if ( update_post_meta( $listing_id, 'db_order_info', $listing_info ) ) {
				echo '{"save_response": "0", "package_name": "'.$package_name.'", "paid": "'.$main_settings['default_currency_symbol'].$package_settings['fee_amount'].'"}';
			} else {
				echo '{"save_response": "failed"}';
			}
		} else {
			echo '{"save_response": "failed"}';
		}
	}

	die(0);
}
add_action( 'wp_ajax_db_change_package', 'db_change_package_func' );

function db_change_expiration_func() {
	if ( !current_user_can('manage_options') ) die(0);

	$listing_id = ( isset($_POST['listing_id']) ? intval($_POST['listing_id']) : '' );
	$new_date = ( isset($_POST['new_date']) ? sanitize_text_field($_POST['new_date']) : '' );

	$listing_info = get_post_meta( $listing_id, 'db_order_info', true );
	global $wpdb;
	$save_expiration = false;

	$listing_info['listing_expires'] = strtotime($new_date);
	$save_expiration = update_post_meta( $listing_id, 'db_order_info', $listing_info );

	if ( $save_expiration ) {
		echo '{"save_response": "0", "package_name": "'.date( get_option('date_format'), $listing_info['listing_expires']).'"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_change_expiration', 'db_change_expiration_func' );

function db_check_my_profile_form() {
	global $update_message;

	if ( isset($_POST['action']) && sanitize_key($_POST['action']) == 'edit-profile' ) {
		$user_new_data = array(
			'ID' => get_current_user_id(),
			'display_name' => sanitize_text_field($_POST['display_name']),
			'user_email' => sanitize_email($_POST['user_email'])
			);

		$proceed_with_update = true;
		if ( isset($_POST['user_password']) && $_POST['user_password'] != '' ) {
			if ( isset($_POST['user_conf_password']) && $_POST['user_password'] == $_POST['user_conf_password'] ) {
				$user_new_data['user_pass'] = $_POST['user_password'];
			} else {
				$update_message = '<span class="db-update-message error">'.__('Passwords did not match!', 'directory-builder').'</span>';
				$proceed_with_update = false;
			}
		}

		if ( $proceed_with_update ) {
			$user_update = wp_update_user( $user_new_data );

			if ( is_wp_error( $user_update ) ) {
				$update_message = '<span class="db-update-message error">'.$user_update->get_error_message().'</span>';
			} else {
				$update_message = '<span class="db-update-message success">'.__('Your profile was successfully updated!', 'directory-builder').'</span>';
			}
		}
	}
}
add_action('init', 'db_check_my_profile_form');

function db_account_shortcode( $atts, $content = null ) {
	$main_settings = get_option( 'db_main_settings');

	$output = '<div class="db-main-wrapper">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">';
	if ( !is_user_logged_in() ) {
		if ( isset($_GET['key']) ) {
			$key_check = check_password_reset_key($_GET['key'], $_GET['login']);
			
			if ( is_wp_error($key_check) ) {
				return '<p class="aligncenter">' . esc_html__( 'We\'re sorry but there has been an error', 'directory-builder' ) . ': <strong>' . $key_check->get_error_message() . '</strong></p>';
			} else {
				global $db_lost_password;
				$output .= '
				<p class="aligncenter">' . esc_html__( 'Please enter your new password!', 'directory-builder' ) . '</p>
				<form method="post" class="db-account-lost-pass">
					'.$db_lost_password.'
					<input type="password" name="db-account-pass" placeholder="'.esc_html__('Password', 'directory-builder').'" required>
					<input type="password" name="db-account-pass2" placeholder="'.esc_html__('Confirm password', 'directory-builder').'" required>
					<input type="submit" value="'.esc_html__('Change', 'directory-builder').'">
				</form>';
			}
		} else if ( isset($_GET['validation']) ) {
			$actual_validation_code = get_user_meta( intval($_GET['user']), 'db_validation', true );
			if ( $actual_validation_code === esc_attr($_GET['validation']) ) {
				update_user_meta( intval($_GET['user']), 'db_validation', 'validated' );

				$main_settings = get_option( 'db_main_settings', array() );
				if ( function_exists( 'db_send_notification_email' ) ) {
					db_send_notification_email( intval($_GET['user']), 'new_user', array( 'username' => get_user_meta( intval($_GET['user']), 'nickname', true ), 'url_dashboard' => get_permalink( $main_settings['account_page_id'] ) ) );
				}

				echo '<p class="aligncenter">' . esc_html__( 'You successfully validated your email and can now login to your account!', 'directory-builder' ) . '</p>';
			} else {
				echo '<p class="aligncenter">' . esc_html__( 'The validation code for your account seems to be invalid!!', 'directory-builder' ) . '</p>';
			}
		} else {
			$output .= '<p>'.__('Only logged in users can access this page!', 'directory-builder').'</p>';
		}
	} else {
		global $wpdb;
		if ( !isset($_GET['edit-listing']) ) {
			$listing_limit = '6';
			if ( isset($_GET['my-listings']) ) {
				if ( !isset( $_GET['db-page'] ) || intval( $_GET['db-page'] ) == 1 ) {
					$listing_limit = '25';
				} else {
					$listing_limit = (intval( $_GET['db-page'] )-1)*25 . ', 25';
				}
			}
			$user_listings = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE post_type="listings" && ( post_status != "auto-draft" && post_status != "trash" ) && post_author="'.get_current_user_id().'" ORDER BY id DESC LIMIT '.$listing_limit);
		} else {
			$user_listings = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE id="'.intval($_GET['edit-listing']).'" && post_author="'.get_current_user_id().'" ORDER BY id DESC');
		}

		$users_are_allowed = $main_settings['users_are_allowed'];

		wp_enqueue_script( 'jquery.mo' );

		$output .= '
		<div class="db-account-wrapper">
		<ul class="db-account-menu">
			<li><a href="'.get_permalink().'" class="'.(empty($_GET)?'active':'').'">'.__('Tableau de bord', 'directory-builder').'</a></li>
			<li><a href="'.add_query_arg('my-profile', '', get_permalink()).'" class="'.(isset($_GET['my-profile'])?'active':'').'">'.__('Modifier profil', 'directory-builder').'</a></li>';
			if ( $main_settings['add_page_id'] != '' ) {
				$output .= '<li><a href="'.get_permalink($main_settings['add_page_id']).'">'.__('Ajouter nouveau membre', 'directory-builder').'</a></li>';
			}
			$output .= '
			<li><a href="'.add_query_arg('my-listings', '', get_permalink()).'" class="'.(isset($_GET['my-listings'])?'active':'').'">'.__('Ma liste', 'directory-builder').'</a></li>
			<li><a href="'.add_query_arg('my-favorites', '', get_permalink()).'" class="'.(isset($_GET['my-favorites'])?'active':'').'">'.__('Mes favoris', 'directory-builder').'</a></li>
			<li><a href="'.wp_logout_url( home_url( '/' ) ).'" class="db-logout dt-button dt-button-danger dt-button-middle">'.__('Déconnexion', 'directory-builder').'</a></li>
		</ul>';

		if ( !isset($_GET['my-listings']) && !isset($_GET['my-favorites']) && !isset($_GET['edit-listing']) && !isset($_GET['my-profile']) ) {
			$output .= '<p class="db-account-intro">'.__('Bienvenue sur votre tableau de bord! De là, vous pouvez gérer toutes vos listes, vérifier vos favoris et modifier votre profil.', 'directory-builder').'</p>';

			$user_data = get_userdata(get_current_user_id());
			$output .= '
			<h2 class="db-account-title">'.__('Profil', 'directory-builder').'</h2>
			<div class="db-account-profile-intro">
				<span class="db-account-row">
					<span class="db-account-label">'.__('Username', 'directory-builder').':</span>
					<span class="db-account-value">'.$user_data->data->display_name.'</span>
				</span>
				<span class="db-account-row">
					<span class="db-account-label">'.__('Email', 'directory-builder').':</span>
					<span class="db-account-value">'.$user_data->data->user_email.'</span>
				</span>
				<span class="db-account-row">
					<span class="db-account-label">'.__('Mot de passe', 'directory-builder').':</span>
					<span class="db-account-value">**********</span>
				</span>
				<a href="'.add_query_arg('my-profile', '', get_permalink()).'">'.__('Modifier profil', 'directory-builder').'</a>
				<div class="clearfix"></div>
			</div>';
		}
		
		if ( !isset($_GET['edit-listing']) && !isset($_GET['my-profile']) ) {
			if ( !isset($_GET['my-favorites']) && !empty($user_listings) ) {
				$output .= db_checkout_html();
				$output .= '
				<h2 class="db-account-title">'.__('liste', 'directory-builder').'</h2>
				<table class="db-account-listings table table-striped table-hover">
					<thead>
						<tr>
							<th style="width: 28.6%;">'.__('Nom', 'directory-builder').'</th>
							<th style="width: 12.5%;">'.__('Statut', 'directory-builder').'</th>
							<th style="width: 15%;">'.__('Package', 'directory-builder').'</th>
							<th style="width: 20%;">'.__('Expire le', 'directory-builder').'</th>
							<th style="width: 10%;">'.__('Sticky', 'directory-builder').'</th>
							<th style="width: 15%;"></th>
						</tr>
					</thead>
					<tbody>';
						$listing_loop = 1;
						foreach ($user_listings as $listing_data) {
							$order_options = get_post_meta( $listing_data->ID, 'db_order_info', true );
							if ( $order_options == '' ) {
								$order_options = array();
							}
							$ratings = get_post_meta( $listing_data->ID, 'listing_ratings', true);
							if ( $ratings == '' ) {
								$rating_stars = '<i class="dbicon-star-empty"></i><i class="dbicon-star-empty"></i><i class="dbicon-star-empty"></i><i class="dbicon-star-empty"></i><i class="dbicon-star-empty"></i>';
							} else {
								$listing_rating = 0;
								foreach ($ratings as $rating_value) {
									$listing_rating += $rating_value;
								}
								$listing_rating = $listing_rating/count($ratings);
								$rating_stars = db_get_rating_stars(round($listing_rating, 0, PHP_ROUND_HALF_DOWN));
							}

							if ( isset($order_options['listing_package']) ) {
								$package_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.$order_options['listing_package'].'"');
								if ( !empty($package_list) ) {
									$field_settings = json_decode($package_list['0']->package_settings, true);

									if ( $field_settings['listing_run_type'] == 'forever' ) {
										$listing_expiration = __('Never', 'directory-builder');
									} else if ( $field_settings['listing_run_type'] == 'days' && isset($order_options['listing_expires']) && $order_options['listing_expires'] != 'Unknown' ) {
										$listing_expiration = date( get_option('date_format'), $order_options['listing_expires']);
									} else {
										$listing_expiration = __('Unknown', 'directory-builder');
									}

									$package_amount = $field_settings['fee_amount'];
									$package_run_type = $field_settings['listing_run_type'];
								}
							} else {
								$listing_expiration = __('Unknown', 'directory-builder');
							}

							$sticky_listings = get_option('db_sticky_listings', array());
							$refunds = get_post_meta( $listing_data->ID, 'db_refunds', true );
							$refunds = is_array($refunds) ? array_reverse($refunds) : '';

							$output .= '
							<tr>
								<td>'.$listing_data->post_title.'</td>
								<td class="db-align-center db-status">'.(isset($order_options['payment_status'])&&$order_options['payment_status']=='Refunded'&&!empty($refunds)&&$refunds['0']['reason']!=''?'<span class="db-account-listing-option-hover">'.__('Reason', 'directory-builder').': '.$refunds['0']['reason'].'</span>':'').(isset($order_options['payment_status'])?$order_options['payment_status']:$listing_data->post_status).'</td>
								<td class="db-align-center">'.(isset($order_options['listing_package_name'])?$order_options['listing_package_name']:__('Unknown', 'directory-builder')).'</td>
								<td class="db-align-center">'.$listing_expiration.'</td>
								<td class="db-align-center">'.(in_array($listing_data->ID, $sticky_listings)?__('Yes', 'directory-builder'):__('No', 'directory-builder')).'</td>
								<td>';
									if ( isset($order_options['completed_on']) && is_numeric($order_options['completed_on']) && $package_amount != '0' && $package_run_type == 'days' ) {
										$output .= '<a href="javascript:void(0)" data-id="'.$order_options['listing_package'].'" data-list-id="'.$listing_data->ID.'" class="db-account-listing-option renew"><span class="db-account-listing-option-hover">'.esc_html__('Renew', 'directory-builder').'</span><svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g   transform="translate(-1125.000000, -858.000000)" fill="#247BA0"><g id="listings" transform="translate(149.000000, 683.000000)"><g id="add" transform="translate(951.000000, 123.000000)"><g   transform="translate(25.000000, 52.000000)"><g id="Group"><path d="M13.5826638,0 L3.09598309,0 C2.87399577,0 2.69640592,0.177589852 2.69640592,0.399577167 L2.69640592,10.8862579 C2.69640592,11.1082452 2.87399577,11.2858351 3.09598309,11.2858351 L13.5826638,11.2858351 C13.8046512,11.2858351 13.982241,11.1082452 13.982241,10.8862579 L13.982241,0.399577167 C13.982241,0.177589852 13.8046512,0 13.5826638,0 L13.5826638,0 Z M13.1830867,10.4866808 L3.49556025,10.4866808 L3.49556025,0.799154334 L13.1830867,0.799154334 L13.1830867,10.4866808 L13.1830867,10.4866808 L13.1830867,10.4866808 Z"  ></path><path d="M10.8862579,13.1830867 L0.799154334,13.1830867 L0.799154334,3.09598309 C0.799154334,2.87399577 0.621564482,2.69640592 0.399577167,2.69640592 C0.177589852,2.69640592 0,2.87399577 0,3.09598309 L0,13.5826638 C0,13.8046512 0.177589852,13.982241 0.399577167,13.982241 L10.8862579,13.982241 C11.1082452,13.982241 11.2858351,13.8046512 11.2858351,13.5826638 C11.2858351,13.3606765 11.1082452,13.1830867 10.8862579,13.1830867 L10.8862579,13.1830867 Z"  ></path><path d="M6.07357294,6.04397463 L7.93826638,6.04397463 L7.93826638,7.90866808 C7.93826638,8.13065539 8.11585624,8.30824524 8.33784355,8.30824524 C8.55983087,8.30824524 8.73742072,8.13065539 8.73742072,7.90866808 L8.73742072,6.04397463 L10.605074,6.04397463 C10.8270613,6.04397463 11.0046512,5.86638478 11.0046512,5.64439746 C11.0046512,5.42241015 10.8270613,5.2448203 10.605074,5.2448203 L8.73742072,5.2448203 L8.73742072,3.37716702 C8.73742072,3.1551797 8.55983087,2.97758985 8.33784355,2.97758985 C8.11585624,2.97758985 7.93826638,3.1551797 7.93826638,3.37716702 L7.93826638,5.2448203 L6.07357294,5.2448203 C5.85158562,5.2448203 5.67399577,5.42241015 5.67399577,5.64439746 C5.67399577,5.86638478 5.85158562,6.04397463 6.07357294,6.04397463 L6.07357294,6.04397463 Z"  ></path></g></g></g></g></g></g></svg></a>';
									}

									$view_text = '';
									$view_url = '#';
									if ( $listing_data->post_status == 'publish' ) {
										$view_text = __('View', 'directory-builder');
										$view_url = get_permalink($listing_data->ID);
									} else {
										$view_text = __('Preview', 'directory-builder');
										$view_url = add_query_arg('preview', 'true', get_permalink($listing_data->ID));
									}

									if ( $listing_data->post_status != 'pending' ) {
										$output .= '
										<a href="'.$view_url.'" class="db-account-listing-option view">
											<span class="db-account-listing-option-hover">Voir</span>
											<svg width="18px" height="12px" viewBox="0 0 18 12" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g   transform="translate(-1164.000000, -859.000000)" fill="#53666D"><g id="listings" transform="translate(149.000000, 683.000000)"><g id="eye-copy" transform="translate(1008.000000, 166.000000)"><g id="eye-(2)" transform="translate(7.000000, 10.000000)"><g id="Layer_1"><g id="Group"><path d="M17.9640352,5.82672414 C16.4323125,2.29437931 12.9136289,0.011862069 9,0.011862069 C5.08637109,0.011862069 1.56775781,2.29431034 0.0359648437,5.82672414 C-0.0119882812,5.93727586 -0.0119882812,6.06213793 0.0359648437,6.17268966 C1.56765234,9.70544828 5.08630078,11.9881379 9,11.9881379 C12.9138047,11.9881379 16.432418,9.70544828 17.9640352,6.17268966 C18.0119883,6.06213793 18.0119883,5.93727586 17.9640352,5.82672414 L17.9640352,5.82672414 Z M9,11.1042069 C5.51271094,11.1042069 2.37104297,9.10689655 0.942503906,5.99975862 C2.37107813,2.89293103 5.51281641,0.895827586 9,0.895827586 C12.4872539,0.895827586 15.628957,2.89293103 17.0574961,5.99968966 C15.628957,9.10682759 12.4872891,11.1042069 9,11.1042069 L9,11.1042069 Z"  ></path><path d="M9,2.61465517 C7.09685156,2.61465517 5.54857031,4.13331034 5.54857031,5.99996552 C5.54857031,7.86662069 7.09688672,9.38527586 9,9.38527586 C10.9031133,9.38527586 12.4514297,7.86665517 12.4514297,5.99996552 C12.4514297,4.13327586 10.9031133,2.61465517 9,2.61465517 L9,2.61465517 Z M9,8.50141379 C7.59382031,8.50141379 6.44976563,7.37927586 6.44976563,6.00003448 C6.44976563,4.6207931 7.59382031,3.49865517 9,3.49865517 C10.4061797,3.49865517 11.5502344,4.6207931 11.5502344,6.00003448 C11.5502344,7.37927586 10.4061797,8.50141379 9,8.50141379 L9,8.50141379 Z"  ></path><path d="M9,4.20268966 C7.98964453,4.20268966 7.16755078,5.00896552 7.16755078,6.00003448 C7.16755078,6.24410345 7.36924219,6.442 7.61814844,6.442 C7.86705469,6.442 8.06874609,6.24410345 8.06874609,6.00003448 C8.06874609,5.49637931 8.48647266,5.08662069 9,5.08662069 C9.24890625,5.08662069 9.45059766,4.88872414 9.45059766,4.64465517 C9.45059766,4.40051724 9.24883594,4.20268966 9,4.20268966 L9,4.20268966 Z"  ></path></g></g></g></g></g></g></g></svg>
										</a>';
									}
									
									if ( in_array('delete', $users_are_allowed) ) {
										$output .= '
										<a href="javascript:void(0)" class="db-delete-listing db-account-listing-option delete" data-id="'.$listing_data->ID.'">
											<span class="db-account-listing-option-hover">'.__('Supprimer', 'directory-builder').'</span>
											<svg width="11px" height="14px" viewBox="0 0 11 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g   transform="translate(-1208.000000, -858.000000)" fill="#53666D"><g id="listings" transform="translate(149.000000, 683.000000)"><g id="rubbish-bin-copy" transform="translate(1049.000000, 166.000000)"><g   transform="translate(10.000000, 9.000000)"><g id="Group"><path d="M10.0372757,1.64692387 L8.1821876,1.64692387 L8.1821876,0.433385806 C8.1821876,0.189117419 7.98646656,0 7.7438385,0 C7.72029527,0 7.7045938,0.00791225806 7.69693148,0.0158064516 C7.68907178,0.00791225806 7.67337031,0 7.66552855,0 L3.30559869,0 L3.2743752,0 L3.24297227,0 C3.00034421,0 2.81248287,0.189117419 2.81248287,0.433385806 L2.81248287,1.64694194 L0.949553018,1.64694194 C0.417192496,1.64694194 0.00238662316,2.06452129 0.00238662316,2.60044129 L0.00238662316,3.29388387 L0.00238662316,4.16063742 L0.824300163,4.16063742 L0.824300163,13.0411535 C0.824300163,13.5770916 1.23126427,13.9867587 1.7636248,13.9867587 L9.22322186,13.9867587 C9.75558238,13.9867587 10.1703703,13.5770916 10.1703703,13.0411535 L10.1703703,4.16063742 L10.9844421,4.16063742 L10.9844421,3.29388387 L10.9844421,2.60044129 C10.9844421,2.06452129 10.5694747,1.64692387 10.0372757,1.64692387 L10.0372757,1.64692387 Z M3.67347961,0.866753548 L7.3133491,0.866753548 L7.3133491,1.64692387 L3.67347961,1.64692387 L3.67347961,0.866753548 L3.67347961,0.866753548 Z M9.30153181,13.0411716 C9.30153181,13.0964671 9.27798858,13.1199871 9.22322186,13.1199871 L1.7636248,13.1199871 C1.70885808,13.1199871 1.68531485,13.096449 1.68531485,13.0411716 L1.68531485,4.16061935 L9.30153181,4.16061935 L9.30153181,13.0411716 L9.30153181,13.0411716 Z M10.1156036,3.29386581 L0.871225122,3.29386581 L0.871225122,2.60042323 C0.871225122,2.54527226 0.894768352,2.51367742 0.949535073,2.51367742 L10.0372757,2.51367742 C10.0920604,2.51367742 10.1156036,2.54527226 10.1156036,2.60042323 L10.1156036,3.29386581 L10.1156036,3.29386581 Z"  ></path><rect id="Rectangle-path" x="7.0707031" y="5.17716387" width="0.868838499" height="7.17056516"></rect><rect id="Rectangle-path" x="5.06683687" y="5.17716387" width="0.868838499" height="7.17056516"></rect><rect id="Rectangle-path" x="3.06295269" y="5.17716387" width="0.868838499" height="7.17056516"></rect></g></g></g></g></g></g></svg>
										</a>';
									}
									if ( in_array('edit', $users_are_allowed) ) {
										$output .= '
										<a href="'.add_query_arg('edit-listing', $listing_data->ID, get_permalink($main_settings['add_page_id'])).'" class="db-edit-listing db-account-listing-option edit" data-id="'.$listing_data->ID.'">
											<span class="db-account-listing-option-hover">'.__('Modifier', 'directory-builder').'</span>
											<svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g   transform="translate(-1248.000000, -858.000000)" fill="#53666D"><g id="listings" transform="translate(149.000000, 683.000000)"><g id="edit-copy" transform="translate(1090.000000, 166.000000)"><g   transform="translate(9.000000, 9.000000)"><path d="M13.0745404,0.905621277 C11.8711362,-0.300761702 9.91411489,-0.300761702 8.71071064,0.905621277 L0.709859574,8.90349362 C0.647306383,8.96604681 0.608582979,9.04647234 0.596668085,9.13285532 L0.00390212766,13.5234936 C-0.0139702128,13.6486 0.0307106383,13.7737064 0.117093617,13.8600894 C0.191561702,13.9345574 0.295817021,13.9792383 0.40007234,13.9792383 C0.417944681,13.9792383 0.435817021,13.9792383 0.453689362,13.9762596 L3.09879574,13.6188128 C3.31922128,13.5890255 3.47411489,13.3864723 3.44432766,13.1660468 C3.41454043,12.9456213 3.21198723,12.7907277 2.9915617,12.8205149 L0.870710638,13.1064723 L1.28475319,10.0443447 L4.50773191,13.2673234 C4.5822,13.3417915 4.68645532,13.3864723 4.79071064,13.3864723 C4.89496596,13.3864723 4.99922128,13.3447702 5.07368936,13.2673234 L13.0745404,5.26945106 C13.6583702,4.68562128 13.9800723,3.91115319 13.9800723,3.08604681 C13.9800723,2.26094043 13.6583702,1.48647234 13.0745404,0.905621277 L13.0745404,0.905621277 Z M8.86560426,1.8886 L10.2090085,3.23200426 L2.90815745,10.5328553 L1.56475319,9.18945106 L8.86560426,1.8886 L8.86560426,1.8886 Z M4.79368936,12.4154085 L3.48007234,11.1017915 L10.7809234,3.80094043 L12.0945404,5.11455745 L4.79368936,12.4154085 L4.79368936,12.4154085 Z M12.6545404,4.53966383 L9.44049787,1.32562128 C9.84858298,0.989025532 10.3579447,0.804344681 10.8941149,0.804344681 C11.5047532,0.804344681 12.0766681,1.04264255 12.508583,1.47157872 C12.9404979,1.90051489 13.175817,2.47540851 13.175817,3.08604681 C13.175817,3.62519574 12.9911362,4.13157872 12.6545404,4.53966383 L12.6545404,4.53966383 Z"  ></path></g></g></g></g></g></svg>
										</a>';
									}
									$output .= ' ';
								$output .= '    
								</td>
							</tr>';
							if ( $listing_loop == 5 && !isset($_GET['my-listings']) ) {
								break;
							}
							$listing_loop++;
						}
						$output .= '
					</tbody>
				</table>';
				if ( count($user_listings) > 5 && !isset($_GET['my-listings']) ) {
					$output .= '<a href="'.add_query_arg('my-listings', '', get_permalink()).'" class="db-see-all-listing dt-button dt-button-invert">'.__('Voir tout', 'directory-builder').'</a><div class="clearfix"></div>';
				} else if ( isset($_GET['my-listings']) ) {
					$total_listings = $wpdb->get_results('SELECT count(ID) as count FROM '.$wpdb->posts.' WHERE post_type="listings" && ( post_status != "auto-draft" && post_status != "trash" ) && post_author="'.get_current_user_id().'"');
					$total_pages = $total_listings['0']->count/25;

					$output .= '<div class="navigation paging-navigation">' . paginate_links( array(
						'format' => '?db-page=%#%',
						'total' => ( is_float( $total_pages ) ? ceil( $total_pages ) : round( $total_pages ) ),
						'current' => ( isset( $_GET['db-page'] ) ? intval( $_GET['db-page'] ) : 1 ),
						'prev_text' => '',
						'next_text' => '',
					) ) . '</div>';
				}
			}
			if ( !isset($_GET['my-listings']) ) {
				$favorite_limit = '3';
				if ( isset($_GET['my-favorites']) ) {
					if ( !isset( $_GET['db-page'] ) || intval( $_GET['db-page'] ) == 1 ) {
						$favorite_limit = '25';
					} else {
						$favorite_limit = (intval( $_GET['db-page'] )-1)*25 . ', 25';
					}
				}
				$output .= '
				<div class="db-account-favorites"'.(isset($_GET['my-favorites'])?' style="margin-top: 0;"':'').'>
					<h2 class="db-account-title">'.__('Mes favoris', 'directory-builder').'</h2>
					'.do_shortcode('[directory_featured_listings limit="'.$favorite_limit.'" type="favorites"]');
					if ( !isset($_GET['my-favorites']) ) {
						$output .= '<a href="'.add_query_arg('my-favorites', '', get_permalink()).'" class="db-see-all-favorites dt-button dt-button-invert">'.__('Voir tout', 'directory-builder').'</a><div class="clearfix"></div>';
					} else if ( isset($_GET['my-favorites']) ) {
						$total_favorites = $wpdb->get_results('SELECT count(ID) as count FROM '.$wpdb->posts.' as posts, '.$wpdb->postmeta.' as meta WHERE posts.post_type="listings" && posts.post_status="publish" && meta.meta_key="directory_post_likes" && meta.meta_value LIKE "%i:'.get_current_user_id().';%" && meta.post_id=posts.ID');
						$total_fav_pages = $total_favorites['0']->count/25;

						$output .= '<div class="navigation paging-navigation">' . paginate_links( array(
							'format' => '?db-page=%#%',
							'total' => ( is_float( $total_fav_pages ) ? ceil( $total_fav_pages ) : round( $total_fav_pages ) ),
							'current' => ( isset( $_GET['db-page'] ) ? intval( $_GET['db-page'] ) : 1 ),
							'prev_text' => '',
							'next_text' => '',
						) ) . '</div>';
					}
				$output .= '
				</div>';
			}
		} else if ( isset($_GET['my-profile']) ) {
			$user_data = get_userdata(get_current_user_id());
			global $update_message;

			$output .= '
			<div class="db-account-profile">
				<h2 class="db-account-title">'.__('Mon profil', 'directory-builder').'</h2>'
				.$update_message.
				'<form method="post" id="db-edit-profile">
					<div class="db-field-row">
						<label for="display_name">'.__('Username', 'directory-builder').'</label>
						<input type="text" name="display_name" id="display_name" placeholder="'.__('Username', 'directory-builder').'" value="'.(isset($_POST['display_name'])?sanitize_text_field($_POST['display_name']):$user_data->data->display_name).'">
					</div>
					<div class="db-field-row">
						<label for="user_email">'.__('Email', 'directory-builder').'</label>
						<input type="email" name="user_email" id="user_email" placeholder="'.__('Email', 'directory-builder').'" value="'.(isset($_POST['user_email'])?sanitize_email($_POST['user_email']):$user_data->data->user_email).'">
					</div>
					<div class="db-field-row">
						<label for="user_password">'.__('Mot de passe', 'directory-builder').'</label>
						<input type="password" name="user_password" id="user_password" placeholder="'.__('Mot de passe', 'directory-builder').'" value="">
					</div>
					<div class="db-field-row">
						<label for="user_conf_password">'.__('Confirmer mot de passe', 'directory-builder').'</label>
						<input type="password" name="user_conf_password" id="user_conf_password" placeholder="'.__('Confirmer mot de passe', 'directory-builder').'" value="">
					</div>
					<input type="hidden" name="action" value="edit-profile">
					<input type="submit" value="'.__('Sauvegarder', 'directory-builder').'">
				</form>';
		}
	}
	$output .= '</div></div>';

	return $output;
}
add_shortcode('directory_account','db_account_shortcode');

function db_account_delete_listing_func() {
	if ( !current_user_can('manage_options') ) die(0);

	$listing_id = ( isset($_POST['listing_id']) ? intval($_POST['listing_id']) : '' );
	$deleting = false;

	global $wpdb;
	$package_list = $wpdb->get_results('SELECT * FROM '.$wpdb->posts.' WHERE ID="'.$listing_id.'" && post_author="'.get_current_user_id().'"');
	if ( !empty($package_list) ) {
		$deleting = wp_delete_post( $package_list['0']->ID, true );
	}

	if ( $deleting ) {
		echo '{"save_response": "0"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_account_delete_listing', 'db_account_delete_listing_func' );

function db_add_to_url( $name, $value ) {
	$params = $_GET;
	unset($params[$name]);
	$params[$name] = $value;
	return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
}

function db_install_theme( $file ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/file_system.php';
	$themes_dir = wp_normalize_path( WP_CONTENT_DIR . '/db-plugin-themes/' );
	list( $temp_dir, $unzipped_dir, ) = WPDB_FS::unzip_to_temp_dir( $file );
	$package_dir = $unzipped_dir;

	// Search for a dir containing 'theme.json'.
	$files = WPDB_FS::ls( $unzipped_dir, 'recursive=1' );
	foreach ( $files as $f ) {
		if ( 'theme_data.json' == basename( $f ) ) {
			$package_dir = dirname( $f );
			break;
		}
	}

	if ( ! file_exists( WPDB_FS::join( $package_dir, 'theme_data.json' ) ) ) {
		WPDB_FS::rmdir( $temp_dir );
		return __( 'ZIP file is not a valid Directory builder theme file.', 'directory-builder' );
	}

	if ( ! WPDB_FS::mkdir( $themes_dir ) ) {
		WPDB_FS::rmdir( $temp_dir );
		return __( 'Could not create themes directory.', 'directory-builder' );
	}

	$dest_dir = $themes_dir . basename( $package_dir );

	if ( ! WPDB_FS::rmdir( $dest_dir ) ) {
		WPDB_FS::rmdir( $temp_dir );
		return sprintf( __( 'Could not remove previous theme directory "%s".', 'directory-builder' ), $dest_dir );
	}

	if ( ! WPDB_FS::movedir( $package_dir, $themes_dir ) ) {
		WPDB_FS::rmdir( $temp_dir );
		return __( 'Could not move new theme into theme directory.', 'directory-builder');
	}

	WPDB_FS::rmdir( $temp_dir );

	return '';
}

function db_upload_theme( $theme_file ) {
	$file_extension = pathinfo($theme_file['name'], PATHINFO_EXTENSION);

	if ( $file_extension != 'zip' || !is_uploaded_file( $theme_file['tmp_name'] ) || UPLOAD_ERR_OK != $theme_file['error'] ) {
		return '<p class="db-theme-status-inner error">'.__('This is not a valid Directory builder plugin theme!', 'directory-builder').'</p>';
	}

	$dest = wp_normalize_path( untrailingslashit( get_temp_dir() ) . DIRECTORY_SEPARATOR . $theme_file['name'] );

	if ( ! move_uploaded_file( $theme_file['tmp_name'], $dest ) ) {
		return '<p class="db-theme-status-inner error">'.$res->get_error_message().'</p>';
	}

	$res = db_install_theme( $dest );

	if ( is_wp_error( $res ) ) {
		return '<p class="db-theme-status-inner error">'.$res->get_error_message().'</p>';
	} else {
		return $res;
	}
}

function db_theme_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'directory-builder') );
	}
	$main_settings = get_option( 'db_main_settings');
	$error_message = '';
	?>

	<?php
	if ( isset( $_FILES['db-theme-zip'] ) ) {
		$theme_file = isset( $_FILES['db-theme-zip'] ) ? $_FILES['db-theme-zip'] : false;

		if ( $theme_file !== false ) {
			$error_message = db_upload_theme( $theme_file );
		}

	}
	?>

	<div class="db-main-wrapper container-fluid" id="db-main-wrapper">
		<div class="db-main-content main-card clearfix">
			<div class="db-box-title">
				<h3 class="db-main-title">Theme settings</h3>
			</div>
			<div class="db-theme-status"><?php echo $error_message; ?></div>
			<div class="db-row-group clearfix">
				<span class="db-row-label col-sm-2">Upload theme</span>
				<div class="col-sm-10">
					<form action="" method="post" enctype="multipart/form-data">
						<input type="file" name="db-theme-zip">
						<input type="submit" value="Upload">
					</form>
				</div>
			</div>
		</div>
		<div class="db-theme-list">
			<?php
				$theme_list = db_get_theme_list();
				$theme_list_output = '';

				foreach ( $theme_list as $theme_value ) {
					$theme_list_output .= '
					<div class="db-theme-list-item col-md-4">
						<div class="db-theme-list-inner main-card">
							<div class="db-box-title">
								<h3 class="db-main-title">'.(isset($theme_value['theme_name'])?$theme_value['theme_name']:__('No name', 'directory-builder')).'</h3>';
								if ( ( $main_settings['db_theme_id'] != '' && $main_settings['db_theme_id'] == $theme_value['theme_id'] ) ) {
									$theme_list_output .= '<span class="db-active-theme db-button db-default-button non-clickable">'.__('Active', 'directory-builder').'</span>';
								} else {
									$theme_list_output .= '<a href="javascript:void(0)" class="db-activate-theme db-button db-primary-button" data-id="'.$theme_value['theme_id'].'" data-path="'.$theme_value['theme_path'].'" data-url="'.$theme_value['theme_url'].'">'.__('Activate', 'directory-builder').'</a>';
								}
							$theme_list_output .= '
							</div>
							<div class="db-theme-list-overlay clearfix">
								<img src="'.$theme_value['theme_image'].'">
								<div class="db-theme-info">';
									if ( isset($theme_value['theme_version']) ) {
										$theme_list_output .= '
										<div class="db-theme-list-row">
											<span class="db-theme-row-label">'.__('Version', 'directory-builder').':</span>
											<span class="db-theme-row-value">'.$theme_value['theme_version'].'</span>
										</div>';
									}
									if ( isset($theme_value['updated']) ) {
										$theme_list_output .= '
										<div class="db-theme-list-row">
											<span class="db-theme-row-label">'.__('Updated', 'directory-builder').':</span>
											<span class="db-theme-row-value">'.$theme_value['updated'].'</span>
										</div>';
									}
									if ( isset($theme_value['theme_author']) ) {
										$theme_list_output .= '
										<div class="db-theme-list-row">
											<span class="db-theme-row-label">'.__('Author', 'directory-builder').':</span>
											<span class="db-theme-row-value">'.$theme_value['theme_author'].'</span>
										</div>';
									}
									if ( isset($theme_value['theme_description']) ) {
										$theme_list_output .= '
										<div class="db-theme-list-row description">
											<span class="db-theme-row-value">'.$theme_value['theme_description'].'</span>
										</div>';
									}
							$theme_list_output .= '
								</div>
							</div>
						</div>
					</div>';
				}

				echo $theme_list_output;
			?>
		</div>
	</div>
	<?php
}

function db_get_theme_list() {
	$available_themes = array();

	// Check plugin theme
	if ( file_exists( plugin_dir_path( __FILE__ ).'/template/theme_data.json' ) ) {
		$theme_info = json_decode( file_get_contents( plugin_dir_path( __FILE__ ).'/template/theme_data.json' ), true );
		$theme_info['theme_image'] = plugin_dir_url( __FILE__ ).'template/theme_preview.jpg';
		$theme_info['theme_path'] = plugin_dir_path( __FILE__ ).'template/';
		$theme_info['theme_url'] = plugin_dir_url( __FILE__ ).'template/';

		$available_themes[] = $theme_info;
	}

	// Check WordPress theme
	if ( file_exists( get_template_directory().'/directory-template/theme_data.json' ) ) {
		$theme_info = json_decode( file_get_contents( get_template_directory().'/directory-template/theme_data.json' ), true );
		$theme_info['theme_image'] = get_template_directory_uri().'/directory-template/theme_preview.jpg';
		$theme_info['theme_path'] = get_template_directory().'/directory-template/';
		$theme_info['theme_url'] = get_template_directory_uri().'/directory-template/';

		$available_themes[] = $theme_info;
	}

	// Check uploaded themes
	$themes_dir = wp_normalize_path( WP_CONTENT_DIR . '/db-plugin-themes/' );
	if ( file_exists( $themes_dir ) ) {
		$themes_dir_url = WP_CONTENT_URL . '/db-plugin-themes/';
		$plugin_custom_themes = scandir($themes_dir);
		unset($plugin_custom_themes['0']);
		unset($plugin_custom_themes['1']);
		
		if ( !empty($plugin_custom_themes) ) {
			foreach ($plugin_custom_themes as $file_directory) {
				if ( file_exists($themes_dir.$file_directory.'/theme_data.json') ) {
					$theme_info = json_decode( file_get_contents( $themes_dir.$file_directory.'/theme_data.json' ), true );
					$theme_info['theme_image'] = $themes_dir_url.$file_directory.'/theme_preview.jpg';
					$theme_info['theme_path'] = $themes_dir.$file_directory.'/';
					$theme_info['theme_url'] = $themes_dir_url.$file_directory.'/';

					$available_themes[] = $theme_info;
				}
			}
		}
	}

	return $available_themes;
}

function db_activate_theme() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$theme_id = ( isset($_POST['theme_id']) ? sanitize_text_field($_POST['theme_id']) : '' );
	$theme_path = ( isset($_POST['theme_path']) ? sanitize_text_field($_POST['theme_path']) : '' );
	$theme_url = ( isset($_POST['theme_url']) ? esc_url($_POST['theme_url']) : '' );
	$main_settings = get_option( 'db_main_settings');

	$main_settings['db_theme_id'] = $theme_id;
	$main_settings['db_theme_path'] = $theme_path;
	$main_settings['db_theme_url'] = $theme_url;

	if ( !update_option( 'db_main_settings', $main_settings ) ) {
		echo '{"save_response": "failed"}';
	} else {
		echo '{"save_response": "0"}';
	}


	die(0);
}
add_action( 'wp_ajax_db_activate_theme', 'db_activate_theme' );

function db_directory_login_shortcode() {
	global $db_user_login;

	$output = '
	<div class="db-main-wrapper">';
		if ( is_wp_error($db_user_login) ) {
			$output .= '<p>'.$db_user_login->get_error_message().'</p>';
		}
		$output .= '
		<form method="post" id="db-login-form">
			<input type="text" name="login_user_email" placeholder="'.__('Username or email address', 'directory-builder').'" value="'.(isset($_POST['login_user_email'])?sanitize_email($_POST['login_user_email']):'').'" required>
			<input type="password" name="login_user_password" placeholder="'.__('Password', 'directory-builder').'" required>
			<input type="submit" name="db-sign-in" value="'.__('Sign in', 'directory-builder').'">
		</form>';
	$output .= '</div>';

	if ( !is_user_logged_in() ) {
		return $output;
	} else {
		$current_user = wp_get_current_user();
		return '<p>'.__('Nice to see you back', 'directory-builder').', '.$current_user->data->display_name.'. '.__('Not you?', 'directory-builder').' <a href="'.wp_logout_url( home_url( '/' ) ).'">'.__('Logout', 'directory-builder').'</a></p>';
	}
}
add_shortcode('directory_login','db_directory_login_shortcode');

function db_directory_register_shortcode() {
	global $db_user_register;

	$output = '
	<div class="db-main-wrapper">';
		if ( is_wp_error($db_user_register) ) {
			$output .= '<p><b>'.__('ERROR', 'directory-builder').':</b> '.$db_user_register->get_error_message().'</p>';
		} else if ( isset($db_user_register) ) {
			$output .= '<p>'.__('You are successfully registered and will shortly receive a confirmation email!', 'directory-builder').'</p>';
			$main_settings = get_option( 'db_main_settings', array() );
			$output .= '<script type="text/javascript">
			jQuery(document).ready(function($) {
				"use strict";
				jQuery(".db-register-form").hide();
			});
			</script>';
		}
		$output .= '
		<form method="post" id="db-register-form">';
			$reg_fields = array();
			if ( function_exists('db_get_registration_fields') ) {
				$reg_fields = db_get_registration_fields( 'shortcode' );
			}

			if ( !empty( $reg_fields ) ) {
				foreach ($reg_fields as $field_id => $field_settings) {
					if ( $field_settings['field_type'] == 'select' ) {
						$output .= '<div class="db-field-row single-select">';
					}
					$output .= $field_settings['field_html'];
					if ( $field_settings['field_type'] == 'select' ) {
						$output .= '</div>';
					}
				}
			}

			$gcaptcha_options = get_option( 'gglcptch_options', array() );
			if ( function_exists( 'gglcptch_init' ) && isset( $gcaptcha_options['public_key'] ) && $gcaptcha_options['public_key'] != '' && isset( $gcaptcha_options['private_key'] ) && $gcaptcha_options['private_key'] != '' ) {
				$output .= do_shortcode( '[bws_google_captcha]' );
			}

			$output .= '
			<input type="submit" name="db-register-action" value="'.__('Register', 'directory-builder').'">
		</form>';
	$output .= '</div>';

	return $output;
}
add_shortcode('directory_register','db_directory_register_shortcode');

function db_change_status_func() {
	if ( !current_user_can('manage_options') ) die(0);

	$listing_id = ( isset($_POST['listing_id']) ? intval($_POST['listing_id']) : '' );
	$listing_status = ( isset($_POST['listing_status']) ? sanitize_text_field($_POST['listing_status']) : '' );

	$listing_info = get_post_meta( $listing_id, 'db_order_info', true );

	$listing_info['payment_status'] = $listing_status;
	if ( $listing_status == 'Completed' ) {
		$listing_info['completed_on'] = time();
	} else {
		if ( isset($listing_info['completed_on']) ) {
			unset($listing_info['completed_on']);
		}
	}

	if ( update_post_meta( $listing_id, 'db_order_info', $listing_info ) ) {
		$db_listing = array( 'ID' => $listing_id );
		if ( $listing_status == 'Processing' || $listing_status == 'Pending' || $listing_status == 'Refunded' ) {
			$db_listing['post_status'] = 'pending';
		} else if ( $listing_status == 'Completed' ) {
			$db_listing['post_status'] = 'publish';
		}
		wp_update_post( $db_listing );

		echo '{"save_response": "0", "listing_status": "'.$listing_status.'"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_change_status', 'db_change_status_func' );

function db_body_classes($classes) {

	if ( is_page_template('template-listing_search.php') ) {
		$main_settings = get_option( 'db_main_settings');

		if ( $main_settings['search_position'] == 'bottom' || isset($_GET['mapontop']) ) {
			$classes[] = 'db-bottom-search';
		}
	}

	return $classes;
}
add_filter('body_class', 'db_body_classes');

function db_upload_images_func() {

	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$main_settings = get_option( 'db_main_settings', array());

	if ( isset($_FILES['file']) ) {
		$image_file_size = $_FILES['file']['size'];
		$file_size = getimagesize($_FILES['file']['tmp_name']);

		if ( $main_settings['image_min_size'] != '0' && round( $image_file_size/1000, 0 ) < intval($main_settings['image_min_size']) ) { // Check image min size
			echo '{"save_status": "false", "save_msg": "Image is too small, min image size is '.round($main_settings['image_min_size']/1000, 1).'MB"}';
			die(0);
		}

		if ( $main_settings['image_min_size'] != '0' && round( $image_file_size/1000, 0 ) > intval($main_settings['image_max_size']) ) { // Check image max size
			echo '{"save_status": "false", "save_msg": "Image is too large, max image size is '.round($main_settings['image_max_size']/1000, 1).'MB"}';
			die(0);
		}

		if ( $main_settings['image_min_width'] != '0' && $file_size['0'] < intval($main_settings['image_min_width']) ) { // Check image min width
			echo '{"save_status": "false", "save_msg": "Image is too small, min image width is '.$main_settings['image_min_width'].'px"}';
			die(0);
		}

		if ( $main_settings['image_max_width'] != '0' && $file_size['0'] > intval($main_settings['image_max_width']) ) { // Check image max width
			echo '{"save_status": "false", "save_msg": "Image is too large, max image width is '.$main_settings['image_max_width'].'px"}';
			die(0);
		}

		if ( $main_settings['image_min_height'] != '0' && $file_size['1'] < intval($main_settings['image_min_height']) ) { // Check image min height
			echo '{"save_status": "false", "save_msg": "Image is too small, min image height is '.$main_settings['image_min_height'].'px"}';
			die(0);
		}

		if ( $main_settings['image_max_height'] != '0' && $file_size['1'] > intval($main_settings['image_max_height']) ) { // Check image max height
			echo '{"save_status": "false", "save_msg": "Image is too large, max image height is '.$main_settings['image_max_height'].'px"}';
			die(0);
		}

		$attachment_id = media_handle_upload( 'file', '0' );

		if ( !is_wp_error( $attachment_id ) ) {
			echo '{"save_status": "true", "save_msg": "File successfully uploaded", "attachment_id": "'.$attachment_id.'"}';
		} else {
			echo '{"save_status": "false", "save_msg": "Sorry, there was an error uploading your file"}';
		}
	} else {
		echo '{"save_status": "false", "save_msg": "Sorry, there was no file uploaded"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_upload_images', 'db_upload_images_func' );
add_action( 'wp_ajax_nopriv_db_upload_images', 'db_upload_images_func' );

function db_search_marker_window() {
	$output = '';
	$marker_id = ( isset($_POST['marker_id']) ? sanitize_text_field($_POST['marker_id']) : '' );

	if ( $marker_id == '' ) {
		die(0);
	}

	$listing_ratings = get_post_meta( $marker_id, 'directory_post_likes', true);
	if ( $listing_ratings != '' ) {
		$liked = $listing_ratings;
	} else {
		$liked = array();
	}

	$listing_phone = get_post_meta($marker_id, 'listingphone', true);
	$listing_address = get_post_meta($marker_id, 'listing_address', true);
	$listing_category = get_the_terms($marker_id, 'listing_category');
	$img = wp_get_attachment_image_src( get_post_thumbnail_id($marker_id), 'medium' );

	$output .= '<div class="dt-featured-listings-item">';
		$output .= '<div class="dt-featured-listings-item-inner">';
			$output .= '<div class="dt-featured-listings-image">';
				$output .= '<a href="'.get_permalink($marker_id).'" class="dt-featured-item-image" '.(isset($img['0'])?'style="background: url('.preg_replace('#^https?://#', '//', $img['0']).')"':'').'></a>';
				$output .= '<div class="dt-featured-image-overlay"></div>';
				$output .= '<span class="dt-featured-listings-image-note">'.__('Featured', 'directory-builder').'</span>';
				$output .= '<div class="dt-featured-listings-image-meta">';
					if ( isset($listing_phone) && $listing_phone != '' ) {
						$output .= '<span class="dt-featured-listings-phone"><img src="'.DIRECTORY_PUBLIC.'images/phone.svg">'.$listing_phone.'</span>';
					}
					if ( isset($listing_address) && $listing_address != '' ) {
						$output .= '<span class="dt-featured-listings-address"><img src="'.DIRECTORY_PUBLIC.'images/location.svg">'.$listing_address.'</span>';
					}
				$output .= '</div>';
			$output .= '</div>';
			$output .= '<div class="dt-featured-listings-data">';
				$output .= '<a href="'.get_permalink($marker_id).'" class="dt-featured-listings-title">'.get_the_title($marker_id).'</a>';
				$output .= '<p class="dt-featured-listings-description">'.(get_the_excerpt($marker_id)!=''?get_the_excerpt($marker_id):strip_shortcodes(strip_tags(get_post_field('post_content', $marker_id)))).'</p>';
				$output .= '<div class="dt-featured-listings-meta clearfix">';
					if ( isset($listing_category['0']) ) {
						$cat_meta = get_option( "listing_category_".$listing_category['0']->term_id);
						$tag_color = (isset($cat_meta['tag-category-color'])?$cat_meta['tag-category-color']:'#555');
						$output .= '
						<a href="'.get_permalink($main_settings['search_page_id']).'?search_category='.$listing_category['0']->term_id.'" class="dt-featured-listings-category '.$listing_category['0']->slug.'" style="color: '.$tag_color.'"><style type="text/css">.dt-featured-listings-category.'.$listing_category['0']->slug.':before { border-color: '.$tag_color.'; }</style>'.$listing_category['0']->name.'</a>';
					}
					$ratings = get_post_meta( $marker_id, 'listing_ratings', true);

					if ( $ratings == '' ) {
						$rating_stars = '<img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg">';
						$listing_rating = 0;
					} else {
						$listing_rating = 0;
						$valid_ratings = 0;
						foreach ($ratings as $rating_value) {
							if ( $rating_value != null ) {
								$listing_rating += $rating_value;
								$valid_ratings++;
							}
						}
	
						$listing_rating = round(($listing_rating/$valid_ratings), 0, PHP_ROUND_HALF_DOWN);
						$rating_stars = '';
						for ($i=0; $i < $listing_rating; $i++) { 
							$rating_stars .= '<img src="'.DIRECTORY_PUBLIC.'images/star-colored.svg">';
						}
						if ( $listing_rating < 5 ) {
							for ($i=0; $i < 5-$listing_rating; $i++) { 
								$rating_stars .= '<img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg">';
							}
						}
					}

					if ( !isset($_COOKIE['dt-data']) ) {
						$can_rate = true;
					} else {
						$rated_listings = json_decode(stripslashes($_COOKIE['dt-data']));
						if ( !in_array($marker_id, $rated_listings) ) {
							$can_rate = true;
						} else {
							$can_rate = false;
						}
					}

					$output .= '<span class="dt-featured-listings-rating'.(!$can_rate?' rated':'').'" data-original="'.$listing_rating.'" data-id="'.$marker_id.'">'.$rating_stars.'</span>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	echo $output;

	die(0);
}
add_action( 'wp_ajax_db_marker_window', 'db_search_marker_window' );
add_action( 'wp_ajax_nopriv_db_marker_window', 'db_search_marker_window' );

function db_featured_status_func() {
	if ( !current_user_can('manage_options') ) die(0);

	global $wpdb;
	$listing_id = ( isset($_POST['listing_id']) ? intval($_POST['listing_id']) : '' );
	$featured_status = ( isset($_POST['featured_status']) ? sanitize_text_field($_POST['featured_status']) : '' );
	
	$featured_listings = get_option('db_sticky_listings', array());
	$featured_changed = false;

	if ( $featured_status == 'No' ) {
		if( ($key = array_search($listing_id, $featured_listings)) !== false ) {
			unset($featured_listings[$key]);
			$featured_changed = true;
		}
	} else if ( $featured_status == 'Yes' ) {
		if ( array_search($listing_id, $featured_listings) === false ) {
			$featured_listings[] = $listing_id;
			$featured_changed = true;
		}
	}
	
	if ( $featured_changed ) {
		update_option('db_sticky_listings', $featured_listings);
		echo '{"save_response": "0"}';
	} else {
		echo '{"save_response": "failed"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_featured_status', 'db_featured_status_func' );

function db_do_cities_autocomplete() {
	$city_value = ( isset($_POST['city_value']) ? esc_attr($_POST['city_value']) : '' );
	global $wpdb;
	$prepared_data = array();
	$cities = $wpdb->get_results('SELECT DISTINCT meta_value as city FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key="listing_city" && meta_value LIKE "%' . $city_value . '%"');
	
	if ( !empty($cities) ) {
		foreach ($cities as $city_value) {
			$prepared_data[] =  $city_value->city;
		}

		echo json_encode( $prepared_data );
	} else {
		echo 'failed';
	}
	
	die(0);
}
add_action( 'wp_ajax_db_city_autocomplete', 'db_do_cities_autocomplete' );
add_action( 'wp_ajax_nopriv_db_city_autocomplete', 'db_do_cities_autocomplete' );

function db_do_address_autocomplete() {
	$address_value = ( isset($_POST['address_value']) ? esc_attr($_POST['address_value']) : '' );
	global $wpdb;
	$prepared_data = array();
	$addresses = $wpdb->get_results('SELECT DISTINCT meta_key, meta_value FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key IN ("listing_address","listing_city","listing_neighborhood","listing_zip","listing_state","listing_country") && meta_value LIKE "%' . $address_value . '%"');

	if ( !empty($addresses) ) {
		$simplified_data = array();
		foreach ($addresses as $address_data) {
			if ( $address_data->meta_key != 'listing_address' ) {
				$simplified_data[] = $address_data->meta_value;
			} else {
				$exploded_address = explode(', ', $address_data->meta_value);
				if ( strpos(strtolower($exploded_address['0']), strtolower($address_value)) !== false ) {
					$simplified_data[] = $exploded_address['0'];
				}
			}
		}

		echo json_encode( array_unique( $simplified_data ) );
	} else {
		echo 'failed';
	}
	
	die(0);
}
add_action( 'wp_ajax_db_address_autocomplete', 'db_do_address_autocomplete' );
add_action( 'wp_ajax_nopriv_db_address_autocomplete', 'db_do_address_autocomplete' );

function db_setup_vc_modules() {
	// Extend Visual Composer
	if ( defined('WPB_VC_VERSION') ) {
		vc_map( array(
			"name" => __("Directory builder search", "directory-builder" ),
			"base" => "directory_listings",
			"class" => "",
			"icon" => "icon-wpb-ui-gap-content",
			"category" => __( "by Directory builder", "directory-builder" ),
			"show_settings_on_create" => false
		));

		vc_map( array(
			"name" => __("Directory builder add listing", "directory-builder" ),
			"base" => "directory_add_listing",
			"class" => "",
			"icon" => "icon-wpb-ui-gap-content",
			"category" => __( "by Directory builder", "directory-builder" ),
			"show_settings_on_create" => false
		));

		vc_map( array(
			"name" => __("Directory builder author dashboard", "directory-builder" ),
			"base" => "directory_account",
			"class" => "",
			"icon" => "icon-wpb-ui-gap-content",
			"category" => __( "by Directory builder", "directory-builder" ),
			"show_settings_on_create" => false
		));

		vc_map( array(
			"name" => __("Directory builder login", "directory-builder" ),
			"base" => "directory_login",
			"class" => "",
			"icon" => "icon-wpb-ui-gap-content",
			"category" => __( "by Directory builder", "directory-builder" ),
			"show_settings_on_create" => false
		));

		vc_map( array(
			"name" => __("Directory builder register", "directory-builder" ),
			"base" => "directory_register",
			"class" => "",
			"icon" => "icon-wpb-ui-gap-content",
			"category" => __( "by Directory builder", "directory-builder" ),
			"show_settings_on_create" => false
		));
	}	
}
add_action('after_setup_theme', 'db_setup_vc_modules');



function db_profile_configuration( $user ) { ?>

	<h3><?php esc_html_e('Directory builder', 'directory-builder'); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="db_listing_claims"><?php esc_html_e('Listing claims', 'directory-builder'); ?></label></th>
			<td>
				<input type="number" name="db_listing_claims" id="db_listing_claims" value="<?php echo esc_attr( get_the_author_meta( 'db_listing_claims', $user->ID ) ); ?>" class="regular-number" /><br />
				<span class="description"><?php esc_html_e('Number of listings this user can claim.', 'directory-builder'); ?></span>
			</td>
		</tr>
		<?php
		global $wpdb;
		$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_registration WHERE field_active="yes" ORDER BY field_order, ID ASC');
		if ( !empty($field_list) ) {
			$active_fields = array();
			foreach ($field_list as $field_value) {
				$field_settings = json_decode($field_value->field_settings, true);

				$do_not_show = array( 'db_registerusername', 'db_registeremail', 'db_registerpassword', 'db_registerpasswordconfirm' );
				$field_settings['field_name'] = 'db_'.$field_settings['field_name'];

				if ( !in_array( $field_settings['field_name'], $do_not_show ) ) {
					?>
					<tr>
						<th><label for="<?php echo $field_settings['field_name']; ?>"><?php echo $field_settings['frontend_title']; ?></label></th>
						<td>
							<?php
							if ( $field_settings['field_type'] == 'textarea' ) {
								echo '<textarea class="db_'.$field_settings['field_name'].' form-input" name="'.$field_settings['field_name'].'" placeholder="'.$field_settings['frontend_title'].'"'.($field_settings['required']=='yes'?' required':'').'>'.esc_attr( get_the_author_meta( $field_settings['field_name'], $user->ID ) ).'</textarea>';
							} else if ( $field_settings['field_type'] == 'checkbox' ) {
								$checkbox_val = esc_attr( get_the_author_meta( $field_settings['field_name'], $user->ID ) );
								echo '<label for="db_'.$field_settings['field_name'].'" class="dt-checkbox"><input type="checkbox" class="db_'.$field_settings['field_name'].' form-input" id="db_'.$field_settings['field_name'].'" name="'.$field_settings['field_name'].'"'.($field_settings['required']=='yes'?' required':'').($checkbox_val=='1'?' checked':'').'>'.$field_settings['frontend_title'].'</label>';
							} else if ( $field_settings['field_type'] == 'radio' ) {
								if ( $field_settings['radio_options'] != '' ) {
									$radio_options = explode(',', $field_settings['radio_options']);
									if ( !empty($radio_options) ) {
										$field_html = '';
										$loops = 1;
										$radio_val = (array)get_the_author_meta( $field_settings['field_name'], $user->ID );
										foreach ($radio_options as $radio_value) {
											$field_html .= '<label class="dt-radio" for="db_'.$field_settings['field_name'].$loops.'"><input type="radio" class="db_'.$field_settings['field_name'].' form-input" id="db_'.$field_settings['field_name'].$loops.'" name="'.$field_settings['field_name'].'[]" value="'.$radio_value.'"'.($field_settings['required']=='yes'?' required':'').(in_array($radio_value, $radio_val)?' checked':'').'>'.$radio_value.'</label>';
											$loops++;
										}
										echo $field_html;
									}
								}
							} else if ( $field_settings['field_type'] == 'select' ) {
								$select_options = explode('<br />', nl2br($field_settings['select_options']));
								if ( !empty($select_options) ) {
									$select_html = '<select class="db_'.$field_settings['field_name'].' form-input" name="'.$field_settings['field_name'].'"'.($field_settings['required']=='yes'?' required':'').'>';
									$select_val = esc_attr( get_the_author_meta( $field_settings['field_name'], $user->ID ) );
									foreach ($select_options as $select_data) {
										$curr_select_data = explode(':', $select_data);
										$select_html .= '<option value="'.$curr_select_data['0'].'"'.($select_val==$curr_select_data['0']?' selected':'').'>'.$curr_select_data['1'].'</option>';
									}
									$select_html .= '</select>';
								}
								echo $select_html;
							} else {
								echo '<input type="'.$field_settings['field_type'].'" class="db_'.$field_settings['field_name'].' form-input" name="'.$field_settings['field_name'].'" placeholder="'.$field_settings['frontend_title'].'" value="'.esc_attr( get_the_author_meta( $field_settings['field_name'], $user->ID ) ).'"'.($field_settings['required']=='yes'?' required':'').'>';
							}
							?>
						</td>
					</tr>
					<?php
				}
			}
		}
		?>
	</table>
	<?php
}
add_action( 'show_user_profile', 'db_profile_configuration' );
add_action( 'edit_user_profile', 'db_profile_configuration' );

function db_profile_configuration_save( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
		
	update_user_meta( $user_id, 'db_listing_claims', intval($_POST['db_listing_claims']) );

	foreach ($_POST as $field_key => $field_value) {
		if ( strpos($field_key, 'db_') === 0 && $field_key != 'db_listing_claims' ) {
			update_user_meta( $user_id, $field_key, $field_value );
		}
	}
}
add_action( 'personal_options_update', 'db_profile_configuration_save' );
add_action( 'edit_user_profile_update', 'db_profile_configuration_save' );

function db_get_claim_limit( $user_id ) {
	$user_meta = get_user_meta( $user_id, 'db_listing_claims', true );
	if ( $user_meta == '' ) {
		$main_settings = get_option( 'db_main_settings', array());
		return (isset($main_settings['claim_amount'])?intval($main_settings['claim_amount']):5);
	} else {
		return intval($user_meta);
	}
}

function db_get_listing_custom_fields( $listing_id = '', $field_location = 'all', $field_name = '' ) {
	global $wpdb;

	$field_query = $wpdb->get_results( $wpdb->prepare('SELECT field_settings FROM '.$wpdb->prefix.'directory_fields WHERE field_active="%s"'.($field_name!=''?' AND field_settings LIKE \'%%"field_name":"'.$field_name.'"%%\'':'').' ORDER BY field_order', 'yes') );

	$all_fields = array();
	if ( !empty($field_query) ) {
		foreach ($field_query as $field_data) {
			$field_settings = json_decode($field_data->field_settings, true);

			if ( $field_location != 'all' && ( isset($field_settings[$field_location]) && $field_settings[$field_location] != 'yes' ) ) {
				continue;
			} else if ( !isset($field_settings[$field_location]) ) {
				continue;
			}
			
			if ( $listing_id != '' ) {
				$field_value = get_post_meta( $listing_id, $field_settings['field_name'], true );
				if ( $field_settings['field_type'] == 'checkbox' ) {
					if ( $field_value == 'true' ) {
						$field_value = (isset($field_settings['checkbox_true'])&&$field_settings['checkbox_true']!=''?$field_settings['checkbox_true']:esc_html__('Yes','directory-builder'));
					} else {
						$field_value = (isset($field_settings['checkbox_false'])&&$field_settings['checkbox_false']!=''?$field_settings['checkbox_false']:esc_html__('No','directory-builder'));
					}
				}
			} else {
				$field_value = '';
			}

			$returned_data = array(
				'title' => esc_html( $field_settings['frontend_title'] ),
				'value' => $field_value,
				'type'  => esc_html( $field_settings['field_type'] ),
				'icon'  => (isset($field_settings['field_icon'])?esc_attr($field_settings['field_icon']):'')
				);

			if ( $field_settings['field_type'] == 'select' || $field_settings['field_type'] == 'multi-select' ) {
				$returned_data['select_options'] = $field_settings['select_options'];
			}

			$all_fields[$field_settings['field_name']] = $returned_data;
		}
	}

	return $all_fields;
}

function db_get_current_package_func() {
	$package_id = ( isset($_POST['package_id']) ? intval($_POST['package_id']) : '' );
	global $wpdb;
	$package_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.$package_id.'"');
	if ( !empty($package_list) ) {
		$field_settings = json_decode($package_list['0']->package_settings, true);

		echo json_encode( array( 'status' => 'success', 'fee_label' => $field_settings['fee_label'], 'fee_amount' => $field_settings['fee_amount'], 'listing_run_type' => $field_settings['listing_run_type'], 'listing_run_days' => $field_settings['listing_run_days'], 'payment_cycle' => $field_settings['payment_cycle'], 'payment_interval' => $field_settings['payment_interval'], 'payment_type' => (isset($field_settings['payment_type'])?$field_settings['payment_type']:'onetime'), 'author' => get_current_user_id() ) );
	} else {
		echo json_encode( array( 'status' => 'failed' ) );
	}

	die(0);
}
add_action( 'wp_ajax_db_get_current_package', 'db_get_current_package_func' );
add_action( 'wp_ajax_nopriv_db_get_current_package', 'db_get_current_package_func' );


function db_save_billing_function() {
	$field_data = ( isset($_POST['field_data']) ? json_decode(htmlspecialchars_decode(stripslashes($_POST['field_data'])), true) : '' );
	$listing_id = ( isset($_POST['listing_id']) ? intval($_POST['listing_id']) : '' );
	$card_data = ( isset($_POST['card_data']) ? json_decode(htmlspecialchars_decode(stripslashes($_POST['card_data'])), true) : '' );
	$gateway = ( isset($_POST['gateway']) ? $_POST['gateway'] : '' );
	$billing_info = get_post_meta( $listing_id, 'db_billing_info', true );

	if ( $billing_info == '' ) {
		update_post_meta( $listing_id, 'db_billing_info', $field_data );
	}

	if ( $listing_id ) {
		if ( $gateway == 'authorizenet' ) {
			if ( function_exists('db_check_authorize_card') ) {
				db_check_authorize_card( $card_data );
			} else {
				echo '{"save_response": "failed", "message": "'.__('Couldn\'t find Authorize.Net', 'directory-builder').'"}';
			}
		} else {
			echo '{"save_response": "'.$listing_id.'"}';
		}
	} else {
		echo '{"save_response": "failed", "message": "'.__('There was an issue while saving your billing information!', 'directory-builder').'"}';
	}

	die(0);
}
add_action( 'wp_ajax_db_save_billing', 'db_save_billing_function' );
add_action( 'wp_ajax_nopriv_db_save_billing', 'db_save_billing_function' );

function db_update_ipn_notes( $listing_id, $message ) {
	$current_notes = get_post_meta( $listing_id, 'db_notes', true );
	$current_notes[time()] = $message;
	update_post_meta( $listing_id, 'db_notes', $current_notes );
}

function db_cancel_subscription_func() {
	require 'vendor/autoload.php';
	require 'auth_cancel.php';

	die(0);
}
add_action( 'wp_ajax_db_cancel_subscription', 'db_cancel_subscription_func' );
add_action( 'wp_ajax_nopriv_db_cancel_subscription', 'db_cancel_subscription_func' );

function db_authorize_refund_func() {
	require 'vendor/autoload.php';
	require 'auth_refund.php';

	die(0);
}
add_action( 'wp_ajax_db_authorize_refund', 'db_authorize_refund_func' );
add_action( 'wp_ajax_nopriv_db_authorize_refund', 'db_authorize_refund_func' );

function db_get_registration_fields( $placement ) {
	global $wpdb;

	$field_list = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_registration WHERE field_active="yes" ORDER BY field_order, ID ASC');
	if ( !empty($field_list) ) {
		$active_fields = array();
		foreach ($field_list as $field_value) {
			$field_settings = json_decode($field_value->field_settings, true);
			if ( !is_array($field_settings['field_for']) ) {
				$field_settings['field_for'] = json_decode( $field_settings['field_for'], true );
			}
			if ( in_array( $placement, $field_settings['field_for'] ) ) {
				if ( $field_settings['field_type'] == 'textarea' ) {
					$field_settings['field_html'] = '<textarea class="db_'.$field_settings['field_name'].' form-input" name="db_'.$field_settings['field_name'].'" placeholder="'.$field_settings['frontend_title'].'"'.($field_settings['required']=='yes'?' required':'').'></textarea>';
				} else if ( $field_settings['field_type'] == 'checkbox' ) {
					$field_settings['field_html'] = '<label for="db_'.$field_settings['field_name'].'" class="dt-checkbox"><input type="checkbox" class="db_'.$field_settings['field_name'].' form-input" id="db_'.$field_settings['field_name'].'" name="db_'.$field_settings['field_name'].'"'.($field_settings['required']=='yes'?' required':'').'>'.$field_settings['frontend_title'].'</label>';
				} else if ( $field_settings['field_type'] == 'radio' ) {
					if ( $field_settings['radio_options'] != '' ) {
						$radio_options = explode(',', $field_settings['radio_options']);
						if ( !empty($radio_options) ) {
							$field_html = '';
							$loops = 1;
							foreach ($radio_options as $radio_value) {
								$field_html .= '<label class="dt-radio" for="db_'.$field_settings['field_name'].$loops.'"><input type="radio" class="db_'.$field_settings['field_name'].' form-input" id="db_'.$field_settings['field_name'].$loops.'" name="db_'.$field_settings['field_name'].'[]" value="'.$radio_value.'"'.($field_settings['required']=='yes'?' required':'').'>'.$radio_value.'</label>';
								$loops++;
							}
							$field_settings['field_html'] = $field_html;
						}
					}
				} else if ( $field_settings['field_type'] == 'select' ) {
					$select_options = explode('<br />', nl2br($field_settings['select_options']));
					if ( !empty($select_options) ) {
						$select_html = '
						<input type="text" class="dt-custom-select form-input" placeholder="'.$field_settings['frontend_title'].'" readonly="">
						<input type="hidden" class="dt-custom-select-value form-input" id="db_'.$field_settings['field_name'].'" name="db_'.$field_settings['field_name'].'">
						<div class="dt-custom-select-container">
							<div class="dt-custom-select-inner">
								<div class="dt-custom-select-items">';
									foreach ($select_options as $select_data) {
										$curr_select_data = explode(':', $select_data);
										$select_html .= '<div class="dt-custom-select-item" data-value="'.$curr_select_data['0'].'">'.$curr_select_data['1'].'</div>';
									}
								$select_html .= '
								</div>
								<div class="dt-custom-select-scrollbar-wrapper">
									<span class="dt-custom-select-scrollbar"></span>
								</div>
							</div>
						</div>';
					}
					$field_settings['field_html'] = $select_html;
				} else {
					$field_settings['field_html'] = '<input type="'.$field_settings['field_type'].'" class="db_'.$field_settings['field_name'].' form-input" name="db_'.$field_settings['field_name'].'" placeholder="'.$field_settings['frontend_title'].'"'.($field_settings['required']=='yes'?' required':'').'>';
				}
				$active_fields[$field_value->ID] = $field_settings;
			}
		}
		return $active_fields;
	} else {
		return array();
	}
}

function db_generate_invoice( $listing_id, $payment_row ) {
	require('includes/pdf/fpdf.php');

	if ( get_post_type( $listing_id ) != 'listings' ) {
		printf( __( 'There\'s no listing found with ID %d', 'directory-builder' ), $listing_id );
		return;
	}

	$main_settings = get_option( 'db_main_settings', array() );

	class dbPDF extends FPDF {
		function FancyTable($header, $data) { // Colored table
			// Colors, line width and bold font
			$this->SetFillColor(0,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			// Header
			$w = array(110, 40, 40);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,($i==0?'L':'C'),true);
			$this->Ln();
			// Color and font restoration
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Data
			$fill = false;
			foreach($data as $row) {
				$this->Cell($w[0],10,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],10,$row[1],'LR',0,'C',$fill);
				$this->Cell($w[1],10,$row[2],'LR',0,'C',$fill);
				$this->Ln();
				$fill = !$fill;
			}
			// Closing line
			$this->Cell(array_sum($w),0,'','T');
		}
	}

	$pdf = new dbPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',14);
	$logo_set = $info_set = false;

	if ( isset($main_settings['invoice_logo']) && $main_settings['invoice_logo'] != '' ) { // Check if logo is set
		$logo_id = db_get_image_id($main_settings['invoice_logo']);
		
		if ( $logo_id !== false ) {
			$uploads_dir = wp_upload_dir();
			$image_meta = wp_get_attachment_metadata($logo_id);
			
			$pdf->Image( $uploads_dir['basedir'] . '/' . $image_meta['file'], 10, 10, 0, 35 );
		}

		$logo_set = true;
	}

	if ( isset($main_settings['invoice_business']) && $main_settings['invoice_business'] != '' ) { // Check if business info is set
		$business_information = preg_split("/\\r\\n|\\r|\\n/", $main_settings['invoice_business']);

		if ( !empty($business_information) ) {
			$info_loops = 0;
			foreach ($business_information as $business_info_line) {
				if ( $info_loops == 0 ) {
					$pdf->SetFont( 'Arial', 'B', 10 );
				} else {
					$pdf->SetFont( 'Arial', '', 10 );
				}

				if ( $logo_set ) {
					$pdf->Cell( 100 );
				}
				
				$pdf->Cell( 0, 5, $business_info_line, 0, 1 );

				$info_loops++;

				$info_set = true;
			}
		}
	}

	if ( $info_set ) {
		if ( $info_loops >= 7 ) {
			$cell_height = 20;
		} else {
			if ( $logo_set ) {
				$cell_height = 20 + ( 7 - $info_loops ) * 5;
			} else {
				$cell_height = ( 7 - $info_loops ) * 5;
			}
		}

		$pdf->Cell( 0, $cell_height, '', 0, 1 );
	} else if ( $logo_set ) {
		$pdf->Cell( 0, 50, '', 0, 1 );
	}
	

	$pdf->SetFont( 'Arial', 'B', 20 );
	$pdf->Cell( 0, 5, esc_html__( 'INVOICE', 'directory builder' ) );
	$pdf->Cell( 0, 10, '', 0, 1 );

	$user_billing = get_post_meta( $listing_id, 'db_billing_info', true );
	if ( $user_billing != '' ) {
		$pdf->SetFont( 'Arial', '', 10 );
		if ( isset($user_billing['x_full_name']) ) {
			$pdf->Cell( 0, 5, $user_billing['x_full_name'] );
			$pdf->Ln();
		}

		if ( isset($user_billing['x_address']) && isset($user_billing['x_city']) && isset($user_billing['x_zip']) ) {
			$pdf->Cell( 0, 5, $user_billing['x_address'].', '.$user_billing['x_city'].', '.$user_billing['x_zip'] );
			$pdf->Ln();
		}

		if ( isset($user_billing['x_country']) ) {
			$pdf->Cell( 0, 5, $user_billing['x_country'] );
			$pdf->Ln();
		}
	}

	$invoice_extra = db_get_invoice_table_data( $listing_id, $payment_row );
	$date_format = get_option( 'date_format' );

	if ( $invoice_extra === false ) {
		esc_html_e( 'There\'s no valid data to display!', 'directory-builder' );
		return;
	}

	$pdf->SetFont( 'Arial', '', 10 );

	$pdf->Cell( 100 );
	$pdf->Cell( 0, -25, sprintf( __( 'Invoice date:           %s', 'directory-builder' ), date( $date_format, time() ) ), 0, 1 );
	$pdf->Cell( 100 );
	$pdf->Cell( 0, 35, sprintf( __( 'Order date:             %s', 'directory-builder' ), date( $date_format, $invoice_extra['order_date'] ) ), 0, 1 );
	$pdf->Cell( 100 );
	$pdf->Cell( 0, -25, sprintf( __( 'Payment method:   %s', 'directory-builder' ), $invoice_extra['payment_method'] ), 0, 1 );

	$pdf->Cell( 100, 30, '', 0, 1 );
	$pdf->FancyTable( array( esc_html__('Description', 'directory-builder'), esc_html__('Status', 'directory-builder'), esc_html__('Price', 'directory-builder')), array( array( $invoice_extra['product_text'], $invoice_extra['payment_status'], $invoice_extra['price_text'] ) ) );

	$pdf->Cell( 0, 5, '', 0, 1 );

	$pdf->Cell( 140 );
	$pdf->SetFont( 'Arial', 'B', 10 );
	$pdf->Cell( 26, 5, __( 'Subtotal:', 'directory-builder' ) );
	$pdf->SetFont( 'Arial', '', 10 );
	$pdf->Cell( 0, 5, $invoice_extra['price_text'] );

	$pdf->SetLineWidth( 0.5 );
	$pdf->Line( $pdf->GetX()-50, $pdf->GetY()+7, $pdf->GetX(), $pdf->GetY()+7 );
	

	$pdf->Cell( 0, 10, '', 0, 1 );

	$pdf->Cell( 140 );
	$pdf->SetFont( 'Arial', 'B', 13 );
	$pdf->Cell( 26, 5, __( 'Total:', 'directory-builder' ) );
	$pdf->SetFont( 'Arial', 'B', 13 );
	$pdf->Cell( 0, 5, $invoice_extra['price_text'] );
	
	$pdf->Output();
	// $pdf->Output( 'D', 'invoice.pdf' );
}

function db_get_invoice_data() {
	if ( is_user_logged_in() && current_user_can('manage_options') && isset($_GET['dbgetinvoice']) && is_numeric($_GET['dbgetinvoice']) && isset($_GET['r']) && is_numeric($_GET['r']) ) {
		db_generate_invoice( intval($_GET['dbgetinvoice']), intval($_GET['r']) );
		exit;
	}
}
add_action( 'init', 'db_get_invoice_data' );

function db_get_image_id( $image_url ) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));

	if ( !empty($attachment) ) {
		return $attachment[0];
	} else {
		return false;
	}
}

function db_get_invoice_table_data( $listing_id, $payment_row ) {
	$main_settings = get_option( 'db_main_settings', array() );

	$order_info = get_post_meta( $listing_id, 'db_order_info', true );
	if ( isset($order_info['payment_history'][$payment_row]) ) {
		$history_row = explode( '===', $order_info['payment_history'][$payment_row] );

		if ( $history_row['2'] == 'Completed' ) {
			$desc_text = sprintf( __( 'Payment for listing - %s', 'directory-builder' ), get_the_title( $listing_id ) );
		} else if ( $history_row['2'] == 'Refunded' ) {
			$desc_text = sprintf( __( 'Refund for listing - %s', 'directory-builder' ), get_the_title( $listing_id ) );
		}

		return array(
			'order_date' => strtotime( $history_row['0'] ),
			'payment_method' => $history_row['3'],
			'payment_status' => $history_row['2'],
			'product_text' => $desc_text,
			'price_text' => (!is_numeric($history_row['1'])?$history_row['1']:$main_settings['default_currency_symbol'].round($history_row['1'], 2))
		);
	} else {
		return false;
	}
}

function db_generate_schema_data() {
	if ( is_single() && get_post_type() == 'listings' ) {
		$field_list = db_get_active_fields();
		$custom_field_data = db_get_listing_custom_values($field_list, get_the_ID());
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$schema_info = array(
			"@context" => "http://schema.org",
			"@type" => "Place",
			"name" => get_the_title(),
			"url" =>get_the_permalink(),
			"address" =>  $custom_field_data['listing_address'],
			"geo" => array(
				"@type" => "GeoCoordinates",
				"latitude" => $custom_field_data['listing_address_lat'],
				"longitude" => $custom_field_data['listing_address_lng']
			),
			"hasMap" => "https://www.google.lv/maps/@".$custom_field_data['listing_address_lat'].",".$custom_field_data['listing_address_lng'].",14z"
		);

		if ( isset($img['0']) ) {
			$schema_info['image'] = $img['0'];
		}

		if ( isset($custom_field_data['listingphone']) && $custom_field_data['listingphone'] != '' ) {
			$schema_info['telephone'] = $custom_field_data['listingphone'];
		}

		if ( isset($custom_field_data['hop']) && $custom_field_data['hop'] != '' && $custom_field_data['hop'] != 'always|' ) {
			$custom_times = explode('|', $custom_field_data['hop']);
			unset($custom_times['0']);
			if ( !empty($custom_times) ) {
				$hoo_days = array(
					'mon' => esc_html__('Monday', 'directory-builder'),
					'tue' => esc_html__('Tuesday', 'directory-builder'),
					'wed' => esc_html__('Wednesday', 'directory-builder'),
					'thu' => esc_html__('Thursday', 'directory-builder'),
					'fri' => esc_html__('Friday', 'directory-builder'),
					'sat' => esc_html__('Saturday', 'directory-builder'),
					'sun' => esc_html__('Sunday', 'directory-builder'),
					'--' => ' - '
					);

				$opening_hours = array();

				foreach ($custom_times as $hoo_values) {
					$parsed_data = explode('==', $hoo_values);

					if ( $parsed_data['0'] == '' ) {
						continue;
					}

					$hoo_day = $parsed_data['0'];
					$schema_day = '';

					switch ( $hoo_day ) {
						case 'mon': $schema_day = 'Monday'; break;
						case 'tue': $schema_day = 'Tuesday'; break;
						case 'wed': $schema_day = 'Wednesday'; break;
						case 'thu': $schema_day = 'Thursday'; break;
						case 'fri': $schema_day = 'Friday'; break;
						case 'sat': $schema_day = 'Saturday'; break;
						case 'sun': $schema_day = 'Sunday'; break;
						default: $schema_day = 'Monday'; break;
					}
					
					$hoo_times = str_replace('0-0', esc_html__('Closed', 'directory-builder'), $parsed_data['1']);
					$exploded_times = explode( '-',$hoo_times );

					$opening_hours[] = array(
						"@type" => "OpeningHoursSpecification",
						"dayOfWeek" => "http://schema.org/".$schema_day,
						"opens" => (isset($exploded_times['0'])?$exploded_times['0']:''),
						"closes" => (isset($exploded_times['1'])?$exploded_times['1']:'')
					);
				}
				$schema_info['openingHoursSpecification'] = $opening_hours;
			}
		}

		$all_comments = get_comments( array( 'post_id' => get_the_ID() ) );
		$all_ratings = 0;
		if ( !empty($all_comments) ) {
			foreach ($all_comments as $review_data) {
				if ( $review_data->comment_approved == '1' ) {
					$rating_value = get_comment_meta( intval($review_data->comment_ID), 'listing_review_rating', true );
					$all_ratings += $rating_value;
				}
			}

			$schema_info['AggregateRating'] = array(
				"ratingValue" => ( $all_ratings != 0 ? round($all_ratings/3, 1) : '1' ),
				"reviewCount" => get_comments_number()
			);
		}

		if ( isset($custom_field_data['amenities']) && !empty($custom_field_data['amenities']) ) {
			$amenities = array();
			$amenities_field = db_get_listing_custom_fields( get_the_ID(), 'on_detail', 'amenities' );
			$select_data = preg_split("/\\r\\n|\\r|\\n/", $amenities_field['amenities']['select_options']);
			$formatted_data = array();

			foreach ($select_data as $select_value) {
				$exploded_data = explode( ':', $select_value );
				$formatted_data[$exploded_data['0']] = $exploded_data['1'];
			}

			if ( !is_array( $custom_field_data['amenities'] ) ) {
				$custom_field_data['amenities'] = explode( ',', $custom_field_data['amenities'] );
			}

			foreach ($custom_field_data['amenities'] as $amenities_value) {
				$amenities[] = array(
					'@type' => 'LocationFeatureSpecification',
					'name' => $formatted_data[$amenities_value],
					'value' => 'True'
				);
			}
			$schema_info['amenityFeature'] = $amenities;
		}

		echo '<script type="application/ld+json">'.json_encode($schema_info).'</script>';
	}

}
add_action( 'wp_head', 'db_generate_schema_data' );

add_filter( 'term_link', 'db_change_term_link' );
function db_change_term_link( $term_url ) {
	$term_full_url = parse_url( $term_url );
	$url_exploded = explode( '/', $term_full_url['path'] );
	$term_data = get_term_by( 'slug', $url_exploded[count($url_exploded)-2], 'listing_category' );

	if ( $term_data !== false ) {
		$main_settings = get_option( 'db_main_settings', array());

		if ( isset( $main_settings['search_page_id'] ) && $main_settings['search_page_id'] != '' ) {
			return add_query_arg( 'search_category', $term_data->term_id, get_permalink( $main_settings['search_page_id'] ) );
		}
	}

	return $term_url;
}

function db_custom_wp_mail_from( $original_email_address ) {
	return get_bloginfo('admin_email');
}

function db_custom_wp_mail_from_name( $original_email_from ) {
	return get_bloginfo('name');
}

function db_check_post_statuses() {
	global $pagenow, $wpdb;

	if ( !isset( $_GET['post_type'] ) || $_GET['post_type'] != 'listings' || !is_admin() || $pagenow != 'edit.php' ) {
		return;
	}

	$listings = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'posts WHERE post_type="listings" && post_status="published"');
	if ( !empty( $listings ) ) {
		foreach ( $listings as $listing_data ) {
			$wpdb->update( $wpdb->prefix.'posts', array( 'post_status' => 'publish' ), array( 'ID' => $listing_data->ID ) );
		}
	}
	
}
add_action( 'admin_init', 'db_check_post_statuses' );

add_filter( 'gglcptch_exclude_forms', function() {
	return array('.dt-register-form', '#db-add-listing-form');
});

function db_wp_login() {
	global $user;

	$user_validation = get_user_meta( $user->data->ID, 'db_validation', true );
	if ( $user_validation !== false && $user_validation != '' ) {
		if ( $user_validation !== 'validated' ) {
			wp_logout();
		}
	}
}
add_action( 'wp_login', 'db_wp_login' );
