<?php

/**
 * @package tellephant
 */

defined('ABSPATH') or die('You can\'t access the file!');

/**
 * Trigger this file when:
 * 1.order gets processing,completed,cancelled,shipped and refunded
 */
if( !class_exists('Tellephant_woocommerce_hooks')){
    class Tellephant_woocommerce_hooks{
        public function tellephant_wc_order_processing($orderId){
           $data = new WC_Order($orderId);
           $orderData = json_decode($data);
           $items = $data->get_items();
           $product_names = '';

           try{
                $itemLength = count($items);
               $itemCount = 1;
                foreach ( $items as $item ) {
                    if($itemCount == 1){
                        $product_names = $product_names . $item->get_name();
                    }else if($itemCount == 2 && $itemLength == 2){
                        $product_names = $product_names .' and '. $item->get_name();
                    }else if($itemCount == 3 || $itemLength > 3){
                        if(($itemCount == 2) || ($itemCount < $itemLength)){
                            $product_names = $product_names .', '. $item->get_name();
                        }else{
                            $product_names = $product_names .' and '. $item->get_name();
                        }
                    }
                $product_id = $item->get_product_id();
                $product_variation_id = $item->get_variation_id();
                $itemCount = $itemCount + 1;
                }

                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
                $specialHookData = [
                    "product_names" => $product_names,
                    "image" => $image[0]
                ];
                //Phone number validations
                $countryData = $this->tellephant_getCountryCode($orderData->billing->country);
                $phone = (int) filter_var($orderData->billing->phone, FILTER_SANITIZE_NUMBER_INT);
                if(!$this->tellephant_startsWith($phone,$countryData['code'])){
                    if(isset($countryData['code'])){
                        $phone = $countryData['code'] . $phone;
                    }
                }else{
                    if(isset($countryData['code']) && $countryData['name'] == 'INDIA'){
                        if(strlen($phone) == 10){
                            $phone = '91'. $phone;

                        }
                    }
                }

                //Get the DB data of ORDER_PROCESSING
                global $wpdb;
                $table_name = $wpdb->prefix. 'tellephant_triggers';
                $db_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE trigger_name = %s",'ORDER_PROCESSING'));
                if(count($db_results) && $db_results[0]->trigger_status == 'ENABLE'){
                //Make parameters
                $messageRequest =  $this->getHSMComponent($db_results[0],$orderData,$specialHookData,$phone);
                $this->triggerHSM($messageRequest,'ORDER_PROCESSING');

                  
                
                }
            }catch (\Exception $ex) {
                esc_html_e($ex->getMessage(),'text_domain');
            }
        

        }
        public function tellephant_wc_order_completed($orderId){
            try{
                $data = new WC_Order($orderId);
                $orderData = json_decode($data);

                $items = $data->get_items();
                $product_names = '';
                //Special Hook Data
                $itemLength = count($items);
               $itemCount = 1;
                foreach ( $items as $item ) {
                    if($itemCount == 1){
                        $product_names = $product_names . $item->get_name();
                    }else if($itemCount == 2 && $itemLength == 2){
                        $product_names = $product_names .' and '. $item->get_name();
                    }else if($itemCount == 3 || $itemLength > 3){
                        if(($itemCount == 2) || ($itemCount < $itemLength)){
                            $product_names = $product_names .', '. $item->get_name();
                        }else{
                            $product_names = $product_names .' and '. $item->get_name();
                        }
                    }
                $product_id = $item->get_product_id();
                $product_variation_id = $item->get_variation_id();
                $itemCount = $itemCount + 1;
                }
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

                $specialHookData = [
                    "product_names" => $product_names,
                    "image" => $image[0]

                ];

                //Phone number validations
                $countryData = $this->tellephant_getCountryCode($orderData->billing->country);
                $phone = (int) filter_var($orderData->billing->phone, FILTER_SANITIZE_NUMBER_INT);
                if(!$this->tellephant_startsWith($phone,$countryData['code'])){
                    if(isset($countryData['code'])){
                        $phone = $countryData['code'] . $phone;
                    }
                    
                }else{
                    if(isset($countryData['code']) && $countryData['name'] == 'INDIA'){
                        if(strlen($phone) == 10){
                            $phone = '91'. $phone;

                        }
                    }
                }


                //Get the DB data of ORDER_COMPLETED
                global $wpdb;
                $table_name = $wpdb->prefix. 'tellephant_triggers';
                $db_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE trigger_name = %s",'ORDER_COMPLETED'));
                if(count($db_results) && $db_results[0]->trigger_status == 'ENABLE'){
                    //Make parameters
                    //Send the HSM
                    $messageRequest =  $this->getHSMComponent($db_results[0],$orderData,$specialHookData,$phone);
                    $this->triggerHSM($messageRequest,'ORDER_COMPLETED');
                }
            }catch (\Exception $ex) {
                esc_html_e($ex->getMessage(),'text_domain');
            }
            
            
        }
        public function tellephant_wc_order_cancelled($orderId){
            try{
                $data = new WC_Order($orderId);
                $orderData = json_decode($data);
    
                $items = $data->get_items();
                $product_names = '';
                //Special Hook Data
                $itemLength = count($items);
                $itemCount = 1;
                 foreach ( $items as $item ) {
                     if($itemCount == 1){
                        $product_names = $product_names . $item->get_name();
                    }else if($itemCount == 2 && $itemLength == 2){
                    $product_names = $product_names .' and '. $item->get_name();
                    }else if($itemCount == 3 || $itemLength > 3){
                    if(($itemCount == 2) || ($itemCount < $itemLength)){
                            $product_names = $product_names .', '. $item->get_name();
                    }else{
                            $product_names = $product_names .' and '. $item->get_name();
                    }
                    }
                 $product_id = $item->get_product_id();
                 $product_variation_id = $item->get_variation_id();
                 $itemCount = $itemCount + 1;
                 }
                 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

                $specialHookData = [
                    "product_names" => $product_names,
                    "image" => $image[0]

                ];
    
                //Phone number validations
                $countryData = $this->tellephant_getCountryCode($orderData->billing->country);
                $phone = (int) filter_var($orderData->billing->phone, FILTER_SANITIZE_NUMBER_INT);
                if(!$this->tellephant_startsWith($phone,$countryData['code'])){
                    if(isset($countryData['code'])){
                        $phone = $countryData['code'] . $phone;
                    }
                }else{
                    if(isset($countryData['code']) && $countryData['name'] == 'INDIA'){
                        if(strlen($phone) == 10){
                            $phone = '91'. $phone;

                        }
                    }
                }
    
    
                //Get the DB data of ORDER_CANCELLED
                global $wpdb;
                $table_name = $wpdb->prefix. 'tellephant_triggers';
                $db_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE trigger_name = %s",'ORDER_CANCELLED'));
                if(count($db_results) && $db_results[0]->trigger_status == 'ENABLE'){
                    //Make parameters
                    //Send the HSM
                    $messageRequest =  $this->getHSMComponent($db_results[0],$orderData,$specialHookData,$phone);
                    $this->triggerHSM($messageRequest,'ORDER_CANCELLED');
                }
            }catch (\Exception $ex) {
                esc_html_e($ex->getMessage(),'text_domain');
            }



        }
        public function tellephant_wc_order_shipped($orderId){
            try{
                $data = new WC_Order($orderId);
                $orderData = json_decode($data);
    
                $items = $data->get_items();
                $product_names = '';
                //Special Hook Data
                $itemLength = count($items);
               $itemCount = 1;
                foreach ( $items as $item ) {
                    if($itemCount == 1){
                        $product_names = $product_names . $item->get_name();
                    }else if($itemCount == 2 && $itemLength == 2){
                        $product_names = $product_names .' and '. $item->get_name();
                    }else if($itemCount == 3 || $itemLength > 3){
                        if(($itemCount == 2) || ($itemCount < $itemLength)){
                            $product_names = $product_names .', '. $item->get_name();
                        }else{
                            $product_names = $product_names .' and '. $item->get_name();
                        }
                    }
                $product_id = $item->get_product_id();
                $product_variation_id = $item->get_variation_id();
                $itemCount = $itemCount + 1;
                }
    
                $specialHookData = [
                    "product_names" => $product_names,
                    "image" => $image[0]

                ];

                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
    
                //Phone number validations
                $countryData = $this->tellephant_getCountryCode($orderData->billing->country);
                $phone = (int) filter_var($orderData->billing->phone, FILTER_SANITIZE_NUMBER_INT);
                if(!$this->tellephant_startsWith($phone,$countryData['code'])){
                    if(isset($countryData['code'])){
                        $phone = $countryData['code'] . $phone;
                    }
                }else{
                    if(isset($countryData['code']) && $countryData['name'] == 'INDIA'){
                        if(strlen($phone) == 10){
                            $phone = '91'. $phone;

                        }
                    }
                }
    
    
                //Get the DB data of ORDER_SHIPPED
                global $wpdb;
                $table_name = $wpdb->prefix. 'tellephant_triggers';
                $db_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE trigger_name = %s",'ORDER_SHIPPED'));
    
                if(count($db_results) && $db_results[0]->trigger_status == 'ENABLE'){
                    //Make parameters
                    //Send the HSM
                    $messageRequest =  $this->getHSMComponent($db_results[0],$orderData,$specialHookData,$phone);
                    $this->triggerHSM($messageRequest,'ORDER_SHIPPED');
                }
            }catch (\Exception $ex) {
                esc_html_e($ex->getMessage(),'text_domain');
            }



        }
        public function tellephant_wc_order_refunded($orderId,$refundId){
            try{
                $data = new WC_Order($orderId);
                $orderData = json_decode($data);
    
                $items = $data->get_items();
                $product_names = '';
                //Special Hook Data
                $itemLength = count($items);
               $itemCount = 1;
                foreach ( $items as $item ) {
                    if($itemCount == 1){
                        $product_names = $product_names . $item->get_name();
                    }else if($itemCount == 2 && $itemLength == 2){
                        $product_names = $product_names .' and '. $item->get_name();
                    }else if($itemCount == 3 || $itemLength > 3){
                        if(($itemCount == 2) || ($itemCount < $itemLength)){
                            $product_names = $product_names .', '. $item->get_name();
                        }else{
                            $product_names = $product_names .' and '. $item->get_name();
                        }
                    }
                $product_id = $item->get_product_id();
                $product_variation_id = $item->get_variation_id();
                $itemCount = $itemCount + 1;
                }
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );

                $specialHookData = [
                    "product_names" => $product_names,
                    "image" => $image[0]

                ];
    
                //Phone number validations
                $countryData = $this->tellephant_getCountryCode($orderData->billing->country);
                $phone = (int) filter_var($orderData->billing->phone, FILTER_SANITIZE_NUMBER_INT);
                if(!$this->tellephant_startsWith($phone,$countryData['code'])){
                    if(isset($countryData['code'])){
                        $phone = $countryData['code'] . $phone;
                    }
                }else{
                    if(isset($countryData['code']) && $countryData['name'] == 'INDIA'){
                        if(strlen($phone) == 10){
                            $phone = '91'. $phone;

                        }
                    }
                }
    
    
                //Get the DB data of ORDER_SHIPPED
                global $wpdb;
                $table_name = $wpdb->prefix. 'tellephant_triggers';
                $db_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE trigger_name = %s",'ORDER_REFUNDED'));
                if(count($db_results) && $db_results[0]->trigger_status == 'ENABLE'){
                    //Make parameters
                    //Send the HSM
                    $messageRequest =  $this->getHSMComponent($db_results[0],$orderData,$specialHookData,$phone);
                    $this->triggerHSM($messageRequest,'ORDER_REFUNDED');
                }
            }catch (\Exception $ex) {
                esc_html_e($ex->getMessage(),'text_domain');
            }

        }

        public function tellephant_getCountryCode($countryCode){
            //Countries List
            $countryArray = array(
                'AD'=>array('name'=>'ANDORRA','code'=>'376'),
                'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
                'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
                'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
                'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
                'AL'=>array('name'=>'ALBANIA','code'=>'355'),
                'AM'=>array('name'=>'ARMENIA','code'=>'374'),
                'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
                'AO'=>array('name'=>'ANGOLA','code'=>'244'),
                'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
                'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
                'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
                'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
                'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
                'AW'=>array('name'=>'ARUBA','code'=>'297'),
                'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
                'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
                'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
                'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
                'BE'=>array('name'=>'BELGIUM','code'=>'32'),
                'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
                'BG'=>array('name'=>'BULGARIA','code'=>'359'),
                'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
                'BI'=>array('name'=>'BURUNDI','code'=>'257'),
                'BJ'=>array('name'=>'BENIN','code'=>'229'),
                'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
                'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
                'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
                'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
                'BR'=>array('name'=>'BRAZIL','code'=>'55'),
                'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
                'BT'=>array('name'=>'BHUTAN','code'=>'975'),
                'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
                'BY'=>array('name'=>'BELARUS','code'=>'375'),
                'BZ'=>array('name'=>'BELIZE','code'=>'501'),
                'CA'=>array('name'=>'CANADA','code'=>'1'),
                'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
                'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
                'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
                'CG'=>array('name'=>'CONGO','code'=>'242'),
                'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
                'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
                'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
                'CL'=>array('name'=>'CHILE','code'=>'56'),
                'CM'=>array('name'=>'CAMEROON','code'=>'237'),
                'CN'=>array('name'=>'CHINA','code'=>'86'),
                'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
                'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
                'CU'=>array('name'=>'CUBA','code'=>'53'),
                'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
                'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
                'CY'=>array('name'=>'CYPRUS','code'=>'357'),
                'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
                'DE'=>array('name'=>'GERMANY','code'=>'49'),
                'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
                'DK'=>array('name'=>'DENMARK','code'=>'45'),
                'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
                'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
                'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
                'EC'=>array('name'=>'ECUADOR','code'=>'593'),
                'EE'=>array('name'=>'ESTONIA','code'=>'372'),
                'EG'=>array('name'=>'EGYPT','code'=>'20'),
                'ER'=>array('name'=>'ERITREA','code'=>'291'),
                'ES'=>array('name'=>'SPAIN','code'=>'34'),
                'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
                'FI'=>array('name'=>'FINLAND','code'=>'358'),
                'FJ'=>array('name'=>'FIJI','code'=>'679'),
                'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
                'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
                'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
                'FR'=>array('name'=>'FRANCE','code'=>'33'),
                'GA'=>array('name'=>'GABON','code'=>'241'),
                'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
                'GD'=>array('name'=>'GRENADA','code'=>'1473'),
                'GE'=>array('name'=>'GEORGIA','code'=>'995'),
                'GH'=>array('name'=>'GHANA','code'=>'233'),
                'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
                'GL'=>array('name'=>'GREENLAND','code'=>'299'),
                'GM'=>array('name'=>'GAMBIA','code'=>'220'),
                'GN'=>array('name'=>'GUINEA','code'=>'224'),
                'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
                'GR'=>array('name'=>'GREECE','code'=>'30'),
                'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
                'GU'=>array('name'=>'GUAM','code'=>'1671'),
                'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
                'GY'=>array('name'=>'GUYANA','code'=>'592'),
                'HK'=>array('name'=>'HONG KONG','code'=>'852'),
                'HN'=>array('name'=>'HONDURAS','code'=>'504'),
                'HR'=>array('name'=>'CROATIA','code'=>'385'),
                'HT'=>array('name'=>'HAITI','code'=>'509'),
                'HU'=>array('name'=>'HUNGARY','code'=>'36'),
                'ID'=>array('name'=>'INDONESIA','code'=>'62'),
                'IE'=>array('name'=>'IRELAND','code'=>'353'),
                'IL'=>array('name'=>'ISRAEL','code'=>'972'),
                'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
                'IN'=>array('name'=>'INDIA','code'=>'91'),
                'IQ'=>array('name'=>'IRAQ','code'=>'964'),
                'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
                'IS'=>array('name'=>'ICELAND','code'=>'354'),
                'IT'=>array('name'=>'ITALY','code'=>'39'),
                'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
                'JO'=>array('name'=>'JORDAN','code'=>'962'),
                'JP'=>array('name'=>'JAPAN','code'=>'81'),
                'KE'=>array('name'=>'KENYA','code'=>'254'),
                'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
                'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
                'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
                'KM'=>array('name'=>'COMOROS','code'=>'269'),
                'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
                'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
                'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
                'KW'=>array('name'=>'KUWAIT','code'=>'965'),
                'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
                'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
                'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
                'LB'=>array('name'=>'LEBANON','code'=>'961'),
                'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
                'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
                'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
                'LR'=>array('name'=>'LIBERIA','code'=>'231'),
                'LS'=>array('name'=>'LESOTHO','code'=>'266'),
                'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
                'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
                'LV'=>array('name'=>'LATVIA','code'=>'371'),
                'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
                'MA'=>array('name'=>'MOROCCO','code'=>'212'),
                'MC'=>array('name'=>'MONACO','code'=>'377'),
                'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
                'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
                'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
                'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
                'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
                'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
                'ML'=>array('name'=>'MALI','code'=>'223'),
                'MM'=>array('name'=>'MYANMAR','code'=>'95'),
                'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
                'MO'=>array('name'=>'MACAU','code'=>'853'),
                'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
                'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
                'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
                'MT'=>array('name'=>'MALTA','code'=>'356'),
                'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
                'MV'=>array('name'=>'MALDIVES','code'=>'960'),
                'MW'=>array('name'=>'MALAWI','code'=>'265'),
                'MX'=>array('name'=>'MEXICO','code'=>'52'),
                'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
                'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
                'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
                'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
                'NE'=>array('name'=>'NIGER','code'=>'227'),
                'NG'=>array('name'=>'NIGERIA','code'=>'234'),
                'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
                'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
                'NO'=>array('name'=>'NORWAY','code'=>'47'),
                'NP'=>array('name'=>'NEPAL','code'=>'977'),
                'NR'=>array('name'=>'NAURU','code'=>'674'),
                'NU'=>array('name'=>'NIUE','code'=>'683'),
                'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
                'OM'=>array('name'=>'OMAN','code'=>'968'),
                'PA'=>array('name'=>'PANAMA','code'=>'507'),
                'PE'=>array('name'=>'PERU','code'=>'51'),
                'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
                'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
                'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
                'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
                'PL'=>array('name'=>'POLAND','code'=>'48'),
                'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
                'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
                'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
                'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
                'PW'=>array('name'=>'PALAU','code'=>'680'),
                'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
                'QA'=>array('name'=>'QATAR','code'=>'974'),
                'RO'=>array('name'=>'ROMANIA','code'=>'40'),
                'RS'=>array('name'=>'SERBIA','code'=>'381'),
                'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
                'RW'=>array('name'=>'RWANDA','code'=>'250'),
                'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
                'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
                'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
                'SD'=>array('name'=>'SUDAN','code'=>'249'),
                'SE'=>array('name'=>'SWEDEN','code'=>'46'),
                'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
                'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
                'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
                'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
                'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
                'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
                'SN'=>array('name'=>'SENEGAL','code'=>'221'),
                'SO'=>array('name'=>'SOMALIA','code'=>'252'),
                'SR'=>array('name'=>'SURINAME','code'=>'597'),
                'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
                'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
                'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
                'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
                'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
                'TD'=>array('name'=>'CHAD','code'=>'235'),
                'TG'=>array('name'=>'TOGO','code'=>'228'),
                'TH'=>array('name'=>'THAILAND','code'=>'66'),
                'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
                'TK'=>array('name'=>'TOKELAU','code'=>'690'),
                'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
                'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
                'TN'=>array('name'=>'TUNISIA','code'=>'216'),
                'TO'=>array('name'=>'TONGA','code'=>'676'),
                'TR'=>array('name'=>'TURKEY','code'=>'90'),
                'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
                'TV'=>array('name'=>'TUVALU','code'=>'688'),
                'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
                'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
                'UA'=>array('name'=>'UKRAINE','code'=>'380'),
                'UG'=>array('name'=>'UGANDA','code'=>'256'),
                'US'=>array('name'=>'UNITED STATES','code'=>'1'),
                'UY'=>array('name'=>'URUGUAY','code'=>'598'),
                'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
                'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
                'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
                'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
                'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
                'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
                'VN'=>array('name'=>'VIET NAM','code'=>'84'),
                'VU'=>array('name'=>'VANUATU','code'=>'678'),
                'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
                'WS'=>array('name'=>'SAMOA','code'=>'685'),
                'XK'=>array('name'=>'KOSOVO','code'=>'381'),
                'YE'=>array('name'=>'YEMEN','code'=>'967'),
                'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
                'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
                'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
                'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
            );

            if(array_key_exists($countryCode,$countryArray)){
                return $countryArray[$countryCode];
            }
            else{
                return [];
            }
            
        }
        
        public function tellephant_startsWith ($string, $startString)
        {
            $len = strlen($startString);
            return (substr($string, 0, $len) === $startString);
        }

        protected function getHSMComponent($db_results,$orderData,$specialHookData,$phone){
            $settings = get_option('tellephant_settings');
            if(isset($settings['api_key'])){

                $data = [
                    'url_variable' => '',
                    'attachment_variable' => '',
                ];

                $data['variables'] = [];
                            
                $sizeOfParam = intval($db_results->variable_count);
                $woocommerce_variables = preg_split ("/\,/", $db_results->woocommerce_variables); 

                if(isset($db_results->variable_count)){
                    for($i=0;$i<$sizeOfParam;$i++){
                        $separatorData = explode("->",$woocommerce_variables[$i]);
                        $text = NULL;
                        if(count($separatorData) == 2){
                            $text = $orderData->{$separatorData[0]}->{$separatorData[1]};
                        }else{
                            if($woocommerce_variables[$i] == 'product_name'){
                                $text = $specialHookData['product_names'];
                            }else if($woocommerce_variables[$i] == 'shipping_total'){
                                $text = $orderData->{$woocommerce_variables[$i]} . ' ' .$orderData->currency ;
                            }else if($woocommerce_variables[$i] == 'total'){
                                $text = $orderData->{$woocommerce_variables[$i]} . ' ' .$orderData->currency;
                            }else if($woocommerce_variables[$i] == 'address'){
                                $address = '';
                                if(isset($orderData->billing->address_1)){
                                    $address = $orderData->billing->address_1;
                                }
                                if(isset($orderData->billing->address_2)){
                                    $address = $address . ', ' . $orderData->billing->address_2;
                                }
                                $text = $address;

                            }
                            else{
                                $text = $orderData->{$woocommerce_variables[$i]};
                            }
                            
                        }
            
                        array_push($data['variables'],$text);
                    }
                }

                if($db_results->template_type == 'IMAGE'){
                    $data['media_url'] = $specialHookData['image'];
                    // $data['destination_url'] =  'https://porterandyork.com/wp-content/uploads/Salmon-Filet-2-scaled.jpg';
                }


                $messageRequest = [
                    'apikey' => $settings['api_key'],
                    'to' => $phone,
                    'channels' => ['whatsapp'],
                    'whatsapp' => [
                        'contentType' => 'template',
                        'template' => [
                            'templateId' => $db_results->template_id,
                            'language' => $db_results->language_code,
                            'components' => [],
                        ],
                    ],
                    'media_url' => $data['media_url'] ?? null,
                ];
                if (!empty($data['destination_url'])) {
                    $messageRequest['destination_url'] = $data['destination_url'];
                }
                $componentArray = [];
                if (!empty($data['url_variable']) || !empty($data['destination_url'])) {
                    $parameterButton[] = [
                        'type' => 'text',
                        'text' => $data['url_variable'] ?? null,
                    ];
                }
                switch ($db_results->template_type) {
                    //ONLY TEXT
                    case 'TEXT':
                        $parameters = [];
        
                        if ($db_results->variable_count != 0) {
                            foreach ($data['variables'] as $index => $text) {
                                $parameters[$index] = [
                                    'type' => 'text',
                                    'text' => $text,
                                ];
                            }
                            if (empty($data['url_variable']) && empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'body',
                                        'parameters' => $parameters,
                                    ],
                                ];
                            } elseif (!empty($data['url_variable']) || !empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'body',
                                        'parameters' => $parameters,
                                    ],
                                    [
                                        'type' => 'button',
                                        'subType' => 'url',
                                        'parameters' => $parameterButton,
                                    ],
                                ];
                            }
                        } else {
                            if (empty($data['url_variable']) && empty($data['destination_url'])) {
                                $componentArray = [];
                            } elseif (!empty($data['url_variable']) || !empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'button',
                                        'subType' => 'url',
                                        'parameters' => $parameterButton,
                                    ],
                                ];
                            }
                        }
        
                        break;
        
                    //MEDIA FORMATS
                    case 'IMAGE':
                        $parameters = [];
                        $mediaArray = [
                            'type' => strtolower($db_results->template_type),
                            // 'url' => env('AWS_URL').'/'.$data['media_url'],
                            'url' => $data['media_url'],
        
                        ];
                        if ($db_results->template_type == 'DOCUMENT') {
                            $mediaArray['filename'] = $data['custom_filename'] ?? '';
                        }
                        $parametersImageDoc[] = [
                            'type' => 'media',
                            'media' => $mediaArray,
                        ];
        
                        if ($db_results->variable_count != 0) {
                            foreach ($data['variables'] as $index => $text) {
                                $parameters[$index] = [
                                    'type' => 'text',
                                    'text' => $text,
                                ];
                            }
                            if (empty($data['url_variable']) && empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'header',
                                        'parameters' => $parametersImageDoc,
                                    ],
                                    [
                                        'type' => 'body',
                                        'parameters' => $parameters,
                                    ],
                                ];
                            } elseif (!empty($data['url_variable']) || !empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'header',
                                        'parameters' => $parametersImageDoc,
                                    ],
                                    [
                                        'type' => 'body',
                                        'parameters' => $parameters,
                                    ],
                                    [
                                        'type' => 'button',
                                        'subType' => 'url',
                                        'parameters' => $parameterButton,
                                    ],
                                ];
                            }
                        } else {
                            if (empty($data['url_variable']) && empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'header',
                                        'parameters' => $parametersImageDoc,
                                    ],
                                ];
                            } elseif (!empty($data['url_variable']) || !empty($data['destination_url'])) {
                                $componentArray = [
                                    [
                                        'type' => 'header',
                                        'parameters' => $parametersImageDoc,
                                    ],
                                    [
                                        'type' => 'button',
                                        'subType' => 'url',
                                        'parameters' => $parameterButton,
                                    ],
                                ];
                            }
                        }
        
                        break;
        
        
                }
                $messageRequest['whatsapp']['template']['components'] = $componentArray;
                return $messageRequest;
            }
        }

        protected function triggerHSM($tellephant_data,$triggerName){
                
            global $wpdb;
            $table_name = $wpdb->prefix. 'tellephant_triggers';
            $settings = get_option('tellephant_settings');
            if(isset($settings['api_key'])){
                $response = wp_remote_post('https://app.tellephant.com/api/v2/messaging/send-message-queue',array(
                    'body' => $tellephant_data,

                ));
                    
                $messageResult = json_decode($response['body']);
                $message = '';
                if(isset($messageResult->messageId)){
                    $message = $messageResult->messageId;
                }else{
                    $message = $messageResult->error;
                }


                $res =  $wpdb->query($wpdb->prepare("UPDATE $table_name
                SET last_messages_status = %s
                WHERE trigger_name = %s
                ",$message,$triggerName));
            }else{
                $res =  $wpdb->query($wpdb->prepare("UPDATE $table_name
                SET last_messages_status = %s
                WHERE trigger_name = %s
                ",'Please save your API key',$triggerName));
            }
        }


    }
}