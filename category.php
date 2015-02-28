<?php get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include get_template_directory() . '/layout-vars.php';
?>

<div id="content" class="layout-half">

	<div class="wrapper wrapper-main">
	
		<div class="post-intro">
			<h1 class="title-page title-m"><?php single_cat_title(); ?></h1>
		</div><!-- .post-intro -->

		<?php if (category_description()) { ?>
		<div class="post-single">
		
			<?php echo category_description(); ?>
			
			<div class="cleaner">&nbsp;</div>
			
		</div><!-- .post-single -->

		<?php } ?>

		<?php get_template_part('loop'); ?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php get_footer(); ?>