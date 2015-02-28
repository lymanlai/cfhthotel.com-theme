<?php
 
/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

add_action('admin_menu', 'hermes_options_box');

function hermes_options_box() {
	
	add_meta_box('hermes_post_template', 'Post Options', 'hermes_post_options', 'post', 'side', 'high');
	add_meta_box('hermes_post_template', 'Post Options', 'hermes_post_options', 'event', 'side', 'high');
	add_meta_box('hermes_post_template', 'Page Options', 'hermes_post_options', 'page', 'side', 'high');

	$template_file = '';
	
	// add_meta_box('hermes_post_template', 'Post Options', 'hermes_post_options', 'post', 'side', 'high');
	add_meta_box('hermes_testimonial_options', 'Testimonial Options', 'hermes_testimonial_options', 'testimonial', 'side', 'high');
	
	// get the id of current post/page
	if (isset($_GET['post']) || isset($_GET['post']) || isset($_POST['post_ID'])) {
		$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
	}

	// get the template file used (if a page)
	if (isset($post_id)) {
		$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
	}
	
	// if we are using the attraction.php page template, add additional meta boxes
	if ( isset($template_file) && ($template_file == 'page-templates/attraction.php') ) {
		add_meta_box('hermes_attraction_template', 'Attraction Options', 'hermes_attraction_options', 'page', 'side', 'high');
	}

	// if we are using the booking.php page template, add additional meta boxes
	if ( isset($template_file) && ($template_file == 'page-templates/booking.php') ) {
		add_meta_box('hermes_booking_template', 'Booking Form Options', 'hermes_booking_options', 'page', 'side', 'high');
	}

	// if we are using the events.php page template, add additional meta boxes
	if ( isset($template_file) && ($template_file == 'page-templates/events.php') ) {
		add_meta_box('hermes_events_template', 'Events Options', 'hermes_events_options', 'page', 'side', 'high');
	}

	// if we are using the room.php page template, add additional meta boxes
	if ( $template_file == 'page-templates/room.php' ) {
		add_meta_box('hermes_room_template', 'Room Options', 'hermes_room_options', 'page', 'side', 'high');
	}

	// if we are using the rooms.php page template, add additional meta boxes
	if ( $template_file == 'page-templates/rooms.php' ) {
		add_meta_box('hermes_rooms_template', 'Template Options', 'hermes_rooms_options', 'page', 'side', 'high');
	}
	
}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
	
	$hermes_options = hermes_get_global_options(); // get all options saved in Theme Options
	
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
		$postID = $parent_id;
	}
	
	if ($_POST['save'] || $_POST['publish']) {
		
		update_custom_meta($postID, $_POST['hermes_page_layout'], 'hermes_page_layout');
		
		update_custom_meta($postID, $_POST['hermes_post_display_featured'], 'hermes_post_display_featured');
		update_custom_meta($postID, $_POST['hermes_post_display_slideshow'], 'hermes_post_display_slideshow');
		update_custom_meta($postID, $_POST['hermes_post_display_slideshow_autoplay'], 'hermes_post_display_slideshow_autoplay');
		update_custom_meta($postID, $_POST['hermes_post_display_slideshow_speed'], 'hermes_post_display_slideshow_speed');
	}
	if ($_POST['saveAttraction']) {
		update_custom_meta($postID, $_POST['hermes_attraction_distance'], 'hermes_attraction_distance');
	}
	if ($_POST['saveBooking']) {
		update_custom_meta($postID, $_POST['hermes_booking_email'], 'hermes_booking_email');
	}
	if ($_POST['saveEvents']) {
		update_custom_meta($postID, $_POST['hermes_events_type'], 'hermes_events_type');
	}
	if ($_POST['saveRooms']) {
		update_custom_meta($postID, $_POST['hermes_rooms_template'], 'hermes_rooms_template');
		update_custom_meta($postID, $_POST['hermes_rooms_layout'], 'hermes_rooms_layout');
	}
	if ($_POST['saveRoom']) {
		$room_labels = $hermes_options['hermes_rooms_meta_fields']; // get the number of custom room meta fields
		
		foreach ($room_labels as $key => $value) {
			if ($value == '') {
				break;
			}
			$field_name = 'hermes_room_' . $key;
			update_custom_meta($postID, $_POST[$field_name], $field_name);
		}

		$room_prices = $hermes_options['hermes_rooms_prices_fields']; // get the number of custom room meta fields
		
		foreach ($room_prices as $key => $value) {
			if ($value == '') {
				break;
			}
			$field_name = 'hermes_room_price_' . $key;
			update_custom_meta($postID, $_POST[$field_name], $field_name);
		}

	}
	if ($_POST['saveTestimonial']) {
		update_custom_meta($postID, $_POST['hermes_testimonial_author'], 'hermes_testimonial_author');
		update_custom_meta($postID, $_POST['hermes_testimonial_country'], 'hermes_testimonial_country');
		update_custom_meta($postID, $_POST['hermes_testimonial_date'], 'hermes_testimonial_date');
		update_custom_meta($postID, $_POST['hermes_testimonial_url'], 'hermes_testimonial_url');
	}

}

function update_custom_meta($postID, $newvalue, $field_name) {
	// To create new meta
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		// or to update existing meta
		update_post_meta($postID, $field_name, $newvalue);
	}
	
}

// Regular Posts Options
function hermes_post_options() {
	global $post;
	?>
	<fieldset>
		<div>
			
			<p>
 				<label for="">Page Layout:</label><br />
				<select name="hermes_page_layout" id="hermes_page_layout">
					<option<?php selected( get_post_meta($post->ID, 'hermes_page_layout', true), 'Small Content Box' ); ?>>Small Content Box</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_page_layout', true), 'Medium Content Box' ); ?>>Medium Content Box</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_page_layout', true), 'Large Content Box' ); ?>>Large Content Box</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_page_layout', true), 'No Content' ); ?>>No Content</option>
				</select>
				<p><span class="description">The Photo Slideshow will not be displayed if you choose the "Large Content Box" layout.</span></p>
			</p>
			
			<p>
 				<label for="">Display attached images as a slideshow:</label><br />
				<select name="hermes_post_display_featured" id="hermes_post_display_featured">
					<option<?php selected( get_post_meta($post->ID, 'hermes_post_display_featured', true), 'Yes' ); ?>>Yes</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_post_display_featured', true), 'No' ); ?>>No</option>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" id="hermes_post_display_slideshow_autoplay" name="hermes_post_display_slideshow_autoplay" value="on"<?php if (get_post_meta($post->ID, 'hermes_post_display_slideshow_autoplay', true) == 'on' ) { echo ' checked="checked"'; } ?> />
 				<label for="hermes_post_display_slideshow_autoplay">Enable slideshow autoplay.</label><br />
			</p>
			<p>
				<label for="hermes_post_display_slideshow_speed"><?php _e('Slideshow autoplay speed in miliseconds', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_post_display_slideshow_speed" id="hermes_post_display_slideshow_speed" value="<?php echo get_post_meta($post->ID, 'hermes_post_display_slideshow_speed', true); ?>"><br />
				<span class="description">1 second = 1000 miliseconds.</span>
			</p>
  		</div>
	</fieldset>
	<?php
}

// Attraction Page Template Options
function hermes_attraction_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveAttraction" id="saveAttraction" value="1" />
		<div>
			<p>
				<label for="hermes_attraction_distance"><?php _e('Distance to Attraction', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_attraction_distance" id="hermes_attraction_distance" value="<?php echo get_post_meta($post->ID, 'hermes_attraction_distance', true); ?>"><br />
			</p>
			
  		</div>
	</fieldset>
	<?php
	}

// Booking Page Template Options
function hermes_booking_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveBooking" id="saveBooking" value="1" />
		<div>
			<p>
				<label for="hermes_booking_email"><?php _e('Send form submissions to this email', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_booking_email" id="hermes_booking_email" value="<?php echo get_post_meta($post->ID, 'hermes_booking_email', true); ?>"><br />
				<span class="description"><?php _e('If left blank, submissions will be sent to', 'hermes_textdomain'); ?>: <strong><?php echo get_option('admin_email'); ?></strong>.</span>
			</p>
			
  		</div>
	</fieldset>
	<?php
	}

// Regular Posts Options
function hermes_events_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveEvents" id="saveEvents" value="1" />
		<div>
			
			<p>
 				<label for=""><?php _e('What events to display', 'hermes_textdomain'); ?>:</label><br />
				<select name="hermes_events_type" id="hermes_events_type">
					<option<?php selected( get_post_meta($post->ID, 'hermes_events_type', true), 'Future' ); ?>><?php _e('Future','hermes_textdomain'); ?></option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_events_type', true), 'Past' ); ?>><?php _e('Past','hermes_textdomain'); ?></option>
				</select>
			</p>
			
  		</div>
	</fieldset>
	<?php
}

// Rooms List Page Template Options
function hermes_rooms_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveRooms" id="saveRooms" value="1" />
		<div>
			<p>
 				<label for="hermes_rooms_template">Page Template</label><br />
				<select name="hermes_rooms_template" id="hermes_rooms_template">
					<option<?php selected( get_post_meta($post->ID, 'hermes_rooms_template', true), 'Normal' ); ?>>Normal</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_rooms_template', true), 'Wide' ); ?>>Wide</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_rooms_template', true), 'Very Wide' ); ?>>Very Wide</option>
				</select>
			</p>
			<p>
 				<label for="hermes_rooms_layout">Rates Table Layout</label><br />
				<select name="hermes_rooms_layout" id="hermes_rooms_layout">
					<option<?php selected( get_post_meta($post->ID, 'hermes_rooms_layout', true), 'Standard' ); ?>>Standard</option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_rooms_layout', true), 'Reversed' ); ?>>Reversed</option>
				</select><br />
			</p>
			<p><span class="description">By default, rate types appear as column headings (top row), while room names appear as 1st cell in each row. 
			<br />Change this if you want room names to appear on top, and rate types to appear on the left.</span></p>
  		</div>
	</fieldset>
	<?php
	}

// Room Page Template Options
function hermes_room_options() {
	global $post;
	$hermes_options = hermes_get_global_options(); // get all options saved in Theme Options
	$room_labels = $hermes_options['hermes_rooms_meta_fields']; // get the number of custom room meta fields
	$room_prices = $hermes_options['hermes_rooms_prices_fields']; // get the number of custom room meta fields
	?>
	<fieldset>
		<input type="hidden" name="saveRoom" id="saveRoom" value="1" />
		<div>
			<?php
			foreach ($room_prices as $key => $value) { 
			if ($value == '') { break; }
			
			$field_name = 'hermes_room_price_' . $key;
			
			?>
			<p>
				<label for="<?php echo $field_name; ?>">Price - <?php echo $value; ?>:</label><br />
				<input type="text" style="width:90%;" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" value="<?php echo get_post_meta($post->ID, $field_name, true); ?>"><br />
			</p>
			<?php } ?>

			<?php
			foreach ($room_labels as $key => $value) { 
			if ($value == '') { break; }
			
			$field_name = 'hermes_room_' . $key;
			
			?>
			<p>
				<label for="<?php echo $field_name; ?>"><?php echo $value; ?>:</label><br />
				<input type="text" style="width:90%;" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" value="<?php echo get_post_meta($post->ID, $field_name, true); ?>"><br />
			</p>
			<?php } ?>
			
  		</div>
	</fieldset>
	<?php
	}

// Testimonials Options
function hermes_testimonial_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveTestimonial" id="saveTestimonial" value="1" />
		<div>
			<p>
				<label for="hermes_testimonial_author"><?php _e('Testimonial Author', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_testimonial_author" id="hermes_testimonial_author" value="<?php echo get_post_meta($post->ID, 'hermes_testimonial_author', true); ?>"><br />
			</p>
			<p>
				<label for="hermes_testimonial_country"><?php _e('Author Location', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_testimonial_country" id="hermes_testimonial_country" value="<?php echo get_post_meta($post->ID, 'hermes_testimonial_country', true); ?>"><br />
				<span class="description">Example: Rome, Italy</span>
			</p>
			<p>
				<label for="hermes_testimonial_date"><?php _e('Testimonial Date', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_testimonial_date" id="hermes_testimonial_date" value="<?php echo get_post_meta($post->ID, 'hermes_testimonial_date', true); ?>"><br />
				<span class="description">Example: 15th December, 2012</span>
			</p>
			<p>
				<label for="hermes_testimonial_url"><?php _e('Link to Original Source', 'hermes_textdomain'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_testimonial_url" id="hermes_testimonial_url" value="<?php echo get_post_meta($post->ID, 'hermes_testimonial_url', true); ?>"><br />
				<span class="description">Example: http://www.hermesthemes.com</span>
			</p>
			
  		</div>
	</fieldset>
	<?php
	}
