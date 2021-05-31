<?php
/*
Plugin Name: Envisic Woo functions
Plugin URL: http://www.envisic.nl
Description: Some nice add ons for Woo Commerce
Version: 0.1
Author: Herko Baarslag
Author URI: http://www.envisic.nl
Text Domain: rc_scd
*/

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

// plugin folder url
if(!defined('RC_SCD_PLUGIN_URL')) {
    define('RC_SCD_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

/*
|--------------------------------------------------------------------------
| MAIN CLASS
|--------------------------------------------------------------------------
*/

class envisic_woo {

    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/

    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {

        add_action('admin_menu', array( &$this,'envisic_woo_register_menu') );

    } // end constructor

    function envisic_woo_register_menu() {
        add_dashboard_page( 'EnvisicWoo', 'EnvisicWoo', 'read', 'ewoo-main', array( &$this,'ewoo_create_main_page') );
    }

    function ewoo_create_main_page() {
        include_once( 'ewoo-main.php'  );
    }


}

// instantiate plugin's class
$GLOBALS['envisic_woo_plugin'] = new envisic_woo();
