<?php

/**
 * @package tellephant
 */

 if(!class_exists('Tellephant_logout_settings')){
    class Tellephant_logout_settings{
        public function tellephant_logout_admin_settings(){

            check_admin_referer('tellephant_logout_settings_verify');

            if(!current_user_can( 'manage_options' )){
                wp_die('You are not allowed to edit the settings.');
            }

            delete_option('tellephant_settings');
            
            //Delete the table
            global $wpdb;
            $tellephant_tb_name = $wpdb->prefix .'tellephant_triggers';
            $wpdb->query( "DROP TABLE IF EXISTS $tellephant_tb_name" );
            wp_redirect(get_admin_url().'admin.php?page=tellephant_settings');
            exit();
        }

    }

 }