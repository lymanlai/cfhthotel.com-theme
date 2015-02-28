<?php 
global $hermes_options;
if (isset($hermes_options['hermes_rooms_prices_fields'])) { $room_prices = $hermes_options['hermes_rooms_prices_fields']; } // get the number of custom room meta fields
if (isset($room_prices)) { $room_prices_count = count($room_prices); }
$room_meta = false;
$output_rooms = false;
$child_of = $post->ID;

$loop = new WP_Query( array( 'post_parent' => $child_of, 'parent' => $child_of, 'post_type' => 'page', 'nopaging' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );

if ($loop->have_posts()) {
	$i = 0;
	while ( $loop->have_posts() ) : $loop->the_post(); $i++; 

		$room_meta = get_post_custom($post->ID);
		
		$output_rooms .= '
		<tr';
		if ($i % 2 == 0) { 
			$output_rooms .= ' class="even"'; 
		}
		$output_rooms .= '>
			<td class="caption"><a href="' . get_permalink() . '">'. get_the_title() .'</a></td>';
			
			if (isset($room_prices)) { reset($room_prices); }
			
			if (isset($room_prices_count)) {
				
				$y = 0; // will use a counter to reiterate through all prices defined in Theme Options
				$x = 0; // will use a counter to determine how many prices this room has
		
				foreach ($room_prices as $key => $value) {
					
					if ($value == '') {
						break; // skip all pricing plans that have no names in Theme Options
					} 
					
					$y++;
					$field_name = 'hermes_room_price_' . $key;
					$rate = $room_meta[$field_name][0];
					
					// if current page has a custom field value for current amenity
					// if ($rate) {
					
						$x++;
						$output_rooms .= '<td class="value">'.$rate.'</td>';
		
					// } 
					
				}
			} 
			
			$output_rooms .='</tr>';
		
	endwhile; ?>
	
<?php 
} // if there are pages
wp_reset_query();
?>

<table border="0" cellspacing="0" cellpading="0" class="hermes-table hermes-rates">
	<thead>
		<tr>
			<th class="caption"><?php _e('Room Type','hermes_textdomain');?></th>

			<?php
			if (isset($room_prices)) {
				foreach ($room_prices as $key => $value) { 
					if ($value == '') { break; }
					$field_name = 'hermes_room_price_' . $key;
					?>
					<th><?php echo $value; ?></th>
				<?php }
			} ?>

		</tr>
	</thead>
	<tbody>
		<?php echo $output_rooms; ?>
	</tbody>
</table>