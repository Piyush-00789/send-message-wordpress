<?php

/**
 * @package TellephantPlugin
 */

 /*
 Plugin Name: Tellephant
 Plugin URI: https://www.tellephant.com/post/how-to-integrate-whatsapp-with-woocommerce
 Description: Connect Tellephant to your WooCommerce account and build relationships with your customers on WhatsApp
 Version: 1.0.0
 Author: Tellephant
 Author URI: https://www.tellephant.com
 License: GPLv2 or later
 Text Domain: tellephant
 */


 /*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>

 */


//  defined('ABSPATH') or die('You can\'t access the file!');

/**
 * Wordpress version
 */
if(version_compare(get_bloginfo('version'),'4.0','<')){
    $message = 'Need wordpress version 4.0 or higher';
    die($message);


}

/**
 * CONSTANTS
 */

 define('TELLEPHANT_PATH',plugin_dir_path(__FILE__));
 define('TELLEPHANT_URI',plugin_dir_url(__FILE__));

/**
 * Check if wooocommerce is activated or not
 */

if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins',get_option('active_plugins')))){
    if(!class_exists('Tellephant')){
        class Tellephant {
            public function __construct () {
                /**
                 * includes files
                 */
                require(TELLEPHANT_PATH.'/includes/activation.php');
                require(TELLEPHANT_PATH.'/views/admin/setting_page.php');
                require(TELLEPHANT_PATH.'/includes/deactivation.php');


                /**
                 * include classes
                 */

                require(TELLEPHANT_PATH.'/classes/Tellephant_setting_page.php');
                require(TELLEPHANT_PATH.'/classes/Tellephant_save_settings.php');
                require(TELLEPHANT_PATH.'/classes/Tellephant_save_triggers.php');
                require(TELLEPHANT_PATH.'/classes/Tellephant_logout_settings.php');
                require(TELLEPHANT_PATH.'/classes/Tellephant_woocommerce_hooks.php');

                /**
                 * Hooks
                */
                register_activation_hook(__FILE__,'tellephant_activation');
                add_action('admin_menu',array(new Tellephant_setting_page(),'tellephant_create_setting_page'));

                register_deactivation_hook(__FILE__,'tellephant_deactivation');

                //login
                add_action('admin_post_tellephant_save_settings_field',
                array(new Tellephant_save_settings(),'tellephant_save_admin_settings'));

                //logout
                add_action('admin_post_tellephant_logout_settings',
                array(new Tellephant_logout_settings(),'tellephant_logout_admin_settings'));

                //woocommerce hooks
                add_action('woocommerce_order_status_processing',
                array(new Tellephant_woocommerce_hooks(),'tellephant_wc_order_processing'), 10,1);
                add_action('woocommerce_order_status_completed', 
                array(new Tellephant_woocommerce_hooks(),'tellephant_wc_order_completed'), 10,1);
                add_action( 'woocommerce_order_status_cancelled',
                array(new Tellephant_woocommerce_hooks(),'tellephant_wc_order_cancelled'), 10,1);
                add_action( 'woocommerce_order_status_shipped',
                array(new Tellephant_woocommerce_hooks(),'tellephant_wc_order_shipped'), 10,1);
                add_action( 'woocommerce_order_status_refunded',
                array(new Tellephant_woocommerce_hooks(),'tellephant_wc_order_refunded'), 10,2);
                

                //save triggers data
                add_action('admin_post_tellephant_triggers_form',
                array(new Tellephant_save_triggers(),'tellephant_save_triggers_form'));

                add_action('wp_ajax_trigger_status_changed',
                array(new Tellephant_save_triggers(),'tellephant_save_triggers_status'));

                //CSS && JS
                add_action('admin_enqueue_scripts',array($this,'tellephantStyle'));

                
            }

            /**
             * Tellephant Styles and Javascript
             */

            function tellephantStyle(){

                wp_enqueue_style('mypluginstyle',plugins_url('/assets/css/style.css',__FILE__),array(),rand(111,9999));
                wp_enqueue_script('mypluginjs',plugins_url('/assets/js/tellephant.js',__FILE__),array(),rand(111,9999));

            }
            

        }

        $tellephant = new Tellephant();


    }
}



