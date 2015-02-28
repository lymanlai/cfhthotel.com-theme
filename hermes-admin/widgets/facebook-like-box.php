<?php

/*----------------------------------------------------------------------------------*/
/*  Hermes: Facebook Like Box	
/*  Author: Dumitru Brinzan @ WPZOOM
/*----------------------------------------------------------------------------------*/


add_action('widgets_init', create_function('', 'return register_widget("hermes_facebook");'));


	class hermes_facebook extends WP_Widget {
		
		function hermes_facebook() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'facebook', 'description' => 'Display the Facebook Like Box for your Facebook page' );
	
			/* Widget control settings. */
			$control_ops = array( 'id_base' => 'hermes-facebook' );
	
			/* Create the widget. */
			$this->WP_Widget( 'hermes-facebook', 'Hermes: Facebook Like Box', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
			extract( $args );
	
			/* User-selected settings. */
			$title = apply_filters('widget_title', $instance['title'] );
			$pageurl = $instance['pageurl'];
			$width = $instance['width'];
			$height = $instance['height'];
			$bordercolor = $instance['bordercolor'];
			$color_scheme = $instance['color_scheme'];
			$show_faces = $instance['show_faces'];
			$show_stream = $instance['show_stream'];
			$show_header = $instance['show_header'];
			
			if ($show_faces == 'on') { $show_faces = 'true';} else { $show_faces = 'false'; }
			if ($show_stream == 'on') { $show_stream = 'true';} else { $show_stream = 'false'; }
			if ($show_header == 'on') { $show_header = 'true';} else { $show_header = 'false'; }
	
			/* Before widget (defined by themes). */
			echo $before_widget;
	
			/* Title of widget (before and after defined by themes). */
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) {return;}
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-like-box" data-href="<?php echo $pageurl; ?>" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>"<?php if ($color_scheme == 'dark') { echo ' data-colorscheme="dark" '; } ?>data-show-faces="<?php echo $show_faces; ?>" data-border-color="#<?php echo $bordercolor; ?>" data-stream="<?php echo $show_stream; ?>" data-header="<?php echo $show_header; ?>"></div>
<?php

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			
            $instance = $old_instance;
	
			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['pageurl'] = $new_instance['pageurl'];
			$instance['width'] = $new_instance['width'];
			$instance['height'] = $new_instance['height'];
			$instance['bordercolor'] = $new_instance['bordercolor'];
			$instance['color_scheme'] = $new_instance['color_scheme'];
			$instance['show_faces'] = $new_instance['show_faces'];
			$instance['show_stream'] = $new_instance['show_stream'];
			$instance['show_header'] = $new_instance['show_header'];
			
	
			return $instance;
		}
		
		function form( $instance ) {
	
			/* Set up some default widget settings. */
			$defaults = array( 'title' => 'Like us on Facebook', 'pageurl' => 'http://www.facebook.com/hermesthemes', 'width' => 300, 'bordercolor' => 'e4e4e4', 'show_faces' => 'on', 'show_stream' => 'off', 'show_header' => 'off' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget Title', 'hermes_textdomain'); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
			</p>
	
			<p>
				<label for="<?php echo $this->get_field_id( 'pageurl' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Facebook page URL', 'hermes_textdomain'); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'pageurl' ); ?>" name="<?php echo $this->get_field_name( 'pageurl' ); ?>" value="<?php echo $instance['pageurl']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
				<small>* Example of page URL: <br />http://www.facebook.com/hermes<br />You can get your page username here: <br /><a href="https://www.facebook.com/username/" target="_blank">https://www.facebook.com/username/</a></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'width' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Box Width', 'hermes_textdomain'); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
				<small>* Default: <strong>300</strong> </small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'height' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Box Height', 'hermes_textdomain'); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'bordercolor' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Box Border Color', 'hermes_textdomain'); ?>:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'bordercolor' ); ?>" name="<?php echo $this->get_field_name( 'bordercolor' ); ?>" value="<?php echo $instance['bordercolor']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
				<small>* Default: <strong>e4e4e4</strong> </small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'color_scheme' ); ?>"><?php _e('Color Scheme', 'hermes_textdomain'); ?>:</label>
				<select id="<?php echo $this->get_field_id( 'color_scheme' ); ?>" name="<?php echo $this->get_field_name( 'color_scheme' ); ?>">
					<option value="light"<?php if (!$instance['color_scheme'] || $instance['color_scheme'] == 'light') { echo ' selected="selected"';} ?>>Light</option>
					<option value="dark"<?php if ($instance['color_scheme'] == 'dark') { echo ' selected="selected"';} ?>>Dark</option>
				</select>
			</p>
			
			<p>
				<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" <?php if ($instance['show_faces'] == 'on') { echo ' checked="checked"';  } ?> />
				<label for="<?php echo $this->get_field_id( 'show_faces' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Show Faces', 'hermes_textdomain'); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" <?php if ($instance['show_stream'] == 'on') { echo ' checked="checked"';  } ?> />
				<label for="<?php echo $this->get_field_id( 'show_stream' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Show Stream', 'hermes_textdomain'); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" <?php if ($instance['show_header'] == 'on') { echo ' checked="checked"';  } ?> />
				<label for="<?php echo $this->get_field_id( 'show_header' ); ?>" style="font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Show Header', 'hermes_textdomain'); ?></label>
			</p>
	
			<?php
		}
	}
 ?>