<?php
/**
 * Define Constants
 */
define('HERMES_SHORTNAME', 'hermes'); 
define('HERMES_PAGE_BASENAME', 'hermes-options'); 

/**
 * Specify Hooks/Filters
 */
add_action( 'admin_menu', 'hermes_add_menu' );
add_action( 'admin_init', 'hermes_register_settings' );

/**
 * Include the required files
 */
// helper functions
require_once('hermes-helper-functions.php');
// page settings sections & fields as well as the contextual help text.
require_once('hermes-theme-options.php');

 /**
 * Helper function for defining variables according to current page content
 *
 * @return array
 */
function hermes_get_settings() {
	
	$output = array();
	
	/*PAGES*/
	// get current page
	$page = hermes_get_admin_page();
	
	/*DEFINE VARS*/
	// define variables according to registered admin menu page: hermes_add_menu()
	switch ($page) {
		case HERMES_PAGE_BASENAME:
			$hermes_option_name 		= 'hermes_options';
			$hermes_settings_page_title = __( 'Hermes Theme Options','hermes_textdomain');	
			$hermes_page_sections 		= hermes_options_page_sections();
			$hermes_page_fields 		= hermes_options_page_fields();
			// $hermes_contextual_help 	= hermes_options_page_contextual_help();
		break;
	
		case HERMES_PAGE_BASENAME . '-doc':
			$hermes_option_name 		= 'hermes_options_doc';
			$hermes_settings_page_title = __( 'Hermes Theme Documentation','hermes_textdomain');	
		break;

	}
	
	// put together the output array 
	if (isset($hermes_option_name)) {
		$output['hermes_option_name'] 		= $hermes_option_name;
	}
	if (isset($hermes_settings_page_title)) {
		$output['hermes_page_title'] 		= $hermes_settings_page_title;
	}
	if (isset($hermes_page_sections)) {
		$output['hermes_page_sections'] 	= $hermes_page_sections;
	}
	if (isset($hermes_page_fields)) {
		$output['hermes_page_fields'] 		= $hermes_page_fields;
	}
	if (isset($hermes_contextual_help)) {
		$output['hermes_contextual_help'] 	= $hermes_contextual_help;
	}
	
return $output;
}

/**
 * Helper function for registering our form field settings
 *
 * src: http://alisothegeek.com/2011/01/wordpress-settings-api-tutorial-1/
 * @param (array) $args The array of arguments to be used in creating the field
 * @return function call
 */
function hermes_create_settings_field( $args = array() ) {
	// default array to overwrite when calling the function
	$defaults = array(
		'id'      => 'default_field', 					// the ID of the setting in our options array, and the ID of the HTML form element
		'title'   => 'Default Field', 					// the label for the HTML form element
		'desc'    => 'This is a default description.', 	// the description displayed under the HTML form element
		'std'     => '', 								// the default value for this setting
		'type'    => 'text', 							// the HTML form element to use
		'section' => 'main_section', 					// the section this setting belongs to — must match the array key of a section in hermes_options_page_sections()
		'choices' => array(), 							// (optional): the values in radio buttons or a drop-down menu
		'class'   => '' 								// the HTML form element class. Is used for validation purposes and may be also use for styling if needed.
	);
	
	// "extract" to be able to use the array keys as variables in our function output below
	extract( wp_parse_args( $args, $defaults ) );
	
	// additional arguments for use in form field output in the function hermes_form_field_fn!
	$field_args = array(
		'type'      => $type,
		'id'        => $id,
		'desc'      => $desc,
		'std'       => $std,
		'choices'   => $choices,
		'label_for' => $id,
		'class'     => $class
	);

	add_settings_field( $id, $title, 'hermes_form_field_fn', __FILE__, $section, $field_args );

}

/**
 * Register our setting, settings sections and settings fields
 */
function hermes_register_settings(){
	
	// get the settings sections array
	$settings_output 	= hermes_get_settings();
	
	if (isset($settings_output['hermes_option_name'])) {
		$hermes_option_name = $settings_output['hermes_option_name'];
	}
	
	//setting
	if (isset($hermes_option_name)) {
		register_setting($hermes_option_name, $hermes_option_name, 'hermes_validate_options' );
	}
	
	//sections
	if(!empty($settings_output['hermes_page_sections'])){
		// call the "add_settings_section" for each!
		foreach ( $settings_output['hermes_page_sections'] as $id => $title ) {
			add_settings_section( $id, $title, 'hermes_section_fn', __FILE__);
		}
	}
		
	//fields
	if(!empty($settings_output['hermes_page_fields'])){
		// call the "add_settings_field" for each!
		foreach ($settings_output['hermes_page_fields'] as $option) {
			hermes_create_settings_field($option);
		}
	}
}

/**
 * Group scripts (js & css)
 */
function hermes_settings_scripts(){
	wp_enqueue_style('hermes_theme_settings_css', get_template_directory_uri() . '/hermes-admin/css/hermes_theme_settings.css');
	wp_enqueue_script( 'hermes_theme_settings_js', get_template_directory_uri() . '/hermes-admin/js/hermes_theme_settings.js', array('jquery'), '1', true );
}

/**
 * The admin menu pages
 */
function hermes_add_menu(){
	
	$settings_output 		= hermes_get_settings();
	$hermes_contextual_help = '';
	// collect our contextual help text
	if (isset($settings_output['hermes_contextual_help'])) {
		$hermes_contextual_help = $settings_output['hermes_contextual_help'];
	}
	$icon_url = get_template_directory_uri() .'/hermes-admin/images/hermes-icon-16.png'; 
	
	// As a "top level" menu
	add_menu_page( __('HermesThemes','hermes_textdomain'), __('HermesThemes','hermes_textdomain'), 'manage_options', HERMES_PAGE_BASENAME, 'hermes_settings_page_fn', $icon_url); 
	
	// theme options page
	$hermes_settings_page = add_submenu_page(HERMES_PAGE_BASENAME, __('Theme Options','hermes_textdomain'), __('Theme Options','hermes_textdomain'), 'manage_options', HERMES_PAGE_BASENAME, 'hermes_settings_page_fn');
	add_action( 'load-'. $hermes_settings_page, 'hermes_settings_scripts' );

	// documentation page
	$hermes_settings_page_doc = add_submenu_page(HERMES_PAGE_BASENAME, __('Documentation','hermes_textdomain'), __('Documentation','hermes_textdomain'), 'manage_options', HERMES_PAGE_BASENAME . '-doc', 'hermes_settings_page_doc');
	add_action( 'load-'. $hermes_settings_page_doc, 'hermes_settings_scripts' );

}

// ************************************************************************************************************

// Callback functions

/**
 * Form Fields HTML
 * All form field types share the same function!!
 * @return echoes output
 */
function hermes_form_field_fn($args = array()) {
	
	extract( $args );
	
	// get the settings sections array
	$settings_output 	= hermes_get_settings();
	
	$hermes_option_name = $settings_output['hermes_option_name'];
	$options 			= get_option($hermes_option_name);
	
	// pass the standard value if the option is not yet set in the database
	if ( !isset( $options[$id] ) && 'type' != 'checkbox' ) {
		$options[$id] = $std;
	}
	
	// additional field class. output only if the class is defined in the create_setting arguments
	$field_class = ($class != '') ? ' ' . $class : '';
	
	// switch html display based on the setting type.	
	switch ( $type ) {

		case 'divider':
			echo '<br>';
			echo ($desc != '') ? "<span class='description'>$desc</span>" : "";
		break;

		case 'text':
			$options[$id] = stripslashes($options[$id]);
			$options[$id] = esc_attr( $options[$id]);
			echo "<input class='regular-text$field_class' type='text' id='$id' name='" . $hermes_option_name . "[$id]' value='$options[$id]' />";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;
		
		case "multi-text":
			foreach($choices as $item) {
				$item = explode("|",$item); // cat_name|cat_slug
				$item[0] = esc_html__($item[0], 'hermes_textdomain');
				if (!empty($options[$id])) {
					foreach ($options[$id] as $option_key => $option_val){
						if ($item[1] == $option_key) {
							$value = stripslashes(htmlentities($option_val, ENT_QUOTES));
						}
					}
				} else {
					$value = '';
				}
				echo "<span>$item[0]:</span> <input class='$field_class' type='text' id='$id|$item[1]' name='" . $hermes_option_name . "[$id|$item[1]]' value='$value' /><br/>";
			}
			echo ($desc != '') ? "<span class='description'>$desc</span>" : "";
		break;
		
		case 'textarea':
			$options[$id] = stripslashes($options[$id]);
			$options[$id] = esc_html( $options[$id]);
			echo "<textarea class='textarea$field_class' type='text' id='$id' name='" . $hermes_option_name . "[$id]' rows='5' cols='30'>$options[$id]</textarea>";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : ""; 		
		break;
		
		case 'select':
			echo "<select id='$id' class='select$field_class' name='" . $hermes_option_name . "[$id]'>";
				foreach($choices as $item) {
					$value 	= esc_attr($item, 'hermes_textdomain');
					$item 	= esc_html($item, 'hermes_textdomain');
					
					$selected = ($options[$id]==$value) ? 'selected="selected"' : '';
					echo "<option value='$value' $selected>$item</option>";
				}
			echo "</select>";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : ""; 
		break;
		
		case 'select2':
			echo "<select id='$id' class='select$field_class' name='" . $hermes_option_name . "[$id]'>";

			$value 	= '';
			$selected = ($options[$id]==$value) ? 'selected="selected"' : '';
			echo "<option value='$value' $selected>". __('--- Please select a page ---','hermes_textdomain') .'</option>';

			foreach($choices as $item) {
				
				$item = explode("|",$item);
				$item[0] = esc_html($item[0], 'hermes_textdomain');
				
				$selected = ($options[$id]==$item[1]) ? 'selected="selected"' : '';
				echo "<option value='$item[1]' $selected>$item[0]</option>";
			}
			echo "</select>";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;
		
		case 'checkbox':
			echo "<input class='checkbox$field_class' type='checkbox' id='$id' name='" . $hermes_option_name . "[$id]' value='1' " . checked( $options[$id], 1, false ) . " />";
			echo ($desc != '') ? "<span class='description'>$desc</span>" : "";
		break;
		
		case "multi-checkbox":
			foreach($choices as $item) {
				
				$item = explode("|",$item);
				$item[0] = esc_html($item[0], 'hermes_textdomain');
				
				$checked = '';
				
			    if ( isset($options[$id][$item[1]]) ) {
					if ( $options[$id][$item[1]] == 'true') {
			   			$checked = 'checked="checked"';
					}
				}
				
				echo "<input class='checkbox$field_class' type='checkbox' id='$id|$item[1]' name='" . $hermes_option_name . "[$id|$item[1]]' value='1' $checked /> $item[0] <br/>";
			}
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;

		case 'debug':
			$options[$id] = stripslashes($options[$id]);
			$options[$id] = esc_attr( $options[$id]);

	        global $wp_version;
	        $theme_data = wp_get_theme();
	        $debug = '';
	
	        // site url, theme info
	        $debug .= "<p>Site URL: "          . get_home_url();
	        $debug .= "<br />Theme Name: "        . $theme_data->name;
	        $debug .= "<br />Theme Version: "     . $theme_data->version;
	        $debug .= "<br />WordPress Version: " . $wp_version;
	
	        $debug .= "</p><p><strong>Active Plugins</strong></p>";
	
	        // active plugins
	        $active_plugins = get_option('active_plugins');
	
	        // in order to be able to intersect plugins vs. active plugins by
	        // keys, we need to change keys with values
	        $active_plugins = array_flip($active_plugins);
	
	        if (!function_exists('get_plugins')) {
	            require_once(ABSPATH . WPINC . '/plugin.php');
	        }
	
	        // get all installed plugins
	        $plugins = get_plugins();
	
	        // select only active plugins
	        $active_plugins = array_intersect_key($plugins, $active_plugins);
	
	        $i = 1;
	        if ($active_plugins && is_array($active_plugins)) {
	            // if there are active plugins, get their name, version.
	            echo '<p>';
	            foreach ($active_plugins as $id => $plugin) {
	                $debug .= "$i. " . $plugin['Name'] . " " . $plugin['Version'];
	                $debug .= "<br />";
	                $i++;
	            }
	            echo '</p>';
	        }
	
	        // return debug text
	        echo $debug;

		break;

	}
}

/*
 * Section HTML, displayed before the first option
 * @return echoes output
 */
function  hermes_section_fn($section_passed) {
	if ($section_passed['id'] == 'general_section') { 
		echo '<div class="hermes-content" id="'.$section_passed['id'].'">';
		echo '<h2>'. $section_passed['title'] . '</h2>'; 
	} else {
		echo '</div>
			<div class="hermes-content" id="'.$section_passed['id'].'">';
			echo '<h2>'. $section_passed['title'] . '</h2>';
	}
}

/*
 * Admin Settings Page HTML
 * 
 * @return echoes output
 */
function hermes_settings_page_fn() {
	// get the settings sections array
	$settings_output = hermes_get_settings();
	$theme_data = wp_get_theme();
	
	// dislays the page title and tabs (if needed)
	//hermes_settings_page_header(); 
	?>
	
	<div class="hermes-wrapper">
		<div class="header">
			<div id="hermes-logo">
				<a href="http://www.hermesthemes.com" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/hermes-admin/images/hermes-options-logo.png" width="116" height="34" alt="Hermes Themes" /></a>
			</div><!-- end #hermes-logo -->

			<div id="hermes-theme-info">
				<p><span class="theme-name"><?php echo $theme_data->name; ?></span> <span class="theme-version"><?php echo $theme_data->version; ?></span></p>
			</div><!-- end #hermes-theme-info -->
			<div class="cleaner">&nbsp;</div>
		</div><!-- end .header -->
		
		<div class="subheader">
			<ul>
				<li><a href="http://www.hermesthemes.com/changelogs/<?php print strtolower($theme_data->name); ?>.txt"><?php esc_attr_e('Changelog','hermes_textdomain'); ?></a></li>
				<li><a href="http://www.hermesthemes.com/documentation/<?php print strtolower($theme_data->name); ?>/"><?php esc_attr_e('Theme Documentation','hermes_textdomain'); ?></a></li>
				<li><a href="http://www.hermesthemes.com/support/"><?php esc_attr_e('Theme Support','hermes_textdomain'); ?></a></li>
			</ul>
			<div class="cleaner">&nbsp;</div>
		</div><!-- .subheader -->
		
		<div class="hermes-container">
			
			<div class="hermes-tabs">
				<ul class="hermes-tabs">
					<li><a href="#general_section"><?php esc_attr_e('General Settings','hermes_textdomain'); ?></a></li>
					<li><a href="#homepage_section"><?php esc_attr_e('Homepage Settings','hermes_textdomain'); ?></a></li>
					<li><a href="#rooms_section"><?php esc_attr_e('Rooms Settings','hermes_textdomain'); ?></a></li>
					<li><a href="#social_section"><?php esc_attr_e('Social Media','hermes_textdomain'); ?></a></li>
					<li><a href="#misc_section"><?php esc_attr_e('Miscellaneous','hermes_textdomain'); ?></a></li>
					<!--<li><a href="#banners_section"><?php esc_attr_e('Banners','hermes_textdomain'); ?></a></li>-->
					<li><a href="#debug_section"><?php esc_attr_e('Debug Information','hermes_textdomain'); ?></a></li>
				</ul>
			</div><!-- end .hermes-tabs -->

			<form action="options.php" method="post">
				<?php 
				// http://codex.wordpress.org/Function_Reference/settings_fields
				settings_fields($settings_output['hermes_option_name']); 
				// http://codex.wordpress.org/Function_Reference/do_settings_sections
				do_settings_sections(__FILE__); 
				?>
				
				</div>
				<div class="cleaner">&nbsp;</div>

			<script>
				// Wait until the DOM has loaded before querying the document
				jQuery(document).ready(function($) { 
					$('ul.hermes-tabs').each(function(){
						// For each set of tabs, we want to keep track of
						// which tab is active and it's associated content
						var $active, $content, $links = $(this).find('a');
	
						// If the location.hash matches one of the links, use that as the active tab.
						// If no match is found, use the first link as the initial active tab.
						$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
						$active.addClass('active');
						$content = $($active.attr('href'));
	
						// Hide the remaining content
						$links.not($active).each(function () {
							$($(this).attr('href')).hide();
						});
	
						// Bind the click event handler
						$(this).on('click', 'a', function(e){
							// Make the old tab inactive.
							$active.removeClass('active');
							$content.hide();
	
							// Update the variables with the new link and content
							$active = $(this);
							$content = $($(this).attr('href'));
	
							// Make the tab active.
							$active.addClass('active');
							$content.show();
	
							// Prevent the anchor's default click action
							e.preventDefault();
						});
					});
				});
			</script>
			
		</div><!-- end .hermes-container -->

		<div class="cleaner cleaner-footer">&nbsp;</div>

		<div class="footer">
			<p class="submit">
				<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes','hermes_textdomain'); ?>" />
			</p>
			<div class="cleaner">&nbsp;</div>
		</div><!-- end .footer -->

		<?php
		$option_name = 'hermes-activated-time';
		$oldtime = get_option( $option_name );
		$curtime = time();
		
		if ($oldtime) {

			if (($curtime - $oldtime) > 2592000) {
				update_option( $option_name, $curtime );
				?>
				<img src="http://www.hermesthemes.com/thankyou/index.png" width="1" height="1" alt="" title="" />
				<?php
			}
 
		} else {

			$deprecated = ' ';
			$autoload = 'no';
			add_option( $option_name, $curtime, $deprecated, $autoload );
			?>
			<img src="http://www.hermesthemes.com/thankyou/index.png" width="1" height="1" alt="" title="" />
			<?php
		}
		?>
		
	</form>

	</div><!-- end .hermes-wrapper -->
<?php }

/*
 * Theme Documentation Page HTML
 * 
 * @return echoes output
 */
function hermes_settings_page_doc() {
	// get the settings sections array
	$settings_output = hermes_get_settings();
	$theme_data = wp_get_theme();
	
	// dislays the page title and tabs (if needed)
	//hermes_settings_page_header(); 
	?>
	
	<div class="hermes-wrapper">
		<div class="header">
			<div id="hermes-logo">
				<a href="http://www.hermesthemes.com" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/hermes-admin/images/hermes-options-logo.png" width="116" height="34" alt="Hermes Themes" /></a>
			</div><!-- end #hermes-logo -->

			<div id="hermes-theme-info">
				<p><span class="theme-name"><?php echo $theme_data->name; ?></span> <span class="theme-version"><?php echo $theme_data->version; ?></span></p>
			</div><!-- end #hermes-theme-info -->
			<div class="cleaner">&nbsp;</div>
		</div><!-- end .header -->
		
		<div class="subheader">
			<ul>
				<li><a href="http://www.hermesthemes.com/changelogs/<?php print strtolower($theme_data->name); ?>.txt"><?php esc_attr_e('Changelog','hermes_textdomain'); ?></a></li>
				<li><a href="http://www.hermesthemes.com/documentation/<?php print strtolower($theme_data->name); ?>/"><?php esc_attr_e('Theme Documentation','hermes_textdomain'); ?></a></li>
				<li><a href="http://www.hermesthemes.com/support/"><?php esc_attr_e('Theme Support','hermes_textdomain'); ?></a></li>
			</ul>
			<div class="cleaner">&nbsp;</div>
		</div><!-- .subheader -->
		
		<div class="hermes-documentation">
			<h2>Theme Documentation</h2>
			<p>Thank you for using <?php print $theme_data->name; ?> Theme by HermesThemes.com</p>
			<p>If you are having difficulties setting-up our WordPress theme, or you simply have some questions about using this theme, <strong>we recommend</strong> checking the following pages:</p>
			<ul>
				<li><a href="http://www.hermesthemes.com/documentation/<?php print strtolower($theme_data->name); ?>/"><?php print $theme_data->name; ?> Theme Documentation</a></li>
				<li><a href="http://www.hermesthemes.com/themes/<?php print strtolower($theme_data->name); ?>/"><?php print $theme_data->name; ?> Theme Release Page</a></li>
				<li><a href="http://www.hermesthemes.com/faq/">Frequently Asked Questions</a></li>
			</ul>
			
			<p>If you can't find answers to your theme-related questions, please feel free to contact our support team. </p>
			<ul>
				<li><a href="http://www.hermesthemes.com/support/">Support Section</a></li>
			</ul>
			<p>You should be able to access our Support Section using the username and password that you have chosen during the checkout process.</p>
			
			<h2>Connect with HermesThemes</h2>
			<p>We would love to hear from you about your experience with our theme, what we should improve, simplify, etc.</p>
			<ul>
				<li><a href="http://www.facebook.com/hermesthemes/">Stay in touch with our updates on Facebook</a></li>
				<li><a href="http://twitter.com/hermesthemes/">Follow us on Twitter</a></li>
				<li><a href="http://feeds.feedburner.com/hermesthemes">Subscribe to our updates via RSS</a></li>
			</ul>
			
		</div><!-- end .hermes-documentation -->

	</div><!-- end .hermes-wrapper -->

<?php }

/**
 * Validate input
 * 
 * @return array
 */
function hermes_validate_options($input) {
	
	// for enhanced security, create a new empty array
	$valid_input = array();
	
	// collect only the values we expect and fill the new $valid_input array i.e. whitelist our option IDs
	
		// get the settings sections array
		$settings_output = hermes_get_settings();
		
		$options = $settings_output['hermes_page_fields'];
		
		// run a foreach and switch on option type
		foreach ($options as $option) {
		
			switch ( $option['type'] ) {
				case 'text':
					//switch validation based on the class!
					switch ( $option['class'] ) {
						//for numeric 
						case 'numeric':
							//accept the input only when numeric!
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$valid_input[$option['id']] = (is_numeric($input[$option['id']])) ? $input[$option['id']] : 'Expecting a Numeric value!';
							
							// register error
							if(is_numeric($input[$option['id']]) == FALSE) {
								add_settings_error(
									$option['id'], // setting title
									HERMES_SHORTNAME . '_txt_numeric_error', // error ID
									__('Expecting a Numeric value! Please fix.','hermes_textdomain'), // error message
									'error' // type of message
								);
							}
						break;
						
						//for multi-numeric values (separated by a comma)
						case 'multinumeric':
							//accept the input only when the numeric values are comma separated
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							
							if($input[$option['id']] !=''){
								// /^-?\d+(?:,\s?-?\d+)*$/ matches: -1 | 1 | -12,-23 | 12,23 | -123, -234 | 123, 234  | etc.
								$valid_input[$option['id']] = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['id']]) == 1) ? $input[$option['id']] : __('Expecting comma separated numeric values','hermes_textdomain');
							}else{
								$valid_input[$option['id']] = $input[$option['id']];
							}
							
							// register error
							if($input[$option['id']] !='' && preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['id']]) != 1) {
								add_settings_error(
									$option['id'], // setting title
									HERMES_SHORTNAME . '_txt_multinumeric_error', // error ID
									__('Expecting comma separated numeric values! Please fix.','hermes_textdomain'), // error message
									'error' // type of message
								);
							}
						break;
						
						//for no html
						case 'nohtml':
							//accept the input only after stripping out all html, extra white space etc!
							$input[$option['id']] 		= sanitize_text_field($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;
						
						//for url
						case 'url':
							//accept the input only when the url has been sanited for database usage with esc_url_raw()
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$valid_input[$option['id']] = esc_url_raw($input[$option['id']]);
						break;
						
						//for email
						case 'email':
							//accept the input only after the email has been validated
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							if($input[$option['id']] != ''){
								$valid_input[$option['id']] = (is_email($input[$option['id']])!== FALSE) ? $input[$option['id']] : __('Invalid email! Please re-enter!','hermes_textdomain');
							}
							/* elseif($input[$option['id']] == ''){
								$valid_input[$option['id']] = __('This setting field cannot be empty! Please enter a valid email address.','hermes_textdomain');
							}
							*/
							
							// register error
							if(is_email($input[$option['id']])== FALSE || $input[$option['id']] == '') {
								add_settings_error(
									$option['id'], // setting title
									HERMES_SHORTNAME . '_txt_email_error', // error ID
									__('Please enter a valid email address.','hermes_textdomain'), // error message
									'error' // type of message
								);
							}
						break;
						
						// a "cover-all" fall-back when the class argument is not set
						default:
							// accept only a few inline html elements
							$allowed_html = array(
								'a' => array('href' => array (),'title' => array ()),
								'b' => array(),
								'em' => array (), 
								'i' => array (),
								'strong' => array()
							);
							
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
							$input[$option['id']] 		= wp_kses( $input[$option['id']], $allowed_html); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]); 
						break;
					}
				break;
				
				case "multi-text":
					// this will hold the text values as an array of 'key' => 'value'
					unset($textarray);
					
					$text_values = array();
					foreach ($option['choices'] as $k => $v ) {
						// explode the connective
						$pieces = explode("|", $v);
						
						$text_values[] = $pieces[1];
					}
					
					foreach ($text_values as $v ) {		
						
						// Check that the option isn't empty
						if (!empty($input[$option['id'] . '|' . $v])) {
							// If it's not null, make sure it's sanitized, add it to an array
							switch ($option['class']) {
								// different sanitation actions based on the class create you own cases as you need them
								
								//for numeric input
								case 'numeric':
									//accept the input only if is numberic!
									$input[$option['id'] . '|' . $v]= trim($input[$option['id'] . '|' . $v]); // trim whitespace
									$input[$option['id'] . '|' . $v]= (is_numeric($input[$option['id'] . '|' . $v])) ? $input[$option['id'] . '|' . $v] : '';
								break;
								
								// a "cover-all" fall-back when the class argument is not set
								default:
									// strip all html tags and white-space.
									$input[$option['id'] . '|' . $v]= sanitize_text_field($input[$option['id'] . '|' . $v]); // need to add slashes still before sending to the database
									$input[$option['id'] . '|' . $v]= addslashes($input[$option['id'] . '|' . $v]);
								break;
							}
							// pass the sanitized user input to our $textarray array
							$textarray[$v] = $input[$option['id'] . '|' . $v];
						
						} else {
							$textarray[$v] = '';
						}
					}
					// pass the non-empty $textarray to our $valid_input array
					if (!empty($textarray)) {
						$valid_input[$option['id']] = $textarray;
					}
				break;
				
				case 'textarea':
					//switch validation based on the class!
					switch ( $option['class'] ) {
						//for only inline html
						case 'inlinehtml':
							// accept only inline html
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
							$input[$option['id']] 		= addslashes($input[$option['id']]); //wp_filter_kses expects content to be escaped!
							$valid_input[$option['id']] = wp_filter_kses($input[$option['id']]); //calls stripslashes then addslashes
						break;
						
						//for no html
						case 'nohtml':
							//accept the input only after stripping out all html, extra white space etc!
							$input[$option['id']] 		= sanitize_text_field($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;
						
						//for allowlinebreaks
						case 'allowlinebreaks':
							//accept the input only after stripping out all html, extra white space etc!
							$input[$option['id']] 		= wp_strip_all_tags($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;

						//for allow all
						case 'allowall':
							//accept any HTML code
							$input[$option['id']] 		= trim($input[$option['id']]); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);
						break;
						
						// a "cover-all" fall-back when the class argument is not set
						default:
							// accept only limited html
							//my allowed html
							$allowed_html = array(
								'a' 			=> array('href' => array (),'title' => array ()),
								'b' 			=> array(),
								'blockquote' 	=> array('cite' => array ()),
								'br' 			=> array(),
								'dd' 			=> array(),
								'dl' 			=> array(),
								'dt' 			=> array(),
								'em' 			=> array (), 
								'i' 			=> array (),
								'li' 			=> array(),
								'ol' 			=> array(),
								'p' 			=> array(),
								'q' 			=> array('cite' => array ()),
								'strong' 		=> array(),
								'ul' 			=> array(),
								'h1' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h2' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h3' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h4' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h5' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()),
								'h6' 			=> array('align' => array (),'class' => array (),'id' => array (), 'style' => array ())
							);
							
							$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
							$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
							$input[$option['id']] 		= wp_kses( $input[$option['id']], $allowed_html); // need to add slashes still before sending to the database
							$valid_input[$option['id']] = addslashes($input[$option['id']]);							
						break;
					}
				break;
				
				case 'select':
					// check to see if the selected value is in our approved array of values!
					$valid_input[$option['id']] = (in_array( $input[$option['id']], $option['choices']) ? $input[$option['id']] : '' );
				break;
				
				case 'select2':
					// process $select_values
						$select_values = array();
						foreach ($option['choices'] as $k => $v) {
							// explode the connective
							$pieces = explode("|", $v);
							
							$select_values[] = $pieces[1];
						}
					// check to see if selected value is in our approved array of values!
					$valid_input[$option['id']] = (in_array( $input[$option['id']], $select_values) ? $input[$option['id']] : '' );
				break;
				
				case 'checkbox':
					// if it's not set, default to null!
					if (!isset($input[$option['id']])) {
						$input[$option['id']] = null;
					}
					// Our checkbox value is either 0 or 1
					$valid_input[$option['id']] = ( $input[$option['id']] == 1 ? 1 : 0 );
				break;
				
				case 'multi-checkbox':
					unset($checkboxarray);
					$check_values = array();
					foreach ($option['choices'] as $k => $v ) {
						// explode the connective
						$pieces = explode("|", $v);
						
						$check_values[] = $pieces[1];
					}
					
					foreach ($check_values as $v ) {		
						
						// Check that the option isn't null
						if (!empty($input[$option['id'] . '|' . $v])) {
							// If it's not null, make sure it's true, add it to an array
							$checkboxarray[$v] = 'true';
						}
						else {
							$checkboxarray[$v] = 'false';
						}
					}
					// Take all the items that were checked, and set them as the main option
					if (!empty($checkboxarray)) {
						$valid_input[$option['id']] = $checkboxarray;
					}
				break;
				
			}
		}
return $valid_input; // return validated input
}

/**
 * Helper function for creating admin messages
 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area
 *
 * @param (string) $message The message to echo
 * @param (string) $msgclass The message class
 * @return echoes the message
 */
function hermes_show_msg($message, $msgclass = 'info') {
	echo "<div id='message' class='$msgclass'>$message</div>";
}

/**
 * Callback function for displaying admin messages
 *
 * @return calls hermes_show_msg()
 */
function hermes_admin_msgs() {
	
	// check for our settings page - need this in conditional further down
	if (isset($_GET['page'])) {
		$hermes_settings_pg = strpos($_GET['page'], HERMES_PAGE_BASENAME);
	} else {
		$hermes_settings_pg = false;
	}
	// collect setting errors/notices: //http://codex.wordpress.org/Function_Reference/get_settings_errors
	$set_errors = get_settings_errors(); 
	
	//display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned!	
	if(current_user_can ('manage_options') && $hermes_settings_pg !== FALSE && !empty($set_errors)){

		// have our settings succesfully been updated? 
		if($set_errors[0]['code'] == 'settings_updated' && isset($_GET['settings-updated'])){
			hermes_show_msg("<p>" . $set_errors[0]['message'] . "</p>", 'updated');
		
		// have errors been found?
		}else{
			// there maybe more than one so run a foreach loop.
			foreach($set_errors as $set_error){
				// set the title attribute to match the error "setting title" - need this in js file
				hermes_show_msg("<p class='setting-error-message' title='" . $set_error['setting'] . "'>" . $set_error['message'] . "</p>", 'error');
			}
		}
	}
}

// admin messages hook!
add_action('admin_notices', 'hermes_admin_msgs');
?>
