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
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One rating for &ldquo;%s&rdquo;', 'comments title', 'directory-builder' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s rating for &ldquo;%2$s&rdquo;',
							'%1$s ratings for &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'directory-builder'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ul class="review-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 42,
					'callback' => 'db_review'
				) );
			?>
		</ul><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Ratings are closed.', 'directory-builder' ); ?></p>
	<?php endif; ?>

	<?php
		$rating_stars = '
		<div class="db-rating-stars">
			'.__('Rate here:', '').'
			<div class="db-rating-container">
				<span class="dbicon-star-empty"></span>
				<span class="dbicon-star-empty"></span>
				<span class="dbicon-star-empty"></span>
				<span class="dbicon-star-empty"></span>
				<span class="dbicon-star-empty"></span>
			</div>
			<input type="radio" name="listing_rating" value="1" required>
			<input type="radio" name="listing_rating" value="2" required>
			<input type="radio" name="listing_rating" value="3" required>
			<input type="radio" name="listing_rating" value="4" required>
			<input type="radio" name="listing_rating" value="5" required>
		</div>';

		comment_form( array(
			'title_reply_before' => '<h2 id="rating-title" class="comment-rating-title">',
			'title_reply_after'  => '</h2>',
			'logged_in_as' => '',
			'url' => '',
			'title_reply'      => __( 'Write a review', 'directory-builder'),
			'comment_notes_before' => '',
			'label_submit'    => __( 'Publish', 'directory-builder'),
			'comment_field' => $rating_stars.'<p class="comment-form-comment"><label for="comment">' . __( 'Your experience', 'directory-builder' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>'
		) );
	?>

</div><!-- .comments-area -->
