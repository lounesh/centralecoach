<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

function db_custom_review( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$rating_value = get_comment_meta( intval($comment->comment_ID), 'listing_review_rating', true );
	$title_value = get_comment_meta( intval($comment->comment_ID), 'listing_review_title', true );

	if ( $comment->user_id != 0 ) {
		$author_url = '<a href="'.esc_url(get_author_posts_url($comment->user_id)).'" class="db-review-author">'.esc_html(get_user_meta($comment->user_id, 'first_name', true)).' '.esc_html(get_user_meta($comment->user_id, 'last_name', true)).'</a>';
		$author_name = esc_html(get_user_meta($comment->user_id, 'first_name', true)).' '.esc_html(get_user_meta($comment->user_id, 'last_name', true));
	} else {
		$author_url = '<a href="#" class="db-review-author">'.$comment->comment_author.'</a>';
		$author_name = $comment->comment_author;
	}
	

	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php esc_html_e( 'Pingback:', 'whitelab' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'whitelab' ), '<span class="edit-link button blue">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	
	<li <?php comment_class(); ?> id="li-review-<?php esc_attr(comment_ID()); ?>">
		<div id="review-<?php esc_attr(comment_ID()); ?>" class="review" itemscope itemtype="http://schema.org/Review">
			<div class="review-meta">
				<div class="review-author shadows">
					<?php echo get_avatar( $comment, 54 ); ?>
				</div><!-- .review-author .vcard -->
			</div>

			<div class="review-content">
				<?php echo '<span class="db-review-title" itemprop="name">'.esc_html($title_value).'</span>' ?>
				<?php echo '<span class="db-listing-rating">'.db_get_rating_stars( intval($rating_value) ).'</span>'; ?>
				<?php if ( $comment->comment_approved == '0' ) { ?>
					<em class="review-awaiting-moderation"><?php esc_html_e( 'Your review is awaiting moderation.', 'whitelab' ); ?></em>
				<?php } ?>
				<?php edit_comment_link( esc_html__( 'Edit', 'whitelab' ), '<span class="edit-link button blue">', '</span>' ); ?>
				<div class="db-review-content" itemprop="description">
					<?php comment_text(); ?>
				</div>
				<div class="db-review-bottom">
					<?php printf( esc_html__('%s on %s at %s', 'whitelab'), $author_url, get_comment_date(get_option('date_format')), get_comment_date(get_option('time_format')) ); ?>
				</div>
				<meta itemprop="itemReviewed" content="<?php echo get_the_title(); ?>">
				<meta itemprop="author" content="<?php echo $author_name; ?>">
				<meta itemprop="datePublished" content="<?php echo get_comment_date('Y-m-d'); ?>">
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
					<meta itemprop="worstRating" content="1">
					<meta itemprop="ratingValue" content="<?php echo $rating_value; ?>">
					<meta itemprop="bestRating" content="5">
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div><!-- end of review -->
	<?php
			break;
	endswitch;
}

$have_comments = have_comments();

?>

<div id="comments" class="comments-area <?php echo (!$have_comments?'no-comments':''); ?>">

	<?php if ( $have_comments ) : ?>
		<span class="db-comment-count">
			<span class="db-comment-number"><?php echo get_comments_number(); ?></span>
			<?php esc_html_e('Reviews', 'whitelab'); ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/comment-arrow.jpg" alt="">
		</span>

		<?php the_comments_navigation(); ?>

		<ul class="review-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 42,
					'callback' => 'db_custom_review'
				) );
			?>
		</ul><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Ratings are closed.', 'whitelab' ); ?></p>
	<?php endif; ?>

	<?php
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

		$rating_stars = '
		<div class="db-rating-stars">
			<span class="db-rating-text">'.esc_html__('Your rating', 'whitelab').'</span>
			<div class="db-rating-container">'.$rating_star.$rating_star.$rating_star.$rating_star.$rating_star.'</div>
			<input type="radio" name="listing_rating" value="1" required>
			<input type="radio" name="listing_rating" value="2" required>
			<input type="radio" name="listing_rating" value="3" required>
			<input type="radio" name="listing_rating" value="4" required>
			<input type="radio" name="listing_rating" value="5" required>
		</div>';

		comment_form( array(
			'title_reply_before' => '<h3 id="rating-title" class="comment-rating-title">',
			'title_reply_after'  => '</h3>',
			'logged_in_as' => '',
			'url' => '',
			'title_reply'      => esc_html__( 'Leave your review', 'whitelab'),
			'comment_notes_before' => '',
			'label_submit'    => esc_html__( 'Publish', 'whitelab'),
			'comment_field' => $rating_stars.'<span class="comment-form-review-title"><input id="review-title" name="review-title" type="text" value="" size="30" maxlength="245" placeholder="'.esc_html__('Title of your review *', 'whitelab').'" aria-required="true" required="required"></span>'.(!is_user_logged_in()?'<div class="db-add-review-bottom"><span class="comment-author"><input id="author" name="author" type="text" placeholder="' . esc_html__('Your name *', 'whitelab') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required="required" /></span><span class="comment-email"><input id="email" name="email" type="email" placeholder="' . esc_html__('Your email *', 'whitelab') . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" required="required" /></span><div class="clearfix"></div></div>':'').'<span class="comment-form-comment"><span class="db-send-comment"></span><textarea id="comment" name="comment" placeholder="'.esc_html__('Your review *', 'whitelab').'" aria-required="true" required="required"></textarea></span>',
			'fields' => array(
				'author' => '',
				'email' => '',
				'url' => '',
			)
		) );
	?>

</div><!-- .comments-area -->