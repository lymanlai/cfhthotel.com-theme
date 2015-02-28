<?php			

/* Add theme customizer to <head> 
================================== */

function hermes_customizer_head() {

	/*
	This block refers to the functionality of the Appearance > Customize screen.
	*/
	echo '<style type="text/css">';
	generate_css('body', 'font-family', 'hermes_font_main');
	generate_css('body', 'color', 'hermes_color_body', '#555555');
	generate_css('body, header', 'background-color', 'hermes_color_bg_menu', '#ffffff');
	generate_css('#content', 'background-color', 'hermes_color_bg_content', '#f8f6f3');
	generate_css('#menu-main .current-menu-ancestor > a, #menu-main .current-menu-item a, #menu-main a:hover, #menu-main a:focus, #menu-main .sf-menu .current-menu-ancestor a:hover, #menu-main .sf-menu .current-menu-ancestor a:focus, #menu-main .sf-menu .current-menu-item a:hover, #menu-main .sf-menu .current-menu-item a:focus', 'color', 'hermes_color_link_hover_menu', '#60b895');
	generate_css('#menu-main .sub-menu li:hover, #menu-main .sub-menu li:focus', 'background-color', 'hermes_color_link_hover_menu', '#60b895');
	generate_css('h1, h2, h3, h4, h5, h6, .title-margin', 'color', 'hermes_color_headings', '#252525');
	generate_css('a', 'color', 'hermes_color_link', '#60b895');
	generate_css('a:hover, a:focus', 'color', 'hermes_color_link_hover', '#252525');
	generate_css('#menu-main li', 'font-family', 'hermes_font_menu');
	echo '</style>
';

}
add_action('wp_head', 'hermes_customizer_head');

/**
 * Adds the Customize page to the WordPress admin area

function hermes_customizer_menu() {
	add_theme_page( __('Customize','hermes_textdomain'), __('Customize','hermes_textdomain'), 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'hermes_customizer_menu' );

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */

function hermes_customizer( $wp_customize ) {

	// Define array of web safe fonts
	$hermes_fonts = array(
		'default' => 'Default',
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'"Droid Serif", Georgia, serif' => 'Droid Serif, Georgia, serif',
		'Georgia, serif' => 'Georgia, serif',
		'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype, Book Antique, Palatino, serif',
		'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
	);

	$wp_customize->add_section(
		'hermes_section_general',
		array(
			'title' => 'General Settings',
			'description' => 'This controls various general theme settings.',
			'priority' => 5,
		)
	);

	$wp_customize->add_section(
		'hermes_section_fonts',
		array(
			'title' => 'Fonts & Color Settings',
			'description' => 'Customize theme fonts and color of elements.',
			'priority' => 35,
		)
	);


	$wp_customize->add_setting( 'hermes_logo_upload' );
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'file-upload',
			array(
				'label' => 'Logo File Upload',
				'section' => 'hermes_section_general',
				'settings' => 'hermes_logo_upload'
			)
		)
	);

	$copyright_default = __('Copyright &copy; ','hermes_textdomain') . date("Y",time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved', 'hermes_textdomain');
	$wp_customize->add_setting(
		'hermes_copyright_text',
		array(
			'default' => $copyright_default,
		)
	);

	$wp_customize->add_control(
		'hermes_copyright_text',
		array(
			'label' => 'Copyright text in Footer',
			'section' => 'hermes_section_general',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'hermes_font_main',
		array(
			'default' => 'default',
		)
	);
	
	$wp_customize->add_control(
		'hermes_font_main',
		array(
			'type' => 'select',
			'label' => 'Choose the main body font',
			'section' => 'hermes_section_fonts',
			'choices' => $hermes_fonts,
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'hermes_font_menu',
		array(
			'default' => 'default',
		)
	);
	
	$wp_customize->add_control(
		'hermes_font_menu',
		array(
			'type' => 'select',
			'label' => 'Choose the Menu font',
			'section' => 'hermes_section_fonts',
			'choices' => $hermes_fonts,
			'priority' => 2,
		)
	);

	$wp_customize->add_setting(
		'hermes_color_bg_menu',
		array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_bg_menu',
			array(
				'label' => 'Menu block background color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_bg_menu',
				'priority' => 3,
			)
		)
	);

	$wp_customize->add_setting(
		'hermes_color_bg_content',
		array(
			'default' => '#f8f6f3',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_bg_content',
			array(
				'label' => 'Content block background color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_bg_content',
				'priority' => 4,
			)
		)
	);

	$wp_customize->add_setting(
		'hermes_color_body',
		array(
			'default' => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_body',
			array(
				'label' => 'Main body text color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_body',
				'priority' => 5,
			)
		)
	);

	$wp_customize->add_setting(
		'hermes_color_headings',
		array(
			'default' => '#252525',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_headings',
			array(
				'label' => 'Page headings color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_headings',
				'priority' => 6,
			)
		)
	);

	$wp_customize->add_setting(
		'hermes_color_link_hover_menu',
		array(
			'default' => '#60b895',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_link_hover_menu',
			array(
				'label' => 'Menu block link color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_link_hover_menu',
				'priority' => 7,
			)
		)
	);

	$wp_customize->add_setting(
		'hermes_color_link',
		array(
			'default' => '#60b895',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_link',
			array(
				'label' => 'Main body link color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_link',
				'priority' => 8,
			)
		)
	);

	$wp_customize->add_setting(
		'hermes_color_link_hover',
		array(
			'default' => '#252525',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hermes_color_link_hover',
			array(
				'label' => 'Main body link :hover color',
				'section' => 'hermes_section_fonts',
				'settings' => 'hermes_color_link_hover',
				'priority' => 9,
			)
		)
	);

}
add_action( 'customize_register', 'hermes_customizer' );

/**
* This will generate a line of CSS for use in header output. If the setting
* ($mod_name) has no defined value, the CSS will not be output.
* 
* @uses get_theme_mod()
* @param string $selector CSS selector
* @param string $style The name of the CSS *property* to modify
* @param string $mod_name The name of the 'theme_mod' option to fetch
* @param string $mod_name The default value in the theme, which will be ignored
* @param string $prefix Optional. Anything that needs to be output before the CSS property
* @param string $postfix Optional. Anything that needs to be output after the CSS property
* @param bool $echo Optional. Whether to print directly to the page (default: true).
* @return string Returns a single line of CSS with selectors and a property.
*/
function generate_css( $selector, $style, $mod_name, $default='', $prefix='', $postfix='', $echo=true ) {
	$return = '';
	$mod = get_theme_mod($mod_name);
	if ( ! empty( $mod ) && $mod != 'default' && $mod != $default ) {
		$return = sprintf('%s { %s: %s; }
		',
			$selector,
			$style,
			$prefix.$mod.$postfix
		);
		if ( $echo ) {
			echo $return;
		}
	}
	return $return;
}