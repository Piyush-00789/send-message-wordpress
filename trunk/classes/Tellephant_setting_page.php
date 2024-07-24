<?php

/**
 * @package tellephant
 */

defined('ABSPATH') or die('You can\'t access the file!');

define('TELLEPHANT_PLUGINPATH',plugin_dir_path(__FILE__));

if( !class_exists('Tellephant_setting_page')){
    class Tellephant_setting_page{
        public function tellephant_create_setting_page(){
            add_submenu_page(
                'woocommerce',
                __('Tellephant WhatsApp Messaging','tellephant'),
                __('Tellephant WhatsApp Messaging','tellephant'),
                'manage_options','tellephant_settings','tellephant_setting_page_callback'
            );


        //create table
        include_once(TELLEPHANT_PLUGINPATH.'/Tellephant_triggers_db_file.php');

        $tellephant_table =  new Tellephant_triggers_db_file();
        $tellephant_table->tellephant_tb_create();
        }
    }
}