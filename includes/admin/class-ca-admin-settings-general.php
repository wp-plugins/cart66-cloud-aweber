<?php

class CA_Admin_Settings_General extends CC_Admin_Setting {

    public static function init() {
        $page = 'cart66_aweber_general_settings';
        $option_group = 'cart66_aweber_general';
        $setting = new CA_Admin_Settings_General( $page, $option_group );
        return $setting;
    }

    /**
     * admin_init hooked in by parent class constructor
     */
    public function register_settings() {
        $this->register_general_section();
        $this->register();
    }

    public function register_general_section() {
        // Set the name for the options in this section and load any stored values
        $defaults = array(
            'presentation' => '',
            'content' => '',
            'width' => '',
            'delay' => ''
        );
        $option_values = self::get_options( $this->option_name, $defaults );

        // Create the section for the cart66_aweber_general section
        $title = __( 'Aweber Settings', 'cart66-aweber' );
        $section = new CC_Admin_Settings_Section( $title, $this->option_name );

        // Add presentation location options
        $presentation_title = __( 'Presentation', 'cart66-aweber' );
        $presentation = new CC_Admin_Settings_Select_Box( $presentation_title, 'presentation' );
        $presentation->new_option( __( 'Modal', 'cart66-aweber' ), 'modal', false );
        $presentation->new_option( __( 'Above receipt', 'cart66-aweber' ), 'above', false );
        $presentation->new_option( __( 'Below receipt', 'cart66-aweber' ), 'below', false );
        $presentation->set_selected( $option_values['presentation'] );
        $section->add_field( $presentation );

        // Add modal width setting
        $width = new CC_Admin_Settings_Text_Field( __('Modal width', 'cart66-aweber'), 'width', $option_values['width'] );
        $width->description = __( 'Number of pixels wide or leave blank for auto-sizing the width. Ex. 400', 'cart66-aweber' );
        $section->add_field( $width );

        // Add modal width setting
        $delay = new CC_Admin_Settings_Text_Field( __('Modal delay', 'cart66-aweber'), 'delay', $option_values['delay'] );
        $delay->description = __( 'Miliseconds before modal appears or leave blank for no delay', 'cart66-aweber' );
        $section->add_field( $delay );

        // Add sign in required editor
        $content_title = __( 'Aweber form', 'cart66-aweber' );
        $content = new CC_Admin_Settings_Text_Area( $content_title, 'content', $option_values['content'] );
        $content->description = __( 'Enter the HTML markup to display your sign up form', 'cart66-aweber' );
        $section->add_field( $content );

        // Add the settings sections for the page and register the settings
        $this->add_section( $section );
    }

}
