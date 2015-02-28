<ul class="hermes-posts hermes-posts-archive">
	
	<?php while (have_posts()) : the_post(); unset($prev); $m++; ?>

	<li <?php post_class('hermes-post'); ?>>

		<?php
		get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
		?>
		
		<div class="post-content">
			<h2 class="title-post title-s"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hermes_textdomain' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
			<p class="post-meta"><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php printf( __('%s', 'hermes_textdomain'), the_time(get_option('date_format'))); ?></time> / <span class="category"><?php the_category(', '); ?></span></p>
			<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
		</div><!-- end .post-excerpt -->

		<div class="cleaner">&nbsp;</div>
		
	</li><!-- end .hermes-post -->
	<?php endwhile; ?>
	
</ul><!-- end .hermes-posts .hermes-posts-archive -->

<?php get_template_part( 'pagination'); ?>