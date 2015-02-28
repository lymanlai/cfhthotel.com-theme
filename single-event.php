<?php get_header();

// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

while (have_posts()) : the_post();

$post_meta = get_post_custom($post->ID);

$event_start_day = $post_meta['_start_day'][0];
$event_start_month = $post_meta['_start_month'][0];
$event_start_year = $post_meta['_start_year'][0];
$event_end_day = $post_meta['_end_day'][0];
$event_end_month = $post_meta['_end_month'][0];
$event_end_year = $post_meta['_end_year'][0];
$event_start_hour = $post_meta['_start_hour'][0];
$event_start_minute = $post_meta['_start_minute'][0];
$event_end_hour = $post_meta['_end_hour'][0];
$event_end_minute = $post_meta['_end_minute'][0];

$metaDateStart = "$event_start_day/$event_start_month/$event_start_year";
$metaDateEnd = "$event_end_day/$event_end_month/$event_end_year";
if ($event_start_hour != '00' && $event_start_minute != '00') {
	$metaTimeStart = "$event_start_hour:$event_start_minute";
}
$metaTimeEnd = "$event_end_hour:$event_end_minute";
$isoDateStart = "$event_start_year-$event_start_month-$event_start_day";
$isoDateEnd = "$event_end_year-$event_end_month-$event_end_day";
$datetime_format = get_option('date_format') . " " . get_option('time_format');  
$date_default_start = date($datetime_format, mktime($event_start_hour, $event_start_minute, 0, $event_start_month, $event_start_day, $event_start_year));
$date_default_end = date($datetime_format, mktime($event_end_hour, $event_end_minute, 0, $event_end_month, $event_end_day, $event_end_year));

if ($date_default_end && ($date_default_end != $date_default_start)) {
	$metaDate = "$date_default_start - $date_default_end";
}
else {
	$metaDate = "$date_default_start";
}
endwhile;

include("layout-vars.php");
?>

<?php if ($page_class != 'layout-nocontent') { ?>
<div id="content" class="<?php echo $page_class;?>">

	<div class="wrapper wrapper-main">
	
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="post-intro">
			<h1 class="title-page title-m"><?php the_title(); ?></h1>
			<?php if ($metaDate) { ?>
			<p class="post-meta"><span class="meta-date"><?php echo $metaDate; ?></span></p><!-- .meta-date -->
			<?php } ?>
			<?php edit_post_link( __('Edit event', 'hermes_textdomain'), '<p class="post-meta">', '</p>'); ?>
		</div><!-- .post-intro -->

		<div class="post-single">

			<?php the_content(); ?>
			<div class="cleaner">&nbsp;</div>
			
			<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'hermes_textdomain').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php the_tags( '<p class="post-meta"><strong>'.__('Tags', 'hermes_textdomain').':</strong> ', ', ', '</p>'); ?>
			
		</div><!-- .post-single -->
		
		<?php endwhile; ?>

		<?php if ($hermes_options['hermes_social_sharing_posts'] == 1) { ?>
		
			<?php get_template_part('social-sharing', 'post'); ?>
		
		<?php } ?>

		<?php if ($hermes_options['hermes_post_comments'] == 1) { ?>
		
		<div id="hermes-comments">
			<?php comments_template(); ?>  
		</div><!-- end #comments -->

		<?php } ?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php } ?>

<?php if ($slide_class != 'disabled') { get_template_part('slideshow'); } ?>

<?php get_footer(); ?>