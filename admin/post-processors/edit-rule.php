<?php
    require_once plugin_dir_path( __FILE__ ).'../../utils/data-utils.php';
    
    global $wpdb;

    $criteria          = filter_var($_POST['criteria'], FILTER_SANITIZE_STRING);
    $source_ids        = $criteria === 'products' ? filter_var($_POST['products'], FILTER_SANITIZE_NUMBER_INT) 
                                                  : filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);
    $auto_add_product  = compress_array($_POST['auto_add_product']);
    $start_date        = filter_var($_POST['start_date'], FILTER_SANITIZE_STRING);
    $end_date          = filter_var($_POST['end_date'], FILTER_SANITIZE_STRING);
    $rule_id           = filter_var($_POST['rule_id'], FILTER_SANITIZE_NUMBER_INT);
    $quantity          = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
    $coupon_code       = filter_var($_POST['coupon_code'], FILTER_SANITIZE_STRING);

    //Build the update query arguments
    $args = array(
        'target_ids'    =>  $auto_add_product,
        'type'          =>  $criteria,
        'source_ids'    =>  $source_ids,
        'start_date'    =>  $start_date,
        'end_date'      =>  $end_date,
        'coupon_code'   =>  $coupon_code,
		'quantity'      =>  $quantity,
         
    );

    $query =    $wpdb->update(
        AATC_TABLE_NAME,
        $args,
        array( 'id'     => $rule_id  ) 
    );

    $wpdb->flush();


    if(false == $query) {
        echo  "
                    <div id=\"setting-error-settings_updated\" class=\"error settings-error notice is-dismissible\"> 
                        <p><strong>Rule update not successful.</strong></p>
                        <button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button>
                    </div>
              ";            
    }
    else{
        echo  "
                <div id=\"setting-error-settings_updated\" class=\"updated settings-error notice is-dismissible\"> 
                    <p><strong>Rule was successfully updated</strong></p>
                    <button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button>
                </div>
              ";
    }

