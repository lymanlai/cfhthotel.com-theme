<?php 
global $hermes_options, $page_class, $slide_class;

$slideshow_autoplay = $hermes_options['hermes_gallery_autoplay'];
$slideshow_speed = $hermes_options['hermes_gallery_autoplay_speed'];

// If it is a post or page, retrieve all attached images to it.

if ( $post->ID ) {

	$args = array(
		'order'          => 'ASC',
		'orderby'          => 'menu_order',
		'post_parent'    => $post->ID,
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => null,
		'numberposts'    => -1
	);
	
	$attachments = get_posts($args);
	$attachments_num = count($attachments);
	
	if ($attachments_num == 0) {
	
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured_image_id = get_post_thumbnail_id($post->ID);

			unset($attachments,$attachments_num);
			
			$args = array(
				'p'    => $featured_image_id,
				'post_type'      => 'attachment',
				'post_mime_type' => 'image'
			);
			
			$attachments = get_posts($args);
			$attachments_num = count($attachments);

		}
	}

} 

$i = 0;
if ($attachments_num > 0) { ?>

<div class="hermes-gallery-wrapper <?php echo $slide_class; ?>">
	
	<div id="hermes-gallery">
	
		<?php
			foreach ($attachments as $attachment) { 
			$large_image_url = wp_get_attachment_image_src( $attachment->ID, 'thumb-hermes-slideshow');
			?>
				<img src="<?php echo $large_image_url[0]; ?>" alt="<?php echo $attachment->post_title; ?>" width="1000" height="1000" alt="" class="slide-img" />
			<?php 
			} // foreach
		?>
		
	</div><!-- #hermes-gallery -->
	
	<img id="cycle-loader" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" alt="" />
	
	<?php if ($attachments_num > 1) { ?>
	<div class="hermes-slideshow-arrows">
		<a href="#" id="hermes-arrow-left">
			<img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" alt="Slide Left" width="63" height="115" class="hermes-slider-arrow hermes-arrow-left" />
		</a>
		<a href="#" id="hermes-arrow-right">
			<img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" alt="Slide Right" width="63" height="115" class="hermes-slider-arrow hermes-arrow-right" />
		</a>
	</div>
	<?php } ?>
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
	
			jQuery('#hermes-gallery').maximage({
				cycleOptions: {
					fx: 'fade',
					// Speed has to match the speed for CSS transitions
					speed: 1000, 
					<?php if ($slideshow_autoplay == 1 && $attachments_num > 1) { ?>
					timeout: <?php echo $slideshow_speed; ?>,
					<?php } else { ?>
					timeout: 0,
					<?php } ?>
					prev: '#hermes-arrow-left',
					next: '#hermes-arrow-right',
					pause: 1
				},
				onFirstImageLoaded: function(){
					jQuery('#cycle-loader').hide();
					jQuery('#hermes-gallery').fadeIn('fast');
				},
				fillElement: '#hermes-gallery'
			});
	
		});
	</script>

</div><!-- .hermes-gallery-wrapper -->

<?php } ?>