<?php get_header(); ?>


<div id="content">
	<div id="content-inner">

<?php include(TEMPLATEPATH .'/left.php'); ?>


<div id="main">

<div id="main-inner">

<?php if (have_posts()) : ?>
		
	<?php while (have_posts()) : the_post(); ?>
			
	<div class="post" id="post-<?php the_ID(); ?>">
	
	<div class="date">
	
	<!--
		<span class="dateMonth"><?php the_time('M'); ?></span>
		<span class="dateDay"><?php the_time('d'); ?></span>
		<span class="dateYear"><?php the_time('Y'); ?></span>
	--> 
	</div>	
		
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<div class="entry">
				<?php the_content('Read more &raquo;'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>'. __('Pages','') .':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<div style="clear:both;"></div>
		</div>
	
	
	
		<div class="postmetadata">
		
			<!-- <p><?php the_author_posts_link(); ?> <?php edit_post_link('Edit',' ',''); ?></p> -->
			
			</div> 

		
		<!-- ?php comments_template(); ? -->
		
		
		</div>
		
		


	<?php endwhile; ?>

	
	
	<div id="navigation">
			<div class="fleft"><?php next_posts_link('&laquo; Older') ?></div>
					<div class="fright"> <?php previous_posts_link('Newer &raquo;') ?></div>
	</div>
			
	

	<?php else : ?>
	
	<div class="post">
	<div class="entry">
		<h2>Not Found</h2>
		<p>Sorry, you are looking for something that isn't here.</p>
	</div>
	</div>	
		
	<?php endif; ?>
	
	

		</div>
	</div> <!-- eof main -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>


