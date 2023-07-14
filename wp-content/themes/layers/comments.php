<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';


/* You can start editing here. */
 ?>
<?php if ($comments) : ?>
	<?php wp_list_comments(); ?>
	<?php paginate_comments_links(); ?>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

        <p class="nocomments">No comments yet</p>

	 <?php else : // comments are closed ?>
		<!-- If comments are closed and also there are no comments -->
		<!-- Do nothing! <p class="nocomments">Comments are closed.</p> -->

	<?php endif; ?>
<?php endif; ?>



<?php if ('open' == $post->comment_status) : ?>
<div id="response">
	<h3 id="respond">Leave a Reply</h3>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.
	<?php else : ?>
 <?php comment_form(); ?>
</div>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>