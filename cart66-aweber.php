<?php
/*
Plugin Name: Cart66 Cloud - Aweber
Plugin URI: http://cart66.com
Description: Aweber integration for Cart66 Cloud
Version: 1.0.0
Author: Reality66
Author URI: http://www.reality66.com

-------------------------------------------------------------------------
Copyright 2015  Reality66

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('Cart66_Aweber') ) {
    $plugin_file = __FILE__;
    if(isset($plugin)) { $plugin_file = $plugin; }
    elseif (isset($mu_plugin)) { $plugin_file = $mu_plugin; }
    elseif (isset($network_plugin)) { $plugin_file = $network_plugin; }
    
    // Define constants
    define( 'CA_VERSION_NUMBER', '1.0.0' );
    define( 'CA_PLUGIN_FILE', $plugin_file );
    define( 'CA_PATH', WP_PLUGIN_DIR . '/' . basename(dirname($plugin_file)) . '/' );
    define( 'CA_URL',  WP_PLUGIN_URL . '/' . basename(dirname($plugin_file)) . '/' );
    define( 'CA_DEBUG', false );

    // Include Cart66 Cloud Aweber helper functions
    include_once CA_PATH . 'includes/ca-functions.php';

	/**
	 * The main plugin class should not be extended
	 */
	final class Cart66_Aweber {

        protected $dependency_check = false;
		protected static $instance;

		/**
		 * The plugin should only be loaded one time
		 *
		 * @since 1.0.0
		 * @static
		 * @return Plugin instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
            // Register autoloader
            spl_autoload_register( array( $this, 'class_loader' ) );

            // Check to see if Cart66 Cloud is installed
            add_action( 'plugins_loaded', array( $this, 'dependency_check' ) );

            // Initialize plugin
            add_action( 'init', array( $this, 'initialize' ) );
		}

        /**
         * Called by init action and only runs if the dependencies are all met
         */
        public function initialize() {
            if ( true === $this->dependency_check ) {
                if ( is_admin() ) {
                    CA_Admin::init();
                } else {
                    add_action( 'wp_enqueue_scripts', array( 'CA_Display', 'enqueue_scripts' ) );
                }            

                add_filter( 'cc_receipt_content', array('CA_Display', 'filter') );
            }
        }

        public function dependency_check() {
            $this->dependency_check = true;

            // If Cart66 Cloud is not loaded show and admin notice
            if ( ! class_exists('Cart66_Cloud') ) {
                add_action( 'admin_notices', array( $this, 'dependency_notice' ) );
                $this->dependency_check = false;
            }
        }

        public function dependency_notice() {
            ?>
            <div class="error">
                <p><?php _e( 'Cart66 Cloud Aweber requires the Cart66 Cloud plugin to be installed and activated.', 'cart66-aweber' ); ?></p>
            </div>
            <?php
        }

        public static function class_loader($class) {
            if(ca_starts_with($class, 'CA_')) {
                $class = strtolower($class);
                $file = 'class-' . str_replace( '_', '-', $class ) . '.php';
                $root = CA_PATH;

                if(ca_starts_with($class, 'ca_exception')) {
                    include_once $root . 'includes/exception-library.php';
                } elseif ( ca_starts_with( $class, 'ca_admin' ) ) {
                    include_once $root . 'includes/admin/' . $file;
                } elseif ( ca_starts_with( $class, 'ca_cloud' ) ) {
                    include_once $root . 'includes/cloud/' . $file;
                } else {
                    include_once $root . 'includes/' . $file;
                }
            }
        }

		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __clone () {
			_doing_it_wrong ( 
				__FUNCTION__, 
				__( 'Cheatin&#8217; huh?' ), 
				'1.0.0' 
			);
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __wakeup () {
			_doing_it_wrong ( 
				__FUNCTION__, 
				__( 'Cheatin&#8217; huh?' ), 
				'1.0.0' 
			);
		}

	}
}

Cart66_Aweber::instance();
