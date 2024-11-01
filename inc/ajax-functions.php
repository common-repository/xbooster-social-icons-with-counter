<?php
/* jQuery handling for follow/share counting */
add_action("wp_ajax_xbooster_ajax_follow", "xbooster_ajax_follow");
add_action("wp_ajax_nopriv_xbooster_ajax_follow", "xbooster_ajax_follow");
add_action("wp_ajax_xbooster_ajax_share", "xbooster_ajax_share");
add_action("wp_ajax_nopriv_xbooster_ajax_share", "xbooster_ajax_share");
add_action("wp_ajax_xbooster_share_sort", "xbooster_share_sort");
add_action("wp_ajax_xbooster_profile_sort", "xbooster_profile_sort");


function xbooster_share_sort(){
/*
"pinterest" 	=> array( 'title'			=> "Pinterest",
		'default_icon'	=> 'pinterest.svg',
		'custom_icon'		=> '',
		'is_enabled'		=> "false",
		'order'			=> '0'
		),			
*/
if ( !wp_verify_nonce( $_REQUEST['nonce'], "xbooster_ajax_share_sort")) {
		exit();
	}   
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	$xbooster_admin_social_sharings = get_option('xbooster_social_plugin_share_ns'); 
	$xbooster_admin_social_sharings_decoded = json_decode($xbooster_admin_social_sharings);
	$stack = (array) $xbooster_admin_social_sharings_decoded;

	
	if ( isset($_POST['xbooster_item']) ){
		foreach ($_POST['xbooster_item'] as $key => $value) {
			
			$new_stack[$value] =array(  'title'			=> $stack[$value]->title,
										'default_icon'	=> $stack[$value]->default_icon,
										'custom_icon'	=> $stack[$value]->custom_icon,
										'is_enabled'	=> $stack[$value]->is_enabled,
										'order'			=> $key
									);

		}
	$new_stack_json = json_encode($new_stack);
	update_option('xbooster_social_plugin_share_ns', $new_stack_json);
	}
	

	}
	
	die();

}



function xbooster_profile_sort(){

if ( !wp_verify_nonce( $_REQUEST['nonce'], "xbooster_ajax_profile_sort")) {
		exit();
	}   
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	$xbooster_admin_social_sharings = get_option('xbooster_social_plugin_snps'); 
	$xbooster_admin_social_sharings_decoded = json_decode($xbooster_admin_social_sharings);
	$stack = (array) $xbooster_admin_social_sharings_decoded;

	
	if ( isset($_POST['xbooster_item']) ){
		foreach ($_POST['xbooster_item'] as $key => $value) {
			
			$new_stack[$value] =array(  'title'			=> $stack[$value]->title,
										'default_icon'	=> $stack[$value]->default_icon,
										'custom_icon'	=> $stack[$value]->custom_icon,
										'profile_url'	=> $stack[$value]->profile_url,
										'is_enabled'	=> $stack[$value]->is_enabled,
										'order'			=> $key
									);

		}
	$new_stack_json = json_encode($new_stack);
	update_option('xbooster_social_plugin_snps', $new_stack_json);
	}
	

	}
	
	die();

}

function xbooster_ajax_share(){

	if ( !wp_verify_nonce( $_REQUEST['nonce'], "xbooster_ajax_share_nonce")) {
		exit();
	}   
	

	if( isset ($_REQUEST['dotype']) ){

		
		if( $_REQUEST['dotype'] == "share"){

			
			if( isset ($_REQUEST['network']) ){

				$network = $_REQUEST['network'];

				if ( strlen($network) >= 2 ){
					if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					$network_option = "xbooster_social_plugin_sns_counter_". $_REQUEST['postid'] . '_' . $network;

					$fcount = get_option($network_option);
					$newfcount = $fcount + 1;

					update_option( $network_option, $newfcount );

					$result['type']= "success";
					

					
						$result = json_encode($result);
						echo $result;
					} else {
						header("Location: ".$_SERVER["HTTP_REFERER"]);
					}

				}

			}
		}
	}  
	die();
}




function xbooster_ajax_follow(){

	if ( !wp_verify_nonce( $_REQUEST['nonce'], "xbooster_ajax_follow_nonce")) {
		exit();
	}   
	

	if( isset ($_REQUEST['dotype']) ){

		
		if( $_REQUEST['dotype'] == "follow"){

			
			if( isset ($_REQUEST['network']) ){

				$network = $_REQUEST['network'];

				if ( strlen($network) >= 2 ){
					if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					$network_option = "xbooster_social_plugin_snp_counter_" . $network;

					$fcount = get_option($network_option);
					$newfcount = $fcount + 1;

					update_option( $network_option, $newfcount );

					$result['type']= "success";
					
					

					
						$result = json_encode($result);
						echo $result;
					} else {
						header("Location: ".$_SERVER["HTTP_REFERER"]);
					}

				}

			}
		}
	}  
	die();
}

?>