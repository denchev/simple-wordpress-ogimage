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
			$cache_key	= md5( 'sfogi_' . $post_id );
			$cache_group= 'sfogi';

			$cached_image = wp_cache_get($cache_key, $cache_group);

			if($cached_image !== false) {

				$og_image = $cached_image;

			}

			// No OG image? Get it from featured image
			if($og_image == null) {

				$image 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

				// There is a featured image
			 	if($image !== false) {

					$og_image = $image[0];
				}

			} 

			// No OG image still? Get it from post content
			if($og_image === null) {

				$post = get_post($post_id);

				// Get all images from within post content
				preg_match_all('/<img(.*?)src="(?P<src>.*?)"([^>]+)>/', $post->post_content, $matches);

				if(isset($matches['src'][0])) {
					$og_image = $matches['src'][0];
				}

			}

			// Found an image? Good. Display it.
			if($og_image !== null) {

				// Cache the image source but only if the source is not retrieved from cache. No point of overwriting the same source.
				if($cached_image === false) {

					$result = wp_cache_set($cache_key, $og_image, $cache_group);
				}

				echo '<meta property="og:image" content="' . $og_image . '">';
			}
		}
	}
}

add_action('wp_head', 'sfogi_wp_head');