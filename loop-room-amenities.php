<?php
global $hermes_options, $post_meta;
if (isset($hermes_options['hermes_rooms_meta_fields'])) { $room_labels = $hermes_options['hermes_rooms_meta_fields']; } // get the number of custom room meta fields
$room_meta = false;
$room_output = false;

if (isset($room_labels) && $room_labels > 0) {
		
		$i = 0; // will use a counter to reiterate through all amenities defined in Theme Options
		$x = 0; // will use a counter to determine how many amenities this room has

		foreach ($room_labels as $key => $value) {
			
			if ($value == '') {
				break; // skip all room amenities that have no names in Theme Options
			} 
			
			$i++;
			$field_name = 'hermes_room_' . $key;
			$room_meta = $post_meta[$field_name][0];
			
			// if current page has a custom field value for current amenity
			if ($room_meta) {
			
				if ($i % 2 == 0) {
					$tr_class = '<tr class="even">';
				} else {
					$tr_class = '<tr>';
				}
				
				$x++;
				$room_output .= $tr_class . ' 
						<td class="caption">'.$value.'</td>
						<td class="value">'.$room_meta.'</td>
					</tr>
					';

			}
			
		}
	} 

	// if current page has a custom field value for at least one amenity
	if (isset($x) && $x > 0) { ?>

<div class="room-section room-specifics">

	<h2 class="title-s title-upper"><?php _e('Room Specifications','hermes_textdomain'); ?></h2>

	<table border="0" cellspacing="0" cellpading="0" class="hermes-table hermes-room-specs">
		<tbody>
			<?php echo $room_output; ?>
		</tbody>
	</table>
	
	<div class="cleaner">&nbsp;</div>
		
</div><!-- .room-specifics -->

<?php } ?>