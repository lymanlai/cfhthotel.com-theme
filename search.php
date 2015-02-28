<?php get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include get_template_directory() . '/layout-vars.php';
?>

<div id="content" class="layout-half">

	<div class="wrapper wrapper-main">
	
		<div class="post-intro">
			<h1 class="title-page title-m"><?php _e('Search Results for', 'hermes_textdomain');?>: <strong><?php the_search_query(); ?></strong></h1>
		</div><!-- .post-intro -->

		<?php get_template_part('loop'); ?>

		<?php
		if (!have_posts()) { ?>
			
		<div class="post-single">
		
			<p><?php _e( 'Apologies, but the search query did not return any results.', 'hermes_textdomain' ); ?></p>
			
			<div class="cleaner">&nbsp;</div>
			
			<h4><?php _e( 'Browse Categories', 'hermes_textdomain' ); ?></h4>
			<ul>
				<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>	
			</ul>
		
			<h4><?php _e( 'Monthly Archives', 'hermes_textdomain' ); ?></h4>
			<ul>
				<?php wp_get_archives('type=monthly&show_post_count=1'); ?>	
			</ul>

			<div class="cleaner">&nbsp;</div>

		</div><!-- .post-single -->

		<?php }	?>
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php get_footer(); ?>