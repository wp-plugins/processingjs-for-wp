<?php
/*
Plugin Name: ProcessingJS for WP
Plugin URI: http://cagewebdev.com/pjs4wp
Description: Directly write Processing.js code in your post / page or include an existing .pde sketch
Version: 1.0
Date: 04/23/2015
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
 *	LOAD THE SCRIPT(S)
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