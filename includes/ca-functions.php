<?php

function ca_starts_with( $haystack, $needle ) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * Check if the current screen is the order receipt
 *
 * Return true of the current screen is the order receipt screen
 * otherwise return false.
 *
 * @since 1.0.0
 * @return boolean
 */
function is_receipt_screen() {
    return isset( $_GET['cc_page_name'] ) && $_GET['cc_page_name'] == 'receipt';
}
