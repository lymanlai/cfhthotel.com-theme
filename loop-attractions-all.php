<?php 
global $hermes_options;

$child_of = $post->ID;

$loop = new WP_Query( array( 'post_parent' => $child_of, 'post_type' => 'page', 'nopaging' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );

if ($loop->have_posts()) {
	$i = 0;
	?>
	<table border="0" cellspacing="0" cellpading="0" class="hermes-table hermes-rates">
		<thead>
			<tr>
				<th><?php _e('Attraction','hermes_textdomain'); ?></th>
				<th><?php _e('Distance from Hotel','hermes_textdomain'); ?></th>
			</tr>
		</thead>
		<tbody>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); $i++; 
			$attraction_distance = get_post_meta($post->ID, 'hermes_attraction_distance', true);
			?>

			<tr<?php if ($i % 2 == 0) { echo ' class="even"'; } ?>>
				<td class="value"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hermes_textdomain' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></td>
				<td class="value"><?php if ($attraction_distance) { ?><?php echo $attraction_distance; ?><?php } ?></td>
			</tr>

			<?php endwhile; ?>

		</tbody>
	</table>

	<?php 
	} // if there are pages
wp_reset_query();
?>

<div class="cleaner">&nbsp;</div>