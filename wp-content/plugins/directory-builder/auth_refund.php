<?php
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

$main_settings = get_option( 'db_main_settings');
$post_id = ( isset($_POST['listing_id']) ? intval( $_POST['listing_id'] ) : '' );
$ref_amount = ( isset($_POST['ref_amount']) ? esc_attr( $_POST['ref_amount'] ) : '' );
$ref_reason = ( isset($_POST['ref_reason']) ? esc_attr( $_POST['ref_reason'] ) : '' );

$listing_billing = get_post_meta( $post_id, 'db_billing_info', true );

if ( isset($listing_billing['card']) && isset($listing_billing['card_expiration']) ) {
	$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
	$merchantAuthentication->setName($main_settings['authorize_id']); 
	$merchantAuthentication->setTransactionKey($main_settings['authorize_key']);
	$refId = 'ref' . time();

	$creditCard = new AnetAPI\CreditCardType();
	$creditCard->setCardNumber( $listing_billing['card'] );
	$creditCard->setExpirationDate( $listing_billing['card_expiration'] );
	$paymentOne = new AnetAPI\PaymentType();
	$paymentOne->setCreditCard($creditCard);
	//create a transaction
	$transactionRequestType = new AnetAPI\TransactionRequestType();
	$transactionRequestType->setTransactionType( "refundTransaction" ); 
	$transactionRequestType->setAmount($ref_amount);
	$transactionRequestType->setPayment($paymentOne);
	$request = new AnetAPI\CreateTransactionRequest();
	$request->setMerchantAuthentication($merchantAuthentication);
	$request->setRefId( $refId );
	$request->setTransactionRequest( $transactionRequestType);
	$controller = new AnetController\CreateTransactionController($request);

	if ( $main_settings['payment_mode'] == 'sandbox' ) {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	} else {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
	}
	
	if ( $response != null ) {
		$tresponse = $response->getTransactionResponse();
		if ( $tresponse != null && $tresponse->getResponseCode() == "1" ) {
			echo json_encode( array( 'save_response' => 'success', 'message' => esc_html__('Money refunded!', 'directory-builder') ) );

			$refunds = get_post_meta( $post_id, 'db_refunds', true );
			$refunds[time()] = array( 'amount' => $ref_amount, 'reason' => $ref_reason );
			update_post_meta( $post_id, 'db_refunds', $refunds );

			db_update_ipn_notes( $post_id, sprintf( __('Payment of %s refunded! %s', 'directory-builder'), $main_settings['default_currency_symbol'].$ref_amount, ($ref_reason!=''?esc_html__('Reason', 'directory-builder').': '.$ref_reason:'') ) );

			$order_info = get_post_meta( $post_id, 'db_order_info', true);
			$old_history = $order_info['payment_history'];
			$old_history[] = date('D, d M Y H:i:s', time()).'==='.$ref_amount.'===Refunded===Authorize.Net==='.get_current_user_id();
			$order_info['payment_history'] = $old_history;

			update_post_meta( $post_id, 'db_order_info', $order_info );
		} else {
			echo json_encode( array( 'save_response' => 'failed', 'message' => esc_html__('There was an issue, error ', 'directory-builder') . $tresponse->getResponseCode() ) );
		}
	} else {
		echo json_encode( array( 'save_response' => 'failed', 'message' => esc_html__('There was an issue, please try later!', 'directory-builder') ) );
	}
} else {
	echo json_encode( array( 'save_response' => 'failed', 'message' => esc_html__('There\'s no credit card data!', 'directory-builder') ) );
}
