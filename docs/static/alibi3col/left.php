<div id="left">



<div class="menu">

<ul>

<?php /* WordPress Widget Support */ 

		if ( function_exists('dynamic_sidebar') and dynamic_sidebar(1)) {} else { ?>


	<li class="widget" id="pages"> 
	<h3><?php _e('Pages'); ?></h3>
		<ul>
				<?php wp_list_pages('title_li='); ?>
		</ul>
	</li>
	

	
	<li class="widget" id="links">
		
		<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>&category_before=&category_after='); ?>
		
	</li>
	
	
 <li class="widget" id="categories"><h3><?php _e('Categories'); ?></h3>
	<ul>
	<?php wp_list_categories('title_li='); ?>
	</ul>
 </li>


	

 <li class="widget" id="search">
 		<h3><?php _e('Search'); ?></h3>
 		<ul>

  	 <form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	
		<input type="text" name="s" id="s" style="width:100px" /><input type="submit" value="<?php _e('Search'); ?>" />

	</form>
 		</ul>
 </li>

<?php } ?>

</ul>

</div>

</div>
