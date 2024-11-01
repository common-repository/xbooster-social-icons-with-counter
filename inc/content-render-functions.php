<?php
add_filter( 'the_content', 'xbooster_the_content' );


function xbooster_the_content($content) {


	$post_id = $GLOBALS['post']->ID;

	$display_options = get_option('xbooster_display_options');
	$display_options = json_decode($display_options);

	$social_network_profiles = get_option('xbooster_social_plugin_snps');
	$social_network_profiles = json_decode($social_network_profiles);

	$social_network_shares = get_option('xbooster_social_plugin_share_ns');
	$social_network_shares = json_decode($social_network_shares);


	$xbooster_render_content_before = "";
	$xbooster_render_content_after = "";
	$xbooster_render_scontent_before = "";
	$xbooster_render_scontent_after = "";
	$xbooster_render = "";
	$xbooster_render_overlay_left = "";
	$xbooster_render_overlay_right = ""; 
	$xbooster_render_soverlay_left = "";
	$xbooster_render_soverlay_right = "";

	/* Social Profiles Before & After Content*/
	if( $display_options->sp->content == "before" ){

		$xbooster_render_content_before = xbooster_sp_render_for_content($display_options,$social_network_profiles,'before');
		
	} else if( $display_options->sp->content == "after" ){

		$xbooster_render_content_after = xbooster_sp_render_for_content($display_options,$social_network_profiles,'after');
	} else if ( $display_options->sp->content == "both" ){

		$xbooster_render_content_before = xbooster_sp_render_for_content($display_options,$social_network_profiles,'both');
		$xbooster_render_content_after = $xbooster_render_content_before;

	} else {

		$xbooster_render_content_before = "";
		$xbooster_render_content_after = "";
	}

	/* Social Share Before & After Content */
	if( $display_options->ss->content == "before" ){

		$xbooster_render_scontent_before = xbooster_ss_render_for_content($display_options,$social_network_shares,'before',$post_id);
		
	} else if( $display_options->ss->content == "after" ){

		$xbooster_render_scontent_after = xbooster_ss_render_for_content($display_options,$social_network_shares,'after',$post_id);
	} else if ( $display_options->ss->content == "both" ){

		$xbooster_render_scontent_before = xbooster_ss_render_for_content($display_options,$social_network_shares,'both',$post_id);
		$xbooster_render_scontent_after = $xbooster_render_scontent_before;

	} else {

		$xbooster_render_scontent_before = "";
		$xbooster_render_scontent_after = "";
	}


	/* Social Profile Overlay Left & Right */

	if( $display_options->sp->overlay == "left" ){

		$xbooster_render_overlay_left = xbooster_sp_render_overlay('left',$social_network_profiles,$display_options);
		
	} else if ( $display_options->sp->overlay == "right" ) {

		$xbooster_render_overlay_right = xbooster_sp_render_overlay('right',$social_network_profiles,$display_options);

	} else {

		$xbooster_render_overlay_left = "";
		$xbooster_render_overlay_right = "";

	}

/* Social Share  Overlay Left & Right */

	if( $display_options->ss->overlay == "left" ){

		$xbooster_render_soverlay_left = xbooster_ss_render_overlay('left',$social_network_shares,$display_options);
		
	} else if ( $display_options->ss->overlay == "right" ) {

		$xbooster_render_soverlay_right = xbooster_ss_render_overlay('right',$social_network_shares,$display_options);

	} else {

		$xbooster_render_soverlay_left = "";
		$xbooster_render_soverlay_right = "";

	}


	$newcontent = $xbooster_render_content_before.$xbooster_render_scontent_before.$content.$xbooster_render_content_after.$xbooster_render_scontent_after.$xbooster_render_overlay_left.$xbooster_render_overlay_right.$xbooster_render_soverlay_left.$xbooster_render_soverlay_right;

	return $newcontent;
}


function xbooster_sp_render_for_content($display_options,$social_network_profiles,$location){

	$xbooster_render = '<!-- xBooster Social Profiles '.$location.' Content --><div class="xbooster_post_before"><ul class="xbsp_container">';
	if ( isset ($display_options->sp->text) ){

		if( strlen($display_options->sp->text) > 0) {
			$xbooster_render .= '<li class="xbsp_act"><span>'.$display_options->sp->text.'</span></li>';
		}
	}
	$sp_count = 0;
	foreach ($social_network_profiles as $key => $value) {

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
			$xbooster_render .= '
			<li>
			<a class="xbooster_follow" data-do="follow" data-nonce="' . $nonce . '" data-network="' . $key . '"  href="'.$value->profile_url.'" target="_blank">
			<img  class="xboostericon '.$key.'" src="' . $display_icon  . '" style="width:'.$display_options->sp->content_icon.'" alt="'. $value->title .'">
			</a>
			</li>';

		}

	}
	if ( $display_options->sp->counter == "yes" ){
		$xbooster_render .='<li class="bubble"><span class="xbooster_follow_counter">'.xbooster_count_format_sec($sp_count).'</span></li>';
	}
	$xbooster_render .= '</ul></div><div style="clear:both;"></div><!-- xBooster Social Profiles '.$location.' Content -->';

	return $xbooster_render;

}

function xbooster_ss_render_for_content ($display_options,$social_network_shares,$location,$post_id){

	$xbooster_render = '<!-- xBooster Share '.$location.' Content --><div class="xbooster_post_before"><ul class="xbsp_container">';
	if ( isset ($display_options->ss->text) ){

		if( strlen($display_options->ss->text) > 0) {
			$xbooster_render .= '<li class="xbsp_act"><span>'.$display_options->ss->text.'</span></li>';
		}
	}
	$sp_count = 0;
	foreach ($social_network_shares as $key => $value) {

		$nonce = wp_create_nonce("xbooster_ajax_share_nonce");
		$link = admin_url('admin-ajax.php?action=xbooster_ajax&dotype=share&network='.$key.'&nonce='.$nonce.'&post_id='.$post_id);

		if( $value->is_enabled == "true" ) {

			$sp_count += get_option('xbooster_social_plugin_sns_counter_' . $post_id . '_' . $key);
			if( $value->custom_icon != "" ){

				$display_icon = $value->custom_icon;
			} else {

				$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );
			}
			//<a class="xbooster_share" data-do="share" data-nonce="' .  . '" data-network="' . $key . '" ><img class="xboostericon '.$key.'" src="' .   . '" style="width:'..'" alt="'.  .'"></a>
			$xbooster_render .= '<li>'.shareapi($key,$display_options->ss->content_icon,$value->title,$display_icon,$nonce,$post_id).'</li>';

		}

	}
	if ( $display_options->sp->counter == "yes" ){
		$xbooster_render .='<li class="bubble"><span class="xbooster_share_counter">'.xbooster_count_format_sec($sp_count).'</span></li>';
	}
	$xbooster_render .= '</ul></div><div style="clear:both;"></div><!-- xBooster Share '.$location.' Content -->';

	return $xbooster_render;



}


function xbooster_sp_render_overlay($location,$social_network_profiles,$display_options){


	$xbooster_render = '<!-- xBooster Social Profiles '.$location.' Overlay --><div id="xbooster_overlay_profile_'.$location.'">
	<div class="xbooster_overlay_profile_'.$location.'_title">'.$display_options->sp->text.'</div>
	<ul>
	';

	$sp_count=0;
	foreach ($social_network_profiles as $key => $value) {

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
			$xbooster_render .= '<li><a class="xbooster_follow" data-do="follow" data-nonce="' . $nonce . '" data-network="' . $key . '"  href="'.$value->profile_url.'" target="_blank"><img  src="' . $display_icon  . '"  alt="'. $value->title .'"></a></li>';

		}

	}
	$xbooster_render .= '<li id="xbooster_overlay_profile_bubble"><div id="xbooster_overlay_profile_count" class="xbooster_follow_counter">'.xbooster_count_format_sec($sp_count).'</div></li>';
	$xbooster_render .= '</ul></div><!-- xBooster Social Profiles '.$location.' Overlay -->';

	return $xbooster_render;

}


function xbooster_ss_render_overlay($location,$social_network_shares,$display_options,$post_id){


	$xbooster_render = '<!-- xBooster Social Share '.$location.' Overlay --><div id="xbooster_overlay_share_'.$location.'">
	<div class="xbooster_overlay_share_'.$location.'_title">'.$display_options->ss->text.'</div>
	<ul>
	';

	$sp_count=0;
	foreach ($social_network_shares as $key => $value) {

		$nonce = wp_create_nonce("xbooster_ajax_share_nonce");
		$link = admin_url('admin-ajax.php?action=xbooster_ajax&dotype=share&network='.$key.'&nonce='.$nonce.'&post_id='.$post_id);

		if( $value->is_enabled == "true" ) {
			$go_key = 'xbooster_social_plugin_sns_counter_' . $post_id . '_' . $key;
			$sp_count += get_option($go_key);

			if( $value->custom_icon != "" ){

				$display_icon = $value->custom_icon;
			} else {

				$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );

			}



				// if ( get_option('permalink_structure') ) { echo 'permalinks enabled'; }
			$xbooster_render .= '<li>'.shareapi($key,$display_options->ss->content_icon,$value->title,$display_icon,$nonce,$post_id).'</li>';

		}

	}
	$xbooster_render .= '<li id="xbooster_overlay_share_bubble"><div id="xbooster_overlay_share_count" class="xbooster_share_counter">'.xbooster_count_format_sec($sp_count).'</div></li>';
	$xbooster_render .= '</ul></div><!-- xBooster Social Share '.$location.' Overlay -->';

	return $xbooster_render;

}


function xbooster_count_format_sec($count) {
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
	?>