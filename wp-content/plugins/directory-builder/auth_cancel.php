<?php
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

$main_settings = get_option( 'db_main_settings');
$post_id = ( isset($_POST['sub_id']) ? intval( $_POST['sub_id'] ) : '' );
$listing_billing = get_post_meta( $post_id, 'db_billing_info', true );

if ( isset($listing_billing['subscription']) ) {
	$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
	$merchantAuthentication->setName($main_settings['authorize_id']); 
	$merchantAuthentication->setTransactionKey($main_settings['authorize_key']);
	$refId = 'ref' . time();

	$request = new AnetAPI\ARBCancelSubscriptionRequest();
	$request->setMerchantAuthentication($merchantAuthentication);
	$request->setRefId($refId);
	$request->setSubscriptionId($listing_billing['subscription']);

	$controller = new AnetController\ARBCancelSubscriptionController($request);
	if ( $main_settings['payment_mode'] == 'sandbox' ) {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	} else {
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
	}
	
	if ( $response != null && $response->getMessages()->getResultCode() == "Ok" ) {
		echo json_encode( array( 'save_response' => 'success', 'message' => esc_html__('Subscription cancelled!', 'directory-builder') ) );
		$sub_data = get_post_meta( $post_id, 'db_subscription', true );
		$sub_data['status'] = 'cancelled';
		update_post_meta( $post_id, 'db_subscription', $sub_data );
		db_update_ipn_notes( $post_id, esc_html__('Subscription cancelled!', 'directory-builder') );
	} else {
		echo json_encode( array( 'save_response' => 'failed', 'message' => $response->getMessages()->getMessage()[0]->getText() ) );
	}
} else {
	echo json_encode( array( 'save_response' => 'failed', 'message' => esc_html__('There\'s no subscription ID!', 'directory-builder') ) );
}
