<?php get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include get_template_directory() . '/layout-vars.php';
?>

<div id="content" class="layout-half">

	<div class="wrapper wrapper-main">
	
		<div class="post-intro">
			<h1 class="title-page title-m"><?php /* tag archive */ if( is_tag() ) { ?><?php _e('Post Tagged with:', 'hermes_textdomain'); ?> "<?php single_tag_title(); ?>"
			<?php /* daily archive */ } elseif (is_day()) { ?><?php _e('Archive for', 'hermes_textdomain'); ?> <?php the_time('F jS, Y'); ?>
			<?php /* search archive */ } elseif (is_month()) { ?><?php _e('Archive for', 'hermes_textdomain'); ?> <?php the_time('F, Y'); ?>
			<?php /* yearly archive */ } elseif (is_year()) { ?><?php _e('Archive for', 'hermes_textdomain'); ?> <?php the_time('Y'); ?>
			<?php } ?></h1>
		</div><!-- .post-intro -->

		<?php get_template_part('loop'); ?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php get_footer(); ?>