<?php 

while (have_posts()) : the_post();
$post_meta = get_post_custom($post->ID);
endwhile;

// preparing layout
if (isset($post_meta['hermes_page_layout'][0])) {
	
	$page_layout = $post_meta['hermes_page_layout'][0];

	if ($page_layout == 'Small Content Box') {
		$page_class = 'layout-normal';
		$slide_class = 'hermes-gallery-normal';
	} elseif ($page_layout == 'Medium Content Box') {
		$page_class = 'layout-half';
		$slide_class = 'hermes-gallery-small';
	} elseif ($page_layout == 'Large Content Box') {
		$page_class = 'layout-full';
		$slide_class = 'disabled';
	} elseif ($page_layout == 'No Content') {
		$page_class = 'layout-nocontent';
		$slide_class = 'hermes-gallery-full';
	}
	
} else {
	$page_class = 'layout-normal';
	$slide_class = 'hermes-gallery-normal';
}

// preparing slideshow options
$display_slideshow = $post_meta['hermes_post_display_slideshow'][0];
$slideshow_autoplay = $post_meta['hermes_post_display_slideshow_autoplay'][0];
$slideshow_speed = $post_meta['hermes_post_display_slideshow_speed'][0];
if (!$slideshow_speed) {
	$slideshow_speed = 5000;
}
?>