<?php
/**
 * @package tellephant
 */


if(!class_exists('Tellephant_save_settings')){
    class Tellephant_save_settings {
        public function tellephant_save_admin_settings(){
            check_admin_referer('tellephant_save_settings_field_verify');

            if(!current_user_can( 'manage_options' )){
                wp_die('You are not allowed to edit the settings.');
            }

            $tellephant_api = sanitize_text_field($_POST['api_key']);

            $api_details = array(
                "apikey" => $tellephant_api,
                "token_type" => "tellephant"

            );


            /**
             * Tellephant Validate API
             */

            $response = wp_remote_post('https://app.tellephant.com/api/v2/user/validate',array(
                'body' => $api_details,

              ));

            $isUserAuthorised = json_decode($response['body']);
                        

            //Validations
            if(!isset($tellephant_api) || empty($tellephant_api)){
                wp_redirect(get_admin_url().'admin.php?page=tellephant_settings&error='.urlencode('Please provide the API key'));
                exit();
            }
            else if(!$isUserAuthorised->success){
                wp_redirect(get_admin_url().'admin.php?page=tellephant_settings&error='.urlencode($isUserAuthorised->error));
                exit();
            }


            /**
             * Saving it in DB
             */
            $values  = array(
                'tellephant_label' => 'Tellephant',
               'api_key' => $tellephant_api,
               'tellephant_user_details' => array(
                   "email" => $isUserAuthorised->data->email,
                   "name" => $isUserAuthorised->data->name
               )
            );
            update_option('tellephant_settings',$values);

            wp_redirect(get_admin_url().'admin.php?page=tellephant_settings&success='.urlencode('API key saved'));
            exit();

        }
    }
}

