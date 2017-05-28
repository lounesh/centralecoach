<?php
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
define("DEBUG", 1);
// Set to 0 once you're ready to go live
$main_settings = get_option( 'db_main_settings');
define("LOG_FILE", plugin_dir_path( __FILE__ )."ipn.log");
// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}
// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
if( $main_settings['payment_mode'] == 'sandbox' ) {
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
	return FALSE;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if(DEBUG == true) {
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.
//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);

$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
	{
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
	}
	curl_close($ch);
	exit;
} else {
		// Log the entire HTTP response if debug is switched on.
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
		}
		curl_close($ch);
}
// Inspect IPN validation result and act accordingly
// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
file_put_contents(LOG_FILE, $res);
if (strcmp ($res, "VERIFIED") == 0) {
	$custom_value = explode(':', $_POST['custom']);
	$listing_id = intval($custom_value['0']);

	// $log_file = fopen("log.txt", "a") or die("Unable to open file!");
	// fwrite($log_file, '['.date('d/M/Y H:i:s').'] - PAYPAL POST - '.json_encode($_POST).PHP_EOL.PHP_EOL);
	// fclose($log_file);

	if ( isset($_POST['payment_status']) ) {
		$payment_status = sanitize_text_field($_POST['payment_status']);
		$payment_amount = sanitize_text_field($_POST['mc_gross'].' '.$_POST['mc_currency']);

		db_update_ipn_notes( $listing_id, 'Payment ' . strtolower( $payment_status ) );

		$order_info = get_post_meta( $listing_id, 'db_order_info', true);
		if ( empty($order_info['payment_history']) ) {
			$order_info['payment_history'] = array(
				esc_attr( $_POST['payment_date'] ).'==='.$payment_amount.'==='.$payment_status.'===PayPal'
			);
		} else {
			$old_history = $order_info['payment_history'];
			$last_value = explode('===', $old_history[count($old_history)]);
			if ( $last_value['2'] != $payment_status ) {
				$old_history[] = esc_attr( $_POST['payment_date'] ).'==='.$payment_amount.'==='.$payment_status.'===PayPal';
				$order_info['payment_history'] = $old_history;
			}
		}
		$order_info['payment_status'] = $payment_status;
		if ( $payment_status == 'Completed' ) {
			$order_info['completed_on'] = time();

			if ( function_exists( 'db_send_notification_email' ) ) {
				$current_user = get_userdata( $custom_value['1'] );
				db_send_notification_email( $custom_value['1'], 'new_payment', array( 'username' => $current_user->data->user_login, 'price' => $payment_amount, 'url_listing' => get_permalink($listing_id), 'listing_title' => get_the_title($listing_id) ) );
			}

			global $wpdb;
			$package_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.$order_info['listing_package'].'"');
			if ( !empty($package_data) ) {
				$package_data = json_decode($package_data['0']->package_settings, true);

				if ( $package_data['payment_type'] != 'onetime' ) {
					if ( $package_data['payment_cycle'] == 'days' ) {
						$start_value = 1;
					} else if ( $package_data['payment_cycle'] == 'weeks' ) {
						$start_value = 7;
					} else if ( $package_data['payment_cycle'] == 'months' ) {
						$start_value = 30;
					} else if ( $package_data['payment_cycle'] == 'years' ) {
						$start_value = 365;
					}

					$package_data['listing_run_days'] = $start_value*intval($package_data['payment_interval']);
				}

				if ( isset($order_info['listing_expires']) && is_numeric($order_info['listing_expires']) ) {
					if ( $package_data['listing_run_type'] == 'days' ) {
						$new_expire_date = strtotime('+'.$package_data['listing_run_days'].' days', $order_info['listing_expires']);
						$order_info['listing_expires'] = $new_expire_date;
					}
				} else if ( isset($order_info['listing_expires']) && !is_numeric($order_info['listing_expires']) ) {
					if ( $package_data['listing_run_type'] == 'days' ) {
						$new_expire_date = strtotime('+'.$package_data['listing_run_days'].' days', time());
						$order_info['listing_expires'] = $new_expire_date;
					}
				}
			}
			
			if ( isset($custom_value['2']) && $custom_value['2'] == 'author' ) {
				$claim_value = $custom_value['1'].':author';
			} else if ( isset($custom_value['2']) && $custom_value['2'] == 'claim' ) {
				if ( $main_settings['claims_processing'] == 'manual' ) {
					$claim_value = $custom_value['1'] . ':waiting';
				} else {
					$claim_value = $custom_value['1'] . ':' . time();

					if ( function_exists( 'db_send_notification_email' ) ) {
						$current_user = get_userdata( $custom_value['1'] );
						db_send_notification_email( $custom_value['1'], 'new_claim', array( 'username' => $current_user->data->user_login, 'url_dashboard' => get_permalink( $main_settings['account_page_id'] ), 'listing_title' => get_the_title($listing_id), 'listing' => get_permalink($listing_id) ) );
					}
				}
			}
			update_post_meta( $listing_id, 'db_claim_info', $claim_value );
			
		}

		update_post_meta( $listing_id, 'db_order_info', $order_info );

		if ( $payment_status == 'Pending' ) {
			$db_post_status = 'pending';
		} else if ( $payment_status == 'Completed' ) {
			$db_post_status = 'publish';
		} else if ( $payment_status == 'Refunded' ) {
			$db_post_status = 'pending';
		}

		$db_listing = array(
			'ID'           => $listing_id,
			'post_status'  => $db_post_status
		);
		wp_update_post( $db_listing );
		
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
		}
	} else if ( isset($_POST['txn_type']) && $_POST['txn_type'] == 'subscr_signup' ) {
		$order_info = get_post_meta( $listing_id, 'db_order_info', true);
		global $wpdb;
		$package_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.$order_info['listing_package'].'"');
		if ( !empty($package_data) ) {
			$package_data = json_decode($package_data['0']->package_settings, true);

			$sub_data = array(
				'status' => 'active',
				'payment_cycle' => $package_data['payment_cycle'],
				'payment_interval' => $package_data['payment_interval'],
				'starting' => time(),
				'next_payment' => strtotime('+ ' . $package_data['payment_interval'] . ' ' . $package_data['payment_cycle']),
				'geteway' => 'PayPal'
			);
			update_post_meta( $listing_id, 'db_subscription', $sub_data );

			$listing_billing = get_post_meta( $listing_id, 'db_billing_info', true );
			$listing_billing['subscription'] = $_POST['subscr_id'];
			
			update_post_meta( $listing_id, 'db_billing_info', $listing_billing );

			db_update_ipn_notes( $listing_id, esc_html__('Signup for subscription completed!', 'directory-builder') );
		}
	} else if ( isset($_POST['txn_type']) && $_POST['txn_type'] == 'subscr_cancel' ) {
		$sub_data = get_post_meta( $listing_id, 'db_subscription', true );
		$sub_data['status'] = 'cancelled';
		update_post_meta( $listing_id, 'db_subscription', $sub_data );

		db_update_ipn_notes( $listing_id, esc_html__('Subscription cancelled!', 'directory-builder') );
	}
} else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
	// Add business logic here which deals with invalid IPN messages
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
	}
}
?>