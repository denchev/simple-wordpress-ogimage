=== Plugin Name ===
Contributors: antubis
Donate link: 
Tags: facebook, open graph
Requires at least: 2.7
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin that only displays Facebook's Open Graph image tag.

== Description ==

This plugin only task is to display the Facebook's Open Graph image tag without too much complication. 
The og:image is determined by these criterias (first that comes true will be used):

1. If the post has a featured image, this image will be used.
2. If the post has any image in its content, the first image will be used.
3. If there is a default image setup from the Settings section, this image will be used.

The plugin will aslo cache the image (if there is a permanent cache plugin installed installed i.e W3 Total Cache) so that no additional calls to the database will be made.

== Installation ==

1. Upload `simple-wordpress-ogimage` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set up a default image from Settings -> Simple Facebook OG image (this is optional)

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.1.0 =
Add preview box in admin edit post area

= 1.0.0 =
Initial plugin version release.

== Arbitrary section ==