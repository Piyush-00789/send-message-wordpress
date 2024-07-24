<?php
/**
 * @package tellephant
 */


if(!class_exists('Tellephant_save_triggers')){
    class Tellephant_save_triggers {
        public function tellephant_save_triggers_form(){

            try{
            check_admin_referer('tellephant_triggers_form_verify');
            if(!current_user_can( 'manage_options' )){
                wp_die('You are not allowed to edit the settings.');
            }


           /**
             * 
             * ORDER_PROCESSING
            */
            $error = true;
            if(isset($_POST['OrderProcessing_Template'])){
                $templateStructure = sanitize_text_field($_POST['OrderProcessing_Template']);
                $templateStatus =  $this->tellephant_get_template_structure($templateStructure,'ORDER_PROCESSING');
                if(count($templateStatus)){
                //Saving in DB
                    $data = [
                        'trigger' => 'ORDER_PROCESSING',
                        'trigger_status' => 'ENABLE',
                        'template_id' => $templateStatus['template_id'],
                        'language_code' => $templateStatus['language_code'],
                        'variable_count' => $templateStatus['variable_count'],
                        'template_type' => $templateStatus['template_type'],
                        'woocommerce_variables' => $templateStatus['woocommerce_variables'],
                        // 'cta_enabled' => $templateStatus['cta_enabled'],
                        'last_messages_status' => ''
                    ];
    
                    $this->tellephant_save_a_trigger($data);
                }
                $error = false;
            }
            /**
             * 
             * ORDER_COMPLETED
            */
            if(isset($_POST['OrderCompleted_Template'])){

                $templateStructure = sanitize_text_field($_POST['OrderCompleted_Template']);
                $templateStatus =  $this->tellephant_get_template_structure($templateStructure,'ORDER_COMPLETED');

                if(count($templateStatus)){
                //Saving in DB
                    $data = [
                        'trigger' => 'ORDER_COMPLETED',
                        'trigger_status' => 'ENABLE',
                        'template_id' => $templateStatus['template_id'],
                        'language_code' => $templateStatus['language_code'],
                        'variable_count' => $templateStatus['variable_count'],
                        'template_type' => $templateStatus['template_type'],
                        // 'cta_enabled' => $templateStatus['cta_enabled'],
                        'woocommerce_variables' => $templateStatus['woocommerce_variables'],
                        'last_messages_status' => ''
                    ];
    
                    $this->tellephant_save_a_trigger($data);
                }

                $error = false;
                
            }
            /**
             * 
             * ORDER_CANCELLED
            */
            
            if(isset($_POST['OrderCancelled_Template'])){
                $templateStructure = sanitize_text_field($_POST['OrderCancelled_Template']);
                $templateStatus =  $this->tellephant_get_template_structure($templateStructure,'ORDER_CANCELLED');

                if(count($templateStatus)){
                //Saving in DB
                    $data = [
                        'trigger' => 'ORDER_CANCELLED',
                        'trigger_status' => 'ENABLE',
                        'template_id' => $templateStatus['template_id'],
                        'language_code' => $templateStatus['language_code'],
                        'variable_count' => $templateStatus['variable_count'],
                        'template_type' => $templateStatus['template_type'],
                        // 'cta_enabled' => $templateStatus['cta_enabled'],
                        'woocommerce_variables' => $templateStatus['woocommerce_variables'],
                        'last_messages_status' => ''
                    ];
    
                    $this->tellephant_save_a_trigger($data);
                }
                $error = false;
            }

            /**
             * 
             * ORDER_SHIPPED
             */
            if(isset($_POST['OrderShipped_Template'])){
                $templateStructure = sanitize_text_field($_POST['OrderShipped_Template']);
                $templateStatus =  $this->tellephant_get_template_structure($templateStructure,'ORDER_SHIPPED');

                if(count($templateStatus)){
                //Saving in DB
                    $data = [
                        'trigger' => 'ORDER_SHIPPED',
                        'trigger_status' => 'ENABLE',
                        'template_id' => $templateStatus['template_id'],
                        'language_code' => $templateStatus['language_code'],
                        'variable_count' => $templateStatus['variable_count'],
                        // 'cta_enabled' => $templateStatus['cta_enabled'],
                        'template_type' => $templateStatus['template_type'],
                        'woocommerce_variables' => $templateStatus['woocommerce_variables'],
                        'last_messages_status' => ''
                    ];
    
                    $this->tellephant_save_a_trigger($data);
                }
                $error = false;
            }

            /**
             * 
             * ORDER_REFUNDED
             */
            if(isset($_POST['OrderRefunded_Template'])){
                $templateStructure = sanitize_text_field($_POST['OrderRefunded_Template']);
                $templateStatus =  $this->tellephant_get_template_structure($templateStructure,'ORDER_REFUNDED');

                if(count($templateStatus)){
                //Saving in DB
                    $data = [
                        'trigger' => 'ORDER_REFUNDED',
                        'trigger_status' => 'ENABLE',
                        'template_id' => $templateStatus['template_id'],
                        'language_code' => $templateStatus['language_code'],
                        'variable_count' => $templateStatus['variable_count'],
                        'template_type' => $templateStatus['template_type'],
                        // 'cta_enabled' => $templateStatus['cta_enabled'],
                        'woocommerce_variables' => $templateStatus['woocommerce_variables'],
                        'last_messages_status' => ''
                    ];
    
                    $this->tellephant_save_a_trigger($data);
                }
                $error = false;
            }
    
            $errorMsg = '';
            if($error){
                wp_redirect(get_admin_url().'admin.php?page=tellephant_settings&error='.urlencode('Please select a trigger'));
                exit();
            }
            wp_redirect(get_admin_url().'admin.php?page=tellephant_settings&success='.urlencode('Triggers saved'));
            
            }catch (\Exception $ex) {
                wp_redirect(get_admin_url().'admin.php?page=tellephant_settings&success='.urlencode('Please contact developer@aiyolabs.com'));
                exit();
            }
            

        }


        public function tellephant_save_a_trigger($data){
            global $wpdb;

                $tellephant_tb_name = $wpdb->prefix .'tellephant_triggers';
                $wpdb->replace($tellephant_tb_name,array(
                    'trigger_name' => $data['trigger'],
                    'trigger_status' => $data['trigger_status'],
                    'template_id' => $data['template_id'],
                    'language_code' =>  $data['language_code'],
                    'variable_count' => $data['variable_count'],
                    'template_type' => $data['template_type'],
                    // 'cta_enabled' => $data['cta_enabled'],
                    'woocommerce_variables' => $data['woocommerce_variables'],
                    'last_messages_status' => $data['last_messages_status']
                ),array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                ));
            
        }

        public function tellephant_get_template_structure($templateStructure,$checker){

            $variableName = '';
            if($checker == 'ORDER_PROCESSING'){
                $variableName='OrderProcessing_Template';
            }
            else if($checker == 'ORDER_COMPLETED'){
                $variableName='OrderCompleted_Template';
            }
            else if($checker == 'ORDER_CANCELLED'){
                $variableName='OrderCancelled_Template';
            }
            else if($checker == 'ORDER_SHIPPED'){
                $variableName='OrderShipped_Template';
            }else if($checker == 'ORDER_REFUNDED'){
                $variableName='OrderRefunded_Template';
            }
            $template_id = explode("-",$templateStructure);
            $variable_count = explode("%",$templateStructure);
            $template_id = $template_id[0];
            $temp_count = intval($variable_count[1]);
            $language_code = explode("-",$variable_count[0]);
            $language_code = $language_code[1];
            $template_format = explode("|",$templateStructure);
            // $templateType = explode("@",$template_format[1]);
            $template_type = $template_format[1];
            // $templateButtonVariable = explode("@",$templateStructure);
            // $templateButtonStatus = intval($templateButtonVariable[0]);
            $variablesArray = [];
            $variablesString = '';
            for($i = 1 ; $i <= $temp_count; $i++){
                $vars = sanitize_text_field($_POST[$variableName.'var'.strval($i)]);
                array_push($variablesArray,$vars);
                if($temp_count == $i){
                    $vars1 = sanitize_text_field($_POST[$variableName.'var'.strval($i)]);
                    $variablesString = $variablesString . $vars1 ;

                }else{
                    $vars2 = sanitize_text_field($_POST[$variableName.'var'.strval($i)]) . ',';
                    $variablesString = $variablesString . $vars2;
                }
            }

            return [
                "template_id" => $template_id,
                "language_code" => $language_code,
                "variable_count" => $temp_count,
                "woocommerce_variables" => $variablesString,
                "template_type" => $template_type,
                // "cta_enabled" => $templateButtonStatus

            ];
        }

        public function tellephant_save_triggers_status(){
            if(!current_user_can( 'manage_options' )){
                wp_die('You are not allowed to edit the settings.');
            }

            global $wpdb;
            $table_name  = $wpdb->prefix."tellephant_triggers";
            if(isset($_POST['triggerName']) && isset($_POST['status']) ){
                $status = sanitize_text_field($_POST['status']); 
                if($status == 'ENABLE' || $status == 'DISABLE'){
                    $triggerName = sanitize_text_field($_POST['triggerName']);
                    $wpdb->query( $wpdb->prepare("UPDATE $table_name 
                    SET trigger_status = %s 
                    WHERE trigger_name = %s",$status, $triggerName));
                }
 
            
            }
        

            wp_send_json_success('success');
            
        }

    }
}

