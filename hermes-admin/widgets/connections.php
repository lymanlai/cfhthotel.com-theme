<?php

/*------------------------------------------*/
/* Hermes: Connections						*/
/*------------------------------------------*/
 
add_action('widgets_init', create_function('', 'return register_widget("hermes_widget_connections");'));

class hermes_widget_connections extends WP_Widget {
	
	function hermes_widget_connections() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hermes-connections', 'description' => 'Display links to popular Social Networks, as well as action buttons, such as RSS, Skype, etc.' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'hermes-widget-connections' );

		/* Create the widget. */
		$this->WP_Widget( 'hermes-widget-connections', 'Hermes: Connections', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title 				= apply_filters('widget_title', $instance['title'] );
		$new_window 		= $instance['new_window'];
		$s_facebook 		= $instance['s_facebook'];
		$s_feedburner 		= $instance['s_feedburner'];
		$s_foursquare 		= $instance['s_foursquare'];
		$s_googleplus 		= $instance['s_googleplus'];
		$s_linkedin 		= $instance['s_linkedin'];
		$s_pinterest 		= $instance['s_pinterest'];
		$s_rss		 		= $instance['s_rss'];
		$s_skype	 		= $instance['s_skype'];
		$s_tripadvisor 		= $instance['s_tripadvisor'];
		$s_twitter	 		= $instance['s_twitter'];
		$s_yelp		 		= $instance['s_yelp'];
		$s_youtube	 		= $instance['s_youtube'];

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		echo'<ul class="hermes-connect">';
		
			$s = 0;
		
			if ($s_facebook) { 
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_facebook; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-facebook" alt="Facebook icon" />
					<span class="social-title"><?php _e('Like us on Facebook','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_twitter) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="http://twitter.com/<?php echo $s_twitter; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-twitter" alt="Twitter icon" />
					<span class="social-title"><?php _e('Follow on Twitter','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_foursquare) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_foursquare; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-foursquare" alt="Foursquare icon" />
					<span class="social-title"><?php _e('Check us on Foursquare','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_linkedin) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_linkedin; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-linkedin" alt="LinkedIn icon" />
					<span class="social-title"><?php _e('Connect on LinkedIn','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_rss) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_rss; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-rss" alt="RSS icon" />
					<span class="social-title"><?php _e('Subscribe to RSS','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_feedburner) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_feedburner; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-feedburner" alt="Feedburner icon" />
					<span class="social-title"><?php _e('RSS via Feedburner','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_tripadvisor) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_tripadvisor; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-tripadvisor" alt="TripAdvisor icon" />
					<span class="social-title"><?php _e('TripAdvisor Reviews','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_yelp) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_yelp; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-yelp" alt="Yelp icon" />
					<span class="social-title"><?php _e('Yelp Reviews','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_youtube) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_youtube; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-youtube" alt="Youtube icon" />
					<span class="social-title"><?php _e('Check us on Youtube','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_googleplus) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_googleplus; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-googleplus" alt="Google+ icon" />
					<span class="social-title"><?php _e('Check us on Google+','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_pinterest) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="<?php echo $s_pinterest; ?>" rel="external,nofollow"<?php if ($new_window == 'on') { echo' target="_blank"'; } ?>><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-pinterest" alt="Pinterest icon" />
					<span class="social-title"><?php _e('Check us on Pinterest','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
			if ($s_skype) {
				$s++; if (($s % 2) == 1) { $newline = true; } else { $newline = false; }
			?>
				<li class="hermes-social<?php if ($newline) { echo ' hermes-social-clear'; } ?>">
					<a href="skype:<?php echo $s_skype; ?>?chat" rel="external,nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/x.gif" width="32" height="32" class="hermes-icon-social icon-skype" alt="Skype icon" />
					<span class="social-title"><?php _e('Chat on Skype','hermes_textdomain'); ?></span></a>
				</li><!-- end .hermes-social -->
			<?php
			}
		
		echo'</ul><!-- end .hermes-connect -->';

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['new_window'] 	= strip_tags( $new_instance['new_window'] );
		$instance['s_facebook'] 	= strip_tags( $new_instance['s_facebook'] );
		$instance['s_feedburner'] 	= strip_tags( $new_instance['s_feedburner'] );
		$instance['s_foursquare'] 	= strip_tags( $new_instance['s_foursquare'] );
		$instance['s_googleplus'] 	= strip_tags( $new_instance['s_googleplus'] );
		$instance['s_linkedin'] 	= strip_tags( $new_instance['s_linkedin'] );
		$instance['s_pinterest'] 	= strip_tags( $new_instance['s_pinterest'] );
		$instance['s_rss'] 			= strip_tags( $new_instance['s_rss'] );
		$instance['s_skype'] 		= strip_tags( $new_instance['s_skype'] );
		$instance['s_tripadvisor'] 	= strip_tags( $new_instance['s_tripadvisor'] );
		$instance['s_twitter'] 		= strip_tags( $new_instance['s_twitter'] );
		$instance['s_yelp'] 		= strip_tags( $new_instance['s_yelp'] );
		$instance['s_youtube'] 		= strip_tags( $new_instance['s_youtube'] );

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Widget Title', 'new_window' => 'off', 's_facebook' => 'http://www.facebook.com/hermesthemes/', 's_twitter' => 'hermesthemes');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Widget Title', 'hermes_textdomain'); ?>:</label><br />
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" <?php if ($instance['new_window'] == 'on') { echo ' checked="checked"';  } ?> /> 
			<label for="<?php echo $this->get_field_id('new_window'); ?>" style="font-size: 11px;"><?php _e('Enable this to open links in new windows', 'hermes_textdomain'); ?></label>
		</p>
		
		<hr style="height: 1px; line-height: 1px; font-size: 1px; border: none; border-top: solid 1px #ccc; margin: 10px 0;" />		

		<p style="color: #01aef0; font-size: 11px; line-height: 17px; ">Fill in only the fields you need. <br />The ones that you leave blank will not appear on the website.</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_facebook' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Facebook Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_facebook' ); ?>" name="<?php echo $this->get_field_name( 's_facebook' ); ?>" value="<?php echo $instance['s_facebook']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_feedburner' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Feedburner RSS URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_feedburner' ); ?>" name="<?php echo $this->get_field_name( 's_feedburner' ); ?>" value="<?php echo $instance['s_feedburner']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_foursquare' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Foursquare Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_foursquare' ); ?>" name="<?php echo $this->get_field_name( 's_foursquare' ); ?>" value="<?php echo $instance['s_foursquare']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_googleplus' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Google+ Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_googleplus' ); ?>" name="<?php echo $this->get_field_name( 's_googleplus' ); ?>" value="<?php echo $instance['s_googleplus']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_linkedin' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('LinkedIn Profile URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_linkedin' ); ?>" name="<?php echo $this->get_field_name( 's_linkedin' ); ?>" value="<?php echo $instance['s_linkedin']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_pinterest' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Pinterest Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_pinterest' ); ?>" name="<?php echo $this->get_field_name( 's_pinterest' ); ?>" value="<?php echo $instance['s_pinterest']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_rss' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('RSS URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_rss' ); ?>" name="<?php echo $this->get_field_name( 's_rss' ); ?>" value="<?php echo $instance['s_rss']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_skype' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Skype Account ID', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_skype' ); ?>" name="<?php echo $this->get_field_name( 's_skype' ); ?>" value="<?php echo $instance['s_skype']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_tripadvisor' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('TripAdvisor Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_tripadvisor' ); ?>" name="<?php echo $this->get_field_name( 's_tripadvisor' ); ?>" value="<?php echo $instance['s_tripadvisor']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_twitter' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Twitter Account ID', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_twitter' ); ?>" name="<?php echo $this->get_field_name( 's_twitter' ); ?>" value="<?php echo $instance['s_twitter']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_yelp' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Yelp Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_yelp' ); ?>" name="<?php echo $this->get_field_name( 's_yelp' ); ?>" value="<?php echo $instance['s_yelp']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 's_youtube' ); ?>" style="display: block; font-size: 11px; font-weight: bold; margin: 0 0 5px;"><?php _e('Youtube Page URL', 'hermes_textdomain'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 's_youtube' ); ?>" name="<?php echo $this->get_field_name( 's_youtube' ); ?>" value="<?php echo $instance['s_youtube']; ?>" type="text" class="widefat" style="padding: 7px 5px; font-size: 11px;" />
		</p>		
		<?php
	}
}
?>