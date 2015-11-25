<?php
/**
 * Adding the Gift to the Form Output 
 *
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds a Custom "downloadurl" Tag
 * @description: This function creates a custom Give email template tag
 *
 * @param $payment_id
 */
function ggfd_give_download_tag( $payment_id ) {

	give_add_email_tag( 'downloadurl', 'This outputs the download url for the relevant form', 'ggfd_give_download_data' );

}

add_action( 'give_add_email_tags', 'ggfd_give_download_tag' );


// Add URL to Payment Meta
function ggfd_give_download_paymentmeta($payment_meta) {
  $payment_meta['downloadurl'] = get_post_meta( get_the_ID(), '_ggfd_download_url' );

	return $payment_meta;

}

add_filter( 'give_payment_meta', 'ggfd_give_download_paymentmeta' );


// Adds info to the email tag {downloadurl}
function ggfd_give_download_data( $payment_id ) {

	$paymentmeta = give_get_payment_meta( $payment_id );

	$formid = $paymentmeta['form_id'];

	$downloadurl = get_post_meta($formid, '_ggfd_download_url');
	$downloadtext = get_post_meta($formid, '_ggfd_link_text');
	$getminimum = get_post_meta($formid, '_ggfd_min_amount');
	$confirmationtitle = get_post_meta($formid, '_ggfd_confirmation_title');
	
	if (empty($getminimum)) {
		$minimum = '0';
	} else {
		$minimum = $getminimum;
	}
	
	//Normalize these amounts for proper comparison
	$paymentamount = html_entity_decode(give_payment_amount( $payment_id ));
	$donation = preg_replace("/([^0-9\\.])/i", "", $paymentamount);
	
	
	// Otherwise check whether it meets minimum donation requirement
	// then output accordingly.
	if ($downloadurl && ($donation >= $minimum[0]) ) {
		$output = '<a href="';
		$output .= $downloadurl[0];
		$output .= '">';
		$output .= $downloadtext[0];
		$output .= '</a>';
	} else {
		$output = '';
	}

	return $output;
}

add_action('give_payment_receipt_before_table', 'add_download_to_donation_receipt');

function add_download_to_donation_receipt($payment) {
	
	$paymentmeta = give_get_payment_meta( $payment->ID );
	$formid = $paymentmeta['form_id'];
	
	$downloadurl = get_post_meta($formid, '_ggfd_download_url');
	$downloadtext = get_post_meta($formid, '_ggfd_link_text');
	$getminimum = get_post_meta($formid, '_ggfd_min_amount');
	$confirmationtitle = get_post_meta($formid, '_ggfd_confirmation_title');
	
	if (empty($getminimum)) {
		$minimum = '0';
	} else {
		$minimum = $getminimum;
	}
	
	//Normalize these amounts for proper comparison
	$paymentamount = html_entity_decode(give_payment_amount( $payment->ID ));
	$donation = preg_replace("/([^0-9\\.])/i", "", $paymentamount);
	
	// Use for debugging the output
	// echo '<h4>Payment =</h4>';
	// var_dump($paymentamount);
	// echo '<h4>Amount =</h4>';
	// var_dump($donation);
	// echo '<h4>Minimum =</h4>';
	// var_dump($minimum);
	
	// Only show the Gift text and links if
	// 1. There is a download url attached to this donation
	// 2. If there's a minimum amount, the donation is equal to or more than that minimum
	if ($downloadurl && ( $donation >= $minimum[0] ) ) { ?>
		
		<div class="donation-gift">
			<h3><?php echo $confirmationtitle[0]; ?></h3>
			<p><a href="<?php echo $downloadurl[0]; ?>"><?php echo $downloadtext[0]; ?></a></p>
		</div>
		
	<?php }

}
