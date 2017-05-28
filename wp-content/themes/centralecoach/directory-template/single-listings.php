<?php
/*
	Template for the single listing
*/

global $post, $wpdb;
get_header();
$main_settings = get_option( 'db_main_settings');
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

$all_fields = db_get_listing_custom_fields( get_the_ID(), 'on_detail' );
$contact_fields = db_get_listing_custom_fields( get_the_ID(), 'on_contact' );

$listing_lat = esc_html( get_post_meta( get_the_ID(), 'listing_address_lat', true) );
$listing_lng = esc_html( get_post_meta( get_the_ID(), 'listing_address_lng', true) );
$listing_category = get_option( "listing_category_".intval($first_cat_id));

if ( function_exists('db_get_active_ads') ) {
	$all_ads = db_get_active_ads( get_the_ID() );
} else {
	$all_ads = array();
}

wp_enqueue_script( 'db-google-maps' );
wp_enqueue_script( 'richmarkers' );

$claim_issue = '';
if ( isset($_GET['db-claim']) ) {
	if ( !is_user_logged_in() ) {
		?>

		<div id="main" class="site-main container db-claim-container">
			<div id="entry-content-wrapper">
				<h1 class="entry-title"><?php esc_html_e('Claim a listing', 'whitelab'); ?></h1>
				<p class="aligncenter"><?php esc_html_e('You need to login in order to claim a listing.', 'whitelab'); ?></p>
				<div class="db-claim-actions clearfix">
					<div class="db-claim-left">
						<h3><?php esc_html_e('Login', 'whitelab'); ?></h3>
						<?php echo do_shortcode('[directory_login]'); ?>
					</div>
					<div class="db-claim-right">
						<h3><?php esc_html_e('Register', 'whitelab'); ?></h3>
						<?php echo do_shortcode('[directory_register]'); ?>
					</div>
				</div>
			</div>
		</div>

		<?php
		get_footer();
		return;
	} else {
		$can_user_claim = true;
		$user_max_claims = db_get_claim_limit( get_current_user_id() );
		$claim_info = get_post_meta( get_the_ID(), 'db_claim_info', true );
		$claimed_listings = $wpdb->get_results( 'SELECT count(*) as claimed_listings FROM '.$wpdb->prefix.'postmeta WHERE meta_key="db_claim_info" && meta_value="'.intval(get_current_user_id()).'"' );
		if ( $claim_info == '' && intval($claimed_listings['0']->claimed_listings) < $user_max_claims ) { // Check if listing is not claimed and he hasn't claimed too much listings
			$package_list = $wpdb->get_results( esc_sql('SELECT * FROM '.$wpdb->prefix.'directory_packages ORDER BY ID ASC') );
			if ( !empty($package_list) ) {
				$output = '<div class="db-pricing-main-wrapper">';

				$output .= db_checkout_html( array(), true );

				$output .= '<div id="entry-content-wrapper">
							<h1 class="entry-title">'.esc_html__('Listing packages', 'whitelab').'</h1>';
				$output .= '<ul class="db-payment-packages">';
				foreach ($package_list as $package_value) {
					$package_settings = json_decode($package_value->package_settings, true);

					if ( $main_settings['claims_require_purchase'] && intval( $package_settings['fee_amount'] ) == 0 ) {
						continue;
					}

					$show_package = false;
					if ( !empty($package_settings['apply_categories']) ) {
						foreach ($package_settings['apply_categories'] as $cat_id) {
							if ( in_array($cat_id, $category_ids) ) {
								$show_package = true;
							}
						}
					}

					if ( !$show_package ) {
						continue;
					}

					$output .= '
					<li data-for="'.implode(',', isset($package_settings['apply_categories'])?$package_settings['apply_categories']:array()).'" class="'.($package_settings['listing_popular']?'popular':'').'">
						<div class="db-package-inner">
							<label for="db-package-'.esc_attr($package_value->ID).'"><input type="radio" id="db-package-'.esc_attr($package_value->ID).'" name="listing_package" value="'.esc_attr($package_value->ID).'"> '.esc_html($package_value->package_name).'</label>';
							if ( $package_settings['fee_description'] != '' ) {
								if ( $package_settings['listing_run_type'] == 'forever' ) {
									$run_listing = esc_html__('forever','whitelab');
								} else {
									$run_listing = $package_settings['listing_run_days'].' '.esc_html__('days','whitelab');
								}
								if ( !defined('WHITELAB_CUSTOM_ADD_LISTING') ) {
									$output .= '
									<div class="db-fee-description">
										<span class="db-fee-status-description">'.$package_settings['fee_description'].'</span>
										<span class="db-fee-status-name">'.esc_html__('Package price','whitelab').': '.esc_html( $main_settings['default_currency_symbol'].$package_settings['fee_amount'] ).'</span>
										<span class="db-fee-status-name">'.esc_html__('Run listing for','whitelab').': '.esc_html( $run_listing ).'</span>
										<span class="db-fee-status-name">'.esc_html__('Images allowed','whitelab').': '.esc_html( $package_settings['image_amount'] ).'</span>
										<span class="db-fee-status-name">'.esc_html__('Listing sticky?','whitelab').': '.esc_html( $package_settings['listing_sticky'] ).'</span>
									</div>';
								} else {
									$output .= '
									<div class="db-fee-description">';
										if ( isset($package_settings['package_img']) && $package_settings['package_img'] != '' ) {
											$output .= '<img src="'.esc_url($package_settings['package_img']).'" class="db-fee-image">';
										}
										$output .= '
										<span class="db-fee-value">'.($package_settings['fee_amount']!='0'?esc_html($main_settings['default_currency_symbol'].$package_settings['fee_amount']):esc_html__('Free', 'whitelab')).'</span>
										<span class="db-fee-description">'.$package_settings['fee_description'].'</span>
										<span class="db-fee-pay">'.esc_html__('One Time Payment','whitelab').'</span>
										<span class="db-fee-run-for">'.esc_html__('Run listing for','whitelab').' '.$run_listing.'</span>
										<span class="db-fee-images">'.esc_html( $package_settings['image_amount'].' '.esc_html__('Images allowed','whitelab') ).'</span>';
										if ( $package_settings['listing_sticky'] === true ) {
											$output .= '<span class="db-fee-sticky">'.esc_html__('Sticky listing','whitelab').'</span>';
										}
									$output .= '
										<a href="javascript:void(0)" class="db-choose-package" data-id="'.esc_attr($package_value->ID).'" data-amount="'.esc_html($package_settings['fee_amount']).'">'.esc_html__('Choose', 'whitelab').'</a>
									</div>';
								}
							}
					$output .= '
						</div>   
					</li>';
				}
				$output .= '</ul>
							<input type="hidden" name="db-active-package" value="">
							<input type="hidden" name="db-listing-id" value="'.esc_attr(get_the_ID()).'">
							<div class="clearfix"></div>
							</div>
						</div>';
				echo $output;
				get_footer();
				return;
			}
		} else if ( intval($claimed_listings['0']->claimed_listings) >= $user_max_claims ) {
			$claim_issue = '<div class="db-claim-issue">' . sprintf( wp_kses( __( 'You have reached your claimed listing limit, for more information contact site <a href="mailto:%s">administrator</a>', 'whitelab' ), array( 'a' => array( 'href' => array() ) ) ), get_bloginfo('admin_email') ) . '</div>';
		}
	}
}

$share_icons = array(
	'facebook'  => '<svg width="23px" height="23px" viewBox="0 0 23 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><g   transform="translate(-925.000000, -5164.000000)" fill="#909FA5"><g   transform="translate(0.000000, 5097.000000)"><g   transform="translate(925.000000, 67.000000)"><g id="facebook-logotype-button"><g  ><path d="M18.4624473,0 L4.26054679,0 C1.90729055,0 0,1.86969921 0,4.17657445 L0,18.0985656 C0,20.4054409 1.90729055,22.2751401 4.26054679,22.2751401 L18.4624473,22.2751401 C20.8157036,22.2751401 22.7229941,20.4053951 22.7229941,18.0985656 L22.7229941,4.17657445 C22.7230408,1.86969921 20.8157036,0 18.4624473,0 L18.4624473,0 Z M14.2984657,11.1361732 L12.4365846,11.1375471 L12.4351831,17.8200754 L9.88024717,17.8200754 L9.88024717,11.1375929 L8.17603779,11.1375929 L8.17603779,8.8348852 L9.88024717,8.83351129 L9.8773974,7.47751453 C9.8773974,5.59806061 10.3971768,4.45506465 12.6538679,4.45506465 L14.5342024,4.45506465 L14.5342024,6.75914629 L13.3582751,6.75914629 C12.479191,6.75914629 12.4365846,7.08073126 12.4365846,7.68076062 L12.4337348,8.83351129 L14.5469563,8.83351129 L14.2984657,11.1361732 L14.2984657,11.1361732 Z"  ></path></g></g></g></g></g></g></svg>',
	'gplus'  => '<svg width="24px" height="23px" viewBox="0 0 24 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><g   transform="translate(-958.000000, -5164.000000)" fill="#909FA5"><g   transform="translate(0.000000, 5097.000000)"><g   transform="translate(925.000000, 67.000000)"><g id="social-google-plus-square-button" transform="translate(33.416185, 0.696970)"><g  ><g id="Group"><path d="M18.4624473,0 L4.26054679,0 C1.90729055,0 0,1.86969921 0,4.17657445 L0,18.0985656 C0,20.4054409 1.90729055,22.2751401 4.26054679,22.2751401 L18.4624473,22.2751401 C20.8157036,22.2751401 22.7229941,20.4053951 22.7229941,18.0985656 L22.7229941,4.17657445 C22.7230408,1.86969921 20.8157036,0 18.4624473,0 L18.4624473,0 Z M8.19164145,18.6317775 C5.67650891,18.6317775 3.5547381,17.6280037 3.5547381,16.0242006 C3.5547381,14.3967206 5.49043292,12.8249294 8.00561218,12.8263033 L8.79098085,12.8193422 C8.44727987,12.49217 8.17463627,12.0898453 8.17463627,11.5928129 C8.17463627,11.2976527 8.27120143,11.0150408 8.40472018,10.7630669 L7.98575723,10.7769891 C5.91939343,10.7769891 4.5361336,9.33608512 4.5361336,7.54987344 C4.5361336,5.8026806 6.44627392,4.29491332 8.4771791,4.29491332 L13.0075664,4.29491332 L11.9907123,5.01328156 L10.5548953,5.01328156 C11.5078398,5.37246568 12.0148653,6.46114666 12.0148653,7.57771788 C12.0148653,8.51467413 11.485135,9.3221629 10.7366732,9.89572173 C10.0052633,10.456778 9.86753999,10.6906622 9.86753999,11.1668113 C9.86753999,11.5733493 10.6515071,12.2638731 11.0605193,12.5492786 C12.2577498,13.3790246 12.642609,14.1489142 12.642609,15.433926 C12.6425155,17.0377291 11.0590243,18.6317775 8.19164145,18.6317775 L8.19164145,18.6317775 Z M19.8826607,9.77184145 L17.0422806,9.77184145 L17.0422806,12.5520722 L15.6235154,12.5520722 L15.6235154,9.77184145 L12.7817338,9.77184145 L12.7817338,8.3531947 L15.6235154,8.3531947 L15.6235154,5.56879647 L17.0422806,5.56879647 L17.0422806,8.3531947 L19.8826607,8.3531947 L19.8826607,9.77184145 L19.8826607,9.77184145 Z"  ></path><path d="M10.3872727,7.6640448 C10.185593,6.16323863 9.07642506,4.95759268 7.91044854,4.92278713 C6.74447202,4.88935549 5.96195312,6.03793865 6.16363276,7.54149263 C6.36531241,9.0436727 7.4744804,10.2897114 8.64185845,10.3230973 C9.80638673,10.3579486 10.5903539,9.16764458 10.3872727,7.6640448 L10.3872727,7.6640448 Z"  ></path><path d="M9.61325639,13.4194173 C9.2695554,13.3108332 8.89039579,13.2453896 8.48563497,13.2412221 C6.74732179,13.2231324 5.19078658,14.2798014 5.19078658,15.5508909 C5.19078658,16.8484052 6.4462272,17.9259576 8.18454039,17.9259576 C10.6286623,17.9259576 11.4793888,16.9124291 11.4793888,15.6177084 C11.4793888,15.4617704 11.4580856,15.308626 11.4239818,15.1596949 C11.2337012,14.424565 10.5562501,14.0612134 9.61325639,13.4194173 L9.61325639,13.4194173 Z"  ></path></g></g></g></g></g></g></g></svg>',
	'twitter'   => '<svg width="23px" height="23px" viewBox="0 0 23 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><g   transform="translate(-1025.000000, -5164.000000)" fill="#909FA5"><g   transform="translate(0.000000, 5097.000000)"><g   transform="translate(925.000000, 67.000000)"><g id="twitter-logo" transform="translate(100.248555, 0.000000)"><g  ><path d="M18.4624473,0 L4.26054679,0 C1.90729055,0 0,1.86969921 0,4.17657445 L0,18.0985656 C0,20.4054409 1.90729055,22.2751401 4.26054679,22.2751401 L18.4624473,22.2751401 C20.8157036,22.2751401 22.7229941,20.4053951 22.7229941,18.0985656 L22.7229941,4.17657445 C22.7230408,1.86969921 20.8157036,0 18.4624473,0 L18.4624473,0 Z M17.0138763,8.63718051 L17.0223789,8.99219713 C17.0223789,12.61747 14.2090016,16.7940902 9.06362446,16.7940902 C7.48438452,16.7940902 6.01446364,16.3402442 4.77607492,15.5619737 C4.99480647,15.5870246 5.2177426,15.6009468 5.44357522,15.6009468 C6.75442286,15.6009468 7.96015601,15.1623969 8.91735182,14.4273128 C7.69316523,14.4050556 6.66066074,13.611489 6.30420586,12.522808 C6.476033,12.5534461 6.64930838,12.5701619 6.83108635,12.5701619 C7.08672476,12.5701619 7.33381387,12.53815 7.56814908,12.4755 C6.28855548,12.2221064 5.32425861,11.1153357 5.32425861,9.78718337 L5.32425861,9.75237782 C5.70201669,9.95841752 6.13233201,10.0809239 6.5910516,10.0962658 C5.84118826,9.60482061 5.34696334,8.76531989 5.34696334,7.81444142 C5.34696334,7.31186759 5.48473338,6.84130571 5.72472142,6.43618742 C7.10372995,8.09567942 9.16584245,9.187154 11.4906944,9.30132537 C11.4423885,9.10082708 11.4182822,8.89061987 11.4182822,8.67624516 C11.4182822,7.16293647 12.6708731,5.93498749 14.2160559,5.93498749 C15.019878,5.93498749 15.7470366,6.26770108 16.2582668,6.80091295 C16.894513,6.67698687 17.4938524,6.44868994 18.034935,6.13543999 C17.8261543,6.77586211 17.3830851,7.31324149 16.8050489,7.65291618 C17.368883,7.58747259 17.9099656,7.43849568 18.4112916,7.22132736 C18.0363833,7.76983536 17.5606118,8.25294555 17.0138763,8.63718051 L17.0138763,8.63718051 Z"  ></path></g></g></g></g></g></g></svg>'
);

$listing_ratings = get_post_meta( get_the_ID(), 'directory_post_likes', true);
if ( $listing_ratings != '' ) {
	$liked = $listing_ratings;
} else {
	$liked = array();
}

$custom_img = esc_attr( get_post_meta( get_the_ID(), 'db_listing_custom_img', true ) );
$img = wp_get_attachment_image_src( ($custom_img==''?get_post_thumbnail_id():$custom_img), 'full' );
?>

<div class="db-single-listing-wrapper">
	<div class="db-listing-featured-img">
		<div class="db-single-overlay"></div>
	</div>
	<div class="db-single-listing-container">
		<div class="db-single-listing-head">
			<span class="db-single-listing-category"><?php echo $categories; ?></span>
			<h1 class="single-listing-title"><?php the_title(); ?></h1>
		</div>
		<div class="db-single-listing-left">
			<div class="db-single-listing-main clearfix">
				<?php echo $claim_issue . apply_filters( 'the_content', $post->post_content ); ?>
				<div class="db-single-listing-meta">
					<div class="db-single-listing-like<?php echo(isset($liked[get_current_user_id()])?' liked':''); ?>" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-favorite="<?php esc_html_e('Favorite', 'whitelab'); ?>" data-favorited="<?php esc_html_e('Favorited', 'whitelab'); ?>">
					<div class="db-favorite-tooltip">
						<?php printf( __( 'You have to be logged in to favorite, click %s to login', 'whitelab' ), '<a href="javascript:void(0)">'.__( 'here', 'whitelab' ).'</a>' ); ?>
					</div>
					<svg class="like-svg" width="16px" height="15px" viewBox="0 0 16 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <g id="Welcome" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Contact-us" transform="translate(-863.000000, -2018.000000)" fill-rule="nonzero" fill="#012532"> <g id="Listing" transform="translate(-1.000000, 172.000000)"> <g id="favorite" transform="translate(803.000000, 1842.000000)"> <g id="like-(1)" transform="translate(61.000000, 4.000000)"> <g id="Capa_1"> <path d="M15.9726154,4.5726 C15.7390769,2.0664 13.9196923,0.2481 11.6427692,0.2481 C10.1258462,0.2481 8.73692308,1.044 7.95538462,2.3196 C7.18092308,1.0275 5.84892308,0.2478 4.35630769,0.2478 C2.07969231,0.2478 0.26,2.0661 0.0267692308,4.5723 C0.00830769231,4.683 -0.0673846154,5.2656 0.162769231,6.2157 C0.494461538,7.5861 1.26061538,8.8326 2.37784615,9.8196 L7.95169231,14.7513 L13.6212308,9.8199 C14.7384615,8.8326 15.5046154,7.5864 15.8363077,6.2157 C16.0664615,5.2659 15.9907692,4.6833 15.9726154,4.5726 Z M15.2372308,6.0783 C14.9344615,7.3299 14.2326154,8.4702 13.2095385,9.3738 L7.95538462,13.9443 L2.79138462,9.375 C1.76646154,8.4696 1.06492308,7.3296 0.761846154,6.078 C0.544,5.1789 0.633538462,4.671 0.633846154,4.6677 L0.638461538,4.6374 C0.838461538,2.4417 2.40184615,0.8478 4.35630769,0.8478 C5.79846154,0.8478 7.068,1.7118 7.67046154,3.1023 L7.95384615,3.7572 L8.23723077,3.1023 C8.83015385,1.7331 10.1667692,0.8481 11.6430769,0.8481 C13.5972308,0.8481 15.1609231,2.442 15.3649231,4.6662 C15.3655385,4.671 15.4550769,5.1792 15.2372308,6.0783 Z" id="Shape"></path> </g> </g> </g> </g> </g> </g> </svg>
					<svg class="unlike-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="15px" viewBox="0 0 16 15" version="1.1"> <g id="Welcome" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Contact-us" transform="translate(-863.000000, -2018.000000)" fill-rule="nonzero" fill="#53666D"> <g id="Listing" transform="translate(-1.000000, 172.000000)"> <g id="favorite" transform="translate(803.000000, 1842.000000)"> <g id="broken-heart-(2)" transform="translate(61.000000, 4.000000)"> <g id="Capa_1"> <path d="M11.3356206,0 C10.5896247,0 9.87658557,0.176326531 9.21642887,0.524115646 C8.7670433,0.760816327 8.35421031,1.07530612 8,1.44843537 C7.64578969,1.07530612 7.2329567,0.760816327 6.78357113,0.524115646 C6.12338144,0.176326531 5.41037526,0 4.66437938,0 C2.09243711,0 0,2.15738095 0,4.80914966 C0,6.68734694 0.962045361,8.68214286 2.85948041,10.7381973 C4.44371134,12.454898 6.38330722,13.8859184 7.73146392,14.7841156 L8.00003299,14.9630612 L8.26860206,14.7841156 C9.61672577,13.8859524 11.5563216,12.454898 13.1405856,10.7381973 C15.0379546,8.68214286 16,6.68734694 16,4.80914966 C16,2.15738095 13.9075629,0 11.3356206,0 Z M3.57644536,10.0347959 C1.86002474,8.17486395 0.989690722,6.41670068 0.989690722,4.80914966 C0.989690722,2.72003401 2.63815258,1.02040816 4.66437938,1.02040816 C5.70197113,1.02040816 6.66421443,1.45778912 7.35818557,2.2322449 L6.75859794,2.98653061 L7.96183093,4.50034014 L6.75863093,6.01418367 L7.96186392,7.52809524 L6.75863093,9.04207483 L7.96186392,10.5559524 L6.75863093,12.069966 L7.96430515,13.5869728 L7.89571959,13.674966 C6.62452784,12.8030612 4.95432577,11.5279252 3.57644536,10.0347959 Z M12.4235546,10.0347959 C11.3111753,11.2402041 10.0082474,12.3035034 8.87854845,13.1273469 L8.03813608,12.069966 L9.24136907,10.5560544 L8.03813608,9.04214286 L9.24136907,7.52812925 L8.03816907,6.0142517 L9.24140206,4.50037415 L8.0534433,3.00585034 L8.39564536,2.53619048 C9.09746804,1.57292517 10.1690722,1.02044218 11.3356206,1.02044218 C13.3618474,1.02044218 15.0103093,2.72006803 15.0103093,4.80918367 C15.0103093,6.41670068 14.1399753,8.17486395 12.4235546,10.0347959 Z" id="Shape"/> </g> </g> </g> </g> </g> </g> </svg>
					</div>
					<div class="db-single-listing-share">
						<span><?php esc_html_e( 'Share', 'whitelab' ); ?></span>
						<svg width="15px" height="16px" viewBox="0 0 15 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<g id="Single-listing" transform="translate(-953.000000, -2018.000000)" fill="#53666D">
									<g id="Listing" transform="translate(-1.000000, 172.000000)">
										<g id="share" transform="translate(897.000000, 1837.000000)">
											<g transform="translate(57.000000, 9.000000)"  >
												<g>
													<path d="M11.9358057,9.92814035 C10.9939336,9.92814035 10.1507346,10.3522807 9.59125592,11.0171228 L5.95187204,8.97740351 C6.06504739,8.66301754 6.12725118,8.32498246 6.12725118,7.97270175 C6.12725118,7.62049123 6.06504739,7.28245614 5.95187204,6.96807018 L9.59097156,4.92785965 C10.1503791,5.59291228 10.9937204,6.01719298 11.9356635,6.01719298 C13.6158057,6.01719298 14.9827251,4.66736842 14.9827251,3.00814035 C14.9828673,1.34940351 13.6159479,0 11.9358057,0 C10.2554502,0 8.88838863,1.34940351 8.88838863,3.00807018 C8.88838863,3.36035088 8.95052133,3.69845614 9.06376777,4.01291228 L5.42445498,6.05319298 C4.86504739,5.38849123 4.02191943,4.96449123 3.08026066,4.96449123 C1.39969194,4.96449123 0.0324170616,6.31389474 0.0324170616,7.97263158 C0.0324170616,9.63129825 1.39969194,10.9807018 3.08026066,10.9807018 C4.02191943,10.9807018 4.8649763,10.5567018 5.42438389,9.89207018 L9.06376777,11.9318596 C8.95052133,12.2463158 8.88831754,12.5844912 8.88831754,12.9368421 C8.88831754,14.5955088 10.2553791,15.9449123 11.9357346,15.9449123 C13.6158768,15.9449123 14.9827962,14.5954386 14.9827962,12.9368421 C14.9828673,11.2778947 13.6159479,9.92814035 11.9358057,9.92814035 L11.9358057,9.92814035 Z M11.9358057,1.05263158 C13.0279621,1.05263158 13.9165166,1.92982456 13.9165166,3.00807018 C13.9165166,4.08687719 13.0279621,4.96449123 11.9358057,4.96449123 C10.843436,4.96449123 9.95473934,4.08687719 9.95473934,3.00807018 C9.95473934,1.92982456 10.843436,1.05263158 11.9358057,1.05263158 L11.9358057,1.05263158 Z M3.08033175,9.92814035 C1.98774882,9.92814035 1.09883886,9.05087719 1.09883886,7.97270175 C1.09883886,6.89438596 1.98774882,6.01719298 3.08033175,6.01719298 C4.17248815,6.01719298 5.06097156,6.89438596 5.06097156,7.97270175 C5.06097156,9.05087719 4.17241706,9.92814035 3.08033175,9.92814035 L3.08033175,9.92814035 Z M11.9358057,14.8923509 C10.843436,14.8923509 9.95473934,14.0150877 9.95473934,12.9369123 C9.95473934,11.8583158 10.843436,10.9807719 11.9358057,10.9807719 C13.0279621,10.9807719 13.9165166,11.8583158 13.9165166,12.9369123 C13.9165166,14.0150877 13.0279621,14.8923509 11.9358057,14.8923509 L11.9358057,14.8923509 Z"  ></path>
												</g>
											</g>
										</g>
									</g>
								</g>
							</g>
						</svg>
						<div class="db-single-listing-share-inner">
						<?php foreach ($share_icons as $icon_key => $icon_value) {
							if ( $icon_key == 'twitter' ) {
								$button_url = 'https://twitter.com/intent/tweet?text='.urlencode(get_the_title()).'&url='.urlencode(get_permalink());
							} else if ( $icon_key == 'gplus' ) {
								$button_url = 'https://plus.google.com/share?url='.urlencode(get_permalink());
							} else if ( $icon_key == 'facebook' ) {
								$button_url = 'https://www.facebook.com/dialog/share?app_id=145634995501895&display=popup&href='.urlencode(get_permalink());
							}
							echo '<div class="db-share-item '.esc_attr($icon_key).'"><a href="'.esc_url($button_url).'" target="_blank">'.$icon_value.'</a></div>';
						} ?>
						</div>
					</div>
				</div>
			</div>
			<?php
			if ( !empty($all_ads) ) {
				foreach ($all_ads as $ad_data) {
					if ( $ad_data->placement != 'content' ) {
						continue;
					}

					$wpdb->query( 'UPDATE ' . $wpdb->prefix . 'directory_ads SET views="'.(intval($ad_data->views)+1).'" WHERE ID="'.intval($ad_data->ID).'"' );

					?>
					<div class="db-single-adv">
						<h3 class="db-single-adv-title"><?php echo $ad_data->title; ?></h3>
						<?php echo stripslashes( urldecode( $ad_data->content ) ); ?>
					</div>
					<?php
				}
			}
			?>
			<?php if ( isset($all_fields) && !empty($all_fields) ) {
					$detail_page_custom = $all_fields;

					// Remove amenities and hop from this list as they have different location intended
					unset($detail_page_custom['amenities']);
					unset($detail_page_custom['hop']);

					if ( !empty($detail_page_custom) ) {
						$fields_with_value = 0;
						foreach ($detail_page_custom as $custom_field) {
							if ( !empty($custom_field['value']) ) {
								$fields_with_value++;
								break;
							}
						}
						if ( $fields_with_value > 0 ) { ?>
							<div class="db-single-additional-information">
								<h3 class="db-single-additional-information-title"><?php esc_html_e('Additional information', 'whitelab'); ?></h3>
								<?php foreach ($detail_page_custom as $custom_field) {
									if ( !empty($custom_field['value']) ) {
										if ( $custom_field['type'] == 'url' ) { ?>
											<div class="db-single-additional-information-item">
												<span><strong><?php echo $custom_field['title']; ?>:</strong> <a href="<?php echo esc_url($custom_field['value']); ?>" target="_blank"><?php echo esc_url($custom_field['value']); ?></a></span>
											</div>
										<?php } else { ?>
										<div class="db-single-additional-information-item">
											<span><strong><?php echo $custom_field['title']; ?>:</strong> <?php echo (is_array($custom_field['value'])?implode(', ', $custom_field['value']):$custom_field['value']); ?></span>
										</div>
									<?php }
									}
								} ?>
							</div>
					<?php }
					}
			 	} ?>
			<?php
			if ( isset($all_fields['amenities']) && $all_fields['amenities']['value'] != '' && !empty($all_fields['amenities']['value']) ) {
				?>
				<div class="db-single-amenities">
					<h3 class="db-single-amenities-title"><?php echo esc_html($all_fields['amenities']['title']); ?></h3>
					<?php
					$loop = 1;
					$select_data = preg_split("/\\r\\n|\\r|\\n/", $all_fields['amenities']['select_options']);
					$select_options = array();
					foreach ($select_data as $select_value) {
						$select_option_data = explode(':', $select_value);
						$select_options[$select_option_data['0']] = array( 'title' => $select_option_data['1'] );
						if ( isset($select_option_data['2']) ) {
							$select_options[$select_option_data['0']]['icon'] = $select_option_data['2'];
						}
					}
					?> <div class="db-amenitie-item-wrapper"> <?php
					if ( is_array($all_fields['amenities']['value']) ) {
						$amenities_values = $all_fields['amenities']['value'];
					} else {
						$amenities_values = explode(',', $all_fields['amenities']['value']);
					}

					foreach ($amenities_values as $amenitie_value) {
						if ( !isset($select_options[$amenitie_value]) ) {
							continue;
						}

						$amenitie_icon = '';

						if ( $amenitie_value == 'wheelchair' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/wheelchair.png" alt="">';
						} else if ( $amenitie_value == 'kids-corder' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/horse.png" alt="">';
						} else if ( $amenitie_value == 'pet-friendly' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/bone.png" alt="">';
						} else if ( $amenitie_value == 'bike-parking' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/bicycle.png" alt="">';
						} else if ( $amenitie_value == 'accepts-creditcards' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/credit-card.png" alt="">';
						} else if ( $amenitie_value == 'car-parking' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/parking.png" alt="">';
						} else if ( $amenitie_value == 'gift-wrapping' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/candy.png" alt="">';
						} else if ( $amenitie_value == 'free-wifi' ) {
							$amenitie_icon = '<img src="'.get_template_directory_uri().'/images/amenities/wifi.png" alt="">';
						}

						if ( isset( $select_options[$amenitie_value]['icon'] ) ) {
							$amenitie_icon = '<img src="'.wp_get_attachment_url( $select_options[$amenitie_value]['icon'] ).'" alt="">';
						}

						?>
						<span class="db-amenitie-item">
							<?php
							echo '<a href="'.add_query_arg( 'amenities', $amenitie_value, get_permalink($main_settings['search_page_id']) ).'">'.$amenitie_icon.'<div class="db-amenities-inner"><span class="db-amenities-text">'.esc_html($select_options[$amenitie_value]['title']).'</span><span class="db-amenities-overflow">'.esc_html($select_options[$amenitie_value]['title']).'</span></div></a>'; ?>
						</span><br>
						<?php

						if ( $loop%2 == 0 && $loop != count($all_fields['amenities']['value']) ) {
							?> </div><div class="db-amenitie-item-wrapper"> <?php
						}
						$loop++;
					}
					?> </div>
				</div><!-- end of db-single-amenities -->
			<?php
			}
			?>
			<?php if ( $main_settings['listing_ratings'] ) {
				comments_template();
			} ?>
		</div><!-- end of db-single-listing-left -->
		<div class="db-single-listing-right">
			<div class="db-single-listing-map-wrapper">
				<div class="db-single-map-modal">
					<img src="<?php echo get_template_directory_uri(); ?>/images/x.png" class="db-single-map-close">
					<div id="db-single-listing-map"></div>
				</div>
				<a href="https://maps.google.com/?q=<?php echo esc_attr($listing_lat); ?>,<?php echo esc_attr($listing_lng); ?>" class="db-get-directions" target="_blank"><?php esc_html_e('Get directions', 'whitelab'); ?></a>
				<a href="javascript:void(0)" class="db-expand-map">
					<svg width="21px" height="21px" viewBox="0 0 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					        <g id="Single-listing" transform="translate(-1257.000000, -396.000000)" fill="#70C1B3">
					            <g id="Listing" transform="translate(-1.000000, 172.000000)">
					                <g id="google-map" transform="translate(1028.000000, 212.000000)">
					                    <g id="expand" transform="translate(230.000000, 12.000000)">
					                        <g  >
					                            <g id="Group">
					                                <path d="M20.4383143,0.0329386503 L11.1942429,2.69263804 C10.9920429,2.89525153 10.9920429,3.2237362 11.1942429,3.42639264 L14.9389286,4.92731288 L11.3227286,8.55086503 C11.0369143,8.8372638 11.0369143,9.30153988 11.3227286,9.58789571 L11.4521143,9.71750307 C11.7379286,10.0039018 12.2012571,10.0039018 12.4869857,9.71750307 L16.1031429,6.09395092 L17.6010429,9.84629448 C17.8032,10.048908 18.1311429,10.048908 18.3332143,9.84629448 C18.3332143,9.84629448 20.9874857,1.13352761 20.9874857,0.583276074 C20.9874857,0.0330245399 20.4383143,0.0329386503 20.4383143,0.0329386503 L20.4383143,0.0329386503 Z"  ></path>
					                                <path d="M0.549171429,20.9974663 L9.79324286,18.3377669 C9.99544286,18.1351534 9.99544286,17.8067117 9.79324286,17.6040552 L6.04855714,16.1031779 L9.66475714,12.4795828 C9.95057143,12.1932699 9.95057143,11.728908 9.66475714,11.4425951 L9.53537143,11.3129448 C9.24955714,11.026546 8.78622857,11.026546 8.5005,11.3129448 L4.88434286,14.9366258 L3.38644286,11.1841963 C3.18428571,10.9816258 2.85638571,10.9816258 2.65427143,11.1841963 C2.65427143,11.1841963 0,19.8969632 0,20.4472147 C1.52259158e-15,20.9974233 0.549171429,20.9974663 0.549171429,20.9974663 L0.549171429,20.9974663 Z"  ></path>
					                            </g>
					                        </g>
					                    </g>
					                </g>
					            </g>
					        </g>
					    </g>
					</svg>
				</a>
			</div>
			<?php if ( !empty($contact_fields) ) { ?>
				<div class="db-single-listing-side-wrapper">
					<h3 class="db-listing-side-title"><?php esc_html_e('Contact details', 'whitelab'); ?></h3>
					<div class="db-single-listing-side-container">
						<?php foreach ($contact_fields as $contact_key => $contact_data) {
							if ( $contact_data['value'] == ''  ) {
								continue;
							}

							$contact_value = (is_array($contact_data['value'])?implode(', ', $contact_data['value']):$contact_data['value']);

							if ( filter_var($contact_value, FILTER_VALIDATE_URL) ) { // Check if value contains only URL
								$contact_value = '<a href="' . $contact_value . '">' . $contact_value . '</a>';
							}
							
							?>
							<span class="db-single-contact-item"><?php echo ($contact_data['icon']!=''?'<span class="db-contact-icon '.$contact_data['icon'].'" title="'.$contact_data['title'].'"></span>':$contact_data['title'] . ': ').$contact_value; ?></span>
						<?php } ?>
					</div>
					<?php
						$show_contact_form = true;
						if ( isset($main_settings['contact_form_registered']) && $main_settings['contact_form_registered'] && !is_user_logged_in() ) {
							$show_contact_form = false;
						}

						$listing_email = get_post_meta( get_the_ID(), 'listingcontact', true );
						if ( $main_settings['contact_form_status'] && $show_contact_form && $listing_email != '' ) {
							echo '
							<span class="db-single-listing-side-bottom">'. esc_html__('Please don\'t hesitate to', 'whitelab').' <a href="javascript:void(0)" class="db-contact-open">'.esc_html__('contact us', 'whitelab').'</a></span>
							<div id="db-contact-listing-dialog" class="db-dialog-animation">
								<div class="db-contact-form">
									<span class="db-contact-close"><img src="'.get_template_directory_uri().'/images/x.png" alt=""></span>
									<span class="db-contact-listing-title">'.esc_html__('Send us a message', 'whitelab').'</span>
									<input type="text" class="db-contact-name" placeholder="'.esc_html__('Name', 'whitelab').'">
									<input type="email" class="db-contact-email" placeholder="'.esc_html__('Email', 'whitelab').'">
									<div class="db-contact-listing-msg">
										<textarea class="db-contact-message" placeholder="'.esc_html__('Message', 'whitelab').'"></textarea>
										<a href="javascript:void(0)" class="db-contact-author" data-author="'.esc_attr($listing_email).'"><span class="db-send-message"></span></a>
									</div>
									<span class="db-contact-status"></span>
								</div>
							</div><!-- end of db-contact-listing-dialog -->';
						}
					?>
				</div><!-- end of db-single-listing-side-wrapper -->
				<div class="db-dialog-overlay"></div>
			<?php } ?>
			<?php if ( isset($all_fields['hop']) && $all_fields['hop']['value'] != '' ) { ?>
			<div class="db-single-listing-side-wrapper">
				<h3 class="db-listing-side-title"><?php esc_html_e('Opening hours', 'whitelab'); ?></h3>
				<div class="db-single-listing-side-container hoo">
					<?php
					if ( $all_fields['hop']['value'] != 'always|' ) {
						$custom_times = explode('|', $all_fields['hop']['value']);
						unset($custom_times['0']);
						if ( !empty($custom_times) ) {
							$hoo_days = array(
								'mon' => esc_html__('Monday', 'whitelab'),
								'tue' => esc_html__('Tuesday', 'whitelab'),
								'wed' => esc_html__('Wednesday', 'whitelab'),
								'thu' => esc_html__('Thursday', 'whitelab'),
								'fri' => esc_html__('Friday', 'whitelab'),
								'sat' => esc_html__('Saturday', 'whitelab'),
								'sun' => esc_html__('Sunday', 'whitelab'),
								'--' => ' - '
								);
							echo '<table>';
							foreach ($custom_times as $hoo_values) {
								$parsed_data = explode('==', $hoo_values);

								if ( $parsed_data['0'] == '' ) {
									continue;
								}

								$hoo_day = $parsed_data['0'];
								foreach ($hoo_days as $hop_key => $hop_value) {
									$hoo_day = str_replace($hop_key, $hop_value, $hoo_day);

									switch ( $hop_key ) {
										case 'mon': $schema_day = 'Monday'; break;
										case 'tue': $schema_day = 'Tuesday'; break;
										case 'wed': $schema_day = 'Wednesday'; break;
										case 'thu': $schema_day = 'Thursday'; break;
										case 'fri': $schema_day = 'Friday'; break;
										case 'sat': $schema_day = 'Saturday'; break;
										case 'sun': $schema_day = 'Sunday'; break;
										default: $schema_day = 'Monday'; break;
									}
								}
								
								$hoo_times = str_replace('0-0', esc_html__('Closed', 'whitelab'), $parsed_data['1']);
								$hoo_times = str_replace('-', ' - ', $hoo_times);
								$exploded_times = explode( ' - ',$hoo_times );

								?>
								<tr class="db-single-opening-hours">
									<td class="db-single-opening-day"><?php echo esc_html($hoo_day); ?></td>
									<td class="db-single-opening-times"><?php echo esc_html($hoo_times); ?></td>
								</tr>
								<?php
							}
							echo '</table>';
						}
					} else {
						?> <span class="db-open-always"> <?php
							esc_html_e( 'We are open 24/7 365 days a year.', 'whitelab' );
						?> </span> <?php
					}
					?>
				</div>
			</div> <!-- end of db-single-listing-side-wrapper -->
			<?php } ?>
			<?php
				$claim_info = get_post_meta( get_the_ID(), 'db_claim_info', true );
				preg_match_all('/\d+:\d+/', $claim_info, $claim_matches);
				$claim_data = explode( ':', $claim_info );
				if ( $claim_info == '' ) {
					?>
					<span class="db-single-listing-side-bottom db-claim-text text-align-left"><?php printf( esc_html__('Claim your business listing on %s.', 'whitelab'), get_bloginfo( 'name' ) ); ?> <a href="<?php echo esc_url(get_permalink()); ?>?db-claim"><?php esc_html_e('Claim my business.', 'whitelab'); ?></a></span>
					<?php
				} else if ( is_user_logged_in() && !empty( $claim_matches['0'] ) && get_current_user_id() === intval($claim_data['0']) ) {
					?>
					<span class="db-single-listing-side-bottom db-claim-text text-align-left"><?php esc_html_e('You have claimed this listing!', 'whitelab'); ?></span>
					<?php
				} else if ( is_user_logged_in() && strpos($claim_info, get_current_user_id().':waiting') !== false ) {
					?>
					<span class="db-single-listing-side-bottom db-claim-text text-align-left"><?php esc_html_e('Your claim is waiting for approval!', 'whitelab'); ?></span>
					<?php
				}
			?>
			<?php
			if ( !empty($all_ads) ) {
				foreach ($all_ads as $ad_data) {
					if ( $ad_data->placement != 'sidebar' ) {
						continue;
					}

					$wpdb->query( 'UPDATE ' . $wpdb->prefix . 'directory_ads SET views="'.(intval($ad_data->views)+1).'" WHERE ID="'.intval($ad_data->ID).'"' );

					?>
					<div class="db-single-listing-side-wrapper">
						<h3 class="db-listing-side-title"><?php echo $ad_data->title; ?></h3>
						<?php echo stripslashes( urldecode( $ad_data->content ) ); ?>
					</div>
					<?php
				}
			}
			?>
		</div><!-- end of db-single-listing-right -->
		<div class="clearfix"></div>
	</div>
</div>

<?php get_footer(); ?>
