<?php
/**
 * The GGFD Metabox 
 *
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 
// Because Give already requires CMB2 
// And GGFD requires Give, there's no need to require CMB2
// We can just jump right into metabox creation with the CMB2 action

add_action( 'cmb2_admin_init', 'ggfd_metabox' );

function ggfd_metabox() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ggfd_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$ggfd = new_cmb2_box( array(
		'id'            => $prefix . 'give_gift',
		'title'         => __( 'Give a Gift for Donating', 'ggfd' ),
		'object_types'  => array( 'give_forms', ),
		'context'    => 'normal',
		'priority'   => 'core',
	) );
	$ggfd->add_field( array(
		'name'       => __( 'Upload', 'ggfd' ),
		'id'         => $prefix . 'download_url',
		'type'       => 'file',
		'options' => array(
			'url' => true,
			'add_upload_file_text' => 'Upload Your Gift File'
		),
	) );
	$ggfd->add_field( array(
		'name'       => __( 'Minimum Donation?', 'ggfd' ),
		'desc'       => __( 'If you want the Gift available only if the donor donates a minimum amount, enter that here. Otherwise leave blank.', 'ggfd' ),
		'id'         => $prefix . 'min_amount',
		'type'       => 'text_money',
	) );
	$ggfd->add_field( array(
		'name'       => __( 'Donation Confirmation Title', 'ggfd' ),
		'desc'       => __( 'This will appear on the Donation Confirmation page above your download link.', 'ggfd' ),
		'id'         => $prefix . 'confirmation_title',
		'type'       => 'text',
	) );
	$ggfd->add_field( array(
		'name'       => __( 'Download Link Text', 'ggfd' ),
		'desc'       => __( 'This is what the link in your email will say', 'ggfd' ),
		'id'         => $prefix . 'link_text',
		'type'       => 'text',
	) );

}
