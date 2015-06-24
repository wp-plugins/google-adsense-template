<?php
/*
Plugin Name: Google Adsense Template
Description: Add Google Adsense Template to use on your Wordpress pages.
Version: 1.0
Author: Jeff Bullins
Author URI: http://www.thinklandingpages.com
*/

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

include_once 'cmb2Settings.php';
include_once 'pagetemplater.php';  
add_action( 'plugins_loaded', array( 'PageTemplateCore', 'get_instance' ) );

function page_template_activate() {
	//$photoGalleryCustomPostType = new PhotoGalleryCustomPostType();
	//$photoGalleryCustomPostType->create_post_type();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}


register_activation_hook( __FILE__, 'page_template_activate');

 