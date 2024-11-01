<?php


if ( function_exists( 'vc_map' ) ){


	vc_map( array(
		"name" => __('xBooster Social Profiles','xboostersocial'),
		"base" => "xBooster_Social_Profiles",
		"class" => "",
		"icon" => "icon-wpb-xbooster",
		"category" => 'Content',
		  // 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		'admin_enqueue_css' => array(plugins_url( 'assets/css/visual-composer.css', __FILE__ )),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Icon Size",'xboostersocial'),
				"param_name" => "iconsize",
				"value" => "32px",
				"description" => __("Please enter icon size with px or em etc..",'xboostersocial')
				),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Title",'xboostersocial'),
				"param_name" => "title",
				"value" => __("Follow Us",'xboostersocial'),
				"description" => __("Enter title, leave blank to disable..",'xboostersocial')
				),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Display Counter",'xboostersocial'),
				"param_name" => "counter",
				"value" => array( "yes","no" ),
				"description" => __("To show counter select yes",'xboostersocial')
				)
			)

		) );

vc_map( array(
	"name" => __("xBooster Social Sharing",'xboostersocial'),
	"base" => "xBooster_Social_Share",
	"class" => "",
	"icon" => "icon-wpb-xbooster",
	"category" => 'Content',
		  // 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
	'admin_enqueue_css' => array(plugins_url( 'assets/css/visual-composer.css', __FILE__ )),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Icon Size",'xboostersocial'),
			"param_name" => "iconsize",
			"value" => "32px",
			"description" => __("Please enter icon size with px or em etc..",'xboostersocial')
			),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title",'xboostersocial'),
			"param_name" => "title",
			"value" => __("Share This",'xboostersocial'),
			"description" => __("Enter title, leave blank to disable..",'xboostersocial')
			),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Display Counter",'xboostersocial'),
			"param_name" => "counter",
			"value" => array( "yes","no" ),
			"description" => __("To show counter select yes",'xboostersocial')
			)
		)

	) );


}


?>