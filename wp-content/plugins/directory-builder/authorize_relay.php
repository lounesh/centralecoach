<?php

// $log_file = fopen("log.txt", "a") or die("Unable to open file!");
// fwrite($log_file, '['.date('d/M/Y H:i:s').'] - POST - '.json_encode($_POST).PHP_EOL.PHP_EOL);
// fclose($log_file);

$ipn_note = esc_attr( $_POST['x_response_reason_text'] );
if ( $_POST['x_response_code'] == 1 ) {
	$payment_status = 'Completed';
	$ipn_note = esc_html__('Payment received!', 'directory-builder');
} else if ( $_POST['x_response_code'] == 2 ) {
	$payment_status = 'Declined';
	$ipn_note = sprintf( __('Payment declined, %s', 'directory-builder'), esc_attr( $_POST['x_response_reason_text'] ) );
} else if ( $_POST['x_response_code'] == 3 ) {
	$payment_status = 'Error';
	$ipn_note = sprintf( __('Payment error, %s', 'directory-builder'), esc_attr( $_POST['x_response_reason_text'] ) );
} else if ( $_POST['x_response_code'] == 4 ) {
	$payment_status = 'Held';
	$ipn_note = sprintf( __('Payment held, %s', 'directory-builder'), esc_attr( $_POST['x_response_reason_text'] ) );
}

$payment_amount = $_POST['x_amount'];
$listing_id = $_POST['x_invoice_num'];

db_update_ipn_notes( $listing_id, $ipn_note );

$order_info = get_post_meta( $listing_id, 'db_order_info', true);

if ( $payment_status == 'Completed' ) {
	if ( empty($order_info['payment_history']) ) {
		$order_info['payment_history'] = array(
			date('D, d M Y H:i:s', time()).'==='.$payment_amount.'==='.$payment_status.'===Authorize.Net'
		);
	} else {
		$old_history = $order_info['payment_history'];
		$last_value = explode('===', $old_history[count($old_history)]);
		if ( $last_value['2'] != $payment_status ) {
			$old_history[] = date('D, d M Y H:i:s', time()).'==='.$payment_amount.'==='.$payment_status.'===Authorize.Net';
			$order_info['payment_history'] = $old_history;
		}
	}

	if ( function_exists( 'db_send_notification_email' ) ) {
		$main_settings = get_option( 'db_main_settings');
		$curr_post = get_post( $listing_id );
		$current_user = get_userdata( $curr_post->post_author );
		db_send_notification_email( $curr_post->post_author, 'new_payment', array( 'username' => $current_user->data->user_login, 'price' => $main_settings['default_currency_symbol'].$payment_amount, 'url_listing' => get_permalink($listing_id), 'listing_title' => get_the_title($listing_id) ) );
	}
}

$order_info['payment_status'] = $payment_status;

update_post_meta( $listing_id, 'db_order_info', $order_info );

if ( $payment_status == 'Completed' ) {
	$db_post_status = 'publish';
} else if ( $payment_status == 'Declined' || $payment_status == 'Error' || $payment_status == 'Held' ) {
	$db_post_status = 'pending';
}

$db_listing = array(
	'ID'           => $listing_id,
	'post_status'  => $db_post_status
);
wp_update_post( $db_listing );

if ( isset($_POST['return']) && esc_url($_POST['return']) != '' ) {
	?>
	<style type="text/css">
		body { display: none !important; }
	</style>
	<script type="text/javascript">
		window.location.replace("<?php echo esc_url($_POST['return']); ?>");
	</script>
	<?php
}