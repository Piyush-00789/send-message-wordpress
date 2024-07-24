<?php
/**
 * @package tellephant
 */



if(!class_exists('Tellephant_triggers_db_file')){;
    class Tellephant_triggers_db_file {
        public function tellephant_tb_create(){
            
            if(!current_user_can( 'manage_options' )){
                wp_die('You are not allowed to edit the settings.');
            }

            global $wpdb;

            $tellephant_tb_name = $wpdb->prefix .'tellephant_triggers';

            $db_query = "CREATE TABLE $tellephant_tb_name(
                trigger_name VARCHAR(100) DEFAULT '',
                trigger_status VARCHAR(20) DEFAULT '',
                template_id VARCHAR(100) DEFAULT '',
                language_code VARCHAR(20) DEFAULT '',
                variable_count int(10) DEFAULT 0,
                template_type VARCHAR(20) DEFAULT '',
                woocommerce_variables VARCHAR(600) DEFAULT '',
                last_messages_status VARCHAR(20) DEFAULT '',
                PRIMARY KEY (trigger_name)
            )";

                
            require_once(ABSPATH."wp-admin/includes/upgrade.php");
            maybe_create_table($tellephant_tb_name,$db_query);
            
            

        }
    }
}
