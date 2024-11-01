<?php
add_action( 'admin_enqueue_scripts', 'xbooster_load_scripts'  ); // wp_enqueue_scripts action hook to link only on the 
add_action( 'wp_enqueue_scripts', 'xbooster_frontend_scripts' );
add_action( 'admin_print_styles', 'xbooster_load_css_admin' );

function xbooster_load_scripts() {

		//wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-resizable');
		wp_enqueue_script('postbox');
		wp_enqueue_script('post');
		wp_enqueue_script('media-views');
		wp_enqueue_script('jquery-ui-position');
		wp_enqueue_script('jquery-form');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('xbooster-admin',plugins_url('../assets/js/xbooster-admin.js', __FILE__));
		wp_enqueue_script('xbooster-datatables',plugins_url('../assets/js/jquery.dataTables.min.js', __FILE__));

	}			 

function xbooster_load_css_admin() {

	
	wp_enqueue_style( 'xBoosterSocialAdminCss', plugins_url('../assets/css/admin.css', __FILE__) );
	wp_enqueue_style( 'xBoosterSocialdataTables', plugins_url('../assets/css/datatable.css', __FILE__) );


}


function xbooster_frontend_scripts() {

	wp_enqueue_style( 'xBoosterSocialFrontendCss', WP_PLUGIN_URL.'/xbooster-social-plugin/assets/css/xbooster.css' );
	//wp_enqueue_script( 'script-name', plugins_url('/assets/js/xbooster.js',__FILE__), array(), '1.0.0', true );
	wp_register_script( "xbooster_process_script", WP_PLUGIN_URL.'/xbooster-social-plugin/assets/js/xbooster.js', array('jquery') );
	wp_localize_script( 'xbooster_process_script', 'xboosterAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'xbooster_process_script' );
    wp_enqueue_script('xbooster-pinterest', WP_PLUGIN_URL.'/xbooster-social-plugin/assets/js/pinimages.min.js','1.0',true);
}
       

?>