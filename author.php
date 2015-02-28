<?php get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include get_template_directory() . '/layout-vars.php';
?>

<div id="content" class="layout-half">

	<div class="wrapper wrapper-main">
	
		<?php $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); ?>
		
		<div class="post-intro">
			<h1 class="title-page title-m"><?php _e('Posts by', 'hermes_textdomain');?> <span><?php echo $curauth->display_name; ?></span></h1>
		</div><!-- .post-intro -->

		<?php get_template_part('loop'); ?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php get_footer(); ?>