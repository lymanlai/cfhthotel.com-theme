<?php 
global $hermes_options;

$slideshow_autoplay = $hermes_options['hermes_gallery_autoplay'];
$slideshow_speed = $hermes_options['hermes_gallery_autoplay_speed'];

$args = array(
	'order'          => 'ASC',
	'orderby'          => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $hermes_options['hermes_gallery_page'],
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => $hermes_options['hermes_gallery_page_num']
);

$attachments = get_posts($args);
$attachments_num = count($attachments);

$i = 0;
if ($attachments_num > 0) { ?>

<!-- Maximage / Cycle -->
<div class="hermes-gallery-wrapper hermes-gallery-full">
	
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

<?php } // if there are attachments
elseif ($attachments_num == 0) { ?>
<div id="hermes-gallery">
	<p class="hermes-notice">Please choose a page containing photos for the Homepage Slider in <a href="<?php echo get_admin_url(); ?>nav-menus.php">HermesThemes > Theme Options</a> page.<br />For more information please <a href="http://www.hermesthemes.com/documentation/belafonte/">read the documentation</a></p>
</div><!-- end #hermes-gallery -->
<?php } ?>
