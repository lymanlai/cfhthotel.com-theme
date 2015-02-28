<?php 
global $hermes_options;

$loop = new WP_Query( array( 'post_type' => 'testimonial', 'nopaging' => 1 ) );

if ($loop->have_posts()) {
	$i = 0;
	?>

	<ul class="hermes-testimonials">
		
		<?php while ( $loop->have_posts() ) : $loop->the_post(); $i++; 

		$testimonial_author = get_post_meta($post->ID, 'hermes_testimonial_author', true);
		$testimonial_country = get_post_meta($post->ID, 'hermes_testimonial_country', true);
		$testimonial_date = get_post_meta($post->ID, 'hermes_testimonial_date', true);
		$testimonial_url = get_post_meta($post->ID, 'hermes_testimonial_url', true);

		?>
		<li class="hermes-testimonial">
			<figure>
				
				<blockquote<?php if ($testimonial_url) { echo ' cite="'.$testimonial_url.'"'; } ?> class="hermes-testimonial-quote">
					<div class="post-excerpt">
						<h2 class="title-testimonial title-s"><?php the_title(); ?></h2>
						<?php the_content(); ?>
					</div><!-- .post-excerpt -->
					<div class="cleaner">&nbsp;</div>
				</blockquote><!-- end .hermes-testimonial -->

				<figcaption class="hermes-author"><?php if ($testimonial_author) { echo "<strong>$testimonial_author</strong>, "; } ?>
				<?php if ($testimonial_country) { echo "$testimonial_country"; } ?>
				<?php if ($testimonial_date) { echo " &mdash; $testimonial_date"; } ?></figcaption>

			</figure>
		</li><!-- end .hermes-testimonial -->
		<?php endwhile; ?>
	
	</ul><!-- end .hermes-testimonials -->
	<div class="cleaner">&nbsp;</div>
	<?php 
	} // if there are pages
wp_reset_query();
?>