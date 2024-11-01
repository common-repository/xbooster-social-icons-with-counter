<?php
/**
 * Plugin Name: xBooster Social Icons With Counter
 * Plugin URI: http://www.allthemesnulled.com
 * Description: Adds SVG Social Sharing Icons anywhere you want. 
 * Version: 1.0
 * Author: acbaltaci
 * Author URI: http://www.allthemesnulled.com
 * License: GPL
 */

if ( function_exists( 'add_action' ) && function_exists( 'register_activation_hook' ) ) {
	
	add_action( 'plugins_loaded', array( 'XboosterSocialPlugin', 'get_object' ) );

	// includes widget classes
	include("inc/widget-functions.php");

	// includes ajax nonce functions
	include("inc/ajax-functions.php");

	// includes wp-enqu functions
	include("inc/script-style-loader.php");

	// render functions fur the_content()

	include("inc/content-render-functions.php");
	
	// Visual Composer (WP Bakery) extention

	include("inc/vcmap-functions.php");
	
	// Sharing apis 

	include("inc/apis.php");

	add_shortcode( 'xBooster_Social_Profiles', array( 'XboosterSocialPlugin', 'xbooster_shortcode_social_profiles' ) );
	add_shortcode( 'xBooster_Social_Share', array( 'XboosterSocialPlugin', 'xbooster_shortcode_social_share' ) );

	
	add_action('init', 'xbooster_social_plugin_init');
}



function xbooster_social_plugin_init(){

	load_plugin_textdomain('xboostersocial', false, basename( dirname( __FILE__ ) ) . '/languages' );

}

class XboosterSocialPlugin {
	// singleton class variable
	static private $classobj = NULL;
	
	
	
	private $settings_page_handle = 'xbooster_social_options_handle';
		


	// singleton method
	public static function get_object() {
		if ( NULL === self::$classobj ) {
			self::$classobj = new self;
		}



		return self::$classobj;

	}

	private function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_menu_entry' ) );


	}
	
	public function add_menu_entry() {
		add_submenu_page( 'options-general.php', 'xBooster Social Plugin', 'xBooster Social Plugin', 'manage_options', $this->settings_page_handle, array( $this, 'settings_page' ) );
	}
	
	public function settings_page() {

		if( isset($_REQUEST['tab']) ){
			$tab = $_REQUEST['tab'];
		}
		
		if( !isset($tab) ){

			$tab = "tab1";

		}
		
		include('admin/admin-first.php');
	}
	
	private function settings_page_sidebar() {
		# see http://www.satoripress.com/2011/10/wordpress/plugin-development/clean-2-column-page-layout-for-plugins-70/
		
		include('admin/admin-sidebar.php');

	}
	
	private function settings_page_tab1() {
		include('admin/admin-dashboard.php');
	}
	
	private function settings_page_tab2() {
		include('admin/admin-social-network-profiles.php');
	}

	private function settings_page_tab3() {
		include('admin/admin-social-sharing.php');
	}

	private function settings_page_tab4() {
		include('admin/admin-display-options.php');
	}

	private function settings_page_tab5() {
		include('admin/admin-sharing-stats.php');
	}

	static function xbooster_shortcode_social_profiles ( $atts ) {

		extract( shortcode_atts( array(
			'iconsize' => '32',
			'title' => '',
			'counter' => 'yes'
			), $atts ) );



		$xbsp = new XboosterSocialPlugin();
		$render =  $xbsp->xbooster_build_social_profiles_sc( $title, $iconsize, $counter );

		return $render;

	}

	public function xbooster_count_format($count) {
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

	static function xbooster_shortcode_social_share ( $atts ) {

		extract( shortcode_atts( array(
			'iconsize' => '32',
			'title' => '',
			'counter' => 'yes'
			), $atts ) );



		$xbsp = new XboosterSocialPlugin();
		$render =  $xbsp->xbooster_build_social_sharing_sc( $title, $iconsize, $counter );

		return $render;

	}

	public function xbooster_build_social_profiles_sc( $title, $iconsize='32', $counter ){


		$xbooster_admin_social_profiles = get_option('xbooster_social_plugin_snps'); 
		$xbooster_admin_social_profiles_decoded = json_decode($xbooster_admin_social_profiles);
		
		$xbooster_display_options = get_option('xbooster_display_options');
		$xbooster_do = json_decode($xbooster_display_options);

		
		$render = '<ul class="xbsp_container">';
		if ( isset ($title) ){

			if( strlen($title) > 0) {
				$render .= '<li class="xbsp_act"><span>'.$title.'</span></li>';
			}
		}
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

					$display_icon = plugins_url( 'assets/images/'.$value->default_icon, __FILE__ );

				}



				// if ( get_option('permalink_structure') ) { echo 'permalinks enabled'; }
				$render .= '<li><a class="xbooster_follow" data-do="follow" data-nonce="' . $nonce . '" data-network="' . $key . '"  href="'.$value->profile_url.'" target="_blank"><img  class="xboostericon '.$key.'" src="' . $display_icon  . '" style="width:'.$iconsize.'" alt="'. $value->title .'"></a></li>';

			}
			
		}
		if ( $counter == "yes" ){
			$render .='<li class="bubble"><span class="xbooster_follow_counter">'.$this->xbooster_count_format($sp_count).'</span></li>';
		}
		$render .= '</ul><div style="clear:both;"></div>';

		return $render;

	}


	public function xbooster_build_social_sharing_sc( $title='', $iconsize='32', $counter='yes' ){


		$xbooster_admin_social_sharing = get_option('xbooster_social_plugin_share_ns'); 
		$xbooster_admin_social_sharing_decoded = json_decode($xbooster_admin_social_sharing);
		
		$xbooster_display_options = get_option('xbooster_display_options');
		$xbooster_do = json_decode($xbooster_display_options);
		$render = '<ul class="xbsp_container">';
		if ( isset ($title) ){
			if( strlen($title) > 0) {
				$render .= '<li class="xbsp_act"><span>'.$title.'</span></li>';
			}
		}
		$sp_count = 0;
		foreach ($xbooster_admin_social_sharing_decoded as $key => $value) {

			$nonce = wp_create_nonce("xbooster_ajax_share_nonce");
			$link = admin_url('admin-ajax.php?action=xbooster_ajax&dotype=share&network='.$key.'&nonce='.$nonce);

			if( $value->is_enabled == "true" ) {

				$sp_count += get_option('xbooster_social_plugin_sns_counter_' . $key);
				if( $value->custom_icon != "" ){

					$display_icon = $value->custom_icon;
				} else {

					$display_icon = plugins_url( 'assets/images/'.$value->default_icon, __FILE__ );
				}

				$render .= '<li>'.shareapi($key,$iconsize,$value->title,$display_icon,$nonce).'</li>';

			}
			
		}
		if ( $counter == "yes" ){
			$render .='<li class="bubble"><span class="xbooster_share_counter">'.$this->xbooster_count_format($sp_count).'</span></li>';
		}
		$render .= '</ul><div style="clear:both;"></div>';

		return $render;

	}




	

	static function install() {


		
		$xbooster_social_plugin_snps = array(
			"facebook"		=> array( 'title'			=> "Facebook",
				'default_icon'	=> 'facebook.svg',
				'custom_icon'		=> '',
				'profile_url' 	=> '',
				'is_enabled'		=> "false",
				'order'			=> '0'
				),

			"twitter" 		=> array( 'title'			=> "Twitter",
				'default_icon'	=> 'twitter.svg',
				'custom_icon'		=> '',
				'profile_url' 	=> '',
				'is_enabled'		=> "false",
				'order'			=> '0'
				)
			);


$xbooster_social_plugin_share_ns = array(
	"facebook"		=> array( 'title'			=> "Facebook",
		'default_icon'	=> 'facebook.svg',
		'custom_icon'		=> '',
		'is_enabled'		=> "true",
		'order'			=> '0'
		),

	"twitter" 		=> array( 'title'			=> "Twitter",
		'default_icon'	=> 'twitter.svg',
		'custom_icon'		=> '',
		'is_enabled'		=> "true",
		'order'			=> '0'
		)
	);

$xbooster_social_plugin_snps_json = json_encode($xbooster_social_plugin_snps);

update_option('xbooster_social_plugin_snps', $xbooster_social_plugin_snps_json);

foreach($xbooster_social_plugin_snps as $profile => $value){

	update_option('xbooster_social_plugin_snp_counter_'.$profile, '0');

}

$xbooster_social_plugin_share_ns_json = json_encode($xbooster_social_plugin_share_ns);

update_option('xbooster_social_plugin_share_ns', $xbooster_social_plugin_share_ns_json);

foreach($xbooster_social_plugin_share_ns as $profile => $value){

	update_option('xbooster_social_plugin_sns_counter_'.$profile, '0');

}



$xbooster_do = array(
	"sp"		=> array( 
		'content'		=> "none",
		'content_icon'	=> '32px',
		'overlay'		=> 'none',
		'text'			=> 'Follow',
		'counter'		=> 'yes'
		),


	"ss" 		=> array( 
		'content'		=> "after",
		'content_icon'	=> '32px',
		'overlay' 		=> 'none',
		'text'			=> 'Share',
		'counter'		=> 'yes'
		)
	);

$xbooster_do_json = json_encode($xbooster_do);

update_option('xbooster_display_options', $xbooster_do_json);
}
}


register_activation_hook(__FILE__,array('XboosterSocialPlugin','install'));





?>