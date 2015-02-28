<?php
/**
 * Define our settings sections
 *
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function hermes_options_page_sections() {
	
	$sections = array();
	$sections['general_section'] 	= __('General Settings', 'hermes_textdomain');
	$sections['homepage_section'] 	= __('Homepage Settings', 'hermes_textdomain');
	$sections['rooms_section'] 	= __('Rooms Settings', 'hermes_textdomain');
	$sections['social_section'] 	= __('Social Media', 'hermes_textdomain');
	$sections['misc_section'] 		= __('Miscellaneous', 'hermes_textdomain');
	// $sections['banners_section']	= __('Banners', 'hermes_textdomain');
	$sections['debug_section'] 		= __('Debug Information', 'hermes_textdomain');
	
	return $sections;	
} 

/**
 * Define our form fields (settings) 
 *
 * @return array
 */
function hermes_options_page_fields() {

    // Load categories and static pages in two separate arrays
	$categories =  get_categories('hide_empty=0'); // load list of categories
    $pages =  get_pages(''); // load list of categories
	$options_categories = array();
	$options_pages = array();
    
    // Create associative arrays with:
    // key = category/page ID
    // value = category/page Name
    
	foreach ($categories as $category) {
    	$options_categories[] = $category->name . "|" .$category->term_id;
	}
	
	foreach ($pages as $page) {
    	$options_pages[] = $page->post_title . "|" .$page->ID; 
	}
	
	$hermes_options = hermes_get_global_options();
	
	$options[] = array(
		"section" => "general_section",
		"id"      => HERMES_SHORTNAME . "_custom_css",
		"title"   => __( 'Load custom.css file', 'hermes_textdomain' ),
		"desc"    => __( 'Check this box if you want to load the custom.css file in the header of the theme.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 0 // 0 for off
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => HERMES_SHORTNAME . "_sidebar_contacts_display",
		"title"   => __( 'Sidebar Contact Info', 'hermes_textdomain' ),
		"desc"    => __( 'Check if you want to display additional contaction information at the bottom of the sidebar, under the menu.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => HERMES_SHORTNAME . "_contact_telephone_value",
		"title"   => __( 'Your Telephone', 'hermes_textdomain' ),
		"desc"    => __( 'Set your telephone number.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => __('1-800-123-4567','hermes_textdomain')
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => HERMES_SHORTNAME . "_contact_address_value",
		"title"   => __( 'Your Address', 'hermes_textdomain' ),
		"desc"    => __( 'Set your full address.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => __('34, Chestnut Road, London','hermes_textdomain')
	);

	$options[] = array(
		"section" => "general_section",
		"id"      => HERMES_SHORTNAME . "_contact_email_value",
		"title"   => __( 'Your E-mail', 'hermes_textdomain' ),
		"desc"    => __( 'Set your e-mail address.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => "",
		"class"   => "email"
	);


	// Homepage Options 

	$options[] = array(
		"section" => "homepage_section",
		"id"      => HERMES_SHORTNAME . "_gallery_page",
		"title"   => __( 'Slideshow Page', 'hermes_textdomain' ),
		"desc"    => __( 'Select a static page that contains the images to be used for the homepage slideshow. <br>These images will be shown in the slideshow on the Homepage and Archive Pages.', 'hermes_textdomain' ),
		"type"    => "select2",
		"std"    => "",
		"choices" => $options_pages
	);

	$options[] = array(
		"section" => "homepage_section",
		"id"      => HERMES_SHORTNAME . "_gallery_page_num",
		"title"   => __( 'Number of Photos to Display', 'hermes_textdomain' ),
		"desc"    => __( 'How many photos to display in the slideshow.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => 5,
		"class"   => "numeric"
	);

	$options[] = array(
		"section" => "homepage_section",
		"id"      => HERMES_SHORTNAME . "_gallery_autoplay",
		"title"   => __( 'Enable Slideshow Autoplay', 'hermes_textdomain' ),
		"desc"    => __( 'Check this box if you want to enable autoplay for the homepage slideshow.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "homepage_section",
		"id"      => HERMES_SHORTNAME . "_gallery_autoplay_speed",
		"title"   => __( 'Slideshow Autoplay Speed', 'hermes_textdomain' ),
		"desc"    => __( 'In miliseconds. 1 second = 1000 miliseconds.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => 5000,
		"class"   => "numeric"
	);

	$options[] = array(
		"section" => "rooms_section",
		"id"      => HERMES_SHORTNAME . "_rooms_metas_num",
		"title"   => __( 'Number of Room Custom Meta Fields', 'hermes_textdomain' ),
		"desc"    => __( 'How many custom meta fields you want to display for Rooms.<br />Click <strong>"Save Changes"</strong> after changing this value.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => 10,
		"class"   => "numeric"
	);
	
	if (isset($hermes_options['hermes_rooms_metas_num'])) { $meta_num = $hermes_options['hermes_rooms_metas_num']; }
	$i = 0;
	$meta_num = 0;
	
	$choices = array();
	while ($i < $meta_num) {
		$i++;
		$choices[] = 'Text input '.$i.'|txt_input'.$i;
	}

	$options[] = array(
		"section" => "rooms_section",
		"id"      => HERMES_SHORTNAME . "_rooms_meta_fields",
		"title"   => __( 'Room Amenities', 'hermes_textdomain' ),
		"desc"    => __( 'Fill in the labels for all available room amenities, which can be then selected for each type of room.', 'hermes_textdomain' ),
		"type"    => "multi-text",
		"choices" => $choices,
		"std"     => "Testing"
	);

	$options[] = array(
		"section" => "rooms_section",
		"id"   => 10,
		"title"   => '',
		"desc"    => '',
		"type"    => "divider",
		"std"     => '' // 0 for off
	);

	$options[] = array(
		"section" => "rooms_section",
		"id"      => HERMES_SHORTNAME . "_rooms_prices_num",
		"title"   => __( 'Number of Price Options', 'hermes_textdomain' ),
		"desc"    => __( 'If your room rates differ by month/season, choose the total number of price "options".<br />For example, if you have Low/Medium/High season rates, set this value to 3.<br />Click <strong>"Save Changes"</strong> after changing this value.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => 5,
		"class"   => "numeric"
	);
	
	if (isset($hermes_options['hermes_rooms_prices_num'])) { $meta_num = $hermes_options['hermes_rooms_prices_num']; }
	$i = 0;
	$meta_num = 0;
	
	$choices = array();
	while ($i < $meta_num) {
		$i++;
		$choices[] = 'Text input '.$i.'|txt_input'.$i;
	}

	$options[] = array(
		"section" => "rooms_section",
		"id"      => HERMES_SHORTNAME . "_rooms_prices_fields",
		"title"   => __( 'Price Options Names', 'hermes_textdomain' ),
		"desc"    => __( 'Fill in the labels (names) for your price options, which will then appear for each room.<br>Examples: Low Season, High Season, January-March, April-June.', 'hermes_textdomain' ),
		"type"    => "multi-text",
		"choices" => $choices,
		"std"     => "Testing"
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => HERMES_SHORTNAME . "_social_header",
		"title"   => __( 'Display Icons Under Menu', 'hermes_textdomain' ),
		"desc"    => __( 'Check this box if you want to display social media icons (Facebook, Twitter, TripAdvisor, RSS) under the Menu.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => HERMES_SHORTNAME . "_social_facebook",
		"title"   => __( 'Facebook', 'hermes_textdomain' ),
		"desc"    => __( 'Set the complete path (URL) to your Facebook page.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => ''
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => HERMES_SHORTNAME . "_social_twitter",
		"title"   => __( 'Twitter', 'hermes_textdomain' ),
		"desc"    => __( 'Set the complete path (URL) to your Twitter page.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => ''
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => HERMES_SHORTNAME . "_social_tripadvisor",
		"title"   => __( 'TripAdvisor', 'hermes_textdomain' ),
		"desc"    => __( 'Set the complete path (URL) to your TripAdvisor page.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => ''
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => HERMES_SHORTNAME . "_social_yelp",
		"title"   => __( 'Yelp', 'hermes_textdomain' ),
		"desc"    => __( 'Set the complete path (URL) to your Yelp page.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => ''
	);

	$options[] = array(
		"section" => "social_section",
		"id"      => HERMES_SHORTNAME . "_social_foursquare",
		"title"   => __( 'FourSquare', 'hermes_textdomain' ),
		"desc"    => __( 'Set the complete path (URL) to your FourSquare page.', 'hermes_textdomain' ),
		"type"    => "text",
		"std"     => ''
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => HERMES_SHORTNAME . "_script_header",
		"title"   => __( 'Custom Code Before &lt;/head&gt;', 'hermes_textdomain' ),
		"desc"    => __( 'Here you can add HTML/JS code that will be added right before &lt;/head&gt;. <br />For example here you can add the tracking code provided by Google Analytics.', 'hermes_textdomain' ),
		"type"    => "textarea",
		"std"     => '',
		"class"   => 'allowall'
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => HERMES_SHORTNAME . "_script_footer",
		"title"   => __( 'Custom Code Before &lt;/body&gt;', 'hermes_textdomain' ),
		"desc"    => __( 'Here you can add HTML/JS code that will be added right before &lt;/body&gt;.', 'hermes_textdomain' ),
		"type"    => "textarea",
		"std"     => '',
		"class"   => 'allowall'
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => HERMES_SHORTNAME . "_page_comments",
		"title"   => __( 'Display Comments for Pages', 'hermes_textdomain' ),
		"desc"    => __( 'Check this box if you want to display comments and submit comment form inside pages.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => HERMES_SHORTNAME . "_post_comments",
		"title"   => __( 'Display Comments for Posts', 'hermes_textdomain' ),
		"desc"    => __( 'Check this box if you want to display comments and submit comment form inside posts.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "misc_section",
		"id"      => HERMES_SHORTNAME . "_misc_credit",
		"title"   => __( 'Credit HermesThemes in Footer', 'hermes_textdomain' ),
		"desc"    => __( 'Leave this box checked if you want to keep "Designed by HermesThemes" in the footer. Keeping this box checked will make us very happy.', 'hermes_textdomain' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);

	$options[] = array(
		"section" => "debug_section",
		"id"      => HERMES_SHORTNAME . "_debug",
		"title"   => __( 'Debugging information', 'hermes_textdomain' ),
		"desc"    => __( '', 'hermes_textdomain' ),
		"type"    => "debug"
	);
	
	return $options;	
}

/**
 * Contextual Help
 */
function hermes_options_page_contextual_help() {
	
	$text 	= "<h3>" . __('Hermes Theme Options - Contextual Help','hermes_textdomain') . "</h3>";
	$text 	.= "<p>" . __('If you are experiencing problems with our theme, please consult our <a href="http://www.hermesthemes.com/support/">Support Section</a>.','hermes_textdomain') . "</p>";
	
	// must return text! NOT echo
	return $text;
} ?>
