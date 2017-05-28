<?php
/*
	Template for the search listing item
*/

$db_search_listing_data = whitelab_get_search_listing_data();
if ( empty($db_search_listing_data) ) {
	return;
}
$main_settings = get_option( 'db_main_settings');
$listing_rating = get_post_meta( $db_search_listing_data['ID'], 'listing_ratings', true );
if ( $listing_rating == '' ) {
	$listing_rating = 0;
} else {
	$rating_count = 0;
	foreach ($listing_rating as $rating_value) {
		$rating_count += intval($rating_value);
	}
	$listing_rating = $rating_count/count($listing_rating);
}

$listing_phone = get_post_meta($db_search_listing_data['ID'], 'listingphone', true);
$listing_address = get_post_meta($db_search_listing_data['ID'], 'listing_address', true);
$listing_category = get_the_terms($db_search_listing_data['ID'], 'listing_category');
$listing_ratings = get_post_meta($db_search_listing_data['ID'], 'directory_post_likes', true);
if ( $listing_ratings != '' ) {
	$liked = $listing_ratings;
} else {
	$liked = array();
}
$featured_listings = get_option('db_sticky_listings', array());

$custom_sorting = db_get_listing_custom_fields( $db_search_listing_data['ID'], 'on_sorting' );
$custom_sorting_arr = array();
if ( !empty( $custom_sorting ) ) {
	foreach ($custom_sorting as $sorting_field_name => $sorting_field) {
		if ( $sorting_field['type'] != 'phone' ) {
			$custom_sorting_arr[] = 'data-'.$sorting_field_name.'="'.mb_substr( $sorting_field['value'], 0, 25 ).'"';
		} else {
			$custom_sorting_arr[] = 'data-'.$sorting_field_name.'="'.preg_replace('/[^0-9.]+/', '', $sorting_field['value']).'"';
		}
	}
}

?>

<div class="dt-featured-listings-item db-main-search-item" data-id="<?php echo esc_attr($db_search_listing_data['ID']); ?>" data-name="<?php echo esc_attr(strtolower($db_search_listing_data['post_title'])); ?>" data-date="<?php echo esc_attr(strtotime($db_search_listing_data['post_date_gmt'])); ?>" data-rating="<?php echo esc_attr($listing_rating); ?>" data-featured="<?php echo (in_array($db_search_listing_data['ID'], $featured_listings)?'0':'1'); ?>" <?php echo implode(' ', $custom_sorting_arr); ?>>
	<div class="dt-featured-listings-item-inner">
		<div class="dt-featured-listings-image">
			<a href="<?php echo esc_url( get_permalink(intval($db_search_listing_data['ID'])) ); ?>" class="dt-featured-item-image id-<?php echo esc_attr( $db_search_listing_data['ID'] ); ?>"></a>
			<?php if ( in_array($db_search_listing_data['ID'], $featured_listings) ) { ?> <span class="dt-featured-listings-image-note"><?php esc_html_e('Featured', 'whitelab'); ?></span> <?php } ?>
			<span class="dt-listing-likes<?php echo (isset($liked[get_current_user_id()])?' liked':(!is_user_logged_in()?' not-logged-in':'')); ?>" data-id="<?php echo esc_attr($db_search_listing_data['ID']); ?>">
				<div class="db-favorite-tooltip">
					<?php printf( __( 'You have to be logged in to favorite, click %s to login', 'whitelab' ), '<a href="javascript:void(0)">'.__( 'here', 'whitelab' ).'</a>' ); ?>
				</div>
				<svg class="like-thumb" version="1.1" width="20" height="20"><path d="M18.9,10.5C19.3,10 19.6,9.4 19.6,8.7C19.6,8.1 19.3,7.5 18.9,7C18.4,6.6 17.9,6.3 17.2,6.3L13.8,6.3C13.9,6.2 13.9,6.1 13.9,6C14,6 14,5.9 14.1,5.8C14.1,5.7 14.2,5.6 14.2,5.5C14.3,5.3 14.4,5 14.5,4.8C14.6,4.7 14.7,4.4 14.8,4.1C14.8,3.8 14.9,3.5 14.9,3.2C14.9,3 14.9,2.8 14.9,2.7C14.9,2.6 14.8,2.4 14.8,2.1C14.8,1.9 14.7,1.7 14.7,1.5C14.6,1.3 14.5,1.2 14.4,1C14.2,0.8 14.1,0.6 13.9,0.5C13.7,0.3 13.4,0.2 13.1,0.1C12.8,0 12.5,0 12.1,0C11.9,0 11.7,0.1 11.6,0.2C11.4,0.4 11.3,0.6 11.2,0.9C11.1,1.1 11,1.3 10.9,1.5C10.9,1.7 10.8,1.9 10.8,2.3C10.7,2.6 10.6,2.9 10.6,3C10.6,3.2 10.5,3.4 10.4,3.6C10.3,3.8 10.2,4 10,4.2C9.7,4.5 9.3,5 8.8,5.7C8.4,6.2 8,6.7 7.5,7.2C7.1,7.6 6.8,7.9 6.6,7.9C6.4,7.9 6.2,8 6.1,8.2C5.9,8.3 5.9,8.5 5.9,8.7L5.9,16.6C5.9,16.8 5.9,17 6.1,17.2C6.3,17.3 6.4,17.4 6.7,17.4C6.9,17.4 7.6,17.6 8.6,17.9C9.2,18.2 9.7,18.3 10.1,18.4C10.4,18.5 10.9,18.7 11.5,18.8C12.2,18.9 12.8,19 13.3,19L13.5,19L14.4,19L14.9,19C16,19 16.8,18.6 17.3,18C17.8,17.5 18,16.7 17.9,15.8C18.2,15.5 18.4,15.1 18.6,14.6C18.7,14.1 18.7,13.6 18.6,13.2C18.9,12.7 19.1,12.1 19.1,11.5C19.1,11.2 19,10.9 18.9,10.5L18.9,10.5z" fill="#ffffff" stroke="none" stroke-width="0" fill-opacity="1" stroke-opacity="0"></path><path d="M4.3,7.9L0.8,7.9C0.6,7.9 0.4,8 0.2,8.1C0.1,8.3 0,8.5 0,8.7L0,16.6C0,16.8 0.1,17 0.2,17.2C0.4,17.3 0.6,17.4 0.8,17.4L4.3,17.4C4.5,17.4 4.7,17.3 4.9,17.2C5,17 5.1,16.8 5.1,16.6L5.1,8.7C5.1,8.5 5,8.3 4.9,8.1C4.7,8 4.5,7.9 4.3,7.9L4.3,7.9M2.9,15.6C2.7,15.7 2.6,15.8 2.3,15.8C2.1,15.8 1.9,15.7 1.8,15.6C1.6,15.4 1.6,15.3 1.6,15C1.6,14.8 1.6,14.6 1.8,14.5C1.9,14.3 2.1,14.2 2.3,14.2C2.6,14.2 2.7,14.3 2.9,14.5C3.1,14.6 3.1,14.8 3.1,15C3.1,15.3 3.1,15.4 2.9,15.6L2.9,15.6z" fill="#ffffff" stroke="none" stroke-width="0" fill-opacity="1" stroke-opacity="0"></path></svg>
				<svg class="like-thumb-liked" width="21px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g   transform="translate(-1250.000000, -1146.000000)" stroke="#FFFFFF" fill="#247BA0"><g id="favorites" transform="translate(150.000000, 1091.000000)"><g id="club-copy-2" transform="translate(780.000000, 39.000000)"><g id="Thumb" transform="translate(319.322034, 16.000000)"><g   transform="translate(0.677966, 0.000000)"><g id="Group"><path d="M18.8951038,10.546385 C19.3435043,10.0274556 19.5677902,9.41378588 19.5677902,8.70524601 C19.5677902,8.06270843 19.3351085,7.50673121 18.8713302,7.03692483 C18.4066094,6.56716173 17.8563464,6.33241002 17.2204127,6.33241002 L13.8329071,6.33241002 C13.865462,6.21711162 13.8981025,6.11825968 13.9306574,6.03589749 C13.9629124,5.95353531 14.0082322,5.86282005 14.0650747,5.76396811 C14.1219601,5.66507289 14.1628678,5.59089066 14.1872412,5.54155125 C14.3339523,5.26161503 14.4462666,5.03080182 14.5237986,4.84971754 C14.601202,4.66828702 14.6782628,4.42124374 14.7559662,4.10819818 C14.833541,3.79532574 14.8720928,3.48215034 14.8720928,3.16910478 C14.8720928,2.97148747 14.8697369,2.81070159 14.8658817,2.68722323 C14.8620694,2.56365831 14.8412942,2.37824601 14.804927,2.13107289 C14.7680029,1.88402961 14.7189993,1.67805923 14.6580017,1.51337813 C14.5967472,1.34865376 14.4988255,1.1631549 14.3645367,0.957357631 C14.229948,0.751170843 14.0669595,0.584585421 13.8751856,0.456822323 C13.6834545,0.329145786 13.4389503,0.222070615 13.1413731,0.135640091 C12.8434961,0.0491230068 12.507367,0.00588610478 12.1320865,0.00588610478 C11.9201371,0.00588610478 11.7368446,0.0841799544 11.5817807,0.240724374 C11.4187493,0.405448747 11.2799199,0.611375854 11.1658922,0.858419134 C11.0516931,1.10559226 10.9721479,1.31978588 10.9272564,1.50108656 C10.8824078,1.68230068 10.8313909,1.9336287 10.7745484,2.25481093 C10.7009144,2.60096583 10.646128,2.85 10.6092039,3.00238952 C10.5725797,3.15477904 10.5010446,3.35451708 10.3951556,3.60160364 C10.2890525,3.84886333 10.1628167,4.04643736 10.0160199,4.19480182 C9.74701386,4.46660137 9.33532325,4.96090433 8.78077674,5.67753759 C8.38116571,6.20469021 7.9694751,6.7030615 7.54553359,7.17265148 C7.1215064,7.64232802 6.81172111,7.88530296 6.61609204,7.90179271 C6.41240992,7.91823918 6.23708481,8.00267882 6.09028804,8.1551549 C5.94349128,8.30754442 5.87011432,8.48676765 5.87011432,8.69265148 L5.87011432,16.6133576 C5.87011432,16.8275513 5.9475178,17.0107563 6.10245329,17.1631458 C6.2573031,17.3157084 6.44076693,17.3959932 6.6527591,17.4042597 C6.93808541,17.4125262 7.58220065,17.5935672 8.58510483,17.9481185 C9.21281414,18.1619658 9.70396433,18.3249157 10.0586411,18.4359727 C10.4132321,18.5470296 10.90888,18.6665695 11.5443426,18.7944191 C12.1804047,18.9220524 12.7673348,18.9860638 13.305304,18.9860638 L13.5132697,18.9860638 L14.4427969,18.9860638 L14.882973,18.9860638 C15.9676071,18.9696173 16.7703416,18.6482187 17.2923333,18.0223007 C17.7650643,17.4538155 17.9647198,16.7082711 17.8915999,15.7856241 C18.2095239,15.4808451 18.4298261,15.0938337 18.5519497,14.6241572 C18.6903508,14.1219339 18.6903508,13.6399658 18.5519497,13.1787289 C18.9269304,12.6762027 19.1022556,12.1119157 19.0776252,11.4858246 C19.0786533,11.2219453 19.0176557,10.9089863 18.8951038,10.546385 L18.8951038,10.546385 Z"  ></path><path d="M4.30495325,7.91438724 L0.782858962,7.91438724 C0.57073828,7.91438724 0.387274451,7.99268109 0.232381805,8.14922551 C0.0774891585,8.30568337 0,8.49105239 0,8.70524601 L0,16.6139203 C0,16.8278109 0.0774891585,17.0132665 0.23242464,17.1699408 C0.387445793,17.3262255 0.570909621,17.4045626 0.782901797,17.4045626 L4.30495325,17.4045626 C4.51690259,17.4045626 4.70028075,17.3262255 4.85525907,17.1699408 C5.01015171,17.0132665 5.08759804,16.8278542 5.08759804,16.6139203 L5.08759804,8.70524601 C5.08759804,8.49105239 5.01010888,8.30572665 4.85525907,8.14922551 C4.70032359,7.99263781 4.51694543,7.91438724 4.30495325,7.91438724 L4.30495325,7.91438724 Z M2.89845435,15.5941959 C2.7435617,15.7465854 2.56014071,15.8227585 2.34814853,15.8227585 C2.1279748,15.8227585 1.94245488,15.7465854 1.79171726,15.5941959 C1.64089397,15.4418064 1.56550375,15.2544465 1.56550375,15.0319863 C1.56550375,14.817836 1.64085114,14.6324237 1.79171726,14.4759658 C1.94249771,14.3194214 2.1279748,14.241041 2.34814853,14.241041 C2.56014071,14.241041 2.7435617,14.3194214 2.89845435,14.4759658 C3.05338983,14.6323804 3.13087899,14.8177927 3.13087899,15.0319863 C3.13087899,15.2544465 3.05356117,15.4417631 2.89845435,15.5941959 L2.89845435,15.5941959 Z"  ></path></g></g></g></g></g></g></g></svg>
			</span>
			<div class="dt-featured-listings-image-meta">
				<div class="db-search-listing-fields">
					<?php db_get_listing_custom_field_data( $db_search_listing_data, 'db-search-listing-field-item' ); ?>
				</div>
			</div>
			<div class="dt-featured-listing-overlay"></div>
		</div>
		<div class="dt-featured-listings-data">
			<a href="<?php echo esc_url( get_permalink(intval($db_search_listing_data['ID'])) ); ?>" class="dt-featured-listings-title"><?php echo esc_html( $db_search_listing_data['post_title'] ); ?></a>
			<p class="dt-featured-listings-description"><?php echo($db_search_listing_data['post_excerpt']!=''?esc_html($db_search_listing_data['post_excerpt']):substr(htmlentities(strip_shortcodes(strip_tags($db_search_listing_data['post_content']))), 0, 170)); ?></p>
			<div class="dt-featured-listings-meta clearfix">
				<?php if ( isset($listing_category['0']) ) {
					$cat_meta = get_option( "listing_category_".intval($listing_category['0']->term_id));
					$tag_color = (isset($cat_meta['tag-category-color'])?esc_attr($cat_meta['tag-category-color']):'#555'); ?>
	
					<span class="dt-featured-listings-category <?php echo esc_attr($listing_category['0']->slug); ?>"><?php echo esc_html($listing_category['0']->name); ?></span>
				<?php }
				$ratings = get_post_meta( intval($db_search_listing_data['ID']), 'listing_ratings', true);
				if ( $ratings == '' ) {
					$rating_stars = '<img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg"><img src="'.DIRECTORY_PUBLIC.'images/star-empty.svg">';
					$listing_rating = 0;
				} else {
					$listing_rating = 0;
					foreach ($ratings as $rating_value) {
						$listing_rating += intval($rating_value);
					}
					$listing_rating = round(($listing_rating/count($ratings)), 0, PHP_ROUND_HALF_DOWN);

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
					if ( !in_array($db_search_listing_data['ID'], $rated_listings) ) {
						$can_rate = true;
					} else {
						$can_rate = false;
					}
				} ?>

				<span class="dt-featured-listings-rating<?php echo (!$can_rate?' rated':''); ?>" data-original="<?php echo esc_attr($listing_rating); ?>" data-id="<?php echo esc_attr($db_search_listing_data['ID']); ?>"><?php echo $rating_stars; ?></div>
			</div>
		</div>
	</div>
</div>