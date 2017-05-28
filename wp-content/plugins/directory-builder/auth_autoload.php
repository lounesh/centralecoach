<?php
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

$main_settings = get_option( 'db_main_settings');
$card_data = json_decode( stripslashes( $_POST['card_data'] ), true );

$get_order_meta = get_post_meta( $card_data['db-listing-id'], 'db_order_info', true );
global $wpdb;
if ( !isset($get_order_meta['listing_package']) ) {
	$package_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages LIMIT 1');
} else {
	$package_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'directory_packages WHERE ID="'.$get_order_meta['listing_package'].'"');
}

if ( !empty($package_data) ) {
	$package_settings = json_decode( $package_data['0']->package_settings, true );

	$no_payment_needed = false;
	$payment_type = (isset($package_settings['payment_type'])?$package_settings['payment_type']:'onetime');
	if ( !isset($package_settings['trial_period']) || ( isset($package_settings['trial_period']) && $package_settings['trial_period'] == false ) ) {
		$single_payment = db_process_single_payment( $main_settings, $card_data );
	} else {
		$no_payment_needed = true;
	}
}

if ( $no_payment_needed || ( $single_payment != null && $single_payment->getMessages()->getResultCode() == 'Ok' ) ) {
	if ( !$no_payment_needed ) {
		$tresponse = $single_payment->getTransactionResponse();
	}
	
	if ( $payment_type == 'onetime' ) {
		if ( $no_payment_needed || ( $tresponse != null && $tresponse->getResponseCode() == "1" ) ) {
			$payment_status = true;
		} else {
			$payment_status = false;
		}
	} else {
		$payment_status = false;

		$subscription_payment = db_process_subscription( $main_settings, $card_data, $package_settings );
		if ( $subscription_payment != null && $subscription_payment->getMessages()->getResultCode() == 'Ok' ) {
			$payment_status = true;

			db_update_ipn_notes( $card_data['db-listing-id'], esc_html__('Signup for subscription completed!', 'directory-builder') );

			$sub_data = array(
				'status' => 'active',
				'payment_cycle' => $package_settings['payment_cycle'],
				'payment_interval' => $package_settings['payment_interval'],
				'starting' => time(),
				'next_payment' => strtotime('+ ' . $package_settings['payment_interval'] . ' ' . $package_settings['payment_cycle']),
				'geteway' => 'Authorize.net'
			);
			update_post_meta( $card_data['db-listing-id'], 'db_subscription', $sub_data );
		} else {
			echo '{"save_response": "failed", "message": "'.__('Something went wrong while processing your subscription!', 'directory-builder').'"}';
			die(0);
		}
	}

	if ( $payment_status ) { // Payment succeeded
		$listing_billing = get_post_meta( $card_data['db-listing-id'], 'db_billing_info', true );

		if ( !$no_payment_needed ) {
			$listing_billing['auth-code'] = $tresponse->getAuthCode();
			$listing_billing['trans-id'] = $tresponse->getTransId();
		}

		if ( $payment_type != 'onetime' ) {
			$listing_billing['subscription'] = $subscription_payment->getSubscriptionId();
		}
		$listing_billing['card'] = $card_data['x_card_num'];
		$listing_billing['card_expiration'] = $card_data['x_year']."-".$card_data['x_month'];
		update_post_meta( $card_data['db-listing-id'], 'db_billing_info', $listing_billing );

		$payment_status = 'Completed';
		$payment_amount = $card_data['db-package-fee'];
		$listing_id = $card_data['db-listing-id'];

		if ( function_exists( 'db_send_notification_email' ) ) {
			$curr_post = get_post( $listing_id );
			$current_user = get_userdata( $curr_post->post_author );
			db_send_notification_email( $curr_post->post_author, 'new_payment', array( 'username' => $current_user->data->user_login, 'price' => $main_settings['default_currency_symbol'].$payment_amount, 'url_listing' => get_permalink($listing_id), 'listing_title' => get_the_title($listing_id) ) );
		}

		$order_info = get_post_meta( $listing_id, 'db_order_info', true);

		$db_listing = array(
			'ID'           => $listing_id,
			'post_status'  => 'publish'
		);

		$order_info['payment_status'] = $payment_status;
		if ( $payment_status == 'Completed' ) {
			$order_info['completed_on'] = time();

			if ( !empty($package_data) ) {
				$package_data = json_decode($package_data['0']->package_settings, true);

				if ( $payment_type != 'onetime' ) {
					if ( $package_data['payment_cycle'] == 'days' ) {
						$day_value = 1;
					} else if ( $package_data['payment_cycle'] == 'weeks' ) {
						$day_value = 7;
					} else if ( $package_data['payment_cycle'] == 'months' ) {
						$day_value = 30;
					} else if ( $package_data['payment_cycle'] == 'years' ) {
						$day_value = 365;
					}

					$package_data['listing_run_days'] = $day_value*intval($package_data['payment_interval']);
				}

				if ( isset($order_info['listing_expires']) && is_numeric($order_info['listing_expires']) ) {
					if ( $package_data['listing_run_type'] == 'days' ) {
						$new_expire_date = strtotime('+ '.$package_data['listing_run_days'].' days', $order_info['listing_expires']);
						$order_info['listing_expires'] = $new_expire_date;
					}
				} else if ( isset($order_info['listing_expires']) && !is_numeric($order_info['listing_expires']) ) {
					if ( $package_data['listing_run_type'] == 'days' ) {
						$new_expire_date = strtotime('+ '.$package_data['listing_run_days'].' days', time());
						$order_info['listing_expires'] = $new_expire_date;
					}
				}
			}

			$claim_value = get_current_user_id() . ':' . time();
			if ( isset($card_data['db-listing-claim']) ) {
				if ( $main_settings['claims_processing'] == 'manual' ) {
					$claim_value = get_current_user_id() . ':waiting';
				} else {
					$db_listing['post_author'] = get_current_user_id();
					$claim_value = get_current_user_id() . ':' . time();

					if ( function_exists( 'db_send_notification_email' ) ) {
						$current_user = get_userdata( get_current_user_id() );
						db_send_notification_email( get_current_user_id(), 'new_claim', array( 'username' => $current_user->data->user_login, 'url_dashboard' => get_permalink( $main_settings['account_page_id'] ), 'listing_title' => get_the_title($listing_id), 'listing' => get_permalink($listing_id) ) );
					}
				}
			} else {
				$claim_value = get_current_user_id() . ':author';
			}

			update_post_meta( $listing_id, 'db_claim_info', $claim_value );
		}

		update_post_meta( $listing_id, 'db_order_info', $order_info );
		
		wp_update_post( $db_listing );

		echo '{"save_response": "'.$card_data['db-listing-id'].'", "redirect": "true"}';
	} else {
		echo '{"save_response": "failed", "message": "'.__('Charge Credit Card ERROR: Invalid response', 'directory-builder').'"}';
	}
} else {
	echo '{"save_response": "failed", "message": "'.__('Something went wrong while processing your card!', 'directory-builder').'"}';
}

function db_process_single_payment( $main_settings, $card_data ) {
	// API details
	$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
	$merchantAuthentication->setName($main_settings['authorize_id']);
	$merchantAuthentication->setTransactionKey($main_settings['authorize_key']);

	// Credit card data
	$creditCard = new AnetAPI\CreditCardType();
	$creditCard->setCardNumber($card_data['x_card_num']);
	$creditCard->setExpirationDate($card_data['x_year']."-".$card_data['x_month']);
	// $creditCard->setCardNumber($card_data['x_cvv']);
	$paymentOne = new AnetAPI\PaymentType();
	$paymentOne->setCreditCard($creditCard);

	// Order info
	$order = new AnetAPI\OrderType();
	$order->setInvoiceNumber($card_data['db-listing-id']);

	// User info
	$customer = new AnetAPI\CustomerDataType();
	$customer->setId(get_current_user_id());

	// Create a transaction
	$transactionRequestType = new AnetAPI\TransactionRequestType();
	$transactionRequestType->setTransactionType( "authCaptureTransaction"); 
	$transactionRequestType->setAmount($card_data['db-package-fee']);
	$transactionRequestType->setPayment($paymentOne);
	$transactionRequestType->setOrder($order);
	$transactionRequestType->setCustomer($customer);

	$request = new AnetAPI\CreateTransactionRequest();
	$request->setMerchantAuthentication($merchantAuthentication);
	$request->setRefId( 'ref' . time() );
	$request->setTransactionRequest( $transactionRequestType);
	$controller = new AnetController\CreateTransactionController($request);

	if ( $main_settings['payment_mode'] == 'sandbox' ) {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	} else {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
	}

	return $response;
}

function db_process_subscription( $main_settings, $card_data, $package_settings ) {
	$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
	$merchantAuthentication->setName($main_settings['authorize_id']);
	$merchantAuthentication->setTransactionKey($main_settings['authorize_key']);

	$request = new AnetAPI\CreateTransactionRequest();
	$request->setMerchantAuthentication($merchantAuthentication);

	$creditCard = new AnetAPI\CreditCardType();
	$creditCard->setCardNumber($card_data['x_card_num']);
	$creditCard->setExpirationDate($card_data['x_year']."-".$card_data['x_month']);
	$paymentOne = new AnetAPI\PaymentType();
	$paymentOne->setCreditCard($creditCard);

	$subscription_status = false;
	$subscription = new AnetAPI\ARBSubscriptionType();
	$subscription->setName($package_settings['fee_label'].' package subscription');
	$interval = new AnetAPI\PaymentScheduleType\IntervalAType();

	if ( $package_settings['payment_cycle'] == 'years' ) {
		$package_settings['payment_cycle'] = 'months';
		$package_settings['payment_interval'] = '12';
	} else if ( $package_settings['payment_cycle'] == 'weeks' ) {
		$package_settings['payment_cycle'] = 'days';
		$package_settings['payment_interval'] = $package_settings['payment_interval']*7;
	}

	$interval->setLength($package_settings['payment_interval']);
	$interval->setUnit($package_settings['payment_cycle']);

	$paymentSchedule = new AnetAPI\PaymentScheduleType();
	$paymentSchedule->setInterval($interval);
	$paymentSchedule->setStartDate(new DateTime(date('Y-m-d', strtotime('+ ' . $package_settings['payment_interval'] . ' ' . $package_settings['payment_cycle']))));
	$paymentSchedule->setTotalOccurrences("24");
	$paymentSchedule->setTrialOccurrences("1");
	$subscription->setPaymentSchedule($paymentSchedule);
	$subscription->setAmount($card_data['db-package-fee']);
	$subscription->setTrialAmount("0.00");
	
	$creditCard = new AnetAPI\CreditCardType();
	$creditCard->setCardNumber($card_data['x_card_num']);
	$creditCard->setExpirationDate($card_data['x_year']."-".$card_data['x_month']);
	$payment = new AnetAPI\PaymentType();
	$payment->setCreditCard($creditCard);
	$subscription->setPayment($payment);
	$order = new AnetAPI\OrderType();
	$order->setInvoiceNumber($card_data['db-listing-id'].time());
	$order->setDescription($package_settings['fee_label'].' package subscription for your listing!'); 
	$order->setInvoiceNumber($card_data['db-listing-id']);
	$subscription->setOrder($order);
	
	$billing_data = json_decode( stripslashes( $_POST['field_data'] ), true );
	$name_comp = explode(' ', $billing_data['x_full_name']);
	$billTo = new AnetAPI\NameAndAddressType();
	$billTo->setFirstName($name_comp['0']);
	$first_name = $name_comp['0'];
	unset($name_comp['0']);
	$billTo->setLastName((empty($name_comp)?$first_name:implode(' ', $name_comp)));
	$subscription->setBillTo($billTo);
	$request = new AnetAPI\ARBCreateSubscriptionRequest();
	$request->setmerchantAuthentication($merchantAuthentication);
	$request->setRefId('ref' . time());
	$request->setSubscription($subscription);
	$controller = new AnetController\ARBCreateSubscriptionController($request);

	if ( $main_settings['payment_mode'] == 'sandbox' ) {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	} else {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
	}

	return $response;
}