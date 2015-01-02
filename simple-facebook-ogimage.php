<?php

/**
 * Plugin Name: Simple Facebook OG image
 * Plugin URI: 
 * Description: A very simple plugin to enable og:image tag only when you share to Facebook
 * Version: 1.0.0
 * Author: Marush Denchev
 * Author URI: http://www.htmlpet.com/
 * License: GPLv2
 */

if( ! function_exists( 'sfogi_wp_head' ) ) {
	function sfogi_wp_head() {
		if(is_single() ) {
			$post_id = get_the_ID();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'single-post-thumbnail' );
			echo '<meta property="og:image" content="' . $image[0] . '">';
		}
	}
}

add_action('wp_head', 'sfogi_wp_head');