<?php get_header();

// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include("layout-vars.php");
?>

<?php if ($page_class != 'layout-nocontent') { ?>
<div id="content" class="<?php echo $page_class;?>">

	<div class="wrapper wrapper-main">
	
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="post-intro">
			<h1 class="title-page title-m"><?php the_title(); ?></h1>
			<p class="post-meta"><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php the_time(get_option('date_format')); ?></time> / <span class="category"><?php the_category(', '); ?></span></p>
			<?php edit_post_link( __('Edit post', 'hermes_textdomain'), '<p class="post-meta">', '</p>'); ?>
		</div><!-- .post-intro -->

		<div class="post-single">

			<?php the_content(); ?>
			<div class="cleaner">&nbsp;</div>
			
			<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'hermes_textdomain').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php the_tags( '<p class="post-meta"><strong>'.__('Tags', 'hermes_textdomain').':</strong> ', ', ', '</p>'); ?>
			
		</div><!-- .post-single -->
		
		<?php endwhile; ?>

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