<?php
    require_once plugin_dir_path( __FILE__ ).'../../utils/data-utils.php';
    
    global $wpdb;

    $criteria          = filter_var($_POST['criteria'], FILTER_SANITIZE_STRING);
    $source_ids        = $criteria === 'products' ? filter_var($_POST['products'], FILTER_SANITIZE_NUMBER_INT) 
                                                  : filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);
    $auto_add_product  = compress_array($_POST['auto_add_product']);
    $start_date        = filter_var($_POST['start_date'], FILTER_SANITIZE_STRING);
    $end_date          = filter_var($_POST['end_date'], FILTER_SANITIZE_STRING);


    //Build the insert query arguments
    $args = array(
        'target_ids'    =>  $auto_add_product,
        'type'          =>  $criteria,
        'source_ids'    =>  $source_ids,
        'date_start'    =>  $start_date,
        'date_end'      =>  $end_date,
        'status'        =>  'active',
         
    );

    //Insert the new data
    $query = $wpdb->insert(AATC_TABLE_NAME, $args);

    $wpdb->flush();


    if(false == $query) {
        echo  "
                    <div id=\"setting-error-settings_updated\" class=\"error settings-error notice is-dismissible\"> 
                        <p><strong>Database Insertion failed.</strong></p>
                        <button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button>
                    </div>
              ";            
    }
    else{
        echo  "
                <div id=\"setting-error-settings_updated\" class=\"updated settings-error notice is-dismissible\"> 
                    <p><strong>Data saved.</strong></p>
                    <button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button>
                </div>
              ";
    }

