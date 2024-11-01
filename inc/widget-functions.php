<?php 
/*
xBooster Social Plugin Widget Classes
*/
add_action( 'widgets_init', create_function('', 'return register_widget("Xbooster_Social_Profiles_Widget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("Xbooster_Social_Share_Widget");') );

class Xbooster_Social_Profiles_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'xbooster_social_profiles_widget', // Base ID
			__('xBooster Social Profiles', 'xboostersocial'), // Name
			array( 'description' => __( 'Displays social profiles icons which defined in xBooster Plugin settings.', 'xboostersocial' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {

		extract( $args );

		$title 						= apply_filters('widget_title', $instance['title']);
		$display_title 				= $instance['display_title'];
		$display_counter 			= $instance['display_counter'];
		$icon_size	 				= $instance['icon_size'];


		$xbooster_admin_social_profiles = get_option('xbooster_social_plugin_snps'); 
		$xbooster_admin_social_profiles_decoded = json_decode($xbooster_admin_social_profiles);
	

		
		$render = '<ul class="xbsp_widget_container">';
		
		$sp_count = 0;
		foreach ($xbooster_admin_social_profiles_decoded as $key => $value) {
			
			$nonce = wp_create_nonce("xbooster_ajax_follow_nonce");
			$link = admin_url('admin-ajax.php?action=xbooster_ajax&dotype=follow&network='.$key.'&nonce='.$nonce);
			
			if( $value->is_enabled == "true" ) {
				$go_key = 'xbooster_social_plugin_snp_counter_' . $key;
				$sp_count += get_option($go_key);


				if( $value->custom_icon != "" ){

					$display_icon = $value->custom_icon;
				} else {

					$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );

				}



				// if ( get_option('permalink_structure') ) { echo 'permalinks enabled'; }
				$render .= '<li class="xbooster_social_widget_item"><a class="xbooster_follow" data-do="follow" data-nonce="' . $nonce . '" data-network="' . $key . '"  href="'.$value->profile_url.'" target="_blank"><img  class="xboostericon '.$key.'" src="' . $display_icon  . '" style="width:'.$icon_size.'" alt="'. $value->title .'"></a></li>';

			}
			
		}
		if ( $display_counter == "ON" ){
			$render .='<li class="bubble"><span class="xbooster_follow_counter">'.$this->xbooster_count_format($sp_count).'</span></li>';
		}
		$render .= '</ul><div style="clear:both;"></div>';

		$xbooster_widget_before = $before_widget;
   		$xbooster_widget_before .= '';
		$xbooster_widget_after = $after_widget;
		$xbooster_widget_after .= '';
		$xbooster_title = '';
		if( "ON" == $display_title ){
			if ( $title ) {
				$xbooster_title .= $before_title . $title . $after_title;
			}
		}


		echo $xbooster_widget_before . $xbooster_title . $render .  $xbooster_widget_after;
		 
	}

 	public function form( $instance ) {
		if( $instance ) {
			$title 				= esc_attr($instance['title']);
			$display_title		= esc_attr($instance['display_title']);
			$display_counter	= esc_attr($instance['display_counter']);
			$icon_size			= esc_attr($instance['icon_size']);
			
		} else {
			$title 				= '';
			$display_title		= '';
			$display_counter	= '';
			$icon_size	= '';

		}

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'xboostersocial'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon Size (with px or em etc)', 'xboostersocial'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('icon_size'); ?>" name="<?php echo $this->get_field_name('icon_size'); ?>" type="text" value="<?php echo $icon_size; ?>" />
		</p>
		<?php 


		if ( isset($display_title) && ( "ON" == $display_title ) ) {
			$display_title_checked = ' checked="checked" ';				
		} else {
			$display_title_checked = ' ';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('display_title'); ?>"><?php _e('Display Title', 'xboostersocial'); ?></label>
			<input id="<?php echo $this->get_field_id('display_title'); ?>" name="<?php echo $this->get_field_name('display_title'); ?>" type="checkbox" value="ON" <?php echo $display_title_checked; ?>/>
		</p>

		<?php 


		if ( isset($display_counter) && ( "ON" == $display_counter ) ) {
			$display_counter_checked = ' checked="checked" ';				
		} else {
			$display_counter_checked = ' ';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('display_counter'); ?>"><?php _e('Display Counter', 'xboostersocial'); ?></label>
			<input id="<?php echo $this->get_field_id('display_counter'); ?>" name="<?php echo $this->get_field_name('display_counter'); ?>" type="checkbox" value="ON" <?php echo $display_counter_checked; ?>/>
		</p>
	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance 					= $old_instance;
      	// Fields

      	$instance['title'] 				= $new_instance['title'];
		$instance['display_title'] 		= $new_instance['display_title'];
		$instance['display_counter'] 	= $new_instance['display_counter'];
		$instance['icon_size'] 			= $new_instance['icon_size'];
		

     	return $instance;
	}

	static function xbooster_count_format($count) {
	    if($count >= 1000000000 ){

	    	$newcount = round($count/1000000000,2);
	    	$suffix = "b";
	    } else if ( $count >= 1000000 ){
	       $newcount = round($count/1000000,2);
	       $suffix = "m";
	    } else if ($count >= 1000) {
	       $newcount = round($count/1000, 2);
	       $suffix = "k";   // NB: you will want to round this
	    } else {
	     	$newcount = $count;
	     	$suffix = "";
	    }

	    $returntext = $newcount.$suffix;

	    return $returntext;
	}
}

class Xbooster_Social_Share_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'xbooster_social_share_widget', // Base ID
			__('xBooster Social Share', 'xbooster_social_plugin'), // Name
			array( 'description' => __( 'Displays social sharing icons which defined in xBooster Plugin settings.', 'xboostersocial' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title 						= apply_filters('widget_title', $instance['title']);
		$display_title 				= $instance['display_title'];
		$display_counter 			= $instance['display_counter'];
		$icon_size	 				= $instance['icon_size'];


		$post_id = $GLOBALS['post']->ID;


		$xbooster_admin_social_share = get_option('xbooster_social_plugin_share_ns'); 
		$xbooster_admin_social_share_decoded = json_decode($xbooster_admin_social_share);
		
		
		$render = '<ul class="xbsp_widget_container">';
		
		$sp_count = 0;
		foreach ($xbooster_admin_social_share_decoded as $key => $value) {
			
			$nonce = wp_create_nonce("xbooster_ajax_share_nonce");
			$link = admin_url('admin-ajax.php?action=xbooster_ajax&dotype=share&network='.$key.'&post_id=' .$post_id. '&nonce='.$nonce);
			
			if( $value->is_enabled == "true" ) {
				$go_key = 'xbooster_social_plugin_sns_counter_' . $post_id . '_' . $key;
				$sp_count += get_option($go_key);


				if( $value->custom_icon != "" ){

					$display_icon = $value->custom_icon;
				} else {

					$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );

				}



				// if ( get_option('permalink_structure') ) { echo 'permalinks enabled'; }
				$render .= '<li>'.shareapi($key,$icon_size,$value->title,$display_icon,$nonce,$post_id).'</li>';

			}
			
		}
		if ( $display_counter == "ON" ){
			$render .='<li class="bubble"><span class="xbooster_share_counter">'.$this->xbooster_count_format($sp_count).'</span></li>';
		}
		$render .= '</ul><div style="clear:both;"></div>';

		$xbooster_widget_before = $before_widget;
   		$xbooster_widget_before .= '';
		$xbooster_widget_after = $after_widget;
		$xbooster_widget_after .= '';
		$xbooster_title = '';
		if( "ON" == $display_title ){
			if ( $title ) {
				$xbooster_title .= $before_title .  $title . $after_title;
			}
		}


		echo $xbooster_widget_before . $xbooster_title . $render .  $xbooster_widget_after;
		 
	}

 	public function form( $instance ) {
		if( $instance ) {
			$title 				= esc_attr($instance['title']);
			$display_title		= esc_attr($instance['display_title']);
			$display_counter	= esc_attr($instance['display_counter']);
			$icon_size			= esc_attr($instance['icon_size']);
			
		} else {
			$title 				= '';
			$display_title		= '';
			$display_counter	= '';
			$icon_size	= '';

		}

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'xboostersocial'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon Size (with px or em etc)', 'xboostersocial'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('icon_size'); ?>" name="<?php echo $this->get_field_name('icon_size'); ?>" type="text" value="<?php echo $icon_size; ?>" />
		</p>
		<?php 


		if ( isset($display_title) && ( "ON" == $display_title ) ) {
			$display_title_checked = ' checked="checked" ';				
		} else {
			$display_title_checked = ' ';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('display_title'); ?>"><?php _e('Display Title', 'xboostersocial'); ?></label>
			<input id="<?php echo $this->get_field_id('display_title'); ?>" name="<?php echo $this->get_field_name('display_title'); ?>" type="checkbox" value="ON" <?php echo $display_title_checked; ?>/>
		</p>

		<?php 


		if ( isset($display_counter) && ( "ON" == $display_counter ) ) {
			$display_counter_checked = ' checked="checked" ';				
		} else {
			$display_counter_checked = ' ';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('display_counter'); ?>"><?php _e('Display Counter', 'xboostersocial'); ?></label>
			<input id="<?php echo $this->get_field_id('display_counter'); ?>" name="<?php echo $this->get_field_name('display_counter'); ?>" type="checkbox" value="ON" <?php echo $display_counter_checked; ?>/>
		</p>
	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance 					= $old_instance;
      	// Fields

      	$instance['title'] 				= $new_instance['title'];
		$instance['display_title'] 		= $new_instance['display_title'];
		$instance['display_counter'] 	= $new_instance['display_counter'];
		$instance['icon_size'] 			= $new_instance['icon_size'];
		

     	return $instance;
	}

	static function xbooster_count_format($count) {
	    if($count >= 1000000000 ){

	    	$newcount = round($count/1000000000,2);
	    	$suffix = "b";
	    } else if ( $count >= 1000000 ){
	       $newcount = round($count/1000000,2);
	       $suffix = "m";
	    } else if ($count >= 1000) {
	       $newcount = round($count/1000, 2);
	       $suffix = "k";   // NB: you will want to round this
	    } else {
	     	$newcount = $count;
	     	$suffix = "";
	    }

	    $returntext = $newcount.$suffix;

	    return $returntext;
	}
}

?>