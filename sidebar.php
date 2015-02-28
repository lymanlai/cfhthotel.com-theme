<?php if (is_active_sidebar('sidebar')) { ?>
	<?php
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?> <?php endif;
	?>
	<div class="cleaner">&nbsp;</div>
<?php } ?>