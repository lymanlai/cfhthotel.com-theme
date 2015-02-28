<?php
/**
 * Template Name: Booking form
 */

get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include get_template_directory() . '/layout-vars.php';

// We need to sanitize user input

$name = isset($_POST['fname']) ? esc_html(trim($_POST['fname'])) : '';
$telephone = isset($_POST['phone']) ? esc_html(trim($_POST['phone'])) : '';
$email = isset($_POST['email']) ? esc_html(trim($_POST['email'])) : '';
$arrival = isset($_POST['arrival']) ? esc_html(trim($_POST['arrival'])) : '';
$departure = isset($_POST['departure']) ? esc_html(trim($_POST['departure'])) : '';
$adults = isset($_POST['adults']) ? intval($_POST['adults']) : '1';
$children = isset($_POST['children']) ? intval($_POST['children']) : '0';
$comments = isset($_POST['booking-comments']) ? esc_html(trim($_POST['booking-comments'])) : '';

$errorString = '';
$emailSent = false;

if(isset($_POST['submit-booking']))
{

	if ($post_meta['hermes_booking_email'][0] && is_email($post_meta['hermes_booking_email'][0])) {
		$to = $post_meta['hermes_booking_email'][0];
	} else {
		$to = get_option('admin_email');
	}
	
	$subject = __('Booking Enquiry', 'hermes_textdomain');
	
	// We need to validate user input
	
	if(empty($name) or mb_strlen($name) < 2)
		$errorString .= '<li>'.__('Your name is required', 'hermes_textdomain').'</li>';

	if(empty($email) or !is_email($email))
		$errorString .= '<li>'.__('A valid email is required', 'hermes_textdomain').'</li>';

	if(empty($arrival) or strlen($arrival) < 6)
		$errorString .= '<li>'.__('A complete arrival date is required', 'hermes_textdomain').'</li>';

	if(empty($departure) or strlen($departure) < 6)
		$errorString .= '<li>'.__('A complete departure date is required', 'hermes_textdomain').'</li>';

	if(empty($adults) or !is_numeric($adults) or intval($adults) < 1)
		$errorString .= '<li>'.__('A number of one or more adults is required', 'hermes_textdomain').'</li>';

	/*
	if(!is_numeric($children) or intval($children) < 0)
		$errorString .= '<li>'.__('A number of zero or more children is required', 'hermes_textdomain').'</li>';
	*/
	
	$headers = 'From: ' . $name . ' <'.$email.'>' . "\r\n";

	// Send e-mail if there are no errors
	if(empty($errorString))
	{
		$mailbody  = __("Name:", 'hermes_textdomain') . " " . $name . "\n";
		$mailbody .= __("Email:", 'hermes_textdomain') . " " . $email . "\n";
		$mailbody .= __("Telephone:", 'hermes_textdomain') . " " . $telephone . "\n";
		$mailbody .= __("Date of arrival:", 'hermes_textdomain') . " " . $arrival . "\n";
		$mailbody .= __("Date of departure:", 'hermes_textdomain') . " " . $departure . "\n";
		$mailbody .= __("Adults:", 'hermes_textdomain') . " " . $adults . "\n";
		$mailbody .= __("Children:", 'hermes_textdomain') . " " . $children . "\n";
		$mailbody .= __("Comments:", 'hermes_textdomain') . " " . $comments . "\n";
		$emailSent = wp_mail($to, $subject, $mailbody, $headers);
	}
	
}

?>

<?php if ($page_class != 'layout-nocontent') { ?>
<div id="content" class="<?php echo $page_class;?>">

	<div class="wrapper wrapper-main">
	
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="post-intro">
			<h1 class="title-page title-m"><?php the_title(); ?></h1>
			<?php edit_post_link( __('Edit page', 'hermes_textdomain'), '<p class="post-meta">', '</p>'); ?>
		</div><!-- .post-intro -->

		<div class="post-single">

			<?php the_content(); ?>
			<div class="cleaner">&nbsp;</div>
			
			<?php if(!empty($errorString)): ?>
				<ul id="hermes-form-errors">
					<?php echo $errorString; ?>
				</ul><!-- #hermes-form-errors -->
			<?php endif; ?>

			<?php if ($emailSent == true): ?>
				<p id="hermes-form-success"><?php _e('Your booking enquiry has been sent. We will contact you as soon as possible.', 'hermes_textdomain'); ?></p>
			<?php endif; ?>

			<?php if( !isset($_POST['submit-booking']) || (isset($_POST['submit-booking']) && !empty($errorString)) ): ?>
				<form action="" id="form-booking" method="post">
					
					<p>
						<label class="hermes-label" for="fname"><?php _e('Name', 'hermes_textdomain'); ?></label>
						<input class="hermes-input" name="fname" id="fname" type="text" value="<?php echo $name;?>" />
					</p>
					
					<p>
						<label class="hermes-label" for="email"><?php _e('Email', 'hermes_textdomain'); ?></label>
						<input class="hermes-input" name="email" id="email" type="email" value="<?php echo $email; ?>" />
					</p>

					<p>
						<label class="hermes-label" for="phone"><?php _e('Telephone', 'hermes_textdomain'); ?></label>
						<input class="hermes-input" name="phone" id="phone" type="tel" value="<?php echo $telephone;?>" />
					</p>

					<p>
						<label class="hermes-label" for="arrival"><?php _e('Date of Arrival', 'hermes_textdomain'); ?></label>
						<input class="hermes-input" name="arrival" id="arrival" type="date" value="<?php echo $arrival; ?>" />
					</p>
					
					<p>
						<label class="hermes-label" for="departure"><?php _e('Date of Departure', 'hermes_textdomain'); ?></label>
						<input class="hermes-input" name="departure" id="departure" type="date" value="<?php echo $departure; ?>" />
					</p>
					
					<p>
						<label class="hermes-label" for="adults"><?php _e('Adults', 'hermes_textdomain'); ?></label>
						<input class="hermes-input hermes-input-small" name="adults" id="adults" type="text" value="<?php echo $adults; ?>" />
					</p>

					<p>
						<label class="hermes-label" for="children"><?php _e('Children', 'hermes_textdomain'); ?></label>
						<input class="hermes-input hermes-input-small" name="children" id="children" type="text" value="<?php echo $children; ?>" />
					</p>
					
					<p>
						<label class="hermes-label" for="booking-comments"><?php _e('Comments', 'hermes_textdomain'); ?></label>
						<textarea class="hermes-input" name="booking-comments" id="booking-comments"><?php echo $comments; ?></textarea>
					</p>
															
					<p>
						<input type="submit" name="submit-booking" class="button purple" value="<?php _e('Send Request', 'hermes_textdomain'); ?>" />
					</p>

				</form><!-- #form-booking -->
			<?php endif; ?>
			
		</div><!-- .post-single -->
		
		<?php endwhile; ?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php } ?>

<?php if ($slide_class != 'disabled') { get_template_part('slideshow'); } ?>

<?php get_footer(); ?>