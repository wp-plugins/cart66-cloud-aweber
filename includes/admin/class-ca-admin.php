<?php

class CA_Admin {

    public static $instance;

    public static function init() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new CA_Admin();
        }

        return self::$instance;
    }

    protected function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        CA_Admin_Settings_General::init();
    }

    public function add_menu_page() {
        $parent_slug = 'cart66';
        $page_title = __( 'Cart66 Cloud Aweber', 'cart66-aweber' );
        $menu_title = __( 'Aweber', 'cart66-aweber' );
        $capability = 'manage_options';
        $menu_slug = 'cart66_aweber';
        $options_page = add_submenu_page( 
            $parent_slug, 
            $page_title, 
            $menu_title, 
            $capability, 
            $menu_slug, 
            array($this, 'render') 
        );
    }

    public function render() {
        echo CC_View::get( CA_PATH . 'views/admin/html-settings-general.php' );
    }

}
