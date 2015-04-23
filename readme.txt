=== ProcessingJS for WordPress ===
Contributors: CAGE Web Design | Rolf van Gelder
Donate link: http://cagewebdev.com/index.php/optimize-database-after-deleting-revisions-donations/
Plugin Name: PJS4WP (ProcessingJS for WordPress)
Plugin URI: http://cagewebdev.com/processingjs-for-wordpress
Tags: processing, processing.org, processingjs, html5, javascript, jQuery, pjs4wp
Author URI: http://rvg.cage.nl
Author: CAGE Web Design | Rolf van Gelder, Eindhoven, The Netherlands
Requires at least: 2.8
Tested up to: 4.2
Stable tag: 1.0
Version: 1.0
License: GPLv2 or later

== Description ==
= This plugin can add a ProcessingJS sketch to your post or page =
You can use the shorttag (<strong>[pjs4wp]...[/pjs4wp]</strong>) in two different ways:<br />
<br />
1) Put the actual ProcessingJS code in a post or page, for instance:<br />
[pjs4wp]<br />
void setup()<br />
{<br />
	size(200, 200);<br />
 	text("Hello world!", 50, 50);<br />
}<br />
[/pjs4wp]<br />
<br />
2) Use an existing ProcessingJS .pde sketch like this:<br />
[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#888"][/pjs4wp]<br />
<br />
<strong>IMPORTANT:</strong><br />
RENAME YOUR .pde FILE TO .js BEFORE UPLOADING!<br />
So in the example: rename your original my_sketch.pde file to my_sketch.js!<br />
Some servers / browsers are not happy with the .pde extension, that's why...

= Example =
See a live example here:<br />
http://rvg.cage.nl/rvglife-internet-2014/

= Author =
CAGE Web Design | Rolf van Gelder, Eindhoven, The Netherlands - http://cagewebdev.com - http://rvg.cage.nl

= Plugin URL =
http://cagewebdev.com/processingjs-for-wordpress

= Download URL =
http://wordpress.org/plugins/processingjs-for-wordpress

= Disclaimer =
NO WARRANTY, USE IT AT YOUR OWN RISK!

= Plugins by CAGE Web Design | Rolf van Gelder =
WordPress plugins created by CAGE Web Design | Rolf van Gelder<br />
http://cagewebdev.com/index.php/wordpress-plugins/

== Installation ==

* Upload the Plugin to the '/wp-content/plugins/' directory
* Activate the plugin in the WP Admin Panel &raquo; Plugins 

== Frequently asked questions ==

= How can I change the settings of this plugin? =
* This plugins doesn't need any settings

= How do I use this plugin? =

This plugin uses the <strong>[pjs4wp]</strong> shorttag<br />
<br />
You can use the shorttag in two different ways<br />
<br />
1) Put the actual ProcessingJS code in a post or page, for instance:<br />
[pjs4wp]<br />
void setup()<br />
{<br />
	size(200, 200);<br />
 	text("Hello world!", 50, 50);<br />
}<br />
[/pjs4wp]<br />
<br />
2) Use an existing ProcessingJS .pde sketch like this<br />
[pjs4wp url="/wp-content/uploads/my_sketch.js" bordercolor="#888"][/pjs4wp]<br />
IMPORTANT:<br />
RENAME YOUR <strong>.pde</strong> FILE TO <strong>.js</strong> BEFORE UPLOADING!<br />
So in the example: rename your original <strong>my_sketch.pde</strong> file to <strong>my_sketch.js</strong>!<br />
Some servers / browsers are not happy with the .pde extension, that's why...

== Changelog ==
= v1.0 [04/22/2015] =
* Initial release
