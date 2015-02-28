<?php

/**
 * Redirect user to Theme Options page upon theme activation
 */
if (is_admin() && isset($_GET['activated']) && $_GET['activated'] == 'true') {
	header("Location: admin.php?page=hermes-options");
}

/**
 * Helper function: Check for pages and return the current page name
 * 
 * @return string
 */
function hermes_get_admin_page() {
	global $pagenow;
	
	// read the current page
	if (isset($_GET['page'])) {
		$current_page = trim($_GET['page']);
	}
	
	// use a different way to read the current page name when the form submits
	if ($pagenow == 'options.php') {
		// get the page name
		$parts 	= explode('page=', $_POST['_wp_http_referer']); // http://codex.wordpress.org/Function_Reference/wp_referer_field
		$page  	= $parts[1]; 

		// account for the use of tabs (we do not want the tab name to be part of our return value!)
		$t 		= strpos($page,"&");
		
		if($t !== FALSE) {			 
			$page  = substr($parts[1],0,$t); 
		}
		
		$current_page = trim($page);
	}
	
	if (isset($current_page)) {
		return $current_page;
	}
}

/**
 * Helper function: Creates settings page title and tabs (if needed)
 *
 * @return echos output
 */
function hermes_settings_page_header() {
	
    // get the tabs
    $settings_output 	= hermes_get_settings();
	
	// display the icon and page title
	echo '<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>' . $settings_output['hermes_page_title'] . '</h2>';
}
?>