function getSelectedTemplateChange(value){
    let templateSelected = jQuery('#'+value.id).find('option:selected');
    let templateValue = templateSelected.val();
    let variable_count = parseInt(templateSelected.data('variable-count'));
    let varSelect = '';  
    jQuery('#addvariables').html('');
     for (let i = 0; i < variable_count; i++) {
        varSelect+= '<div id="var"><label>Var'+(i+1)+'</label>'+
                    '<select name="'+value.id+'var'+(i+1)+'" class="variable" id="var'+(i+1)+'">'+
                    '<option value="id">order number</option>'+
                    '<option value="order_key">order_key</option>'+
                    '<option value="status">status</option>'+
                    '<option value="currency">currency</option>'+
                    '<option value="product_name">product name</option>'+
                    '<option value="total">total amount</option>'+
                    '<option value="payment_method">payment method (cod)</option>'+
                    '<option value="payment_method_title">payment method title(Cash on Delivery)</option>'+
                    '<option value="address">address</option>'+
                    '<option value="discount_total">discount total</option>'+
                    '<option value="discount_tax">discount tax</option>'+
                    '<option value="created_via">created via (admin,checkout)</option>'+
                    '<optgroup label="Shipping">'+
                    '<option value="shipping_total">shipping total</option>'+
                    '<option value="shipping_tax">shipping tax</option>'+
                    '<option value="shipping->first_name">shipping->first_name</option>'+
                    '<option value="shipping->last_name">shipping->last_name</option>'+
                    '<option value="shipping->city">shipping->city</option>'+
                    '<option value="shipping->state">shipping->state</option>'+
                    '<option value="shipping->postcode">shipping->postcode</option>'+
                    '<option value="shipping->company">shipping->company</option>'+
                    '</optgroup>'+
                    '<optgroup label="Billing">'+
                    '<option value="billing->first_name">billing->first_name</option>'+
                    '<option value="billing->last_name">billing->last_name</option>'+
                    '<option value="billing->city">billing->city</option>'+
                    '<option value="billing->state">billing->state</option>'+
                    '<option value="billing->email">billing->email</option>'+
                    '<option value="billing->postcode">billing->postcode</option>'+
                    '<option value="billing->company">billing->company</option>'+
                    '</optgroup>'+
                    '</select></div>';
      }

      jQuery('#'+value.id+'AddVariables').html(varSelect);

}

function getTriggerScenarios(value){
  
    let showSaveButton = false;
    if(document.getElementById('tellephant_order_processing').checked){
        document.getElementById('orderProcessingTemplate').style.display = 'block';
        showSaveButton = true;
    }else{
        document.getElementById('orderProcessingTemplate').style.display = 'none';
    }
    
    if(document.getElementById('tellephant_order_completed').checked){
        document.getElementById('orderCompletedTemplate').style.display = 'block';
        showSaveButton = true;
    }else {
        document.getElementById('orderCompletedTemplate').style.display = 'none';

    }
    
    if(document.getElementById('tellephant_order_cancelled').checked){
        document.getElementById('orderCancelledTemplate').style.display = 'block';
        showSaveButton = true;
    }else{
        document.getElementById('orderCancelledTemplate').style.display = 'none';
    }

    if(document.getElementById('tellephant_order_shipped').checked){
        document.getElementById('orderShippedTemplate').style.display = 'block';
        showSaveButton = true;
    }else{
        document.getElementById('orderShippedTemplate').style.display = 'none';
    }

    if(document.getElementById('tellephant_order_refunded').checked){
        document.getElementById('orderRefundedTemplate').style.display = 'block';
        showSaveButton = true;
    }else{
        document.getElementById('orderRefundedTemplate').style.display = 'none';
    }

    if(showSaveButton) {
        document.getElementById('saveTriggers').style.display = 'block';
    }else{
        document.getElementById('saveTriggers').style.display = 'none';
    }
}

function openInNewTab(value){
    if(value == 'WhatsApp_logs'){
        window.open('https://app.tellephant.com/user/logs', '_blank').focus();
    }else if(value == 'register'){
        window.open('https://app.tellephant.com/user/whatsapp/template-messages', '_blank').focus();
    }else if(value == 'help'){
        window.open('https://www.tellephant.com/contact-us', '_blank').focus();
    }else if (value == 'signUp'){
        window.open('https://app.tellephant.com/register',"_blank").focus();
    }else if(value == 'guide'){
        window.open('https://www.tellephant.com/post/how-to-integrate-whatsapp-with-woocommerce','_blank').focus();
    }
}



