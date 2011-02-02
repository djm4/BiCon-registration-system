<?php


	// Widgets
  if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => __('Left Sidebar','alibi'),
		
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',

	));
	
	register_sidebar(array(
		'name' => __('Right Sidebar','alibi'),
		
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',

	));		
}

add_filter('comments_template', 'legacy_comments');
function legacy_comments($file) {
	if ( !function_exists('wp_list_comments') ) 
		$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}



define (TEMPLATEURL, get_bloginfo('template_directory')); 
define(ALI_LINKCOLOUR, '#3C439F');
define(ALI_HOVERCOLOUR, '#731113');

add_action('admin_print_scripts', 'mer_adminScripts');

function mer_adminScripts(){
 
 	wp_enqueue_script('jscolor', TEMPLATEURL . '/scripts/jscolor/jscolor.js', 'jquery');
	
	$jsPath = TEMPLATEURL . '/scripts/jscolor/';
	wp_localize_script('jscolor', 'metaSettings', array('templateUrl' => $jsPath));
}


function buildMenu(){
	global $wpdb;
	
	$mo = ap_getPageMenuOrder();
	
	$menu = '<li><a href="'.get_option('home').'/" title="'. __('Home','alibi').'"><span>'. __('Home','alibi').'</span></a></li>';
	
	$pages = $wpdb->get_results("SELECT ID, post_title as title, guid FROM $wpdb->posts WHERE post_type='page' AND post_status='publish' AND post_parent='0' ORDER BY $mo");

	$exc = get_option('ap_pagesOmit');	
	
	$excludeArray = explode(',',$exc);
	
	foreach ($pages as $page){
	
		if (!in_array($page->ID, $excludeArray)){
	
			$url = get_page_link($page->ID);
	
			$menu .=  sprintf('<li><a href="%s" title="%s"><span>%s</span></a></li>', $url, $page->title, $page->title);
		}
	
	}
	return $menu;
}				

function ap_add_theme_page() {
	global $wpdb;

	$errorFlag = false;	
	if ($_GET['page'] == basename(__FILE__)) {
	
	    // save settings
		if ( 'save' == $_REQUEST['action'] ) {

			if (valid_colour($_REQUEST['ali_linkColour'])){
					update_option('ali_linkColour', $_REQUEST['ali_linkColour']);
			} else {
 				$errorFlag = true;
			}
			
			if (valid_colour($_REQUEST['ali_hoverColour'])){
					update_option('ali_hoverColour', $_REQUEST['ali_hoverColour']);
			} else {
 				$errorFlag = true;
			}	
			
			
			if (($_REQUEST['ap_pageMenuOrder'] == 'menu') || 
				($_REQUEST['ap_pageMenuOrder'] == 'alpha') || 
				($_REQUEST['ap_pageMenuOrder'] == 'pageid')  
			){
			update_option('ap_pageMenuOrder', $_REQUEST['ap_pageMenuOrder']);
			} else {
 				$errorFlag = true;
			}
			
			if (checkPagesOmit($_REQUEST['ap_pagesOmit'])){
				update_option('ap_pagesOmit', trim($_REQUEST['ap_pagesOmit']));
			} else {
 				$errorFlag = true;
			}
			
							
			// goto theme edit page
			if($errorFlag){
					header("Location: themes.php?page=functions.php&error=true");
					die;
			} else {
					header("Location: themes.php?page=functions.php&saved=true");
					die;
			}
			
			
  		// reset defaults
		} else if('reset' == $_REQUEST['action']) {
			delete_option('ali_linkColour');
			delete_option('ali_hoverColour');			
			delete_option('ap_pageMenuOrder');	
			delete_option('ap_pagesOmit');				
			header("Location: themes.php?page=functions.php&reset=true");
			die;

		}
	}

    add_theme_page(__('Alibi3col Theme Options','alibi'), __('Alibi3col Options','alibi'), 'edit_themes', basename(__FILE__), 'ap_theme_page');

}

function ap_theme_page() {

	global $wpdb;

	
 ?>

<div class="wrap">


<?php if ($_REQUEST['saved'] ) echo '<div style="margin:10px 0;" id="message" class="updated fade"><p><strong>'.__('Settings saved.','alibi').'</strong></p></div>';
	if ($_REQUEST['reset'] ) echo '<div style="margin:10px 0;" id="message" class="updated fade"><p><strong>'.__('Settings reset.','alibi').'</strong></p></div>';
	if ($_REQUEST['error'] ) echo '<div style="margin:10px 0;" id="message" class="error errorfade"><p><strong>'.__('Error - invalid data','alibi').'</strong></p></div>';

 ?>


<h2><?php _e('Alibi3col Theme Options', 'alibi') ;?></h2>

<p><?php _e('Alibi3col theme by <a href="http://themocracy.com/">Themocracy</a> -  the options are short and sweet...','alibi'); ?></p>


<form name="tcp" method="post">


<table width="100%" cellspacing="2" cellpadding="5" class="form-table">

<?php

		
		ap_th(__('Link Color:','alibi'));
		
?>
<input name="ali_linkColour" type="text" value="<?php echo ali_linkColour(); ?>" class="color {hash:true, pickerMode:'HSV'}" />
	<?php
		ap_cth();	
	
	ap_th(__('Hover Color:','alibi'));
		
	?>
<input name="ali_hoverColour" type="text" value="<?php echo ali_hoverColour(); ?>" class="color {hash:true, pickerMode:'HSV'}" />
	<?php
		ap_cth();	
	
	ap_th(__('Horizontal Pages Menu:<br /><small>(Displays top-level pages only)</small>','alibi'));
		
		$setPageMenuOrder = get_settings('ap_pageMenuOrder');
		$pageMenuOrder = !empty($setPageMenuOrder) ? $setPageMenuOrder : 'menu';
		

 ?>
			
		Order by: <select name="ap_pageMenuOrder">
		<option <?php if($setPageMenuOrder == 'alpha') echo 'selected'  ?> value="alpha">Page Title</option>
		<option <?php if($setPageMenuOrder == 'menu') echo 'selected'  ?> value="menu">Page Order</option>
		<option <?php if($setPageMenuOrder == 'pageid') echo 'selected'  ?> value="pageid">Page ID</option>
		</select>
		
		<br />
		
	
		<?php _e('Exclude','alibi'); ?>:<br />
		
<?php 
	$valPagesOmit = (!empty($_REQUEST['ap_pagesOmit'])) ? $_REQUEST['ap_pagesOmit'] :  get_option('ap_pagesOmit');
	
	echo ap_input('ap_pagesOmit', 'text', '', $valPagesOmit ); ?>
		

	<?php 
		
	_e('<br /><small>Page IDs, separated by commas</small>','alibi');
		
	
	ap_cth();	
	
	
?>

</table>


<?php ap_input('save', 'submit', '', __('Save Settings','alibi')); ?>


<input type="hidden" name="action" value="save" />

</form>



<form method="post">




<?php

	ap_input('reset', 'submit', '', __('Restore Default Settings','alibi'));
	
?>


<input type="hidden" name="action" value="reset" />

</form>

<?php
}

add_action('admin_menu', 'ap_add_theme_page');

	
function ap_input($var, $type, $description='', $value='', $selected='', $onchange='' ) {


 	echo "\n";
 	
	switch( $type ){
	
	    case "text":

	 		printf('<input name="%s" id="%s"  type="%s" style="width: 60%%" class="code" value="%s" onchange="%s" />', $var, $var, $type, $value, $onchange);
			 
			break;
			
		case "submit":
		
			printf('<p class="submit"><input name="%s" type="%s" value="%s" /><p>',  $var, $type, $value);

			break;

		case "option":
		
			if($selected == $value)  $extra = 'selected '; 

			printf('<option value="%s" %s>%s</option>', $value, $extra, $description);
		
		    break;
  		case "radio":
  		if($selected == $value)  $extra = 'checked '; 
  		
			printf('<label><input name="%s" id="%s" type="%s" value="%s" %s /> %s</label> &nbsp;', $var, $var, $type, $value, $extra, $description); 
 			
  			break;
  			
		case "checkbox":
		
			if($selected == $value)  $extra = 'checked '; 

				printf('<label><input name="%s" id="%s" type="%s" value="%s" %s /> %s</label><br/>', $var, $var, $type, $value, $extra, $description); 

  			break;

		case "textarea":
		
			printf('<textarea name="%s" id="%s" style="width: 60%%; height: 10em;" class="code"></textarea>',$var, $var, $value ); 
		
		    break;
	}

}

function ap_th( $title ) {


   	echo '<tr valign="top">';
		echo '<th align="right" width="33%" scope="row">'.$title.' </th>';
		echo '<td>';

}

function ap_cth() {

	echo '</td>';
	echo '</tr>';
	
}

function valid_colour($var){
	$regex = '^#([a-f]|[A-F]|[0-9]){6}^';
	return preg_match($regex,$var);
}


	
function ali_linkColour() {
	$tc =  get_option('ali_linkColour');
	return (empty($tc)) ? ALI_LINKCOLOUR : $tc;
	}

function ali_hoverColour() {
	$tc =  get_option('ali_hoverColour');
	return (empty($tc)) ? ALI_HOVERCOLOUR : $tc;
	}	


function ap_getPageMenuOrder() {

	switch (get_settings('ap_pageMenuOrder')){
	
		case ('alpha'):
		$mo = 'post_title ASC';
		break;
		
		case ('pageid'):
		$mo = 'ID DESC';
		break;
		
		default:
		$mo = 'menu_order';
	}
	
	return $mo;
}

function checkPagesOmit($str){
	if (empty($str)) return true;
	$regex = '/^[0-9 ,]+$/';
	return preg_match($regex,$str);
}

?>