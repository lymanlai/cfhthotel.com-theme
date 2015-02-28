<?php get_header();

// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 

include("layout-vars.php");
?>

<div id="content" class="layout-half">

	<div class="wrapper wrapper-main">
	
		<div class="post-intro">
			<h1 class="title-page title-m"><?php _e('Page not found', 'hermes_textdomain'); ?></h1>
		</div><!-- .post-intro -->

		<div class="post-single">

			<p><?php _e( 'Apologies, but the requested page cannot be found. Perhaps searching will help find a related page.', 'hermes_textdomain' ); ?></p>
			
			<div class="cleaner">&nbsp;</div>
			
			<div class="divider divider-notop">&nbsp;</div>
			
			<h3 class="title-s"><?php _e( 'Browse Categories', 'hermes_textdomain' ); ?></h3>
			<ul>
				<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>	
			</ul>
		
			<h3 class="title-s"><?php _e( 'Monthly Archives', 'hermes_textdomain' ); ?></h3>
			<ul>
				<?php wp_get_archives('type=monthly&show_post_count=1'); ?>	
			</ul>
			<div class="cleaner">&nbsp;</div>
			
		</div><!-- .post-single -->
	
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php get_footer(); ?>