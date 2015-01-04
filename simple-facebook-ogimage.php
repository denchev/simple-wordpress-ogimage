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

			// No OG ... still? Well let see if there is something in the default section
			if($og_image === null) {

				$option = get_option('sfogi_default_image');

				if(!empty($option)) {
					$og_image = $option;
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

if( ! function_exists( 'sfogi_admin_menu' ) ) {

	function sfogi_admin_menu() {

		add_submenu_page('options-general.php', __('Simple Facebook OG image', 'sfogi'), __('Simple Facebook OG image', 'sfogi'), 'manage_options', 'sfogi', 'sfogi_options_page');
	}
}

function sfogi_options_page() {
	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'sfogi' ); ?>
    	<?php do_settings_sections( 'sfogi' ); ?>

    	<script>
		jQuery(function() {

			jQuery('#upload_image_button').click(function() {
				formfield = jQuery('#upload_image').attr('name');
				tb_show('', 'media-upload.php?type=image&TB_iframe=true');
				return false;
			});

			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				jQuery('#upload_image').val(imgurl);
				tb_remove();
			}

		});
		</script>


    	<table class="form-table">
    		<tr valign="top">
				<td><?php echo __('Default image', 'sfogi') ?></td>
				<td><label for="upload_image">
					<input id="upload_image" type="text" size="36" name="sfogi_default_image" value="<?php echo esc_attr(get_option('sfogi_default_image')) ?>" />
					<input id="upload_image_button" type="button" value="Upload Image" />
					<br /><?php echo __( 'Enter an URL or upload an image for the default image.', 'sfogi') ?>
					</label>
				</td>
			</tr>
    	</table>
		<?php submit_button() ?>
	</form>
	<?php
}

function sfogi_register_settings() {
	register_setting('sfogi', 'sfogi_default_image');
}

function sfogi_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery');
}

function sfogi_admin_styles() {
	wp_enqueue_style('thickbox');
}

add_action('wp_head', 'sfogi_wp_head');

if( is_admin() ) {
	add_action('admin_menu', 'sfogi_admin_menu');
	add_action('admin_init', 'sfogi_register_settings');
	add_action('admin_print_scripts', 'sfogi_admin_scripts');
	add_action('admin_print_styles', 'sfogi_admin_styles');
}