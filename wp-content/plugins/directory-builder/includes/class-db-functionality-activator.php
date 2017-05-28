<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * Fired during plugin activation
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    db_func
 * @subpackage db_func/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    db_func
 * @subpackage db_func/includes
 * @author     Cohhe <support@cohhe.com>
 */
class db_func_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function db_activate() {
		global $wpdb;

		$field_table  = $wpdb->prefix . 'directory_fields';
		$registration_table  = $wpdb->prefix . 'directory_registration';
		$package_table  = $wpdb->prefix . 'directory_packages';
		$package_ads  = $wpdb->prefix . 'directory_ads';
		$charset_collate = $wpdb->get_charset_collate();

		$main_sql = "CREATE TABLE IF NOT EXISTS $field_table (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `field_order` int(9) NOT NULL,
				  `field_active` text NOT NULL,
				  `field_settings` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		$registration_sql = "CREATE TABLE IF NOT EXISTS $registration_table (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `field_order` int(9) NOT NULL,
				  `field_active` text NOT NULL,
				  `field_settings` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		$package_sql = "CREATE TABLE IF NOT EXISTS $package_table (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `package_name` text NOT NULL,
				  `package_settings` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		$ads_sql = "CREATE TABLE IF NOT EXISTS $package_ads (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `title` text NOT NULL,
				  `content` text NOT NULL,
				  `placement` text NOT NULL,
				  `packages` text NOT NULL,
				  `views` int NOT NULL,
				  `status` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $main_sql );
		dbDelta( $registration_sql );
		dbDelta( $package_sql );
		dbDelta( $ads_sql );

		$default_custom_fields = array(
			'listing_address' => array(
				"field_name" => "listing_address",
				"admin_title" => "Address",
				"frontend_title" => "Address",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "yes",
				"on_detail" => "no",
				"on_contact" => "yes",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "false",
				"disabled" => "delete,field_active",
				"field_icon" => "wl-location"
			),
			'listing_city' => array(
				"field_name" => "listing_city",
				"admin_title" => "City",
				"frontend_title" => "City",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listing_neighborhood' => array(
				"field_name" => "listing_neighborhood",
				"admin_title" => "Neighborhood",
				"frontend_title" => "Neighborhood",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listing_zip' => array(
				"field_name" => "listing_zip",
				"admin_title" => "Postal code / Zip",
				"frontend_title" => "Postal code / Zip",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listing_state' => array(
				"field_name" => "listing_state",
				"admin_title" => "County / State",
				"frontend_title" => "County / State",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listing_country' => array(
				"field_name" => "listing_country",
				"admin_title" => "Country",
				"frontend_title" => "Country",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "select",
				"select_options" => "Afghanistan,Albania,Algeria,Andorra,Angola,Antigua and Barbuda,Argentina,Armenia,Aruba,Australia,Austria,Azerbaijan,The Bahamas,Bahrain,Bangladesh,Barbados,Belarus,Belgium,Belize,Benin,Bhutan,Bolivia,Bosnia and Herzegovina,Botswana,Brazil,Brunei ,Bulgaria,Burkina Faso,Burma,Burundi,Cambodia,Cameroon,Canada,Cabo Verde,Central African Republic,Chad,Chile,China,Colombia,Comoros,Democratic Republic of the Congo,Republic of the Congo,Costa Rica,Cote d'Ivoire,Croatia,Cuba,Curacao,Cyprus,Czech Republic,Denmark,Djibouti,Dominica,Dominican Republic,East Timor (see Timor-Leste),Ecuador,Egypt,El Salvador,Equatorial Guinea,Eritrea,Estonia,Ethiopia,Fiji,Finland,France,Gabon,The Gambia,Georgia,Germany,Ghana,Greece,Grenada,Guatemala,Guinea,Guinea-Bissau,Guyana,Haiti,Holy See,Honduras,Hong Kong,Hungary,Iceland,India,Indonesia,Iran,Iraq,Ireland,Israel,Italy,Jamaica,Japan,Jordan,Kazakhstan,Kenya,Kiribati,North Korea,South Korea,Kosovo,Kuwait,Kyrgyzstan,Laos,Latvia,Lebanon,Lesotho,Liberia,Libya,Liechtenstein,Lithuania,Luxembourg,Macau,Macedonia,Madagascar,Malawi,Malaysia,Maldives,Mali,Malta,Marshall Islands,Mauritania,Mauritius,Mexico,Micronesia,Moldova,Monaco,Mongolia,Montenegro,Morocco,Mozambique,Namibia,Nauru,Nepal,Netherlands,New Zealand,Nicaragua,Niger,Nigeria,North Korea,Norway,Oman,Pakistan,Palau,Palestinian Territories,Panama,Papua New Guinea,Paraguay,Peru,Philippines,Poland,Portugal,Qatar,Romania,Russia,Rwanda,Saint Kitts and Nevis,Saint Lucia,Saint Vincent and the Grenadines,Samoa ,San Marino,Sao Tome and Principe,Saudi Arabia,Senegal,Serbia,Seychelles,Sierra Leone,Singapore,Sint Maarten,Slovakia,Slovenia,Solomon Islands,Somalia,South Africa,South Korea,South Sudan,Spain ,Sri Lanka,Sudan,Suriname,Swaziland ,Sweden,Switzerland,Syria,Taiwan,Tajikistan,Tanzania,Thailand ,Timor-Leste,Togo,Tonga,Trinidad and Tobago,Tunisia,Turkey,Turkmenistan,Tuvalu,Uganda,Ukraine,United Arab Emirates,United Kingdom,Uruguay,Uzbekistan,Vanuatu,Venezuela,Vietnam,Yemen,Zambia,Zimbabwe",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listing_address_lat' => array(
				"field_name" => "listing_address_lat",
				"admin_title" => "Latitude",
				"frontend_title" => "Latitude",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listing_address_lng' => array(
				"field_name" => "listing_address_lng",
				"admin_title" => "Longitude",
				"frontend_title" => "Longitude",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "1",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"child" => "true",
				"disabled" => "delete,display_order"
			),
			'listingcontact' => array(
				"field_name" => "listingcontact",
				"admin_title" => "Contact e-mail",
				"frontend_title" => "Contact e-mail",
				"frontend_description" => "Email address users might use to contact listing owner!",
				"default_value" => "",
				"display_order" => "2",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "no",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "email"
			),
			'listingphone' => array(
				"field_name" => "listingphone",
				"admin_title" => "Phone number",
				"frontend_title" => "Phone number",
				"frontend_description" => "Listing phone number",
				"default_value" => "",
				"display_order" => "4",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "yes",
				"on_detail" => "no",
				"on_contact" => "yes",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "text",
				"field_icon" => "wl-phone"
			),
			'listingwebsite' => array(
				"field_name" => "listingwebsite",
				"admin_title" => "Website",
				"frontend_title" => "Website",
				"frontend_description" => "Listing website",
				"default_value" => "",
				"display_order" => "5",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "no",
				"on_contact" => "yes",
				"data_type" => "text",
				"validation_pattern" => "",
				"validation_pattern-message" => "",
				"field_type" => "url",
				"field_icon" => "wl-link"
			),
			'amenities' => array(
				"field_name" => "amenities",
				"admin_title" => "Amenities",
				"frontend_title" => "Amenities",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "6",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "yes",
				"on_contact" => "no",
				"multiselect_type" => "select",
				"select_options" => "wheelchair:Wheelchair access\naccepts-creditcards:Accept credit cards\nkids-corder:Kids corner\ncar-parking:Car parking\npet-friendly:Pets friendly\ngift-wrapping:Gift wrapping\nbike-parking:Bike parking\nfree-wifi:Free Wi-Fi",
				"field_type" => "multi-select"
			),
			'hop' => array(
				"field_name" => "hop",
				"admin_title" => "Hours of operation",
				"frontend_title" => "Hours of operation",
				"frontend_description" => "",
				"default_value" => "",
				"display_order" => "7",
				"field_active" => "yes",
				"for_admins" => "no",
				"required" => "no",
				"required_message" => "",
				"on_listing" => "no",
				"on_detail" => "yes",
				"on_contact" => "no",
				"field_type" => "hoursofoperation"
			)
		);

		$custom_field = $wpdb->get_results("SELECT count(*) as count FROM ".$field_table);
		if ( intval($custom_field['0']->count) == 0 ) {
			foreach ($default_custom_fields as $custom_key => $custom_value) {
				$wpdb->query('INSERT INTO '.$field_table.' (`field_order`, `field_active`, `field_settings`) VALUES ("'.$custom_value['display_order'].'", "yes", "'.addslashes(json_encode($custom_value)).'")' );
			}
		}

		$main_settings = get_option( 'db_main_settings' );
		if ( $main_settings === false ) { // Set the default settings
			$main_settings = array(
				'per_page' => '10',
				'contact_form_status' => true,
				'contact_form_registered' => false,
				'contact_form_max' => '5',
				'listing_ratings' => true,
				'after_uninstall' => 'nothing',
				'default_listing_image' => '',
				'add_listing_register' => '',
				'login_page_id' => '',
				'search_page_id' => '',
				'add_page_id' => '',
				'default_location' => 'London',
				'default_location_lat' => '51.5073509',
				'default_location_lng' => '-0.12775829999998223',
				'google_key' => '',
				'directory_slug' => 'listing',
				'category_slug' => 'listing_category',
				'allow_images' => '',
				'image_min_size' => '0',
				'image_max_size' => '10000',
				'image_min_width' => '0',
				'image_max_width' => '500',
				'image_min_height' => '0',
				'image_max_height' => '500',
				'users_are_allowed' => array( 'edit' ),
				'terms_and_conditions_status' => '',
				'terms_and_conditions' => '',
				'search_position' => 'left',
				'search_fields' => array('listing_keyword', 'listing_categories', 'listing_country', 'listing_address', 'search_radius'),
				'search_layout' => '{"row_1":["listing_keyword","listing_categories","listing_country","listing_address","search_radius"]}',
				'search_radius_status' => 'yes',
				'search_radius_value' => 'km',
				'search_radius_distance' => '150',
				'new_post_status' => 'pending',
				'category_list_order' => 'name',
				'category_list_sort' => 'asc',
				'category_post_count' => '',
				'hide_empty_categories' => '',
				'only_parent_categories' => '',
				'default_currency' => 'USD',
				'default_currency_symbol' => '$',
				'payment_method' => array('paypal'),
				'payment_active' => 'yes',
				'payment_mode' => 'sandbox',
				'paypal_merchant_id' => 'example@example.com',
				'paypal_cancel_url' => '',
				'paypal_return_url' => '',
				'order_success_url' => '',
				'authorize_id' => '',
				'authorize_key' => '',
				'db_theme_id' => 'default',
				'db_theme_path' => DB_PLUGIN.'template/',
				'db_theme_url' => DB_PLUGIN_URI.'template/',
				'claim_amount' => '5',
				'claims_require_purchase' => false,
				'claims_processing' => 'manual',
				'homepage_search_fields' => array('listing_keyword', 'listing_address', 'listing_categories'),
				'homepage_search_layout' => '{"row_0":["listing_keyword","listing_address","listing_categories"]}',
				'invoice_logo' => '',
				'invoice_business' => 'invoice_business'
			);
			update_option( 'db_main_settings', $main_settings );
		} else { // Set default settings for existing configuration
			if ( !isset( $main_settings['homepage_search_fields'] ) ) {
				$main_settings['homepage_search_fields'] = array('listing_keyword', 'listing_address', 'listing_categories');
				$main_settings['homepage_search_layout'] = '{"row_0":["listing_keyword","listing_address","listing_categories"]}';
			}

			if ( !isset($main_settings['invoice_logo']) ) {
				$main_settings['invoice_logo'] = '';
				$main_settings['invoice_business'] = '';
			}

			update_option( 'db_main_settings', $main_settings );
		}

		$default_registration_fields = array(
			'username' => array(
				"frontend_title" => "Username",
				"display_order" => "1",
				"field_active" => "yes",
				"field_for" => "[\"shortcode\",\"modal\",\"add_listing\"]",
				"required" => "yes",
				"disabled" => "delete",
				"field_name" => "registerusername",
				"validation_pattern" => "",
				"field_type" => "text"
			),
			'email' => array(
				"field_name" => "registeremail",
				"frontend_title" => "Email",
				"display_order" => "2",
				"field_active" => "yes",
				"field_for" => "[\"shortcode\",\"modal\",\"add_listing\"]",
				"required" => "yes",
				"validation_pattern" => "",
				"field_type" => "email",
				"disabled" => "delete"
			),
			'pass1' => array(
				"field_name" => "registerpassword",
				"frontend_title" => "Password",
				"display_order" => "3",
				"field_active" => "yes",
				"field_for" => "[\"shortcode\",\"modal\",\"add_listing\"]",
				"required" => "yes",
				"validation_pattern" => "",
				"field_type" => "password",
				"disabled" => "delete"
			),
			'pass2' => array(
				"field_name" => "registerpasswordconfirm",
				"frontend_title" => "Confirm password",
				"display_order" => "4",
				"field_active" => "yes",
				"field_for" => "[\"shortcode\",\"modal\",\"add_listing\"]",
				"required" => "yes",
				"validation_pattern" => "",
				"field_type" => "password",
				"disabled" => "delete"
			),
		);

		$reg_field = $wpdb->get_results("SELECT count(*) as count FROM ".$registration_table);
		if ( intval($reg_field['0']->count) == 0 ) {
			foreach ($default_registration_fields as $custom_key => $custom_value) {
				$wpdb->query('INSERT INTO '.$registration_table.' (`field_order`, `field_active`, `field_settings`) VALUES ("'.$custom_value['display_order'].'", "yes", "'.addslashes(json_encode($custom_value)).'")' );
			}
		}

		$main_templates = get_option( 'db_main_templates' );
		if ( $main_templates === false ) {
			$main_templates = array(
				'new_user' => 'Hello, {username}

You successfully registered a new account and can now start adding and claiming listings!
Make sure you visit your dashboard: {url_dashboard}',
				'new_payment' => 'Hello {username},

We have received a payment of {price} for listing {listing_title}',
				'new_claim' => 'Hello, {username}

Nice to see you claimed {listing_title} for yourself, this listing is added to your listings at your dashboard and you can manage it as your own!
Visit your dashboard: {url_dashboard}',
				'new_listing' => 'Hello, {username}

You can access your new listing here: {url_listing}
It\'s also added to your dashboard: {url_dashboard}'
				
			);
			update_option( 'db_main_templates', $main_templates );
		}

		$main_templates = get_option( 'db_main_templates' );
		if ( !isset($main_templates['new_user_confirm']) ) {
			$main_templates['new_user_confirm'] = 'Hello, {username}

To complete your registration and validate your account, please follow this url {url_confirm}';
			update_option( 'db_main_templates', $main_templates );
		}

		$default_pages = get_option('db_pages_created');
		if ( !$default_pages ) {
			
			$add_listing_page = array(
				'post_author' => get_current_user_id(),
				'post_content' => '[directory_add_listing]',
				'post_title' => 'Directory builder add listing',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			$add_id = wp_insert_post($add_listing_page);

			if ( $add_id ) {
				$main_settings = get_option( 'db_main_settings' );
				$main_settings['add_page_id'] = $add_id;
				update_option( 'db_main_settings', $main_settings );
			}

			$login_page = array(
				'post_author' => get_current_user_id(),
				'post_content' => '[directory_login]',
				'post_title' => 'Directory builder login',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			$login_id = wp_insert_post($login_page);

			if ( $login_id ) {
				$main_settings = get_option( 'db_main_settings' );
				$main_settings['login_page_id'] = $login_id;
				update_option( 'db_main_settings', $main_settings );
			}

			$register_page = array(
				'post_author' => get_current_user_id(),
				'post_content' => '[directory_register]',
				'post_title' => 'Directory builder register',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			wp_insert_post($register_page);

			$search_page = array(
				'post_author' => get_current_user_id(),
				'post_content' => '[directory_listings]',
				'post_title' => 'Directory builder search',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			$search_id = wp_insert_post($search_page);

			if ( $search_id ) {
				$main_settings = get_option( 'db_main_settings' );
				$main_settings['search_page_id'] = $search_id;
				update_option( 'db_main_settings', $main_settings );
			}

			$account_page = array(
				'post_author' => get_current_user_id(),
				'post_content' => '[directory_account]',
				'post_title' => 'Directory builder user account',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			$account_id = wp_insert_post($account_page);

			if ( $account_id ) {
				$main_settings = get_option( 'db_main_settings' );
				$main_settings['account_page_id'] = $account_id;
				update_option( 'db_main_settings', $main_settings );
			}

			$success_page = array(
				'post_author' => get_current_user_id(),
				'post_content' => '<div align="center">Please give us 1 business day to review it.<br> This page is a standard WordPress page and it\'s contents can be completely changed.</div>',
				'post_title' => 'Thank you. Your listing has been received.',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			$success_id = wp_insert_post($success_page);

			if ( $success_id ) {
				$main_settings = get_option( 'db_main_settings' );
				$main_settings['order_success_url'] = $success_id;
				update_option( 'db_main_settings', $main_settings );
			}

			update_option('db_pages_created', 'true');			
		}

		// Check if Address, Phone and URL fields have default icon
		$custom_fields = $wpdb->get_results( 'SELECT ID, field_settings FROM ' . $field_table . ' WHERE ( field_settings LIKE "%\"field_name\":\"listing_address\"%" OR field_settings LIKE "%\"field_name\":\"listingphone\"%" OR field_settings LIKE "%\"field_name\":\"listingwebsite\"%" ) ' );
		if ( !empty($custom_fields) ) {
			foreach ( $custom_fields as $field_data ) {
				$field_settings = json_decode( $field_data->field_settings, true );
				
				if ( $field_settings['field_name'] == 'listing_address' && !isset($field_settings['field_icon']) ) {
					$field_settings['field_icon'] = 'wl-location';
					$wpdb->query('UPDATE '.$field_table.' SET field_settings="'.addslashes(json_encode($field_settings)).'" WHERE ID="'.$field_data->ID.'"' );
				} else if ( $field_settings['field_name'] == 'listingphone' && !isset($field_settings['field_icon']) ) {
					$field_settings['field_icon'] = 'wl-phone';
					$wpdb->query('UPDATE '.$field_table.' SET field_settings="'.addslashes(json_encode($field_settings)).'" WHERE ID="'.$field_data->ID.'"' );
				} else if ( $field_settings['field_name'] == 'listingwebsite' && !isset($field_settings['field_icon']) ) {
					$field_settings['field_icon'] = 'wl-link';
					$wpdb->query('UPDATE '.$field_table.' SET field_settings="'.addslashes(json_encode($field_settings)).'" WHERE ID="'.$field_data->ID.'"' );
				}
			}
		}

		// Create a custom role for listing authors
		add_role( 'db_listing_author', esc_html__( 'Listing author', 'directory-builder' ), array( 'read' => true ) );

		update_option( 'db_plugin_version', DB_CURRENT_VERSION );
	}

}
