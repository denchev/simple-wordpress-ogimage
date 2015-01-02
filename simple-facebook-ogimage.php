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

			$og_image 	= null;
			$post_id 	= get_the_ID();
			$image 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

			// There is a featured image
			if($image !== false) {

				$og_image = $image[0];

			} else {

				$post = get_post($post_id);

				// Get all images from within post content
				preg_match_all('/<img(.*?)src="(?P<src>.*?)"([^>]+)>/', $post->post_content, $matches);

				if(isset($matches['src'][0])) {
					$og_image = $matches['src'][0];
				}

			}

			if($og_image != null) {

				echo '<meta property="og:image" content="' . $og_image . '">';
			}
		}
	}
}

add_action('wp_head', 'sfogi_wp_head');