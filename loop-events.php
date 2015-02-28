<?php 
global $hermes_options, $display_events;

$current_time = current_time('mysql');
list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '([^0-9])', $current_time );
$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;

if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) { 
	$paged = get_query_var('page');
} else { 
	$paged = 1;
}
			 
if (isset($display_events) && $display_events == 'Future') {
	$sign = '>';
	$eventsorder = 'ASC';
} else {
	$sign = '<';
	$eventsorder = 'DESC';
}

$meta_query = array(
	array(
		'key' => '_end_eventtimestamp',
		'value' => $current_timestamp,
		'compare' => $sign
	)
);

$args = array( 
	'post_type' => 'event',
	'meta_query' => $meta_query,
	'meta_key' => '_end_eventtimestamp',
	'orderby'=> 'meta_value_num',
	'order' => $eventsorder,
	'posts_per_page' => get_option('posts_per_page'),
	'paged' => $paged
);

query_posts($args);

// $events = new WP_Query( $args );

if (have_posts()) {
	$i = 0;
	?>

	<ul class="hermes-posts hermes-posts-archive hermes-events">
	
	<?php
	$i = 0;
	
	while ( have_posts() ) : the_post();
	unset($same_day,$same_time,$parentMeta); 
	$same_day = false;
	$same_time = false; 
	
	$parentMeta = get_post_custom();
	$event_start_day = $parentMeta['_start_day'][0];
	$event_start_month = $parentMeta['_start_month'][0];
	$event_start_year = $parentMeta['_start_year'][0];
	$event_end_day = $parentMeta['_end_day'][0];
	$event_end_month = $parentMeta['_end_month'][0];
	$event_end_year = $parentMeta['_end_year'][0];
	$event_start_hour = $parentMeta['_start_hour'][0];
	$event_start_minute = $parentMeta['_start_minute'][0];
	$event_end_hour = $parentMeta['_end_hour'][0];
	$event_end_minute = $parentMeta['_end_minute'][0];
	
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
	$classes = array('hermes-post','hermes-event');
	
	?>
		<li <?php post_class($classes); ?>>
	
			<?php
			get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
			?>
			
			<div class="post-content">
				<h2 class="title-post title-s"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hermes_textdomain' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
				<?php if ($metaDate) { ?>
				<p class="post-meta"><span class="meta-date"><?php echo $metaDate; ?></span></p><!-- .meta-date -->
				<?php } ?>
				<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
			</div><!-- end .post-excerpt -->

			<div class="cleaner">&nbsp;</div>
			
		</li><!-- end .hermes-post -->
		<?php endwhile; ?>
	
	</ul><!-- end .hermes-posts .hermes-posts-archive -->

	<?php get_template_part( 'pagination','taxonomy'); ?>

<?php 
} // if there are pages
wp_reset_query();
?>

<div class="cleaner">&nbsp;</div>