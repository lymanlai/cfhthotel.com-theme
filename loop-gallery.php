<?php 
global $hermes_options;

$args = array(
	'order'          => 'ASC',
	'orderby'          => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $post->ID,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => -1
);
$attachments = get_posts($args);

$i = 0;
$m = 0;

if (count($attachments) > 0) { ?>

<ul class="hermes-gallery-list">

<?php foreach ($attachments as $attachment) { 
	$i++; $m++;
	$image_data = wp_get_attachment_image_src( $attachment->ID, 'thumb-hermes-slideshow' ); 
	?>
	<li class="hermes-gallery-item gallery-item-i<?php echo $i; ?> gallery-item-m<?php echo $m; ?>">

		<div class="post-cover">
			<a href="<?php echo $image_data[0]; ?>" class="thickbox" title="<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>" rel="hermes-gallery"><?php echo wp_get_attachment_image( $attachment->ID, 'thumb-loop-gallery' ); ?></a>
		</div><!-- end .post-cover -->
		
		<div class="post-excerpt">
			<p><?php echo apply_filters( 'the_title', $attachment->post_title ); ?></p>
		</div><!-- end .post-excerpt -->
		<div class="cleaner">&nbsp;</div>
		
	</li><!-- end .hermes-gallery-item -->
<?php 
	if ($i == 3) { $i = 0; } // reset the counter to zero
	if ($m == 4) { $m = 0; } // reset the counter to zero
} // foreach ?>

</ul><!-- end .hermes-gallery-list -->

<div class="cleaner">&nbsp;</div>

<?php 
wp_reset_query();
} // if there are attachments

	$parent_id = $post->post_parent;
	
	if ($parent_id == 0) {
		$child_of = $post->ID;
	} // if no parent
	
	if (isset($child_of)) {

		$children_pages = get_pages( array( 'child_of' => $child_of, 'parent' => $child_of, 'sort_column' => 'menu_order', 'sort_order' => 'ASC' ) );
		
		if (count($children_pages) > 0) {
			
			foreach ($children_pages as $page) {
				
				echo'<h2 class="title-page title-m title-center"><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a></h2>';

				$args = array(
					'order'          => 'ASC',
					'orderby'          => 'menu_order',
					'post_type'      => 'attachment',
					'post_parent'    => $page->ID,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => -1
				);
				$attachments = get_posts($args);
				
				$i = 0;
				$m = 0;

				if (count($attachments) > 0) { ?>
				
				<ul class="hermes-gallery-list">
				
				<?php foreach ($attachments as $attachment) { 
					$i++; $m++;
					$image_data = wp_get_attachment_image_src( $attachment->ID, 'thumb-hermes-slideshow' ); 
					?>
					<li class="hermes-gallery-item gallery-item-i<?php echo $i; ?> gallery-item-m<?php echo $m; ?>">
				
						<div class="post-cover">
							<a href="<?php echo $image_data[0]; ?>" class="thickbox" title="<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>" rel="hermes-gallery"><?php echo wp_get_attachment_image( $attachment->ID, 'thumb-loop-gallery' ); ?></a>
						</div><!-- end .post-cover -->
						
						<div class="post-excerpt">
							<p><?php echo apply_filters( 'the_title', $attachment->post_title ); ?></p>
						</div><!-- end .post-excerpt -->
						<div class="cleaner">&nbsp;</div>
						
					</li><!-- end .hermes-gallery-item -->
				<?php 
					if ($i == 3) { $i = 0; } // reset the counter to zero
					if ($m == 4) { $m = 0; } // reset the counter to zero
				} // foreach ?>
				
				</ul><!-- end .hermes-gallery-list -->
				
				<div class="cleaner">&nbsp;</div>
				
				<?php 
				wp_reset_query();
				} // if there are attachments
			
			} // foreach sub-page of the gallery
			
		}
	
		wp_reset_query();
	
	}
	
?>