<!-- begin sidebar -->


<div id="sidebar">


<div id="subscribe">

	<p><img style="vertical-align:-2px;" alt="RSS" src="<?php bloginfo('template_directory'); ?>/images/feed-icon-16x16.gif" /> &nbsp;<a href="<?php bloginfo_rss('rss2_url') ?>"><?php _e('Announcements RSS feed'); ?></a> <!-- | <a href="<?php bloginfo_rss('comments_rss2_url') ?>"><?php _e('Comments RSS'); ?></a> --></p>

</div>


<div class="menu">

<ul>

<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar(2)) { } else { ?>


 
 <li class="widget" id="tags"><h3><?php _e('Tagcloud'); ?></h3>
 
	<?php wp_tag_cloud(''); ?>

 </li>
 

	 <li class="widget" id="archives"><h3><?php _e('Archives'); ?></h3>
 	<ul>
	 <?php wp_get_archives('type=monthly'); ?>
 	</ul>
 </li>
 <li class="widget" id="meta"><h3><?php _e('Meta'); ?></h3>
 	<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('RSS'); ?></a></li>

		<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments RSS'); ?></a></li>
		<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
		<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
		<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>"><abbr title="WordPress">WP</abbr></a></li>

		<?php wp_meta(); ?>
	</ul>
 </li> 
 
 <li class="widget" id="calendar"> 
	<h3><?php _e('Calendar'); ?></h3>
	 <?php get_calendar(); ?> 
	</li>
 
 
 
<?php } ?>

</ul>



</div>





</div><!-- end sidebar -->

	



