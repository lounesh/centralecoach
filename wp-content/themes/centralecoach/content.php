<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

if ( !is_single() ) {
	$header_class = 'simple';
} else {
	$header_class = (has_post_thumbnail()?'has-image':'no-image');
}

$icons = array(
		'facebook'  => '<svg width="23px" height="23px" viewBox="0 0 23 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><g   transform="translate(-925.000000, -5164.000000)" fill="#909FA5"><g   transform="translate(0.000000, 5097.000000)"><g   transform="translate(925.000000, 67.000000)"><g id="facebook-logotype-button"><g  ><path d="M18.4624473,0 L4.26054679,0 C1.90729055,0 0,1.86969921 0,4.17657445 L0,18.0985656 C0,20.4054409 1.90729055,22.2751401 4.26054679,22.2751401 L18.4624473,22.2751401 C20.8157036,22.2751401 22.7229941,20.4053951 22.7229941,18.0985656 L22.7229941,4.17657445 C22.7230408,1.86969921 20.8157036,0 18.4624473,0 L18.4624473,0 Z M14.2984657,11.1361732 L12.4365846,11.1375471 L12.4351831,17.8200754 L9.88024717,17.8200754 L9.88024717,11.1375929 L8.17603779,11.1375929 L8.17603779,8.8348852 L9.88024717,8.83351129 L9.8773974,7.47751453 C9.8773974,5.59806061 10.3971768,4.45506465 12.6538679,4.45506465 L14.5342024,4.45506465 L14.5342024,6.75914629 L13.3582751,6.75914629 C12.479191,6.75914629 12.4365846,7.08073126 12.4365846,7.68076062 L12.4337348,8.83351129 L14.5469563,8.83351129 L14.2984657,11.1361732 L14.2984657,11.1361732 Z"  ></path></g></g></g></g></g></g></svg>',
		'gplus'  => '<svg width="24px" height="23px" viewBox="0 0 24 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><g   transform="translate(-958.000000, -5164.000000)" fill="#909FA5"><g   transform="translate(0.000000, 5097.000000)"><g   transform="translate(925.000000, 67.000000)"><g id="social-google-plus-square-button" transform="translate(33.416185, 0.696970)"><g  ><g id="Group"><path d="M18.4624473,0 L4.26054679,0 C1.90729055,0 0,1.86969921 0,4.17657445 L0,18.0985656 C0,20.4054409 1.90729055,22.2751401 4.26054679,22.2751401 L18.4624473,22.2751401 C20.8157036,22.2751401 22.7229941,20.4053951 22.7229941,18.0985656 L22.7229941,4.17657445 C22.7230408,1.86969921 20.8157036,0 18.4624473,0 L18.4624473,0 Z M8.19164145,18.6317775 C5.67650891,18.6317775 3.5547381,17.6280037 3.5547381,16.0242006 C3.5547381,14.3967206 5.49043292,12.8249294 8.00561218,12.8263033 L8.79098085,12.8193422 C8.44727987,12.49217 8.17463627,12.0898453 8.17463627,11.5928129 C8.17463627,11.2976527 8.27120143,11.0150408 8.40472018,10.7630669 L7.98575723,10.7769891 C5.91939343,10.7769891 4.5361336,9.33608512 4.5361336,7.54987344 C4.5361336,5.8026806 6.44627392,4.29491332 8.4771791,4.29491332 L13.0075664,4.29491332 L11.9907123,5.01328156 L10.5548953,5.01328156 C11.5078398,5.37246568 12.0148653,6.46114666 12.0148653,7.57771788 C12.0148653,8.51467413 11.485135,9.3221629 10.7366732,9.89572173 C10.0052633,10.456778 9.86753999,10.6906622 9.86753999,11.1668113 C9.86753999,11.5733493 10.6515071,12.2638731 11.0605193,12.5492786 C12.2577498,13.3790246 12.642609,14.1489142 12.642609,15.433926 C12.6425155,17.0377291 11.0590243,18.6317775 8.19164145,18.6317775 L8.19164145,18.6317775 Z M19.8826607,9.77184145 L17.0422806,9.77184145 L17.0422806,12.5520722 L15.6235154,12.5520722 L15.6235154,9.77184145 L12.7817338,9.77184145 L12.7817338,8.3531947 L15.6235154,8.3531947 L15.6235154,5.56879647 L17.0422806,5.56879647 L17.0422806,8.3531947 L19.8826607,8.3531947 L19.8826607,9.77184145 L19.8826607,9.77184145 Z"  ></path><path d="M10.3872727,7.6640448 C10.185593,6.16323863 9.07642506,4.95759268 7.91044854,4.92278713 C6.74447202,4.88935549 5.96195312,6.03793865 6.16363276,7.54149263 C6.36531241,9.0436727 7.4744804,10.2897114 8.64185845,10.3230973 C9.80638673,10.3579486 10.5903539,9.16764458 10.3872727,7.6640448 L10.3872727,7.6640448 Z"  ></path><path d="M9.61325639,13.4194173 C9.2695554,13.3108332 8.89039579,13.2453896 8.48563497,13.2412221 C6.74732179,13.2231324 5.19078658,14.2798014 5.19078658,15.5508909 C5.19078658,16.8484052 6.4462272,17.9259576 8.18454039,17.9259576 C10.6286623,17.9259576 11.4793888,16.9124291 11.4793888,15.6177084 C11.4793888,15.4617704 11.4580856,15.308626 11.4239818,15.1596949 C11.2337012,14.424565 10.5562501,14.0612134 9.61325639,13.4194173 L9.61325639,13.4194173 Z"  ></path></g></g></g></g></g></g></g></svg>',
		'twitter'   => '<svg width="23px" height="23px" viewBox="0 0 23 23" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3"><g   transform="translate(-1025.000000, -5164.000000)" fill="#909FA5"><g   transform="translate(0.000000, 5097.000000)"><g   transform="translate(925.000000, 67.000000)"><g id="twitter-logo" transform="translate(100.248555, 0.000000)"><g  ><path d="M18.4624473,0 L4.26054679,0 C1.90729055,0 0,1.86969921 0,4.17657445 L0,18.0985656 C0,20.4054409 1.90729055,22.2751401 4.26054679,22.2751401 L18.4624473,22.2751401 C20.8157036,22.2751401 22.7229941,20.4053951 22.7229941,18.0985656 L22.7229941,4.17657445 C22.7230408,1.86969921 20.8157036,0 18.4624473,0 L18.4624473,0 Z M17.0138763,8.63718051 L17.0223789,8.99219713 C17.0223789,12.61747 14.2090016,16.7940902 9.06362446,16.7940902 C7.48438452,16.7940902 6.01446364,16.3402442 4.77607492,15.5619737 C4.99480647,15.5870246 5.2177426,15.6009468 5.44357522,15.6009468 C6.75442286,15.6009468 7.96015601,15.1623969 8.91735182,14.4273128 C7.69316523,14.4050556 6.66066074,13.611489 6.30420586,12.522808 C6.476033,12.5534461 6.64930838,12.5701619 6.83108635,12.5701619 C7.08672476,12.5701619 7.33381387,12.53815 7.56814908,12.4755 C6.28855548,12.2221064 5.32425861,11.1153357 5.32425861,9.78718337 L5.32425861,9.75237782 C5.70201669,9.95841752 6.13233201,10.0809239 6.5910516,10.0962658 C5.84118826,9.60482061 5.34696334,8.76531989 5.34696334,7.81444142 C5.34696334,7.31186759 5.48473338,6.84130571 5.72472142,6.43618742 C7.10372995,8.09567942 9.16584245,9.187154 11.4906944,9.30132537 C11.4423885,9.10082708 11.4182822,8.89061987 11.4182822,8.67624516 C11.4182822,7.16293647 12.6708731,5.93498749 14.2160559,5.93498749 C15.019878,5.93498749 15.7470366,6.26770108 16.2582668,6.80091295 C16.894513,6.67698687 17.4938524,6.44868994 18.034935,6.13543999 C17.8261543,6.77586211 17.3830851,7.31324149 16.8050489,7.65291618 C17.368883,7.58747259 17.9099656,7.43849568 18.4112916,7.22132736 C18.0363833,7.76983536 17.5606118,8.25294555 17.0138763,8.63718051 L17.0138763,8.63718051 Z"  ></path></g></g></g></g></g></g></svg>'
	);

?>

<article id="post-<?php esc_attr( the_ID() ); ?>" <?php esc_html( post_class($header_class) ); ?>>
	<?php
		if ( !is_single() && ( is_home() || is_archive() || is_search() ) ) {
			if ( get_post_type() != 'listings' ) {
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'db_single_listing');
				$blog_category = get_the_terms(get_the_ID(), 'category');
				$posttags = get_the_tags();
				$tags = array();
				if ( $posttags !== false ) {
					foreach ($posttags as $tag_value) {
						$tags[] = '<a href="'.esc_url( get_tag_link($tag_value->term_id) ).'">'.esc_html($tag_value->name).'</a>';
					}
				}
				$date_format = get_option('date_format').' '.get_option('time_format'); ?>
				<div class="dt-blog-item-inner">
					<div class="dt-blog-item-top">
						<?php if ( $posttags !== false ) { ?>
							<div class="dt-blog-item-tag"><?php echo wp_kses( implode(', ', $tags), array( 'a' => array( 'href' => array() ) ) ); ?></div>
						<?php } ?>
						<div class="dt-blog-item-share"><img src="<?php echo get_template_directory_uri(); ?>/images/share.svg">
							<div class="dt-share-item-wrapper">
								<?php foreach ($icons as $icon_key => $icon_value) {
									if ( $icon_key == 'twitter' ) {
										$button_url = 'https://twitter.com/intent/tweet?text='.urlencode(get_the_title()).'&url='.urlencode(get_permalink());
									} else if ( $icon_key == 'gplus' ) {
										$button_url = 'https://plus.google.com/share?url='.urlencode(get_permalink());
									} else if ( $icon_key == 'facebook' ) {
										$button_url = 'https://www.facebook.com/dialog/share?app_id=145634995501895&display=popup&href='.urlencode(get_permalink());
									}
									echo '<div class="dt-share-item '.esc_attr($icon_key).'"><a href="'.esc_url( $button_url ).'" target="_blank">'.esc_html($icon_value).'</a></div>';
								} ?>
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<?php if ( isset($img['0']) ) { ?>
						<a href="<?php echo esc_url(get_permalink()); ?>"><div class="dt-blog-item-image id-<?php echo intval(get_the_ID()); ?>"></div></a>
					<?php } ?>
					<div class="dt-blog-item-bottom">
						<div class="dt-blog-item-date"><?php echo esc_html(get_the_date($date_format)); ?></div>
						<?php
							$curr_post_title = esc_html( get_the_title() );
						?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="dt-blog-item-title"><?php echo ($curr_post_title?$curr_post_title:esc_html__('Read article', 'whitelab')); ?></a>
						<div class="dt-blog-item-meta">
							<span class="dt-blog-item-author"><?php esc_html_e('by', 'whitelab'); ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID') )); ?>"><?php echo esc_html(get_the_author_meta('display_name')); ?></a></span>
							<?php if ( isset($blog_category['0']) ) { ?>
								<a href="<?php echo esc_url(get_category_link($blog_category['0']->term_id)); ?>" class="dt-blog-item-category"><?php echo esc_html($blog_category['0']->name); ?></a>
							<?php } ?>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<?php
			} else if ( function_exists('directory_get_single_listing_item') ) {
				wp_enqueue_script( 'jquery.mo' );
				echo directory_get_single_listing_item( $post );
			}
		}
	?>

	<?php if ( is_search() || is_home() || is_archive() ) {
		// Nothing
	} else {
		$categories = get_the_category_list( ', ', '', get_the_ID() ); ?>
		<div class="entry-content clearfix">
			<div class="entry-content-inner">
				<div class="db-author-wrapper">
					<div id="author-avatar">
						<?php echo get_avatar( esc_html( get_the_author_meta( 'user_email' ) ), apply_filters( 'db_author_bio_avatar_size', 97 ) ); ?>
						<span class="db-post-meta">
							<?php esc_html_e('by ', 'whitelab'); ?>
							<span>
								<?php printf( esc_attr__( '%s / %s', 'whitelab' ), '<a href="'.esc_url(get_author_posts_url($post->post_author)).'">'.esc_html(get_the_author()).'</a>', get_the_date(get_option('date_format'), intval($post->ID)) ); ?>
							</span>
						</span>
						<div class="db-author-social">
							
							<a href="<?php echo esc_url('https://www.pinterest.com/pin/create/button/'); ?>" target="_blank"></a>
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="wl-pin-it-button">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3">
									<g id="Article" transform="translate(-1203.000000, -1165.000000)" fill="#909FA5">
										<g id="path-logo" transform="translate(1203.000000, 1165.000000)">
											<g  >
												<path d="M5.94431555,1.05483063 C2.86335035,2.2749884 0.770171694,4.62620882 0.185429234,7.79359629 C-0.173457077,9.73976798 -0.0370301624,11.8609002 0.821457077,13.6774942 C1.01290023,14.0813735 1.24248724,14.4701624 1.51545244,14.8298283 C1.6477587,15.0050116 1.78992111,15.1728445 1.94372158,15.331935 C2.21724362,15.2344872 2.48157773,15.1128167 2.73327146,14.9701531 C3.77462645,14.3822923 4.54307193,13.4766404 5.43491415,12.7154339 C2.45390255,9.26143852 5.61321578,4.98180974 9.56536427,4.02743387 C13.2444362,3.14043619 18.2310905,4.67153596 19.347007,8.45702088 C19.8085754,10.0250394 19.5063202,11.758051 18.2279165,12.8932343 C17.5589791,13.4873318 16.7107378,13.880297 15.8133828,14.0401114 C15.2894478,14.1331601 14.751536,14.1477494 14.2218654,14.0954617 C13.9268492,14.066116 13.6332251,14.0159443 13.3445012,13.9481206 C12.8548677,13.8327425 12.4193039,13.8498933 12.4193039,13.3220603 L12.4193039,9.18281206 L12.4193039,7.11346636 C12.4193039,6.69037587 12.4609002,6.76989327 12.1100325,6.72623666 C11.8330023,6.69249188 11.5566961,6.66531787 11.278942,6.64348956 C10.3027935,6.56709049 9.28248724,6.5147471 8.31419026,6.68157773 C7.95190719,6.74383295 7.92902088,6.68586543 7.92902088,7.07866357 L7.92902088,8.03220418 L7.92902088,10.352464 C7.92902088,12.6641485 8.10314617,15.0031183 8.00748028,17.3105708 C7.9798051,17.9982738 7.96070534,19.648761 7.19109049,19.9894385 C6.29902552,20.3839629 5.51053364,19.5497541 4.68735035,19.3758515 C4.80027842,20.5344223 4.07560093,22.8296798 5.42622738,23.4144223 C6.66442691,23.9508306 8.08922506,24.1504037 9.39480278,23.7075452 C12.1298005,22.780065 13.014181,19.7360186 12.667768,17.235174 C16.889819,18.4963712 21.4471462,16.3861531 23.252826,12.5733828 C24.5384687,9.85876566 23.9956009,6.48651508 22.0599536,4.17806032 C18.4345615,-0.146728538 11.0751926,-0.976148492 5.94431555,1.05483063 L5.94431555,1.05483063 Z" id="Path"></path>
											</g>
										</g>
									</g>
								</g>
							</svg>
							<a href="<?php echo esc_url('https://plus.google.com/share?url='.urlencode(get_permalink())); ?>" target="_blank"><svg width="17px" height="26px" viewBox="0 0 17 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3">
									<g id="Article" transform="translate(-1207.000000, -1209.000000)" fill="#909FA5">
										<g transform="translate(-1.000000, 267.000000)" id="google-logo">
											<g transform="translate(1208.000000, 942.000000)">
												<g  >
													<path d="M16.85805,0 L9.95746667,0 C8.14923333,0 5.87151667,0.272062428 3.9627,1.87440038 C2.52053333,3.13767115 1.819,4.8757515 1.819,6.44574233 C1.819,9.10600457 3.82896667,11.8020797 7.37941667,11.8020797 C7.71431667,11.8020797 8.08123333,11.7674221 8.4524,11.7342085 C8.28466667,12.1423021 8.11551667,12.483391 8.11551667,13.0641952 C8.11551667,14.1218307 8.65186667,14.7687732 9.1205,15.3830797 C7.61486667,15.485031 4.79995,15.6551422 2.72198333,16.9507601 C0.745733333,18.1473149 0.141666667,19.8851064 0.141666667,21.1137196 C0.141383333,23.6382394 2.4871,25.9932256 7.34485,25.9932256 C13.1067167,25.9932256 16.15595,22.7527368 16.15595,19.5440175 C16.15595,17.1922083 14.8160667,16.0308887 13.3418833,14.7687732 L12.13545,13.8142442 C11.7685333,13.5066577 11.2661833,13.0982752 11.2661833,12.347071 C11.2661833,11.597022 11.7685333,11.1184579 12.2031667,10.675129 C13.6096333,9.5499111 15.0175167,8.3559556 15.0175167,5.83172458 C15.0175167,3.2384671 13.4081833,1.87382275 12.63865,1.22601381 L14.7166167,1.22601381 L16.85805,0 L16.85805,0 Z M13.9125167,20.8751595 C13.9125167,22.9898528 12.2031667,24.5583996 8.98676667,24.5583996 C5.40316667,24.5583996 3.09088333,22.8185863 3.09088333,20.3980394 C3.09088333,17.9740267 5.23515,17.1581282 5.97125,16.8849106 C7.37913333,16.4066352 9.18765,16.338764 9.48855,16.338764 C9.82401667,16.338764 9.99146667,16.338764 10.2606333,16.3719776 C12.8072333,18.213742 13.9125167,19.1359239 13.9125167,20.8751595 L13.9125167,20.8751595 Z M11.2319,9.89157761 C10.69555,10.4362801 9.7903,10.8461066 8.95248333,10.8461066 C6.07268333,10.8461066 4.76708333,7.05889364 4.76708333,4.77437792 C4.76708333,3.88714249 4.93481667,2.9669823 5.50318333,2.2501469 C6.03953333,1.56796913 6.9768,1.1240626 7.84833333,1.1240626 C10.6284,1.1240626 12.0697167,4.94477796 12.0697167,7.39998253 C12.0697167,8.01515553 12.0014333,9.10571575 11.2319,9.89157761 L11.2319,9.89157761 Z" id="Google"></path>
												</g>
											</g>
										</g>
									</g>
								</g>
							</svg></a>
							<a href="<?php echo esc_url('https://twitter.com/intent/tweet?text='.urlencode(get_the_title()).'&url='.urlencode(get_permalink())); ?>" target="_blank"><svg width="25px" height="17px" viewBox="0 0 25 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3">
									<g id="Article" transform="translate(-1203.000000, -1254.000000)" fill="#909FA5">
										<g transform="translate(-1.000000, 267.000000)" id="twitter-logo-(1)">
											<g transform="translate(1204.000000, 987.000000)">
												<g  >
													<path d="M22.1220418,7.56468285 C23.5232599,7.45101785 24.4737239,6.82469115 24.8395012,5.97485558 C24.3340487,6.2801485 22.7650232,6.61298793 21.8984919,6.29600343 C21.8560325,6.0958207 21.8085847,5.90567563 21.762007,5.73400896 C21.1017401,3.35018057 18.8410673,1.42968109 16.4723318,1.66168774 C16.6639791,1.58560689 16.8583527,1.514773 17.0521462,1.4511822 C17.312877,1.35936049 18.8426334,1.11463568 18.6017401,0.583723709 C18.3987239,0.116744742 16.5296984,0.936638443 16.1777842,1.04380179 C16.6423434,0.872021056 17.4106148,0.576537662 17.4929234,0.0516710972 C16.7812065,0.147656149 16.0825406,0.478499454 15.5426914,0.959565354 C15.737587,0.75328019 15.8854408,0.501882622 15.9168213,0.231322263 C14.0185615,1.42369272 12.9096868,3.82759641 12.012297,6.15946854 C11.3076566,5.48802944 10.6831206,4.95928469 10.1228538,4.66568336 C8.55110209,3.83694968 6.67180974,2.97228576 3.72175174,1.89551941 C3.6312065,2.85519883 4.20446636,4.1312354 5.85632251,4.97981625 C5.49843387,4.93270772 4.84396752,5.03781791 4.32053364,5.16106432 C4.5337007,6.26047242 5.22987239,7.16625649 7.11455916,7.60426314 C6.25324826,7.66015462 5.80812065,7.85286614 5.40469838,8.26823104 C5.79698376,9.03286062 6.75423434,9.93277038 8.4762181,9.74804335 C6.56171694,10.5593822 7.69559165,12.0618933 9.25342227,11.8378142 C6.59588167,14.536745 2.40597448,14.3383873 0,12.0809991 C6.28184455,20.4973425 19.937123,17.05842 21.9720998,8.95187501 C23.4967517,8.96465021 24.3930394,8.4325976 24.9487819,7.84602228 C24.0703596,7.99259482 22.7971578,7.84111752 22.1220418,7.56468285 L22.1220418,7.56468285 Z" id="Twitter__x28_alt_x29_"></path>
												</g>
											</g>
										</g>
									</g>
								</g>
							</svg></a>
							<a href="<?php echo esc_url('https://www.facebook.com/dialog/share?app_id=145634995501895&display=popup&href='.urlencode(get_permalink())); ?>" target="_blank"><svg width="11px" height="24px" viewBox="0 0 11 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0.3">
									<g id="Article" transform="translate(-1210.000000, -1291.000000)" fill="#909FA5">
										<g id="facebook-letter-logo" transform="translate(1210.000000, 1291.000000)">
											<g  >
												<path d="M2.4004505,4.63851508 L2.4004505,7.93603712 L0.0379009901,7.93603712 L0.0379009901,11.9682599 L2.4004505,11.9682599 L2.4004505,23.9506079 L7.25362871,23.9506079 L7.25362871,11.968594 L10.5103366,11.968594 C10.5103366,11.968594 10.8153416,10.035174 10.9631881,7.92116937 L7.2719802,7.92116937 L7.2719802,5.16417633 C7.2719802,4.75211137 7.80112376,4.19782831 8.32411386,4.19782831 L10.9683069,4.19782831 L10.9683069,5.56844545e-05 L7.37310396,5.56844545e-05 C2.28048515,-0.000222737819 2.4004505,4.03600928 2.4004505,4.63851508 L2.4004505,4.63851508 Z" id="Facebook"></path>
											</g>
										</g>
									</g>
								</g>
							</svg></a>
						</div>
					</div>
				</div>
				<div class="db-post-head">
					<div class="db-single-header">
						<span class="db-single-category"><?php echo wp_kses( $categories, array( 'a' => array( 'href' => array(), 'rel' => array() ) ) ); ?></span>
						<h1 class="db-single-title"><?php the_title(); ?></h1>
					</div>
					<div class="db-single-navigation">
						<span><?php esc_html_e( 'Next post', 'whitelab' ); ?></span>
						<?php
						$prev_arrow = '
						<svg width="7px" height="11px" viewBox="0 0 7 11" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="square">
								<g id="Article" transform="translate(-251.000000, -785.000000)" stroke="#CCCCCC" stroke-width="2">
									<g transform="translate(-1.000000, 267.000000)" id="arrows">
										<g transform="translate(253.000000, 519.000000)">
											<g id="arrow-left" transform="translate(2.500000, 4.500000) rotate(-270.000000) translate(-2.500000, -4.500000) translate(-2.000000, 2.000000)">
												<path d="M0.5,0.5 C0.5,0.5 1.13381189,1.13381189 1.91025037,1.91025037 L4.5,4.5" id="Line" fill="#D8D8D8"></path>
												<path d="M8.5,0.5 C8.5,0.5 7.86618811,1.13381189 7.08974963,1.91025037 L4.5,4.5" id="Line-Copy-2"></path>
											</g>
										</g>
									</g>
								</g>
							</g>
						</svg>';
						$next_arrow = '
						<svg width="7px" height="11px" viewBox="0 0 7 11" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="square">
								<g id="Article" transform="translate(-288.000000, -785.000000)" stroke="#CCCCCC" stroke-width="2">
									<g transform="translate(-1.000000, 267.000000)" id="arrows">
										<g transform="translate(253.000000, 519.000000)">
											<g id="arrow" transform="translate(39.500000, 4.500000) rotate(-90.000000) translate(-39.500000, -4.500000) translate(35.000000, 2.000000)">
												<path d="M0.5,0.5 C0.5,0.5 1.13381189,1.13381189 1.91025037,1.91025037 L4.5,4.5" id="Line" fill="#D8D8D8"></path>
												<path d="M8.5,0.5 C8.5,0.5 7.86618811,1.13381189 7.08974963,1.91025037 L4.5,4.5" id="Line-Copy-2"></path>
											</g>
										</g>
									</g>
								</g>
							</g>
						</svg>';
						previous_post_link('%link', $prev_arrow);
						next_post_link('%link', $next_arrow);
						?>
					</div>
				</div>
				<div id="entry-content-wrapper">
					<?php the_content( esc_html__( 'Continue reading', 'whitelab' ).' '.'<span class="meta-nav">&rarr;</span>' ); ?>
					<?php
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'whitelab' ) . '</span>',
							'after'       => '<div class="clearfix"></div></div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					?>
					<div class="db-single-post-tags clearfix">
						<?php echo get_the_tag_list(); ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				?>
			</div>
		</div><!-- .entry-content -->
	<?php } ?>
</article><!-- #post-## -->