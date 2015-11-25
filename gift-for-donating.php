<?php
/**
 * Plugin Name: 	GIVE: Gift for Donating 
 * Plugin URI: 		https://mattcromwell.com/products/gift-for-donating
 * Description: 	Give your donors a gift for donating.
 * Version: 		1.0
 * Author: 			Matt Cromwell
 * Author URI: 		https://www.mattcromwell.com
 * License:      	GNU General Public License v2 or later
 * License URI:  	http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:		ggfd
 *
 */
 
define( 'GGFD_DIR', dirname( __FILE__ ) );
 
function ggfd_plugin_init() {
	if( class_exists( 'Give' ) ) {
 
		include_once( GGFD_DIR . '/inc/ggfd-metabox.php' );
		include_once( GGFD_DIR . '/inc/ggfd-custom-form-fields.php' );
 
	}
}

add_action( 'plugins_loaded', 'ggfd_plugin_init' );