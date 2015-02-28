<?php

/*----------------------------------------------------------------------------------*/
/*  Hermes: TripAdvisor Widget
/*  Author: Dumitru Brinzan @ HermesThemes
/*----------------------------------------------------------------------------------*/


add_action('widgets_init', create_function('', 'return register_widget("hermes_tripadvisor");'));


	class hermes_tripadvisor extends WP_Widget {
		
		function hermes_tripadvisor() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'tripadvisor', 'description' => 'Display a TripAdvisor icon and link to your profile page.' );
	
			/* Widget control settings. */
			$control_ops = array( 'id_base' => 'hermes-tripadvisor' );
	
			/* Create the widget. */
			$this->WP_Widget( 'hermes-tripadvisor', 'Hermes: TripAdvisor Profile', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
			extract( $args );
	
			/* User-selected settings. */
			$title = apply_filters('widget_title', $instance['title'] );
			$pageurl = esc_url($instance['pageurl']);
			$widget_style = $instance['widget_style'];
			$new_window = $instance['new_window'];
			
			/* Before widget (defined by themes). */
			echo $before_widget;
			
			/* Title of widget (before and after defined by themes).
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			*/
			
			?>
			
			<div class="hermes-ta-widget hermes-ta-<?php echo $widget_style; ?>">
				<a href="<?php echo $pageurl; ?>" rel="external"<?php if ($new_window == 'on') { echo ' target="_blank"'; } ?>>
				<span class="hermes-ta-icon">
				<?php if ($widget_style == 'box') { ?><img src="<?php echo get_template_directory_uri(); ?>/images/icon_tripadvisor_24x24.png" width="24" height="24" class="hermes-icon-ta" alt="TripAdvisor Icon" /><?php } ?>
				<?php if ($widget_style == 'line') { ?><img src="<?php echo get_template_directory_uri(); ?>/images/icon_tripadvisor_16x16.png" width="16" height="16" class="hermes-icon-ta" alt="TripAdvisor Icon" /><?php } ?>
				</span>
				<span class="hermes-ta-title"><?php echo $title; ?></span>
				</a>
			</div><!-- hermes-ta-<?php echo $widget_style; ?> -->
			
			<?php

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			
            $instance = $old_instance;
	
			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['pageurl'] = esc_url($new_instance['pageurl']);
			$instance['widget_style'] = $new_instance['widget_style'];
			$instance['new_window'] = $new_instance['new_window'];
	
			return $instance;
		}
		
		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array( 'title' => 'View us on TripAdvisor', 'pageurl' => 'http://www.tripadvisor.com/', 'widget_style' => 'box', 'new_window' => 'on');
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget Title', 'hermes_textdomain'); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
			</p>
	
			<p>
				<label for="<?php echo $this->get_field_id( 'pageurl' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('TripAdvisor page URL', 'hermes_textdomain'); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'pageurl' ); ?>" name="<?php echo $this->get_field_name( 'pageurl' ); ?>" value="<?php echo $instance['pageurl']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
				<small>* Example of URL: <br />http://www.tripadvisor.com/reviews/</small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'widget_style' ); ?>"><?php _e('Widget Layout', 'hermes_textdomain'); ?>:</label>
				<select id="<?php echo $this->get_field_id( 'widget_style' ); ?>" name="<?php echo $this->get_field_name( 'widget_style' ); ?>">
					<option value="box"<?php if (!$instance['widget_style'] || $instance['widget_style'] == 'box') { echo ' selected="selected"';} ?>>Box</option>
					<option value="line"<?php if ($instance['widget_style'] == 'line') { echo ' selected="selected"';} ?>>Line</option>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" <?php if ($instance['new_window'] == 'on') { echo ' checked="checked"';  } ?> />
				<label for="<?php echo $this->get_field_id( 'new_window' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Open link in a new window', 'hermes_textdomain'); ?></label>
			</p>
	
			<?php
		}
	}
 ?>