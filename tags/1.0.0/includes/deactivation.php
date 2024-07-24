<?php

/**
 * @package tellephant
 */

defined('ABSPATH') or die('You can\'t access the file!');


if( !function_exists('tellephant_deactivation')){
    function tellephant_deactivation() {
        //check if tellephant_settings option found
        if(get_option('tellephant_settings') ){
            delete_option('tellephant_settings');
        }

        //Delete the table
        global $wpdb;
        $tellephant_tb_name = $wpdb->prefix .'tellephant_triggers';
        $wpdb->query( "DROP TABLE IF EXISTS $tellephant_tb_name" );
    }
}