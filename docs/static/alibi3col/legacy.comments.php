
<div class="entry">
<?php 
if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<?php if ( comments_open() ) : ?>
<h3 id="comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?> 

	<a href="#postcomment" title="<?php _e("Leave a comment"); ?>"></a>
<?php endif; ?>
</h3>

<?php if ( $comments ) : ?>


<ul id="lcommentlist">

<?php foreach ($comments as $comment) : 

if (get_comment_type() == 'comment'){

?>

	<li id="comment-<?php comment_ID() ?>">
	<div class="comm">
	<div class="gravatar">
<?php

   if (function_exists('get_avatar')) {
       echo get_avatar(get_comment_author_email(), '50');
   } else {
	  $gravatarUrl = "http://www.gravatar.com/avatar.php?gravatar_id=" . md5(get_comment_author_email()) . "&size=50";
      echo "<img src='$gravatarUrl'/>";
   }
?>

</div>


		<div class="commenttext">
			<div class="commentwrapper">
		
				<p class="commentheader"><b>By <?php comment_author_link() ?></b>, <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a> </p>

			<?php comment_text() ?>

			</div>
		</div>
		<div style="clear:both;"></div>
		</div>
</li>

<?php } ?> 
<?php endforeach; ?>

</ul>

<h3 id="comments"><?php _e('Other Links to this Post'); ?></h3>

<ol id="lcommentlist">

<?php foreach ($comments as $comment) : 

	if (get_comment_type() != 'comment'){

?>

	<li id="comment-<?php comment_ID() ?>">
		<p class="commentheader"><?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></p>

	</li>
<?php } ?> 
<?php endforeach; ?>

</ol>




<?php else : // If there are no comments yet ?>

<?php if ( comments_open() ) : ?>
	<p><?php _e('No comments yet.'); ?></p>
<?php endif; ?>	
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>
<p><?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?> 
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack URI'); ?></a>
<?php endif; ?>
</p>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<h3 id="postcomment"><?php _e('Leave a comment'); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
<label for="author">*Name </label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" />
<label for="email">*Email (not published) </label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" />
<label for="url">Website</label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" style="width:80%; height:100px;" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Add your Comment" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>

<?php do_action('comment_form', $post->ID); ?>

</form>


<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>

<?php endif; ?>
</div>
