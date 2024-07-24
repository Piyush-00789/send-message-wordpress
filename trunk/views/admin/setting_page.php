<?php

/**
 * @package tellephant
 */

defined('ABSPATH') or die('You can\'t access the file!');

function tellephant_setting_page_callback(){
   ?>

<div id="wpbody" role="main">
    <div id="wpbody-content">
        <div class="wrap">
           <div class="tellephant_header">
              <img src=<?php _e( esc_html(plugin_dir_url( dirname( __FILE__ ) ) . 'images/tellephant_logo.png')); ?> id="tellephantImage" alt="Tellephant" />
              <span class="tellephant_logout">
                    <form method="post" action="admin-post.php" novalidate="novalidate">
                        <input type="hidden" name="action" value="tellephant_logout_settings"/>
                        <?php
                            wp_nonce_field("tellephant_logout_settings_verify");
                            $logoutData = get_option("tellephant_settings");
                        ?>  
                    </form> 
                <span>  
            </div>
                <div class="tellephant_login">
                    <i>
                        <br/>
                    <?php
                        if(isset($_GET['success'])){
                            $success = urldecode (sanitize_text_field($_GET['success']));
                            _e('<span class="success">'.
                            esc_html($success).
                            '</span>');
                        }
                        if(isset($_GET['error'])){
                            $error = urldecode (sanitize_text_field($_GET['error']));
                            _e('<span class="error">'.
                            esc_html($error).
                             '</span>');

                        }
                    ?>
                    </i>
                    <br/>
                    <?php
                        
                            $settings = get_option('tellephant_settings');
                            if(isset($settings['tellephant_user_details']['email'])){
                               $email =  sanitize_text_field($settings['tellephant_user_details']['email']);
                                _e( '<strong>Welcome! ' . esc_html($email).'</strong>');
                            }
                        
                    ?>

                            <form method="post" action="admin-post.php" novalidate="novalidate">
                                <input type="hidden" name="action" value="tellephant_save_settings_field"/>
                                <?php wp_nonce_field('tellephant_save_settings_field_verify'); 
                                    $settings = get_option('tellephant_settings')
                                ?>  
                                <div id="login_form" class="templateCard" 
                                    style=
                                    <?php
                                        if(!isset($settings['api_key']) || $settings['api_key'] == '')
                                        {
                                            _e('display:block');
                                        }else{
                                            _e('display:none');
                                        }                 
                                    ?> 
                                >
                                    <?php
                                        if(!isset($settings['api_key']) || $settings['api_key'] == '')
                                        {
                                                                
                                    ?>  
                                                    <label style="font-size:14px;font-weight: bold;" for="api_key"><?php _e('Tellephant API Key','tellephant')  ?></label>
                                                    <input id="api_key" name="api_key" value="" type="text" style="width:500px" required/>
                                        
                                    <?php
                                        }
                                    ?>
                                            <?php
                                            if( !isset($settings['api_key']) || $settings['api_key'] == null){
                                                _e( '
                                                
                                                <input type="submit" id="tellephant_login_button"  value="Log in"/>
                                                ');
                                                
                                                _e('<p>
                                                <a href="#" style="color:#686868 !important;" onclick="openInNewTab(`signUp`)">Not a user?
                                                <u>Sign up</u></a>
                                                </p>');
                                            }
                                            ?>
                                </div>
                            </form>
                                    
            
                </div>


            <div class="tellephant_sidebar" style="<?php 
            if(isset($logoutData['api_key']) && $logoutData['api_key'] != '') 
            {
                _e('display:block');
            } 
            else
            { 
                _e( 'display:none' );
                
            }?>">
                <a href="#WhatsApp_logs" onclick="openInNewTab('WhatsApp_logs')">📝 WhatsApp Logs</a>
                <a href="#register" onclick="openInNewTab('register')">📌 Register a template</a>
                <a href="#guide" onclick="openInNewTab('guide')"> 📖 Plugin Guide</a>
                <a href="#help" onclick="openInNewTab('help')">ℹ️ Help?</a>
            </div>
            <div class="tellephant_main">

                <?php
                    if(isset($settings['api_key']) && $settings['api_key'] != '')
                    {
                                            
                ?>  
                    <form id="triggers-form" method="post" action="admin-post.php" novalidate="novalidate">                   
                        <div class="templates">
                        
                                <input type="hidden" name="action" value="tellephant_triggers_form"/>
                                <?php wp_nonce_field('tellephant_triggers_form_verify'); 
                                    $settings = get_option('tellephant_settings')
                                ?>
                            

                            <div>
                                <div class="chooseTriggersCard">
                                    <p>Choose the scenarios for messages to be triggered</p>
                                    <div class="triggersOption">    
                                        <input type="checkbox" id="tellephant_order_processing" value="tellephant_order_processing" onchange="getTriggerScenarios(this.value)"/>           
                                        <span><label for="tellephant_order_processing">Order Processing</label></span><br/>
                                    </div>
                                    <div class="triggersOption">
                                        <input type="checkbox" id="tellephant_order_completed" value="tellephant_order_completed" onchange="getTriggerScenarios(this.value)"/>           
                                        <label for="tellephant_order_completed">Order Completed</label><br/>
                                    </div>
                                    <div class="triggersOption">
                                        <input type="checkbox" id="tellephant_order_cancelled" value="tellephant_order_cancelled" onchange="getTriggerScenarios(this.value)"/>           
                                        <label for="tellephant_order_cancelled">Order Cancelled</label><br/>
                                    </div>
                                    <div class="triggersOption">
                                        <input type="checkbox" id="tellephant_order_shipped" value="tellephant_order_shipped" onchange="getTriggerScenarios(this.value)"/>           
                                        <label for="tellephant_order_shipped">Order Shipped (Note : Slug name should be shipped)</label><br/>
                                    </div>
                                    <div class="triggersOption">
                                        <input type="checkbox" id="tellephant_order_refunded" value="tellephant_order_refunded" onchange="getTriggerScenarios(this.value)"/>           
                                        <label for="tellephant_order_refunded">Order Refunded</label><br/>
                                    </div>
                                        <?php 
                                            global $wpdb;
                                            $table_name = $wpdb->prefix. 'tellephant_triggers';
                                            $db_results = $wpdb->get_results("SELECT * FROM $table_name");
                                            $triggerArray = [];
                                            if(count($db_results)){
                                                _e( '<table class="savedTriggers savedTiggers__table">');
                                                _e( '<tr>');
                                                _e( '<th>');
                                                _e( 'Trigger Name');
                                                _e('</th>');
                                                _e( '<th>');
                                                _e( 'Template Name');
                                                _e( '</th>');
                                                _e( '<th>');
                                                _e( 'Enable/Disable');
                                                _e( '</th>');
                                                _e( '</tr>');
                                    
                                                foreach($db_results as $result){
                                                    _e ('<tr>');
                                                    array_push($triggerArray,$result->trigger_name);
                                                    _e('<td>' . esc_html(str_replace("_"," ",$result->trigger_name)) . '</td>');
                                                    _e( '<td>' . esc_html($result->template_id) . '</td>');
                                                    if($result->trigger_status == 'ENABLE'){
                                                        _e( '<td> <button type="button" data-status="DISABLE" value='.esc_html($result->trigger_name).' class="triggerStatus">DISABLE</button></td>');
                                                    }else{
                                                        _e( '<td> <button type="button" data-status="ENABLE" value='.esc_html($result->trigger_name).' class="triggerStatus">ENABLE</button></td>');
                                                    }
                                                   
    
                                                    _e( '</tr>');
                                                }
                                        
                                                _e ('</table>');
                                            }

                                            ?>
                                </div>
         

                            </div>


                            <div id="orderProcessingTemplate" class="templateCard" style="display:none;">
                                <span>
                                    <input type="label" name="order_processing" value="ORDER_PROCESSING" style="display:none;"/>
                                </span>
                                <?php 
                                        if(isset($settings['api_key'])){
                                            _e( '<h2>Order Processing</h2>');
                                            _e( '<p>Select your template</p>');                 
                                            $templatesData = [];
                                            $response = wp_remote_post('https://app.tellephant.com/api/v2/user/hsm-templates',array(
                                              'body' => ["apikey" => $settings['api_key']],

                                            ));

                                        $templatesData = json_decode($response['body']);
                                       
                                        $option = '<option value="" Selected disabled>Select your template</option>';    
                                        if($templatesData || count($templatesData->hsmTemplates) > 0){
                                                _e( '<select name="OrderProcessing_Template" onChange="getSelectedTemplateChange(OrderProcessing_Template)" id="OrderProcessing_Template">');
                                                foreach($templatesData->hsmTemplates as $hsmTemplate){
                                                    if(($hsmTemplate->template_format == "TEXT" && $hsmTemplate->button_variable_count != 1) || ($hsmTemplate->template_format == 'IMAGE' && $hsmTemplate->button_variable_count != 1)){
                                                        $option = $option . '<option value='.esc_html($hsmTemplate->template_id. '-' .$hsmTemplate->language_code.'%'.$hsmTemplate->variable_count.'|'.$hsmTemplate->template_format). ' data-variable-count='.esc_html($hsmTemplate->variable_count). ' data-template-type='.esc_html($hsmTemplate->template_format) .'>' . esc_html($hsmTemplate->template_id) . ' - ' . esc_html($hsmTemplate->language_code).'</option>';
                                                    }
                                                }
                                                
                                                _e($option .'</select>');
                                            }
                                            
                                        }
                                



                                    ?>

                                    <div id="OrderProcessing_TemplateAddVariables">
                                    </div>
                                    
                            </div>
                            <div id="orderCompletedTemplate" class="templateCard" style="display:none;">
                                <input type="label" name="order_completed" value="ORDER_COMPLETED" style="display:none;"/>
                                    <?php 
                                    
                                    if(isset($settings['api_key'])){
                                        _e( '<h2>Order Completed</h2>');
                                        _e( '<p>Select your template</p>');
                                        _e( '<select name="OrderCompleted_Template" onChange="getSelectedTemplateChange(OrderCompleted_Template)" id="OrderCompleted_Template">');
                                        _e($option);
                                        _e('</select>');
                                    }


                                    ?>

                                    <div id="OrderCompleted_TemplateAddVariables">
                                    </div>
                                    
                            </div>
                            <div id="orderCancelledTemplate" class="templateCard" style="display:none;">
                                <input type="label" name="order_cancelled" value="ORDER_CANCELLED" style="display:none;"/>
                                    <?php 
                                    
                                    if(isset($settings['api_key'])){
                                        _e( '<h2>Order Cancelled</h2>');
                                        _e( '<p>Select your template</p>');
                                        _e( '<select name="OrderCancelled_Template" onChange="getSelectedTemplateChange(OrderCancelled_Template)" id="OrderCancelled_Template">');
                                        _e($option);
                                        _e( '</select>');
                                    }


                                    ?>

                                    <div id="OrderCancelled_TemplateAddVariables">
                                    </div>
                                    
                            </div>         
                            <div id="orderShippedTemplate" class="templateCard" style="display:none;">
                                <input type="label" name="order_shipped" value="ORDER_SHIPPED" style="display:none;"/>
                                    <?php 
                                    
                                    if(isset($settings['api_key'])){
                                        _e( '<h2>Order Shipped</h2>');
                                        _e( '<p>Select your template</p>');
                                        _e( '<select name="OrderShipped_Template" onChange="getSelectedTemplateChange(OrderShipped_Template)" id="OrderShipped_Template">');
                                        _e($option);
                                        _e( '</select>');
                                    }


                                    ?>

                                    <div id="OrderShipped_TemplateAddVariables">
                                    </div>
                                    
                            </div>
                            <div id="orderRefundedTemplate" class="templateCard" style="display:none;">
                                <input type="label" name="order_refunded" value="ORDER_REFUNDED" style="display:none;"/>
                                    <?php 
                                    
                                    if(isset($settings['api_key'])){
                                        _e( '<h2>Order Refunded</h2>');
                                        _e( '<p>Select your template</p>');
                                        _e( '<select name="OrderRefunded_Template" onChange="getSelectedTemplateChange(OrderRefunded_Template)" id="OrderRefunded_Template">');
                                        _e($option);
                                        _e( '</select>');
                                    }


                                    ?>

                                    <div id="OrderRefunded_TemplateAddVariables">
                                    </div>
                                    
                            </div>       
                        </div>
                        <input type="submit" id="saveTriggers"  value="Save your scenarios" style="margin-top:3rem;display:none;"/>
                
                    </form>
                <?php
                    }
                ?>                         
        
            </div>   
   
            <div class="clear">

            </div>

        </div><!-- wpbody-content -->
        <div class="clear">

        </div>
    </div>
</div>
<script>

jQuery(document).ready(function($) {

jQuery('.triggerStatus').click(function(){
    event.preventDefault();
    let link = "<?php _e( admin_url('admin-ajax.php')) ?>";
    let triggerName = jQuery(this).attr("value");
    let status = jQuery(this).attr("data-status");

    jQuery.ajax({
        url: link,
        type : 'post', 
        data: {
            'action':'trigger_status_changed',
            'triggerName' : triggerName,
            'status' : status
        },
        success:function(data) {
            /* This outputs the result of the ajax request */
            window.location.reload();
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });  
})
})
</script>

   <?php
   
}
?>