<?php

/**
 * @package tellephant
 */

defined('ABSPATH') or die('You can\'t access the file!');


if( !function_exists('tellephant_activation')){
    function tellephant_activation() {
        //check if tellephant_settings option not found
        if( !get_option('tellephant_settings') ){
            add_option('tellephant_settings',array(
                'tellephant_label' => 'Tellephant',
                'api_key' => '',
                'tellephant_user_details' => '',
            ));
        }
    }
}