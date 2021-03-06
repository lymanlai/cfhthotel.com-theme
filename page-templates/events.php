<?php
/**
 * Template Name: Events (Future)
 */

get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include get_template_directory() . '/layout-vars.php';

while (have_posts()) : the_post();
$hermes_layout = strtolower(get_post_meta($post->ID, 'hermes_rooms_layout', true));
$display_events = $post_meta['hermes_events_type'][0];
endwhile;
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
			
			<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'hermes_textdomain').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			
		</div><!-- .post-single -->
		
		<?php endwhile; ?>

		<?php get_template_part('loop-events'); ?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php } ?>

<?php if ($slide_class != 'disabled') { get_template_part('slideshow'); } ?>

<?php get_footer(); ?>