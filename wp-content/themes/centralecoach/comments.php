<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage WhiteLab
 * @since WhiteLab 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */	
if ( post_password_required() ) {
	return;
}
$have_comments = have_comments();

?>

<div id="comments" class="comments-container">
	<div class="db-comment-inner <?php echo (!$have_comments?'no-comments':''); ?>">
		<?php if ( $have_comments ) { ?>
			<span class="db-comment-count">
				<span class="db-comment-number"><?php echo intval( get_comments_number() ); ?></span>
				<?php esc_html_e('Comments', 'whitelab'); ?>
				<img src="<?php echo get_template_directory_uri(); ?>/images/comment-arrow.jpg" alt="">
			</span>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'whitelab' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'whitelab' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'whitelab' ) ); ?></div>
				</nav><!-- #comment-nav-above -->
			<?php endif; // Check for comment navigation. ?>

			<ol class="commentlist">
				<?php
					wp_list_comments( array(
						'style'      => 'ol',
						'short_ping' => true,
						'avatar_size'=> 54,
						'callback' => 'db_comment'
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'whitelab' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'whitelab' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'whitelab' ) ); ?></div>
				</nav><!-- #comment-nav-below -->
			<?php endif; // Check for comment navigation. ?>

			<?php if ( ! comments_open() ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'whitelab' ); ?></p>
			<?php endif; ?>

		<?php }

		if ( is_user_logged_in() ) {
			$comment_fields = '<p class="comment-form-comment"><span class="db-send-comment"></span><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__('Comment *', 'whitelab') . '" required>' . '</textarea></p>';
		} else {
			$comment_fields = '<div class="comment-form-top"><span class="comment-author"><input id="author" name="author" type="text" placeholder="' . esc_html__('Name *', 'whitelab') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></span><span class="comment-email"><input id="email" name="email" type="text" placeholder="' . esc_html__('E-mail *', 'whitelab') . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /></span><span class="comment-url"><input id="url" name="url" type="text" placeholder="' . esc_html__('Website', 'whitelab') . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span><div class="clearfix"></div></div><p class="comment-form-comment"><span class="db-send-comment"></span><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__('Comment *', 'whitelab') . '">' . '</textarea></p>';
		}

		comment_form(
			array('comment_notes_after' => '',
					'logged_in_as' => '',
					'url' => '',
					'title_reply'      => esc_html__( 'Leave your comment', 'whitelab'),
					'comment_notes_before' => '',
					'label_submit'    => esc_html__( 'Post Comment', 'whitelab'),
					'comment_field' =>  $comment_fields,
					'fields' => array(
						'author' => '',
						'email' => '',
						'url' => ''
					)
				)
			); ?>
		<div class="clearfix"></div>
	</div>
</div><!-- #comments -->