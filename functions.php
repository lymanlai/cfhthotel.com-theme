<?php			

if ( ! isset( $content_width ) ) $content_width = 940;

/* Disable PHP error reporting for notices, leave only the important ones 
================================== */

error_reporting(E_ERROR | E_PARSE);

/* Add javascripts and CSS used by the theme 
================================== */

function hermes_js_scripts() {

	if (! is_admin()) {

		wp_enqueue_script(
			'cycle',
			get_template_directory_uri() . '/js/jquery.cycle.all.js',
			array('jquery'),
			null
		);
		wp_enqueue_script(
			'maximage',
			get_template_directory_uri() . '/js/jquery.maximage.min.js',
			array('jquery','cycle'),
			null
		);
		wp_enqueue_script(
			'superfish',
			get_template_directory_uri() . '/js/superfish.js',
			array('jquery'),
			null
		);
		wp_enqueue_script(
			'selectnav',
			get_template_directory_uri() . '/js/selectnav.min.js',
			array('jquery'),
			null
		);
		wp_enqueue_script(
			'init',
			get_template_directory_uri() . '/js/init.js',
			array('jquery','superfish','selectnav'),
			null
		);

		wp_enqueue_script('thickbox', null,  array('jquery'), null);
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, null);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

		// Loads our default Google Webfont
		//wp_enqueue_style( 'hermes-webfonts', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700', array(), null, null );

	}

}
add_action('wp_enqueue_scripts', 'hermes_js_scripts');

/* Register Thumbnails Size 
================================== */

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'thumb-hermes-slideshow', 1000, 1000, true );
	add_image_size( 'thumb-loop-gallery', 140, 85, true );
	add_image_size( 'thumb-loop-main', 100, 60, true );
}

/* 	Register Custom Menu 
==================================== */

register_nav_menu('primary', 'Main Menu');

/* Add support for Localization
==================================== */

load_theme_textdomain( 'hermes_textdomain', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);

/* Add support for Custom Background 
==================================== */

add_theme_support( 'custom-background' );

/* Add support for post and comment RSS feed links in <head>
==================================== */

add_theme_support( 'automatic-feed-links' ); 

/* Enable Excerpts for Static Pages
==================================== */

add_action( 'init', 'hermes_excerpts_for_pages' );

function hermes_excerpts_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

/* Custom Excerpt Length
==================================== */

function new_excerpt_length($length) {
	return 40;
}
add_filter('excerpt_length', 'new_excerpt_length');

/* Replace invalid ellipsis from excerpts
==================================== */

function hermes_excerpt($text)
{
   return str_replace(' [...]', '...', $text); // if there is a space before ellipsis
   return str_replace('[...]', '...', $text);
}
add_filter('the_excerpt', 'hermes_excerpt');

/* Reset [gallery] shortcode styles						
==================================== */

add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

/* Comments Custom Template						
==================================== */

function hermes_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
				
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 50 ); ?>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->

					</div><!-- .comment-author .vcard -->
	
					<div class="comment-body">
	
						<?php printf( __( '%s', 'hermes_textdomain' ), sprintf( '<cite class="comment-author-name">%s</cite>', get_comment_author_link() ) ); ?>
						<span class="comment-timestamp"><?php printf( __('%s at %s', 'hermes_textdomain'), get_comment_date(), get_comment_time()); ?></span><?php edit_comment_link( __( 'Edit', 'hermes_textdomain' ), ' <span class="comment-bullet">&#8226;</span> ' ); ?>
	
						<div class="comment-content">
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'hermes_textdomain' ); ?></p>
						<?php endif; ?>
	
						<?php comment_text(); ?>
						</div><!-- .comment-content -->

					</div><!-- .comment-body -->
	
					<div class="cleaner">&nbsp;</div>
				
				</div><!-- #comment-<?php comment_ID(); ?> -->
		
			</li><!-- #li-comment-<?php comment_ID(); ?> -->
		
			<?php
		break;

		case 'pingback'  :
		case 'trackback' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'hermes_textdomain' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'hermes_textdomain' ), ' ' ); ?></p>
			</li>
			<?php
		break;
	
	endswitch;
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function hermes_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'hermes_textdomain' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'hermes_wp_title', 10, 2 );

/* Include WordPress Theme Customizer
================================== */

require_once('hermes-admin/hermes-customizer.php');

/* Include Additional Options and Components
================================== */

require_once('hermes-admin/components/get-the-image.php');
require_once('hermes-admin/components/wpml.php'); // enables support for WPML plug-in
require_once('hermes-admin/custom-post-types.php'); // important to load this before post-options.php
require_once('hermes-admin/post-options.php');
require_once('hermes-admin/sidebars.php');
require_once('hermes-admin/widgets/connections.php');
require_once('hermes-admin/widgets/facebook-like-box.php');
require_once('hermes-admin/widgets/tripadvisor.php');
require_once('hermes-admin/widgets/twitter.php');


/* Include Theme Options Page for Admin
================================== */

//require only in admin!
if(is_admin()){	
	require_once('hermes-admin/hermes-theme-settings.php');
}

/**
 * Collects our theme options
 *
 * @return array
 */
function hermes_get_global_options(){
	
	$hermes_option = array();

	// collect option names as declared in hermes_get_settings()
	$hermes_option_name = 'hermes_options';

	// loop for get_option
	if (get_option($hermes_option_name)!= FALSE) {
		$option = get_option($hermes_option_name);
		
		// now merge in main $hermes_option array!
		$hermes_option = array_merge($hermes_option, $option);
	}

	
	return $hermes_option;
}

/**
 * Call the function and collect in variable
 *
 * Should be used in template files like this:
 * echo $hermes_option['hermes_txt_input'];
 *
 * Note: Should you notice that the variable ($hermes_option) is empty when used in certain templates such as header.php, sidebar.php and footer.php
 * you will need to call the function (copy the line below and paste it) at the top of those documents (within php tags)!
 */ 
$hermes_option = hermes_get_global_options();
