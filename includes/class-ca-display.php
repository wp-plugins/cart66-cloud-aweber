<?php

class CA_Display {

    public static function filter( $content ) {
        $presentation = CC_Admin_Setting::get_option( 'cart66_aweber_general', 'presentation' );
        $form = CC_Admin_Setting::get_option( 'cart66_aweber_general', 'content' );

        $aligned_form = '<div class="ca-receipt-notification">' . $form . '</div>';

        switch ( $presentation ) {
            case 'above':
                $content = $aligned_form . $content;
                break;
            case 'below':
                $content = $content . $aligned_form;
                break;
            case 'modal':
                $content = self::modal( $content, $form );
                break;
        }

        return $content;
    }

    public static function modal( $content, $form ) {
        CA_Log::write($form);

        $modal = '<div id="cc-receipt-notification-modal" style="display:none;">';
        $modal .= $form;
        $modal .= '</div>';

        return $modal . $content;
    }

    public static function enqueue_scripts() {
        wp_enqueue_style('ca-aweber-styles', CA_URL . 'resources/css/cart66-aweber-styles.css' );
        $presentation = CC_Admin_Setting::get_option( 'cart66_aweber_general', 'presentation' );

        if ( 'modal' == $presentation && is_receipt_screen() ) {
            wp_enqueue_script( 'js-cookie',           CA_URL . 'resources/js/js.cookie.js' );
            wp_enqueue_script( 'jquery-simple-modal', CA_URL . 'resources/js/jquery.simplemodal.min.js', array( 'jquery' ) );
            wp_enqueue_script( 'ca-aweber-script',    CA_URL . 'resources/js/cart66-aweber-scripts.js',  array( 'jquery-simple-modal' ) );

            $width = (int) CC_Admin_Setting::get_option( 'cart66_aweber_general', 'width' );
            $delay = (int) CC_Admin_Setting::get_option( 'cart66_aweber_general', 'delay' );

            // Set minimum width to at least 200px 
            if ( $width < 200 ) { $width = 200; }

            $data = array(
                'width' => $width,
                'delay' => $delay 
            );

            wp_localize_script('ca-aweber-script', 'caModalInfo', $data );
        }
    }
}
