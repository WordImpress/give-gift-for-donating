<?php
/**
 * Plugin Name: 	GIVE a Gift for Donating 
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

// Defines Plugin directory for easy reference
define( 'GGFD_DIR', dirname( __FILE__ ) );
 
function ggfd_plugin_init() {
	
	// If Give is NOT active
	if ( current_user_can( 'activate_plugins' ) && !class_exists('Give')) {
		
		add_action( 'admin_init', 'my_plugin_deactivate' );
		add_action( 'admin_notices', 'my_plugin_admin_notice' );
		
		// Deactivate GGFD
		function my_plugin_deactivate() {
		  deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		
		// Throw an Alert to tell the Admin why it didn't activate
		function my_plugin_admin_notice() {
		   echo "<div class=\"error\"><p><strong>" . __('"Give a Gift for Donating"</strong> requires the free <a href="https://wordpress.org/plugins/give" target="_blank">Give Donation Plugin</a> to work. Please activate Give before activating this plugin. For now, the plug-in has been <strong>deactivated</strong>.', 'ggfd') . "</p></div>";
		   if ( isset( $_GET['activate'] ) )
				unset( $_GET['activate'] );
		}

     } else {
		
		include_once( GGFD_DIR . '/inc/ggfd-metabox.php' );
		include_once( GGFD_DIR . '/inc/ggfd-custom-form-fields.php' );
	 }
}

add_action( 'plugins_loaded', 'ggfd_plugin_init' );