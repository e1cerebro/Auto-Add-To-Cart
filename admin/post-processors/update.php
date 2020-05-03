<?php 

    if($_POST['update_status']) { 
        
        global $wpdb;

        $query =    $wpdb->update(
                        AATC_TABLE_NAME,
                        array('status'  => $_POST['status']),
                        array( 'id'     => $_POST['product_id']  ) 
                    );

        $wpdb->flush();
      
         if(false == $query) {
            echo  "
                        <div id='setting-error-settings_updated' class='error settings-error notice is-dismissible'> 
                            <p><strong>Status Could not be updated</strong></p>
                            <button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button>
                        </div>
                  ";            
        }
        else{
            echo  "
                    <div id='setting-error-settings_updated' class='updated settings-error notice is-dismissible'> 
                        <p><strong>status was successfully updated</strong></p>
                        <button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button>
                    </div>
                  ";
        }

    }