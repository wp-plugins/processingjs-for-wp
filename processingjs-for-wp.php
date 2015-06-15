<?php
/*
Plugin Name: ProcessingJS for WP
Plugin URI: http://cagewebdev.com/pjs4wp
Description: Directly write Processing.js code in your post / page or include an existing .pde sketch
Version: 1.2
Date: 06/15/2015
Author: Rolf van Gelder
Author URI: http://cagewebdev.com/
License: GPL2
*/

/***********************************************************************************************
 *
 *	USAGE:
 *
 *	You can use the shorttag [pjs4wp] ... [/pjs4wp] in two different ways:
 *
 *	1) Put the actual ProcessingJS code directly in a post or page, for instance:
 *
 *	[pjs4wp]
 *	void setup()
 *	{
 *		size(200, 200);
 *		text("Hello world!", 50, 50);
 * 	}
 * 	[/pjs4wp]
 *
 *	2) Use an existing ProcessingJS .pde sketch like this:
 *
 *	[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#000"][/pjs4wp]
 ***********************************************************************************************/

/***********************************************************************************************
 *
 * 	MAIN CLASS
 *
 ***********************************************************************************************/ 
class Pjs4wp
{	
	/*******************************************************************************************
	 *
	 * 	CONSTRUCTOR
	 *
	 *******************************************************************************************/
	function __construct()
	{
		if($this->pjs4wp_is_fontend_page())
		{	// FRONTEND
			add_action('init', array($this, 'pjs4wp_load_scripts'));
			// ADD SHORTCODE
			add_shortcode('pjs4wp', array($this, 'pjs4wp_add_code'));
			// NO SMART QUOTES AND SUCH...		
			remove_filter('the_content', 'wptexturize');
			add_filter('the_content', 'wptexturize', 99);			
		}
		else
		{	// BACKEND
			// ADD A LINK TO THE INSTRUCTIONS PAGE ON THE PLUGINS MAIN PAGE
			add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'pjs4wp_settings_link'));
			// ADD A (HIDDEN) LINK TO THE ADMIN MENU (to create the http://.../wp-admin/options-general.php?page=pjs4wp_instructions page)
			add_action('admin_menu', array($this, 'pjs4wp_instructions_link'));
		}
	} // __construct()


	/*******************************************************************************************
	 *
	 *	LOAD THE SCRIPTS
	 *
	 *******************************************************************************************/ 
	function pjs4wp_load_scripts()
	{
		wp_deregister_script('pjs4wp');
		wp_enqueue_script('pjs4wp', plugins_url('/js/processing.min.js', __FILE__ ), false, '1.4.8');
	} // pjs4wp_load_scripts()


	/*******************************************************************************************
	 *
	 *	SHOW A LINK TO THE INSTRUCTIONS PAGE ON THE MAIN PLUGINS PAGE
	 *
	 *******************************************************************************************/ 
	function pjs4wp_settings_link($links)
	{ 
	  array_unshift($links, '<a href="options-general.php?page=pjs4wp_instructions">'.__('Instructions', 'pjs4wp').'</a>'); 
	  return $links;
	} // pjs4wp_settings_link()
	

	/*******************************************************************************************
	 *
	 * 	IS THIS A FRONTEND PAGE?
	 *
	 *******************************************************************************************/
	function pjs4wp_is_fontend_page()
	{
		if (isset($GLOBALS['pagenow']))
			return !is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
		else
			return !is_admin();
	} // pjs4wp_is_regular_page()


	/*******************************************************************************************
	 *
	 *	ADD THE INSTRUCTIONS TO THE SETTINGS MENU
	 *
	 *******************************************************************************************/ 
	function pjs4wp_instructions_link()
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
	} // pjs4wp_instructions_link()


	/*******************************************************************************************
	 *
	 *	ADD THE PROCESSING CODE TO THE POST / PAGE
	 *
	 *******************************************************************************************/ 
	function pjs4wp_add_code($atts, $content)
	{
		if(!isset($atts['url']))
		{	// PROCESSING.JS CODE IS IN POST / PAGE
			$output = '	
<script type="text/processing" data-processing-target="pjs4wpcanvas_'.get_the_ID().'">
'.strip_tags($content).'
</script>
<canvas id="pjs4wpcanvas_'.get_the_ID().'"></canvas>
			';
		}
		else
		{	// FROM EXISTING .pde SKETCH
			if(isset($atts['bordercolor'])) $bordercolor = 'style="border:solid 1px '.$atts['bordercolor'].';"';
			
			$output = '
<canvas id="pjs4wp_'.get_the_ID().'" '.$bordercolor.' data-processing-sources="'.$atts['url'].'">
</canvas>
			';
		}
		return $output;
	} // pjs4wp_add_code()
} // Pjs4wp


/***********************************************************************************************
 *
 * 	CREATE INSTANCE
 *
 ***********************************************************************************************/
global $pjs4wp_class;
$pjs4wp_class = new Pjs4wp;


/*******************************************************************************************
 *
 *	INSTRUCTIONS PAGE
 *
 *******************************************************************************************/ 
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
<h4><a href="http://cagewebdev.com/processingjs-for-wordpress" rel="nofollow" target="_blank">Plugin URL</a> - <a href="http://wordpress.org/plugins/processingjs-for-wordpress" rel="nofollow" target="_blank">Download URL</a> - <a href="http://cagewebdev.com/index.php/donations-pjs4wp/" rel="nofollow" target="_blank">Donation URL</a></h4>
<?php
} // pjs4wp_instructions()
?>
