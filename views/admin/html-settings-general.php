<?php
/**
 * Cart66 Cloud Aweber settings page
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Use this identifier when calling add_settings_error()
settings_errors( 'cart66_aweber_settings' );
?>

<div class="wrap">
    <h2>Cart66 Cloud Aweber Settings</h2>
</div>

<div class="wrap">
    <form method="post" action="options.php">
    <?php
        // menu_slug used in add_settings_section
        do_settings_sections('cart66_aweber_general_settings'); 

        // option_group
        settings_fields('cart66_aweber_general');              

        // submit button.
        submit_button();
    ?>
    </form>
</div>

