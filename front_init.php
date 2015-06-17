<?php

/*--------------------------------------------------*/
/* Simple Background Manager > frontend load style
/*--------------------------------------------------*/

function vuzzu_sbm_load_background_manager_style() {

	// In case post type is not supported break the hook
	$supported_post_types = get_theme_support( 'simple_background_manager_support_types' );
	if( !is_front_page() && !is_home() && !is_singular( $supported_post_types[0] ) ) return;

	global $wp_query;
	$postId = $wp_query->get_queried_object_id();

	$background_manager_options = get_post_meta($postId, 'sbm_background_manager', true);

	$bg_color = (isset($background_manager_options['color'])) ? $background_manager_options['color'] : null;
	$bg_img = (isset($background_manager_options['img'])) ? $background_manager_options['img'] : null;
	$bg_img_repeat  = (isset($background_manager_options['img_repeat'])) ? $background_manager_options['img_repeat'] : null;

	?>

		<style type="text/css">

		body {
			<?php if($bg_color) echo "background-color: {$bg_color} !important;"; ?>
			<?php if($bg_img) echo "background-image: url({$bg_img}) !important;"; ?>
			<?php echo ($bg_img_repeat) ? "background-repeat: {$bg_img_repeat} !important;" : "background-repeat:no-repeat;"; ?>
		}

		</style>

	<?php

}
