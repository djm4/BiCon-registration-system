<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<style type="text/css" media="screen">
	
body{
	background: #aaa url("<?php bloginfo('template_directory'); ?>/images/bodybg.gif");
				}
	
	#header{
	background: #444 url("<?php bloginfo('template_directory'); ?>/images/headerbg.jpg") repeat-x;
				}
	
			
		a{
		color: <?php echo ali_linkColour(); ?>;
		}
		
		a:hover{
		color: <?php echo ali_hoverColour(); ?>;
		}
		
		.menu ul li.widget h3 {
		background: #eee url("<?php bloginfo('template_directory'); ?>/images/list_header_bullet.gif") no-repeat 0 4px;
			}
		
	#tabs {
		border-bottom: 4px solid <?php echo ali_linkColour(); ?>;
		}
				
	#tabs a {
      background: url("<?php bloginfo('template_directory'); ?>/images/tableft.gif") no-repeat left top;
      }
			
    #tabs a span {
      background: url("<?php bloginfo('template_directory'); ?>/images/tabright.gif") no-repeat right top;
}				
		
	<?php if (get_settings('thread_comments') == 1){ ?>	
		
	ol.commentlist li div.reply {
	background:#ddd;
	border:1px solid #aaa;
	padding:2px 10px;
	text-align:center;
	width:35px;
	 -moz-border-radius: 3px;
   -khtml-border-radius: 3px;
   -webkit-border-radius: 3px;
   border-radius: 3px;
	}
		
		ol.commentlist li div.reply:hover {
background:#f3f3f3;
border:1px solid #aaa;
		}
	<?php } ?>	
				
	</style>
	
	<!--[if IE]>
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie-only.css" />
<![endif]-->

		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/utils.js"></script>
	
<?php

if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
 wp_head();
 ?>

</head>
<body>


<div id="wrapper">
<div id="wrapper2">
<div id="wrapper3">
<div id="wrapper4">

<div id="header">
	

	
		<form id="searchform2" method="get" action="<?php bloginfo('home'); ?>">
		
			<input type="text"  onfocus="doClear(this)" value="<?php _e('Search this site...'); ?>" class="searchinput" name="s" id="s" size="25" /> <input type="submit" class="searchsubmit" value="<?php _e('Go'); ?>"   onmouseover="this.style.background='#666666'"
onmouseout="this.style.background='#333333'" />
			
		</form>
	
	
		<h3><a href="<?php bloginfo('home'); ?>/"><?php bloginfo('name'); ?></a></h3>

		
			<h2><?php bloginfo('description'); ?></h2>
		

</div>


<div id="tabs">


  	<ul>
			<?php echo buildMenu(); ?>
	 </ul>

</div>
		

