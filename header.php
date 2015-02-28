<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 
?>
<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php 
	// check if WordPress SEO by Yoast plugin is active
	if ( defined('WPSEO_VERSION') ) { ?>
<title><?php wp_title(''); ?></title>
	<?php } else { ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php } ?>
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
	<?php if (isset($hermes_options['hermes_custom_css']) && $hermes_options['hermes_custom_css'] == 1) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_url'); ?>/custom.css" />
	<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<?php wp_head(); ?>

	<?php if (isset($hermes_options['hermes_script_header'])) { print(stripslashes($hermes_options['hermes_script_header'])); } ?>

</head>

<body <?php body_class(); ?>>

<div id="container">

	<header>
	
		<div class="wrapper wrapper-header">
		
			<div id="logo">
				<?php $default_logo = get_template_directory_uri() . '/images/logo.png'; ?>
				<a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>"><img src="<?php if (get_theme_mod('hermes_logo_upload') != '') { echo get_theme_mod('hermes_logo_upload'); } else { echo $default_logo; } ?>" alt="<?php bloginfo('name'); ?>" class="logo-main" /></a>
			</div><!-- end #logo -->
			
			<nav id="menu-main">
					
				<?php if (has_nav_menu( 'primary' )) { 

					$menuSocial = '';
					if (isset($hermes_options['hermes_social_header']) && $hermes_options['hermes_social_header'] == 1) {
	
						$menuSocial = '<li class="social-icons hermes-social-24">';
						if (isset($hermes_options['hermes_social_facebook'])) { $menuSocial .= '<a href="' . $hermes_options['hermes_social_facebook'] . '" rel="nofollow"><img src="' . get_template_directory_uri() . '/images/x.gif" width="24" height="24" class="hermes-icon-social icon-facebook" alt="Facebook icon" /></a>'; }
						if (isset($hermes_options['hermes_social_foursquare'])) { $menuSocial .= '<a href="' . $hermes_options['hermes_social_foursquare'] . '" rel="nofollow"><img src="' . get_template_directory_uri() . '/images/x.gif" width="24" height="24" class="hermes-icon-social icon-foursquare" alt="FourSquare icon" /></a>'; }
						if (isset($hermes_options['hermes_social_twitter'])) { $menuSocial .= '<a href="' . $hermes_options['hermes_social_twitter'] . '" rel="nofollow"><img src="' . get_template_directory_uri() . '/images/x.gif" width="24" height="24" class="hermes-icon-social icon-twitter" alt="Twitter icon" /></a>'; }
						if (isset($hermes_options['hermes_social_tripadvisor'])) { $menuSocial .= '<a href="' . $hermes_options['hermes_social_tripadvisor'] . '" rel="nofollow"><img src="' . get_template_directory_uri() . '/images/x.gif" width="24" height="24" class="hermes-icon-social icon-tripadvisor" alt="TripAdvisor icon" /></a>'; }
						if (isset($hermes_options['hermes_social_yelp'])) { $menuSocial .= '<a href="' . $hermes_options['hermes_social_yelp'] . '" rel="nofollow"><img src="' . get_template_directory_uri() . '/images/x.gif" width="24" height="24" class="hermes-icon-social icon-yelp" alt="Yelp icon" /></a>'; }
						// $menuSocial .= '<a href="' . get_bloginfo('rss2_url') . '" rel="nofollow"><img src="' . get_template_directory_uri() . '/images/x.gif" width="24" height="24" class="hermes-icon-social icon-rss" alt="RSS icon" /></a>';
						$menuSocial .= '</li>';
					}
	
					wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'dropdown', 'menu_id' => 'menu-main-menu', 'sort_column' => 'menu_order', 'theme_location' => 'primary', 
					'items_wrap' => '<ul id="menu-main-menu" class="mobile-menu sf-js-enabled sf-menu sf-vertical">%3$s'.$menuSocial.'</ul>' ) );
				}
				else
				{
					if (current_user_can('edit_theme_options')) {
						echo '<p class="hermes-notice">Please set your Main Menu on the <a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a> page. For more information please <a href="http://www.hermesthemes.com/documentation/belafonte/">read the documentation</a></p>';
					}
				}
				?>
			</nav><!-- end #menu-main -->
			
			<div class="cleaner">&nbsp;</div>
			<?php if (is_active_sidebar('sidebar') || $hermes_options['hermes_sidebar_contacts_display'] == 1) {
				echo '<div class="divider">&nbsp;</div>';
			}
			?>

			<?php if (isset($hermes_options['hermes_sidebar_contacts_display']) && $hermes_options['hermes_sidebar_contacts_display'] == 1) { ?>
			<div id="hermes-contacts" class="widget">
				<ul class="hermes-contacts">
					<?php if (isset($hermes_options['hermes_contact_address_value'])) { ?>
					<li class="hermes-contact address">
						<span class="value"><?php echo $hermes_options['hermes_contact_address_value']; ?></span>
					</li>
					<?php } ?>
					<?php if (isset($hermes_options['hermes_contact_telephone_value'])) { ?>
					<li class="hermes-contact telephone">
						<span class="value"><?php echo $hermes_options['hermes_contact_telephone_value']; ?></span>
					</li>
					<?php } ?>
					<?php if (isset($hermes_options['hermes_contact_email_value'])) { ?>
					<li class="hermes-contact email">
						<span class="value"><a href="mailto:<?php echo $hermes_options['hermes_contact_email_value']; ?>"><?php echo $hermes_options['hermes_contact_email_value']; ?></a></span>
					</li>
					<?php } ?>
				</ul>
			</div><!-- #hermes-contacts -->
			<?php } ?>
			
			<?php get_sidebar(); ?>
			
			<div class="hermes-copy">
				<div class="wrapper-copy">
					<div class="divider">&nbsp;</div>
					<?php $copyright_default = __('Copyright &copy; ','hermes_textdomain') . date("Y",time()) . ' ' . get_bloginfo('name') . '.<br>' . __('All Rights Reserved.', 'hermes_textdomain'); ?>
					<p class="copy"><?php echo get_theme_mod( 'hermes_copyright_text', $copyright_default ); ?></p>
					<?php if (isset($hermes_options['hermes_misc_credit']) && $hermes_options['hermes_misc_credit'] == 1) { ?>
					<p class="hermes-credit"><?php _e('Designed by', 'hermes_textdomain'); ?> <a href="http://www.hermesthemes.com" target="_blank" title="Hotel WordPress Themes">HermesThemes</a></p>
					<?php } ?>
				</div><!-- .wrapper-copy -->
			</div><!-- .hermes-copy -->
		
		</div><!-- .wrapper .wrapper-header -->
		
	</header>