<?php
/*
Plugin Name: ProcessingJS for WP
Plugin URI: http://cagewebdev.com/pjs4wp
Description: Directly write Processing.js code in your post / page or include an existing .pde sketch
Version: 1.1
Date: 04/26/2015
Author: Rolf van Gelder
Author URI: http://cagewebdev.com/
License: GPL2
*/

/***********************************************************************************************
 *	USAGE:
 *
 *	Method 1: write the code directly in a post / page
 *	[pjs4wp]
 *	void setup()
 *	{
 *		size(200, 200);
 *		text("Hello world!", 50, 50);
 *	}
 *	[/pjs4wp]
 *
 *	Method 2: use an existing Processing .pde sketch
 *	[pjs4wp url="http://localhost/wp-content/uploads/rvg_human.pde" bordercolor="#888"][/pjs4wp]
 ***********************************************************************************************/

/***********************************************************************************************
 *
 *	LOAD THE SCRIPTS
 *
 ***********************************************************************************************/ 
function pjs4wp_load_scripts()
{
	wp_deregister_script( 'pjs4wp' );
	wp_enqueue_script( 'pjs4wp', plugins_url( '/js/processing.min.js', __FILE__ ), false, '1.4.8' );
} // pjs4wp_load_scripts()
add_action( 'init', 'pjs4wp_load_scripts' );


/***********************************************************************************************
 *
 *	SHOW A LINK TO THE INSTRUCTIONS PAGE ON THE MAIN PLUGINS PAGE
 *
 *	Since: v1.1
 *
 ***********************************************************************************************/ 
function pjs4wp_settings_link($links)
{ 
  array_unshift($links, '<a href="options-general.php?page=pjs4wp_instructions">'.__('Instructions', 'pjs4wp').'</a>'); 
  return $links;
} // pjs4wp_settings_link()
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'pjs4wp_settings_link');


/***********************************************************************************************
 *
 *	ADD THE 'OPTIMIZE DB SETTINGS' ITEM TO THE SETTINGS MENU
 *
 *	Since: v1.1
 *
 ***********************************************************************************************/ 
function rvg_pjs4wp_instructions()
{
	if (function_exists('add_submenu_page'))
	{	add_submenu_page(
			null, // parent_slug: HIDE FROM MENUS!
			__('ProcessingJS for WP', 'pjs4wp'), // page_title
			__('ProcessingJS for WP', 'pjs4wp'), // menu_title
			'manage_options', // capabitily
			'pjs4wp_instructions', // menu_slug
			'pjs4wp_instructions' // function
		);
	}	
} // rvg_pjs4wp_admin_menu()
add_action('admin_menu', 'rvg_pjs4wp_instructions');


/***********************************************************************************************
 *
 *	SHOW INSTRUCTIONS
 *
 *	Since: v1.1
 *
 ***********************************************************************************************/ 
function pjs4wp_instructions()
{
?>

<h1 style="margin-bottom: 30px;">ProcessingJS for WP - Instructions</h1>
<h3 style="margin-bottom: 30px;">With this plugin you can embed a <a href="http://processingjs.org" target="_blank">ProcessingJS</a> sketch in your post or page.</h3>
<p>You can use the shorttag <strong>[pjs4wp] ... [/pjs4wp]</strong> in two different ways:<br />
  <br />
  <strong>1) Put the actual ProcessingJS code directly in a post or page, for instance:</strong><br />
  <br />
  [pjs4wp]<br />
  void setup()<br />
  {<br />
  &nbsp;&nbsp;size(200, 200);<br />
  &nbsp;&nbsp;text("Hello world!", 50, 50);<br />
  }<br />
  [/pjs4wp]<br />
  <br />
  <strong>2) Use an existing ProcessingJS .pde sketch like this:</strong><br />
  <br />
  [pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#000"][/pjs4wp]<br />
  <br />
  <strong>IMPORTANT:</strong><br />
  RENAME YOUR <strong>.pde</strong> FILE TO <strong>.js</strong> BEFORE UPLOADING!<br />
  So in the example: rename your original <strong>my_sketch.pde</strong> file to <strong>my_sketch.js</strong>!<br />
  Some servers / browsers are not happy with the .pde extension, that's why...</p>
<h4>Plugin URL</h4>
<p><a href="http://cagewebdev.com/processingjs-for-wordpress" rel="nofollow" target="_blank"><strong>http://cagewebdev.com/processingjs-for-wordpress</strong></a></p>
<h4>Download URL</h4>
<p><a href="http://wordpress.org/plugins/processingjs-for-wordpress" rel="nofollow" target="_blank"><strong>http://wordpress.org/plugins/processingjs-for-wordpress</strong></a>
  <?php
} // pjs4wp_instructions()


/***********************************************************************************************
 *
 *	ADD THE PROCESSING CODE TO THE POST / PAGE
 *
 ***********************************************************************************************/ 
function pjs4wp_add_code($atts, $content)
{
	$output = '';
	
	if(!isset($atts['url']))
	{	// PROCESSING.JS CODE IS IN POST / PAGE
		$output .= '	
<script type="text/processing" data-processing-target="pjs4wpcanvas_'.get_the_ID().'">
'.strip_tags($content).'
</script>
<canvas id="pjs4wpcanvas_'.get_the_ID().'"></canvas>
		';
	}
	else
	{	// FROM EXISTING .pde SKETCH
		if(isset($atts['bordercolor'])) $bordercolor = 'style="border:solid 1px '.$atts['bordercolor'].';"';
		
		$output .= '
<canvas id="pjs4wp_'.get_the_ID().'" '.$bordercolor.' data-processing-sources="'.$atts['url'].'">
</canvas>
		';
	}
	return $output;
} // pjs4wp_add_code()
add_shortcode( "pjs4wp", "pjs4wp_add_code" );

remove_filter( 'the_content', 'wptexturize' );
add_filter( 'the_content', 'wptexturize', 99 );
?>
