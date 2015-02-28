<?php 
global $hermes_options;
if (isset($hermes_options['hermes_rooms_prices_fields'])) { $room_prices = $hermes_options['hermes_rooms_prices_fields']; } // get the number of custom room meta fields
if (isset($room_prices)) { $room_prices_count = count($room_prices); }
$room_meta = false;
$output_rooms = false;
$child_of = $post->ID;

$loop = new WP_Query( array( 'post_parent' => $child_of, 'parent' => $child_of, 'post_type' => 'page', 'nopaging' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );

	if (isset($room_prices_count)) {
		
		$y = 0; // will use a counter to reiterate through all prices defined in Theme Options
		$x = 0; // will use a counter to determine how many prices this room has

		foreach ($room_prices as $key => $value) {
			
			if ($value == '') {
				break; // skip all pricing plans that have no names in Theme Options
			} 

			$output_rooms .= '
			<tr';
			if ($i % 2 == 0) { 
				$output_rooms .= ' class="even"'; 
			}
			$output_rooms .= '>';

			$y++;
			$field_name = 'hermes_room_price_' . $key;

			$output_rooms .= '<td class="caption">'. $value .'</td>';
			
			rewind_posts($loop);
			
			while ( $loop->have_posts() ) : $loop->the_post();
			
				$room_meta = get_post_custom($post->ID);
				$rate = $room_meta[$field_name][0];
			
				// if current page has a custom field value for current amenity
				// if ($rate) {
				
					$x++;
					$output_rooms .= '<td class="value">'.$rate.'</td>';
	
				// }

			endwhile;

		}
	} 
	
	$output_rooms .='</tr>';
	?>
	
<?php 
wp_reset_query();
?>

<table border="0" cellspacing="0" cellpading="0" class="hermes-table hermes-rates">
	<thead>
		<tr>
			<th class="caption"><?php _e('Room Price','hermes_textdomain');?></th>

			<?php
			rewind_posts($loop);
			if ($loop->have_posts()) {
			$i = 0;
			while ( $loop->have_posts() ) : $loop->the_post(); $i++; ?>
			<th><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></th>
			<?php
			endwhile;
			} // endif
			?>

		</tr>
	</thead>
	<tbody>
		<?php echo $output_rooms; ?>
	</tbody>
</table>